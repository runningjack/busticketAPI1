<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 6/7/15
 * Time: 2:42 PM
 */

namespace system\library\Database;

class Model extends Database {
    protected static  $db_fields = array();
    protected static $table;

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

    public static function all(){
        $result_set =self::find_by_sql("SELECT * FROM ".static::$table." ");
        return $result_set;
    }

    public static function find($id){
        $instance = new static;
        $sql =  $instance->query("SELECT * FROM ".static::$table." where id = ".$id );
        if($sql->execute()){
            //$result_set =$sql->fetch(PDO::FETCH_ASSOC) ;
            $object_array = array();
            while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
                $object_array[] = static::instantiate($row);
            }
            return !empty($object_array) ? array_shift($object_array) : false;
        }
    }




    public static function find_by_sql($sql="") {
        $instance = new static;
        $object_array =array();
        $sql =  $instance->query($sql);
        if($sql->execute()){
            while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
                $object_array[] = self::instantiate($row);
            }
            if(($object_array)){
                return $object_array;
            }else{
                return false;
            }
        }
    }

    public function fill(array $attributes)
    {
       // $totallyGuarded = $this->totallyGuarded();
        foreach ($attributes as $key => $value)
        {
            $this->setAttribute($key, $value);
        }
        return $this;
    }

    public function getColumnNames(){
        $sql = "select column_names from information_schema.columns where table_name = ".$this->table;
        #$sql = 'SHOW COLUMNS FROM ' . $this->table;
        $stmt = $this->prepare($sql);
        try {
            if($stmt->execute()){
            var_dump($stmt);
                $raw_column_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($raw_column_data as $outer_key => $array){
                    foreach($array as $inner_key => $value){
                        if (!(int)$inner_key){
                            $this->column_names[] = $value;
                        }
                    }
                }
            }
            return $this->column_names;
        } catch (Exception $e){
            return $e->getMessage(); //return exception
        }
    }

    public function create(){

        $instance = new self;
        $attributes = $this->attributes();
        unset($attributes['id']);
        foreach($attributes as $key=>$value){
            if($value == null){
                unset($attributes[$key]);
            }
        }
        $sql = "INSERT INTO ".static::$table."  (";
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
                $this->id = $instance->lastInsertId();

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

   /* public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }*/


    public  function update(){
        $instance = new static;
        $attributes = $this->attributes();
        $attribute_pairs = array();


        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}=:{$key}";
        }
        $sql = "UPDATE ".static::$table." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=:id";

        try{
            $prep = $instance->prepare($sql);
            foreach($attributes as $key=>$value){
                $prep->bindValue(':'.$key, $value);
            }

            //var_dump($prep);

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

    public  function delete(){
        $instance = new self;
        $sql = "DELETE FROM ".static::$table." WHERE id=".$this->id;
        $prep = $instance->prepare($sql);
        try{
            if ($prep->execute()){
                return true ;
            }else{
                return   false;
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }catch(\PDOException $e){
            echo $e->getMessage();
        }

    }
} 