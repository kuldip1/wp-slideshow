<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Public Class
 *
 * @package WP Slideshow
 * @since 1.0
 */
class Wpss_PublicPages {

    public function __construct() {

        global $wpss_options, $wpss_model;
    }

    /**
     * Add public script and styles
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_public_script() {
        global $wp_version, $wpss_options;
        if (!is_admin()) {

            wp_register_style('wpss-public-style-thumb', esc_url(WPSS_URL) . 'public/css/wpss-thumbs2.css', array(), WPSS_VERSION);
            wp_enqueue_style('wpss-public-style-thumb');

            wp_register_style('wpss-public-style-thumb-slide', esc_url(WPSS_URL) . 'public/css/wpss-thumbnail-slider.css', array(), WPSS_VERSION);
            wp_enqueue_style('wpss-public-style-thumb-slide');



            wp_register_script('wpss-public-settings', esc_url(WPSS_URL) . 'public/js/wpss-thumbnail-slider.js', array(), WPSS_VERSION);
            wp_enqueue_script('wpss-public-settings');

            wp_register_script('wpss-public-script', esc_url(WPSS_URL) . 'public/js/wpss-public-script.js', array(), WPSS_VERSION, true);
            wp_enqueue_script('wpss-public-script');
        }
    }

    /**
     * Render shortcode HTML with javascript
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_public_display_slide() {

        include_once( WPSS_DIR . '/public/views/wpss-public-view.php' );
    }

    /**
     * Adding Hooks
     *
     * @package WP Slideshow
     * @since 1.0
     */
    public function add_hooks() {
        // if the user can edit plugin options, let the fun begin!
        add_action('wp_enqueue_scripts', array($this, 'wpss_public_script'));
        add_shortcode('wpss_slideshow', array($this, 'wpss_public_display_slide'));
    }

}
