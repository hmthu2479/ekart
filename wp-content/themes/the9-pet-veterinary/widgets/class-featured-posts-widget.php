<?php
namespace The9PetVeterinary\Widgets;

use WP_Widget;

class Featured_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'the9_featured_posts_widget',
            __( '+ The9 Featured Posts', 'the9-pet-veterinary' ),
            array( 'description' => __( 'Displays featured or popular posts in a grid layout.', 'the9-pet-veterinary' ) )
        );
    }

    /**
     * Output the widget content on the front-end.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $type           = ! empty( $instance['type'] ) ? $instance['type'] : 'sticky';
        $posts_per_page = ! empty( $instance['posts_per_page'] ) ? intval( $instance['posts_per_page'] ) : 5;

        // Prepare query args
        $query_args = array(
            'posts_per_page' => $posts_per_page,
        );

        if ( 'popular' === $type ) {
            $query_args['orderby'] = 'comment_count';
            $query_args['order']   = 'DESC';
        } else {
            $sticky = (array) \get_option( 'sticky_posts', array() );
            if ( ! empty( $sticky ) ) {
                $query_args['post__in']            = $sticky;
                $query_args['ignore_sticky_posts'] = 1;
                $query_args['orderby']             = 'post__in';
            } else {
                $query_args['orderby'] = 'rand';
            }
        }

        // Use global WP_Query
        $q = new \WP_Query( $query_args );

        if ( ! $q->have_posts() ) {
            \wp_reset_postdata();
            echo $args['after_widget'];
            return;
        }

        echo '<div class="the9-featured-posts container">';
        $count = 0;

        while ( $q->have_posts() ) {
            $q->the_post();

            if ( $count === 0 ) {
                echo '<div class="the9-featured-row">';

                // Large post on the left
                echo '<div class="featured-main" style="background: url(' . \esc_url( \get_the_post_thumbnail_url( \get_the_ID(), 'large' ) ) . ') center/cover;">';
                echo '<div class="desc_wrap">';
                do_action('the9_store_meta_info', ['author','date','category']);
                echo '<h2 class="entry_title"><a href="' . \esc_url( \get_permalink() ) . '">' . \esc_html( \get_the_title() ) . '</a></h2>';
                echo '</div></div>';

                echo '<div class="featured-right">'; // Start right column
            } else {
                // Small posts stacked on right
                echo '<div class="featured-side" style="background: url(' . \esc_url( \get_the_post_thumbnail_url( \get_the_ID(), 'medium' ) ) . ') center/cover;">';
                echo '<div class="desc_wrap">';
                do_action('the9_store_meta_info', ['author','date']);
                echo '<h4 class="entry_title"><a href="' . \esc_url( \get_the_permalink() ) . '">' . \esc_html( \get_the_title() ) . '</a></h4>';
                echo '</div></div>';
            }

            $count++;

            if ( $count === 3 ) {
                echo '</div></div>'; // Close right column and row
                $count = 0;
            }
        }

        // Close unclosed divs if posts are not multiple of 3
        if ( $count !== 0 ) {
            echo '</div></div>';
        }

        echo '</div>'; // End container
        \wp_reset_postdata();

        echo $args['after_widget'];
    }

    /**
     * Widget settings form in admin.
     */
    public function form( $instance ) {
        $type           = ! empty( $instance['type'] ) ? $instance['type'] : 'sticky';
        $posts_per_page = ! empty( $instance['posts_per_page'] ) ? intval( $instance['posts_per_page'] ) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( 'Post Type:', 'the9-pet-veterinary' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
                <option value="sticky" <?php selected( $type, 'sticky' ); ?>><?php _e( 'Sticky Posts', 'the9-pet-veterinary' ); ?></option>
                <option value="popular" <?php selected( $type, 'popular' ); ?>><?php _e( 'Popular Posts', 'the9-pet-veterinary' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ); ?>"><?php _e( 'Number of posts:', 'the9-pet-veterinary' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_per_page' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $posts_per_page ); ?>" size="3" />
        </p>
        <?php
    }

    /**
     * Save widget settings.
     */
    public function update( $new_instance, $old_instance ) {
        $instance                   = [];
        $instance['type']           = ! empty( $new_instance['type'] ) ? sanitize_text_field( $new_instance['type'] ) : 'sticky';
        $instance['posts_per_page'] = ! empty( $new_instance['posts_per_page'] ) ? intval( $new_instance['posts_per_page'] ) : 5;
        return $instance;
    }

}

// Register the widget
add_action( 'widgets_init', function() {
    register_widget( \The9PetVeterinary\Widgets\Featured_Posts_Widget::class );
});
