<?php get_header(); $assets = get_template_directory_uri() . '/assets/img/'; ?>
<section class="hero" id="home">
	<div class="hero-backdrop" aria-hidden="true"></div>
	<div class="hero-content">
		<img class="hero-logo" src="<?php echo esc_url( $assets . 'logo-transparent.png' ); ?>" alt="KLONE">
		<p class="eyebrow">Site officiel</p>
		<div class="hero-actions">
			<a class="button" href="#music">Découvrir la musique</a>
			<a class="button button-outline" href="https://kloneofficialshop.bigcartel.com/" target="_blank" rel="noopener noreferrer">Boutique officielle ↗</a>
		</div>
	</div>
	<a class="scroll-cue" href="#music">Explorer ↓</a>
</section>

<section class="section music-section" id="music">
	<div class="wrap">
		<p class="eyebrow">01 / Musique</p><h1>Musique</h1>
		<div class="music-layout">
			<img class="album-art" src="<?php echo esc_url( $assets . 'album.jpg' ); ?>" alt="Visuel d’album KLONE fourni avec la maquette">
			<div class="section-copy">
				<p>Retrouvez la musique de KLONE sur vos plateformes d’écoute.</p>
				<a class="button" href="https://open.spotify.com/search/KLONE" target="_blank" rel="noopener noreferrer">Écouter KLONE ↗</a>
			</div>
		</div>
	</div>
</section>

<section class="section video-section" id="videos">
	<div class="wrap">
		<p class="eyebrow">02 / Regarder</p><h2>Vidéos</h2>
		<a class="video-card" href="https://www.youtube.com/@KLONEBAND" target="_blank" rel="noopener noreferrer">
			<img src="<?php echo esc_url( $assets . 'album.jpg' ); ?>" alt="">
			<span class="play-icon" aria-hidden="true">▶</span>
			<strong>Voir les vidéos de KLONE</strong>
		</a>
	</div>
</section>

<section class="section tour-section" id="tour">
	<div class="wrap tour-inner">
		<div><p class="eyebrow">03 / Sur la route</p><h2>Concerts</h2><p>Retrouvez les prochaines dates et les informations de billetterie sur Bandsintown.</p></div>
		<a class="button button-outline" href="https://www.bandsintown.com/a/211737-klone" target="_blank" rel="noopener noreferrer">Dates de concert ↗</a>
		<!-- Tu pourras remplacer ce bouton par ton code d’intégration Bandsintown. -->
	</div>
</section>

<section class="section store-section" id="store">
	<div class="wrap store-inner">
		<div><p class="eyebrow">04 / Boutique officielle</p><h2>Merch & musique</h2><p>Retrouvez les disques et produits officiels de KLONE sur la boutique du groupe.</p></div>
		<a class="button" href="https://kloneofficialshop.bigcartel.com/" target="_blank" rel="noopener noreferrer">Visiter la boutique ↗</a>
	</div>
</section>

<section class="contact-section" id="contact">
	<div class="wrap contact-inner"><div><p class="eyebrow">05 / Restons en contact</p><h2>KLONE</h2></div><a href="mailto:klonosphere@hotmail.com">Contacter le groupe ↗</a></div>
</section>
<?php get_footer(); ?>
