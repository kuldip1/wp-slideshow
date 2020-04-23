<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Model Class
 *
 * @package WP Slideshow
 * @since 1.0
 */
class Wpss_Model {

    public function __construct() {
        
    }

    /**
     * similar to checked() but checks for array
     * 	
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_checked_array($checked, $current) {

        if (is_array($current)) {
            if (in_array($checked, $current)) {
                echo ' checked="checked"';
            }
        } else {
            if ($checked == $current) {
                echo ' checked="checked"';
            }
        }
    }

    /**
     * Get Option Data
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_get_option_data($optid = '') {

        $default_option_data = array(
            'name' => '',
            'description' => '',
            'image' => ''
        );

        if (!empty($optid)) {

            $all_options = $this->wpss_get_all_option_data();
            $option_data = isset($all_options[$optid]) ? $all_options[$optid] : $default_option_data;
        } else {

            $option_data = $default_option_data;
        }

        return $option_data;
    }
    

    /**
     * Get All Option Data
     * 
     * handle to get all options data
     * 
     * @package WP Slideshow
     * @since 1.0.0
     */
    function wpss_get_all_option_data($args = array()) {


        if (empty($args)) {

            return get_option(WPSS_OPTION, array());
        } else {

            return get_option(WPSS_OPTION, array());
        }
    }

    /**
     * Get Unserialize the data
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_get_unserialize_data($data) {

        $undata = unserialize($data);
        return $undata;
    }

    /**
     * Escape Tags & Slashes with URL
     *
     * @package WP Slideshow
     * @since 1.0
     */
    function wpss_escape_url($data) {

        return esc_url($data);
    }

    /**
     * Escape Tags & Slashes
     *
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_escape_attr($data) {
        return esc_attr_e(stripslashes($data));
    }

    /**
     * Stripslashes
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_stripslashes($data = array(), $flag = false) {

        if ($flag != true) {
            $data = $this->wpss_nohtml_kses($data);
        }
        $data = stripslashes_deep($data);
        return $data;
    }

    /**
     * Update All Option Data
     * 
     * handle to update all options data
     * 
     * @package WP Slideshow
     * @since 1.0.0
     */
    public function wpss_update_all_option_data($all_option_data = array()) {

        return update_option(WPSS_OPTION, $all_option_data);
    }

    /**
     * Strip Html Tags 
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_nohtml_kses($data = array()) {

        if (is_array($data)) {

            $data = array_map(array($this, 'wpss_nohtml_kses'), $data);
        } elseif (is_string($data)) {

            $data = wp_filter_nohtml_kses($data);

            if (defined('JNEWS_THEME_ID')) {
                $data = wp_strip_all_tags($data);
            }
        }

        return $data;
    }

    /**
     * HTML Entity Decode
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_html_decode($string) {

        return html_entity_decode($string);
    }

    /**
     * Short the Content As Per Character Limit
     *
     * @package WP Slideshow
     * @since 1.0
     * */
    public function wpss_excerpt($content, $charlength = 280) {

        $excerpt = '';
        $charlength++;

        //check content length is greater then character length
        if (strlen($content) > $charlength) {

            $subex = substr($content, 0, $charlength - 5);
            $exwords = explode(' ', $subex);
            $excut = - ( strlen($exwords[count($exwords) - 1]) );

            if ($excut < 0) {
                $excerpt = substr($subex, 0, $excut);
            } else {
                $excerpt = $subex;
            }
        } else {
            $excerpt = $content;
        }

        //return short content
        return $excerpt;
    }

    /**
     * Convert Object To Array
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_object_to_array($result) {
        $array = array();
        foreach ($result as $key => $value) {
            if (is_object($value)) {
                $array[$key] = $this->wpss_object_to_array($value);
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    /**
     * Get Date Format
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_get_date_format($date, $time = false) {

        $format = $time ? get_option('date_format') . ' ' . get_option('time_format') : get_option('date_format');
        $date = date_i18n($format, strtotime($date));
        return apply_filters('wpss_date_format', $date);
    }

    /**
     * Bulk Deletion
     *
     * Does handle deleting options from the
     * wp_options table.
     *
     * @package WP Slideshow
     * @since 1.0.0
     */
    public function wpss_olt_bulk_delete($args = array()) {

        if (isset($args['olt_ids']) && !empty($args['olt_ids'])) {

            $get_all_options = $this->wpss_get_all_option_data();

            foreach ($args['olt_ids'] as $olt_id) {

                if (isset($get_all_options[$olt_id])) {

                    unset($get_all_options[$olt_id]);
                }
            }

            $this->wpss_update_all_option_data($get_all_options);
        }
    }

    /**
     * Get One Diemention Array
     * 
     * @package WP Slideshow
     * @since 1.0
     */
    public function wpss_get_one_dim_array($multi_dim_array) {

        $one_dim_array = array();
        if (!empty($multi_dim_array)) { // Check dim array are not empty
            foreach ($multi_dim_array as $multi_dim_keys) {

                if (!empty($multi_dim_keys)) { // Check dim keys are not empty
                    foreach ($multi_dim_keys as $multi_dim_values) {

                        $one_dim_array[] = $multi_dim_values;
                    }
                }
            }
        }
        return $one_dim_array;
    }

}
