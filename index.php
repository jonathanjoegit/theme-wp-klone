<?php get_header(); ?>
<div class="page-wrap"><h1 class="page-title">Actualités</h1>
<?php if ( have_posts() ) : ?><div class="post-list"><?php while ( have_posts() ) : the_post(); ?><article><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p></article><?php endwhile; ?></div><?php the_posts_pagination(); else : ?><p>Aucune actualité pour le moment.</p><?php endif; ?></div>
<?php get_footer(); ?>
