<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * General Settings
 *
 * @package WP Slideshow
 * @since 1.0
 */
global $wpss_options, $wpss_model, $wp_version;

$model = $wpss_model;
?>

<!-- beginning of the general settings meta box -->
<div id="wpw-auto-poster-general" class="post-box-container">
    <div class="metabox-holder">	
        <div class="meta-box-sortables ui-sortable">
            <div id="general" class="postbox">	
                <div class="handlediv" title="<?php esc_html_e('Click to toggle', 'wpss'); ?>"><br /></div>

                <!-- general settings box title -->
                <h3 class="hndle">
                    <span class='wpw-sap-buffer-app-settings'><?php esc_html_e('General Settings', 'wpss'); ?></span>
                </h3>

                <div class="inside">

                    <table class="form-table">											
                        <tbody>				

                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[background_color]"><?php esc_html_e('Slider Background Colour:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <?php
                                    if ($wp_version >= 3.5) {
                                        echo '<input type="text" value="' . $wpss_options['background_color'] . '" name="wpss_options[background_color]" class="wpd-ws-color-box" data-default-color="#effeff" />';
                                    } else {

                                        echo '<div style="position:relative;">
                                                <input type="text" name="wpss_options[background_color]" value="' . $wpss_options['background_color'] . '" id="wpd_ws_options_color" />
                                                <input type="button" class="wpd-ws-color-box button-secondary" value="' . esc_html__('Select Color', 'wpss') . '">
                                                <div class="colorpicker" style="z-index:100; position:absolute; display:none;"></div>
                                            </div>';
                                    }
                                    ?>
                                    <p><small>
                                            <?php echo sprintf(esc_html__('Select color for display background of slider. Default is %s #effeff %s', 'wpss'), '<code>', '</code>'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="2">
                                    <strong><?php esc_html_e('Thumbnail Settings', 'wpss'); ?></strong>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_thumb_width]"><?php esc_html_e('Thumbnail Width:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_thumb_width]" name="wpss_options[wpss_thumb_width]" type="number" value="<?php echo $wpss_options['wpss_thumb_width']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter thumb image width. Recommended 300 for better output.', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_thumb_height]"><?php esc_html_e('Thumbnail Height:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_thumb_height]" name="wpss_options[wpss_thumb_height]" type="number" value="<?php echo $wpss_options['wpss_thumb_height']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter thumb image height. Recommended 150 for better output', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_slideInterval]"><?php esc_html_e('Thumbnail Slide Interval:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_slideInterval]" name="wpss_options[wpss_slideInterval]" type="number" value="<?php echo $wpss_options['wpss_slideInterval']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter scrolling slider interval', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_transitionSpeed]"><?php esc_html_e('Thumbnail Slide Transit Speed:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_transitionSpeed]" name="wpss_options[wpss_transitionSpeed]" type="number" value="<?php echo $wpss_options['wpss_transitionSpeed']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter slider transition speed', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_startSlideIndex]"><?php esc_html_e('Thumbnail Start Slide Index:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_startSlideIndex]" name="wpss_options[wpss_startSlideIndex]" type="number" value="<?php echo $wpss_options['wpss_startSlideIndex']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter slider starting image index', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_pauseOnHover]"><?php esc_html_e('Thumbnail Pause On Hover:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_pauseOnHover]" name="wpss_options[wpss_pauseOnHover]" type="checkbox" value="1" <?php
                                            if (isset($wpss_options['wpss_pauseOnHover'])) {
                                                checked('1', $wpss_options['wpss_pauseOnHover']);
                                            }
                                            ?> />
                                    <p><small>
                                            <?php esc_html_e('If you need to pause slider while mouse hover then select checkbox', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_keyboardNav]"><?php esc_html_e('Thumbnail Keyboard Navigation:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_keyboardNav]" name="wpss_options[wpss_keyboardNav]" type="checkbox" value="1" <?php
                                            if (isset($wpss_options['wpss_keyboardNav'])) {
                                                checked('1', $wpss_options['wpss_keyboardNav']);
                                            }
                                            ?> />
                                    <p><small>
                                            <?php esc_html_e('Select checkbox is you need to enable keyboard navigation', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_mousewheelNav]"><?php esc_html_e('Thumbnail Mouse Wheel Navigation:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_mousewheelNav]" name="wpss_options[wpss_mousewheelNav]" type="checkbox" value="1" <?php
                                            if (isset($wpss_options['wpss_mousewheelNav'])) {
                                                checked('1', $wpss_options['wpss_mousewheelNav']);
                                            }
                                            ?> />
                                    <p><small>
                                            <?php esc_html_e('Select checkbox if you need scroll based on mouse wheel scroll', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="2">
                                    <strong><?php esc_html_e('Large Image Settings', 'wpss'); ?></strong>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_thumbWidth]"><?php esc_html_e('Large Width:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_thumbWidth]" name="wpss_options[wpss_t_thumbWidth]" type="number" value="<?php echo $wpss_options['wpss_t_thumbWidth']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter main image width. Recommended 50% for better output', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_slideInterval]"><?php esc_html_e('Large Slide Interval:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_slideInterval]" name="wpss_options[wpss_t_slideInterval]" type="number" value="<?php echo $wpss_options['wpss_t_slideInterval']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter main image slide interval', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_transitionSpeed]"><?php esc_html_e('Large Slide Transit Speed:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_transitionSpeed]" name="wpss_options[wpss_t_transitionSpeed]" type="number" value="<?php echo $wpss_options['wpss_t_transitionSpeed']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter main image transition speed', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>





                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_startSlideIndex]"><?php esc_html_e('Large Start Slide Index:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_startSlideIndex]" name="wpss_options[wpss_t_startSlideIndex]" type="number" value="<?php echo $wpss_options['wpss_t_startSlideIndex']; ?>" />
                                    <p><small>
                                            <?php esc_html_e('Enter main image start slide index', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_pauseOnHover]"><?php esc_html_e('Large Pause On Hover:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_pauseOnHover]" name="wpss_options[wpss_t_pauseOnHover]" type="checkbox" value="1" <?php
                                            if (isset($wpss_options['wpss_t_pauseOnHover'])) {
                                                checked('1', $wpss_options['wpss_t_pauseOnHover']);
                                            }
                                            ?> />
                                    <p><small>
                                            <?php esc_html_e('If you need to pause main image slider while mouse hover then select checkbox', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_keyboardNav]"><?php esc_html_e('Large Keyboard Navigation:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_keyboardNav]" name="wpss_options[wpss_t_keyboardNav]" type="checkbox" value="1" <?php
                                            if (isset($wpss_options['wpss_t_keyboardNav'])) {
                                                checked('1', $wpss_options['wpss_t_keyboardNav']);
                                            }
                                            ?> />
                                    <p><small>
                                            <?php esc_html_e('Select checkbox is you need to enable main image keyboard navigation', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>


                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpss_options[wpss_t_mousewheelNav]"><?php esc_html_e('Large Mouse Wheel Navigation:', 'wpss'); ?></label>
                                </th>
                                <td>
                                    <input id="wpss_options[wpss_t_mousewheelNav]" name="wpss_options[wpss_t_mousewheelNav]" type="checkbox" value="1" <?php
                                            if (isset($wpss_options['wpss_t_mousewheelNav'])) {
                                                checked('1', $wpss_options['wpss_t_mousewheelNav']);
                                            }
                                            ?> />
                                    <p><small>
                                            <?php esc_html_e('Select checkbox if you need scroll based on main image mouse wheel scroll', 'wpss'); ?>
                                        </small></p>
                                </td>
                            </tr>

                            <?php
                            echo apply_filters(
                                    'wpss_submit_button', '<tr valign="top">
                                        <td colspan="2">
                                                <input type="submit" value="' . esc_html__('Save Changes', 'wpss') . '" id="wpss_set_submit" name="wpss_set_submit" class="button-primary wpss_set_submit">
                                        </td>
                                </tr>'
                            );
                            ?>
                        </tbody>
                    </table>

                </div><!-- .inside -->

            </div><!-- #general -->
        </div><!-- .meta-box-sortables ui-sortable -->
    </div><!-- .metabox-holder -->
</div><!-- #wpw-auto-poster-general -->
<!-- end of the general settings meta box -->