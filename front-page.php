<?php
/**
 * Homepage.
 */

get_header();

$mc_hero_slides = array( 'hero-1.webp', 'hero-2.webp', 'hero-3.webp' );

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
		'text'  => __( "Protecting your VFD's & Motors without our Input & output chokes.", 'magneticcontrol' ),
		'icon'  => 'shield-check',
		'image' => 'product-drive-chokes.webp',
		'cat'   => 'drive-chokes',
	),
);

$mc_features = array(
	array( 'settings', __( 'Custom Engineering', 'magneticcontrol' ), __( 'Tailored solutions for your specific requirements.', 'magneticcontrol' ) ),
	array( 'shield-check', __( 'Quality Assurance', 'magneticcontrol' ), __( 'Rigorous testing for reliable performance.', 'magneticcontrol' ) ),
	array( 'truck', __( 'On-Time Delivery', 'magneticcontrol' ), __( 'Your projects, our priority.', 'magneticcontrol' ) ),
	array( 'handshake', __( 'Expert Support', 'magneticcontrol' ), __( 'Dedicated team for long-term partnership.', 'magneticcontrol' ) ),
);

$mc_stats = mc_company_stats();

$mc_testimonials = array(
	array(
		'quote' => __( 'Magnetic Control provided us with excellent support and high-quality products. Their team is professional, responsive and always delivers on time.', 'magneticcontrol' ),
		'name'  => 'John Carter',
		'role'  => __( 'Operations Manager, UK', 'magneticcontrol' ),
	),
	array(
		'quote' => __( 'The harmonic filters they engineered for our plant solved problems we had been fighting for years. Clear communication from design through to commissioning.', 'magneticcontrol' ),
		'name'  => 'Sarah Mitchell',
		'role'  => __( 'Electrical Engineer, Germany', 'magneticcontrol' ),
	),
	array(
		'quote' => __( 'Reliable transformers, fair pricing and a team that genuinely understands industrial power. They are now our first call for every new project.', 'magneticcontrol' ),
		'name'  => 'Ahmed Khan',
		'role'  => __( 'Project Director, UAE', 'magneticcontrol' ),
	),
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
			<?php mc_section_label( __( 'Industrial Magnetic Solutions', 'magneticcontrol' ) ); ?>
			<h1 class="mc-hero__title"><?php esc_html_e( 'Powering Efficiency', 'magneticcontrol' ); ?><br><?php esc_html_e( 'Through', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Innovation', 'magneticcontrol' ); ?></span></h1>
			<p class="mc-hero__lead"><?php esc_html_e( 'We provide advanced magnetic and industrial solutions that help businesses improve efficiency, reduce costs and achieve higher quality standards.', 'magneticcontrol' ); ?></p>
			<div class="mc-hero__buttons">
				<a class="mc-btn mc-btn--primary" href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'Explore Our Solutions', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
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

<!-- Products & Solutions -->
<section class="mc-section mc-products">
	<div class="mc-container mc-products__grid">
		<div class="mc-products__intro" data-reveal>
			<?php mc_section_label( __( 'Our Products & Solutions', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Innovative Solutions for', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Every Industry', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'From electrical transformers to harmonic filters and drive chokes, we offer a wide range of high-performance products designed to meet your unique industrial needs.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'View All Products', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
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

<!-- Features strip -->
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

<!-- About / Why choose us -->
<section class="mc-section mc-about">
	<div class="mc-container mc-about__grid">
		<div class="mc-about__media" data-reveal>
			<img src="<?php echo mc_img( 'about.webp' ); ?>" alt="<?php esc_attr_e( 'Magnetic Control engineers at work in the factory', 'magneticcontrol' ); ?>" loading="lazy">
			<div class="mc-about__slogan"><span><?php esc_html_e( 'Engineering', 'magneticcontrol' ); ?><br><?php esc_html_e( 'a Better', 'magneticcontrol' ); ?><br><?php esc_html_e( 'Tomorrow', 'magneticcontrol' ); ?></span></div>
		</div>

		<div class="mc-about__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Why Choose Magnetic Control', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Trusted Industrial Solutions', 'magneticcontrol' ); ?><br><span class="mc-accent"><?php esc_html_e( 'Since Day One', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'With years of experience in the industry, Magnetic Control delivers reliable, high-quality products and services to clients around the world. We focus on innovation, quality and customer satisfaction in everything we do.', 'magneticcontrol' ); ?></p>
			<ul class="mc-stats">
				<?php foreach ( $mc_stats as $stat ) : ?>
					<li>
						<strong><span data-count="<?php echo (int) $stat[0]; ?>"><?php echo esc_html( number_format_i18n( $stat[0] ) ); ?></span><?php echo esc_html( $stat[1] ); ?></strong>
						<span><?php echo esc_html( $stat[2] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<a class="mc-btn mc-btn--outline mc-btn--sm" href="<?php echo esc_url( mc_page_url( 'about' ) ); ?>"><?php esc_html_e( 'Learn More About Us', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/customers' ); ?>

<!-- Testimonials -->
<section class="mc-section mc-testimonials">
	<div class="mc-container mc-testimonials__grid">
		<div class="mc-testimonials__intro" data-reveal>
			<?php mc_section_label( __( 'What Our Clients Say', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Customer', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Satisfaction', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( "We are proud to be a trusted partner to businesses around the world. Here's what our clients have to say about working with us.", 'magneticcontrol' ); ?></p>
		</div>

		<div class="mc-quote" data-slider="quotes" data-reveal style="--delay:150ms">
			<?php echo mc_icon( 'quote', 'mc-quote__mark' ); ?>
			<div class="mc-quote__slides">
				<?php foreach ( $mc_testimonials as $i => $t ) : ?>
					<figure class="mc-quote__slide<?php echo 0 === $i ? ' is-active' : ''; ?>">
						<blockquote>&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
						<figcaption>
							<span class="mc-quote__avatar" aria-hidden="true"><?php echo esc_html( implode( '', array_map( function ( $w ) { return mb_substr( $w, 0, 1 ); }, explode( ' ', $t['name'] ) ) ) ); ?></span>
							<span><strong><?php echo esc_html( $t['name'] ); ?></strong><small><?php echo esc_html( $t['role'] ); ?></small></span>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
			<div class="mc-quote__nav">
				<button type="button" data-prev aria-label="<?php esc_attr_e( 'Previous testimonial', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-left' ); ?></button>
				<button type="button" data-next aria-label="<?php esc_attr_e( 'Next testimonial', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-right' ); ?></button>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
