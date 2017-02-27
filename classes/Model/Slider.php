<?php

/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 3:05 PM
 */
namespace ElegantSlider\Model;

use DateTime;
use WordWrap\LifeCycle;
use WordWrap\ORM\BaseModel;

class Slider extends BaseModel{
    /**
     * @var int the primary id of this slider
     */
    public $id;
    /**
     * @var string the name of this slider
     */
    public $name;
    /**
     * @var string a description of this slider
     */
    public $description;
    /**
     * @var bool whether or not to use autoplay
     */
    public $auto_play = false;
    /**
     * @var int speed of the auto play
     */
    public $auto_play_pause_speed = 4000;
    /**
     * @var int the slide that we want to start on
     */
    public $start_slide = 0;
    /**
     * @var bool whether or not this slider has fluid touch between elements
     */
    public $fluid_touch = false;
    /**
     * @var bool whether or not to use the paging element in the slider
     */
    public $pager = false;
    /**
     * @var bool whether or not this plugin uses a light box plugin
     */
    public $light_box = false;
    /**
     * @var bool whether or not this slider is only a popup
     */
    public $popup_only = false;
    /**
     * @var string the text of the link that will display when this slider is a popup
     */
    public $popup_link_text;
    /**
     * @var Image[] the images that belong to this slider
     */
    public $images = [];
    /**
     * @var int the total amount of images in the slider
     */
    public $count = 0;

    /**
     * Constructor.
     *
     * @param array $properties
     */
    public function __construct(array $properties = array()) {
        parent::__construct($properties);

        $this->loadImages();

        $this->count = count($this->images);
    }

    /**
     * Overwrite this in your concrete class. Returns the table name used to
     * store models of this class.
     *
     * @return string
     */
    public static function getTableName(){
        return "elegant_slider_slider";
    }

    /**
     * loads the image variables into memory
     */
    public function loadImages() {
        $this->images = Image::fetchImagesForSlider($this);
    }

    /**
     * creates the first instant of an image
     */
    public function createPlaceholderImage() {
        $this->images = [];

        $this->images[] = Image::create(["id" => 0]);
    }

    /**
     * prepares all images for exporting to a page
     */
    public function prepareExport() {
        foreach ($this->getImages() as $image) {

            $image->prepareExport();
        }
    }

    /**
     * prepares this slider to be edited
     * @param LifeCycle $lifeCycle
     */
    public function prepareEdit(LifeCycle $lifeCycle) {
        foreach ($this->getImages() as $image) {
            $image->prepareEdit($lifeCycle);
        }
    }


    /**
     * @return Image[]
     */
    public function getImages(){
        if(!count($this->images))
            $this->loadImages();

        return $this->images;
    }

    /**
     * @return Slider[] all active sliders
     */
    public static function fetchAllActive() {
        $SQL = "SELECT * FROM `" . static::getFullTableName() . "` WHERE `deleted_at` IS NULL";
        global $wpdb;

        $results = $wpdb->get_results($SQL, ARRAY_A);

        $sliders = [];

        foreach ($results as $row) {
            $sliders[] = new Slider($row);
        }

        return $sliders;
    }

    /**
     * Get an array of fields to search during a search query.
     *
     * @return array
     */
    public static function getSearchableFields(){
        // TODO: Implement get_searchable_fields() method.
    }

    /**
     * Get an array of all fields for this Model with a key and a value
     * The key should be the name of the column in the database and the value should be the structure of it
     *
     * @return array
     */
    public static function getFields(){
        return [
            "name" => "TEXT",
            "description" => "TEXT",
            "auto_play" => "TINYINT(4) DEFAULT '0'",
            "fluid_touch" => "TINYINT(4) DEFAULT '0'",
            "pager" => "TINYINT(4) DEFAULT '0'",
            "light_box" => "TINYINT(4) DEFAULT '0'",
            "start_slide" => "INTEGER(11) DEFAULT '0'",
            "auto_play_pause_speed" => "INTEGER(11) DEFAULT '4000'",
            "popup_only" => "INTEGER(11) DEFAULT '0'",
            "popup_link_text" => "TEXT"
        ];
    }
}
