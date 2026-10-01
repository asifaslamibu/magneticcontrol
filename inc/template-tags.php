<?php
/**
 * Template helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mc_img( $file ) {
	return esc_url( MC_URI . '/assets/images/' . $file );
}

/**
 * URL of a page by slug, falling back to home.
 */
function mc_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

function mc_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : mc_page_url( 'products' );
}

function mc_logo( $variant = 'dark' ) {
	?>
	<a class="mc-logo mc-logo--<?php echo esc_attr( $variant ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<img class="mc-logo__mark" src="<?php echo mc_img( 'logo.webp' ); ?>" alt="" width="520" height="170">
	</a>
	<?php
}

/**
 * Menu fallback used until a "Primary Menu" is assigned in Appearance → Menus.
 */
function mc_primary_menu_fallback() {
	$items = array(
		array( __( 'Home', 'magneticcontrol' ), home_url( '/' ), array() ),
		array( __( 'About Us', 'magneticcontrol' ), mc_page_url( 'about' ), array() ),
		array( __( 'Products', 'magneticcontrol' ), mc_products_url(), array(
			array( __( 'Isolation Transformers', 'magneticcontrol' ), mc_product_url( 'isolation-transformers' ) ),
			array( __( 'K-rated Transformers', 'magneticcontrol' ), mc_product_url( 'k-rated-transformers' ) ),
			array( __( 'Control Transformers', 'magneticcontrol' ), mc_product_url( 'control-transformers' ) ),
			array( __( 'Step-Down & Step-Up Auto Transformers', 'magneticcontrol' ), mc_product_url( 'step-up-and-step-down-auto-transformer' ) ),
			array( __( 'Variable Auto Transformers', 'magneticcontrol' ), mc_product_url( 'variable-auto-transformers' ) ),
			array( __( 'Harmonic Filters', 'magneticcontrol' ), mc_product_url( 'harmonic-filters' ) ),
			array( __( 'Drive Chokes', 'magneticcontrol' ), mc_product_url( 'drive-chokes' ) ),
		) ),
		array( __( 'Manufacturing', 'magneticcontrol' ), mc_page_url( 'manufacturing' ), array() ),
		array( __( 'Careers', 'magneticcontrol' ), mc_page_url( 'careers' ), array() ),
		array( __( 'Contact Us', 'magneticcontrol' ), mc_page_url( 'contact' ), array() ),
	);

	$current = mc_current_url();
	$is_shop = function_exists( 'is_woocommerce' ) && is_woocommerce();

	echo '<ul class="mc-menu">';
	foreach ( $items as $i => $item ) {
		list( $label, $url, $children ) = $item;
		$classes = array( 'menu-item' );

		$active = mc_same_url( $url, $current ) || ( 2 === $i && $is_shop ); // 2 = Products.
		foreach ( $children as $child ) {
			$active = $active || mc_same_url( $child[1], $current );
		}
		if ( $active ) {
			$classes[] = 'current-menu-item';
		}
		if ( $children ) {
			$classes[] = 'menu-item-has-children';
		}
		printf( '<li class="%s"><a href="%s">%s</a>', esc_attr( implode( ' ', $classes ) ), esc_url( $url ), esc_html( $label ) );
		if ( $children ) {
			echo '<ul class="sub-menu">';
			foreach ( $children as $child ) {
				$is_current = mc_same_url( $child[1], $current );
				printf( '<li class="menu-item%s"><a href="%s"%s>%s</a></li>', $is_current ? ' current-menu-item' : '', esc_url( $child[1] ), $is_current ? ' aria-current="page"' : '', esc_html( $child[0] ) );
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Product category archive URL, falling back to the shop.
 */
function mc_cat_url( $slug ) {
	$link = taxonomy_exists( 'product_cat' ) ? get_term_link( $slug, 'product_cat' ) : '';
	return $link && ! is_wp_error( $link ) ? $link : mc_shop_url();
}

/**
 * Single product URL by slug, falling back to the shop.
 */
function mc_product_url( $slug ) {
	$product = get_page_by_path( $slug, OBJECT, 'product' );
	return $product ? get_permalink( $product ) : mc_shop_url();
}

/**
 * Path + query of the current request (enough for mc_same_url()).
 */
function mc_current_url() {
	return isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
}

/**
 * Whether two URLs point at the same page (query args and fragments must match too).
 */
function mc_same_url( $a, $b ) {
	$norm = function ( $url ) {
		$parts = wp_parse_url( $url );
		$path  = isset( $parts['path'] ) ? trailingslashit( $parts['path'] ) : '/';
		return $path . ( isset( $parts['query'] ) ? '?' . $parts['query'] : '' ) . ( isset( $parts['fragment'] ) ? '#' . $parts['fragment'] : '' );
	};
	return $norm( $a ) === $norm( $b );
}

function mc_section_label( $text, $center = false ) {
	printf( '<span class="mc-eyebrow%s">%s</span>', $center ? ' mc-eyebrow--center' : '', esc_html( $text ) );
}

/**
 * Headline company numbers (homepage + About page): value, suffix, label.
 */
function mc_company_stats() {
	return array(
		array( 500, '+', __( 'Clients', 'magneticcontrol' ) ),
		array( 1000, '+', __( 'Products Delivered', 'magneticcontrol' ) ),
		array( 10, '+', __( 'Years Experience', 'magneticcontrol' ) ),
	);
}

/**
 * Tidy content left over from the old page builder: drop inline <style> blocks and
 * &nbsp; spacer paragraphs, and group runs of side-by-side <figure>s into a grid.
 */
function mc_clean_page_content( $html ) {
	$html = preg_replace( '#<style[^>]*>.*?</style>#s', '', $html );
	$html = preg_replace( '#<p>(?:\s|&nbsp;|\xC2\xA0)*</p>#', '', $html );
	return preg_replace( '#(?:<figure\b[^>]*>(?:(?!</figure>).)*</figure>\s*){2,}#s', '<div class="mc-media-grid">$0</div>', $html );
}

/**
 * Old page addresses that changed: send visitors (and search engines) to the new ones.
 */
add_action( 'template_redirect', function () {
	$moved = array(
		'about-2' => 'about', // Local copy used "about-2"; the live site's slug is "about".
	);
	if ( ! is_404() ) {
		return;
	}
	$path = trim( (string) wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
	$slug = basename( $path );
	if ( isset( $moved[ $slug ] ) ) {
		wp_safe_redirect( mc_page_url( $moved[ $slug ] ), 301 );
		exit;
	}
} );

/**
 * tel: link for a displayed phone number.
 */
function mc_tel( $number ) {
	return 'tel:' . preg_replace( '/[^\d+]/', '', $number );
}

/**
 * Contact page with the form set up for a call back request.
 */
function mc_callback_url() {
	return add_query_arg( 'callback', '1', mc_page_url( 'contact' ) ) . '#mc-contact-form';
}

/**
 * The Products landing page (categories); falls back to the shop catalogue.
 */
function mc_products_url() {
	$page = get_page_by_path( 'products' );
	return $page ? get_permalink( $page ) : mc_shop_url();
}

/**
 * Contact page scrolled to the form; with a product name the subject is pre-filled.
 * (?enquiry=, not ?product=: that is WooCommerce's query var.)
 */
function mc_quote_url( $product = '' ) {
	$url = mc_page_url( 'contact' );
	if ( $product ) {
		$url = add_query_arg( 'enquiry', rawurlencode( $product ), $url );
	}
	return $url . '#mc-contact-form';
}
