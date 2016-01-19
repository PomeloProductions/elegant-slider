<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/19/16
 * Time: 2:15 AM
 */

namespace ElegantSlider\Admin;


use ElegantSlider\Model\Slider;
use WordWrap\Admin\TaskController;

class DeleteSlider extends TaskController{


    /**
     * override this to setup anything that needs to be done before
     * @param $action string the action the user is trying to complete
     */
    public function processRequest($action = null) {

        if (isset($_GET["id"])) {
            $slider = Slider::find_one($_GET["id"]);

            if ($slider)
                $slider->delete();
        }

        wp_redirect("admin.php?page=elegant_slider&task=view_sliders");
    }

    /**
     * override to render the main page
     */
    protected function renderMainContent()
    {
        // TODO: Implement renderMainContent() method.
    }

    /**
     * override to render the main page
     */
    protected function renderSidebarContent()
    {
        // TODO: Implement renderSidebarContent() method.
    }
}