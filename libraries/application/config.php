<?php 

class Config{
	public static $params;
	
	public static $instance;
	
	function &getInstance(){
		
        if ( !(self::$instance instanceof self) ) {
			self::init();
			self::$instance = new self();
        }
		
        return self::$instance;	
	}
	
	function getAll(){
		return self::$params;
	}
	
	function get($key = ''){
		if($key == ''){return false;}
		if(!isset(self::$params[$key])){
			PError::send('Config::get Param "'.$key.'" not found',$this);
		}
		return self::$params[$key];
	}
	
	function set($key='',$val=''){
		if($key==''){
			PError::send('Config::get Param key is empty',$this);
		}
		self::$params[$key] = $val;
		return null;
	}
	
	function init(){
		
		
		$default = array(
				'db_engine' => 'mysqli',
				'db_host' => '127.0.0.1',
				'db_use' => 'pframework',
				'db_user' => 'pedja',
				'db_pass' => 'enigma27'
					);
	
		self::$params = $default;
	}
	
}