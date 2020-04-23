<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Settings Page
 *
 * @package WP Slideshow
 * @since 1.0
 */
global $wpss_options, $wpss_model;

//model class
$model = $wpss_model;
?>
<div class="wrap">

    <!-- plugin name -->
    <h2><?php esc_attr_e('WP Slideshow Settings', 'wpss'); ?></h2><br />

    <!-- settings reset -->
    <?php
    if (isset($_POST['wpw_auto_posting_reset_settings']) && $_POST['wpw_auto_posting_reset_settings'] == esc_html__('Reset All Settings', 'wpss')) {

        //delete auto poster options
        delete_option('wpss_options');

        //delete all slide options
        delete_option('wpss_olt_option');

        // set default settings
        wpss_default_setting();

        echo '<div id="message" class="updated fade wpw_auto_posting_reposter_reset_settings"><p><strong>' . esc_html__('All Settings Reset Successfully.', 'wpss') . '</strong></p></div>';
    }
    ?>

    <!-- settings updated message -->
    <?php
    if (isset($_GET['settings-updated'])) {

        echo '<div id="message" class="updated fade"><p><strong>' . esc_html__('Changes Saved.', 'wpss') . '</strong></p></div>';
    }
    ?>

    <?php
    echo apply_filters(
            'wpss_settings_submit_button', '<form method="post" action="">
									<div class="wpw-auto-poster-posting-reset-setting">
								        <input type="submit" class="button-primary wpw-auto-poster-reset-button" id="wpw_auto_posting_reset_settings" name="wpw_auto_posting_reset_settings" value="' . esc_html__('Reset All Settings', 'wpss') . '" />
								     </div>
								</form>'
    );
    ?>

    <!-- beginning of the plugin options form -->
    <form id="wpss_setting" method="post" action="options.php">

        <?php settings_fields('wpss_plugin_options'); ?>
        <?php $wpss_options = get_option('wpss_options'); ?>

        <!-- beginning of the left meta box section -->
        <div class="content">

            <?php
            /**
             * Settings Boxes
             *
             * Including all the different settings boxes for the plugin options.
             *
             * @package WP Slideshow
             * @since 1.0
             */
            ?>

            <h2 class="nav-tab-wrapper wpw-auto-poster-h2">

                <?php do_action('wpss_settings_panel_tab') ?>

            </h2><!--nav-tab-wrapper-->
            <input type="hidden" id="wpss_selected_tab" name="wpss_options[selected_tab]" value="<?php echo $selected_tab; ?>"/>
            <div class="wpss-content">

                <?php do_action('wpss_settings_panel_tab_content') ?>

            </div>

        </div><!-- .content -->

    </form><!-- end of plugin options form -->

</div><!-- .wrap -->