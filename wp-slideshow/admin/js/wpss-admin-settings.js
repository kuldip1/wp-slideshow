'use strict';

jQuery(document).ready(function ($) {

    //reset confirmation
    jQuery(document).on("click", ".wpw-auto-poster-reset-button", function () {

        var ans;
        ans = confirm(WpdWsSettings.confirmmsg);

        if (ans) {
            return true;
        } else {
            return false;
        }

    });

    //code for color picker
    if (WpdWsSettings.new_media_ui == '1') {
        jQuery('.wpd-ws-color-box').wpColorPicker();
    } else {
        var inputcolor = jQuery('.wpd-ws-color-box').prev('input').val();
        jQuery('.wpd-ws-color-box').prev('input').css('background-color', inputcolor);

        $(".wpd-ws-color-box").on("click", function (e) {
            colorPicker = jQuery(this).next('div');
            input = jQuery(this).prev('input');
            jQuery.farbtastic(jQuery(colorPicker), function (a) {
                jQuery(input).val(a).css('background', a);
            });
            colorPicker.show();
            e.preventDefault();
            jQuery(document).mousedown(function () {
                jQuery(colorPicker).hide();
            });
        });
    }

    $('table.options tbody').sortable({
        update: function (event, ui) {
            UpdateOrder();
        }
    });
    function UpdateOrder() {
        var currAjax = null;
        var templates = new Array();



        jQuery("table tbody tr").each(function () {
            var template = new Object();
            //template.id = jQuery(this).find("input[type='checkbox']").val();
            template.slider_title = jQuery(this).find("td.name").text();
            template.slider_description = jQuery(this).find("td.description").text();
            template.slider_image = jQuery(this).find("td.image img").attr('src');
            templates.push(template);
        });

        var orderdata = {
            action: 'wpss_update_sortable',
            data: templates
        };

        jQuery.ajax({
            type: 'POST',
            beforeSend: function () {
                $(".sortableupdated").css('display', 'none');
            },
            url: wpss_ajax.ajaxurl,
            data: orderdata,
            dataType: 'text',
            success: function (response) {
                if (response == 1) {
                    $(".sortableupdated").css('display', 'block');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);

                }
            }
        });
    }



    //Image Uploader as per wordpress version
    jQuery(document).on('click', '.wpd-ws-img-uploader', function () {

        var imgfield, showimgfield;
        imgfield = jQuery(this).prev('input').attr('id');
        showimgfield = jQuery(this).next().next().next('div').attr('id'); //show uploaded image

        if (typeof wp == "undefined" || WpdWsSettings.new_media_ui != '1') {// check for media uploader

            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

            window.original_send_to_editor = window.send_to_editor;
            window.send_to_editor = function (html) {

                if (imgfield) {

                    var mediaurl = jQuery('img', html).attr('src');
                    jQuery('#' + imgfield).val(mediaurl);
                    jQuery('#' + showimgfield).html('<img src="' + mediaurl + '" alt="Image" />');
                    tb_remove();
                    imgfield = '';

                } else {

                    window.original_send_to_editor(html);

                }
            };
            return false;


        } else {

            var file_frame;

            // If the media frame already exists, reopen it.
            if (file_frame) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                frame: 'post',
                state: 'insert',
                multiple: false  // Set to true to allow multiple files to be selected
            });

            file_frame.on('menu:render:default', function (view) {
                // Store our views in an object.
                var views = {};

                // Unset default menu items
                view.unset('library-separator');
                view.unset('gallery');
                view.unset('featured-image');
                view.unset('embed');

                // Initialize the views in our view object.
                view.set(views);
            });

            // When an image is selected, run a callback.
            file_frame.on('insert', function () {

                // Get selected size from media uploader
                var selected_size = jQuery('.attachment-display-settings .size').val();

                var selection = file_frame.state().get('selection');
                selection.each(function (attachment, index) {
                    attachment = attachment.toJSON();

                    // Selected attachment url from media uploader
                    var attachment_url = attachment.sizes[selected_size].url;

                    if (index == 0) {
                        // place first attachment in field
                        jQuery('#' + imgfield).val(attachment_url);
                        jQuery('#' + showimgfield).html('<img src="' + attachment_url + '" alt="Image" />');
                    } else {
                        jQuery('#' + imgfield).val(attachment_url);
                        jQuery('#' + showimgfield).html('<img src="' + attachment_url + '" alt="Image" />');
                    }
                });
            });

            // Finally, open the modal
            file_frame.open();

        }

    });
});