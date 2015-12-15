<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 8/7/15
 * Time: 3:34 PM
 */

namespace models;


use system\library\Database\Model;

class Translog extends Model{
    protected static $db_fields = array("id","trans_id","merch_app_id","cus_app_id","cus_bank_no","merch_bank_no",
        "cus_bank_name","merch_bank_name","cus_bank_code","merch_bank_code","trans_type","narration","trans_status","created_at","updated_at");
    protected static $table ="transactions";
} 