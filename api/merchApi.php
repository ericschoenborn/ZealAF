<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);

require_once('./functions/merch.php');
require_once('./functions/gateKeeper.php');
	
header("ACCESS-CONTROL-Allow-ORIGIN: *");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['type']) && $_POST['type'] == 'merchToCart'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = merchToCart($_POST);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getSingle'){
		$data = getMerch($_POST['id']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getAll'){
		$data = getMerchandise($_POST);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getCartItems'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = getCartItems($hash);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'incromentCartItem'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = incromentCartItem($_POST['id']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'decromentCartItem'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = decromentCartItem($_POST['id']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'payWithDeficit'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = payWithDeficit($hash, $_POST['ids']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'payWithCredit'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = payWithCredit($hash, $_POST['ids']);
		}
	}

	print_r(json_encode($data));
}
?>
