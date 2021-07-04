<?php namespace administrator;
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
error_reporting(E_ALL);
const DEBUG = false;
const SQL_DEBUG = false;



require "../class.user.php";
require "../class.connect.php";
require "../class.controller.php";
require "../class.model.php";
require "../class.view.php";
require "../class.termin.php";
require "../class.newsletter.php";
require "../class.coverLesson.php";



require "administrator.controller.class.php";
require "administrator.model.class.php";
require "administrator.filehandler.class.php";
require "administrator.tmanager.class.php";




if (DEBUG) {
    ini_set("display_errors", true);
    \View::$DEBUG = true;
    enableCustomErrorHandler();
}

$input = array_merge($_GET, $_POST);

$control = new Controller($input);


/**
 * This function will throw Exceptions instead of warnings (better to debug)
 */
function enableCustomErrorHandler() {
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }
        
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    });
}

?>
