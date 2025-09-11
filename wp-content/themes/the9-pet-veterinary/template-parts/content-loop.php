<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package the9-store
 */
$full_width = 'width';
?>
<article data-aos="fade-up" id="post-<?php the_ID(); ?>" <?php post_class( array( 'the9-store-post', 'd-md-flex','side' ) ); ?>>
    <?php
    $format = get_post_format( get_the_ID() ) ? get_post_format( get_the_ID() ): 'image';

    if ( has_post_thumbnail() && $format === 'image' ) : $full_width = '';
        $post_thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
        ?>
        <div class="img-box bg-style" style="background-image: url('<?php echo esc_url( $post_thumbnail_url ); ?>'); background-position: center; background-repeat: no-repeat; background-size: cover;">
            <a href="<?php the_permalink(); ?>" class="image-link">
                <i class="icofont-image"></i><?php echo get_the_post_thumbnail( get_the_ID(), 'full' );?>
            </a>
        </div>
    <?php else : ?>

        <?php
        /**
         * Hook - the9_store_posts_blog_media.
         *
         * @hooked the9_store_posts_formats_thumbnail - 10
         */
        do_action( 'the9_store_posts_blog_media' );
        ?>

    <?php endif; ?>

    <div class="post <?php echo esc_attr($full_width);?>">
        <?php
        /**
         * Hook - the9-store_site_content_type.
         *
         * @hooked site_loop_heading - 10
         * @hooked render_meta_list  - 20
         * @hooked site_content_type - 30
         */

        $meta = array();

        if ( ! is_singular() ) :
            if ( ! the9_store_get_option( 'blog_meta_hide' ) ) {
                $meta = array( 'author', 'date' );
            }
            $meta = apply_filters( 'the9_store_blog_meta', $meta );
        endif;

        do_action( 'the9_store_site_content_type', $meta );
        ?>
    </div>

    <div class="clearfix"></div>

</article><!-- #post-<?php the_ID(); ?> -->
