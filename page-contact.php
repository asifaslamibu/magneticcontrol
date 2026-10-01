<?php
/**
 * Contact page (slug: contact).
 */

get_header();

$mc_regions = mc_sales_regions();

// Each office: name, address, then contact lines as [icon, text, link].
$mc_offices = array(
	array(
		__( 'Head Office', 'magneticcontrol' ),
		__( '202, Itaam Business Center, Al Hussam, Dammam 32222', 'magneticcontrol' ),
		array(
			array( 'phone', __( 'Tel.:', 'magneticcontrol' ) . ' ' . mc_contact( 'phone2' ), mc_tel( mc_contact( 'phone2' ) ) ),
			array( 'phone', __( 'Mobile:', 'magneticcontrol' ) . ' ' . mc_contact( 'phone' ), mc_tel( mc_contact( 'phone' ) ) ),
			array( 'mail', mc_contact( 'email' ), 'mailto:' . mc_contact( 'email' ) ),
		),
	),
	array( __( 'Factory', 'magneticcontrol' ), wp_strip_all_tags( str_replace( '<br>', ', ', mc_contact( 'address' ) ) ), array() ),
	array( __( 'UK Branch', 'magneticcontrol' ), __( 'Leicestershire, United Kingdom', 'magneticcontrol' ), array() ),
);

// Quote links pass ?enquiry=Product Name to pre-fill the subject. (Not ?product=: that is
// WooCommerce's product query var and would load this page with the wrong template.)
$mc_product = isset( $_GET['enquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['enquiry'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
/* translators: %s: product name */
$mc_subject = $mc_product ? sprintf( __( 'Quote request: %s', 'magneticcontrol' ), $mc_product ) : '';
// "Request call back" (top bar) links here with ?callback=1.
if ( ! $mc_subject && ! empty( $_GET['callback'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$mc_subject = __( 'Call back request', 'magneticcontrol' );
}
$mc_sent    = isset( $_GET['sent'] ) ? sanitize_key( $_GET['sent'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended


get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'Contact Us', 'magneticcontrol' ),
	'title'   => __( 'Get In Touch', 'magneticcontrol' ),
	'lead'    => __( 'Please let us know if you have a question, want to leave a comment, or would like further information about Magnetic Control.', 'magneticcontrol' ),
	'image'   => 'contact-banner.webp',
) );
?>

<!-- Quick contact cards -->
<section class="mc-container mc-contact-cards">
	<a class="mc-contact-card" href="<?php echo esc_url( mc_tel( mc_contact( 'phone' ) ) ); ?>">
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

<!-- KSA contact details first: regional sales, then offices -->
<section class="mc-section mc-reach">
	<div class="mc-container">
		<div class="mc-section-head">
			<?php mc_section_label( __( 'Sales Inquiry', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Talk to Our', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Regional Sales Team', 'magneticcontrol' ); ?></span></h2>
		</div>
		<ul class="mc-reach__grid">
			<?php foreach ( $mc_regions as $mc_region ) : ?>
				<li class="mc-reach__card">
					<span class="mc-feature__icon"><?php echo mc_icon( 'headset' ); ?></span>
					<h3><?php echo esc_html( $mc_region['label'] ); ?></h3>
					<a href="<?php echo esc_url( mc_tel( $mc_region['phone'] ) ); ?>"><?php echo mc_icon( 'phone' ); ?><?php echo esc_html( $mc_region['phone'] ); ?></a>
					<a href="mailto:<?php echo esc_attr( $mc_region['email'] ); ?>"><?php echo mc_icon( 'mail' ); ?><?php echo esc_html( $mc_region['email'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="mc-section-head mc-reach__head">
			<?php mc_section_label( __( 'Contact Us', 'magneticcontrol' ), true ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'Our', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Offices', 'magneticcontrol' ); ?></span></h2>
		</div>
		<ul class="mc-reach__grid">
			<?php foreach ( $mc_offices as $mc_office ) : ?>
				<li class="mc-reach__card">
					<span class="mc-feature__icon"><?php echo mc_icon( 'map-pin' ); ?></span>
					<h3><?php echo esc_html( $mc_office[0] ); ?></h3>
					<p><?php echo esc_html( $mc_office[1] ); ?></p>
					<?php foreach ( $mc_office[2] as $mc_line ) : ?>
						<a href="<?php echo esc_url( $mc_line[2] ); ?>"><?php echo mc_icon( $mc_line[0] ); ?><?php echo esc_html( $mc_line[1] ); ?></a>
					<?php endforeach; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- Form + map -->
<section class="mc-section mc-contact">
	<div class="mc-container mc-contact__grid">
		<div class="mc-contact__form-wrap" id="mc-contact-form">
			<?php mc_section_label( __( 'Send a Message', 'magneticcontrol' ) ); ?>
			<h2 class="mc-heading"><?php esc_html_e( 'How Can We', 'magneticcontrol' ); ?> <span class="mc-accent"><?php esc_html_e( 'Help You?', 'magneticcontrol' ); ?></span></h2>

			<?php if ( '1' === $mc_sent ) : ?>
				<p class="mc-notice mc-notice--ok" role="status"><?php echo mc_icon( 'check' ); ?><?php esc_html_e( 'Thank you! Your message has been sent. We will get back to you shortly.', 'magneticcontrol' ); ?></p>
			<?php elseif ( 'captcha' === $mc_sent ) : ?>
				<p class="mc-notice mc-notice--error" role="alert"><?php esc_html_e( 'The security check answer was not correct. Please try again.', 'magneticcontrol' ); ?></p>
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
					<label for="mc-region"><?php esc_html_e( 'Your Region', 'magneticcontrol' ); ?></label>
					<select id="mc-region" name="mc_region">
						<option value=""><?php esc_html_e( 'General enquiry (Sales team)', 'magneticcontrol' ); ?></option>
						<?php foreach ( $mc_regions as $mc_key => $mc_region ) : ?>
							<option value="<?php echo esc_attr( $mc_key ); ?>"><?php echo esc_html( $mc_region['label'] ); ?></option>
						<?php endforeach; ?>
					</select>
					<small class="mc-form__hint"><?php esc_html_e( 'Your message goes to our sales team, with the sales person for your region in copy.', 'magneticcontrol' ); ?></small>
				</p>
				<p class="mc-form__field">
					<label for="mc-subject"><?php esc_html_e( 'Subject', 'magneticcontrol' ); ?></label>
					<input type="text" id="mc-subject" name="mc_subject" value="<?php echo esc_attr( $mc_subject ); ?>">
				</p>
				<p class="mc-form__field">
					<label for="mc-message"><?php esc_html_e( 'Message', 'magneticcontrol' ); ?> <abbr title="<?php esc_attr_e( 'required', 'magneticcontrol' ); ?>">*</abbr></label>
					<textarea id="mc-message" name="mc_message" rows="6" required></textarea>
				</p>
				<?php $mc_captcha = mc_captcha(); ?>
				<p class="mc-form__field mc-form__captcha">
					<?php /* translators: %s: arithmetic question, e.g. "4 + 7" */ ?>
					<label for="mc-captcha"><?php echo esc_html( sprintf( __( 'Security check: what is %s?', 'magneticcontrol' ), $mc_captcha['question'] ) ); ?> <abbr title="<?php esc_attr_e( 'required', 'magneticcontrol' ); ?>">*</abbr></label>
					<input type="text" id="mc-captcha" name="mc_captcha" inputmode="numeric" autocomplete="off" required>
					<input type="hidden" name="mc_captcha_token" value="<?php echo esc_attr( $mc_captcha['token'] ); ?>">
				</p>
				<button type="submit" class="mc-btn mc-btn--primary"><?php esc_html_e( 'Send Message', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></button>
			</form>
		</div>

		<div class="mc-map">
			<iframe title="<?php esc_attr_e( 'Map of our factory in Al Kharj', 'magneticcontrol' ); ?>" src="https://www.google.com/maps?q=<?php echo rawurlencode( wp_strip_all_tags( str_replace( '<br>', ', ', mc_contact( 'address' ) ) ) ); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	</div>
</section>

<?php
// The footer's "Request a Quote" band would just link back to this page.
add_filter( 'mc_show_cta', '__return_false' );

get_footer();
