<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);

require_once('./functions/merch.php');
require_once('../functions/gateKeeper.php');
	
header("ACCESS-CONTROL-Allow-ORIGIN: *");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['type']) && $_POST['type'] == 'delete'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = deleteMerch($_POST['id']);
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
			$data = updateMerch($_POST);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getSingle'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
		$data = getMerch($_POST['id']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getAll'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = getMerchandise($_POST);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'create'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = createMerch($_POST);
		}
	}
	print_r(json_encode($data));
}
?>
