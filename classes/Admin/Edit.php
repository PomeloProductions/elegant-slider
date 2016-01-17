<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/15/16
 * Time: 3:35 PM
 */

namespace ElegantSlider\Admin;


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

        if ($this->slider == null)
            wp_redirect("Location: admin.php?page=elegant_slider&task=view_sliders");
    }

    /**
     * override to render the main page
     */
    protected function renderMainContent() {

        $this->slider->prepareEdit($this->lifeCycle);

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