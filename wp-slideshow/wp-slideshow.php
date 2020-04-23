<?php

/**
 * Plugin Name: WP Slideshow
 * Plugin URI: http://kuldipmakdiya.wordpress.com
 * Description: WP Slideshow provide you to display your image and title to any page or posts.
 * Version: 1.0
 * Author: Kuldip Makadiya
 * Author URI: http://kuldipmakdiya.wordpress.com
 * Text Domain: wpss
 * Domain Path: languages
 * 
 * @package WP Slideshow
 * @category Core
 * @author Kuldip Makadiya
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Basic Plugin Definitions 
 * 
 * @package WP Slideshow
 * @since 1.0
 */
if (!defined('WPSS_VERSION')) {
    define('WPSS_VERSION', '1.0'); //version of plugin
}
if (!defined('wpsslevel')) {
    //specify the user's role capabilites who can access this plugins settings in backend
    //for more informatioon please check  http://codex.wordpress.org/Roles_and_Capabilities
    define('wpsslevel', 'manage_options'); //administrator role can use this plugin
}
if (!defined('WPSS_DIR')) {
    define('WPSS_DIR', dirname(__FILE__)); // plugin dir
}
if (!defined('WPSS_URL')) {
    define('WPSS_URL', plugin_dir_url(__FILE__)); // plugin url
}
if (!defined('WPSS_IMG_URL')) {
    define('WPSS_IMG_URL', WPSS_URL . 'admin/images'); // plugin image url
}

if (!defined('WPSS_ADMIN')) {
    define('WPSS_ADMIN', WPSS_DIR . '/admin'); // plugin admin dir
}

if (!defined('WPSS_TITLE_PREFIX')) {
    define('WPSS_TITLE_PREFIX', 'WPSP');
}

if (!defined('WPSS_META_PREFIX')) {
    define('WPSS_META_PREFIX', '_wpss_'); //metabox prefix if required
}
if (!defined('WPSS_BASENAME')) {
    define('WPSS_BASENAME', basename(WPSS_DIR)); // base name
}
if (!defined('WPSS_OPTION')) {
    define('WPSS_OPTION', 'wpss_olt_option'); // slider slug
}

/**
 * Text Domain Loaded
 * 
 * The plugin ready for translation.
 * 
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_plugins_loaded() {

    // filter for plugin's languages directory
    $wpss_lang_dir = dirname(plugin_basename(__FILE__)) . '/languages/';
    $wpss_lang_dir = apply_filters('wpss_plugins_loaded', $wpss_lang_dir);

    // Traditional WordPress plugin locale filter
    $locale = apply_filters('plugin_locale', get_locale(), 'wpss');
    $mofile = sprintf('%1$s-%2$s.mo', 'wpss', $locale);

    // Setup paths to current locale file
    $mofile_local = $wpss_lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/' . WPSS_BASENAME . '/' . $mofile;

    if (file_exists($mofile_global)) { // Look in global /wp-content/languages/ folder
        load_textdomain('wpss', $mofile_global);
    } elseif (file_exists($mofile_local)) { // Look in local /wp-content/plugins/wp-slideshow/languages/ folder
        load_textdomain('wpss', $mofile_local);
    } else { // Load the default language files
        load_plugin_textdomain('wpss', false, $wpss_lang_dir);
    }
}

add_action('plugins_loaded', 'wpss_plugins_loaded');

/**
 * Read all options to make it wordpress multilanguage compatible
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_load_option() {

    // Read plugin default option to Make it wordpress multilanguage Compatible
    global $wpss_options, $wpss_olt_option;
    $wpss_options = get_option('wpss_options');
    $wpss_olt_option = get_option('wpss_olt_option');
}

//add action to load plugin
add_action('plugins_loaded', 'wpss_load_option');

/**
 * Activation Hook
 *
 * @package WP Slideshow
 * @since 1.0
 */
register_activation_hook(__FILE__, 'wpss_install');

/**
 * Plugin Activation
 * 
 * It will create initial setup, create tables if necessary and add default setting in database
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_install() {

    global $wpdb;

    //get plugin options from database
    $wpss_options = get_option('wpss_options');

    //on first time activation plugin get option data
    $wpss_set_option_ver = get_option('wpss_set_option_ver');

    // check slider option 
    $wpss_olt_option = get_option('wpss_olt_option');

    //check default option is empty or not
    if (empty($wpss_options)) {

        //set default settings
        wpss_default_setting();

        //update plugin version to option table 
        update_option('wpss_set_option_ver', '1.0');
    }

    $wpss_set_option_ver = get_option('wpss_set_option_ver');

    if ($wpss_set_option_ver == '1.0') {
        // Next version code will be here as per your default setting argument and option
    }
}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package WP Slideshow
 * @since 1.0
 */
register_deactivation_hook(__FILE__, 'wpss_uninstall');

/**
 * Plugin Deactivation
 *
 * Delete plugin options
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_uninstall() {

    global $wpdb;

    $wpss_options = get_option('wpss_options');

    //delete options
    delete_option('wpss_options');

    //delete plugin option version also
    delete_option('wpss_set_option_ver');

    //delete all slide options
    delete_option('wpss_olt_option');
}

/**
 * Default Settings
 *
 * Define default value of plugin while install first time.
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_default_setting() {

    global $wpss_options;

    //default values
    $wpss_options = array(
        //General Settings
        'wpss_thumb_width' => '300px',
        'wpss_thumb_height' => '150px',
        'wpss_slideInterval' => '3000',
        'wpss_transitionSpeed' => '1000',
        'wpss_startSlideIndex' => '0',
        'wpss_pauseOnHover' => 'true',
        'wpss_keyboardNav' => 'true',
        'wpss_mousewheelNav' => 'true',
        'wpss_t_thumbWidth' => '50%',
        'wpss_t_slideInterval' => '3000',
        'wpss_t_transitionSpeed' => '900',
        'wpss_t_startSlideIndex' => '0',
        'wpss_t_pauseOnHover' => 'true',
        'wpss_t_keyboardNav' => 'true',
        'wpss_t_mousewheelNav' => 'true',
        'slider_image' => '',
        'background_color' => '#effeff',
    );

    // apply filters for default setting
    $wpss_options = apply_filters('wpss_default_setting', $wpss_options);

    update_option('wpss_options', $wpss_options);
}

/**
 *
 * Adds a settings link to the plugin list.
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_add_settings_link($links) {
    $plugin_links = array(
        '<a href="' . add_query_arg(array('page' => 'wpss-settings'), admin_url('admin.php')) . '">' . esc_html__('Settings', 'wpss') . '</a>'
    );

    return array_merge($plugin_links, $links);
}

//add plugin settings link to plugin list     
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wpss_add_settings_link');

/**
 * Session Start
 *
 * @package WP Slideshow
 * @since 1.0
 */
function wpss_session_set() {

    global $wpdb, $pagenow;

    if ($pagenow != 'site-health.php') {


        if (!session_id()) {
            session_cache_limiter(''); // fix header response issue for caching
            session_start();
        }
    }
}

global $wpss_options, $wpss_model;

/**
 * Plugin needed file includes here
 *
 * @package WP Slideshow
 * @since 1.0
 */
//Settings functions File
require_once( WPSS_ADMIN . '/views/wpss-settings-function.php' );
add_hooks();

//Model Class File
require_once( WPSS_DIR . '/include/class-wpss-model.php' );
$wpss_model = new Wpss_Model();

//Including the Scripts and Styles File
require_once( WPSS_ADMIN . '/script/class-wpss-scripts.php' );
$wpss_scripts = new Wpss_Scripts();
$wpss_scripts->add_hooks();

//Public Class to handles all public functionalities File
require_once( WPSS_DIR . '/public/class-wpss-public.php' );
$wpss_public = new Wpss_PublicPages();
$wpss_public->add_hooks();

//session set hook
add_action('init', 'wpss_session_set', 15);
