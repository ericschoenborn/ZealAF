<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);

require_once('./functions/deficit.php');
require_once('./functions/gateKeeper.php');
	
header("ACCESS-CONTROL-Allow-ORIGIN: *");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['type']) && $_POST['type'] == 'getAll'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3,4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = getDeficits($hash);
		}
	}
	print_r(json_encode($data));
}
?>
