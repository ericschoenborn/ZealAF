<?php
       ini_set('display_errors', 1);
       error_reporting(E_ALL);
require './functions/schedule.php';
require_once('./functions/gateKeeper.php');
		
header("ACCESS-CONTROL-Allow-ORIGIN: *");
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	header('Content-Type: application/json');
	if(isset($_POST['type']) && $_POST['type'] == 'getUserLeaderEvents'){
		$data = getUserLeaderEvents($_POST['hash']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getUserParticipantEvents'){
		$data = getUserParticipantEvents($_POST['hash']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'removeParticipant'){
		$data = removeParticipant($_POST['hash'], $_POST['scheduleParticipantId']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getAll'){
		$data = getSchedules($_POST['weekStart'], $_POST['weekEnd']);
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getSingle'){
		$data = getSchedule($_POST['id']);
	}

	print_r(json_encode($data));
}
?>
