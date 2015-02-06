<?php 
require_once dirname(__FILE__).'/renderer.php';

class PHTML extends PObject{
	
	public static $instance;
	
	function &getInstance(){
        if ( !(self::$instance instanceof self) ) {
            self::$instance = new self();
        }
        return self::$instance;	
	}
	
	function getMenuStructure($type = 'main',$parent = 0){
		$menu = array();
		$db =& PFactory::getDbo();
		$sql = "select * from menu where parent=".$parent." and state=1 and menutype ='".$type."' order by ordering ASC";
		$db->setQuery($sql);
		$db->query();
		$list = $db->loadAssocList();
		
		if(count($list) < 1){return $menu;}
		
		
		foreach($list as $lst){
			$_m = self::getMenuStructure($type,$lst['id']);
			if(count($_m) < 1){
				$menu[] = $lst;
			}else{
				$menu[] = $_m;
			}
		}
		
		return $menu;
	}
	
	function header(){
		
	}
	function addStyleSheet($file){
	}
	function addScript($file){
	}
	function addScriptCode($code){
	}
	function gzipContent(){
		
	}
	function getFormToken(){
		$session =& PFactory::getSession();
		$id = $session->getID();
		$token = md5(mt_rand(1,1000000) . $id);
		return $token;
	}
#HTML Elements
	function getForm($params){
		$token = self::getFormToken();
		echo $token;
	}
	function getInput($params){
	}
	function getCheckBox($params){
	}
	function getRadio($params){
	}
	function getDropDown($params){
	}


	
}