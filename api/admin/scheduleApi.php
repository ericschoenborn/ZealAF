<?php
       ini_set('display_errors', 1);
       error_reporting(E_ALL);
require './functions/schedule.php';
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
			$data = getSchedules($_POST['weekStart'], $_POST['weekEnd']);
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
			$data = getSchedule($_POST['id']);
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
			$data = "Not Implemented.";//updateUser($_POST);
			if(!isset($data) || $data = "No change detected."){
				$accessResult = "Not Implemented.";//updateUserAccess($_POST);
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
			$data = deleteSchedule($_POST['id']);
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
			$data = createSchedule($_POST);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getUserLeaderEvents'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = getUserLeaderEvents($_POST['id']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getUserParticipantEvents'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = getUserParticipantEvents($_POST['id']);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'removeParticipant'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(4,5));
		if(isset($accessErrors)){
			$data = $accessErrors;
		}else{
			$data = removeParticipant($_POST['id']);
		}
	}

	print_r(json_encode($data));
}
?>
