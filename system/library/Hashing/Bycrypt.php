<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/5/15
 * Time: 6:34 AM
 */

namespace system\library\Hashing;


class Bycrypt implements Hashinginterface {
    /**
     * Default crypt cost factor.
     * @var int
     */
    const ROUNDS = 10;

    public static function make($value,array $options = array()){
        $cost = isset($options['rounds']) ? $options['rounds'] : self::ROUNDS;
        $hash = password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost));
        if ($hash === false)
        {
            throw new \RuntimeException("Encrypt hashing not supported.");
        }
        return $hash;
    }


    public static function check($value,$hashed,array $option=array()){
        return password_verify($value,$hashed);
    }
} 