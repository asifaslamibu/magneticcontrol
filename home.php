<?php
/**
 * Blog posts page (Settings → Reading → Posts page).
 */

get_header();

get_template_part( 'template-parts/page-hero', null, array(
	'eyebrow' => __( 'News & Insights', 'magneticcontrol' ),
	'lead'    => __( 'Industry insights, company news and updates from Magnetic Control.', 'magneticcontrol' ),
	'image'   => 'hero-1.webp',
) );
?>

<div class="mc-container mc-page">
	<?php if ( have_posts() ) : ?>
		<ul class="mc-posts">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<li <?php post_class( 'mc-post-card' ); ?>>
					<a class="mc-post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<img src="<?php echo mc_img( 'products-hero.webp' ); ?>" alt="" loading="lazy">
						<?php endif; ?>
					</a>
					<div class="mc-post-card__body">
						<p class="mc-post-card__meta"><?php echo mc_icon( 'clock' ); ?><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
						<h2 class="mc-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
						<a class="mc-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>

		<?php
		the_posts_pagination( array(
			'class'     => 'mc-pagination',
			'prev_text' => mc_icon( 'arrow-left' ) . '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'magneticcontrol' ) . '</span>',
			'next_text' => mc_icon( 'arrow-right' ) . '<span class="screen-reader-text">' . esc_html__( 'Next page', 'magneticcontrol' ) . '</span>',
		) );
		?>
	<?php else : ?>
		<div class="mc-empty-state">
			<h2><?php esc_html_e( 'No posts yet', 'magneticcontrol' ); ?></h2>
			<p><?php esc_html_e( 'Check back soon for news and insights.', 'magneticcontrol' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
