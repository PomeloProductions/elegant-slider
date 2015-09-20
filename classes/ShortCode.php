<?php
/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 5:41 PM
 */

namespace ElegantSlider;


use ElegantSlider\Model\Slider;
use WordWrap\Assets\View\View;
use WordWrap\Assets\View\ViewCollection;
use WordWrap\ShortCodeScriptLoader;

class ShortCode extends ShortCodeScriptLoader{

    /**
     * @param  $atts shortcode inputs
     * @return string shortcode content
     */
    public function handleShortcode($atts) {
        $exportedHTML = 'hello word';
        $slider = Slider::find_one($atts['id']);
        $images = $slider->getImages();

        $imageCollection = $this->buildCollection($images);
        return $imageCollection->export();
    }

    /**
     * Example:
     *   wp_register_script('my-script', plugins_url('js/my-script.js', __FILE__), array('jquery'), '1.0', true);
     *   wp_print_scripts('my-script');
     * @return void
     */
    public function addScript() {
        // TODO: Implement addScript() method.
    }

    private function buildCollection($images) {
        $imageCollection = new ViewCollection($this->lifeCycle, "slider");

        foreach ($images as $image){
            $imageView = new View($this->lifeCycle, "image");

            $imageView->setTemplateVar("image_url", $image->image_url);

            $imageCollection->addChildView("image", $imageView);
        }
        return $imageCollection;
    }
}