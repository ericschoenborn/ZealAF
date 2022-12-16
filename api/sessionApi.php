<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
	require './functions/session.php';
		
	header("ACCESS-CONTROL-Allow-ORIGIN: *");

	$method = $_SERVER['REQUEST_METHOD'];


	if($method == 'GET'){
		header('Content-Type: application/json');
		$data = getUserIdFromSessionHash($_POST); 
		print_r(json_encode($data));
	}
	
	if($method == 'PUT'){
		echo "PUT REQUEST";
	}
	
	if($method == 'DELETE'){
		echo "DELETE REQUEST";
	}
?>
