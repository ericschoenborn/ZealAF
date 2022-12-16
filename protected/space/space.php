<?php
require '../../assets/requestFunctions.php';

function createSpace($hash, $spaceData){
	$spaceData['type'] = 'create';
	$spaceData['hash'] = $hash;
	$response = sendPostRequest('http://34.138.189.81/zealaf/api/spaceApi.php', $spaceData);
	$result = json_decode($response);
	return $result;
}
function deleteSpace($hash, $id){
	$spaceData = array();
	$spaceData['id'] = $id;
	$spaceData['type'] = 'delete';
	$spaceData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/spaceApi.php', $spaceData);
	$result = json_decode($result);
	return $result;
}
function updateSpace($hash, $spaceData){	
	$spaceData['type'] = 'update';
	$spaceData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/spaceApi.php', $spaceData);
	$result = json_decode($result);
	return $result;
}
function getSpace($hash, $id){
	$spaceData = array();
	$spaceData['id'] = $id;
	$spaceData['type'] = 'getSingle';
	$spaceData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/spaceApi.php', $spaceData);
	$result = json_decode($result);
	return $result;
}
function getSpaces($hash){
	$spaceData = array();
	$spaceData['type'] = 'getAll';
	$spaceData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/spaceApi.php', $spaceData);
	$result = json_decode($result);
	return $result;
}
?>
