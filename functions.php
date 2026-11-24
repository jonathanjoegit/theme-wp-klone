<?php
/**
 * KLONE — thème WordPress léger adapté depuis Klonosphere.
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
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'klone-theme', get_stylesheet_uri(), array(), $ver );
	wp_enqueue_script( 'klone-theme', get_template_directory_uri() . '/assets/js/app.js', array(), $ver, array( 'in_footer' => true, 'strategy' => 'defer' ) );
} );

add_filter( 'document_title_separator', function () { return '—'; } );
add_filter( 'pre_get_document_title', function ( $title ) {
	return is_front_page() ? 'KLONE — Site officiel' : $title;
}, 5 );
