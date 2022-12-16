<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);
require_once(dirname(__DIR__).'/../mysql/requests.php');
require_once(dirname(__DIR__).'/../assets/locationData.php');

function deleteLocation($id){
	$scheduleQuery = "SELECT events.`name`, scheduled.`date`, scheduled.`time` FROM events, scheduled WHERE scheduled.`location_id` = $id AND events.`id` = scheduled.`event_id`;";
	$scheduled = getAll($scheduleQuery);
	if($scheduled){
		$scheduledList = "";
		foreach($scheduled as $s){
			$scheduledList.= " ".$s['name']." on ".$s['date']." at ".$s['time'].",";
		}
		$scheduledList = substr($scheduledList, 0, -1);
		return "Please remove this location from the following locations before deleting:$scheduledList";
	}
	$removeResult = removeLocationSpaces($id);
	$query = "DELETE FROM locations WHERE `id` = $id;";
	$result = update($query);
	if($result > 0){	
		return null;
	}else{
		return "Failed to delete Location";
	}
}function getLocation($id){
	$query = "select `name`, `address`, `description` FROM locations WHERE `id` = '$id';";
	$result = getSingle($query);
	if($result){	
		return array(null, $result);
	}else{
		return array("Location not found.", null);
	}
}
function getLocations(){
	$query = "SELECT `id`, `name` FROM locations;";
	$result = getAll($query);
	if($result){
		$locations = array();
		foreach($result as $item){
			$locations[] = array($item['id'], $item['name']);
		}
		return $locations;
	}
	return array();
}
function updateLocation($locationData){
	$loc = new LocationData();
	$loc->setFromArray($locationData);
	$errors = $loc->validate();
	if(!empty($errors)){
		return array($errors);
	}
	$result = getLocation($loc->id);
	$errors = $result[0];
	if(!empty($errors)){
		return array($errors);
	}
	$result = $result[1];
	$originalName = $result['name'];
	if($originalName != $loc->name){
		$query = "SELECT count(*) FROM locations WHERE `name` = '$loc->name';";
		$found = getCount($query);
		if($found > 0){
			return array("There already exists a location named '$loc->name'.");
		}
	}
	$query = "UPDATE locations SET `name`='$loc->name', `address`='$loc->address', `description`='$loc->description' WHERE `id`=$loc->id;";
	$result2 = update($query);
	if($result2){
		return null;
	}
	return null;
}
function createLocation($locationData){
	$loc = new LocationData();
	$loc->setFromArray($locationData);
	$errors = $loc->validate();
	if(!empty($errors)){
		return $errors;
	}
	$query = "SELECT count(*) FROM locations WHERE `name` = '$loc->name';";
	$found = getCount($query);
	if($found > 0){
		return array("There already exists a location named '$loc->name'.");
	}
	$query = "INSERT INTO locations (`name`, `address`, `description`) VALUES ('$loc->name','$loc->address','$loc->description');";	
	$id = create($query);
	if($id < 1){
		return array("Failed to create locaiton named $name.");
	}
	return null;
}
?>
