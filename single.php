<?php get_header(); while ( have_posts() ) : the_post(); ?>
<div class="page-wrap"><article class="entry"><p class="eyebrow">Actualités</p><h1><?php echo esc_html( get_the_title() ); ?></h1><p><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'class' => 'single-featured-image' ) ); } ?><?php the_content(); ?></article></div>
<?php endwhile; get_footer(); ?>
