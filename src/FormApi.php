<?php
	namespace Demo;	

	interface FormApi{

		public static function getInstance();
		public function saveData($data);
		public function getData();

	}	
		

?>
