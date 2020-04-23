<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;
 
global $wpss_olt_option, $wpss_options,$wpss_model;
ob_start();
?>
<script>
    var thumbnailSliderOptions =
            {
                sliderId: "thumbnail-slider",
                orientation: "horizontal",
                thumbWidth: '<?php echo $wpss_options['wpss_thumb_width']; ?>px',
                thumbHeight: '<?php echo $wpss_options['wpss_thumb_height']; ?>px',
                showMode: 3,
                autoAdvance: false,
                selectable: true,
                slideInterval: <?php echo $wpss_options['wpss_slideInterval']; ?>,
                transitionSpeed: <?php echo $wpss_options['wpss_transitionSpeed']; ?>,
                shuffle: false,
                startSlideIndex: <?php echo $wpss_options['wpss_startSlideIndex']; ?>, //0-based
                pauseOnHover: <?php echo ($wpss_options['wpss_pauseOnHover'] == '1') ? 'true' : 'false'; ?>,
                initSliderByCallingInitFunc: false,
                rightGap: "default",
                keyboardNav: <?php echo ($wpss_options['wpss_keyboardNav'] == '1') ? 'true' : 'false'; ?>,
                mousewheelNav: <?php echo ($wpss_options['wpss_mousewheelNav'] == '1') ? 'true' : 'false'; ?>,
                before: null,
                license: "mylicense"
            };

    var thumbs2Op =
            {
                sliderId: "thumbs2",
                orientation: "vertical",
                thumbWidth: '<?php echo $wpss_options['wpss_t_thumbWidth']; ?>%',
                thumbHeight: "auto",
                showMode: 3,
                autoAdvance: false,
                selectable: true,
                slideInterval: <?php echo $wpss_options['wpss_t_slideInterval']; ?>,
                transitionSpeed: <?php echo $wpss_options['wpss_t_transitionSpeed']; ?>,
                shuffle: false,
                startSlideIndex: <?php echo $wpss_options['wpss_t_startSlideIndex']; ?>, //0-based
                pauseOnHover: <?php echo ($wpss_options['wpss_t_pauseOnHover'] == '1') ? 'true' : 'false'; ?>,
                initSliderByCallingInitFunc: true,
                rightGap: 0,
                keyboardNav: <?php echo ($wpss_options['wpss_t_keyboardNav'] == '1') ? 'true' : 'false'; ?>,
                mousewheelNav: <?php echo ($wpss_options['wpss_t_mousewheelNav'] == '1') ? 'true' : 'false'; ?>,
                before: null,
                license: "mylicense"
            };

    var mcThumbnailSlider = new ThumbnailSlider(thumbnailSliderOptions);
    var mcThumbs2 = new ThumbnailSlider(thumbs2Op);
</script>
<div style="padding:260px 0;background:<?php echo $wpss_options['background_color']; ?>;">
    <div id="thumbnail-slider">
        <div class="inner">
            <ul>
                <?php
                if (!empty($wpss_olt_option)) {
                    foreach ($wpss_olt_option as $key => $value) {
                        if (!empty($value['slider_image'])) {
                            ?>
                            <li>
                                <a class="thumb" href="<?php echo $wpss_model->wpss_escape_url($value['slider_image']); ?>"></a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div id="thumbs2" style="display:none;">
        <div class="inner">
            <ul>
                <?php
                if (!empty($wpss_olt_option)) {
                    foreach ($wpss_olt_option as $key => $value) {
                        if (!empty($value['slider_image'])) {
                            ?>
                            <li>
                                <a class="thumb" href="<?php echo $wpss_model->wpss_escape_url($value['slider_image']); ?>"></a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div id="closeBtn">CLOSE</div>
    </div>
</div>