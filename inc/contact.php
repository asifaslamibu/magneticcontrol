<?php
/**
 * Contact page form: posts to admin-post.php, emails the site contact address.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Saudi sales team by region: shown on the Contact page and used to route form messages.
 * Keys are what the form posts; labels and contacts are what visitors see.
 */
function mc_sales_regions() {
	return array(
		'eastern' => array( 'label' => __( 'Eastern Region', 'magneticcontrol' ), 'email' => 'rahul@magneticcontrol.com', 'phone' => '+966583919411' ),
		'central' => array( 'label' => __( 'Central Region', 'magneticcontrol' ), 'email' => 'munees@magneticcontrol.com', 'phone' => '+966565242305' ),
		'western' => array( 'label' => __( 'Western Region', 'magneticcontrol' ), 'email' => 'anas@magneticcontrol.com', 'phone' => '+966565242300' ),
	);
}

/**
 * Simple arithmetic captcha. The answer is never sent to the browser: the form carries an
 * HMAC of "answer|timestamp", so the server can check a reply without storing anything.
 *
 * @return array { question, token }
 */
function mc_captcha() {
	$a  = wp_rand( 2, 9 );
	$b  = wp_rand( 1, 9 );
	$ts = time();
	return array(
		'question' => $a . ' + ' . $b,
		'token'    => $ts . '.' . hash_hmac( 'sha256', ( $a + $b ) . '|' . $ts, wp_salt( 'nonce' ) ),
	);
}

/**
 * Whether a captcha reply is correct and the form was loaded within the last two hours.
 */
function mc_captcha_ok( $answer, $token ) {
	list( $ts, $mac ) = array_pad( explode( '.', (string) $token, 2 ), 2, '' );
	if ( ! ctype_digit( $ts ) || time() - (int) $ts > 2 * HOUR_IN_SECONDS || ! preg_match( '/^\d{1,2}$/', trim( (string) $answer ) ) ) {
		return false;
	}
	return hash_equals( hash_hmac( 'sha256', (int) trim( $answer ) . '|' . $ts, wp_salt( 'nonce' ) ), $mac );
}

/**
 * Handle a contact form submission, then redirect back with ?sent=1 or ?sent=0.
 */
function mc_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : mc_page_url( 'contact' );
	$back = remove_query_arg( 'sent', $back );

	if ( ! isset( $_POST['mc_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['mc_contact_nonce'] ) ), 'mc_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#mc-contact-form' );
		exit;
	}

	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['mc_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#mc-contact-form' );
		exit;
	}

	// Captcha (checked before the flood counter, so wrong answers don't use up the allowance).
	$captcha = isset( $_POST['mc_captcha'] ) ? sanitize_text_field( wp_unslash( $_POST['mc_captcha'] ) ) : '';
	$token   = isset( $_POST['mc_captcha_token'] ) ? sanitize_text_field( wp_unslash( $_POST['mc_captcha_token'] ) ) : '';
	if ( ! mc_captcha_ok( $captcha, $token ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'captcha', $back ) . '#mc-contact-form' );
		exit;
	}

	// Flood protection: at most 5 messages per IP per hour.
	$rate_key = 'mc_contact_' . md5( mc_client_ip() );
	$sent_count = (int) get_transient( $rate_key );
	if ( $sent_count >= 5 ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#mc-contact-form' );
		exit;
	}
	set_transient( $rate_key, $sent_count + 1, HOUR_IN_SECONDS );

	$field = function ( $key, $sanitize = 'sanitize_text_field' ) {
		return isset( $_POST[ $key ] ) ? call_user_func( $sanitize, wp_unslash( $_POST[ $key ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified above.
	};

	$name    = $field( 'mc_name' );
	$email   = $field( 'mc_email', 'sanitize_email' );
	$phone   = $field( 'mc_phone' );
	$company = $field( 'mc_company' );
	$subject = $field( 'mc_subject' );
	$message = $field( 'mc_message', 'sanitize_textarea_field' );
	$regions = mc_sales_regions();
	$region  = $field( 'mc_region', 'sanitize_key' );
	$region  = isset( $regions[ $region ] ) ? $region : ''; // Only known regions; anything else goes to sales.

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#mc-contact-form' );
		exit;
	}

	$body = implode( "\n", array_filter( array(
		'Name: ' . $name,
		'Email: ' . $email,
		$phone ? 'Phone: ' . $phone : '',
		$company ? 'Company: ' . $company : '',
		'Region: ' . ( $region ? $regions[ $region ]['label'] : __( 'General enquiry', 'magneticcontrol' ) ),
		$subject ? 'Subject: ' . $subject : '',
		'',
		$message,
	), 'strlen' ) );

	// Every enquiry goes to the sales inbox; a chosen region's sales person is copied in.
	$to      = mc_contact( 'email' );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	if ( $region ) {
		$headers[] = 'Cc: ' . $regions[ $region ]['email'];
	}

	$sent = wp_mail(
		$to,
		/* translators: 1: region, 2: subject or visitor name */
		sprintf( __( '[Website enquiry – %1$s] %2$s', 'magneticcontrol' ), $region ? $regions[ $region ]['label'] : __( 'General', 'magneticcontrol' ), $subject ? $subject : $name ),
		$body,
		$headers
	);

	wp_safe_redirect( add_query_arg( 'sent', $sent ? '1' : '0', $back ) . '#mc-contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_mc_contact', 'mc_handle_contact' );
add_action( 'admin_post_mc_contact', 'mc_handle_contact' );
