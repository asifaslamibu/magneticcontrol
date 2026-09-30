<?php
/**
 * Fallback template.
 */

get_header();
?>
<div class="mc-page-head">
	<div class="mc-container">
		<h1><?php echo is_singular() ? esc_html( get_the_title() ) : wp_kses_post( get_the_archive_title() ? get_the_archive_title() : get_bloginfo( 'name' ) ); ?></h1>
	</div>
</div>

<div class="mc-container mc-content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'mc-entry' ); ?>>
				<?php if ( ! is_singular() ) : ?>
					<h2 class="mc-entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'magneticcontrol' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
