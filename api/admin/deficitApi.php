<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);

require_once('./functions/deficit.php');
require_once('../functions/gateKeeper.php');
	
header("ACCESS-CONTROL-Allow-ORIGIN: *");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['type']) && $_POST['type'] == 'getUserDeficits'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = getUserDeficits($_POST['id']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'removeUserDeficit'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = removeUserDeficit($_POST['id']);
		}
	}
	print_r(json_encode($data));
}
?>
