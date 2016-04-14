/**
 * Created by bryce on 1/15/16.
 */

jQuery(document).ready(function() {

    ImageTemplate.init();
    WPImageEditor.init();

    ImageRemoval.init();

    EditImage.init();
});

var ImageTemplate = {

    templateContent : null,

    $imageList : null,

    newImages : 0,

    editorSettings : null,

    textAreaSettings : null,

    init : function() {

        for (var settingsName in tinyMCEPreInit.mceInit)  {
            ImageTemplate.editorSettings =
                jQuery.extend(true, {}, tinyMCEPreInit.mceInit[settingsName]);
            break;
        }

        ImageTemplate.editorSettings.body_class =
            ImageTemplate.editorSettings.body_class.replace(/description-\d+/g, "description-\{\{id\}\}");

        for (var settingsName in tinyMCEPreInit.qtInit)  {
            ImageTemplate.textAreaSettings =
                jQuery.extend(true, {}, tinyMCEPreInit.qtInit[settingsName]);
            break;
        }

        ImageTemplate.$imageList = jQuery("#images-list");
        var $image = jQuery(ImageTemplate.$imageList.find("li")[0].cloneNode(true));

        $image.find(".wp-editor-wrap").removeClass("html-active");
        $image.find(".wp-editor-wrap").addClass("tmce-active");

        $image.find(".image-container").find("img").attr("src", "");

        $image.find(".image_url_input").attr("value", "");
        $image.find(".url-input").attr("value", "");
        $image.find(".title_input").attr("value", "");
        $image.find(".link_target").removeAttr("checked");

        $image.find("textarea").html("");

        var html = $image.clone().wrap("<div></div>").parent().html();
        html = html.replace(/description-\d+/g, "description-\{\{id\}\}");
        html = html.replace(/image_link-\d+/g, "image_link-\{\{id\}\}");
        html = html.replace(/image_url-\d+/g, "image_url-\{\{id\}\}");
        html = html.replace(/link_target-\d+/g, "link_target-\{\{id\}\}");
        html = html.replace(/name-\d+/g, "title-\{\{id\}\}");
        html = html.replace(/id=\d+/g, "id=\{\{id\}\}");

        ImageTemplate.templateContent = html;
    },

    duplicateImage : function(url) {

        var newHtml = ImageTemplate.templateContent;

        newHtml = newHtml.replace(/\{\{id}}/g, "new-" + ImageTemplate.newImages);

        var $newTemplate = jQuery(newHtml);

        $newTemplate.find(".image-container").find("img").attr("src", url);
        $newTemplate.find(".image_url_input").val(url);

        $newTemplate.find(".add_media").click(WPImageEditor.disableCustomMedia);

        ImageTemplate.$imageList.append($newTemplate);

        var newEditorSettings =
            jQuery.extend(true, {}, ImageTemplate.editorSettings);

        newEditorSettings.body_class =
            newEditorSettings.body_class.replace(/\{\{id}}/g, "new-" + ImageTemplate.newImages);
        newEditorSettings.selector = "#description-new-" + ImageTemplate.newImages;

        tinyMCEPreInit.mceInit["description-new-" + ImageTemplate.newImages] = newEditorSettings;
        tinyMCE.init(tinyMCEPreInit.mceInit["description-new-" + ImageTemplate.newImages]);

        var newTextAreaSettings =
            jQuery.extend(true, {}, ImageTemplate.textAreaSettings);
        newTextAreaSettings.id = "description-new-" + ImageTemplate.newImages;
        tinyMCEPreInit.qtInit["description-new-" + ImageTemplate.newImages] = newTextAreaSettings;
        quicktags(tinyMCEPreInit.qtInit["description-new-" + ImageTemplate.newImages]);

        ImageTemplate.newImages++;
    }
};

var WPImageEditor = {

    newImage : false,
    editingImage : false,
    origSendAttachment : null,

    editingId : 0,

    init : function() {
        WPImageEditor.origSendAttachment =  wp.media.editor.send.attachment;

        jQuery(".add-new-image-button").click(WPImageEditor.addNewImage);
        jQuery(".edit_image").click(WPImageEditor.editImage);
    },

    addNewImage : function() {

        WPImageEditor.newImage = true;
        WPImageEditor.editingImage = false;

        var button = jQuery(this);

        wp.media.editor.send.attachment = WPImageEditor.handleResult;

        wp.media.editor.open(button);
        return false;
    },

    editImage : function() {

        WPImageEditor.newImage = false;
        WPImageEditor.editingImage = true;

        WPImageEditor.editingId = jQuery(this).data("id");

        var button = jQuery(this);

        wp.media.editor.send.attachment = WPImageEditor.handleResult;

        wp.media.editor.open(button);
        return false;
    },

    handleResult : function(props, attachment){
        switch (true) {
            case WPImageEditor.newImage:
                ImageTemplate.duplicateImage(attachment.url);
                break;
            case WPImageEditor.editingImage:
                jQuery(".preview_image_url-" + WPImageEditor.editingId).attr("src", attachment.url);
                jQuery(".image_url-" + WPImageEditor.editingId).val(attachment.url);
                break;
            default:
                return WPImageEditor.origSendAttachment.apply( this, [props, attachment] );
        }


        return true;
    }
};

var ImageRemoval = {

    init : function() {
        jQuery(".remove-image").click(ImageRemoval.remove);
    },

    remove : function(event) {
        event.preventDefault();

        var $li = jQuery(this).closest("li").hide();

        $li.find("input,textarea").remove();
    }
};

/**
 * Used to init
 */
var EditImage = {

    $popUpLinkTextWrapper : null,

    /**
     * Runs in order to initialize image editing
     */
    init : function() {

        EditImage.$popUpLinkTextWrapper = jQuery("#popup_link_text-wrapper");

        jQuery("#popup_only").change(EditImage.toggleOnlyPopUp);
    },

    /**
     * Called when the pop up only checkbox changes, toggles different events
     */
    toggleOnlyPopUp : function() {
        if (this.checked) {
            EditImage.$popUpLinkTextWrapper.show();
        }
        else {
            EditImage.$popUpLinkTextWrapper.hide();
        }
    }
};



// Legacy code from previous plugin, most of this can be removed
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

jQuery(function() {
    jQuery( "#images-list" ).sortable({
        stop: function() {
            jQuery("#images-list li").removeClass('has-background');
            count=jQuery("#images-list li").length;
            for(var i=0;i<=count;i+=2){
                jQuery("#images-list li").eq(i).addClass("has-background");
            }
            jQuery("#images-list li").each(function(){
                jQuery(this).find('.order_by').val(jQuery(this).index());
            });
        },
        revert: true
    });
    // jQuery( "ul, li" ).disableSelection();
});

jQuery(document).ready(function($){


    jQuery('.huge-it-newuploader .button').click(function(e) {

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
    //This is causing a console error nt sure why
    window.send_to_editor = function (html) {
        imgurl = jQuery('img', html).attr('src');
        window.parent.uploadID.val(imgurl);
        tb_remove();
        jQuery("#save-buttom").click();
    };
});
