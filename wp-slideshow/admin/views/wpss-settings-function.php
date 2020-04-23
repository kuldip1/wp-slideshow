<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

if (!function_exists('wpss_settings_page')) {

    /**
     * Add Top Level Menu
     *
     * Runs when the admin_menu hook fires and adds a new
     * top level admin page and menu item.
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_settings_page() {

        global $post, $wpss_scripts, $wpss_model;

        // plugin settings page
        $wpss_admin = add_menu_page(esc_html__('WP Slideshow', 'wpss'), esc_html__('WP Slideshow', 'wpss'), wpsslevel, 'wpss-settings', '', WPSS_IMG_URL . '/wpss_image.png');

        $wpss_admin = add_submenu_page('wpss-settings', esc_html__('Settings', 'wpss'), esc_html__('Settings', 'wpss'), wpsslevel, 'wpss-settings', 'wpss_setting_page');

        $wpss_slider_lists = add_submenu_page('wpss-settings', esc_html__('Slider Lists', 'wpss'), esc_html__('Slider Lists', 'wpss'), wpsslevel, 'wpss-slider-lists', 'wpss_slider_lists');

        $wpss_slider_add = add_submenu_page('wpss-settings', esc_html__('Add Slider', 'wpss'), esc_html__('Add Slider', 'wpss'), wpsslevel, 'wpss-add-slider', 'wpss_add_slider');
    }

}

if (!function_exists('wpss_setting_page')) {

    /**
     * Settings Page
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_setting_page() {

        include_once( WPSS_ADMIN . '/views/wpss-settings-hooks.php' );
        include_once( WPSS_ADMIN . '/views/wpss-plugin-settings.php' );
    }

}


if (!function_exists('wpss_slider_lists')) {

    /**
     * Settings Page
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_slider_lists() {

        include_once( WPSS_ADMIN . '/views/wpss-option-list.php');
    }

}


if (!function_exists('wpss_add_slider')) {

    /**
     * Settings Page
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_add_slider() {

        include_once( WPSS_ADMIN . '/views/wpss-add-edit-slide.php');
    }

}


if (!function_exists('wpss_init')) {

    /**
     * Register Settings
     *
     * Runs when the admin_init hook fires and registers
     * the plugin settings with the WordPress settings API.
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_init() {

        register_setting('wpss_plugin_options', 'wpss_options', 'wpss_validate_options');
    }

}

if (!function_exists('wpss_olt_admin_init')) {

    /**
     * Add action admin init
     * 
     * Handles add and edit functionality of product
     * 
     * @package WP Slideshow
     * @since 1.0.0
     */
    function wpss_olt_admin_init() {

        include_once( WPSS_ADMIN . '/views/wpss-olt-slide-save.php');
    }

}

/**
 * Settings Hooks
 *
 * @package WP Slideshow
 * @since 1.0
 */
if (!function_exists('wpss_general_setting_tab')) {

    /**
     * Display General Setting Tab
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_general_setting_tab($selected_tab) {
        ?>
        <a class="nav-tab" href="#wpss-tab-general" attr-tab="general">
            <?php esc_html_e('General Settings', 'wpss'); ?>
        </a>
        <?php
    }

}

if (!function_exists('wpss_general_setting_tab_content')) {

    /**
     * Display General Setting Tab Content
     * 
     * Handle to display general setting tab content
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_general_setting_tab_content($selected_tab) {
        ?>
        <div class="wpw-auto-poster-tab-content" id="wpw-auto-poster-tab-general"> 

            <?php
            // General Settings
            include( WPSS_ADMIN . '/views/wpss-general-settings.php' );
            ?>

        </div><!--#wpw-auto-poster-tab-general-->
        <?php
    }

}

/**
 * Sortable function for lists
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_update_sortable() {
    global $wpss_model;

    $data = $wpss_model->wpss_get_all_option_data();
    if (!empty($_POST['data'])) {
        $sortable = update_option(WPSS_OPTION, $_POST['data']);
        if ($sortable) {
            echo '1';
        } else {
            echo '0';
        }
        die();
    } else {
        echo '0';
        die();
    }
}

if (!function_exists('wpss_admin_bulk_delete')) {

    /**
     * Delete function
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_admin_bulk_delete() {
        global $wpss_model;

        if ((isset($_GET['action']) && $_GET['action'] == 'delete') && isset($_GET['page']) && $_GET['page'] == 'wpss-slider-lists') { //check action and page
            // get redirect url
            $redirect_url = add_query_arg(array('page' => 'wpss-slider-lists'), admin_url('admin.php'));

            //get bulk option array from $_GET
            $action_on_id = $_GET['option'];

            if (count($action_on_id) > 0) { //check there is some checkboxes are checked or not 
                //if there is multiple checkboxes are checked then call delete in loop
                $args = array(
                    'olt_ids' => $action_on_id
                );

                $wpss_model->wpss_olt_bulk_delete($args);

                $redirect_url = add_query_arg(array('message' => '3'), $redirect_url);

                //if bulk delete is performed successfully then redirect 
                wp_redirect($redirect_url);
                exit;
            } else {
                //if there is no checboxes are checked then redirect to listing page
                wp_redirect($redirect_url);
                exit;
            }
        }
    }

}

/**
 * All hooks initialzed
 * 
 * @package WP Slideshow
 * @since 1.0
 */
function add_hooks() {

    add_action('admin_menu', 'wpss_settings_page');

    add_action('admin_init', 'wpss_init');

    add_action('admin_init', 'wpss_olt_admin_init');

    add_action('wp_ajax_wpss_update_sortable', 'wpss_update_sortable');
    add_action('wp_ajax_nopriv_wpss_update_sortable', 'wpss_update_sortable');

    add_action('admin_init', 'wpss_admin_bulk_delete');
}
