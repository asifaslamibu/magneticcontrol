<?php
/**
 * Catalog filter sidebar (category + attribute checkboxes, submitted as GET).
 */

defined( 'ABSPATH' ) || exit;

$mc_selected_cats = mc_selected_categories();

$mc_categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
	'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
) );

$mc_has_filters = $mc_selected_cats;
foreach ( array_keys( mc_filter_groups() ) as $mc_key ) {
	$mc_has_filters = $mc_has_filters || mc_filter_values( $mc_key );
}

$mc_checkbox = function ( $name, $term, $checked, $count ) {
	?>
	<li>
		<label class="mc-check">
			<input type="checkbox" name="<?php echo esc_attr( $name ); ?>[]" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( $checked ); ?>>
			<span class="mc-check__box" aria-hidden="true"><?php echo mc_icon( 'check' ); ?></span>
			<span class="mc-check__label"><?php echo esc_html( $term->name ); ?></span>
			<span class="mc-check__count">(<?php echo (int) $count; ?>)</span>
		</label>
	</li>
	<?php
};
?>
<aside class="mc-filters" id="mc-filters" aria-label="<?php esc_attr_e( 'Product filters', 'magneticcontrol' ); ?>">
	<form class="mc-filters__form" method="get" action="<?php echo esc_url( mc_shop_url() ); ?>">
		<div class="mc-filters__head">
			<h2><?php echo mc_icon( 'filter' ); ?><?php esc_html_e( 'Filter Products', 'magneticcontrol' ); ?></h2>
			<?php if ( $mc_has_filters ) : ?>
				<a href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'Clear All', 'magneticcontrol' ); ?></a>
			<?php endif; ?>
		</div>

		<?php if ( ! is_wp_error( $mc_categories ) && $mc_categories ) : ?>
			<fieldset class="mc-filters__group">
				<legend><?php esc_html_e( 'Product Category', 'magneticcontrol' ); ?></legend>
				<ul>
					<?php
					foreach ( $mc_categories as $mc_cat ) {
						$mc_checkbox( 'cat', $mc_cat, in_array( $mc_cat->slug, $mc_selected_cats, true ), $mc_cat->count );
					}
					?>
				</ul>
			</fieldset>
		<?php endif; ?>

		<?php foreach ( mc_filter_groups() as $mc_key => $mc_group ) : ?>
			<?php
			if ( ! taxonomy_exists( $mc_group['taxonomy'] ) ) {
				continue;
			}
			$mc_active = mc_filter_values( $mc_key );
			$mc_items  = array();
			foreach ( get_terms( array( 'taxonomy' => $mc_group['taxonomy'], 'hide_empty' => true ) ) as $mc_t ) {
				$mc_count  = mc_term_count( $mc_group['taxonomy'], $mc_t->term_id, $mc_selected_cats );
				$mc_is_set = in_array( $mc_t->slug, $mc_active, true );
				if ( $mc_count || $mc_is_set ) {
					$mc_items[] = array( $mc_t, $mc_is_set, $mc_count );
				}
			}
			if ( ! $mc_items ) {
				continue;
			}
			?>
			<fieldset class="mc-filters__group">
				<legend><?php echo esc_html( $mc_group['label'] ); ?></legend>
				<ul>
					<?php
					foreach ( $mc_items as $mc_item ) {
						$mc_checkbox( $mc_key, $mc_item[0], $mc_item[1], $mc_item[2] );
					}
					?>
				</ul>
			</fieldset>
		<?php endforeach; ?>

		<?php if ( is_search() ) : ?>
			<input type="hidden" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
			<input type="hidden" name="post_type" value="product">
		<?php endif; ?>
		<?php if ( ! empty( $_GET['orderby'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<input type="hidden" name="orderby" value="<?php echo esc_attr( wc_clean( wp_unslash( $_GET['orderby'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
		<?php endif; ?>

		<button type="submit" class="mc-btn mc-btn--primary mc-filters__apply"><?php echo mc_icon( 'filter' ); ?> <?php esc_html_e( 'Apply Filters', 'magneticcontrol' ); ?></button>
	</form>
</aside>
