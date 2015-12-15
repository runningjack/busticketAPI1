<?php

    $directory = realpath(dirname(__FILE__));
    $document_root = realpath($_SERVER['DOCUMENT_ROOT']);
    $base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .
        $_SERVER['HTTP_HOST'];
    if(strpos($directory, $document_root)===0) {
        $base_url .= str_replace(DIRECTORY_SEPARATOR, '/', substr($directory, strlen($document_root)));
    }

$basedir = __DIR__;
$basedir =str_replace(DIRECTORY_SEPARATOR, '/',$basedir);
    defined("APP_URL") ? null : define("APP_URL",  $base_url);
define("BASE_DIR",$basedir);
    //Assets URL, location of your css, img, js, etc. files
    defined("ASSETS_URL") ? null : define("ASSETS_URL", APP_URL);
    define('DIR_SYSTEM', '/system/');
    define('DIR_LIB', '/system/library/');
    define('DIR_PUBLIC','/public/');
    define('DIR_IMG','/public/img/');
    define('DIR_CSS','/public/css/');
    define('DIR_JS','/public/js/');
    define('DIR_FOLDERS_HTTP',"");

define('HOST', 'localhost');
define('DB_NAME', 'version_control');
define('DB_USER','root');
define('DB_PASS','');


    function __autoload($class) {
        if(file_exists(DIR_SYSTEM. "library/".strtolower($class).".php")){
            require_once DIR_SYSTEM. "library/".strtolower($class).".php";
        }elseif(file_exists(BASE_DIR. "/controller/".$class.".php")){
            require_once BASE_DIR."/controller/Controller.php";
            require_once  BASE_DIR."/controller/".($class).".php";
        }
    }
//@$session = new Session();

function controller__autoload($classname) {
    $classname = ltrim($classname, '\\');
    $filename  = '';
    $file ="";
    $namespace = '';
    if ($lastnspos = strripos($classname, '\\')) {
        $namespace = substr($classname, 0, $lastnspos);
        $classname = substr($classname, $lastnspos + 1);
        $filename  = preg_replace('#\/\/#', DIRECTORY_SEPARATOR, $namespace) . '\\';
    }

    $filename .= preg_replace('/_/', DIRECTORY_SEPARATOR, $classname) . '.php';
    $file = preg_replace("/\\\\/",DIRECTORY_SEPARATOR,$filename );
    require BASE_DIR.DIRECTORY_SEPARATOR. $file;
}

spl_autoload_register("controller__autoload");

?>