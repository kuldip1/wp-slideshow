<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Save Option
 * 
 * @package WP Slideshow
 * @since 1.0
 */
global $error, $err_code, $wpss_model;

$model = $wpss_model;


if (!empty($_POST['ww_olt_option_save']) && !empty($_POST['wpss_olt_option'])) {

    $error = array();
    $err_code = 0;

    if (empty($_POST['wpss_olt_option']['slider_title'])) {
        $error['slider_title'] = esc_html__('Please enter slider title.', 'wpss');
        $err_code = 1;
    }

    if (empty($_POST['wpss_olt_option']['slider_description'])) {
        $error['slider_description'] = esc_html__('Please enter slider description.', 'wpss');
        $err_code = 1;
    }

    if (empty($_POST['wpss_olt_option']['slider_image'])) {
        $error['slider_image'] = esc_html__('Please select image.', 'wpss');
        $err_code = 1;
    }
    


    if (isset($_POST['ww_olt_optid']) && !empty($_POST['ww_olt_optid']) && $err_code != 1) {


        $get_all_option = $model->wpss_get_all_option_data();
        $last_key = $_POST['ww_olt_optid'];
        $get_all_option[$last_key] = $model->wpss_stripslashes($_POST['wpss_olt_option']);

        $model->wpss_update_all_option_data($get_all_option);

        // Get redirect url
        $redirect_url = add_query_arg(array('page' => 'wpss-slider-lists', 'message' => '2'), admin_url('admin.php'));

        wp_redirect($redirect_url);
    } else {

        if ($err_code != 1) {

            $get_all_option = $model->wpss_get_all_option_data();

            $last_key = 1;
            if (!empty($get_all_option) && is_array($get_all_option)) {

                $keys = array_keys($get_all_option);
                $last_key = end($keys);
                $last_key = $last_key + 1;
            }

            $get_all_option[$last_key] = $model->wpss_stripslashes($_POST['wpss_olt_option']);

            $model->wpss_update_all_option_data($get_all_option);

            // Get redirect url
            $redirect_url = add_query_arg(array('page' => 'wpss-slider-lists', 'message' => '1'), admin_url('admin.php'));

            wp_redirect($redirect_url);
        }
    }
}