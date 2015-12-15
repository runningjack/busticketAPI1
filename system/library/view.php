<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 6/5/15
 * Time: 4:08 PM
 */
namespace system\library;
class View {
    function __construct(){
    }
    public function render($name, $noInclude = false)
    {
        if ($noInclude == true) {
            require 'views/'.$name.'.php';
        }
        else {
            require 'views/includes/header.php';
            require 'views/'.$name.'.php';
            require 'views/includes/footer.php';
        }
    }

}

new View();
?>