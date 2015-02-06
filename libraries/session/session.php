<?php 

class Session extends PObject{
	public static $instance;
	public static $__session__;
	
	function &getInstance(){
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }
        return self::$instance;	
	}
	
 
	function start(){
		static $__session__;
		if(!is_object($__session__)){
			session_start();
			self::$__session__[session_id()] = array();
			self::$__session__[session_id()] = $_SESSION[session_id()];
			self::$__session__[session_id()]['instance']= &self::getInstance();
		}
		return $__session__;
	}
	
	function get($key = ''){
		if($key == ''){
			return self::$__session__;
		}else{
			return self::$__session__['key'];
		}
	}
	function set($key = null,$value=''){
		if(!$key){
			PError::send('Session::set Key not defined',$this);
		}
		$_SESSION[session_id()][$key] = $value;
		$__session__[session_id()][$key] = $value;
		
		return null;
	}
	function getID(){
		return session_id();
	}
	function destroy(){
		$_SESSION = array();
		$__session__ = array();
		session_destroy();
		
	}
}