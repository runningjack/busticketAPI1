<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 6/5/15
 * Time: 12:51 PM
 */
namespace system\library\Database;
class Database extends \PDO {


    public function __construct(){
        parent::__construct("mysql:host=localhost;dbname=busticket;","root", "");
        $this->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // always disable emulated prepared statement when using the MySQL driver
        $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, TRUE);
    }



}