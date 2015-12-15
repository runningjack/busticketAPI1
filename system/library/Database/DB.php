<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/5/15
 * Time: 9:15 AM
 */

namespace system\library\Database;


class DB extends Database {
    public $id;
    protected static  $db_fields = array();

    protected  static function instantiate($record) {
        // Could check that $record exists and is an array
        $object = new static;
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    protected static function has_attribute($attribute) {
        //if object has attributes and return object attributes
        $instance = new static;
        $object_vars = $instance->attributes();
        return array_key_exists($attribute, $object_vars);
    }

    protected   function attributes(){
        //return get_object_vars($this);
        $instance = new static;
        $attributes = array();
        foreach(static::$db_fields as $field){
            if(property_exists($this,$field)){
                $attributes[$field] =$this->$field;
            }
        }
        return $attributes;
    }
    public static function insert($table,array $params = array()){

        $attributes = $params;
        $instance = new self;

        $sql = "INSERT INTO ".$table."  (";
        $sql .= join(", ", array_keys($attributes));
        $sql .=")VALUES(";
        $sql .= ":";
        $sql .= join(", :", array_keys($attributes));
        $sql .=")";
        try{
            $prep = $instance->prepare($sql);

            foreach($attributes as $key=>$value){

                $prep->bindValue(':'.$key, $value);
            }

            if ($prep->execute()){
                $instance->id = $instance->lastInsertId();

                return true;
            }
            else{
                throw new \Exception("data could not be saved");//return false;
            }
        }catch (\PDOException $e){
            echo $e->getMessage();
        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }

    public static   function update($table,array $params = array()){
        $instance = new static;
        $attributes = $params;
        $attribute_pairs = array();


        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}=:{$key}";
        }
        $sql = "UPDATE ".$table." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=:id";

        try{
            $prep = $instance->prepare($sql);
            foreach($attributes as $key=>$value){
                $prep->bindValue(':'.$key, $value);
            }
            if ($prep->execute()){
                return true ;
            }else{
                return   false;
            }
        }catch (\PDOException $e){
            echo $e->getMessage();
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public static function find($id,$table){
        $instance = new static;
        $sql =  $instance->query("SELECT * FROM ".$table." where id = ".$id );
        if($sql->execute()){
            //$result_set =$sql->fetch(PDO::FETCH_ASSOC) ;
            $object_array = array();
            while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
                $object_array[] = $row;
            }
            return !empty($object_array) ? array_shift($object_array) : false;
        }
    }

    public static function find_by_sql($sql="") {
        $instance = new static;
        //$object_array =[];
        $object_array = array();
        $sql =  $instance->query($sql);
        if($sql->execute()){
            while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
                $object_array[] = $row;
            }
            if(($object_array)){
                return $object_array;
            }else{
                return false;
            }
        }
    }
} 