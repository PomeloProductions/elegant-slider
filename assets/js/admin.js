/**
 * Created by bryce on 1/15/16.
 */
jQuery(document).ready(function () {
    jQuery('#arrows-type input[name="params[slider_navigation_type]"]').change(function(){
        jQuery(this).parents('ul').find('li.active').removeClass('active');
        jQuery(this).parents('li').addClass('active');
    });
    jQuery('#slider-loading-icon li').click(function(){ //alert(jQuery(this).find("input:checked").val());
        jQuery(this).parents('ul').find('li.act').removeClass('act');
        jQuery(this).addClass('act');
    });
    jQuery('.slider-options .save-slider-options').click(function(){
        alert("General Settings are disabled in free version. If you need those functionalityes, you need to buy the commercial version.");
    });

    jQuery('input[data-slider="true"]').bind("slider:changed", function (event, data) {
        jQuery(this).parent().find('span').html(parseInt(data.value)+"%");
        jQuery(this).val(parseInt(data.value));
    });

    jQuery('.help').hover(function(){
        jQuery(this).parent().find('.help-block').removeClass('active');
        var width=jQuery(this).parent().find('.help-block').outerWidth();
        jQuery(this).parent().find('.help-block').addClass('active').css({'left':-((width /2)-10)});
    },function() {
        jQuery(this).parent().find('.help-block').removeClass('active');
    });

});


jQuery(document).ready(function($){
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;


    jQuery('.huge-it-newuploader .button').click(function(e) {
        var send_attachment_bkp = wp.media.editor.send.attachment;

        var button = jQuery(this);
        var id = button.attr('id').replace('_button', '');
        _custom_media = true;

        jQuery("#"+id).val('');
        wp.media.editor.send.attachment = function(props, attachment){
            if ( _custom_media ) {
                jQuery("#"+id).val(attachment.url+';;;'+jQuery("#"+id).val());
                jQuery("#save-buttom").click();
            } else {
                return _orig_send_attachment.apply( this, [props, attachment] );
            };
        }

        wp.media.editor.open(button);

        return false;
    });

    jQuery('.add_media').on('click', function(){
        _custom_media = false;

    });
});

jQuery(document).ready(function ($) {
    jQuery("#slideup").click(function () {
        window.parent.uploadID = jQuery(this).prev('input');
        formfield = jQuery('.upload').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });
    window.send_to_editor = function (html) {
        imgurl = jQuery('img', html).attr('src');
        window.parent.uploadID.val(imgurl);
        tb_remove();
        jQuery("#save-buttom").click();
    };
});
