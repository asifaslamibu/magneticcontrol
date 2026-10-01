<?php
/**
 * Product card used in catalog loops.
 *
 * Overrides woocommerce/templates/content-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$mc_id        = $product->get_id();
$mc_link      = get_permalink( $mc_id );
$mc_subtitle  = get_post_meta( $mc_id, '_mc_subtitle', true );
$mc_specs     = mc_product_specs( $mc_id );
$mc_icons     = array( 'zap', 'gauge', 'check' );
$mc_price     = $product->get_price();
$mc_can_buy   = '' !== $mc_price && $product->is_purchasable() && $product->is_in_stock();
$mc_quote_url = mc_quote_url( $product->get_name() );
?>
<li <?php wc_product_class( 'mc-pcard', $product ); ?>>
	<div class="mc-pcard__media">
		<a href="<?php echo esc_url( $mc_link ); ?>" tabindex="-1" aria-hidden="true">
			<?php
			// First row loads eagerly (above the fold), the rest lazily.
			$mc_loading = (int) wc_get_loop_prop( 'loop' ) <= 3 ? 'eager' : 'lazy';
			echo $product->get_image( 'woocommerce_single', array( 'loading' => $mc_loading, 'sizes' => '(max-width: 767px) 92vw, (max-width: 1199px) 45vw, 270px' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</a>
		<?php if ( $product->is_featured() ) : ?>
			<span class="mc-pcard__badge"><?php esc_html_e( 'Featured', 'magneticcontrol' ); ?></span>
		<?php elseif ( $product->is_on_sale() ) : ?>
			<span class="mc-pcard__badge mc-pcard__badge--sale"><?php esc_html_e( 'Sale', 'magneticcontrol' ); ?></span>
		<?php endif; ?>
		<button type="button" class="mc-pcard__wish" data-wishlist="<?php echo (int) $mc_id; ?>" aria-pressed="false" aria-label="<?php echo esc_attr( sprintf( __( 'Save %s to wishlist', 'magneticcontrol' ), $product->get_name() ) ); ?>"><?php echo mc_icon( 'heart' ); ?></button>
	</div>

	<div class="mc-pcard__body">
		<h3 class="mc-pcard__title"><a href="<?php echo esc_url( $mc_link ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
		<?php if ( $mc_subtitle ) : ?>
			<p class="mc-pcard__subtitle"><?php echo esc_html( $mc_subtitle ); ?></p>
		<?php endif; ?>

		<?php if ( $mc_specs ) : ?>
			<ul class="mc-pcard__specs">
				<?php foreach ( $mc_specs as $mc_i => $mc_spec ) : ?>
					<li><?php echo mc_icon( $mc_icons[ $mc_i ] ); ?><?php echo esc_html( $mc_spec ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<p class="mc-pcard__price">
			<?php if ( '' !== $mc_price ) : ?>
				<span><?php esc_html_e( 'From', 'magneticcontrol' ); ?></span>
				<strong><?php echo wc_price( wc_get_price_to_display( $product, array( 'price' => $product->is_type( 'variable' ) ? $product->get_variation_price( 'min' ) : $mc_price ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
			<?php else : ?>
				<strong class="mc-pcard__poa"><?php esc_html_e( 'Price on Request', 'magneticcontrol' ); ?></strong>
			<?php endif; ?>
		</p>

		<div class="mc-pcard__actions">
			<a class="mc-btn mc-btn--outline mc-btn--sm mc-pcard__details" href="<?php echo esc_url( $mc_link ); ?>"><?php esc_html_e( 'View Details', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
			<?php if ( $mc_can_buy && $product->is_type( 'simple' ) ) : ?>
				<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="mc-pcard__cart add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo (int) $mc_id; ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" data-quantity="1" rel="nofollow" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'magneticcontrol' ), $product->get_name() ) ); ?>"><?php echo mc_icon( 'cart' ); ?></a>
			<?php elseif ( $mc_can_buy ) : ?>
				<a href="<?php echo esc_url( $mc_link ); ?>" class="mc-pcard__cart" aria-label="<?php echo esc_attr( sprintf( __( 'Choose options for %s', 'magneticcontrol' ), $product->get_name() ) ); ?>"><?php echo mc_icon( 'cart' ); ?></a>
			<?php else : ?>
				<a href="<?php echo esc_url( $mc_quote_url ); ?>" class="mc-pcard__cart" aria-label="<?php echo esc_attr( sprintf( __( 'Request a quote for %s', 'magneticcontrol' ), $product->get_name() ) ); ?>" title="<?php esc_attr_e( 'Request a Quote', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'message' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</li>
