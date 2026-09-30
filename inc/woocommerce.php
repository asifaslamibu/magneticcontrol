<?php
/**
 * WooCommerce integration: wrappers, catalog filters, product spec fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Attribute taxonomies used by the catalog filter sidebar.
 * Keys are the query-string parameter names.
 */
function mc_filter_groups() {
	return array(
		'voltage' => array( 'taxonomy' => 'pa_voltage-range', 'label' => __( 'Voltage Range', 'magneticcontrol' ) ),
		'cooling' => array( 'taxonomy' => 'pa_cooling-type', 'label' => __( 'Cooling Type', 'magneticcontrol' ) ),
		'brand'   => array( 'taxonomy' => 'pa_brand', 'label' => __( 'Brand', 'magneticcontrol' ) ),
	);
}

/**
 * Sanitised list of slugs from a query-string array parameter.
 */
function mc_filter_values( $key ) {
	if ( empty( $_GET[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return array();
	}
	$values = (array) wp_unslash( $_GET[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	return array_values( array_filter( array_map( 'sanitize_title', $values ) ) );
}

/**
 * Categories currently selected: the ?cat[] filter, or the category being viewed.
 */
function mc_selected_categories() {
	$cats = mc_filter_values( 'cat' );
	if ( ! $cats && is_product_category() ) {
		$cats = array( get_queried_object()->slug );
	}
	return $cats;
}

/* Layout wrappers ---------------------------------------------------------- */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', function () {
	echo '<div class="mc-container mc-content mc-wc">';
}, 10 );
add_action( 'woocommerce_after_main_content', function () {
	echo '</div>';
}, 10 );

// The custom archive template renders its own breadcrumb in the hero.
add_action( 'wp', function () {
	if ( is_shop() || is_product_taxonomy() ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	}
} );

add_filter( 'woocommerce_enqueue_styles', function ( $styles ) {
	unset( $styles['woocommerce-layout'], $styles['woocommerce-smallscreen'] );
	return $styles;
} );

/* Catalog query ------------------------------------------------------------ */

add_filter( 'loop_shop_per_page', function () {
	return 9;
} );

add_filter( 'loop_shop_columns', function () {
	return 3;
} );

add_action( 'woocommerce_product_query', function ( $q ) {
	$tax_query = (array) $q->get( 'tax_query' );

	$cats = mc_filter_values( 'cat' );
	if ( $cats ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $cats,
		);
	}

	foreach ( mc_filter_groups() as $key => $group ) {
		$values = mc_filter_values( $key );
		if ( $values && taxonomy_exists( $group['taxonomy'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $group['taxonomy'],
				'field'    => 'slug',
				'terms'    => $values,
			);
		}
	}

	$q->set( 'tax_query', $tax_query );
} );

add_filter( 'woocommerce_catalog_orderby', function () {
	return array(
		'date'       => __( 'Sort by: Newest First', 'magneticcontrol' ),
		'menu_order' => __( 'Sort by: Default', 'magneticcontrol' ),
		'popularity' => __( 'Sort by: Popularity', 'magneticcontrol' ),
		'price'      => __( 'Sort by: Price Low to High', 'magneticcontrol' ),
		'price-desc' => __( 'Sort by: Price High to Low', 'magneticcontrol' ),
	);
} );

/**
 * Number of published products in a term, restricted to the selected categories.
 */
function mc_term_count( $taxonomy, $term_id, $categories = array() ) {
	$tax_query = array(
		array( 'taxonomy' => $taxonomy, 'field' => 'term_id', 'terms' => $term_id ),
		array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => array( 'exclude-from-catalog' ), 'operator' => 'NOT IN' ),
	);
	if ( $categories ) {
		$tax_query[] = array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $categories );
	}

	$q = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'posts_per_page' => 1,
		'no_found_rows'  => false,
		'tax_query'      => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	) );

	return (int) $q->found_posts;
}

/* Product spec fields ------------------------------------------------------ */

/**
 * Card specs: subtitle plus up to three key spec lines.
 */
function mc_product_specs( $product_id ) {
	$specs = array();
	foreach ( array( 1, 2, 3 ) as $n ) {
		$value = get_post_meta( $product_id, '_mc_spec_' . $n, true );
		if ( '' !== $value ) {
			$specs[] = $value;
		}
	}
	return $specs;
}

add_action( 'woocommerce_product_options_general_product_data', function () {
	echo '<div class="options_group">';
	woocommerce_wp_text_input( array(
		'id'          => '_mc_subtitle',
		'label'       => __( 'Card subtitle', 'magneticcontrol' ),
		'placeholder' => __( 'e.g. Oil Cooled', 'magneticcontrol' ),
		'desc_tip'    => true,
		'description' => __( 'Short line shown under the product name on catalog cards.', 'magneticcontrol' ),
	) );
	$placeholders = array( 1 => '500 kVA – 2500 kVA', 2 => '11kV / 33kV', 3 => 'IEC 60076' );
	foreach ( $placeholders as $n => $placeholder ) {
		woocommerce_wp_text_input( array(
			'id'          => '_mc_spec_' . $n,
			/* translators: %d: spec line number */
			'label'       => sprintf( __( 'Key spec %d', 'magneticcontrol' ), $n ),
			'placeholder' => $placeholder,
		) );
	}
	echo '</div>';
} );

add_action( 'woocommerce_admin_process_product_object', function ( $product ) {
	foreach ( array( '_mc_subtitle', '_mc_spec_1', '_mc_spec_2', '_mc_spec_3' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- WooCommerce verifies the nonce.
			$product->update_meta_data( $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}
	}
} );

/* Single product page ------------------------------------------------------ */

// The single product template renders its own breadcrumb and related products.
add_action( 'wp', function () {
	if ( is_product() ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	}
} );

add_action( 'wp_enqueue_scripts', function () {
	if ( is_product() ) {
		wp_enqueue_style( 'mc-product', MC_URI . '/assets/css/product.css', array( 'mc-shop' ), filemtime( MC_DIR . '/assets/css/product.css' ) );
	}
} );

/**
 * Non-empty, trimmed lines of a multi-line product meta field.
 */
function mc_meta_lines( $product_id, $key ) {
	$raw = (string) get_post_meta( $product_id, $key, true );
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) ) ) );
}

/**
 * Split "Label | Value" lines into pairs.
 */
function mc_meta_pairs( $product_id, $key ) {
	$pairs = array();
	foreach ( mc_meta_lines( $product_id, $key ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( 2 === count( $parts ) && '' !== $parts[0] && '' !== $parts[1] ) {
			$pairs[] = $parts;
		}
	}
	return $pairs;
}

/**
 * Overview checklist: the "Key highlights" field, or the "-item" lines of the description.
 */
function mc_product_highlights( $product ) {
	$items = mc_meta_lines( $product->get_id(), '_mc_highlights' );
	if ( ! $items ) {
		$text = wp_strip_all_tags( $product->get_description() );
		preg_match_all( '/^\s*[-–•]\s*(.+)$/mu', $text, $m );
		$items = array_map( 'trim', $m[1] );
	}
	return array_slice( $items, 0, 6 );
}

/**
 * Technical specs as label/value pairs: the spec field, or visible attributes + card specs.
 */
function mc_product_tech_specs( $product ) {
	$specs = mc_meta_pairs( $product->get_id(), '_mc_tech_specs' );
	if ( $specs ) {
		return $specs;
	}

	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->get_visible() ) {
			continue;
		}
		$values = $attribute->is_taxonomy()
			? wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) )
			: $attribute->get_options();
		if ( $values ) {
			$specs[] = array( wc_attribute_label( $attribute->get_name(), $product ), implode( ', ', $values ) );
		}
	}

	$labels = array( __( 'Rating', 'magneticcontrol' ), __( 'Construction', 'magneticcontrol' ), __( 'Standards', 'magneticcontrol' ) );
	foreach ( array( 1, 2, 3 ) as $n ) {
		$value = get_post_meta( $product->get_id(), '_mc_spec_' . $n, true );
		if ( '' !== $value ) {
			$specs[] = array( $labels[ $n - 1 ], $value );
		}
	}

	return $specs;
}

/**
 * Icon name for a spec label, matched by keyword.
 */
function mc_spec_icon( $label ) {
	$map = array(
		'primary'    => 'plug',
		'secondary'  => 'activity',
		'voltage'    => 'plug',
		'power'      => 'zap',
		'rating'     => 'zap',
		'kva'        => 'zap',
		'frequency'  => 'radio',
		'cooling'    => 'snowflake',
		'insulation' => 'shield-check',
		'class'      => 'shield-check',
		'standard'   => 'file-text',
		'material'   => 'box',
		'tank'       => 'box',
		'enclosure'  => 'box',
		'brand'      => 'award',
	);
	$label = strtolower( $label );
	foreach ( $map as $needle => $icon ) {
		if ( false !== strpos( $label, $needle ) ) {
			return $icon;
		}
	}
	return 'settings';
}

add_action( 'woocommerce_product_options_general_product_data', function () {
	echo '<div class="options_group">';
	$fields = array(
		'_mc_highlights'   => array(
			__( 'Key highlights', 'magneticcontrol' ),
			__( 'One per line. Shown as the checklist in the Overview tab. Leave empty to use the "-item" lines of the description.', 'magneticcontrol' ),
			"Oil-immersed design for superior cooling\nLow no-load and load losses",
		),
		'_mc_tech_specs'   => array(
			__( 'Technical specifications', 'magneticcontrol' ),
			__( 'One per line as "Label | Value". Leave empty to use the product attributes and key specs.', 'magneticcontrol' ),
			"Rated Power | 50 – 2500 kVA\nPrimary Voltage | 11 kV / 33 kV",
		),
		'_mc_applications' => array(
			__( 'Applications', 'magneticcontrol' ),
			__( 'One per line. Shown in the Applications tab.', 'magneticcontrol' ),
			"Utility distribution networks\nIndustrial plants",
		),
		'_mc_downloads'    => array(
			__( 'Downloads', 'magneticcontrol' ),
			__( 'One per line as "Label | File URL" (e.g. datasheets from the Media Library).', 'magneticcontrol' ),
			'Product Datasheet | https://…/datasheet.pdf',
		),
	);
	foreach ( $fields as $id => $field ) {
		woocommerce_wp_textarea_input( array(
			'id'          => $id,
			'label'       => $field[0],
			'description' => $field[1],
			'desc_tip'    => true,
			'placeholder' => $field[2],
			'rows'        => 4,
		) );
	}
	echo '</div>';
} );

add_action( 'woocommerce_admin_process_product_object', function ( $product ) {
	foreach ( array( '_mc_highlights', '_mc_tech_specs', '_mc_applications', '_mc_downloads' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- WooCommerce verifies the nonce.
			$product->update_meta_data( $key, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}
	}
} );

// The old "Products" page is an empty builder page; send visitors to the catalogue.
add_action( 'template_redirect', function () {
	if ( is_page( 'products' ) && ! is_shop() ) {
		wp_safe_redirect( mc_shop_url(), 301 );
		exit;
	}
} );
