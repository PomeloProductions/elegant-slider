<?php
/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 5:41 PM
 */

namespace ElegantSlider;


use ElegantSlider\Model\Image;
use ElegantSlider\Model\Slider;
use WordWrap\Assets\Script\JavaScript;
use WordWrap\Assets\StyleSheet\CSS;
use WordWrap\Assets\Template\Mustache\MustacheTemplate;
use WordWrap\Assets\View\View;
use WordWrap\Assets\View\ViewCollection;
use WordWrap\ShortCodeLoader;
use WordWrap\ShortCodeScriptLoader;

class ShortCode extends ShortCodeLoader{


    private static $echoedMagnificAssets = false;
    /**
     * @param  $atts shortcode inputs
     * @return string shortcode content
     */
    public function onShortcode($atts) {
        $exportedContent = '';

        $slider = Slider::find_one($atts['id']);

        if ($slider) {

            $slider->loadImages();

            $slider->prepareExport();

            if ($slider->popup_only) {

                $exportedContent.= $this->loadMagnificAssets();

                $template = new MustacheTemplate($this->lifeCycle, "popup_link", $slider);

                $exportedContent.= $template->export();
            }
            else {

                $css = new CSS($this->lifeCycle, "jquery.bxslider");

                $css->setTemplateVar("plugin_directory", plugin_dir_url(__DIR__ . "../"));
                $exportedContent.= $css->export();

                $images = $slider->getImages();


                $sliderView = new ViewCollection($this->lifeCycle, "slider");

                $sliderView->setTemplateVar("title", $slider->name);
                $sliderView->setTemplateVar("subtitle", $slider->description);
                $sliderView->setTemplateVar("id", $slider->id);

                $sliderView = $this->buildCollection($sliderView, $images);
                $exportedContent .= $sliderView->export();

                $js = new JavaScript($this->lifeCycle, "jquery.bxslider");
                $exportedContent .= $js->export();
                $js = new JavaScript($this->lifeCycle, "plugin");

                $js->setTemplateVar('id', $slider->id);
                $js->setTemplateVar('auto_play', $slider->auto_play ? 'true' : 'false');
                $js->setTemplateVar('fluid_touch', $slider->fluid_touch ? 'true' : 'false');
                $js->setTemplateVar('pager', $slider->pager ? 'true' : 'false');
                $js->setTemplateVar('auto_play_speed', $slider->auto_play_pause_speed);
                $js->setTemplateVar("start_slide", $slider->start_slide);

                if ($slider->light_box)
                    $exportedContent .= $this->buildLightBox($slider);

                $exportedContent .= $js->export();
            }
        }

        return $exportedContent;
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

    /**
     * @param ViewCollection $sliderView the parent view of the images
     * @param $images Image[] all images associated with this slider
     * @return ViewCollection the same sliderView, but with all images added to it
     */
    private function buildCollection(ViewCollection $sliderView, $images) {

        foreach ($images as $image){
            $layout = $image->image_link ? "image_link" : "image";
            $imageView = new View($this->lifeCycle, $layout);

            $imageView->setTemplateVar("image_url", $image->image_url);
            $imageView->setTemplateVar("image_name", $image->name);
            $imageView->setTemplateVar("image_description", $image->description);

            if($image->image_link) {
                $imageView->setTemplateVar("image_link", $image->image_link);
                $imageView->setTemplateVar("image_link_target", $image->image_link_new_window ? "_blank" : "_self");
            }

            $sliderView->addChildView("image", $imageView);
        }
        return $sliderView;
    }

    /**
     * @param Slider $slider the slider we are building a light box for
     * @return string the content of the light box script
     */
    private function buildLightBox(Slider $slider) {

        $content = $this->loadMagnificAssets();

        $js = new JavaScript($this->lifeCycle, "magnific");

        $js->setTemplateVar("id", $slider->id);

        $content.= $js->export();

        return $content;
    }

    /**
     * @return string loads up all assets needed for magnific
     */
    private function loadMagnificAssets() {

        $content = '';

        if (!ShortCode::$echoedMagnificAssets) {
            $css = new CSS($this->lifeCycle, "magnific-popup");

            $content = $css->export();

            $js = new JavaScript($this->lifeCycle, "jquery.magnific-popup.min");

            $content .= $js->export();

            ShortCode::$echoedMagnificAssets = true;

        }
        return $content;

    }
}