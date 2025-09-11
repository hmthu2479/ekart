<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'the9_pet_veterinary_theme_setup' ) ) :
/**
 * Child theme setup: Load translations, add theme support, and override defaults.
 *
 * @since 1.0.0
 * @return void
 */
function the9_pet_veterinary_theme_setup() {

    // Make theme available for translation.
    load_theme_textdomain( 'the9-pet-veterinary', get_stylesheet_directory() . '/languages' );

    // Add custom header support with default arguments.
    add_theme_support( 'custom-header', apply_filters( 'the9_pet_veterinary_custom_header_args', array(
        'default-image'      => get_stylesheet_directory_uri() . '/assets/images/custom-header.jpg',
        'default-text-color' => '000000',
        'width'              => 1000,
        'height'             => 350,
        'flex-height'        => true,
        'wp-head-callback'   => 'the9_store_header_style',
    ) ) );

    // Register default header images.
    register_default_headers( array(
        'default-image' => array(
            'url'           => '%s/assets/images/custom-header.jpg',
            'thumbnail_url' => '%s/assets/images/custom-header.jpg',
            'description'   => esc_html__( 'Default Header Image', 'the9-pet-veterinary' ),
        ),
    ) );

    // Remove parent theme's starter content.
    remove_action( 'after_setup_theme', 'the9_store_customizer_starter_content' );
}
add_action( 'after_setup_theme', 'the9_pet_veterinary_theme_setup' );
endif;

if ( !function_exists( 'the9_pet_veterinary_parent_scripts' ) ):
    function the9_pet_veterinary_parent_scripts() {
        wp_enqueue_style( 'the9_pet_veterinary_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap','bi-icons','icofont','scrollbar','aos','the9-store-common' ) );

        $custom_css = ':root {--primary-color:'.esc_attr( get_theme_mod('__primary_color','#000') ).'!important; --secondary-color: '.esc_attr( get_theme_mod('__secondary_color','#FF4907') ).'!important; --nav-h-color:'.esc_attr( get_theme_mod('__secondary_color','#FF4907') ).'!important;}';
        
        wp_add_inline_style( 'the9_pet_veterinary_parent', $custom_css );

        
        wp_enqueue_script( 'masonry' );

        wp_enqueue_script( 'the9-pet-veterinary-js', get_theme_file_uri( '/assets/the9-pet-veterinary.js'), array(),  wp_get_theme()->get('Version'), true);
    }
endif;
add_action( 'wp_enqueue_scripts', 'the9_pet_veterinary_parent_scripts', 10 );


if ( ! function_exists( 'the9_pet_veterinary_override_parent_hooks' ) ) :
/**
 * Remove specific actions from the parent theme to allow custom replacements.
 *
 * @since 1.0.0
 * @return void
 */
function the9_pet_veterinary_override_parent_hooks() {
    global $the9_store_header_layout, $the9_store_post_related, $the9_store_footer_layout;

    // Remove default header elements from parent theme
    remove_action( 'the9_store_site_header', array( $the9_store_header_layout, 'site_header_layout' ), 30 );
    remove_action( 'the9_store_site_header', array( $the9_store_header_layout, 'get_site_navigation' ), 40 );
    remove_action( 'the9_store_site_header', array( $the9_store_header_layout, 'site_hero_sections' ), 9999 );

    // Remove default post heading in loop
    remove_action( 'the9_store_site_content_type', array( $the9_store_post_related, 'site_loop_heading' ), 20 );

    // Remove default footer info section
    remove_action( 'the9_store_site_footer', array( $the9_store_footer_layout, 'site_footer_info' ), 80 );
}
add_action( 'wp', 'the9_pet_veterinary_override_parent_hooks', 10 );
endif;



if( !function_exists('the9_pet_veterinary_header') ):
/**
 * Disable parent theme actions and add custom ones.
 *
 * @return void
 */
function the9_pet_veterinary_header() {
    global $the9_store_header_layout;
    ?>
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    
                    <!-- Branding / Logo -->
                    <?php do_action('the9_store_header_layout_1_branding'); ?>
                    
                    <!-- Navigation Menu -->
                    <?php $the9_store_header_layout->get_site_navigation(); ?>
                    
                </div>
            </div>
        </div>
    </header>
    <?php
}
add_action('the9_store_site_header', 'the9_pet_veterinary_header', 30);
endif;

if( !function_exists('the9_pet_veterinary_hero_sections') ):
/**
 * Get the hero sections for different templates.
 *
 * @return void
 */
function the9_pet_veterinary_hero_sections() {
    // Do not show on 404 pages
    if ( is_404() ) {
        return;
    }

    // Show slider on front page if active
    if ( is_front_page() && is_active_sidebar( 'slider' ) ) {
        dynamic_sidebar( 'slider' );
        return;
    } elseif ( is_post_type_archive('post') || is_home()  ) {
        // Display Featured Posts Widget automatically
        the_widget( 
            'The9PetVeterinary\Widgets\Featured_Posts_Widget', 
            array(
                'type'           => 'sticky',  // or 'popular'
                'posts_per_page' => 3
            )
        );
        return;
    }

    $height = ( is_front_page() || is_home() ) ? 'homepage' : '';
    $header_image = get_header_image();
    ?>
    <div id="static_header_banner" class="header-img container <?php echo esc_attr($height);?>">
        <div class="content-text" <?php if ( ! empty( $header_image ) ) : ?>
            style="background-image: url(<?php echo esc_url( $header_image ); ?>);
                   background-attachment: scroll;
                   background-size: cover;
                   background-position: center center;"
        <?php endif; ?>>
            <div class="container">
                <div class="site-header-text-wrap">
                    <?php
                    // Home page (blog listing)
                    if ( is_front_page() || is_home() && display_header_text() ) {
                        printf(
                            '<h1 class="page-title-text home-page-title">%s</h1>',
                            esc_html( get_bloginfo( 'name' ) )
                        );
                        printf(
                            '<p class="subtitle home-page-desc">%s</p>',
                            esc_html( get_bloginfo( 'description', 'display' ) )
                        );
                        echo do_shortcode('[apsw_search_bar_preview]');
                    // WooCommerce Shop page
                    } elseif ( function_exists( 'is_shop' ) && is_shop() && class_exists( 'WooCommerce' ) ) {
                        printf(
                            '<h1 class="page-title-text">%s</h1>',
                            esc_html( woocommerce_page_title( false ) )
                        );

                    // WooCommerce Product Category
                    } elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
                        printf(
                            '<h1 class="page-title-text">%s</h1>',
                            esc_html( woocommerce_page_title() )
                        );
                        echo '<p class="subtitle">';
                        do_action( 'the9_store_archive_description' );
                        echo '</p>';

                    // Single post or page
                    } elseif ( is_singular() ) {
                        printf(
                            '<h1 class="page-title-text">%s</h1>',
                            esc_html( single_post_title( '', false ) )
                        );

                    // Archive pages
                    } elseif ( is_archive() ) {
                        the_archive_title( '<h1 class="page-title-text">', '</h1>' );
                        the_archive_description( '<p class="archive-description subtitle">', '</p>' );

                    // Search results
                    } elseif ( is_search() ) {
                        printf(
                            '<h1 class="title">' . esc_html__( 'Search Results for: %s', 'the9-pet-veterinary' ) . '</h1>',
                            esc_html( get_search_query() )
                        );

                    // 404 fallback (won't normally run due to early return)
                    } elseif ( is_404() ) {
                        echo '<h1 class="display-1">';
                        esc_html_e( 'Oops! That page can’t be found.', 'the9-pet-veterinary' );
                        echo '</h1>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action('the9_store_site_header', 'the9_pet_veterinary_hero_sections', 9999 );
endif;

if ( ! function_exists( 'the9_pet_veterinary_loop_heading' ) ) :
/**
 * Display post title in loop.
 *
 * @since 1.0.0
 * @return void
 */
function the9_pet_veterinary_loop_heading() {
    if ( is_page() && ! is_singular() ) {
        return;
    }
    the_title(
        '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">',
        '</a></h3>'
    );
   
}
add_action( 'the9_store_site_content_type', 'the9_pet_veterinary_loop_heading', 20 ); 
endif;

if ( ! function_exists( 'the9_pet_veterinary_modify_default_options' ) ) :
/**
 * Modify the default theme options for The9 Pet Veterinary child theme.
 *
 * @since 1.0.0
 *
 * @param array $defaults Default theme options.
 * @return array Modified theme options.
 */
function the9_pet_veterinary_modify_default_options( $defaults ) {
    // Customize default theme option values
    $defaults['__primary_color']    = '#000000';
    $defaults['__secondary_color']  = '#FF4907';
    $defaults['blog_layout']        = 'content-sidebar';
    $defaults['single_post_layout'] = 'no-sidebar';
    $defaults['read_more_text']                 = esc_html__( 'Read More', 'the9-pet-veterinary' );

    return $defaults;
}
add_filter( 'the9_store_filter_default_theme_options', 'the9_pet_veterinary_modify_default_options' );
endif;


if ( ! function_exists( 'the9_pet_veterinary_site_footer_info' ) ) :
/**
 * Outputs the custom footer information for the site.
 *
 * @since 1.0.0
 * @return void
 */
function the9_pet_veterinary_site_footer_info() {
    
    // Initialize variables
    $text = '';
    $html = '<div class="site_info"><div class="container"><div class="row">';
    
    // Left column (Copyright info)
    $html .= '<div class="col-6">';

    if ( get_theme_mod( 'copyright_text' ) ) {
        $text .= esc_html( get_theme_mod( 'copyright_text' ) );
    } else {
        /* translators: 1: Current Year, 2: Blog Name */
        $text .= sprintf(
            esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'the9-pet-veterinary' ),
            date_i18n( _x( 'Y', 'copyright date format', 'the9-pet-veterinary' ) ),
            esc_html( get_bloginfo( 'name' ) )
        );
    }

    // Apply filter for copyright text customization
    $html .= apply_filters( 'the9_store_footer_copywrite_filter', $text );

    // Developer credit
    /* translators: 1: developer website, 2: WordPress URL */
    $html .= '<small class="dev_info">' . sprintf(
        esc_html__( ' %1$s by aThemeArt - Proudly powered by %2$s.', 'the9-pet-veterinary' ),
        '<a href="' . esc_url( 'https://athemeart.com/downloads/the9-pet-veterinary/' ) . '" target="_blank">' . esc_html_x( 'The9 theme', 'credit - theme', 'the9-pet-veterinary' ) . '</a>',
        '<a href="' . esc_url( __( 'https://wordpress.org', 'the9-pet-veterinary' ) ) . '" target="_blank" rel="nofollow">' . esc_html_x( 'WordPress', 'credit to CMS', 'the9-pet-veterinary' ) . '</a>'
    ) . '</small>';

    $html .= '</div>'; // End col-6 left

    // Right column (Social icons)
    $html .= '<div class="col-6">';
    $html .= '<ul class="social-links text-end d-flex justify-content-end align-items-center">';

    // Facebook
    if ( the9_store_get_option( '__fb_pro_link' ) ) {
        $html .= '<li class="social-item-facebook"><a href="' . esc_url( the9_store_get_option( '__fb_pro_link' ) ) . '" target="_blank" rel="nofollow"><i class="icofont-facebook"></i></a></li>';
    }

    // Twitter
    if ( the9_store_get_option( '__tw_pro_link' ) ) {
        $html .= '<li class="social-item-twitter"><a href="' . esc_url( the9_store_get_option( '__tw_pro_link' ) ) . '" target="_blank" rel="nofollow"><i class="icofont-twitter"></i></a></li>';
    }

    // YouTube
    if ( the9_store_get_option( '__you_pro_link' ) ) {
        $html .= '<li class="social-item-youtube"><a href="' . esc_url( the9_store_get_option( '__you_pro_link' ) ) . '" target="_blank" rel="nofollow"><i class="icofont-youtube"></i></a></li>';
    }

    $html .= '</ul>';
    $html .= '</div>'; // End col-6 right

    $html .= '</div></div></div>'; // Close row, container, and wrapper div

    // Output sanitized HTML
    echo wp_kses( $html, the9_store_alowed_tags() );
}
add_action('the9_store_site_footer', 'the9_pet_veterinary_site_footer_info', 80);
endif;


if ( ! function_exists( 'the9_pet_veterinary_custom_excerpt_length' ) ) :
/**
 * Set the custom excerpt length for the theme.
 *
 * This function modifies the default WordPress excerpt length globally.
 *
 * @since 1.0.0
 * @param int $length Current excerpt length.
 * @return int New excerpt length.
 */
function the9_pet_veterinary_custom_excerpt_length( $length ) {
    return 20; // Change this number to set your preferred word limit
}
add_filter( 'excerpt_length', 'the9_pet_veterinary_custom_excerpt_length', 999 );
endif;

if ( ! function_exists( 'the9_pet_veterinary_preloader' ) ) :
/**
 * Displays a custom site preloader.
 *
 * This function outputs a preloader animation that appears
 * while the site content is loading. It includes a spinner
 * and loading text.
 *
 * @since 1.0.0
 * @return void
 */
function the9_pet_veterinary_preloader() {
    ?>
    <div id="the9_preloader">
        <div class="preloader-animation">
            <div class="spinner"></div>
            <div class="loading-text">
                <?php echo esc_html__( 'Loading, please wait…', 'the9-pet-veterinary' ); ?>
            </div>
        </div>
        <div class="loader">
            <?php for ( $i = 0; $i < 4; $i++ ) : ?>
                <div class="loader-section">
                    <div class="bg"></div>
                </div>
            <?php endfor; ?>
        </div> 
    </div>
    <?php
}
add_action( 'the9_store_site_footer', 'the9_pet_veterinary_preloader', 999 );
endif;


require get_stylesheet_directory(). '/widgets/class-featured-posts-widget.php';

