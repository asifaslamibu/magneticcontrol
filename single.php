<?php
/**
 * Single blog post.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$mc_blog_id = (int) get_option( 'page_for_posts' );

	get_template_part( 'template-parts/page-hero', null, array(
		'eyebrow' => get_the_date(),
		'image'   => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'full' ) : 'hero-1.webp',
		'parents' => $mc_blog_id ? array( array( get_the_title( $mc_blog_id ), get_permalink( $mc_blog_id ) ) ) : array(),
	) );
	?>

	<div class="mc-container mc-page">
		<article <?php post_class( 'mc-page__content mc-rich' ); ?>>
			<?php
			echo mc_clean_page_content( apply_filters( 'the_content', get_the_content() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered post content.
			wp_link_pages();
			?>
		</article>

		<nav class="mc-post-nav" aria-label="<?php esc_attr_e( 'More posts', 'magneticcontrol' ); ?>">
			<?php if ( $mc_blog_id ) : ?>
				<a class="mc-btn mc-btn--outline mc-btn--sm" href="<?php echo esc_url( get_permalink( $mc_blog_id ) ); ?>"><?php echo mc_icon( 'arrow-left' ); ?> <?php esc_html_e( 'Back to Blog', 'magneticcontrol' ); ?></a>
			<?php endif; ?>
			<?php next_post_link( '%link', esc_html__( 'Next Post', 'magneticcontrol' ) . ' ' . mc_icon( 'arrow-right' ) ); ?>
		</nav>
	</div>

	<?php
endwhile;

get_footer();
