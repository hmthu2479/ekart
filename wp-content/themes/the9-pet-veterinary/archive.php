<?php
/**
 * Archive template
 *
 * Displays archive pages (categories, tags, dates, custom taxonomies).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package the9-store
 */

get_header();

$layout = the9_store_get_option( 'blog_layout' );

/**
 * Hook: container_wrap_start
 *
 * @hooked the9_store_container_wrap_start - 5
 */
do_action( 'the9_store_container_wrap_start', esc_attr( $layout ) );
?>

<?php if ( have_posts() ) : 
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', 'loop' );
        endwhile;
         the_posts_navigation(); ?>

<?php else : ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

<?php
/**
 * Hook: container_wrap_end
 *
 * @hooked the9_store_container_wrap_end - 999
 */
do_action( 'the9_store_container_wrap_end', esc_attr( $layout ) );

get_footer();
