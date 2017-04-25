<?php
	namespace Demo;
	require_once('vendor/autoload.php');

	use Demo\IformBuilderApi;

	$formApi = IformBuilderApi::getInstance();
	if(isset($_POST['email'])){
		$_POST['password'] = md5($_POST['password']);
		$formApi->saveData($_POST);			
	}

	include_once('view.home.php');
?>	
	