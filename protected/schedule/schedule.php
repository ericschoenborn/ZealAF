<?php
require '../../assets/requestFunctions.php';

function deleteSchedule($hash, $id){
	$data = array();
	$data['type'] = 'delete';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
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
function getLeaders($hash){
	$data = array();
	$data['type'] = 'getLeaders';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getLeadersForSchedule($hash, $id){
	$data = array();
	$data['type'] = 'getLeadersForSchedule';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function updateScheduleLeaders($hash, $leaders, $id){
	$data = array();
	$data['type'] = 'updateScheduleLeaders';
	$data['hash'] = $hash;
	$data['leaders'] = $leaders;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/userApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function createScheduledEvent($hash, $data){
	$data->type = 'create';
	$data->hash = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getSchedules($hash, $weekStart, $weekEnd){
	$data = array();
	$data['type'] = 'getAll';
	$data['hash'] = $hash;
	$data['weekStart'] = $weekStart;
	$data['weekEnd'] = $weekEnd;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getSchedule($hash, $id){
	$data['type'] = 'getSingle';
	$data['hash'] = $hash;
	$data['id'] = $id;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/scheduleApi.php', $data);
	$result = json_decode($result);
	return $result;
}
?>
