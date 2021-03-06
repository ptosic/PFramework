<?php 

class DBMySqli extends DBFactory{

	var  $_link;
	var $_params;
	
	function __construct(){
		$this->_params = array();
		if(!is_resource($this->_link)){
			$config = PFactory::getConfig();
			$host = $config->get('db_host');
			$database = $config->get('db_use');
			$user = $config->get('db_user');
			$pass = $config->get('db_pass');
			$port	= NULL;
			$socket	= NULL;
			$targetSlot = substr( strstr( $host, ":" ), 1 );
			
			if (!empty( $targetSlot )) {
				
				if (is_numeric( $targetSlot )){
					$port	= $targetSlot;
				}else{
					$socket	= $targetSlot;
				}
					
				$host = substr( $host, 0, strlen( $host ) - (strlen( $targetSlot ) + 1) );

				if($host == ''){ $host = 'localhost';}
			}

			if (!function_exists( 'mysqli_connect' )) {
				PError::send('DBMySqli::adapter The MySQL adapter "mysqli" is not available.','fatal');
				return false;
			}
			
			$link = mysqli_connect($host, $user, $pass, NULL, $port, $socket);
			
			if(!$link){
				PError::send('DBMySqli::connect DB Connection faild','fatal');
				return false;				
			}
			
			$this->_link = $link;
			
			mysqli_select_db($this->_link,$database);
			
			$this->setUTF();
		}
		
	}
	function __destruct(){
		$return = false;
		if (is_resource($this->_link)) {
			$return = mysqli_close($this->_link);
		}
		return $return;
	}
	
	
	function setQuery( $sql, $offset = 0, $limit = 0 ){

		$this->_params['query'] = $sql;
		$this->_params['limit'] = (int) $limit;
		$this->_params['offset'] = (int) $offset;
		
		return null;
	}	
	
	function query(){
	
		if (!is_object($this->_link)) {
			return false;
		}
		
		$sql = $this->_params['query'];
		
		$this->_params['cursor'] = mysqli_query($this->_link, $sql);
		
		if(!$this->_params['cursor']){
			$_errorNum = mysqli_errno( $this->_link );
			$_errorMsg = mysqli_error( $this->_link )." SQL=$sql";
			PError::send('DBMySql::connect DB error:'.$_errorNum.'<br>'.$_errorMsg,'fatal');
		}
		return $this->_params['cursor'];	
	}	
	
	function getAffectedRows(){
		return mysqli_affected_rows( $this->_link );
	}	

	function loadAssocList(){
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysqli_fetch_assoc( $cur )) {
			if ($key) {
				$array[$row[$key]] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysqli_free_result( $cur );
		return $array;	
	}

	function loadObject(){
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($object = mysqli_fetch_object( $cur )) {
			$ret = $object;
		}
		mysqli_free_result( $cur );
		return $ret;	
	}
	
	function loadObjectList(){
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysqli_fetch_object( $cur )) {
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysqli_free_result( $cur );
		return $array;	
	}	
	function getEscaped( $text, $extra = false ){
		$result = mysqli_real_escape_string( $this->_link, $text );
		if ($extra) {
			$result = addcslashes( $result, '%_' );
		}
		return $result;
	}	
	function loadRow(){
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($row = mysqli_fetch_row( $cur )) {
			$ret = $row;
		}
		mysqli_free_result( $cur );
		return $ret;
	}
	
	function loadRowList( $key=null ){
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysqli_fetch_row( $cur )) {
			if ($key !== null) {
				$array[$row[$key]] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysqli_free_result( $cur );
		return $array;
	}	
	
	function getTableFields( $tables, $typeonly = true ){
		settype($tables, 'array'); 
		$result = array();

		foreach ($tables as $tblval){
			$this->setQuery( 'SHOW FIELDS FROM ' . $tblval );
			$fields = $this->loadObjectList();

			if($typeonly)
			{
				foreach ($fields as $field) {
					$result[$tblval][$field->Field] = preg_replace("/[(0-9)]/",'', $field->Type );
				}
			}
			else
			{
				foreach ($fields as $field) {
					$result[$tblval][$field->Field] = $field;
				}
			}
		}

		return $result;
	}	
	
	function setUTF(){
		mysqli_query( $this->_link, "SET NAMES 'utf8'" );
	}

	private function close(){
		mysqli_close($this->_link);
		return null;
	}	
}
