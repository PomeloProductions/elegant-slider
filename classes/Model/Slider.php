<?php

/**
 * Created by PhpStorm.
 * User: Quixotical
 * Date: 9/20/15
 * Time: 3:05 PM
 */
namespace ElegantSlider\Model;
use DateTime;
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
    public $auto_play_speed = 4000;
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
     * @var Image[] the images that belong to this slider
     */
    private $images = null;
    /**
     * @var DateTime the date that this slider was deleted
     */
    public $deleted_at;

    /**
     * Overwrite this in your concrete class. Returns the table name used to
     * store models of this class.
     *
     * @return string
     */
    public static function get_table(){
        return "wp_elegant_slider_slider";
    }

    /**
     * @return Image[]
     */
    public function getImages(){
        if(!$this->images)
            $this->images = Image::fetchImagesForSlider($this);

        return $this->images;
    }
    /**
     * Get an array of fields to search during a search query.
     *
     * @return array
     */
    public static function get_searchable_fields(){
        // TODO: Implement get_searchable_fields() method.
    }

    /**
     * Get an array of all fields for this Model with a key and a value
     * The key should be the name of the column in the database and the value should be the structure of it
     *
     * @return array
     */
    public static function get_fields(){
        return [
            "name" => "TEXT",
            "description" => "TEXT",
            "deleted_at" => "DATETIME",
            "auto_play" => "TINYINT(4) DEFAULT '0'",
            "fluid_touch" => "TINYINT(4) DEFAULT '0'",
            "pager" => "TINYINT(4) DEFAULT '0'",
            "light_box" => "TINYINT(4) DEFAULT '0'",
            "start_slide" => "INT(11) DEFAULT '0'",
            "auto_play_speed" => "INTEGER(11) DEFAULT '4000'"
        ];
    }
}
