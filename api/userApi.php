<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require './functions/user.php';
		
header("ACCESS-CONTROL-Allow-ORIGIN: *");

$method = $_SERVER['REQUEST_METHOD'];


if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['type']) && $_POST['type'] == 'hash'){
		$data = getUserByHash($_POST['hash']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'update'){
		$data = updateUser($_POST);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'updatePass'){
		$data = updatePassword($_POST);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getLeadersForSchedule'){
		$data =  getLeadersForSchedule($_POST['id']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getParticipantStatus'){
		$data = getParticipantStatus($_POST['hash'], $_POST['id']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'joinScheduledEvent'){
		$data = joinScheduledEvent($_POST['hash'], $_POST['id']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'leaveScheduledEvent'){
		$data = leaveScheduledEvent($_POST['hash'], $_POST['id']);
	}else{
		$data = createNewUser($_POST);
	}	
	print_r(json_encode($data));
}
?>
