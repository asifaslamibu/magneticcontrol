<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'magneticcontrol' ); ?></a>

<div class="mc-masthead" id="mc-masthead">
<div class="mc-topbar">
	<div class="mc-container mc-topbar__inner">
		<ul class="mc-topbar__info">
			<li><?php echo mc_icon( 'phone' ); ?><a href="<?php echo esc_url( mc_tel( mc_contact( 'phone' ) ) ); ?>"><strong><?php echo esc_html( mc_contact( 'phone' ) ); ?></strong></a></li>
			<li><a href="<?php echo esc_url( mc_tel( mc_contact( 'phone2' ) ) ); ?>"><?php echo esc_html( mc_contact( 'phone2' ) ); ?></a></li>
			<li><?php echo mc_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( mc_contact( 'email' ) ); ?>"><?php echo esc_html( mc_contact( 'email' ) ); ?></a></li>
			<li><?php echo mc_icon( 'map-pin' ); ?><?php echo esc_html( mc_contact( 'location' ) ); ?></li>
		</ul>
		<ul class="mc-topbar__social">
			<?php foreach ( array( 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn' ) as $mc_network => $mc_label ) : ?>
				<?php if ( '#' !== mc_contact( $mc_network ) ) : ?>
					<li><a href="<?php echo esc_url( mc_contact( $mc_network ) ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $mc_label ); ?>"><?php echo mc_icon( $mc_network ); ?></a></li>
				<?php endif; ?>
			<?php endforeach; ?>
			<li><a class="mc-topbar__callback" href="<?php echo esc_url( mc_callback_url() ); ?>"><?php echo mc_icon( 'phone' ); ?><?php esc_html_e( 'Request call back', 'magneticcontrol' ); ?></a></li>
		</ul>
	</div>
</div>

<header class="mc-header" id="mc-header">
	<div class="mc-container mc-header__inner">
		<?php mc_logo(); ?>

		<nav class="mc-nav" id="mc-nav" aria-label="<?php esc_attr_e( 'Primary', 'magneticcontrol' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'mc-menu',
				'fallback_cb'    => 'mc_primary_menu_fallback',
				'depth'          => 2,
			) );
			?>
			<a class="mc-btn mc-btn--outline mc-nav__cta-mobile" href="<?php echo esc_url( mc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a Quote', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
		</nav>

		<div class="mc-header__actions">
			<div class="mc-search">
				<button class="mc-search__toggle" type="button" aria-expanded="false" aria-controls="mc-search-form" aria-label="<?php esc_attr_e( 'Search', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'search' ); ?></button>
				<form class="mc-search__form" id="mc-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="mc-search-input"><?php esc_html_e( 'Search products', 'magneticcontrol' ); ?></label>
					<input id="mc-search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'Search products…', 'magneticcontrol' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
					<button type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'magneticcontrol' ); ?>"><?php echo mc_icon( 'search' ); ?></button>
				</form>
			</div>
			<a class="mc-btn mc-btn--outline mc-header__quote" href="<?php echo esc_url( mc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a Quote', 'magneticcontrol' ); ?> <?php echo mc_icon( 'arrow-right' ); ?></a>
			<button class="mc-nav-toggle" type="button" aria-controls="mc-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'magneticcontrol' ); ?>">
				<?php echo mc_icon( 'menu', 'mc-nav-toggle__open' ); ?><?php echo mc_icon( 'close', 'mc-nav-toggle__close' ); ?>
			</button>
		</div>
	</div>
</header>
</div>

<main id="main" class="mc-main">
