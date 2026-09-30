<?php
/**
 * Contact page (slug: contact).
 */

get_header();

$mc_regions = array(
	array( __( 'Eastern Region', 'magneticcontrol' ), 'rahul@magneticcontrol.com', '+966 58 391 9411' ),
	array( __( 'Western Region', 'magneticcontrol' ), 'anas@magneticcontrol.com', '+966 56 524 2300' ),
	array( __( 'Central Region', 'magneticcontrol' ), 'munees@magneticcontrol.com', '+966 56 524 2305' ),
);

$mc_offices = array(
	array( __( 'Branch Office', 'magneticcontrol' ), wp_strip_all_tags( str_replace( '<br>', ', ', mc_contact( 'address' ) ) ), mc_contact( 'phone' ) ),
	array( __( 'Head Office', 'magneticcontrol' ), __( 'Dammam, Saudi Arabia', 'magneticcontrol' ), '+966 13 822 2155' ),
	array( __( 'Factory', 'magneticcontrol' ), __( 'Al Kharj, Saudi Arabia', 'magneticcontrol' ), '+966 56 524 2305' ),
);

// Quote links pass ?product=Name to pre-fill the subject.
$mc_product = isset( $_GET['product'] ) ? sanitize_text_field( wp_unslash( $_GET['product'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
/* translators: %s: product name */
$mc_subject = $mc_product ? sprintf( __( 'Quote request: %s', 'magneticcontrol' ), $mc_product ) : '';
$mc_sent    = isset( $_GET['sent'] ) ? sanitize_key( $_GET['sent'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$mc_tel = function ( $number ) {
	return 'tel:' . preg_replace( '/[^\d+]/', '', $number );
};

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'Contact Us', 'magneticcontrol' ),
	'title'   => __( 'Get In Touch', 'magneticcontrol' ),
	'lead'    => __( 'Please let us know if you have a question, want to leave a comment, or would like further information about Magnetic Control.', 'magneticcontrol' ),
	'image'   => 'hero-2.webp',
) );
?>

<!-- Quick contact cards -->
<section class="mc-container mc-contact-cards">
	<a class="mc-contact-card" href="<?php echo esc_url( $mc_tel( mc_contact( 'phone' ) ) ); ?>">
		<span class="mc-feature__icon"><?php echo mc_icon( 'phone' ); ?></span>
		<span><strong><?php esc_html_e( 'Call Us', 'magneticcontrol' ); ?></strong><?php echo esc_html( mc_contact( 'phone' ) ); ?></span>
	</a>
	<a class="mc-contact-card" href="mailto:<?php echo esc_attr( mc_contact( 'email' ) ); ?>">
		<span class="mc-feature__icon"><?php echo mc_icon( 'mail' ); ?></span>
		<span><strong><?php esc_html_e( 'Email Us', 'magneticcontrol' ); ?></strong><?php echo esc_html( mc_contact( 'email' ) ); ?></span>
	</a>
	<div class="mc-contact-card">
		<span class="mc-feature__icon"><?php echo mc_icon( 'clock' ); ?></span>
		<span><strong><?php esc_html_e( 'Working Hours', 'magneticcontrol' ); ?></strong><?php echo esc_html( mc_contact( 'hours' ) ); ?></span>
	</div>
</section>

<!-- Form + offices -->
<section class="mc-section mc-contact">
	<div class="mc-container mc-contact__grid">
		<div class="mc-contact__form-wrap" id="mc-contact-form">
			<?php mc_section_label( __( 'Send a Message', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'How Can We', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Help You?', 'magneticcontrol' ); ?></span></h2>

			<?php if ( '1' === $mc_sent ) : ?>
				<p class="mc-notice mc-notice--ok" role="status"><?php echo mc_icon( 'check' ); ?><?php esc_html_e( 'Thank you! Your message has been sent. We will get back to you shortly.', 'magneticcontrol' ); ?></p>
			<?php elseif ( '0' === $mc_sent ) : ?>
				<p class="mc-notice mc-notice--error" role="alert"><?php esc_html_e( 'Sorry, your message could not be sent. Please check the required fields, or email us directly.', 'magneticcontrol' ); ?></p>
			<?php endif; ?>

			<form class="mc-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="mc_contact">
				<?php wp_nonce_field( 'mc_contact', 'mc_contact_nonce' ); ?>
				<div class="mc-form__hp" aria-hidden="true">
					<label for="mc-website"><?php esc_html_e( 'Website', 'magneticcontrol' ); ?></label>
					<input type="text" id="mc-website" name="mc_website" tabindex="-1" autocomplete="off">
				</div>

				<div class="mc-form__row">
					<p class="mc-form__field">
						<label for="mc-name"><?php esc_html_e( 'Full Name', 'magneticcontrol' ); ?> <abbr title="<?php esc_attr_e( 'required', 'magneticcontrol' ); ?>">*</abbr></label>
						<input type="text" id="mc-name" name="mc_name" required autocomplete="name">
					</p>
					<p class="mc-form__field">
						<label for="mc-email"><?php esc_html_e( 'Email Address', 'magneticcontrol' ); ?> <abbr title="<?php esc_attr_e( 'required', 'magneticcontrol' ); ?>">*</abbr></label>
						<input type="email" id="mc-email" name="mc_email" required autocomplete="email">
					</p>
				</div>
				<div class="mc-form__row">
					<p class="mc-form__field">
						<label for="mc-phone"><?php esc_html_e( 'Phone', 'magneticcontrol' ); ?></label>
						<input type="tel" id="mc-phone" name="mc_phone" autocomplete="tel">
					</p>
					<p class="mc-form__field">
						<label for="mc-company"><?php esc_html_e( 'Company', 'magneticcontrol' ); ?></label>
						<input type="text" id="mc-company" name="mc_company" autocomplete="organization">
					</p>
				</div>
				<p class="mc-form__field">
					<label for="mc-subject"><?php esc_html_e( 'Subject', 'magneticcontrol' ); ?></label>
					<input type="text" id="mc-subject" name="mc_subject" value="<?php echo esc_attr( $mc_subject ); ?>">
				</p>
				<p class="mc-form__field">
					<label for="mc-message"><?php esc_html_e( 'Message', 'magneticcontrol' ); ?> <abbr title="<?php esc_attr_e( 'required', 'magneticcontrol' ); ?>">*</abbr></label>
					<textarea id="mc-message" name="mc_message" rows="6" required></textarea>
				</p>
				<button type="submit" class="mc-btn mc-btn--primary"><?php esc_html_e( 'Send Message', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></button>
			</form>
		</div>

		<aside class="mc-contact__side">
			<div class="mc-contact__box">
				<h3><?php echo mc_icon( 'headset' ); ?><?php esc_html_e( 'Sales Inquiry', 'magneticcontrol' ); ?></h3>
				<ul class="mc-contact__list">
					<?php foreach ( $mc_regions as $mc_region ) : ?>
						<li>
							<strong><?php echo esc_html( $mc_region[0] ); ?></strong>
							<a href="mailto:<?php echo esc_attr( $mc_region[1] ); ?>"><?php echo mc_icon( 'mail' ); ?><?php echo esc_html( $mc_region[1] ); ?></a>
							<a href="<?php echo esc_url( $mc_tel( $mc_region[2] ) ); ?>"><?php echo mc_icon( 'phone' ); ?><?php echo esc_html( $mc_region[2] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="mc-contact__box">
				<h3><?php echo mc_icon( 'map-pin' ); ?><?php esc_html_e( 'Our Offices', 'magneticcontrol' ); ?></h3>
				<ul class="mc-contact__list">
					<?php foreach ( $mc_offices as $mc_office ) : ?>
						<li>
							<strong><?php echo esc_html( $mc_office[0] ); ?></strong>
							<span><?php echo mc_icon( 'map-pin' ); ?><?php echo esc_html( $mc_office[1] ); ?></span>
							<a href="<?php echo esc_url( $mc_tel( $mc_office[2] ) ); ?>"><?php echo mc_icon( 'phone' ); ?><?php echo esc_html( $mc_office[2] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</aside>
	</div>
</section>

<!-- Map -->
<section class="mc-container mc-map">
	<iframe title="<?php esc_attr_e( 'Map of our UK office', 'magneticcontrol' ); ?>" src="https://www.google.com/maps?q=<?php echo rawurlencode( wp_strip_all_tags( str_replace( '<br>', ', ', mc_contact( 'address' ) ) ) ); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<?php
// The footer's "Request a Quote" band would just link back to this page.
add_filter( 'mc_show_cta', '__return_false' );

get_footer();
