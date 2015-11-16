/**
 * Created by Quixotical on 9/20/15.
 */
jQuery(document).ready(function(){
    jQuery('.bxslider').bxSlider({
        'startSlide' : 1,
        'lockToSlide' : false,
        'auto' : {{auto_play}},
        'pause' : {{auto_play_speed}},
        'touchEnabled' : {{fluid_touch}},
        'oneToOneTouch' : {{fluid_touch}},
        'pager' : {{pager}},
        "onSliderLoad" : function() {
            jQuery(".bxslider.slider-{{id}} li:not(.bx-clone) img").addClass("bx-original");
        }
    });
});