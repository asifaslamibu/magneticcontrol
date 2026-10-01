<?php
/**
 * Homepage.
 */

get_header();

$mc_hero_slides = array( 'hero-1.webp', 'hero-2.webp', 'factory-building.webp' );

$mc_products = array(
	array(
		'title' => __( 'Electrical Transformers', 'magneticcontrol' ),
		'text'  => __( 'Low voltage dry type transformers for all your applications.', 'magneticcontrol' ),
		'icon'  => 'zap',
		'image' => 'product-transformers.webp',
		'cat'   => 'industrial-transformers',
	),
	array(
		'title' => __( 'Harmonic Filter', 'magneticcontrol' ),
		'text'  => __( 'Filters to rebuild and maintain the quality of power to meet customer requirements.', 'magneticcontrol' ),
		'icon'  => 'activity',
		'image' => 'product-harmonic-filter.webp',
		'cat'   => 'harmonic-filters',
	),
	array(
		'title' => __( 'Drive Chokes', 'magneticcontrol' ),
		'text'  => __( "Protecting your VFD's & Motors without our input & output chokes.", 'magneticcontrol' ),
		'icon'  => 'shield-check',
		'image' => 'product-drive-chokes.webp',
		'cat'   => 'drive-chokes',
	),
);

$mc_features = array(
	array( 'settings', __( 'We Design & Engineer', 'magneticcontrol' ), __( 'Thoroughly understanding your specific needs.', 'magneticcontrol' ) ),
	array( 'badge', __( 'We Manufacture', 'magneticcontrol' ), __( 'Committed to quality.', 'magneticcontrol' ) ),
	array( 'truck', __( 'We Deliver', 'magneticcontrol' ), __( 'Bringing growth through on-time delivery.', 'magneticcontrol' ) ),
);
?>

<!-- Hero -->
<section class="mc-hero" data-slider="hero">
	<div class="mc-hero__slides">
		<?php foreach ( $mc_hero_slides as $i => $slide ) : ?>
			<?php // Only the first slide loads up front; main.js swaps in the others after page load. ?>
			<div class="mc-hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" <?php echo 0 === $i ? 'style' : 'data-bg'; ?>="background-image:url('<?php echo mc_img( $slide ); ?>')"></div>
		<?php endforeach; ?>
	</div>
	<div class="mc-hero__overlay"></div>

	<div class="mc-container mc-hero__inner">
		<div class="mc-hero__content">
			<h1 class="mc-hero__title"><?php esc_html_e( 'Offering Manufacturing Solutions', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'From Start to Finish', 'magneticcontrol' ); ?></span></h1>
			<p class="mc-hero__lead"><?php esc_html_e( 'Our vision and focus has been to manufacture and deliver high quality products for our clients with emphasis on cost, efficiency, international & local standards.', 'magneticcontrol' ); ?></p>
			<div class="mc-hero__buttons">
				<a class="mc-btn mc-btn--primary" href="<?php echo esc_url( mc_products_url() ); ?>"><?php esc_html_e( 'Explore Our Solutions', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
				<a class="mc-btn mc-btn--ghost" href="<?php echo esc_url( mc_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About Us', 'magneticcontrol' ); ?></a>
			</div>
			<ul class="mc-hero__points">
				<li><?php echo mc_icon( 'badge' ); ?><span><?php esc_html_e( 'High Quality', 'magneticcontrol' ); ?><br><?php esc_html_e( 'Products', 'magneticcontrol' ); ?></span></li>
				<li><?php echo mc_icon( 'shield-check' ); ?><span><?php esc_html_e( 'Cost Effective', 'magneticcontrol' ); ?><br><?php esc_html_e( 'Solutions', 'magneticcontrol' ); ?></span></li>
				<li><?php echo mc_icon( 'globe' ); ?><span><?php esc_html_e( 'International', 'magneticcontrol' ); ?><br><?php esc_html_e( 'Standards', 'magneticcontrol' ); ?></span></li>
			</ul>
		</div>

		<div class="mc-hero__trust">
			<?php echo mc_icon( 'globe' ); ?>
			<span class="mc-hero__trust-label"><?php esc_html_e( 'Trusted by', 'magneticcontrol' ); ?></span>
			<strong>500+</strong>
			<span><?php esc_html_e( 'Clients Worldwide', 'magneticcontrol' ); ?></span>
		</div>
	</div>

	<div class="mc-hero__controls">
		<button type="button" class="mc-hero__arrow" data-prev aria-label="<?php esc_attr_e( 'Previous slide', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'arrow-left' ); ?></button>
		<button type="button" class="mc-hero__arrow" data-next aria-label="<?php esc_attr_e( 'Next slide', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'arrow-right' ); ?></button>
		<div class="mc-hero__dots" role="tablist">
			<?php foreach ( $mc_hero_slides as $i => $slide ) : ?>
				<button type="button" class="<?php echo 0 === $i ? 'is-active' : ''; ?>" data-dot="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'magneticcontrol' ), $i + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- About -->
<section class="mc-section mc-about">
	<div class="mc-container mc-about__grid">
		<div class="mc-about__media" data-reveal>
			<img src="<?php echo mc_img( 'about.webp' ); ?>" alt="<?php esc_attr_e( 'Magnetic Control engineers at work in the factory', 'magneticcontrol' ); ?>" loading="lazy">
		</div>

		<div class="mc-about__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'About Us', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Trusted Industrial Solutions', 'magneticcontrol' ); ?><br><span class="mc-accent"><?php esc_html_e( 'Since 2018', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'We understand the importance of innovation and professionalism and work with the best people to achieve this. Since our launch in 2018, our vision and focus has been to manufacture and deliver high quality products for our clients with emphasis on cost, efficiency, international & local standards.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--outline mc-btn--sm" href="<?php echo esc_url( mc_page_url( 'about' ) ); ?>"><?php esc_html_e( 'Learn More About Us', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>
	</div>
</section>

<!-- Design / Manufacture / Deliver -->
<section class="mc-features">
	<div class="mc-container mc-features__grid">
		<?php foreach ( $mc_features as $i => $feature ) : ?>
			<div class="mc-feature" data-reveal style="--delay:<?php echo (int) $i * 100; ?>ms">
				<span class="mc-feature__icon"><?php echo mc_icon( $feature[0] ); ?></span>
				<div>
					<h3><?php echo esc_html( $feature[1] ); ?></h3>
					<p><?php echo esc_html( $feature[2] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- Products -->
<section class="mc-section mc-products">
	<div class="mc-container mc-products__grid">
		<div class="mc-products__intro" data-reveal>
			<?php mc_section_label( __( 'Our Products & Solutions', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'We Focus on', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Quality & Efficiency', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'Serving all your power conditioning needs.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_products_url() ); ?>"><?php esc_html_e( 'Our Products', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>

		<?php foreach ( $mc_products as $i => $product ) : ?>
			<article class="mc-card" data-reveal style="--delay:<?php echo (int) ( $i + 1 ) * 100; ?>ms">
				<div class="mc-card__media">
					<img src="<?php echo mc_img( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['title'] ); ?>" loading="lazy">
				</div>
				<h3 class="mc-card__title"><?php echo mc_icon( $product['icon'] ); ?><?php echo esc_html( $product['title'] ); ?></h3>
				<p><?php echo esc_html( $product['text'] ); ?></p>
				<a class="mc-link" href="<?php echo esc_url( mc_cat_url( $product['cat'] ) ); ?>"><?php esc_html_e( 'Learn More', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<!-- Statistics -->
<section class="mc-numbers">
	<div class="mc-container mc-numbers__inner">
		<div class="mc-numbers__text" data-reveal>
			<?php mc_section_label( __( 'Statistics', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'We Pride Ourselves on Aiming', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Perfection in Every Product', 'magneticcontrol' ); ?></span></h2>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>
		<ul class="mc-numbers__list" data-reveal style="--delay:150ms">
			<?php foreach ( mc_company_stats() as $mc_stat ) : ?>
				<li>
					<strong><span data-count="<?php echo (int) $mc_stat[0]; ?>"><?php echo esc_html( number_format_i18n( $mc_stat[0] ) ); ?></span><?php echo esc_html( $mc_stat[1] ); ?></strong>
					<span><?php echo esc_html( $mc_stat[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php get_template_part( 'template-parts/customers' ); ?>

<?php
get_footer();
