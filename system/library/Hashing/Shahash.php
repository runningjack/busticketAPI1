<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/5/15
 * Time: 6:28 AM
 */

namespace system\library\Hashing;


class Shahash implements Hashinginterface {
    public static function make($value,array $options = array()){

        return sha1($value . $options['number'] . $options['key_salt']);
    }

    public static function check($value="",$hashed,array $options=array()){

        if($hashed == sha1($options["pin"] . $options['number'] . $options['key_salt']) ){
            return true;
        }else{
            return false;
        }

    }
} 