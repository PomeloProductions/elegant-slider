<?php
/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 3:17 PM
 */

namespace ElegantSlider\Model;


use DateTime;
use WordWrap\ORM\BaseModel;

class Image extends BaseModel{
    /**
     * @var int the id of the image
     */
    public $id;
    /**
     * @var string the name of the image
     */
    public $name;
    /**
     * @var string the description of the image
     */
    public $description;
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
     * @var string in correspondence with the previous variable this will be '_blank' or '_self' defautls to '_self'
     */
    public $image_link_target = '_self';
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

    public function prepareExport() {
        $this->name = apply_filters("elegant_slider/image_name", $this->name);
        $this->name = addslashes($this->name);

        $this->description = apply_filters("elegant_slider/image_description", $this->description);
        $this->description = addslashes($this->description);
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
            "name" => "TEXT",
            "description" => "TEXT",
            "order" => "INTEGER(11)",
            "image_url" => "TEXT",
            "image_link" => "VARCHAR(255)",
            "image_link_target" => "VARCHAR(20) NOT NULL DEFAULT _self",
            "deleted_at" => "DATETIME"
        ];
    }
}