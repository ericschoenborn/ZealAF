<?php
require_once('../mysql/requests.php');
require_once(__DIR__.'/accessTag.php');
require_once(__DIR__.'/session.php');
require_once('../assets/userData.php');

function joinScheduledEvent($hash, $id){
	$result = getUserIdBySessionHash($hash);
	$errors = $result[0];
	$userId = $result[1];
	if(!empty($errors)){
		return "Unable to find user";
	}
	$query="INSERT INTO schedule_participants (`scheduled_id`, `member_id`) VALUES ($id, $userId);";	
	$scheduled_id = create($query);
	if($scheduled_id < 1){
		return "Failed to add you to scheduled event";
	}
	return null;
}
function leaveScheduledEvent($hash, $id){
	$result = getUserIdBySessionHash($hash);
	$errors = $result[0];
	$userId = $result[1];
	if(!empty($errors)){
		return "Unable to find user";
	}
	$query="DELETE FROM schedule_participants WHERE `scheduled_id` = $id AND `member_id` = $userId;";	
	$result = update($query);
	if($result > 0){	
		return null;
	}else{
		return "Failed to leave schedueled event";
	}
}
function getParticipantStatus($hash, $id){
	$query="SELECT COUNT(*) FROM sessions, schedule_participants WHERE sessions.`session_hash` = '$hash' AND schedule_participants.`scheduled_id` = '$id' AND sessions.`user_id` = schedule_participants.`member_id`;";	
	$found = getCount($query);
	if($found > 0){
		return true;
	}
	return false;
}

function getLeadersForSchedule($id){
	$query="SELECT members.`id`, members.`first_name`, members.`last_name`, members.`email` FROM members, schedule_leaders WHERE members.`id` = schedule_leaders.`member_id` AND schedule_leaders.`scheduled_id` = '$id'";	
	$result = getAll($query);
	if($result){
		$users = array();
		foreach($result as $item){
			$users[] = array($item['id'], $item['first_name'], $item['last_name'], $item['email']);
		}
		return $users;
	}
	return array();
}
function updatePassword($passData){
	$errors = array();
	$errors = array_merge($errors,validatePassword($passData['new'], $passData['conf']));
	if(!empty($errors)){
		return array($errors, null);
	}
	$result = getUserIdBySessionHash($passData['hash']);
	$errors = $result[0];
	if(!empty($errors)){
		return array($errors, null);
	}
	$pass = $passData['new'];
	$id = $result[1];
	$query = "UPDATE members SET `password`='$pass' WHERE `id`=$id;";
	$result2 = update($query);
	if($result2){
		return array(null,null);
	}
	return array("No change detected.", null);
	return array("error here", null);
}
function updateUser($userData){
	$errors = array();
	$errors = array_merge($errors,validateName($userData['firstName'], 'First'));
	$errors = array_merge($errors,validateName($userData['middleName'], 'Middle'));
	$errors = array_merge($errors,validateName($userData['lastName'], 'Last'));
	$errors = array_merge($errors,validateDOB($userData['dob']));
	$errors = array_merge($errors,validatePhone($userData['phone']));
	if(!empty($errors)){
		return $errors;
	}
	$result = getUserIdBySessionHash($userData['hash']);
	$errors = $result[0];
	if(!empty($errors)){
		return $errors;
	}
	['firstName' => $first, 'middleName' => $middle, 'lastName' => $last, 'phone' => $phone, 'pronouns' => $pronouns] = $userData;

	$id = $result[1];
	$query = "UPDATE members SET `first_name`='$first',`middle_name`='$middle', `last_name`='$last', `phone`='$phone', `pronouns`='$pronouns' WHERE `id`=$id;";
	$result2 = update($query);
	if($result2){
		return nulll;
	}
	return "No change detected.";
}
function getUserByHash($hash){
	$result = getUserIdBySessionHash($hash);
	$errors = $result[0];
	$id = $result[1];
	if(!empty($errors)){
		return array($errors, null);
	}
	$query = "select `email`, `first_name`, `middle_name`, `last_name`, `dob`, `phone`, `pronouns` FROM members WHERE `id` = $id;";
	$result2 = getSingle($query);
	if($result){
		$userData = new UserData();
		$userData->email = $result2['email'];
		$userData->firstName = $result2['first_name'];
		$userData->middleName = $result2['middle_name'];
		$userData->lastName = $result2['last_name'];
		$userData->dob = $result2['dob'];
		$userData->phone = $result2['phone'];
		$userData->pronouns = $result2['pronouns'];
		
		return array(null, $userData);
	}else{
		return array("user not found.", null);
	}
return $result;
}
function getUserID($email, $password){
	$query = "select `id` FROM members WHERE `email` = '$email' AND `password` = '$password'";
	$result = getSingle($query);
	if($result){
		return $result['id'];
	}
	return 0;
}
function createNewUser($userData){
	$userErrors = validateUser($userData);
	if(!empty($userErrors)){
		return $userErrors;
	}
	$email = $userData['email'];
	$emailExists = emailExists($email);
	if($emailExists){
		return array("Email '$email' is already registered.");
	}
		//TODO:sanitize data
	['email' => $email, 'password' => $password, 'firstName' => $first, 'middleName' => $middle, 'lastName' => $last, 'dob' => $dob, 'phone' => $phone, 'pronouns' => $pronouns] = $userData;
	$createQuery = "insert into members(`email`,`password`,`first_name`,`middle_name`,`last_name`,`dob`,`created`,`phone`,`pronouns`) VALUES ('$email','$password','$first', '$middle', '$last', '$dob', CURDATE(), '$phone', '$pronouns');";
	$id = create($createQuery);
	if($id < 1){
		return array("Failed to create account.");
	}
	$created = createUserAccess($id, 1);
	if($created){
		return;
	}
	return array("Failed to give basic access.");
}
function emailExists($email){
	$query ="select count(*) from members Where `email` = '$email';";
	$found = getCount($query);
	return $found ==1;
}
function validateUser($user){
	$errors = array();
	if(is_null($user)){
		$errors[] = "No data recieved for user.";
	}
	$errors = array_merge($errors,validateEmail($user['email']));
	$errors = array_merge($errors,validatePassword($user['password'], $user['comPass']));
	$errors = array_merge($errors,validateName($user['firstName'], 'First'));
	$errors = array_merge($errors,validateName($user['middleName'], 'Middle'));
	$errors = array_merge($errors,validateName($user['lastName'], 'Last'));
	$errors = array_merge($errors,validateDOB($user['dob']));
	$errors = array_merge($errors,validatePhone($user['phone']));
	
	return $errors;
}

	function validateEmail($email){
		$errors = array();
		if(empty($email)){
			$errors[] = "An Email is required.";
		}
		if(strlen($email)>100){
			$errors[] = "An Email can not have more than 100 characters.";
		}
		//TODO: verify email
		return $errors;
	}

	function validatePassword($password, $comPass){
		if(empty($password)){
			return array("A Password is required.");
		}
		if(strlen($password) > 30){
			return array("A Password can not have more than 30 characters.");
		}
		if(strcmp($password, $comPass)){
			return array("The passwords do not match.");
		}
		//TODO: password requirements
		return array();
	}

	function validateName($name, $type){
		$errors = array();
		if(empty($name)){
			$errors[] = "A $type name is required.";
		}elseif(strlen($name)>15){
			$errors[] = "A $type name can not have more than 15 characters.";
		}
		return $errors;
	}

	function validateDOB($dob){
		$errors = array();
		if(empty($dob)){
			$errors[] = "A Birth Date is required.";
		}else{
			$minDate = Date("1900-01-01");
			$maxDate = Date("Y-m-d");
			if($dob < $minDate){
				$errors[] = "The given Birth Date is too old.";
			}elseif($dob > $maxDate){
				$errors[] = "The given Birth Date is too young.";
			}
		}
		return $errors;
	}
	function validatePhone($phone){
		$errors = array();
		if(empty($phone)){
			$errors[] = "A Phone Number is required.";
		}elseif(strlen($phone) != 10){
			$errors[] = "A Phone Number must be 10 numbers. ex 1112223333";
		}elseif(!preg_match("/^\d+$/", $phone)){
			$errors[] = "A Phone Number must only contain numbers.";
		}
		return $errors;
	}


?>
