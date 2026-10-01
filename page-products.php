<?php
/**
 * Products landing page (slug: products): product categories, then what we offer.
 */

get_header();

$mc_categories = array(
	array(
		'slug'  => 'industrial-transformers',
		'title' => __( 'Electrical Transformers', 'magneticcontrol' ),
		'text'  => __( 'Low voltage dry type transformers for all your applications.', 'magneticcontrol' ),
		'icon'  => 'zap',
		'image' => 'product-transformers.webp',
	),
	array(
		'slug'  => 'harmonic-filters',
		'title' => __( 'Harmonic Filter', 'magneticcontrol' ),
		'text'  => __( 'Filters to rebuild and maintain the quality of power to meet customer requirements.', 'magneticcontrol' ),
		'icon'  => 'activity',
		'image' => 'product-harmonic-filter.webp',
	),
	array(
		'slug'  => 'drive-chokes',
		'title' => __( 'Drive Chokes', 'magneticcontrol' ),
		'text'  => __( "Protecting your VFD's & Motors without our input & output chokes.", 'magneticcontrol' ),
		'icon'  => 'shield-check',
		'image' => 'product-drive-chokes.webp',
	),
);

$mc_pillars = array(
	array( 'settings', __( 'Design', 'magneticcontrol' ) ),
	array( 'activity', __( 'Engineering', 'magneticcontrol' ) ),
	array( 'badge', __( 'Manufacturing', 'magneticcontrol' ) ),
	array( 'shield-check', __( 'Quality', 'magneticcontrol' ) ),
);

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'Our Products', 'magneticcontrol' ),
	'title'   => __( 'Products & Solutions', 'magneticcontrol' ),
	'lead'    => __( 'As a manufacturer we provide a wide range of customized products.', 'magneticcontrol' ),
	'image'   => 'products-display.webp',
) );
?>

<!-- Product categories -->
<section class="mc-section mc-cats">
	<div class="mc-container">
		<div class="mc-section-head" data-reveal>
			<?php mc_section_label( __( 'Product Categories', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'What We', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Manufacture', 'magneticcontrol' ); ?></span></h2>
		</div>
		<div class="mc-cats__grid">
			<?php foreach ( $mc_categories as $mc_i => $mc_cat ) : ?>
				<?php $mc_target = mc_category_target( $mc_cat['slug'] ); ?>
				<article class="mc-cat" data-reveal style="--delay:<?php echo (int) $mc_i * 120; ?>ms">
					<a class="mc-cat__media" href="<?php echo esc_url( $mc_target['url'] ); ?>" tabindex="-1" aria-hidden="true">
						<img src="<?php echo mc_img( $mc_cat['image'] ); ?>" alt="" loading="lazy">
					</a>
					<div class="mc-cat__body">
						<h3 class="mc-cat__title"><?php echo mc_icon( $mc_cat['icon'] ); ?><a href="<?php echo esc_url( $mc_target['url'] ); ?>"><?php echo esc_html( $mc_cat['title'] ); ?></a></h3>
						<p><?php echo esc_html( $mc_cat['text'] ); ?></p>
						<a class="mc-btn mc-btn--outline mc-btn--sm" href="<?php echo esc_url( $mc_target['url'] ); ?>">
							<?php
							if ( $mc_target['count'] > 1 ) {
								/* translators: %d: number of products in the category */
								echo esc_html( sprintf( __( 'View %d Products', 'magneticcontrol' ), $mc_target['count'] ) );
							} else {
								esc_html_e( 'View Product', 'magneticcontrol' );
							}
							?>
							<?php echo mc_icon( 'arrow-right' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Customized products -->
<section class="mc-section mc-custom-products">
	<div class="mc-container mc-split">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo mc_img( 'hero-2.webp' ); ?>" alt="<?php esc_attr_e( 'Transformer coils being wound at the Magnetic Control factory', 'magneticcontrol' ); ?>" loading="lazy">
			<div class="mc-trust-badge">
				<strong>500+</strong>
				<span><?php esc_html_e( 'Trusted by more than 500 customers', 'magneticcontrol' ); ?></span>
			</div>
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Customized Products', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'As a Manufacturer We Provide a Wide Range of', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Customized Products', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'We can help you create an effective solution with the carefully selected raw materials, best technology & design.', 'magneticcontrol' ); ?></p>
			<ul class="mc-pillar-grid">
				<?php foreach ( $mc_pillars as $mc_pillar ) : ?>
					<li><span class="mc-feature__icon"><?php echo mc_icon( $mc_pillar[0] ); ?></span><?php echo esc_html( $mc_pillar[1] ); ?></li>
				<?php endforeach; ?>
			</ul>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_quote_url() ); ?>"><?php esc_html_e( 'Request a Quote', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
