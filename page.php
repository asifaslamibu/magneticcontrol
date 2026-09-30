<?php
/**
 * Default page template: page hero + content.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$mc_is_shop_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );

	get_template_part( 'template-parts/page-hero', null, array(
		'eyebrow' => $mc_is_shop_page ? __( 'Shop', 'magneticcontrol' ) : __( 'Magnetic Control', 'magneticcontrol' ),
		'lead'    => has_excerpt() ? get_the_excerpt() : '',
		'image'   => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'full' ) : 'products-hero.webp',
	) );
	?>

	<div class="mc-container mc-page">
		<article <?php post_class( 'mc-page__content mc-rich' . ( $mc_is_shop_page ? ' mc-page__content--wide' : '' ) ); ?>>
			<?php
			if ( $mc_is_shop_page ) {
				the_content();
			} else {
				echo mc_clean_page_content( apply_filters( 'the_content', get_the_content() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered post content.
			}
			wp_link_pages();
			?>
		</article>
	</div>

	<?php
endwhile;

get_footer();
