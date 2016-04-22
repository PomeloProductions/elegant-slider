<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/15/16
 * Time: 3:35 PM
 */

namespace ElegantSlider\Admin;


use ElegantSlider\Model\Image;
use ElegantSlider\Model\Slider;
use WordWrap\Admin\TaskController;
use WordWrap\Assets\Template\Mustache\MustacheTemplate;

class Edit extends TaskController {

    /**
     * @var Slider
     */
    protected $slider = null;

    /**
     * override this to setup anything that needs to be done before
     * @param $action string the action the user is trying to complete
     */
    public function processRequest($action = null) {


        if (isset($_GET["id"]))
            $this->slider = Slider::find_one($_GET["id"]);

        if (isset($action) && ($action == "edit" || $action == "create")) {

            $this->saveSliderSettings();
            $this->createImages();
        }

        if ($this->slider == null)
            wp_redirect("admin.php?page=elegant_slider&task=view_sliders");
    }

    /**
     * sets new settings and saves the slider model
     */
    private function saveSliderSettings() {

        if (isset($_POST["name"]))
            $this->slider->name = $_POST["name"];
        if (isset($_POST["auto_play"]))
            $this->slider->auto_play = $_POST["auto_play"] == "on";
        if (isset($_POST["auto_play_pause_speed"]))
            $this->slider->auto_play_pause_speed = $_POST["auto_play_pause_speed"];
        if (isset($_POST["light_box"]))
            $this->slider->light_box = $_POST["light_box"] == "on";
        if (isset($_POST["popup_only"]))
            $this->slider->popup_only = $_POST["popup_only"] == "on";
        if (isset($_POST["popup_link_text"]))
            $this->slider->popup_link_text = stripslashes($_POST["popup_link_text"]);

        $this->slider->save();
    }

    /**
     * will delete old images and create new ones
     */
    private function createImages() {

        foreach ($this->slider->getImages() as $image) {
            $image->delete();
        }
        $descriptions = [];
        $linkTargets = [];

        foreach($_POST as $key => $value) {
            if (strstr($key, "description"))
                $descriptions[] = stripslashes($value);
            if (strstr($key, "link_target"))
                $linkTargets[] = $value;
        }

        $newImages = [];

        for ($i = 0; $i < count($descriptions); $i++) {
            $image = Image::create([
                "slider_id" => $this->slider->id,
                "title" => $_POST["title"][$i],
                "description" => $descriptions[$i],
                "order" => $i + 1,
                "image_url" => $_POST["image_url"][$i],
                "image_link" => $_POST["image_link"][$i],
                "image_link_new_window" => $linkTargets[$i] == "on" ? 1 : 0
            ]);
            $image->save();

            $newImages[] = $image;
        }
        $this->slider->images = $newImages;
    }

    /**
     * override to render the main page
     * @param $create bool whether or not we are creating an element
     * @return string
     */
    protected function renderMainContent($create = false) {

        $this->slider->prepareEdit($this->lifeCycle);

        if ($create)
            $this->slider->action = "create";
        else
            $this->slider->action = "edit";

        $template = new MustacheTemplate($this->lifeCycle, "admin/edit_slider", $this->slider);

        return $template->export();
    }

    /**
     * override to render the main page
     */
    protected function renderSidebarContent() {
        // TODO: Implement renderSidebarContent() method.
    }
}