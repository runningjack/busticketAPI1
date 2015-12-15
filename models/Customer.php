<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/2/15
 * Time: 7:31 AM
 */

namespace models;
use system\library\Database\Model;
use system\library\Validator\Validator;
use system\library\Validator\Validate\Unique;

class Customer extends  Model{
    protected  static $db_fields=array('id','app_id','hashed','key_salt','ip','firstname','lastname','phone','email','username','password','verified','disabled','device_IMEI','address','city','state','created_at','updated_at');
    protected static $table ="customers";

    public  $id;
    public  $app_id;
    public  $hashed;
    public  $key_salt;
    public  $firstname;
    public  $lastname;
    public  $phone;
    public  $email;
    public  $username;
    public  $password;
    public  $verified;
    public  $disabled;
    public  $ip;
   // public  $device_IMEI;
    public  $address;
    public  $city;
    public  $state;
    public  $created_at;
    public  $updated_at;



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



    public function validateUniqueEmailFailed(array $data){
        $v = new Validator($data, array(
            new Unique("email","field must be unique","customer")
        ));

        if (! $v->execute()) {
            print_r($v->getErrors());
        }else{
            return true;
        }
    }
} 