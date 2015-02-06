<?php 

class PObject{
	public static $instance;
	public static $classes;
	public static $objects = array();
	
	
	function &getInstance(){
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }
        return self::$instance;	
	}
	
	function register($object){
		static $objects;
		
		if(!is_object($object)){
			PError::send('PObject::register  Not is Object<br>',$this);
			return false;
		}
		
		self::$objects[] = $object;
	}
	
	function getObjects(){
		//static $objects;
		
		$objects =& self::$objects;
		
		if(count($objects) < 1){
			return NULL;
		}
		
		$classes = array();
		
		foreach($objects as $obj){
			$name = get_class($obj);
			$classes[$name] = $obj;
			//var_dump($obj);
			//$classes[$obj]['vars'] = get_class_vars($obj);
		}
		
		return $classes;
	}
}