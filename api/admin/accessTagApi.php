<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
	require './functions/accessTag.php';
	require_once('../functions/gateKeeper.php');
		
	header("ACCESS-CONTROL-Allow-ORIGIN: *");

	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		header('Content-Type: application/json');
		if(isset($_POST['type']) && $_POST['type'] == 'getAll'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getAccessTags();
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'getTag'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getAccessTag($_POST['id']);
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'update'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = updateAccessTag($_POST);
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'delete'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = deleteAccessTag($_POST['id']);
			}
		}
		print_r(json_encode($data));
	}
	
	if($method == 'PUT'){
		echo "PUT REQUEST";
	}
	
	if($method == 'DELETE'){
		echo "DELETE REQUEST";
	}
?>
