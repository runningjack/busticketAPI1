<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/5/15
 * Time: 6:12 AM
 */

namespace system\library\Hashing;


interface Hashinginterface {
    public static function make($value, array $options = array());

    public static function check($value,$hashed, array $options = array());
} 