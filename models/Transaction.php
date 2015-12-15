<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 8/6/15
 * Time: 8:31 AM
 */

namespace models;

use system\library\Database\Model;

class Transaction extends Model {
    protected static $db_fields = array("id","trans_id","merch_app_id","cus_app_id","cus_bank_no","merch_bank_no",
        "cus_bank_name","merch_bank_name","cus_bank_code","merch_bank_code","trans_type","narration","trans_status","created_at","updated_at");
    protected static $table ="transactions";



    public $id;
    public $trans_id;
    public $merch_app_id;
    public $cus_app_id;
    public $cus_bank_no;
    public $merch_bank_no;
    public $cus_bank_name;
    public $merch_bank_name;
    public $cus_bank_code;
    public $merch_bank_code;
    public $trans_type;
    public $narration;
    public $trans_status;
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