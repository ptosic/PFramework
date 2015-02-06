<?php 
		ini_set("display_errors",1);
		//error_reporting(E_ALL);

define ('_PFRAME',1);
define('PATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( PATH_BASE .DS.'libraries'.DS.'factory.php' );

$mainframe =& PFactory::getApplication();
$mainframe->init();
