<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 7/13/15
 * Time: 4:45 AM
 */

namespace system\library\Validator\Validate;

use system\library\Validator\Base;

class Required extends Base
{
    public function execute(array $data)
    {

        if (!isset($data[$this->field]) || $data[$this->field] == '') {
            return false;
        }
        return true;
    }
}