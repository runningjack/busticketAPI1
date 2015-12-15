<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/10/15
 * Time: 11:55 PM
 */

namespace models;


use system\library\Database\Model;

class Tickets extends Model {
    protected  static $db_fields=array('id','code','serial_no','terminal_id','route_id','stack_id','ticket_type','amount','status','created_at','updated_at');
    protected static $table ="tickets";

    public $id;
    public $code;
    public $serial_no;
    public $terminal_id;
    public $route_id;
    public $stack_id;
    public $ticket_type;
    public $amount;
    public $status;
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