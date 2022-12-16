<?php
require '../../assets/requestFunctions.php';

function getEvents($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getLocations($hash){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getSpacesForLocation($hash, $id){
	$locationData = array();
	$locationData['type'] = 'getSpaces';
	$locationData['hash'] = $hash;
	$locationData['id'] = $id;
	$response = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $locationData);
	$result = json_decode($response);
	return $result;
}
function getLeadersForSchedule($id){
	$data = array();
	$data['type'] = 'getLeadersForSchedule';
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getParticipantStatus($hash, $id){
	$data = array();
	$data['type'] = 'getParticipantStatus';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function joinScheduledEvent($hash, $id){
	$data = array();
	$data['type'] = 'joinScheduledEvent';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function leaveScheduledEvent($hash, $id){
	$data = array();
	$data['type'] = 'leaveScheduledEvent';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getSchedules($weekStart, $weekEnd){
	$data = array();
	$data['type'] = 'getAll';
	$data['weekStart'] = $weekStart;
	$data['weekEnd'] = $weekEnd;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/scheduleApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getSchedule($id){
	$data['type'] = 'getSingle';
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/scheduleApi.php', $data);
	$result = json_decode($result);
	return $result;
}

?>
