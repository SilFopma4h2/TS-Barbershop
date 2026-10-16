<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="wrap header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="64" height="47">
			<?php endif; ?>
		</a>
		<button class="menu-toggle" aria-expanded="false" aria-controls="site-nav">Menu</button>
		<nav id="site-nav" class="site-nav" aria-label="Hoofdmenu">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) );
			} else {
				$home = esc_url( home_url( '/' ) );
				echo '<ul>';
				echo '<li><a href="' . $home . '#openingstijden">Openingstijden</a></li>';
				echo '<li><a href="' . esc_url( tsb_afspraak_url() ) . '">Afspraak maken</a></li>';
				echo '<li><a href="' . esc_url( home_url( '/foto-galerij/' ) ) . '">Foto galerij</a></li>';
				echo '<li><a href="' . $home . '#contactformulier">Contact</a></li>';
				echo '</ul>';
			}
			?>
		</nav>
	</div>
</header>
<main id="main">
