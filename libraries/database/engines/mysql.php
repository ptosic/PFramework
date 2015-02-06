<?php 
class DBMySql extends DBFactory{
	
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
			
			$link = mysql_connect($host,$user,$pass);
			if(!$link){
				PError::send('DBMySql::connect DB Connection faild','fatal');
			}
			mysql_select_db($database, $link);
			$this->_link = $link;
			$this->setUTF();
		}
		
		return null;
	}
	function __destruct(){
		$return = false;
		if (is_resource($this->_link)) {
			$return = mysql_close($this->_link);
		}
		return $return;
	}
	function setUTF(){
		mysql_query( "SET NAMES 'utf8'", $this->_link );
	}	
	function setQuery( $sql, $offset = 0, $limit = 0 ){

		$this->_params['query'] = $sql;
		$this->_params['limit'] = (int) $limit;
		$this->_params['offset'] = (int) $offset;
		
		return null;
	}
	function query(){
		if (!is_resource($this->_link)) {
			return false;
		}
		$sql = $this->_params['query'];
		$this->_params['cursor'] = mysql_query( $sql, $this->_link );
		
		if(!$this->_params['cursor']){
			$_errorNum = mysql_errno( $this->_link );
			$_errorMsg = mysql_error( $this->_link )." SQL=$sql";
			PError::send('DBMySql::connect DB error:'.$_errorNum.'<br>'.$_errorMsg,'fatal');
		}
		return $this->_params['cursor'];
	}
	function getAffectedRows(){
	
		return mysql_affected_rows( $this->_link );
	}	
	function loadAssocList(){
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_assoc( $cur )) {
			if ($key) {
				$array[$row[$key]] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
		return $array;	
	}
	function loadObject(){
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($object = mysql_fetch_object( $cur )) {
			$ret = $object;
		}
		mysql_free_result( $cur );
		return $ret;	
	}
	function loadObjectList(){
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_object( $cur )) {
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
		return $array;	
	}
	function loadRow(){
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($row = mysql_fetch_row( $cur )) {
			$ret = $row;
		}
		mysql_free_result( $cur );
		return $ret;
	}	
	function loadRowList( $key=null ){
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_row( $cur )) {
			if ($key !== null) {
				$array[$row[$key]] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
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
	function getEscaped( $text, $extra = false ){
		$result = mysql_real_escape_string( $text, $this->_link );
		if ($extra) {
			$result = addcslashes( $result, '%_' );
		}
		return $result;
	}
	private function close(){
		mysql_close($this->_link);
		return null;
	}
}