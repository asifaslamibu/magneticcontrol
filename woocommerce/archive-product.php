<?php
/**
 * Product catalog: shop page, product categories, tags and attribute archives.
 *
 * Overrides woocommerce/templates/archive-product.php
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$mc_selected = mc_selected_categories();
$mc_term     = null;
if ( 1 === count( $mc_selected ) ) {
	$mc_term = get_term_by( 'slug', $mc_selected[0], 'product_cat' );
} elseif ( is_product_taxonomy() ) {
	$mc_term = get_queried_object();
}

if ( is_search() ) {
	/* translators: %s: search query */
	$mc_title = sprintf( __( 'Results for “%s”', 'magneticcontrol' ), get_search_query() );
} elseif ( $mc_term ) {
	$mc_title = $mc_term->name;
} else {
	$mc_title = __( 'All Products', 'magneticcontrol' );
}

$mc_intro = $mc_term && $mc_term->description
	? wp_strip_all_tags( $mc_term->description )
	: __( 'High-quality, reliable and efficient products designed to meet the demanding needs of modern industries.', 'magneticcontrol' );

$mc_hero_image = mc_img( 'products-banner.webp' );
if ( $mc_term ) {
	$mc_thumb_id = (int) get_term_meta( $mc_term->term_id, 'thumbnail_id', true );
	if ( $mc_thumb_id ) {
		$mc_hero_image = esc_url( wp_get_attachment_image_url( $mc_thumb_id, 'full' ) );
	}
}

// Split the title so the last word gets the accent colour.
$mc_words      = explode( ' ', $mc_title );
$mc_title_last = array_pop( $mc_words );
$mc_title_head = implode( ' ', $mc_words );

$mc_total    = (int) wc_get_loop_prop( 'total' );
$mc_per_page = (int) wc_get_loop_prop( 'per_page' );
$mc_page     = max( 1, (int) wc_get_loop_prop( 'current_page' ) );
$mc_first    = $mc_total ? ( $mc_page - 1 ) * $mc_per_page + 1 : 0;
$mc_last     = min( $mc_total, $mc_page * $mc_per_page );
?>

<section class="mc-page-hero" style="--hero-image:url('<?php echo $mc_hero_image; // Escaped above. ?>')">
	<div class="mc-container mc-page-hero__inner">
		<?php mc_section_label( __( 'Our Products', 'magneticcontrol' ) ); ?>
		<h1 class="mc-page-hero__title">
			<?php if ( $mc_title_head ) : ?><?php echo esc_html( $mc_title_head ); ?><br><?php endif; ?>
			<span class="mc-accent"><?php echo esc_html( $mc_title_last ); ?></span>
		</h1>
		<p class="mc-page-hero__lead"><?php echo esc_html( $mc_intro ); ?></p>
		<nav class="mc-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'magneticcontrol' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo mc_icon( 'home' ); ?><?php esc_html_e( 'Home', 'magneticcontrol' ); ?></a>
			<?php echo mc_icon( 'chevron-right' ); ?>
			<?php if ( $mc_term || is_search() ) : ?>
				<a href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'Products', 'magneticcontrol' ); ?></a>
				<?php echo mc_icon( 'chevron-right' ); ?>
				<span aria-current="page"><?php echo esc_html( $mc_title ); ?></span>
			<?php else : ?>
				<span aria-current="page"><?php esc_html_e( 'Products', 'magneticcontrol' ); ?></span>
			<?php endif; ?>
		</nav>
	</div>
</section>

<div class="mc-container mc-shop">
	<?php get_template_part( 'template-parts/shop-filters' ); ?>

	<div class="mc-shop__main">
		<div class="mc-shop__toolbar">
			<div>
				<h2 class="mc-shop__title"><?php echo esc_html( $mc_title ); ?></h2>
				<p class="mc-shop__count">
					<?php
					if ( $mc_total ) {
						/* translators: 1: first result, 2: last result, 3: total results */
						printf( esc_html( _n( 'Showing %1$d–%2$d of %3$d product', 'Showing %1$d–%2$d of %3$d products', $mc_total, 'magneticcontrol' ) ), $mc_first, $mc_last, $mc_total );
					}
					?>
				</p>
			</div>
			<div class="mc-shop__tools">
				<button type="button" class="mc-btn mc-btn--outline mc-btn--sm mc-shop__filter-toggle" aria-controls="mc-filters" aria-expanded="false"><?php echo mc_icon( 'filter' ); ?> <?php esc_html_e( 'Filters', 'magneticcontrol' ); ?></button>
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<?php woocommerce_output_all_notices(); ?>

		<?php if ( woocommerce_product_loop() ) : ?>
			<?php woocommerce_product_loop_start(); ?>
			<?php
			while ( have_posts() ) {
				the_post();
				wc_get_template_part( 'content', 'product' );
			}
			?>
			<?php woocommerce_product_loop_end(); ?>

			<?php
			$mc_pages = (int) wc_get_loop_prop( 'total_pages' );
			if ( $mc_pages > 1 ) :
				?>
				<nav class="mc-pagination" aria-label="<?php esc_attr_e( 'Products pagination', 'magneticcontrol' ); ?>">
					<?php
					echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
						'format'    => '',
						'current'   => $mc_page,
						'total'     => $mc_pages,
						'prev_text' => mc_icon( 'arrow-left' ) . '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'magneticcontrol' ) . '</span>',
						'next_text' => mc_icon( 'arrow-right' ) . '<span class="screen-reader-text">' . esc_html__( 'Next page', 'magneticcontrol' ) . '</span>',
						'end_size'  => 2,
						'mid_size'  => 1,
					) );
					?>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<div class="mc-shop__empty">
				<?php echo mc_icon( 'search' ); ?>
				<h3><?php esc_html_e( 'No products match your filters', 'magneticcontrol' ); ?></h3>
				<p><?php esc_html_e( 'Try removing a filter, or contact us for a custom solution.', 'magneticcontrol' ); ?></p>
				<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'Clear Filters', 'magneticcontrol' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_template_part( 'template-parts/assurance-strip' ); ?>

<?php
get_footer( 'shop' );
