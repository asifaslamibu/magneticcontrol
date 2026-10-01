<?php
/**
 * Careers page (slug: careers): "no vacancies" message with a CV invite.
 */

get_header();

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'Careers', 'magneticcontrol' ),
	'title'   => __( 'Build Your Career With Us', 'magneticcontrol' ),
	'lead'    => __( 'Join a team that designs and manufactures power conditioning equipment for industry leaders.', 'magneticcontrol' ),
	'image'   => 'careers-team.webp',
	'below_header' => true, // keep the back row of the team photo visible
) );
?>

<section class="mc-section">
	<div class="mc-container">
		<div class="mc-empty-state" data-reveal>
			<span class="mc-feature__icon"><?php echo mc_icon( 'handshake' ); ?></span>
			<h2><?php esc_html_e( 'No Open Positions Right Now', 'magneticcontrol' ); ?></h2>
			<p><?php esc_html_e( 'There are no vacancies at the moment, but we are always happy to hear from talented people. Send us your CV and we will be in touch when a suitable role opens up.', 'magneticcontrol' ); ?></p>
			<a class="mc-btn mc-btn--primary mc-btn--sm" href="mailto:<?php echo esc_attr( mc_contact( 'email' ) ); ?>?subject=<?php echo rawurlencode( __( 'CV submission', 'magneticcontrol' ) ); ?>"><?php echo mc_icon( 'mail' ); ?> <?php esc_html_e( 'Send Your CV', 'magneticcontrol' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
