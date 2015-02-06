<?php 
require_once dirname(__FILE__).'/modules.php';

class PRender extends PHTML{
	
	var $params = array();
	
	public function __construct(){
		
	}
	
	function TestgZip(){
		$config =& PFactory::getConfig();
		
		if($config->get('GZIP') == 1){
			if(function_exists('ob_gzhandler') && ini_get('zlib.output_compression')){
				return true;
			}
		}
		
		return false;
	}
	
	
}