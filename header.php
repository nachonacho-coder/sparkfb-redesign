<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="container header-inner">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				SPARK<span>FB</span>
			<?php endif; ?>
		</a>

		<nav class="site-nav" aria-label="Primary">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => 'main-nav',
				'container'      => false,
				'fallback_cb'    => function() {
					echo '<ul class="main-nav">
						<li><a href="/tienda">Tienda</a></li>
						<li><a href="/tienda/decks">Decks</a></li>
						<li><a href="/tienda/obstacles">Obstacles</a></li>
						<li><a href="/tienda/trucks">Trucks</a></li>
					</ul>';
				},
			] );
			?>
		</nav>

		<div class="header-actions">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="Mi cuenta">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
					<circle cx="12" cy="7" r="4"/>
				</svg>
			</a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="Carrito" class="cart-btn">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
					<line x1="3" y1="6" x2="21" y2="6"/>
					<path d="M16 10a4 4 0 0 1-8 0"/>
				</svg>
				<?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
					<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				<?php endif; ?>
			</a>
		</div>

	</div>
</header>
