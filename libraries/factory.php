<?php 

require_once dirname(__FILE__).'/loader.php';
Loader::import('libraries.application.errorHandler.errorHandler');
class PFactory{
	
	function &getApplication(){
		
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = PFactory::_createApplication();
		}
		
		return $instance;		
	}
	
	function &getObject(){
		
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = PFactory::_createObject();
		}
		return $instance;		
	}
	
	function &getSession(){
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = PFactory::_createSession();
		}
		return $instance;		
	}
	
	function &getDbo(){
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = PFactory::_createDatabase();
		}
		return $instance;			
	}
	function &getConfig(){
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = PFactory::_createConfig();
		}
		return $instance;		
	}
	function &getEvents(){
		
		static $instance;
		
		if (!is_object( $instance )) {
			$instance = PFactory::_createEvents();
		}
		
		return $instance;		
	}	
#Creators
	
	function &_createObject(){
		Loader::import('libraries.object');
		$object =& PObject::getInstance();
		return $object;
	}
	
	function &_createApplication(){
		
		Loader::import('libraries.application.application');
		
		$app =& Application::getInstance();
		$object = PFactory::getObject();
		$object->register($app);
		return $app;
	}
	
	function _createSession(){
		Loader::import('libraries.session.session');

		$session =& Session::getInstance();
		$object = PFactory::getObject();
		$object->register($session);

		return $session;
	}
	
	function _createDatabase(){
	
		Loader::import('libraries.database.interface');
		$database =& DBFactory::getInstance();
		
		$object = PFactory::getObject();
		$object->register($database);	
		
		return $database;
	}
	function _createConfig(){
		Loader::import('libraries.application.config');
		
		$config =& Config::getInstance();
		$object = PFactory::getObject();
		$object->register($config);		
		return $config;
	}
	
	function _createEvents(){
		Loader::import('libraries.events.event');
		
		$event =& PEvent::getInstance();
		$object = PFactory::getObject();
		$object->register($config);		
		return $event;		
	}
}