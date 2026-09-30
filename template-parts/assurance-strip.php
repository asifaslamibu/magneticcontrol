<?php
/**
 * Four-up assurance strip shown under catalog pages.
 */

defined( 'ABSPATH' ) || exit;

$mc_items = array(
	array( 'shield-check', __( 'Quality Assured', 'magneticcontrol' ), __( 'All products meet international standards (IEC, ANSI, IEEE).', 'magneticcontrol' ) ),
	array( 'settings', __( 'Custom Solutions', 'magneticcontrol' ), __( 'Tailored designs for your specific requirements.', 'magneticcontrol' ) ),
	array( 'truck', __( 'Fast Delivery', 'magneticcontrol' ), __( 'On-time delivery across the UK and worldwide.', 'magneticcontrol' ) ),
	array( 'headset', __( 'Expert Support', 'magneticcontrol' ), __( 'Our technical team is here to help you, 24/7.', 'magneticcontrol' ) ),
);
?>
<section class="mc-container mc-assurance">
	<ul class="mc-assurance__grid">
		<?php foreach ( $mc_items as $mc_item ) : ?>
			<li class="mc-assurance__item">
				<?php echo mc_icon( $mc_item[0] ); ?>
				<div>
					<h3><?php echo esc_html( $mc_item[1] ); ?></h3>
					<p><?php echo esc_html( $mc_item[2] ); ?></p>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
