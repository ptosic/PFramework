<?php 

class Application {

	public static $instance;
	public static $Config;
	
	function &getInstance(){
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }
        return self::$instance;	
	}
	
	function init(){
		self::config();
		$config =& PFactory::getConfig();
		Loader::import('libraries.object');
		Loader::import('libraries.event.event');
		Loader::import('libraries.utilities.utilities');
		Loader::import('libraries.html.html');
		
		///$test =& Utilities::getEncryption();
		//echo $test->encrypt('TESTTEST');
		
		//PEvent::trigger('stop',array('STOP','TEST'));
		$session = PFactory::getSession();
		$session->start();
		//$session->set('test','TEST');
		
		//var_dump(PRender::TestgZip());
		//ModuleRenderer::getModules();
		//PHTML::getForm(null);
		/*echo '<pre>';
		var_dump(PHTML::getMenuStructure());
		
		echo '</pre>';*/
		
		//$session->destroy();
		//PEvent::trigger('redirect',array('google.com'));
	}
	
	function config(){
		Loader::import('libraries.application.config');
		$db =& PFactory::getDbo();
		
		$sql = "select * from defines";
		$db->setQuery($sql);
		$db->query();
		$list = $db->loadAssocList();
		
		if(count($list) < 1){return false;}
		$config =& PFactory::getConfig();
		foreach($list as $val){
			$config->set($val['define'],$val['value']);
		}
		return;		
	}
	
	function getMenu($type = 'main'){
		
		
		
		
	}
}