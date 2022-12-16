<?php
	require_once('./functions/achievement.php');
	require_once('./functions/gateKeeper.php');
		
	header("ACCESS-CONTROL-Allow-ORIGIN: *");

	$method = $_SERVER['REQUEST_METHOD'];

	if($method == 'POST'){
		header('Content-Type: application/json');
		if(isset($_POST['type']) && $_POST['type'] == 'getUserAchievements'){
			$data = getUserAchievements($_POST['hash']);
		}
		print_r(json_encode($data));
	}

?>
