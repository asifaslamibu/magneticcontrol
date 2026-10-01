<?php
/**
 * Inner page hero: eyebrow, title (last word accented), lead and breadcrumb.
 *
 * @var array $args { eyebrow, title, lead, image (theme image file or full URL), below_header,
 *                    crumb (current breadcrumb label), parents (array of [label, url]) }
 */

defined( 'ABSPATH' ) || exit;

$mc_page_id = get_queried_object_id();
$mc_args    = wp_parse_args( $args, array(
	'eyebrow' => '',
	'title'   => get_the_title( $mc_page_id ),
	'lead'    => '',
	'image'   => 'products-hero.webp',
	'below_header' => false, // true: start the image under the header (keeps the top of the photo visible)
	'crumb'   => get_the_title( $mc_page_id ),
	'parents' => array_map( function ( $id ) {
		return array( get_the_title( $id ), get_permalink( $id ) );
	}, array_reverse( get_post_ancestors( $mc_page_id ) ) ),
) );

$mc_image = false !== strpos( $mc_args['image'], '://' ) ? esc_url( $mc_args['image'] ) : mc_img( $mc_args['image'] );

// Split the title so the last word gets the accent colour.
$mc_words = explode( ' ', trim( $mc_args['title'] ) );
$mc_last  = array_pop( $mc_words );
$mc_head  = implode( ' ', $mc_words );
?>
<section class="mc-page-hero<?php echo $mc_args['below_header'] ? ' mc-page-hero--below-head' : ''; ?>" style="--hero-image:url('<?php echo $mc_image; // Escaped above. ?>')">
	<div class="mc-container mc-page-hero__inner">
		<?php if ( $mc_args['eyebrow'] ) : ?>
			<?php mc_section_label( $mc_args['eyebrow'] ); ?>
		<?php endif; ?>
		<h1 class="mc-page-hero__title">
			<?php if ( $mc_head ) : ?><?php echo esc_html( $mc_head ); ?> <?php endif; ?><span class="mc-accent"><?php echo esc_html( $mc_last ); ?></span>
		</h1>
		<?php if ( $mc_args['lead'] ) : ?>
			<p class="mc-page-hero__lead"><?php echo esc_html( $mc_args['lead'] ); ?></p>
		<?php endif; ?>
		<nav class="mc-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'magneticcontrol' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo mc_icon( 'home' ); ?><?php esc_html_e( 'Home', 'magneticcontrol' ); ?></a>
			<?php foreach ( $mc_args['parents'] as $mc_parent ) : ?>
				<?php echo mc_icon( 'chevron-right' ); ?>
				<a href="<?php echo esc_url( $mc_parent[1] ); ?>"><?php echo esc_html( $mc_parent[0] ); ?></a>
			<?php endforeach; ?>
			<?php echo mc_icon( 'chevron-right' ); ?>
			<span aria-current="page"><?php echo esc_html( $mc_args['crumb'] ); ?></span>
		</nav>
	</div>
</section>
