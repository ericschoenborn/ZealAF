<?php
require '../../assets/requestFunctions.php';
function getSpaces($hash){
	$locationData = array();
	$locationData['type'] = 'getAll';
	$locationData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/spaceApi.php', $locationData);
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
function createLocation($hash, $locationData){
	$locationData['type'] = 'create';
	$locationData['hash'] = $hash;
	$response = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $locationData);
	$result = json_decode($response);
	return $result;
}
function deleteLocation($hash, $id){
	$locationData = array();
	$locationData['id'] = $id;
	$locationData['type'] = 'delete';
	$locationData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $locationData);
	$result = json_decode($result);
	return $result;
}
function updateLocation($hash, $locationData, $spaces){	
	$locationData['type'] = 'update';
	$locationData['hash'] = $hash;
	$spaceIds = array();
	foreach($spaces as $space){
		$spaceIds[] = $space[0];
	}
	$locationData['spaceIds']= $spaceIds;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $locationData);
	$result = json_decode($result);
	return $result;
}
function getLocation($hash, $id){
	$locationData = array();
	$locationData['id'] = $id;
	$locationData['type'] = 'getSingle';
	$locationData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $locationData);
	$result = json_decode($result);
	return $result;
}
function getLocations($hash){
	$locationData = array();
	$locationData['type'] = 'getAll';
	$locationData['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/locationApi.php', $locationData);
	$result = json_decode($result);
	return $result;
}
function adjustSpaces($spaces, $locationSpaces, $spaceName){
	$spaceId=0;
	foreach($locationSpaces as $key => $lSpace){
		if($lSpace[1] == $spaceName){
			$spaceId = $lSpace[0];
			unset($locationSpaces[$key]);
		}
	}
	if($spaceId > 0){
		$spaces[] = array($spaceId, $spaceName);
	}
	return [$spaces, $locationSpaces];
}
function removeUsedSpaces($spaces, $locationSpaces){
	$toRemove = array();
	foreach($locationSpaces as $key => $value){
		$toRemove[] = $value[0];
		}
	if(count($toRemove)>0){
		foreach($spaces as $key => $value){
			if(in_array($value[0], $toRemove)){
				unset($spaces[$key]);
			}
		}
	}
	return [$spaces,$locationSpaces];
}
?>
