</main>
<footer class="site-footer">
	<?php $footer_logo = klone_option( 'logo', get_template_directory_uri() . '/assets/img/logo-transparent.png' ); if ( ! $footer_logo ) { $footer_logo = get_template_directory_uri() . '/assets/img/logo-transparent.png'; } ?>
	<a class="footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $footer_logo ); ?>" alt="KLONE"></a>
	<div class="footer-links">
		<a href="<?php echo esc_url( klone_option( 'store_url', 'https://kloneofficialshop.bigcartel.com/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'footer_store_label', 'Official store' ) ); ?></a>
		<a href="<?php echo esc_url( klone_option( 'tour_url', 'https://www.bandsintown.com/a/211737-klone' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( klone_option( 'footer_tour_label', 'Tour dates' ) ); ?></a>
		<a href="<?php echo esc_url( klone_link_option( 'footer_contact_url', '#contact' ) ); ?>"><?php echo esc_html( klone_option( 'footer_contact_label', 'Contact' ) ); ?></a>
	</div>
	<div class="footer-social"><?php klone_social_links( 'footer' ); ?></div>
	<small>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( klone_option( 'footer_copy', 'KLONE · Official website concept' ) ); ?></small>
</footer>
<?php wp_footer(); ?>
</body>
</html>
