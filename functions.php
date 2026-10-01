<?php
/**
 * Magnetic Control theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MC_VERSION', '1.1.0' );
define( 'MC_URI', get_template_directory_uri() );
define( 'MC_DIR', get_template_directory() );

require_once MC_DIR . '/inc/icons.php';
require_once MC_DIR . '/inc/template-tags.php';
require_once MC_DIR . '/inc/security.php';
require_once MC_DIR . '/inc/perf.php';
require_once MC_DIR . '/inc/contact.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once MC_DIR . '/inc/woocommerce.php';
}

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'magneticcontrol', MC_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 260,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// WooCommerce (the single product template ships its own gallery).
	add_theme_support( 'woocommerce' );

	register_nav_menus( array(
		'primary'        => __( 'Primary Menu', 'magneticcontrol' ),
		'footer_links'   => __( 'Footer Quick Links', 'magneticcontrol' ),
		'footer_products'=> __( 'Footer Products', 'magneticcontrol' ),
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'mc-fonts',
		'https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&family=Kaushan+Script&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'mc-main', MC_URI . '/assets/css/main.css', array( 'mc-fonts' ), filemtime( MC_DIR . '/assets/css/main.css' ) );
	wp_enqueue_style( 'mc-shop', MC_URI . '/assets/css/shop.css', array( 'mc-main' ), filemtime( MC_DIR . '/assets/css/shop.css' ) );
	if ( ( is_singular() || is_home() ) && ! is_front_page() && ! ( function_exists( 'is_product' ) && is_product() ) ) {
		wp_enqueue_style( 'mc-pages', MC_URI . '/assets/css/pages.css', array( 'mc-shop' ), filemtime( MC_DIR . '/assets/css/pages.css' ) );
	}
	wp_enqueue_script( 'mc-main', MC_URI . '/assets/js/main.js', array(), filemtime( MC_DIR . '/assets/js/main.js' ), true );
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

/**
 * Site-wide contact details (single place to edit).
 */
function mc_contact( $key ) {
	$contact = array(
		'email'    => 'sales@magneticcontrol.com',
		'phone'    => '+966 505211107',
		'phone2'   => '+966 13 822 2155',
		'location' => '74th Street, Al Kharj Industrial City, KSA',
		'hours'    => 'Mon - Fri: 9:00 AM - 6:00 PM',
		'address'  => '74th Street, Al Kharj Industrial City, Al Kharj 16271<br>Kingdom of Saudi Arabia',
		// Social profile URLs (Facebook + LinkedIn): an icon only appears once its '#' is replaced with a real link.
		'linkedin' => '#',
		'facebook' => '#',
	);
	return isset( $contact[ $key ] ) ? $contact[ $key ] : '';
}
