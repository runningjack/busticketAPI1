<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/16/15
 * Time: 2:39 PM
 */

namespace models;
use system\library\Model;

class Account extends Model {
    protected  static $db_fields=array('id','cus_id','app_id','account_no','bank_id','bank','created_at','updated_at');
    protected static $table ="accounts";
    public $id;
    public $cus_id;
    public $app_id;
    public $account_no;
    public $bank_id;
    public $bank;
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