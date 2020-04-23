<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Scripts Class
 *
 * @package WP Slideshow
 * @since 1.0
 */
class Wpss_Scripts {

    public $model;

    public function __construct() {
        global $wpss_model;

        $this->model = $wpss_model;
    }

    /**
     * Enqueue style
     *
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_settings_page_print_styles($hook_suffix) {
        global $wp_version;
        
        wp_register_style('wpss-settings-css', WPSS_URL . 'admin/css/wpss-admin-style.css', array(), WPSS_VERSION);
        wp_enqueue_style('wpss-settings-css');
    }

    /**
     * Enqueuing Scripts
     *
     * Loads the JavaScript files required for managing the meta boxes on the theme settings
     * page, which allows users to arrange the boxes to their liking plus all the other java
     * script files needed for the settings page.
     *
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_settings_page_print_scripts($hook_suffix) {
        global $wp_version;

        // loads the required scripts for the meta boxes
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');

        wp_register_script('wpss-settings', WPSS_URL . 'admin/js/wpss-admin-settings.js', array('jquery-ui-sortable'), WPSS_VERSION, true);
        wp_enqueue_script('wpss-settings');

        wp_localize_script('wpss-settings', 'wpss_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));


        $newui = $wp_version >= '3.5' ? '1' : '0';
        wp_localize_script('wpss-settings', 'WpdWsSettings', array(
            'new_media_ui' => $newui,
            'confirmmsg'   => esc_html__('Click OK to reset all options. All settings will be lost!', 'wpss'),
        ));

        

        //for new media uploader
        wp_enqueue_media();
        
        if ($wp_version >= 3.5) {
            //Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style( 'wp-color-picker' );
        }
        //If the WordPress version is less than 3.5 load the older farbtasic color picker.
        else {
            //As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
            wp_enqueue_script('farbtastic');
            wp_enqueue_style( 'farbtastic' );
        }
        
        
    }

    /**
     * Adding Hooks
     *
     * @package WP Slideshow
     * @since 1.0
     */
    public function add_hooks() {

        // adding the admin css for settings page
        add_action('admin_enqueue_scripts', array($this, 'wpss_settings_page_print_styles'));

        //enqueue scripts for setting page
        add_action('admin_enqueue_scripts', array($this, 'wpss_settings_page_print_scripts'));
    }

}
