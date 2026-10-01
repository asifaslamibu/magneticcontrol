<?php
/**
 * Front-end performance: load only the assets a page needs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Emoji detection script + styles (modern browsers render emoji natively).
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'emoji_svg_url', '__return_false' );

/**
 * Whether the current page shows WooCommerce UI (catalogue, product, cart, checkout, account).
 */
function mc_is_wc_page() {
	if ( ! function_exists( 'is_woocommerce' ) ) {
		return false;
	}
	return is_woocommerce() || is_cart() || is_checkout() || is_account_page();
}

// On content pages (home, about, contact, blog…) WooCommerce's CSS/JS only adds weight:
// the theme styles its own header cart, and there are no add-to-cart buttons.
add_action( 'wp_enqueue_scripts', function () {
	if ( mc_is_wc_page() ) {
		return;
	}
	foreach ( array( 'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen', 'wc-blocks-style' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
	foreach ( array( 'woocommerce', 'wc-add-to-cart', 'wc-jquery-blockui', 'jquery-blockui', 'wc-js-cookie', 'js-cookie', 'wc-cart-fragments' ) as $handle ) {
		wp_dequeue_script( $handle );
	}
}, 99 );

// Nothing on content pages uses jQuery once WooCommerce's scripts are gone.
add_action( 'wp_enqueue_scripts', function () {
	if ( mc_is_wc_page() || is_admin_bar_showing() ) {
		return;
	}
	global $wp_scripts;
	$needs_jquery = false;
	foreach ( $wp_scripts->queue as $handle ) {
		$dep = $wp_scripts->query( $handle );
		if ( $dep && array_intersect( array( 'jquery', 'jquery-core' ), (array) $dep->deps ) ) {
			$needs_jquery = true;
			break;
		}
	}
	if ( ! $needs_jquery ) {
		wp_dequeue_script( 'jquery' );
	}
}, 100 );

// Start fetching the homepage's first hero image (the largest thing on screen) straight away.
add_action( 'wp_head', function () {
	if ( is_front_page() ) {
		printf( '<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n", mc_img( 'hero-1.webp' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- mc_img() escapes.
	}
}, 2 );

/* WebP copies of uploads ----------------------------------------------------
 * Every JPEG/PNG in the media library gets a sibling "<file>.webp" (e.g. photo-600x400.png.webp).
 * .htaccess serves it instead of the original to browsers that accept WebP. The library
 * itself (files, sizes, metadata) is never changed, so turning this off is just deleting
 * the .webp files.
 */

/**
 * Write "<path>.webp" next to a JPEG/PNG when that makes it smaller. Returns true if one exists.
 */
function mc_make_webp_sibling( $path ) {
	if ( ! function_exists( 'imagewebp' ) || ! preg_match( '/\.(jpe?g|png)$/i', $path ) || ! is_readable( $path ) ) {
		return false;
	}
	$target = $path . '.webp';
	if ( file_exists( $target ) && filemtime( $target ) >= filemtime( $path ) ) {
		return true;
	}
	$is_png = (bool) preg_match( '/\.png$/i', $path );
	$img    = $is_png ? @imagecreatefrompng( $path ) : @imagecreatefromjpeg( $path ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- corrupt files just get skipped.
	if ( ! $img ) {
		return false;
	}
	if ( ! imageistruecolor( $img ) ) {
		imagepalettetotruecolor( $img ); // imagewebp() fatals on palette images.
	}
	if ( $is_png ) {
		imagealphablending( $img, false );
		imagesavealpha( $img, true );
	}
	$ok = imagewebp( $img, $target, 80 );
	imagedestroy( $img );
	if ( $ok && filesize( $target ) >= filesize( $path ) ) {
		wp_delete_file( $target ); // Not worth it.
		return false;
	}
	return $ok;
}


/**
 * Absolute paths of an attachment's main file and all its generated sizes.
 */
function mc_attachment_paths( $attachment_id, $meta = null ) {
	$file = get_attached_file( $attachment_id );
	if ( ! $file ) {
		return array();
	}
	$meta  = is_array( $meta ) ? $meta : wp_get_attachment_metadata( $attachment_id );
	$paths = array( $file );
	foreach ( (array) ( $meta['sizes'] ?? array() ) as $size ) {
		$paths[] = path_join( dirname( $file ), $size['file'] );
	}
	return $paths;
}

// New uploads (and regenerated thumbnails) get their WebP copies straight away.
add_filter( 'wp_generate_attachment_metadata', function ( $meta, $attachment_id ) {
	foreach ( mc_attachment_paths( $attachment_id, $meta ) as $path ) {
		mc_make_webp_sibling( $path );
	}
	return $meta;
}, 20, 2 );

// Deleting a media item removes its WebP copies too.
add_action( 'delete_attachment', function ( $attachment_id ) {
	foreach ( mc_attachment_paths( $attachment_id ) as $path ) {
		if ( file_exists( $path . '.webp' ) ) {
			wp_delete_file( $path . '.webp' );
		}
	}
} );

/* Page cache ------------------------------------------------------------------
 * Hosts like Hostinger serve pages from LiteSpeed Cache for days. After the theme is
 * uploaded, updated or switched, clear that cache so visitors see the new version.
 */
function mc_purge_page_cache() {
	do_action( 'litespeed_purge_all' ); // LiteSpeed Cache plugin (no-op if not installed).
}
add_action( 'after_switch_theme', 'mc_purge_page_cache' );
add_action( 'upgrader_process_complete', function ( $upgrader, $options ) {
	if ( isset( $options['type'] ) && 'theme' === $options['type'] ) {
		mc_purge_page_cache();
	}
}, 10, 2 );
