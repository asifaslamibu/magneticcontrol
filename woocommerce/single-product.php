<?php
/**
 * Single product page.
 *
 * Overrides woocommerce/templates/single-product.php
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

while ( have_posts() ) :
	the_post();

	global $product;
	if ( ! is_a( $product, WC_Product::class ) ) {
		$product = wc_get_product( get_the_ID() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	$mc_id       = $product->get_id();
	$mc_name     = $product->get_name();
	$mc_terms    = wc_get_product_terms( $mc_id, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
	$mc_cat      = $mc_terms ? $mc_terms[0] : null;
	$mc_price    = $product->get_price();
	$mc_quote    = mc_quote_url( $mc_name );
	$mc_phone    = mc_contact( 'phone' );
	$mc_tel      = 'tel:' . preg_replace( '/\s+/', '', $mc_phone );
	$mc_reviews  = (int) $product->get_review_count();
	$mc_rating   = (float) $product->get_average_rating();
	$mc_lead     = wp_trim_words( wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ), 28 );
	// Join hard-wrapped lines so each paragraph flows; blank lines still split paragraphs.
	$mc_overview = preg_replace( '/(?<!\n)\n(?!\n)/', ' ', str_replace( "\r", '', $product->get_short_description() ) );

	$mc_images = array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );

	$mc_highlights   = mc_product_highlights( $product );
	$mc_specs        = mc_product_tech_specs( $product );
	$mc_applications = mc_meta_lines( $mc_id, '_mc_applications' );
	$mc_downloads    = mc_meta_pairs( $mc_id, '_mc_downloads' );

	$mc_badges = array(
		array( 'settings', __( 'High Efficiency', 'magneticcontrol' ), __( 'Lower energy losses', 'magneticcontrol' ) ),
		array( 'shield-check', __( 'Reliable Performance', 'magneticcontrol' ), __( 'Long service life', 'magneticcontrol' ) ),
		array( 'badge', __( 'IEC Certified', 'magneticcontrol' ), __( 'Meets global standards', 'magneticcontrol' ) ),
	);
	$mc_perks = array(
		array( 'truck', __( 'Free Shipping', 'magneticcontrol' ), __( 'On orders over £500', 'magneticcontrol' ) ),
		array( 'card', __( 'Secure Payment', 'magneticcontrol' ), __( '100% secure checkout', 'magneticcontrol' ) ),
		array( 'award', __( '2 Year Warranty', 'magneticcontrol' ), __( 'Manufacturer warranty', 'magneticcontrol' ) ),
	);

	// Tabs are only shown when they have something to show.
	$mc_tabs = array(
		'overview'       => __( 'Overview', 'magneticcontrol' ),
		'specifications' => $mc_specs ? __( 'Specifications', 'magneticcontrol' ) : '',
		'features'       => $product->get_description() ? __( 'Features', 'magneticcontrol' ) : '',
		'applications'   => $mc_applications ? __( 'Applications', 'magneticcontrol' ) : '',
		'downloads'      => $mc_downloads ? __( 'Downloads', 'magneticcontrol' ) : '',
		'reviews'        => comments_open() ? __( 'Reviews', 'magneticcontrol' ) : '',
	);
	$mc_tabs = array_filter( $mc_tabs );

	$mc_related = array_filter( array_map( 'wc_get_product', wc_get_related_products( $mc_id, 8 ) ), 'wc_products_array_filter_visible' );

	do_action( 'woocommerce_before_single_product' );
	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		continue;
	}
	?>

	<div id="product-<?php echo (int) $mc_id; ?>" <?php wc_product_class( 'mc-product', $product ); ?>>

		<section class="mc-product-hero" data-product-hero>
			<div class="mc-product-hero__band" style="--hero-image:url('<?php echo mc_img( 'products-banner.webp' ); ?>')" aria-hidden="true"></div>

			<div class="mc-container mc-product-hero__inner">
				<nav class="mc-breadcrumb mc-product-hero__crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'magneticcontrol' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo mc_icon( 'home' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Home', 'magneticcontrol' ); ?></span></a>
					<a href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'Products', 'magneticcontrol' ); ?></a>
					<?php if ( $mc_cat ) : ?>
						<?php echo mc_icon( 'chevron-right' ); ?>
						<a href="<?php echo esc_url( get_term_link( $mc_cat ) ); ?>"><?php echo esc_html( $mc_cat->name ); ?></a>
					<?php endif; ?>
					<?php echo mc_icon( 'chevron-right' ); ?>
					<span aria-current="page"><?php echo esc_html( $mc_name ); ?></span>
				</nav>

				<div class="mc-product-top">
					<div class="mc-gallery" data-gallery>
						<div class="mc-gallery__stage">
							<?php if ( $product->is_featured() ) : ?>
								<span class="mc-pcard__badge"><?php esc_html_e( 'Featured', 'magneticcontrol' ); ?></span>
							<?php elseif ( $product->is_on_sale() ) : ?>
								<span class="mc-pcard__badge mc-pcard__badge--sale"><?php esc_html_e( 'Sale', 'magneticcontrol' ); ?></span>
							<?php endif; ?>

							<?php if ( $mc_images ) : ?>
								<?php foreach ( array_values( $mc_images ) as $mc_i => $mc_img_id ) : ?>
									<figure class="mc-gallery__slide<?php echo 0 === $mc_i ? ' is-active' : ''; ?>" data-slide>
										<?php
										echo wp_get_attachment_image( $mc_img_id, 'woocommerce_single', false, array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'loading' => 0 === $mc_i ? 'eager' : 'lazy',
											'sizes'   => '(max-width: 991px) 92vw, 560px',
											'alt'     => get_post_meta( $mc_img_id, '_wp_attachment_image_alt', true ) ? get_post_meta( $mc_img_id, '_wp_attachment_image_alt', true ) : $mc_name,
										) );
										?>
									</figure>
								<?php endforeach; ?>
							<?php else : ?>
								<figure class="mc-gallery__slide is-active"><?php echo wc_placeholder_img( 'woocommerce_single' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
							<?php endif; ?>

							<?php if ( count( $mc_images ) > 1 ) : ?>
								<button type="button" class="mc-gallery__arrow mc-gallery__arrow--prev" data-prev aria-label="<?php esc_attr_e( 'Previous image', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-left' ); ?></button>
								<button type="button" class="mc-gallery__arrow mc-gallery__arrow--next" data-next aria-label="<?php esc_attr_e( 'Next image', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-right' ); ?></button>
							<?php endif; ?>
						</div>

						<?php if ( count( $mc_images ) > 1 ) : ?>
							<ul class="mc-gallery__thumbs">
								<?php foreach ( array_values( $mc_images ) as $mc_i => $mc_img_id ) : ?>
									<li>
										<button type="button" class="mc-gallery__thumb<?php echo 0 === $mc_i ? ' is-active' : ''; ?>" data-thumb="<?php echo (int) $mc_i; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show image %d', 'magneticcontrol' ), $mc_i + 1 ) ); ?>">
											<?php echo wp_get_attachment_image( $mc_img_id, 'woocommerce_gallery_thumbnail', false, array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</button>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>

					<div class="mc-product-intro" data-product-intro>
						<?php if ( $mc_cat ) : ?>
							<span class="mc-eyebrow mc-product-intro__cat"><?php echo esc_html( $mc_cat->name ); ?></span>
						<?php endif; ?>
						<h1 class="mc-product-intro__title"><?php echo esc_html( $mc_name ); ?></h1>
						<?php if ( $mc_lead ) : ?>
							<p class="mc-product-intro__lead"><?php echo esc_html( $mc_lead ); ?></p>
						<?php endif; ?>
						<?php if ( $mc_reviews ) : ?>
							<a class="mc-rating" href="#tab-reviews" data-tab-link="reviews">
								<span class="mc-rating__stars" style="--rating:<?php echo esc_attr( $mc_rating / 5 * 100 ); ?>%" aria-hidden="true">
									<?php echo str_repeat( mc_icon( 'star' ), 5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<span><?php echo str_repeat( mc_icon( 'star' ), 5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								</span>
								<?php
								/* translators: 1: average rating, 2: review count */
								printf( esc_html( _n( '%1$s (%2$d review)', '%1$s (%2$d reviews)', $mc_reviews, 'magneticcontrol' ) ), esc_html( number_format_i18n( $mc_rating, 1 ) ), $mc_reviews );
								?>
							</a>
						<?php endif; ?>
					</div>

					<div class="mc-buy">
						<ul class="mc-buy__badges">
							<?php foreach ( $mc_badges as $mc_badge ) : ?>
								<li>
									<?php echo mc_icon( $mc_badge[0] ); ?>
									<div><strong><?php echo esc_html( $mc_badge[1] ); ?></strong><span><?php echo esc_html( $mc_badge[2] ); ?></span></div>
								</li>
							<?php endforeach; ?>
						</ul>

						<div class="mc-buy__price">
							<?php if ( '' !== $mc_price ) : ?>
								<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php if ( wc_tax_enabled() && 'excl' === get_option( 'woocommerce_tax_display_shop' ) ) : ?>
									<small><?php esc_html_e( '(Ex VAT)', 'magneticcontrol' ); ?></small>
								<?php endif; ?>
							<?php else : ?>
								<span class="mc-buy__poa"><?php esc_html_e( 'Price on Request', 'magneticcontrol' ); ?></span>
							<?php endif; ?>
						</div>

						<p class="mc-buy__meta">
							<span class="mc-buy__stock<?php echo $product->is_in_stock() ? '' : ' is-out'; ?>">
								<?php
								if ( ! $product->is_in_stock() ) {
									esc_html_e( 'Out of Stock', 'magneticcontrol' );
								} elseif ( $product->is_on_backorder() ) {
									esc_html_e( 'Available on Backorder', 'magneticcontrol' );
								} else {
									esc_html_e( 'In Stock', 'magneticcontrol' );
								}
								?>
							</span>
							<?php if ( $product->get_sku() ) : ?>
								<span class="mc-buy__sku"><?php esc_html_e( 'SKU:', 'magneticcontrol' ); ?> <?php echo esc_html( $product->get_sku() ); ?></span>
							<?php endif; ?>
						</p>

						<div class="mc-buy__actions">
							<?php if ( '' !== $mc_price && $product->is_purchasable() ) : ?>
								<?php woocommerce_template_single_add_to_cart(); ?>
							<?php else : ?>
								<a class="mc-btn mc-btn--primary mc-buy__quote" href="<?php echo esc_url( $mc_quote ); ?>"><?php echo mc_icon( 'message' ); ?> <?php esc_html_e( 'Request a Quote', 'magneticcontrol' ); ?></a>
								<a class="mc-btn mc-btn--outline mc-buy__call" href="<?php echo esc_url( $mc_tel ); ?>"><?php echo mc_icon( 'phone' ); ?> <?php echo esc_html( $mc_phone ); ?></a>
							<?php endif; ?>
							<button type="button" class="mc-buy__wish" data-wishlist="<?php echo (int) $mc_id; ?>" aria-pressed="false"><?php echo mc_icon( 'heart' ); ?> <?php esc_html_e( 'Add to Wishlist', 'magneticcontrol' ); ?></button>
						</div>

						<ul class="mc-buy__perks">
							<?php foreach ( $mc_perks as $mc_perk ) : ?>
								<li>
									<?php echo mc_icon( $mc_perk[0] ); ?>
									<div><strong><?php echo esc_html( $mc_perk[1] ); ?></strong><span><?php echo esc_html( $mc_perk[2] ); ?></span></div>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</section>

		<section class="mc-container mc-product-tabs" data-tabs>
			<div class="mc-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Product information', 'magneticcontrol' ); ?>">
				<?php $mc_first_tab = true; ?>
				<?php foreach ( $mc_tabs as $mc_key => $mc_label ) : ?>
					<button type="button" class="mc-tabs__tab<?php echo $mc_first_tab ? ' is-active' : ''; ?>" role="tab" id="tab-btn-<?php echo esc_attr( $mc_key ); ?>" aria-controls="tab-<?php echo esc_attr( $mc_key ); ?>" aria-selected="<?php echo $mc_first_tab ? 'true' : 'false'; ?>" <?php echo $mc_first_tab ? '' : 'tabindex="-1"'; ?> data-tab="<?php echo esc_attr( $mc_key ); ?>"><?php echo esc_html( $mc_label ); ?></button>
					<?php $mc_first_tab = false; ?>
				<?php endforeach; ?>
			</div>

			<div class="mc-tabs__panel mc-overview is-active" role="tabpanel" id="tab-overview" aria-labelledby="tab-btn-overview">
				<div class="mc-overview__text">
					<h2><?php esc_html_e( 'Product Overview', 'magneticcontrol' ); ?></h2>
					<?php if ( $mc_overview ) : ?>
						<div class="mc-overview__body"><?php echo wp_kses_post( wpautop( $mc_overview ) ); ?></div>
					<?php endif; ?>
					<?php if ( $mc_highlights ) : ?>
						<ul class="mc-checklist">
							<?php foreach ( $mc_highlights as $mc_item ) : ?>
								<li><?php echo mc_icon( 'check' ); ?><?php echo esc_html( $mc_item ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<figure class="mc-overview__promo">
					<img src="<?php echo mc_img( 'factory-team.webp' ); ?>" alt="" loading="lazy" width="1920" height="1080">
					<figcaption>
						<span><?php esc_html_e( 'Built for a', 'magneticcontrol' ); ?></span>
						<strong><?php esc_html_e( 'More Reliable', 'magneticcontrol' ); ?> <em class="mc-accent"><?php esc_html_e( 'Power Future', 'magneticcontrol' ); ?></em></strong>
						<small><?php esc_html_e( 'Efficient', 'magneticcontrol' ); ?> <i></i> <?php esc_html_e( 'Durable', 'magneticcontrol' ); ?> <i></i> <?php esc_html_e( 'Sustainable', 'magneticcontrol' ); ?></small>
					</figcaption>
				</figure>
			</div>

			<?php if ( isset( $mc_tabs['specifications'] ) ) : ?>
				<div class="mc-tabs__panel" role="tabpanel" id="tab-specifications" aria-labelledby="tab-btn-specifications" hidden>
					<table class="mc-spec-table">
						<tbody>
							<?php foreach ( $mc_specs as $mc_spec ) : ?>
								<tr><th scope="row"><?php echo esc_html( $mc_spec[0] ); ?></th><td><?php echo esc_html( $mc_spec[1] ); ?></td></tr>
							<?php endforeach; ?>
							<?php if ( $product->get_sku() ) : ?>
								<tr><th scope="row"><?php esc_html_e( 'SKU', 'magneticcontrol' ); ?></th><td><?php echo esc_html( $product->get_sku() ); ?></td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>

			<?php if ( isset( $mc_tabs['features'] ) ) : ?>
				<div class="mc-tabs__panel mc-prose" role="tabpanel" id="tab-features" aria-labelledby="tab-btn-features" hidden>
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

			<?php if ( isset( $mc_tabs['applications'] ) ) : ?>
				<div class="mc-tabs__panel" role="tabpanel" id="tab-applications" aria-labelledby="tab-btn-applications" hidden>
					<ul class="mc-checklist mc-checklist--grid">
						<?php foreach ( $mc_applications as $mc_item ) : ?>
							<li><?php echo mc_icon( 'check' ); ?><?php echo esc_html( $mc_item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( isset( $mc_tabs['downloads'] ) ) : ?>
				<div class="mc-tabs__panel" role="tabpanel" id="tab-downloads" aria-labelledby="tab-btn-downloads" hidden>
					<ul class="mc-downloads">
						<?php foreach ( $mc_downloads as $mc_file ) : ?>
							<li><a href="<?php echo esc_url( $mc_file[1] ); ?>" target="_blank" rel="noopener"><?php echo mc_icon( 'file-text' ); ?><span><?php echo esc_html( $mc_file[0] ); ?></span><?php echo mc_icon( 'download' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( isset( $mc_tabs['reviews'] ) ) : ?>
				<div class="mc-tabs__panel mc-reviews" role="tabpanel" id="tab-reviews" aria-labelledby="tab-btn-reviews" hidden>
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>
		</section>

		<section class="mc-container mc-product-specs">
			<?php if ( $mc_specs ) : ?>
				<div class="mc-specs">
					<h2><?php esc_html_e( 'Technical Specifications', 'magneticcontrol' ); ?></h2>
					<dl class="mc-specs__grid">
						<?php foreach ( array_slice( $mc_specs, 0, 12 ) as $mc_spec ) : ?>
							<div class="mc-specs__row">
								<span class="mc-specs__icon"><?php echo mc_icon( mc_spec_icon( $mc_spec[0] ) ); ?></span>
								<dt><?php echo esc_html( $mc_spec[0] ); ?></dt>
								<dd><?php echo esc_html( $mc_spec[1] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			<?php endif; ?>

			<aside class="mc-custom">
				<h2><span class="mc-custom__icon"><?php echo mc_icon( 'shield-check' ); ?></span><?php esc_html_e( 'Need a Custom Solution?', 'magneticcontrol' ); ?></h2>
				<p><?php esc_html_e( 'We can help you find the right transformer for your specific requirements.', 'magneticcontrol' ); ?></p>
				<a class="mc-btn mc-btn--outline mc-btn--sm" href="<?php echo esc_url( $mc_quote ); ?>"><?php esc_html_e( 'Request a Quote', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
				<div class="mc-custom__contact">
					<span class="mc-custom__icon"><?php echo mc_icon( 'phone' ); ?></span>
					<div>
						<a href="<?php echo esc_url( $mc_tel ); ?>"><?php echo esc_html( $mc_phone ); ?></a>
						<a href="mailto:<?php echo esc_attr( mc_contact( 'email' ) ); ?>"><?php echo esc_html( mc_contact( 'email' ) ); ?></a>
					</div>
				</div>
			</aside>
		</section>

		<?php if ( $mc_related ) : ?>
			<section class="mc-container mc-related" data-related>
				<div class="mc-related__head">
					<div>
						<?php mc_section_label( __( 'Related Products', 'magneticcontrol' ) ); ?>
						<h2><?php esc_html_e( 'You May Also Like', 'magneticcontrol' ); ?></h2>
					</div>
					<div class="mc-related__nav">
						<button type="button" class="mc-partners__arrow" data-prev aria-label="<?php esc_attr_e( 'Previous products', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-left' ); ?></button>
						<button type="button" class="mc-partners__arrow" data-next aria-label="<?php esc_attr_e( 'Next products', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-right' ); ?></button>
					</div>
				</div>
				<ul class="products mc-related__track">
					<?php
					foreach ( $mc_related as $mc_related_product ) {
						$post_object = get_post( $mc_related_product->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
						wc_get_template_part( 'content', 'product' );
					}
					wp_reset_postdata();
					?>
				</ul>
			</section>
		<?php endif; ?>
	</div>

	<?php
	if ( isset( WC()->structured_data ) ) {
		WC()->structured_data->generate_product_data( $product );
	}
	do_action( 'woocommerce_after_single_product' );

endwhile;

get_footer( 'shop' );
