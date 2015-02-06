<?php 
class PEvent extends PObject{
	
	public static $instance;
	public static $methods;
	
	function &getInstance(){
	
        if ( !(self::$instance instanceof self) ) {
			
            self::$instance = new self();
        }
        return self::$instance;	
	}	
	
	function init(){
		Loader::import('libraries.event.methods');
		self::$methods = new EventsMethods();
	}
	
	function trigger($method,$params = array()){
		if(!$method){
			return false;
		}
		self::init();
		$method = 'event_'.ucfirst($method);
		
		if(method_exists (self::$methods,$method)){
			
			self::$methods->{$method}($params);
		}else{
			PError::send('PEvent::trigger '.$method.' does not exist',$this);
		}
		return;
	}
}