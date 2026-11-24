<!doctype html>
<html lang="en">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#080b10">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
	<?php $logo = klone_option( 'logo', get_template_directory_uri() . '/assets/img/logo-transparent.png' ); if ( ! $logo ) { $logo = get_template_directory_uri() . '/assets/img/logo-transparent.png'; } ?>
	<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="KLONE, home"><img src="<?php echo esc_url( $logo ); ?>" alt="KLONE"></a>
	<button class="menu-toggle" id="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav">Menu <span aria-hidden="true">☰</span></button>
	<nav class="site-nav" id="site-nav" aria-label="Main navigation">
		<a href="<?php echo esc_url( klone_link_option( 'nav_music_url', '#music' ) ); ?>"><?php echo esc_html( klone_option( 'nav_music', 'Music' ) ); ?></a>
		<a href="<?php echo esc_url( klone_link_option( 'nav_videos_url', '#videos' ) ); ?>"><?php echo esc_html( klone_option( 'nav_videos', 'Videos' ) ); ?></a>
		<a href="<?php echo esc_url( klone_link_option( 'nav_tour_url', '#tour' ) ); ?>"><?php echo esc_html( klone_option( 'nav_tour', 'Tour Dates' ) ); ?></a>
		<a href="<?php echo esc_url( klone_option( 'store_url', 'https://kloneofficialshop.bigcartel.com/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'nav_store', 'Store' ) ); ?></a>
		<a href="<?php echo esc_url( klone_link_option( 'nav_newsletter_url', '#newsletter' ) ); ?>"><?php echo esc_html( klone_option( 'nav_newsletter', 'Newsletter' ) ); ?></a>
		<a href="<?php echo esc_url( klone_link_option( 'nav_contact_url', '#contact' ) ); ?>"><?php echo esc_html( klone_option( 'nav_contact', 'Contact' ) ); ?></a>
		<div class="mobile-social" aria-label="Social media"><?php klone_social_links( 'mobile' ); ?></div>
	</nav>
	<div class="header-social" aria-label="Social media">
		<?php klone_social_links( 'header' ); ?>
	</div>
</header>
<main id="main">
