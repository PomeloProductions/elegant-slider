/**
 * Created by bryce on 10/22/15.
 */

jQuery(document).ready(function() {
    jQuery('.bxslider#{{id}}').magnificPopup({
        delegate: 'img', // child items selector, by clicking on it popup will open
        type: 'image',
        image: {
            titleSrc: 'data-title'
        },
        gallery: {
            enabled: true
        }
    });
});