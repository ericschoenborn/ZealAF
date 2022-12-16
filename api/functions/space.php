<?php
require_once(dirname(__DIR__).'/../mysql/requests.php');
require_once(dirname(__DIR__).'/../assets/spaceData.php');

function deleteSpace($id){
	$result = getLocationsBySpace($_POST['id']);
	if($result){
		$locationsList = "";
		foreach($result as $location){
			$locationsList.= " ".$location[1].",";
		}
		$locationsList = substr($locationsList, 0, -1);
		return "Please remove this spaces from the following locations before deleting:$locationsList";
	}
	$query = "DELETE FROM spaces WHERE `id` = $id;";
	$result = update($query);
	if($result > 0){	
		return null;
	}else{
		return "Failed to remove Space";
	}
}function getSpace($id){
	$query = "select `name`, `description` FROM spaces WHERE `id` = $id;";
	$result = getSingle($query);
	if($result){	
		return array(null, $result);
	}else{
		return array("space not found.", null);
	}
}
function getSpaces(){
	$query = "SELECT `id`, `name` FROM spaces;";
	$result = getAll($query);
	if($result){
		$spaces = array();
		foreach($result as $item){
			$spaces[] = array($item['id'], $item['name']);
		}
		return $spaces;
	}
	return array();
}
function updateSpace($spaceData){
	$space = new SpaceData();
	$space->setFromArray($spaceData);
	$errors = $space->validate();
	if(!empty($errors)){
		return array($errors);
	}
	$result = getSpace($spaceData['id']);
	$errors = $result[0];
	if(!empty($errors)){
		return array($errors);
	}
	['name' => $name, 'description' => $description, 'id' => $id] = $spaceData;
		$result = $result[1];
	$originalName = $result['name'];
	if($originalName != $name){
		$query = "SELECT count(*) FROM spaces WHERE `name` = '$name';";
		$found = getCount($query);
		if($found > 0){
			return array("There already exists a space named '$name'.");
		}
	}
	$query = "UPDATE spaces SET `name`='$name',`description`='$description' WHERE `id`=$id;";
	$result2 = update($query);
	if($result2){
		return null;
	}
	return array("No change detected.");
}
function createSpace($spaceData){
	$space = new SpaceData();
	$space->setFromArray($spaceData);
	$errors = $space->validate();
	if(!empty($errors)){
		return $errors;
	}
	$name = $spaceData['name'];
	$query = "SELECT count(*) FROM spaces WHERE `name` = '$name';";
	$found = getCount($query);
	if($found > 0){
		return array("There already exists a space named '$name'.");
	}
		
	$description = $spaceData['description'];
	$query = "INSERT INTO spaces (`name`, `description`) VALUES ('$name','$description');";	
	$id = create($query);
	if($id < 1){
		return array("Failed to create space named $name.");
	}
	return null;
}
?>
