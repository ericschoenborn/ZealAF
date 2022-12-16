<?php
require_once(dirname(__DIR__).'/../mysql/requests.php');

function createSession($userId, $email, $password){
	$sessionHash = password_hash("$email+$password", PASSWORD_BCRYPT);
	$createQuery = "insert into sessions(`user_id`,`session_hash`,`expiration`) VALUES ('$userId','$sessionHash',date_add(now(),interval 1 hour));";
	$id = create($createQuery);
	if($id > 0){
		return $sessionHash;
	}
	return;
}
function createRecoverySession($email){
	$sessionHash = password_hash("$email+PasswordResset", PASSWORD_BCRYPT);
	$createQuery = "insert into sessions(`user_id`,`session_hash`,`expiration`) VALUES (-1,'$sessionHash',date_add(now(),interval 3 hour));";
	$id = create($createQuery);
	if($id > 0){
		return $sessionHash;
	}
	return;
}
function getUserIdBySessionHash($hash){
	$query = "SELECT `user_id` FROM sessions where date_add(`expiration`,interval 1 hour) > now() AND `session_hash` = '$hash';";
	$result = getSingle($query);
	if($result){
		return array("", $result['user_id']);
	}
	return array("Session Expired.", null);
}
?>
