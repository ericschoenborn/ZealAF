<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
	require './functions/user.php';
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
			$accessErrors = grantAccess($hash, array(3,4,5));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getUsers();
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'getLeaders'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getLeaders();
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'getLeadersForSchedule'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getLeadersForSchedule($_POST['id']);
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'updateScheduleLeaders'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = updateScheduleLeaders($_POST['leaders'], $_POST['id']);
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'getUser'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getUser($_POST['id']);
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
				$data = updateUser($_POST);
				if(!isset($data) || $data = "No change detected."){
					$accessResult = updateUserAccess($_POST);
					if($accessResult != "No change detected."){
						$data = $accessResult;
					}
				}
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
				$data = deleteUser($_POST['id']);
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
