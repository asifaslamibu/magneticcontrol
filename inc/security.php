<?php
/**
 * Security hardening: fewer information leaks, security headers,
 * login brute-force protection and no user enumeration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Information leaks -------------------------------------------------------- */

// Don't advertise the WordPress version or legacy editing endpoints.
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
add_filter( 'the_generator', '__return_empty_string' );

// Strip ?ver=<wp version> from core scripts and styles (theme files keep their filemtime versions).
add_filter( 'style_loader_src', 'mc_strip_wp_version', 20 );
add_filter( 'script_loader_src', 'mc_strip_wp_version', 20 );
function mc_strip_wp_version( $src ) {
	return strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ? remove_query_arg( 'ver', $src ) : $src;
}

// XML-RPC is a common brute-force and DDoS amplification target; nothing here uses it.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );
add_filter( 'pings_open', '__return_false' );

/* User enumeration --------------------------------------------------------- */

// /?author=1 would redirect to /author/<username>/, revealing login names.
add_action( 'template_redirect', function () {
	if ( ! is_user_logged_in() && ( isset( $_GET['author'] ) || is_author() ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}, 1 ); // Before redirect_canonical(), which would reveal /author/<username>/.

// The REST users endpoint lists usernames to anyone; limit it to people who can list users.
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! current_user_can( 'list_users' ) ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );

// Don't expose usernames in sitemaps or oEmbed author data.
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );
add_filter( 'oembed_response_data', function ( $data ) {
	unset( $data['author_name'], $data['author_url'] );
	return $data;
} );

/* Login protection --------------------------------------------------------- */

// One message for wrong username and wrong password, so usernames can't be probed
// (the lockout notice is the exception, so locked-out visitors know to wait).
add_filter( 'login_errors', function () {
	global $errors; // wp-login.php runs in global scope.
	if ( is_wp_error( $errors ) && $errors->get_error_message( 'mc_locked_out' ) ) {
		return $errors->get_error_message( 'mc_locked_out' );
	}
	return __( '<strong>Error:</strong> The login details are incorrect.', 'magneticcontrol' );
} );

define( 'MC_LOGIN_MAX_FAILS', 5 );
define( 'MC_LOGIN_LOCKOUT', 15 * MINUTE_IN_SECONDS );

function mc_client_ip() {
	// REMOTE_ADDR only: forwarded headers can be forged by the attacker.
	return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
}

function mc_login_key() {
	return 'mc_login_fails_' . md5( mc_client_ip() );
}

// Count failures per IP…
add_action( 'wp_login_failed', function () {
	$fails = (int) get_transient( mc_login_key() );
	set_transient( mc_login_key(), $fails + 1, MC_LOGIN_LOCKOUT );
} );

// …and refuse further attempts from that IP until the lockout expires.
add_filter( 'authenticate', function ( $user ) {
	if ( (int) get_transient( mc_login_key() ) >= MC_LOGIN_MAX_FAILS ) {
		return new WP_Error(
			'mc_locked_out',
			/* translators: %d: minutes */
			sprintf( __( '<strong>Error:</strong> Too many failed login attempts. Please try again in %d minutes.', 'magneticcontrol' ), MC_LOGIN_LOCKOUT / MINUTE_IN_SECONDS )
		);
	}
	return $user;
}, 30 );

add_action( 'wp_login', function () {
	delete_transient( mc_login_key() );
} );

/* Security headers --------------------------------------------------------- */

add_action( 'send_headers', 'mc_security_headers' );
add_action( 'login_init', 'mc_security_headers' );
add_action( 'admin_init', 'mc_security_headers' );
function mc_security_headers() {
	if ( headers_sent() ) {
		return;
	}
	header_remove( 'X-Powered-By' );                          // Don't reveal the PHP version.
	header( 'X-Content-Type-Options: nosniff' );             // No MIME sniffing.
	header( 'X-Frame-Options: SAMEORIGIN' );                  // No clickjacking in foreign frames.
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(self)' );
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000' ); // Browsers stay on HTTPS.
	}
}
