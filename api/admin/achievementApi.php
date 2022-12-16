<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);

	require_once('./functions/achievement.php');
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
				$data = "a";//getLocationsBySpace($_POST['id']);
			//	if(isset($data) && count($data) == 0){
			//		$data = deleteSpace($_POST['id']);
			//	}
				
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
				$data = updateAchievement($_POST);
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
				$data = getAchievement($_POST['id']);
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
				$data = getAchievements($_POST);
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
				$data = createAchievement($_POST);
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'getUserAchievements'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = getUserAchievements($_POST['id']);
			}
		}elseif(isset($_POST['type']) && $_POST['type'] == 'updateUserAchievements'){
			$hash = "";
			if(isset($_POST['hash'])){
				$hash = $_POST['hash'];
			}	
			$accessErrors = grantAccess($hash, array(1,2,3));
			if(isset($accessErrors)){
				$data = $accessErrors;
			}else{
				$data = updateUserAchievements($_POST['id'], $_POST['achievements']);
			}
		}
		print_r(json_encode($data));
	}

?>
