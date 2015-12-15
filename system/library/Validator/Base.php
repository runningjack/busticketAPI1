<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/12/15
 * Time: 9:54 PM
 */

namespace system\library\Validator;


 abstract class Base {
    protected $field = "";
    protected $errorMessage ="";
    protected $data = array();

    abstract public function execute( array $data);

    public function __construct($field,$errMsg ){
        $this->field = $field;
        $this->errorMessage = $errMsg;
    }

    public function getErrorMessage($field){
        return $field." ".$this->errorMessage;
    }

    public function getField(){
        if (is_array($this->field)) {
            return $this->field[0];
        }
        return $this->field;
    }
} 