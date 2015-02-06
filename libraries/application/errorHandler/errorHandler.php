<?php 
class PError {
	
	function &getInstance(){
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }
        return self::$instance;	
	}
	
	function send($error,$object,$type=''){
		echo $error.'<br>';
		
		switch($type){
			case 'fatal':
				die();
				break;
			default:
		}
	}
}