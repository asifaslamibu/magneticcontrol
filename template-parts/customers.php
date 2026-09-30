<?php
/**
 * "Our Customers" logo carousel (homepage, About page).
 */

defined( 'ABSPATH' ) || exit;

// Client logos in wp-content/uploads/2024/04 (file => name).
$mc_partners = array(
	'zain-1.png'             => 'Zain',
	'snb-1.jpg'              => 'SNB',
	'schem-1.png'            => 'SCHEM',
	'saudi-aramco-1.png'     => 'Saudi Aramco',
	'sadara-1.jpg'           => 'Sadara',
	'sabic-1.png'            => 'SABIC',
	'sab-1.png'              => 'SAB',
	'riyad-1.png'            => 'Riyad Bank',
	'rcjy-1.png'             => 'RCJY',
	'rcjy-1.jpg'             => 'RCJY',
	'petro-rabigh-1.png'     => 'Petro Rabigh',
	'moi-1.png'              => 'Ministry of Interior',
	'moh-1.png'              => 'Ministry of Health',
	'mobily-1.jpg'           => 'Mobily',
	'marafiq-1.png'          => 'Marafiq',
	'Ma_aden_Logo_-_2-1.png' => "Ma'aden",
	'justice-1.png'          => 'Ministry of Justice',
	'gaca-1.png'             => 'GACA',
	'emirates-nbd-1.png'     => 'Emirates NBD',
	'cluster-2-1.png'        => 'Cluster2',
	'baj-1.png'              => 'BAJ',
	'stc-1.jpg'              => 'stc',
	'farabi-1.jpg'           => 'Farabi',
	'redsea-1.jpg'           => 'Red Sea',
);
$mc_partner_url = wp_upload_dir()['baseurl'] . '/2024/04/';
?>
<section class="mc-partners" id="customers">
	<div class="mc-container">
		<?php mc_section_label( __( 'Our Customers', 'magneticcontrol' ), true ); ?>
		<div class="mc-partners__carousel" data-carousel>
			<button type="button" class="mc-partners__arrow" data-prev aria-label="<?php esc_attr_e( 'Previous customers', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-left' ); ?></button>
			<div class="mc-partners__viewport">
				<ul class="mc-partners__track">
					<?php foreach ( array_keys( $mc_partners ) as $mc_i => $file ) : ?>
						<?php // The first six are visible straight away; the rest load as the carousel nears them. ?>
						<li class="mc-partner"><img src="<?php echo esc_url( $mc_partner_url . $file ); ?>" alt="<?php echo esc_attr( $mc_partners[ $file ] ); ?>" decoding="async" height="100"<?php echo $mc_i >= 6 ? ' loading="lazy"' : ''; ?>></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<button type="button" class="mc-partners__arrow" data-next aria-label="<?php esc_attr_e( 'Next customers', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-right' ); ?></button>
		</div>
	</div>
</section>
