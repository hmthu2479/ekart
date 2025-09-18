<?php
/**
 * Theme functions and definitions
 *
 * @package eKart
 */

/**
 * After setup theme hook
 */
function ekart_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'ekart' );	
}
add_action( 'after_setup_theme', 'ekart_theme_setup' );

/**
 * Load assets.
 */

function ekart_theme_css() {
	wp_enqueue_style( 'ekart-parent-theme-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'ekart_theme_css', 99);

require get_stylesheet_directory() . '/theme-functions/controls/class-customize.php';

/**
 * Import Options From Parent Theme
 *
 */
function ekart_parent_theme_options() {
	$ekart_mods = get_option( 'theme_mods_shopire' );
	if ( ! empty( $ekart_mods ) ) {
		foreach ( $ekart_mods as $ekart_mod_k => $ekart_mod_v ) {
			set_theme_mod( $ekart_mod_k, $ekart_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'ekart_parent_theme_options' );

/**
 * Convert Uploaded Images to WebP Format
 *
 * This snippet automatically converts JPEG, PNG, and GIF images 
 * to WebP format during the upload process.
 */

add_filter('wp_handle_upload', 'wpturbo_handle_upload_convert_to_webp');
function wpturbo_handle_upload_convert_to_webp($upload) {
    if (in_array($upload['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
        $file_path = $upload['file'];
        if (extension_loaded('imagick') || extension_loaded('gd')) {
            $image_editor = wp_get_image_editor($file_path);
            if (!is_wp_error($image_editor)) {
                $file_info = pathinfo($file_path);
                $dirname = $file_info['dirname'];
                $filename = $file_info['filename'];
                $def_filename = wp_unique_filename($dirname, $filename . '.webp');
                $new_file_path = $dirname . '/' . $def_filename;
                $saved_image = $image_editor->save($new_file_path, 'image/webp');
                if (!is_wp_error($saved_image) && file_exists($saved_image['path'])) {
                    // Update the upload data to use the WebP image
                    $upload['file'] = $saved_image['path'];
                    $upload['url'] = str_replace(basename($upload['url']), basename($saved_image['path']), $upload['url']);
                    $upload['type'] = 'image/webp';

                    // Optionally delete the original file
                    @unlink($file_path);
                }
            }
        }
    }

    return $upload;
}