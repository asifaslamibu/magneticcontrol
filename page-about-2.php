<?php
/**
 * About page (slug: about-2).
 */

get_header();

$mc_uploads = wp_upload_dir()['baseurl'];

$mc_process = array(
	array( 'settings', __( 'Design', 'magneticcontrol' ), __( 'Thoroughly understanding your specific needs.', 'magneticcontrol' ) ),
	array( 'badge', __( 'Manufacture', 'magneticcontrol' ), __( 'Committed to quality.', 'magneticcontrol' ) ),
	array( 'truck', __( 'Delivery', 'magneticcontrol' ), __( 'Bringing growth through on-time delivery.', 'magneticcontrol' ) ),
);

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'About Us', 'magneticcontrol' ),
	'title'   => __( 'Driving Meaningful Change Through Technology & Design', 'magneticcontrol' ),
	'image'   => 'about.webp',
) );
?>

<!-- Mission & vision -->
<section class="mc-section mc-mv">
	<div class="mc-container mc-split">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo esc_url( $mc_uploads . '/2024/02/vision-mission.jpg' ); ?>" alt="<?php esc_attr_e( 'Puzzle pieces reading Mission and Vision', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Who We Are', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Our Mission', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( '& Vision', 'magneticcontrol' ); ?></span></h2>
			<div class="mc-mv__item">
				<span class="mc-mv__icon"><?php echo mc_icon( 'zap' ); ?></span>
				<div>
					<h3><?php esc_html_e( 'Our Mission', 'magneticcontrol' ); ?></h3>
					<p><?php esc_html_e( 'To continually develop, innovate and use the latest technologies & processes that will help us provide power supplying equipment & services meeting international standards to our customers.', 'magneticcontrol' ); ?></p>
				</div>
			</div>
			<div class="mc-mv__item">
				<span class="mc-mv__icon"><?php echo mc_icon( 'globe' ); ?></span>
				<div>
					<h3><?php esc_html_e( 'Our Vision', 'magneticcontrol' ); ?></h3>
					<p><?php esc_html_e( 'To contribute to the infrastructure development of nations in the field of power conditioning, bringing prosperity to the people and to our management.', 'magneticcontrol' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- How we work -->
<section class="mc-section mc-process">
	<div class="mc-container">
		<div class="mc-section-head">
			<?php mc_section_label( __( 'How We Work', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'From Idea to', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Installation', 'magneticcontrol' ); ?></span></h2>
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

<!-- Impact + stats -->
<section class="mc-impact">
	<div class="mc-container mc-impact__grid">
		<div data-reveal>
			<?php mc_section_label( __( 'Our Impact', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Helping Organizations Innovate, Transform', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'and Lead', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'By making an impact on the current issues that our clients face, and anticipating ones they may face in the future, we help empower them with the confidence that leads to effective decisions for their organizations.', 'magneticcontrol' ); ?></p>
			<p><?php esc_html_e( 'We have manufactured equipment for a variety of notable clients like Saudi Aramco, SABIC, L&T and more.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="<?php echo esc_url( mc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get Started', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
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

<!-- Manufacturing with excellence -->
<section class="mc-section">
	<div class="mc-container mc-split mc-split--reverse">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo esc_url( $mc_uploads . '/2024/02/excellence.jpeg' ); ?>" alt="<?php esc_attr_e( 'Wooden blocks reading vision, ideas, innovation, inspiration, passion and competence', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Our Factory', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Manufacturing With', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Excellence', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'Magnetic Control Factory is one of the leading manufacturers of power conditioning equipment with advanced technologies in Saudi Arabia. As a Saudi local manufacturer we have a large local customer base, with thousands of power conditioning units supplied over the past several years.', 'magneticcontrol' ); ?></p>
			<p><?php esc_html_e( 'We design and engineer our own products, and we are willing to take on every challenge to improve customer satisfaction.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--outline mc-btn--sm" href="<?php echo esc_url( mc_page_url( 'manufacturing' ) ); ?>"><?php esc_html_e( 'Our Manufacturing', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/customers' ); ?>

<?php
get_footer();
