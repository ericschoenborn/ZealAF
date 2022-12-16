<?php        
ini_set('display_errors', 1);
error_reporting(E_ALL);
	require_once('./functions/eventRequirements.php');
	require_once('./functions/event.php');
	require_once('./functions/gateKeeper.php');
		
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
			$data = deleteEvent($_POST['id']);
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
			$data = updateEvent($_POST);
			if(!isset($data)){
				$requirementIds = getAchievementIdsByNames($_POST['requirements']);
				$data = updateEventRequirements($_POST['id'],$requirementIds);
			}
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
			$data = getEvent($_POST['id']);
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
			$data = getEvents($_POST);
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'create'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3));
		if(isset($accessErrors)){
			$data = array($accessErrors);
		}else{
			$data = createEvent($_POST);
			if((int)$data>0 && gettype($data) != "array"){
				if(isset($_POST['requirements'])){
					$requirementIds = getAchievementIdsByNames($_POST['requirements']);
					$data = updateEventRequirements($data,$requirementIds);
				}else{
					$data = null;
				}
			}
		}
	}elseif(isset($_POST['type']) && $_POST['type'] == 'getRequirements'){
		$hash = "";
		if(isset($_POST['hash'])){
			$hash = $_POST['hash'];
		}	
		$accessErrors = grantAccess($hash, array(1,2,3));
		if(isset($accessErrors)){
			$data = array($accessErrors);
		}else{
			$data = getRequirementsByEvent($_POST['id']);
		}
	}
	print_r(json_encode($data));
}
?>
