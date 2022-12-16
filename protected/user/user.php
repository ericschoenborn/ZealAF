<?php
require '../../assets/requestFunctions.php';
function removeUserDeficit($hash, $id){
	$data = array();
	$data['type'] = 'removeUserDeficit';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/deficitApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserDeficits($hash, $id){
	$data = array();
	$data['type'] = 'getUserDeficits';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/deficitApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function removeParticipant($hash, $id){
	$data = array();
	$data['type'] = 'removeParticipant';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserLeaderEvents($hash, $id){
	$data = array();
	$data['type'] = 'getUserLeaderEvents';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserParticipantEvents($hash, $id){
	$data = array();
	$data['type'] = 'getUserParticipantEvents';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getAchievements($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUserAchievements($hash, $id){
	$data = array();
	$data['type'] = 'getUserAchievements';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function updateUserAchievements($hash, $id, $achievements){
	$data = array();
	$data['type'] = 'updateUserAchievements';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$data['achievements'] = $achievements;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getAccessTags($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/accessTagApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUsers($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return  $result;
}
function getUser($hash, $id){
	$data = array();
	$data['type'] = 'getUser';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function updateUser($hash, $data, $originalEmail){
	$data['type'] = 'update';
	$data['hash'] = $hash;
	$data['originalEmail'] = $originalEmail;
	$tags = array();
	if(isset($data['currentTags'])){
		foreach($data['currentTags'] as $tag){
			$tags[] = unserialize($tag);
		}
	}
	$data['accessTags'] = $tags;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function deleteUser($hash, $id){
	$data = array();
	$data['type'] = 'delete';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
?>
