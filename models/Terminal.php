<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/11/15
 * Time: 12:11 AM
 */

namespace models;


use system\library\Database\Model;

class Terminal extends Model {
    protected static $db_fields = array("id","short_name","route_id","name","description","geodata","distance","one_way_to_fare","one_way_from_fare","created_at","updated_at");
    protected static $table="busstops";

    public $id;
    public $short_name;
    public $route_id;
    public $name;
    public $description;
    public $geodata;
    public $distance;
    public $one_way_to_fare;
    public $one_way_from_fare;
    public $created_at;
    public $updated_at;

    protected   function attributes(){
        $attributes = array();
        foreach(self::$db_fields as $field){
            if(property_exists($this,$field)){
                $attributes[$field] =$this->$field;
            }
        }
        return $attributes;
    }
} 