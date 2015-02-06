<?php 

class DBFactory extends PObject{
	public static $DBEngine;
	public static $instance;
	public static $connection;
	
	function &getInstance(){
        if ( !(self::$instance instanceof self) ) {
			self::getDbo();
            self::$instance = new self();
        }
        return self::$instance;	
	}	
	
	function &getDbo(){
		$config = PFactory::getConfig();
		$engine = $config->get('db_engine');
		
		switch($engine){
			case 'mysql':
				Loader::import('libraries.database.engines.mysql');
				self::$DBEngine = new DBMySql;
				break;
			case 'mysqli':
				Loader::import('libraries.database.engines.mysqli');
				self::$DBEngine = new DBMySqli;			
				break;
		}
		
		return $db;
	}
	
	function setQuery($sql){
		return self::$DBEngine->setQuery($sql);
	}
	function query(){
		return self::$DBEngine->query();
	}	
	function getAffectedRows(){
		return self::$DBEngine->getAffectedRows() ;
	}
	function loadAssocList(){
		return self::$DBEngine->loadAssocList() ;
	}
	function loadObject(){	
		return self::$DBEngine->loadObject() ;
	}
	function loadObjectList(){
		return self::$DBEngine->loadObjectList() ;
	}
	function loadRow(){
		return self::$DBEngine->loadRow() ;	
	}
	function loadRowList( $key ){
		return self::$DBEngine->loadRowList($key) ;	
	}
	function getTableFields( $tables, $typeonly = true ){
		return self::$DBEngine->getTableFields( $tables, $typeonly ) ;	
	}
	function getEscaped( $text, $extra = false ){
		return self::$DBEngine->getEscaped( $text, $extra ) ;	
	}
}