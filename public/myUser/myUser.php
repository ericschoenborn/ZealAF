<?php
require_once('../../assets/requestFunctions.php');
require_once('../../assets/userData.php');

function getDeficits($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/deficitApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function updateUser($userData){
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $userData);
	$result = json_decode($result);
	return $result;
}
function updatePassword($passwordData){
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $passwordData);
	$result = json_decode($result);
	return $result;
}
function getUser($sessionHash){
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $sessionHash);
	$result = json_decode($result);
	return $result;
}
function removeParticipant($hash, $scheduleParticipantId){
	$data = array();
	$data['type'] = 'removeParticipant';
	$data['hash'] = $hash;
	$data['scheduleParticipantId'] = $scheduleParticipantId;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/scheduleApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserLeaderEvents($hash){
	$data = array();
	$data['type'] = 'getUserLeaderEvents';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/scheduleApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserParticipantEvents($hash){
	$data = array();
	$data['type'] = 'getUserParticipantEvents';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/scheduleApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserAchievements($hash){
	$data = array();
	$data['type'] = 'getUserAchievements';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/achievementApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
?>
