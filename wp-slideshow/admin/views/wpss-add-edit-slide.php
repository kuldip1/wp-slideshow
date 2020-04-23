<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

global $wpss_model, $error, $err_code;

$model = $wpss_model;

$page_title = esc_html__('Add Slider', 'wpss');
$save_btn = esc_html__('Add Slider', 'wpss');
$optid = 0;
$data = array(
    'slider_title' => '',
    'slider_description' => '',
    'slider_image' => ''
);

if (isset($_GET['action']) && $_GET['action'] == 'edit' && !empty($_GET['optid'])) { //check action & id is set or not
    //level page title
    $page_title = esc_html__('Edit Option', 'wpss');

    //level page submit button text either it is Add or Update
    $save_btn = esc_html__('Update', 'wpss');

    //get the level id from url to update the data and get the data of level to fill in editable fields
    $optid = $_GET['optid'];

    //get the data from level id
    $data = $model->wpss_get_option_data($optid);
}
$data['slider_title'] = isset($_POST['wpss_olt_option']['slider_title']) ? $_POST['wpss_olt_option']['slider_title'] : $data['slider_title'];
$data['slider_description'] = isset($_POST['wpss_olt_option']['slider_description']) ? $_POST['wpss_olt_option']['slider_description'] : $data['slider_description'];
$data['slider_image'] = isset($_POST['wpss_olt_option']['slider_image']) ? $_POST['wpss_olt_option']['slider_image'] : $data['slider_image'];
?>

<div class="wrap">
    <h2><?php echo $page_title; ?></h2>
    <div id="ww-olt-manage-option" class="post-box-container">
        <div class="metabox-holder">
            <div class="meta-box-sortables ui-sortable">
                <div id="manage-option" class="postbox">

                    <div class="handlediv" title="<?php esc_html_e('Click to toggle', 'wpss'); ?>"></div>
                    <!-- product box title -->
                    <h3 class="hndle"><span style="vertical-align: top;"><?php echo $page_title; ?></span></h3>

                    <div class="inside">

                        <form id="ww-olt-manage-option-form" action="" method="post">

                            <input type="hidden" name="page" value="ww_olt_manage_option_add_form" />
                            <table class="form-table sa-manage-level-product-box"> 
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <label for="ww_olt_option_name"><strong><?php esc_html_e('Slider Title:', 'wpss'); ?></strong></label>
                                        </th>
                                        <td>

                                            <input type="text" id="ww_olt_option_name" name="wpss_olt_option[slider_title]" value="<?php echo $data['slider_title']; ?>" class="regular-text"/>
                                            <br />
                                            <span class="description"><?php esc_html_e('Enter slider title.', 'wpss'); ?></span>
                                            <br />
                                            <span class="error_message"><?php
                                                if (isset($error['slider_title'])) {
                                                    echo $error['slider_title'];
                                                }
                                                ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ww_olt_option_description"><strong><?php esc_html_e('Slider description:', 'wpss'); ?></strong></label>
                                        </th>
                                        <td>
                                            <textarea id="ww_olt_option_description" name="wpss_olt_option[slider_description]" class="regular-text"><?php
                                                echo $data['slider_description'];
                                                ?></textarea>
                                            <br />
                                            <span class="description"><?php esc_html_e('Enter slider description.', 'wpss'); ?></span>
                                            <br />
                                            <span class="error_message"><?php
                                                if (isset($error['slider_description'])) {
                                                    echo $error['slider_description'];
                                                }
                                                ?></span>
                                        </td>
                                    </tr>

                                    <?php
                                    if (!empty($data['slider_image'])) { //check connect button image
                                        $show_img_connect = ' <img src="' . esc_url($data['slider_image']) . '" alt="' . esc_html__('Image', 'wpss') . '" />';
                                    } else {
                                        $show_img_connect = '';
                                    }
                                    ?>	

                                    <tr>
                                        <th scope="row">
                                            <label for="wpd-ws-settings-image"><strong><?php echo esc_html__('Slider Image:', 'wpss') ?></strong></label>
                                        </th>
                                        <td><input type="text" id="wpd-ws-settings-image" name="wpss_olt_option[slider_image]" value="<?php echo $data['slider_image'] ?>" size="63" />
                                            <input type="button" class="button-secondary wpd-ws-img-uploader" id="wpd-ws-img-btn" name="wpd_ws_img" value="<?php echo esc_html__('Choose image.', 'wpss') ?>"><br />
                                            <span class="description"><?php echo esc_html__('Choose image.', 'wpss') ?></span>
                                            <div id="wpd-ws-setting-image-view"><?php echo $show_img_connect ?></div>
                                            <span class="error_message"><?php
                                                if (isset($error['slider_image'])) {
                                                    echo $error['slider_image'];
                                                }
                                                ?></span>
                                            <br />
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">
                                            
                                        </th>
                                        <td>
                                            <p class="wpw-auto-poster-info-box width-80" >
                                                <?php print sprintf(esc_html__('%sNote:%s Add more then one slide for better output using shortcode.', 'wpss'), '<b>', '</b>'); ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="ww_olt_optid" value="<?php echo $optid ?>" />
                                            <input type="submit" class="button-primary margin_button wpss_set_submit" name="ww_olt_option_save" id="ww_olt_option_save" value="<?php echo $save_btn; ?>" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                    </div><!-- End .inside -->
                </div><!-- End #manage-option -->
            </div><!-- End .meta-box-sortables -->
        </div><!-- End .metabox-holder -->
    </div><!-- End #ww-olt-manage-option -->
</div><!-- End .wrap -->