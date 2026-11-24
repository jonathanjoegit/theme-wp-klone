<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#080b10">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Aller au contenu</a>
<header class="site-header">
	<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="KLONE, accueil"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-transparent.png' ); ?>" alt="KLONE"></a>
	<button class="menu-toggle" id="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav">Menu <span aria-hidden="true">☰</span></button>
	<nav class="site-nav" id="site-nav" aria-label="Navigation principale">
		<a href="<?php echo esc_url( home_url( '/#music' ) ); ?>">Musique</a>
		<a href="<?php echo esc_url( home_url( '/#videos' ) ); ?>">Vidéos</a>
		<a href="<?php echo esc_url( home_url( '/#tour' ) ); ?>">Concerts</a>
		<a href="<?php echo esc_url( home_url( '/#store' ) ); ?>">Boutique</a>
		<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Contact</a>
	</nav>
	<div class="header-social" aria-label="Réseaux sociaux">
		<a href="https://www.facebook.com/KLONEBAND" target="_blank" rel="noopener noreferrer">Facebook</a>
		<a href="https://www.youtube.com/@KLONEBAND" target="_blank" rel="noopener noreferrer">YouTube</a>
	</div>
</header>
<main id="main">
