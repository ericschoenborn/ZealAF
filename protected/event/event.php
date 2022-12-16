<?php
require '../../assets/requestFunctions.php';
function getRequirements($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getRequirementsForEvent($hash, $id){
	$data = array();
	$data['type'] = 'getRequirements';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$response = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	$result = json_decode($response);
	return $result;
}
function createEvent($hash, $data){
	$data['type'] = 'create';
	$data['hash'] = $hash;
	$response = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	$result = json_decode($response);
	return $result;
}
function deleteEvent($hash, $id){
	$data = array();
	$data['id'] = $id;
	$data['type'] = 'delete';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	var_dump($result);
	$result = json_decode($result);
	return $result;
}
function updateEvent($hash, $data){	
	$data['type'] = 'update';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getEvent($hash, $id){
	$data = array();
	$data['id'] = $id;
	$data['type'] = 'getSingle';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getEvents($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	$result = json_decode($result);
	return $result;
}
?>
