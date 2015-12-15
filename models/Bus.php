<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/10/15
 * Time: 11:32 PM
 */

namespace models;
use system\library\Database\Model;
use system\library\Validator\Validator;
use system\library\Validator\Validate\Unique;

class Bus extends  Model {
    protected  static $db_fields=array('id','model','plate_no','chases_no','bus_color','route_id','number_of_sitters','driver','conductor','created_at','updated_at');
    protected static $table ="buses";
    public  $id;
    public $model;
    public $plate_no;
    public $chases_no;
    public $bus_color;
    public $route_id;
    public $number_of_sitters;
    public $driver;
    public $conductor;
    public $created_at;
    public $updated_at;

    protected   function attributes(){
        //return get_object_vars($this);
        $instance = new static;
        $attributes = array();
        foreach(self::$db_fields as $field){
            if(property_exists($this,$field)){
                $attributes[$field] =$this->$field;
            }
        }

        return $attributes;
    }
} 