<?php
get_header();
$assets = get_template_directory_uri() . '/assets/img/';
$logo = klone_option( 'logo', $assets . 'logo-transparent.png' );
if ( ! $logo ) { $logo = $assets . 'logo-transparent.png'; }
$hero_image = klone_option( 'hero_image', $assets . 'album.jpg' );
if ( ! $hero_image ) { $hero_image = $assets . 'album.jpg'; }
$album_image = klone_option( 'album_image', $assets . 'album.jpg' );
if ( ! $album_image ) { $album_image = $assets . 'album.jpg'; }
$tracks = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', klone_option( 'album_tracks', "Emergence\nWavering\nUnchained\nMirage\nThe Guardian Of Your Sun\nMoonlight\nSeeds Of Silence\nMolt\nLost Horizon" ) ) ) );
?>
<?php if ( klone_enabled( 'show_hero' ) ) : ?><section class="hero" id="home">
	<div class="hero-backdrop" aria-hidden="true" style="background-image:linear-gradient(180deg,#080b10b5 0%,#080b1033 36%,#050911e8 100%),url('<?php echo esc_url( $hero_image ); ?>')"></div>
	<div class="hero-content">
		<img class="hero-logo" src="<?php echo esc_url( $logo ); ?>" alt="KLONE">
		<p class="hero-kicker"><?php echo esc_html( klone_option( 'hero_kicker', 'The new album' ) ); ?></p>
		<h1><?php echo esc_html( klone_option( 'hero_title', 'The Moon Is Witness' ) ); ?></h1>
		<p class="hero-date"><?php echo esc_html( klone_option( 'hero_date', 'March 12, 2027 · V2 Records' ) ); ?></p>
		<div class="hero-actions">
			<a class="button" href="<?php echo esc_url( klone_link_option( 'hero_music_url', '#music' ) ); ?>"><?php echo esc_html( klone_option( 'hero_music_label', 'Discover the album' ) ); ?></a>
			<a class="button button-presave" href="<?php echo esc_url( klone_option( 'presave_url', 'https://orcd.co/the-moon-is-witness-klone' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'presave_label', 'Pre-save the new album' ) ); ?> ↗</a>
			<a class="button button-outline" href="<?php echo esc_url( klone_option( 'store_url', 'https://kloneofficialshop.bigcartel.com/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'hero_store_label', 'Music & merch' ) ); ?> ↗</a>
		</div>
	</div>
	<a class="scroll-cue" href="#music"><?php echo esc_html( klone_option( 'hero_scroll_label', 'Explore' ) ); ?> ↓</a>
</section><?php endif; ?>

<?php if ( klone_enabled( 'show_music' ) ) : ?>
<section class="section music-section" id="music"><div class="wrap">
	<p class="eyebrow"><?php echo esc_html( klone_option( 'album_eyebrow', '01 / The new record' ) ); ?></p><h2><?php echo esc_html( klone_option( 'album_heading', 'Music' ) ); ?></h2>
	<div class="music-layout"><img class="album-art" src="<?php echo esc_url( $album_image ); ?>" alt="<?php echo esc_attr( klone_option( 'album_title', 'The Moon Is Witness' ) ); ?> album artwork">
			<div class="section-copy"><div class="release-label"><?php echo esc_html( klone_option( 'album_release', '12 March 2027 · V2 Records' ) ); ?></div>
			<h3><?php echo esc_html( klone_option( 'album_title', 'The Moon Is Witness' ) ); ?></h3>
			<p><?php echo esc_html( klone_option( 'album_description', 'Nine tracks exploring the space between light and darkness. Produced by Francis Castes. Available on vinyl LP and CD digipack.' ) ); ?></p>
			<?php if ( $tracks ) : ?><ol class="tracklist"><?php foreach ( $tracks as $i => $track ) : ?><li><span><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><?php echo esc_html( $track ); ?></li><?php endforeach; ?></ol><?php endif; ?>
			<a href="<?php echo esc_url( klone_link_option( 'music_url', '#store' ) ); ?>" class="button"><?php echo esc_html( klone_option( 'music_button', 'Explore editions' ) ); ?> ↗</a>
		</div>
	</div>
</div></section>
<?php endif; ?>

<?php if ( klone_enabled( 'show_videos' ) ) : ?>
<section class="section video-section" id="videos"><div class="wrap">
	<header class="section-head"><div><p class="eyebrow"><?php echo esc_html( klone_option( 'videos_eyebrow', '02 / Watch' ) ); ?></p><h2><?php echo esc_html( klone_option( 'videos_heading', 'Videos' ) ); ?></h2></div><p><?php echo esc_html( klone_option( 'videos_intro', 'Official music videos, visualizers and live performances.' ) ); ?></p></header>
	<div class="videos-grid">
		<?php for ( $i = 1; $i <= 3; $i++ ) :
			$video_defaults = array(
				1 => array( 'Unchained', 'Visualizer · October 23, 2026', 'https://www.youtube.com/@KLONEBAND' ),
				2 => array( 'Mirage', 'Official video · Coming soon', 'https://www.youtube.com/@KLONEBAND' ),
				3 => array( 'Live at Motocultor', 'Live performance', 'https://www.youtube.com/watch?v=hmJmMVVC3Zk' ),
			);
			$title = klone_option( "video_{$i}_title", $video_defaults[ $i ][0] );
			$label = klone_option( "video_{$i}_label", $video_defaults[ $i ][1] );
			$url = klone_option( "video_{$i}_url", $video_defaults[ $i ][2] );
			$image = klone_option( "video_{$i}_image", $album_image );
			if ( ! $image ) { $image = $album_image; }
			$embed_html = klone_option( "video_{$i}_embed", '' );
			$youtube_id = klone_youtube_video_id( $url );
		?>
		<?php if ( $embed_html ) : ?><div class="video-embed"><div class="video-embed-frame"><?php echo $embed_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Admin/editor-provided YouTube embed code. ?></div><div class="video-info-static"><small><?php echo esc_html( $label ); ?></small><h3><?php echo esc_html( $title ); ?></h3></div></div>
		<?php elseif ( $youtube_id ) : ?><div class="video-embed"><div class="video-embed-frame"><?php echo klone_youtube_iframe( $youtube_id, $title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Constructed iframe from a validated YouTube video ID. ?></div><div class="video-info-static"><small><?php echo esc_html( $label ); ?></small><h3><?php echo esc_html( $title ); ?></h3></div></div>
		<?php else : ?><a class="video-card" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy"><span class="play-icon" aria-hidden="true">▶</span><span class="video-info"><small><?php echo esc_html( $label ); ?></small><h3><?php echo esc_html( $title ); ?></h3></span></a><?php endif; ?>
		<?php endfor; ?>
	</div><p class="notice"><?php echo esc_html( klone_option( 'videos_note', 'Update video titles, labels, thumbnails and YouTube links here.' ) ); ?></p>
</div></section>
<?php endif; ?>

<?php if ( klone_enabled( 'show_tour' ) ) : ?>
<section class="section tour-section" id="tour"><div class="wrap tour-inner">
	<div><p class="eyebrow"><?php echo esc_html( klone_option( 'tour_eyebrow', '03 / On the road' ) ); ?></p><h2><?php echo esc_html( klone_option( 'tour_heading', 'Tour Dates' ) ); ?></h2><p><?php echo esc_html( klone_option( 'tour_intro', 'Upcoming shows, cities and ticket information.' ) ); ?></p></div>
	<div class="tour-status"><strong><?php echo esc_html( klone_option( 'tour_status', '2026 / 2027 — SHOW ANNOUNCEMENTS COMING SOON' ) ); ?></strong><p><?php echo esc_html( klone_option( 'tour_description', 'Confirmed concerts and official ticket links will appear here once the touring schedule is validated.' ) ); ?></p>
		<?php $songkick_html = klone_option( 'tour_embed_html', '' ); if ( $songkick_html ) : ?><div class="tour-embed"><?php echo $songkick_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Admin/editor-provided Songkick widget code. ?></div><?php endif; ?>
		<a class="button button-outline" href="<?php echo esc_url( klone_option( 'tour_url', 'https://www.songkick.com/artists/487951-klone' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'tour_button', 'Get tour updates' ) ); ?> ↗</a>
	</div>
</div></section>
<?php endif; ?>

<?php if ( klone_enabled( 'show_store' ) ) : ?>
<section class="section store-section" id="store"><div class="wrap store-inner">
	<div><p class="eyebrow"><?php echo esc_html( klone_option( 'store_eyebrow', '04 / Official merch' ) ); ?></p><h2><?php echo esc_html( klone_option( 'store_heading', 'Store' ) ); ?></h2><p><?php echo esc_html( klone_option( 'store_description', 'Records, vinyl and official KLONE apparel.' ) ); ?></p></div>
	<a class="button" href="<?php echo esc_url( klone_option( 'store_url', 'https://kloneofficialshop.bigcartel.com/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'store_button', 'Visit the store' ) ); ?> ↗</a>
</div></section>
<?php endif; ?>

<?php if ( klone_enabled( 'show_newsletter' ) ) : ?>
<section class="section subscribe" id="newsletter"><div class="wrap">
	<p class="eyebrow"><?php echo esc_html( klone_option( 'newsletter_eyebrow', '05 / Stay in touch' ) ); ?></p><h2><?php echo esc_html( klone_option( 'newsletter_heading', 'Subscribe' ) ); ?></h2>
	<p><?php echo esc_html( klone_option( 'newsletter_description', 'New music. Videos. Tour dates. Merch drops. Straight to your inbox.' ) ); ?></p>
	<p class="newsletter-note"><?php echo esc_html( klone_option( 'newsletter_note', 'Demo form: no addresses are collected. To launch, connect a mailing list provider, privacy policy and subscription consent.' ) ); ?></p>
	<?php $newsletter_html = klone_option( 'newsletter_embed_html', '' ); if ( $newsletter_html ) : ?><div class="newsletter-embed"><?php echo $newsletter_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Admin/editor-provided newsletter form code. ?></div><?php endif; ?>
</div></section>
<?php endif; ?>

<?php if ( klone_enabled( 'show_contact' ) ) : ?>
<section class="section contact-section" id="contact"><div class="wrap">
	<header class="section-head"><div><p class="eyebrow"><?php echo esc_html( klone_option( 'contact_eyebrow', '06 / Get in touch' ) ); ?></p><h2><?php echo esc_html( klone_option( 'contact_heading', 'Contact' ) ); ?></h2></div><div class="contact-social"><?php klone_social_links( 'contact' ); ?></div></header>
	<div class="contacts-grid">
	<?php for ( $i = 1; $i <= 4; $i++ ) :
		$contact_defaults = array(
			1 => array( 'Management', 'Klonosphere', 'Management and general enquiries', 'klonosphere@hotmail.com' ),
			2 => array( 'Record label', 'V2 Records', 'New album, label and distribution enquiries', 'Direct email to be confirmed' ),
			3 => array( 'Booking / France', 'BASE PROD', 'French live dates and festivals', 'Direct email to be confirmed' ),
			4 => array( 'Booking / International', 'International booking', 'Worldwide live dates and festivals', 'Agency details to be confirmed' ),
		);
		$role = klone_option( "contact_{$i}_role", $contact_defaults[ $i ][0] );
		$name = klone_option( "contact_{$i}_name", $contact_defaults[ $i ][1] );
		$description = klone_option( "contact_{$i}_description", $contact_defaults[ $i ][2] );
		$email = klone_option( "contact_{$i}_email", $contact_defaults[ $i ][3] );
	?>
	<article class="contact-card"><small><?php echo esc_html( $role ); ?></small><h3><?php echo esc_html( $name ); ?></h3><p><?php echo esc_html( $description ); ?></p><?php if ( is_email( $email ) ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php else : ?><span><?php echo esc_html( $email ); ?></span><?php endif; ?></article>
	<?php endfor; ?>
	</div>
</div></section>
<?php endif; ?>
<?php get_footer(); ?>
