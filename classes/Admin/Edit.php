<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/15/16
 * Time: 3:35 PM
 */

namespace ElegantSlider\Admin;


use WordWrap\Admin\TaskController;
use WordWrap\Assets\Template\Mustache\MustacheTemplate;

class Edit extends TaskController {

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

        $template = new MustacheTemplate($this->lifeCycle, "admin/edit_slider");

        return $template->export();
    }

    /**
     * override to render the main page
     */
    protected function renderSidebarContent() {
        // TODO: Implement renderSidebarContent() method.
    }
}