<?php get_header(); while ( have_posts() ) : the_post(); ?>
<div class="page-wrap"><article class="entry"><h1><?php echo esc_html( get_the_title() ); ?></h1><?php the_content(); ?></article></div>
<?php endwhile; get_footer(); ?>
