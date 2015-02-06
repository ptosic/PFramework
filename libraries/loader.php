<?php 

class Loader{
	
	function import($class){
		static $paths;


		if(empty($class)){
			PError::send('Loader::import  Import error<br>',$this);
			return false;
		}
		
		$_class = explode('.',$class);
		$classname = array_pop($_class);
		switch($classname){
			case 'helper' :
				$classname = ucfirst(array_pop( $parts )).ucfirst($classname);
				break;

			default :
				$classname = ucfirst($classname);
				break;
		}

		$path  = PATH_BASE . DS . str_replace( '.', DS, $class ).'.php';
		if(!file_exists($path)){
			PError::send('Loader::import Class '.$classname.' File not exists',$this,'fatal');
			return false;
		}
		require_once($path);
		

		return null;
	}
	
}