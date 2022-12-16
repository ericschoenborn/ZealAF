<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require './functions/login.php';
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['recoverPassword'])){	
		if(isset($_POST['email']) && strlen($_POST['email']) >1 ){
			$email = $_POST['email'];
			$data = array(null,recoverPassword($email));
		}else{
			$data = array("An email is required", null);
		}
	}else{
		$data = loginUser($_POST); 
	}
	print_r(json_encode($data));
}
?>
