<?php
/**
 * Main template file
 *
 * Displays the default page when no more specific template is available.
 * Handles the blog home page if home.php is missing.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package the9-store
 */

get_header();

$layout = the9_store_get_option( 'blog_layout' );

/**
 * Hook: the9_store_container_wrap_start
 *
 * @hooked the9_store_container_wrap_start - 5
 */
do_action( 'the9_store_container_wrap_start', esc_attr( $layout ) );

if ( have_posts() ) :

    if ( is_home() && ! is_front_page() ) : ?>
        <header>
            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
        </header>
    <?php endif;
    /* Start the Loop */
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content', 'loop' );
    endwhile;

    /**
     * Hook: the9_store_loop_navigation
     *
     * @hooked site_loop_navigation - 10
     */
    do_action( 'the9_store_loop_navigation' );

else :
    get_template_part( 'template-parts/content', 'none' );
endif;

/**
 * Hook: the9_store_container_wrap_end
 *
 * @hooked container_wrap_end - 999
 */
do_action( 'the9_store_container_wrap_end', esc_attr( $layout ) );

get_footer();
