<?php
/**
 * About page (slug: about).
 */

get_header();

$mc_uploads = wp_upload_dir()['baseurl'];

$mc_process = array(
	array( 'settings', __( 'Design', 'magneticcontrol' ), __( 'Thoroughly understanding your specific needs.', 'magneticcontrol' ) ),
	array( 'badge', __( 'Manufacturing', 'magneticcontrol' ), __( 'Committed to quality.', 'magneticcontrol' ) ),
	array( 'truck', __( 'Delivery', 'magneticcontrol' ), __( 'Bringing growth through on-time delivery.', 'magneticcontrol' ) ),
);

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'About Us', 'magneticcontrol' ),
	'title'   => __( 'Driving Meaningful Change Through Technology & Design', 'magneticcontrol' ),
	'image'   => 'about-building.webp',
	'below_header' => true, // the factory sign is near the top of the photo
) );
?>

<!-- Who we are -->
<section class="mc-section mc-about-intro">
	<div class="mc-container">
		<div class="mc-section-head" data-reveal>
			<?php mc_section_label( __( 'Who We Are', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Low Voltage Dry Type', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Transformer Specialists', 'magneticcontrol' ); ?></span></h2>
		</div>
		<p class="mc-about-intro__text" data-reveal><?php esc_html_e( 'Magnetic Control Factory is based in Al Kharj, Saudi Arabia. We specialize in Low Voltage Dry Type Transformer. Our ethos is to constantly challenge the status quo and shape industry-redefining solutions in a tight-knit collaboration with our customers.', 'magneticcontrol' ); ?></p>
	</div>
</section>

<!-- Statistics: projects & clients -->
<section class="mc-impact">
	<div class="mc-container mc-impact__grid">
		<div data-reveal>
			<?php mc_section_label( __( 'Projects & Clients', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Manufacturing', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Excellence!', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'We have manufactured equipment for a variety of notable clients like Saudi Aramco, Sabic, L&T, etc.', 'magneticcontrol' ); ?></p>
		</div>
		<ul class="mc-impact__stats" data-reveal style="--delay:150ms">
			<?php foreach ( mc_company_stats() as $mc_stat ) : ?>
				<li>
					<strong><span data-count="<?php echo (int) $mc_stat[0]; ?>"><?php echo esc_html( number_format_i18n( $mc_stat[0] ) ); ?></span><?php echo esc_html( $mc_stat[1] ); ?></strong>
					<span><?php echo esc_html( $mc_stat[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- Engineering & manufacturing -->
<section class="mc-section">
	<div class="mc-container mc-split">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo mc_img( 'about.webp' ); ?>" alt="<?php esc_attr_e( 'Magnetic Control engineers at work in the factory', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'What We Do', 'magneticcontrol' ) ); ?>
			<ul class="mc-pillars">
				<li><span class="mc-feature__icon"><?php echo mc_icon( 'settings' ); ?></span><?php esc_html_e( 'Engineering', 'magneticcontrol' ); ?></li>
				<li><span class="mc-feature__icon"><?php echo mc_icon( 'badge' ); ?></span><?php esc_html_e( 'Manufacturing', 'magneticcontrol' ); ?></li>
			</ul>
			<p><?php esc_html_e( 'We design and engineer our own products. We are willing to take every challenge to improve customer satisfaction.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'All Services', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>
	</div>
</section>

<!-- Design / Manufacturing / Delivery -->
<section class="mc-section mc-process">
	<div class="mc-container">
		<div class="mc-section-head">
			<?php mc_section_label( __( 'How We Work', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Design, Manufacturing', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( '& Delivery', 'magneticcontrol' ); ?></span></h2>
		</div>
		<ol class="mc-process__grid">
			<?php foreach ( $mc_process as $mc_i => $mc_step ) : ?>
				<li class="mc-process__step" data-reveal style="--delay:<?php echo (int) $mc_i * 120; ?>ms">
					<span class="mc-process__num"><?php echo esc_html( sprintf( '%02d', $mc_i + 1 ) ); ?></span>
					<span class="mc-feature__icon"><?php echo mc_icon( $mc_step[0] ); ?></span>
					<h3><?php echo esc_html( $mc_step[1] ); ?></h3>
					<p><?php echo esc_html( $mc_step[2] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- Helping organizations -->
<section class="mc-section">
	<div class="mc-container mc-split mc-split--reverse">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo esc_url( $mc_uploads . '/2024/02/excellence.jpeg' ); ?>" alt="<?php esc_attr_e( 'Wooden blocks reading vision, ideas, innovation, inspiration, passion and competence', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Our Impact', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Helping Organizations Innovate, Transform', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'and Lead', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'By making an impact on the current issues that our clients face, and anticipating ones they may face in the future, we help empower them with the confidence that leads to effective decisions for their organizations.', 'magneticcontrol' ); ?></p>
		</div>
	</div>
</section>

<!-- Leading manufacturer -->
<section class="mc-section mc-section--flush-top">
	<div class="mc-container mc-split">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo esc_url( $mc_uploads . '/2024/02/2020092312200894.jpg' ); ?>" alt="<?php esc_attr_e( 'Transformer production at the Magnetic Control factory', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Our Factory', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'A Leading Saudi', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Manufacturer', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'Magnetic Control Factory is one of the leading manufacturers of power conditioning equipment with advanced technologies in Saudi Arabia. Being a Saudi Local Manufacturer we have a large local customer base with over thousands of power conditioning equipment supplied in the past several years.', 'magneticcontrol' ); ?></p>
			<p><?php esc_html_e( 'We have a passion for continuous improvement in all phases of design and manufacturing process in order to meet the requirements of a broad range of customers for even the most onerous transformer application approach to executable strategy that combines deep industry knowledge and insight. Applying the latest manufacturing advances and leading-edge test methods, we can build performance and reliability advantages into every transformer.', 'magneticcontrol' ); ?></p>
		</div>
	</div>
</section>

<!-- Dry type transformers -->
<section class="mc-section mc-offer">
	<div class="mc-container">
		<div class="mc-section-head" data-reveal>
			<?php mc_section_label( __( 'What We Offer', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Dry Type Transformers in', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Al-Kharj Industrial City', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'Kingdom of Saudi Arabia', 'magneticcontrol' ); ?></p>
		</div>
		<div class="mc-offer__grid">
			<div class="mc-offer__card" data-reveal>
				<span class="mc-feature__icon"><?php echo mc_icon( 'globe' ); ?></span>
				<p><?php esc_html_e( 'Our customers are typically large electrical power utilities, IT industries and OEM companies around worldwide. We have the latest technology strengths that include high quality designs and a genuine maintenance free operation with outstanding and lasting performance.', 'magneticcontrol' ); ?></p>
			</div>
			<div class="mc-offer__card" data-reveal style="--delay:150ms">
				<span class="mc-feature__icon"><?php echo mc_icon( 'handshake' ); ?></span>
				<p><?php esc_html_e( 'We have a facility to provide a complete range of transformer products supported by a team of qualified, skilled and dedicated engineers, technicians, supervisors and quality control. We are dedicated to the highest level of service and quality at competitive prices. We can provide all types of dry type low voltage transformer (Indoor & Outdoor application) as per the requirements of customers.', 'magneticcontrol' ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Vision & mission -->
<section class="mc-section mc-mv">
	<div class="mc-container mc-split">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo esc_url( $mc_uploads . '/2024/02/vision-mission.jpg' ); ?>" alt="<?php esc_attr_e( 'Puzzle pieces reading Mission and Vision', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Who We Are', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Our Vision', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( '& Mission', 'magneticcontrol' ); ?></span></h2>
			<div class="mc-mv__item">
				<span class="mc-mv__icon"><?php echo mc_icon( 'globe' ); ?></span>
				<div>
					<h3><?php esc_html_e( 'Our Vision', 'magneticcontrol' ); ?></h3>
					<p>&ldquo;<?php esc_html_e( 'To contribute to the infrastructure development of Nations in the field of power conditioning, this will bring prosperity to the people and to our management', 'magneticcontrol' ); ?>&rdquo;</p>
				</div>
			</div>
			<div class="mc-mv__item">
				<span class="mc-mv__icon"><?php echo mc_icon( 'zap' ); ?></span>
				<div>
					<h3><?php esc_html_e( 'Our Mission', 'magneticcontrol' ); ?></h3>
					<p><?php esc_html_e( 'To continually develop, innovate and use latest technologies & processes that will help us provide the power supplying equipment & services, meeting the international standards to our customers.', 'magneticcontrol' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/customers' ); ?>

<?php
get_footer();
