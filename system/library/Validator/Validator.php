<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/12/15
 * Time: 9:58 PM
 */

namespace system\library\Validator;
use system\library\Validator\Validate;

class Validator {

    private $data = array();//data to be validated
    private $errors = array();
    private $validators = array();

    public function __construct(array $validators,array $data){
        $this->data = $data;
        $this->validators = $validators;
    }

    public function execute(){
        $result = true;

        foreach($this->validators as $validator){

            if(!$validator->execute($this->data)){
                $this->addError(
                    $validator->getField(),
                    $validator->getErrorMessage($validator->getField())
                );
                $result = false;
            }
        }

        return $result;
    }

    public function addError($field,$message){
        if(isset($this->errors[$field])){
            $this->errors[$field] = array();
        }
        $this->errors[$field][] = $message;
    }

    public function getErrors(){
        return $this->errors;
    }

} 