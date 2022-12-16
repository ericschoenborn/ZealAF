<?php
require_once('../mysql/requests.php');
function getSpacesByLocation($locationId){
	$query = "select spaces.`id`, spaces.`name` FROM spaces, location_spaces WHERE location_spaces.`location_id` = '$locationId' AND spaces.`id` = location_spaces.`space_id`;";
	$result = getAll($query);
	if($result){
		$spaces = array();
		foreach($result as $item){
			$spaces[] = array($item['id'],$item['name']);
		}
		return $spaces;
	}
	return array();
}
function getLocationsBySpace($spaceId){
	$query = "select locations.`id`, locations.`name` FROM locations, location_spaces WHERE location_spaces.`space_id` = '$spaceId' AND locations.`id` = location_spaces.`location_id`;";
	$result = getAll($query);
	if($result){
		$locations = array();
		foreach($result as $item){
			$locations[] = array($item['id'],$item['name']);
		}
		return $locations;
	}
	return array();
}
function updateLocationSpaces($locationId,$spaceIds){
	if($locationId < 1){
		return "Bad data";
	}
	$removeResult = removeLocationSpaces($locationId);
	if(count($spaceIds)>0){
		$values = "";
		foreach($spaceIds as $sid){
			if(strlen($values)>0){
				$values .= ",";
			}
			$values .= "('$locationId','$sid')";
		}
		$query = "INSERT INTO location_spaces(`location_id`,`space_id`) VALUES $values;";
		$lastId = create($query);
		if($lastId<1){
			return "update location spaces error";
		}
	}
	return null;
}
function removeLocationSpaces($locationId){
	$query="DELETE FROM location_spaces WHERE `location_id` = '$locationId'";
	$result = update($query);
	return $result;
}
?>
