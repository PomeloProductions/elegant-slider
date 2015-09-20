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
            "deleted_at" => "DATETIME"
        ];
    }
}
