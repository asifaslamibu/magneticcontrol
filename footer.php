</main>

<?php if ( apply_filters( 'mc_show_cta', ! ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) ) ) : ?>
<section class="mc-cta">
	<div class="mc-container mc-cta__inner">
		<div class="mc-cta__text">
			<span class="mc-cta__icon"><?php echo mc_icon( 'message' ); ?></span>
			<div>
				<h2 class="mc-cta__title"><?php esc_html_e( 'Need a Custom Solution?', 'magneticcontrol' ); ?></h2>
				<p><?php esc_html_e( "Let's discuss your project and find the right solution for your business.", 'magneticcontrol' ); ?></p>
			</div>
		</div>
		<a class="mc-btn mc-btn--white" href="<?php echo esc_url( mc_quote_url() ); ?>"><?php esc_html_e( 'Request a Quote', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
	</div>
</section>
<?php endif; ?>

<footer class="mc-footer">
	<div class="mc-container mc-footer__grid">
		<div class="mc-footer__brand">
			<?php mc_logo( 'light' ); ?>
			<ul class="mc-social">
				<?php if ( '#' !== mc_contact( 'linkedin' ) ) : ?><li><a href="<?php echo esc_url( mc_contact( 'linkedin' ) ); ?>" aria-label="LinkedIn"><?php echo mc_icon( 'linkedin' ); ?></a></li><?php endif; ?>
				<?php if ( '#' !== mc_contact( 'facebook' ) ) : ?><li><a href="<?php echo esc_url( mc_contact( 'facebook' ) ); ?>" aria-label="Facebook"><?php echo mc_icon( 'facebook' ); ?></a></li><?php endif; ?>
			</ul>
		</div>

		<div class="mc-footer__col">
			<h3><?php esc_html_e( 'Quick Links', 'magneticcontrol' ); ?></h3>
			<?php
			if ( has_nav_menu( 'footer_links' ) ) {
				wp_nav_menu( array( 'theme_location' => 'footer_links', 'container' => false, 'depth' => 1 ) );
			} else {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About Us', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'manufacturing' ) ); ?>"><?php esc_html_e( 'Manufacturing', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'blog' ) ); ?>"><?php esc_html_e( 'Blog', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'exhibition-2023' ) ); ?>"><?php esc_html_e( 'Exhibition 2023', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'annual-meeting-2024' ) ); ?>"><?php esc_html_e( 'Annual Meeting 2024', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'careers' ) ); ?>"><?php esc_html_e( 'Careers', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'magneticcontrol' ); ?></a></li>
				</ul>
			<?php } ?>
		</div>

		<div class="mc-footer__col">
			<h3><?php esc_html_e( 'Our Products', 'magneticcontrol' ); ?></h3>
			<?php
			if ( has_nav_menu( 'footer_products' ) ) {
				wp_nav_menu( array( 'theme_location' => 'footer_products', 'container' => false, 'depth' => 1 ) );
			} else {
				?>
				<ul>
					<li><a href="<?php echo esc_url( mc_shop_url() ); ?>"><?php esc_html_e( 'All Products', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_cat_url( 'industrial-transformers' ) ); ?>"><?php esc_html_e( 'Electrical Transformers', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_cat_url( 'harmonic-filters' ) ); ?>"><?php esc_html_e( 'Harmonic Filters', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_cat_url( 'drive-chokes' ) ); ?>"><?php esc_html_e( 'Drive Chokes', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_page_url( 'isolation-transformers' ) ); ?>"><?php esc_html_e( 'Isolation Transformers', 'magneticcontrol' ); ?></a></li>
					<li><a href="<?php echo esc_url( mc_quote_url() ); ?>"><?php esc_html_e( 'Custom Solutions', 'magneticcontrol' ); ?></a></li>
				</ul>
			<?php } ?>
		</div>

		<div class="mc-footer__col mc-footer__office">
			<h3><?php esc_html_e( 'Our Office', 'magneticcontrol' ); ?></h3>
			<ul>
				<li><?php echo mc_icon( 'map-pin' ); ?><span><?php echo wp_kses( mc_contact( 'address' ), array( 'br' => array() ) ); ?></span></li>
				<li><?php echo mc_icon( 'phone' ); ?><span><a href="<?php echo esc_url( mc_tel( mc_contact( 'phone' ) ) ); ?>"><?php echo esc_html( mc_contact( 'phone' ) ); ?></a><br><a href="<?php echo esc_url( mc_tel( mc_contact( 'phone2' ) ) ); ?>"><?php echo esc_html( mc_contact( 'phone2' ) ); ?></a></span></li>
				<li><?php echo mc_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( mc_contact( 'email' ) ); ?>"><?php echo esc_html( mc_contact( 'email' ) ); ?></a></li>
			</ul>
		</div>

		<div class="mc-footer__map">
			<?php get_template_part( 'template-parts/world-map' ); ?>
			<strong><?php esc_html_e( 'Global Presence', 'magneticcontrol' ); ?></strong>
			<span><?php esc_html_e( 'UK', 'magneticcontrol' ); ?> <i>|</i> <?php esc_html_e( 'KSA', 'magneticcontrol' ); ?></span>
		</div>
	</div>

	<div class="mc-container mc-footer__bottom">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Magnetic Control - All Rights Reserved.', 'magneticcontrol' ); ?></p>
		<ul>
			<li><a href="<?php echo esc_url( mc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'magneticcontrol' ); ?></a></li>
			<?php if ( get_privacy_policy_url() ) : // Only once the Privacy Policy page is published. ?>
				<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'magneticcontrol' ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
</footer>

<button class="mc-to-top" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'chevron-up' ); ?></button>

<?php wp_footer(); ?>
</body>
</html>
