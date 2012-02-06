<?php
	include_once 'classes/class.core.php';
	try{
		$core = new Core();
		$core->LoadScriptsForDataMining();
		$data = new Data();
		$data->PrepareData();
	}catch(Exception $ex){
	}
	
?>