<?php
/**
 * KLONE — thème adapté de la base WordPress Klonosphere.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'klone', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	set_post_thumbnail_size( 1200, 630, true );
} );

add_action( 'wp_enqueue_scripts', function () {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'klone-theme', get_stylesheet_uri(), array(), $version );
	wp_enqueue_script( 'klone-theme', get_template_directory_uri() . '/assets/js/app.js', array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
} );

/** Return a saved text or URL setting, with its supplied initial value. */
function klone_option( $key, $default = '' ) {
	$value = get_theme_mod( 'klone_' . $key, $default );
	return is_string( $value ) ? $value : $default;
}
function klone_enabled( $key, $default = true ) {
	return (bool) get_theme_mod( 'klone_' . $key, $default );
}
function klone_link_option( $key, $default = '' ) {
	$url = klone_option( $key, $default );
	if ( '' === $url ) { return ''; }
	if ( 0 === strpos( $url, '#' ) ) { return home_url( '/' ) . $url; }
	if ( wp_parse_url( $url, PHP_URL_SCHEME ) ) { return $url; }
	return home_url( $url );
}
function klone_sanitize_embed_markup( $value ) {
	return is_string( $value ) ? trim( $value ) : '';
}
/** Make Songkick's embedded widget use the site's dark palette, including previously saved embed code. */
function klone_songkick_markup( $markup ) {
	if ( ! is_string( $markup ) || '' === trim( $markup ) ) { return ''; }
	$attributes = array(
		'data-theme' => 'dark',
		'data-detect-style' => 'off',
		'data-background-color' => 'rgba(8,11,16,1)',
		'data-font-color' => 'rgba(243,240,236,1)',
		'data-button-bg-color' => 'rgba(181,155,100,1)',
		'data-button-text-color' => 'rgba(8,11,16,1)',
	);
	foreach ( $attributes as $name => $value ) {
		$quoted_name = preg_quote( $name, '/' );
		if ( preg_match( '/\\b' . $quoted_name . '\\s*=\\s*"[^"]*"/i', $markup ) ) {
			$markup = preg_replace( '/\\b' . $quoted_name . '\\s*=\\s*"[^"]*"/i', $name . '="' . $value . '"', $markup, 1 );
		} else {
			$markup = preg_replace( '/<a\\b/i', '<a ' . $name . '="' . $value . '"', $markup, 1 );
		}
	}
	return $markup;
}
function klone_youtube_video_id( $url ) {
	$host = strtolower( (string) wp_parse_url( $url, PHP_URL_HOST ) );
	$path = (string) wp_parse_url( $url, PHP_URL_PATH );
	if ( ! in_array( $host, array( 'youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtu.be', 'www.youtu.be', 'youtube-nocookie.com', 'www.youtube-nocookie.com' ), true ) ) { return ''; }
	$id = '';
	if ( 'youtu.be' === $host || 'www.youtu.be' === $host ) {
		$id = trim( $path, '/' );
	} else {
		parse_str( (string) wp_parse_url( $url, PHP_URL_QUERY ), $query );
		if ( ! empty( $query['v'] ) ) { $id = $query['v']; }
		elseif ( preg_match( '#^/(?:embed|shorts|live)/([A-Za-z0-9_-]{6,20})#', $path, $matches ) ) { $id = $matches[1]; }
	}
	return preg_match( '/^[A-Za-z0-9_-]{6,20}$/', $id ) ? $id : '';
}
function klone_youtube_iframe( $id, $title ) {
	if ( ! preg_match( '/^[A-Za-z0-9_-]{6,20}$/', $id ) ) { return ''; }
	return sprintf( '<iframe src="https://www.youtube-nocookie.com/embed/%1$s?rel=0" title="%2$s" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>', esc_attr( $id ), esc_attr( $title ) );
}
function klone_social_links( $context = 'header' ) {
	$networks = array(
		'facebook' => array( 'Facebook', 'https://www.facebook.com/KLONEBAND', '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11" fill="#1877f2"/><path fill="#fff" d="M13.7 21v-8h2.7l.4-3.1h-3.1V8c0-.9.3-1.5 1.6-1.5H17V3.7c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.1H7.5V13h2.8v8z"/></svg>' ),
		'instagram' => array( 'Instagram', 'https://www.instagram.com/', '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/></svg>' ),
		'spotify' => array( 'Spotify', 'https://open.spotify.com/search/KLONE', '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11" fill="#1ed760"/><path d="M5.5 9c4.5-1.4 9.7-.8 13.3 1.3M6.5 12c3.7-1.1 8-.6 11 1.1M7.3 15c2.8-.8 5.9-.4 8.2.8" fill="none" stroke="#07120b" stroke-width="1.6" stroke-linecap="round"/></svg>' ),
		'youtube' => array( 'YouTube', 'https://www.youtube.com/@KLONEBAND', '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#f00" d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8Z"/><path fill="#fff" d="m9.6 15.6 6.2-3.6-6.2-3.6z"/></svg>' ),
		'tiktok' => array( 'TikTok', '#', '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#25f4ee" d="M19.6 7.1a6.8 6.8 0 0 1-4.1-1.4v9.1a6.1 6.1 0 1 1-5.3-6.1v3.2a2.9 2.9 0 1 0 2.1 2.8V2.5h3.2c.3 2.3 1.8 4.1 4.1 4.5z"/><path fill="#fe2c55" d="M18.1 8.6a6.7 6.7 0 0 1-2.6-1.1v8.7a6.1 6.1 0 1 1-5.3-6.1v3.2a2.9 2.9 0 1 0 2.1 2.8V4.9h3.2c.3 1.8 1.2 3 2.6 3.7z"/><path fill="#fff" d="M17.9 7.2a6.7 6.7 0 0 1-2.4-3.1h-2.3v11.4a2.9 2.9 0 1 1-2.9-2.9c.4 0 .8.1 1.1.2V9.5a6.1 6.1 0 1 0 5 6V8.8c.8.5 1.7.8 2.7.9V7.3z"/></svg>' ),
	);
	foreach ( $networks as $key => $network ) {
		$url = klone_option( 'social_' . $key, $network[1] );
		if ( ! klone_enabled( 'social_' . $key . '_show', true ) || '' === $url ) { continue; }
		printf( '<a class="social-icon social-%1$s" href="%2$s" target="_blank" rel="noopener noreferrer" aria-label="%3$s" title="%3$s">%4$s</a>', esc_attr( $key ), esc_url( $url ), esc_attr( $network[0] ), $network[2] );
	}
}

add_filter( 'document_title_separator', function () { return '—'; } );
add_filter( 'pre_get_document_title', function ( $title ) {
	return is_front_page() ? 'KLONE — Official Website' : $title;
}, 5 );

// Keep the original theme's editor-friendly permission for changing site settings.
add_action( 'after_switch_theme', function () {
	foreach ( array( get_role( 'editor' ), get_role( 'administrator' ) ) as $role ) {
		if ( $role && ! $role->has_cap( 'edit_klo_site_content' ) ) { $role->add_cap( 'edit_klo_site_content' ); }
	}
} );
// Recheck on admin requests as well: upgrades do not always fire after_switch_theme.
add_action( 'admin_init', function () {
	$wp_roles = wp_roles();
	foreach ( $wp_roles->role_objects as $role ) {
		if ( $role->has_cap( 'edit_pages' ) && ! $role->has_cap( 'edit_klo_site_content' ) ) {
			$role->add_cap( 'edit_klo_site_content' );
		}
	}
} );
add_action( 'switch_theme', function () {
	$wp_roles = wp_roles();
	foreach ( $wp_roles->role_objects as $role ) {
		if ( $role->has_cap( 'edit_klo_site_content' ) ) { $role->remove_cap( 'edit_klo_site_content' ); }
	}
} );
add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id ) {
	if ( 'customize' === $cap && user_can( $user_id, 'edit_klo_site_content' ) ) { return array( 'edit_klo_site_content' ); }
	return $caps;
}, 10, 3 );

/** Complete editable field map shared by the Customizer and the KLONE settings screen. */
function klone_content_fields() {
	return array(
		'branding' => array( 'Identité et menu', array(
			'logo' => array( 'Logo KLONE', 'image', get_template_directory_uri() . '/assets/img/logo-transparent.png' ),
			'hero_kicker' => array( 'Texte au-dessus du titre', 'text', 'The new album' ),
			'hero_title' => array( 'Titre principal', 'text', 'The Moon Is Witness' ),
			'hero_date' => array( 'Date / label sous le titre', 'text', 'March 12, 2027 · V2 Records' ),
			'hero_image' => array( 'Image de fond de l’accueil', 'image', get_template_directory_uri() . '/assets/img/album.jpg' ),
			'hero_music_label' => array( 'Bouton accueil : musique', 'text', 'Discover the album' ),
			'hero_music_url' => array( 'Bouton accueil : lien musique', 'url', '#music' ),
			'hero_store_label' => array( 'Bouton accueil : boutique', 'text', 'Music & merch' ),
			'hero_scroll_label' => array( 'Indication pour faire défiler', 'text', 'Explore' ),
			'nav_music' => array( 'Menu : musique', 'text', 'Music' ), 'nav_music_url' => array( 'Menu : destination musique', 'url', '#music' ),
			'nav_videos' => array( 'Menu : vidéos', 'text', 'Videos' ), 'nav_videos_url' => array( 'Menu : destination vidéos', 'url', '#videos' ),
			'nav_tour' => array( 'Menu : dates', 'text', 'Tour Dates' ), 'nav_tour_url' => array( 'Menu : destination dates', 'url', '#tour' ),
			'nav_store' => array( 'Menu : boutique (lien direct vers le store)', 'text', 'Store' ),
			'nav_newsletter' => array( 'Menu : newsletter', 'text', 'Newsletter' ), 'nav_newsletter_url' => array( 'Menu : destination newsletter', 'url', '#newsletter' ),
			'nav_contact' => array( 'Menu : contact', 'text', 'Contact' ), 'nav_contact_url' => array( 'Menu : destination contact', 'url', '#contact' ),
			'show_hero' => array( 'Afficher la section d’accueil', 'checkbox', true ),
			'show_music' => array( 'Afficher la section musique', 'checkbox', true ),
			'show_videos' => array( 'Afficher la section vidéos', 'checkbox', true ),
			'show_tour' => array( 'Afficher la section dates', 'checkbox', true ),
			'show_store' => array( 'Afficher la section boutique', 'checkbox', true ),
			'show_newsletter' => array( 'Afficher la section newsletter', 'checkbox', true ),
			'show_contact' => array( 'Afficher la section contact', 'checkbox', true ),
		) ),
		'album' => array( 'Album', array(
			'album_eyebrow' => array( 'Petit titre', 'text', '01 / The new record' ),
			'album_heading' => array( 'Titre de section', 'text', 'Music' ),
			'album_title' => array( 'Titre de l’album', 'text', 'The Moon Is Witness' ),
			'album_release' => array( 'Date de sortie et label', 'text', '12 March 2027 · V2 Records' ),
			'album_description' => array( 'Présentation de l’album', 'textarea', 'Nine tracks exploring the space between light and darkness. Produced by Francis Castes. Available on vinyl LP and CD digipack.' ),
			'album_tracks' => array( 'Liste des titres (un titre par ligne)', 'textarea', "Emergence\nWavering\nUnchained\nMirage\nThe Guardian Of Your Sun\nMoonlight\nSeeds Of Silence\nMolt\nLost Horizon" ),
			'album_image' => array( 'Pochette de l’album', 'image', get_template_directory_uri() . '/assets/img/album.jpg' ),
			'music_url' => array( 'Lien du bouton éditions', 'url', '#store' ),
			'music_button' => array( 'Texte du bouton', 'text', 'Explore editions' ),
			'presave_label' => array( 'Texte du bouton pré-enregistrement', 'text', 'Pre-save the new album' ),
			'presave_url' => array( 'Lien du pré-enregistrement', 'url', 'https://orcd.co/the-moon-is-witness-klone' ),
		) ),
		'videos' => array( 'Vidéos YouTube', array(
			'videos_eyebrow' => array( 'Petit titre', 'text', '02 / Watch' ), 'videos_heading' => array( 'Titre de section', 'text', 'Videos' ), 'videos_intro' => array( 'Texte d’introduction', 'textarea', 'Official music videos, visualizers and live performances.' ),
			'video_1_title' => array( 'Vidéo 1 : titre', 'text', 'Unchained' ), 'video_1_label' => array( 'Vidéo 1 : type / date', 'text', 'Visualizer · October 23, 2026' ), 'video_1_url' => array( 'Vidéo 1 : lien YouTube (une URL de vidéo crée un lecteur intégré)', 'url', 'https://www.youtube.com/@KLONEBAND' ), 'video_1_embed' => array( 'Vidéo 1 : code HTML YouTube (facultatif)', 'html', '' ), 'video_1_image' => array( 'Vidéo 1 : miniature', 'image', get_template_directory_uri() . '/assets/img/album.jpg' ),
			'video_2_title' => array( 'Vidéo 2 : titre', 'text', 'Mirage' ), 'video_2_label' => array( 'Vidéo 2 : type / date', 'text', 'Official video · Coming soon' ), 'video_2_url' => array( 'Vidéo 2 : lien YouTube (une URL de vidéo crée un lecteur intégré)', 'url', 'https://www.youtube.com/@KLONEBAND' ), 'video_2_embed' => array( 'Vidéo 2 : code HTML YouTube (facultatif)', 'html', '' ), 'video_2_image' => array( 'Vidéo 2 : miniature', 'image', get_template_directory_uri() . '/assets/img/album.jpg' ),
			'video_3_title' => array( 'Vidéo 3 : titre', 'text', 'Live at Motocultor' ), 'video_3_label' => array( 'Vidéo 3 : type / date', 'text', 'Live performance' ), 'video_3_url' => array( 'Vidéo 3 : lien YouTube', 'url', 'https://www.youtube.com/watch?v=hmJmMVVC3Zk' ), 'video_3_embed' => array( 'Vidéo 3 : code HTML YouTube (facultatif)', 'html', '' ), 'video_3_image' => array( 'Vidéo 3 : miniature', 'image', get_template_directory_uri() . '/assets/img/album.jpg' ),
			'videos_note' => array( 'Texte sous les vidéos', 'textarea', 'Update video titles, labels, thumbnails and YouTube links here.' ),
		) ),
		'tour' => array( 'Dates de concert', array(
			'tour_eyebrow' => array( 'Petit titre', 'text', '03 / On the road' ), 'tour_heading' => array( 'Titre de section', 'text', 'Tour Dates' ), 'tour_intro' => array( 'Texte à côté du titre', 'textarea', 'Upcoming shows, cities and ticket information.' ),
			'tour_status' => array( 'Message / statut', 'text', '2026 / 2027 — SHOW ANNOUNCEMENTS COMING SOON' ), 'tour_description' => array( 'Texte sous le statut', 'textarea', 'Confirmed concerts and official ticket links will appear here once the touring schedule is validated.' ),
			'tour_button' => array( 'Texte du bouton', 'text', 'Get tour updates' ), 'tour_url' => array( 'Lien vers Songkick', 'url', 'https://www.songkick.com/artists/487951-klone' ),
			'tour_embed_html' => array( 'Code HTML Songkick', 'html', '<a href="https://www.songkick.com/artists/487951-klone" class="songkick-widget" data-theme="dark" data-track-button="on" data-detect-style="off" data-background-color="rgba(8,11,16,1)" data-font-color="rgba(243,240,236,1)" data-button-bg-color="rgba(181,155,100,1)" data-button-text-color="rgba(8,11,16,1)" data-locale="en" data-other-artists="on" data-share-button="on" data-country-filter="on" data-rsvp="on" data-request-show="on" data-past-events="on" data-past-events-offtour="on" data-remind-me="off" style="display:none;"></a><script src="//widget-app.songkick.com/injector/10240683"></script>' ),
		) ),
		'store' => array( 'Boutique externe', array(
			'store_eyebrow' => array( 'Petit titre', 'text', '04 / Official merch' ), 'store_heading' => array( 'Titre de section', 'text', 'Store' ), 'store_description' => array( 'Texte de la section', 'textarea', 'Records, vinyl and official KLONE apparel.' ), 'store_button' => array( 'Texte du bouton (section)', 'text', 'Visit the store' ),
			'store_url' => array( 'Lien Big Cartel (section et menu)', 'url', 'https://kloneofficialshop.bigcartel.com/' ),
		) ),
		'newsletter' => array( 'Newsletter (formulaire à ajouter plus tard)', array(
			'newsletter_eyebrow' => array( 'Petit titre', 'text', '05 / Stay in touch' ), 'newsletter_heading' => array( 'Titre de section', 'text', 'Subscribe' ), 'newsletter_description' => array( 'Texte éditable (tu ajouteras le formulaire plus tard)', 'textarea', 'New music. Videos. Tour dates. Merch drops. Straight to your inbox.' ), 'newsletter_note' => array( 'Texte complémentaire', 'textarea', 'Demo form: no addresses are collected. To launch, connect a mailing list provider, privacy policy and subscription consent.' ), 'newsletter_embed_html' => array( 'Code HTML formulaire newsletter (à ajouter plus tard)', 'html', '' ),
		) ),
		'contacts' => array( 'Contacts et réseaux sociaux', array(
			'contact_eyebrow' => array( 'Petit titre', 'text', '06 / Get in touch' ), 'contact_heading' => array( 'Titre de section', 'text', 'Contact' ),
			'contact_1_role' => array( 'Contact 1 : catégorie', 'text', 'Management' ), 'contact_1_name' => array( 'Contact 1 : nom', 'text', 'Klonosphere' ), 'contact_1_description' => array( 'Contact 1 : description', 'text', 'Management and general enquiries' ), 'contact_1_email' => array( 'Contact 1 : e-mail ou mention', 'text', 'klonosphere@hotmail.com' ),
			'contact_2_role' => array( 'Contact 2 : catégorie', 'text', 'Record label' ), 'contact_2_name' => array( 'Contact 2 : nom', 'text', 'V2 Records' ), 'contact_2_description' => array( 'Contact 2 : description', 'text', 'New album, label and distribution enquiries' ), 'contact_2_email' => array( 'Contact 2 : e-mail ou mention', 'text', 'Direct email to be confirmed' ),
			'contact_3_role' => array( 'Contact 3 : catégorie', 'text', 'Booking / France' ), 'contact_3_name' => array( 'Contact 3 : nom', 'text', 'BASE PROD' ), 'contact_3_description' => array( 'Contact 3 : description', 'text', 'French live dates and festivals' ), 'contact_3_email' => array( 'Contact 3 : e-mail ou mention', 'text', 'Direct email to be confirmed' ),
			'contact_4_role' => array( 'Contact 4 : catégorie', 'text', 'Booking / International' ), 'contact_4_name' => array( 'Contact 4 : nom', 'text', 'International booking' ), 'contact_4_description' => array( 'Contact 4 : description', 'text', 'Worldwide live dates and festivals' ), 'contact_4_email' => array( 'Contact 4 : e-mail ou mention', 'text', 'Agency details to be confirmed' ),
			'social_facebook_show' => array( 'Afficher Facebook', 'checkbox', true ), 'social_facebook' => array( 'Facebook URL', 'url', 'https://www.facebook.com/KLONEBAND' ),
			'social_instagram_show' => array( 'Afficher Instagram', 'checkbox', true ), 'social_instagram' => array( 'Instagram URL', 'url', 'https://www.instagram.com/' ),
			'social_spotify_show' => array( 'Afficher Spotify', 'checkbox', true ), 'social_spotify' => array( 'Spotify URL', 'url', 'https://open.spotify.com/search/KLONE' ),
			'social_youtube_show' => array( 'Afficher YouTube', 'checkbox', true ), 'social_youtube' => array( 'YouTube URL', 'url', 'https://www.youtube.com/@KLONEBAND' ),
			'social_tiktok_show' => array( 'Afficher TikTok', 'checkbox', true ), 'social_tiktok' => array( 'TikTok URL', 'url', '#' ),
		) ),
		'footer' => array( 'Pied de page', array(
			'footer_copy' => array( 'Texte de copyright (l’année reste automatique)', 'text', 'KLONE · Official website concept' ),
			'footer_store_label' => array( 'Lien boutique', 'text', 'Official store' ), 'footer_tour_label' => array( 'Lien dates', 'text', 'Tour dates' ), 'footer_contact_label' => array( 'Lien contact', 'text', 'Contact' ), 'footer_contact_url' => array( 'Destination du lien contact', 'url', '#contact' ),
		) ),
	);
}

add_action( 'customize_register', function ( $customize ) {
	$customize->add_panel( 'klone_content', array(
		'title' => 'Contenu KLONE', 'priority' => 30, 'capability' => 'edit_klo_site_content',
	) );
	$fields = klone_content_fields();
	foreach ( $fields as $section_id => $section ) {
		$customize->add_section( 'klone_' . $section_id, array( 'title' => $section[0], 'panel' => 'klone_content', 'capability' => 'edit_klo_site_content' ) );
		foreach ( $section[1] as $key => $field ) {
			$type = $field[1];
			$sanitize = 'html' === $type ? 'klone_sanitize_embed_markup' : ( 'url' === $type || 'image' === $type ? 'esc_url_raw' : ( 'checkbox' === $type ? 'rest_sanitize_boolean' : ( 'textarea' === $type ? 'sanitize_textarea_field' : 'sanitize_text_field' ) ) );
			$customize->add_setting( 'klone_' . $key, array( 'default' => $field[2], 'capability' => 'edit_klo_site_content', 'sanitize_callback' => $sanitize ) );
			$control_type = 'html' === $type ? 'textarea' : $type;
			$customize->add_control( 'klone_' . $key, array( 'label' => $field[0], 'section' => 'klone_' . $section_id, 'type' => $control_type, 'capability' => 'edit_klo_site_content' ) );
		}
	}
} );

add_action( 'admin_menu', function () {
	add_menu_page( 'Guide KLONE', 'Guide du site', 'edit_posts', 'klone-guide', 'klone_admin_guide', 'dashicons-welcome-learn-more', 4 );
	add_submenu_page( 'klone-guide', 'Modifier le site KLONE', 'Modifier le site', 'edit_klo_site_content', 'klone-content', 'klone_site_settings_page' );
	add_submenu_page( 'klone-guide', 'Personnaliser le site KLONE', 'Aperçu personnalisé', 'edit_klo_site_content', 'klone-customizer', 'klone_open_customizer' );
} );

function klone_open_customizer() {
	if ( ! current_user_can( 'edit_klo_site_content' ) ) { wp_die( 'Vous n’avez pas l’autorisation de modifier le site.' ); }
	wp_safe_redirect( admin_url( 'customize.php?autofocus[panel]=klone_content' ) );
	exit;
}

function klone_save_site_content() {
	if ( ! current_user_can( 'edit_klo_site_content' ) ) { wp_die( 'Vous n’avez pas l’autorisation de modifier le site.' ); }
	check_admin_referer( 'klone_save_site_content' );
	$posted = isset( $_POST['klone_settings'] ) && is_array( $_POST['klone_settings'] ) ? wp_unslash( $_POST['klone_settings'] ) : array();
	foreach ( klone_content_fields() as $section ) {
		foreach ( $section[1] as $key => $field ) {
			$type = $field[1];
			if ( 'checkbox' === $type ) {
				$value = isset( $posted[ $key ] ) ? 1 : 0;
			} elseif ( isset( $posted[ $key ] ) && is_scalar( $posted[ $key ] ) ) {
				$raw = (string) $posted[ $key ];
				if ( 'html' === $type ) { $value = klone_sanitize_embed_markup( $raw ); }
				elseif ( 'image' === $type || 'url' === $type ) { $value = esc_url_raw( $raw ); }
				elseif ( 'textarea' === $type ) { $value = sanitize_textarea_field( $raw ); }
				else { $value = sanitize_text_field( $raw ); }
			} else {
				continue;
			}
			set_theme_mod( 'klone_' . $key, $value );
		}
	}
	wp_safe_redirect( add_query_arg( array( 'page' => 'klone-content', 'updated' => '1' ), admin_url( 'admin.php' ) ) );
	exit;
}
add_action( 'admin_post_klone_save_site_content', 'klone_save_site_content' );

function klone_site_settings_page() {
	if ( ! current_user_can( 'edit_klo_site_content' ) ) { wp_die( 'Vous n’avez pas l’autorisation de modifier le site.' ); }
	$sections = klone_content_fields();
	?>
	<div class="wrap">
		<h1>Modifier le site KLONE</h1>
		<p>Modifie les textes, images et liens ci-dessous, puis clique sur « Enregistrer ». Les changements s’appliquent aussi à l’aperçu personnalisé.</p>
		<?php if ( isset( $_GET['updated'] ) ) : ?><div class="notice notice-success is-dismissible"><p>Les réglages du site ont été enregistrés.</p></div><?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="klone_save_site_content">
			<?php wp_nonce_field( 'klone_save_site_content' ); ?>
			<?php foreach ( $sections as $section_id => $section ) : ?>
				<section id="klone_<?php echo esc_attr( $section_id ); ?>" style="background:#fff;border:1px solid #dcdcde;padding:20px 24px;margin:22px 0;max-width:1100px">
					<h2 style="margin-top:0"><?php echo esc_html( $section[0] ); ?></h2>
					<?php foreach ( $section[1] as $key => $field ) :
						$type = $field[1];
						$value = get_theme_mod( 'klone_' . $key, $field[2] );
						$name = 'klone_settings[' . $key . ']';
						$id = 'klone-setting-' . $key;
					?>
					<div style="margin:18px 0;max-width:760px">
						<label for="<?php echo esc_attr( $id ); ?>" style="display:block;font-weight:600;margin-bottom:6px"><?php echo esc_html( $field[0] ); ?></label>
						<?php if ( 'checkbox' === $type ) : ?>
							<input id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" type="checkbox" value="1" <?php checked( (bool) $value ); ?>>
						<?php elseif ( 'textarea' === $type || 'html' === $type ) : ?>
							<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="<?php echo 'html' === $type ? 9 : 4; ?>" class="large-text <?php echo 'html' === $type ? 'code' : ''; ?>"><?php echo esc_textarea( (string) $value ); ?></textarea>
						<?php elseif ( 'image' === $type ) : ?>
							<div style="display:flex;gap:8px;align-items:center"><input id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" type="url" value="<?php echo esc_attr( (string) $value ); ?>" class="regular-text klone-image-input"><button type="button" class="button klone-choose-image">Choisir une image</button></div>
							<?php if ( $value ) : ?><img src="<?php echo esc_url( $value ); ?>" alt="" style="display:block;max-width:220px;max-height:110px;object-fit:contain;margin-top:8px" class="klone-image-preview"><?php else : ?><img src="" alt="" style="display:none;max-width:220px;max-height:110px;object-fit:contain;margin-top:8px" class="klone-image-preview"><?php endif; ?>
						<?php elseif ( 'url' === $type ) : ?>
							<input id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" type="text" value="<?php echo esc_attr( (string) $value ); ?>" class="regular-text" placeholder="https://… ou #section">
						<?php else : ?>
							<input id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" type="text" value="<?php echo esc_attr( (string) $value ); ?>" class="regular-text">
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
				</section>
			<?php endforeach; ?>
			<?php submit_button( 'Enregistrer les modifications' ); ?>
		</form>
	</div>
	<?php
}

add_action( 'admin_enqueue_scripts', function () {
	if ( empty( $_GET['page'] ) || 'klone-content' !== sanitize_key( wp_unslash( $_GET['page'] ) ) ) { return; }
	wp_enqueue_media();
	wp_enqueue_script( 'klone-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
} );

function klone_admin_guide() {
	if ( ! current_user_can( 'edit_posts' ) ) { return; }
	$cards = array(
		array( 'Identité, menu et sections', 'klone_branding', 'Modifier le logo, les textes de l’accueil, les libellés et liens du menu, et afficher ou masquer les sections.' ),
		array( 'Album', 'klone_album', 'Changer le visuel, le titre, la date, le texte, la liste des pistes et le bouton de pré-enregistrement.' ),
		array( 'Vidéos YouTube', 'klone_videos', 'Modifier les titres, les miniatures et les liens. Une URL de vidéo ou un code iframe crée un vrai lecteur intégré.' ),
		array( 'Dates et boutique', 'klone_tour', 'Modifier le texte, le lien et le code HTML Songkick. La boutique est un lien direct vers Big Cartel.' ),
		array( 'Newsletter', 'klone_newsletter', 'Modifier le texte et coller plus tard le code HTML du formulaire newsletter.' ),
		array( 'Contacts et réseaux sociaux', 'klone_contacts', 'Modifier les coordonnées et les liens sociaux affichés dans l’en-tête, la section Contact et le pied de page.' ),
		array( 'Pied de page', 'klone_footer', 'Modifier les libellés et le texte de copyright.' ),
	);
	echo '<div class="wrap"><h1>Bienvenue dans l’administration de KLONE</h1><p>Les réglages du site se trouvent dans « Modifier le site ». Les pages et les articles restent modifiables depuis l’éditeur WordPress.</p><p><a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=klone-content' ) ) . '">Ouvrir les réglages KLONE</a></p><div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;max-width:1100px">';
	foreach ( $cards as $card ) {
		$url = admin_url( 'admin.php?page=klone-content#klone_' . $card[1] );
		printf( '<section style="background:#fff;border:1px solid #dcdcde;padding:20px"><h2 style="margin-top:0;font-size:18px"><a href="%1$s">%2$s →</a></h2><p>%3$s</p></section>', esc_url( $url ), esc_html( $card[0] ), esc_html( $card[2] ) );
	}
	echo '</div><p style="margin-top:24px">Le code HTML Songkick et le futur formulaire newsletter se modifient dans leurs rubriques. Les rôles Administrateur et Éditeur ont accès à ces réglages.</p></div>';
}
