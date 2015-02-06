<?php

class EventsMethods{
	
	
	function __construct(){
		
	}
	
	function event_Start($params){
		
	}
	function event_Stop($params){
		
		die('Trigger:Stop');
	}
	
	function event_Redirect($params){
		$url = $params[0];
		if(!$url){return false;}
		
		if(!stripos($url,'http')){
			$url = 'http://'.$url;
		}
		echo '<script>window.location.href ="'.$url.'";</script>';
	}
}
