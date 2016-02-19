<?php
/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 3:17 PM
 */

namespace ElegantSlider\Model;


use CollapsingContent\Admin\Edit;
use DateTime;
use WordWrap\Assets\View\Editor;
use WordWrap\ORM\BaseModel;

class Image extends BaseModel{
    /**
     * @var int the id of the image
     */
    public $id;
    /**
     * @var string the title of the image
     */
    public $title;
    /**
     * @var string the description of the image
     */
    public $description;
    /**
     * The contents of the editor for the description in the admin
     */
    public $description_editor;
    /**
     * @var int the order of the images
     */
    public $order;
    /**
     * @var string the url of the image
     */
    public $image_url;
    /**
     * @var string the url that will be opened when this image is clicked, or null if there is none
     */
    public $image_link;
    /**
     * @var bool whether or not we should open in link in a new window
     */
    public $image_link_new_window = false;
    /**
     * @var int the id of this image's slider
     */
    public $slider_id;
    /**
     * @var Slider the slider that this image belongs to
     */
    public $slider;
    /**
     * @var DateTime the date that the image was deleted
     */
    public $deleted_at;

    /**
     * @param $slider
     * @return Image[]
     */
    public static function fetchImagesForSlider($slider){

        $SQL = "SELECT * FROM `" . static::get_table() . "` WHERE `deleted_at` IS NULL AND `slider_id` = " . $slider->id . " ORDER BY `order`";
        global $wpdb;

        $results = $wpdb->get_results($SQL, ARRAY_A);

        $images = [];

        foreach ($results as $row) {
            $image = new Image($row);
            $image->slider = $slider;
            $images[] = $image;
        }

        return $images;
    }

    /**
     * gets this ready to display its content
     */
    public function prepareExport() {
        $this->name = apply_filters("elegant_slider/image_name", $this->title);
        $this->name = addslashes($this->name);

        $this->description = apply_filters("elegant_slider/image_description", $this->description);
        $this->description = addslashes($this->description);
    }

    public function delete() {
        $this->deleted_at = new DateTime();
        $this->save();
    }

    /**
     * gets this ready to be edited
     */
    public function prepareEdit($lifeCycle) {

        $editor = new Editor($lifeCycle, "description-" . $this->id, $this->description, "Image Description");
        $editor->setHeight(100);
        $editor->disableMedia();
        $this->description_editor = $editor->export();
    }

    /**
     * Overwrite this in your concrete class. Returns the table name used to
     * store models of this class.
     *
     * @return string
     */
    public static function get_table() {
        return "wp_elegant_slider_image";
    }

    /**
     * Get an array of fields to search during a search query.
     *
     * @return array
     */
    public static function get_searchable_fields() {
        // TODO: Implement get_searchable_fields() method.
    }

    /**
     * Get an array of all fields for this Model with a key and a value
     * The key should be the name of the column in the database and the value should be the structure of it
     *
     * @return array
     */
    public static function get_fields() {
        return [
            "slider_id" => "INTEGER(11) UNSIGNED",
            "title" => "TEXT",
            "description" => "TEXT",
            "order" => "INTEGER(11)",
            "image_url" => "TEXT",
            "image_link" => "VARCHAR(255)",
            "image_link_new_window" => "TINYINT(4) DEFAULT 0",
            "deleted_at" => "DATETIME"
        ];
    }
}