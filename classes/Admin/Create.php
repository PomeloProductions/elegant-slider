<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/15/16
 * Time: 3:34 PM
 */

namespace ElegantSlider\Admin;



use ElegantSlider\Model\Slider;

class Create extends Edit {

    /**
     * @param null $action
     */
    public function processRequest($action = null) {

        $this->slider = Slider::create([]);

        $this->slider->createPlaceholderImage();

        parent::processRequest($action);

        if ($this->slider->id)
            wp_redirect("admin.php?page=elegant_slider&task=edit_slider&id=" . $this->slider->id);
    }

    /**
     * @return string
     */
    public function renderMainContent() {
        return parent::renderMainContent(true);
    }
}