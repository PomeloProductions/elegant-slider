<?php
/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 2:32 PM
 */
namespace ElegantSlider;

use ElegantSlider\Model\Image;
use ElegantSlider\Model\Slider;
use WordWrap\LifeCycle;

class Plugin extends LifeCycle{

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        Image::install_table();
        Slider::install_table();
    }
    public function addActionsAndFilters() {
        $sc = new ShortCode($this);
        $sc->register('elegant_slider');
    }
}