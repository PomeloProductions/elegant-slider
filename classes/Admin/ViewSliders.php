<?php

/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/15/16
 * Time: 12:27 PM
 */
namespace ElegantSlider\Admin;

use ElegantSlider\Model\Slider;
use WordWrap\Admin\TaskController;
use WordWrap\Assets\Template\Mustache\MustacheTemplate;

class ViewSliders extends TaskController {

    /**
     * override this to setup anything that needs to be done before
     * @param $action string the action the user is trying to complete
     */
    public function processRequest($action = null) {
        // TODO: Implement processRequest() method.
    }

    /**
     * override to render the main page
     */
    protected function renderMainContent() {

        $sliders = ["sliders" => Slider::all()];

        $template = new MustacheTemplate($this->lifeCycle, "admin/list_sliders", $sliders);

        return $template->export();
    }

    /**
     * override to render the main page
     */
    protected function renderSidebarContent() {
        // TODO: Implement renderSidebarContent() method.
    }
}