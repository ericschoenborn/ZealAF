<?php
	header("ACCESS-CONTROL-Allow-ORIGIN: *");

	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'GET'){
		echo "GET REQUEST";
	}

	if($method == 'POST'){
		echo "POST REQUEST";
	}
	
	if($method == 'PUT'){
		echo "PUT REQUEST";
	}
	
	if($method == 'DELETE'){
		echo "DELETE REQUEST";
	}
?>
