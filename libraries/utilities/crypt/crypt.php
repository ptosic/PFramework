<?php 
require_once dirname(__FILE__).'/EnDecryptText.php';

class PCrypt{
	public static $instance;
	
	function &getInstance(){
		
        if ( !(self::$instance instanceof self) ) {
			self::$instance = new self();
        }
		
        return self::$instance;	
	}
	
	function encrypt($text = null){
		if(!$text){return null;}
		$E = new EnDecryptText;
		$text = $E->Encrypt_Text($text);
		return $text;
	}
	
	function decrypt($data = null){
		if(!$data){return null;}
		$E = new EnDecryptText;
		$data = $E->Decrypt_Text($data);
		return $data;		
	}
	
} 