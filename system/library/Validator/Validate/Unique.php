<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/12/15
 * Time: 9:39 PM
 */

namespace system\library\Validator\Validate;

//require_once("../Validate/Base.php");
use system\library\Database\Database;
use system\library\Validator\Base;
class Unique extends Base {


    private $primary_key;
    private $table;
    public function __construct($field, $error_message, $table, $primary_key = 'id')
    {
        parent::__construct($field, $error_message);
        $this->pdo = new Database();
        $this->primary_key = $primary_key;
        $this->table = $table;
    }
    public function execute(array $data){
        if (isset($data[$this->field]) && $data[$this->field] !== '') {
            if (! isset($data[$this->primary_key])) {
                $rq = $this->pdo->prepare('SELECT COUNT(*) FROM '.$this->table.' WHERE '.$this->field.'=?');
                $rq->execute(array($data[$this->field]));

            }
            else {
                $rq = $this->pdo->prepare(
                    'SELECT COUNT(*) FROM '.$this->table.'
                    WHERE '.$this->field.'=? AND '.$this->primary_key.' != ?'
                );
                $rq->execute(array($data[$this->field], $data[$this->primary_key]));
            }
            $result = $rq->fetchColumn();
            if ($result == 1) { // Postgresql returns an integer but other database returns a string '1'
                return false;
            }
        }
        return true;
    }
}