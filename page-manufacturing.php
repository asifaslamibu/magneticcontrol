<?php
/**
 * Manufacturing page (slug: manufacturing).
 */

get_header();

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'Manufacturing', 'magneticcontrol' ),
	'title'   => __( 'Manufacturing & Delivery', 'magneticcontrol' ),
	'lead'    => __( 'Performance and reliability built into every transformer we make.', 'magneticcontrol' ),
	'image'   => 'hero-3.webp',
) );
?>

<section class="mc-section">
	<div class="mc-container mc-split">
		<div class="mc-split__media" data-reveal>
			<img src="<?php echo esc_url( wp_upload_dir()['baseurl'] . '/2024/02/2020092312200894.jpg' ); ?>" alt="<?php esc_attr_e( 'Transformer production at the Magnetic Control factory', 'magneticcontrol' ); ?>" loading="lazy">
		</div>
		<div class="mc-split__content" data-reveal style="--delay:150ms">
			<?php mc_section_label( __( 'Our Process', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Built for Performance', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( '& Reliability', 'magneticcontrol' ); ?></span></h2>
			<p><?php esc_html_e( 'At Magnetic Control Factory, coils are impregnated with two complete vacuum pressure impregnation cycles. By deploying the latest manufacturing advances and leading-edge test methods, we build performance and reliability advantages into every transformer.', 'magneticcontrol' ); ?></p>
			<p><?php esc_html_e( 'Our team has a passion for continuous improvement in all phases of the design and manufacturing process, to meet the requirements of a broad range of customers for even the most onerous transformer applications.', 'magneticcontrol' ); ?></p>
		</div>
	</div>
</section>

<section class="mc-quote-band">
	<div class="mc-container">
		<?php echo mc_icon( 'quote' ); ?>
		<blockquote><?php esc_html_e( 'Quality control and continual improvement is part of everyone’s job.', 'magneticcontrol' ); ?></blockquote>
	</div>
</section>

<?php get_template_part( 'template-parts/assurance-strip' ); ?>

<?php
get_footer();
