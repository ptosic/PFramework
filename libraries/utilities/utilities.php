<?php 

class Utilities extends PObject{
	
	function &getEncryption(){
		
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = Utilities::_createEncryption();
		}
		
		return $instance;		
	}

#Creators

	function &_createEncryption(){
		
		Loader::import('libraries.utilities.crypt.crypt');
		
		$app =& PCrypt::getInstance();
		$object = PFactory::getObject();
		$object->register($app);
		return $app;
	}

}