<?php
require_once(dirname(__DIR__).'/../../mysql/requests.php');
require_once(dirname(__DIR__).'/../../assets/merchData.php');

function deleteMerch($id){
	$query = "DELETE FROM merchandise WHERE `id` = $id;";
	$result = update($query);
	if($result > 0){	
		return null;
	}else{
		return "Failed to delete merchandise";
	}
}function getMerch($id){
	$query = "select `id`, `name`, `description`, `cost`, `quantity`, `infinite` FROM merchandise WHERE `id` = $id;";
	$result = getSingle($query);
	if($result){	
		return array(null, $result);
	}else{
		return array("Merchandise not found.", null);
	}
}
function getMerchandise(){
	$query = "SELECT `id`, `name` FROM merchandise;";
	$result = getAll($query);
	if($result){
		$merch = array();
		foreach($result as $item){
			$merch[] = array($item['id'], $item['name']);
		}
		return $merch;
	}
	return array();
}
function updateMerch($data){
	$merch = new MerchData();
	$merch->setFromArray($data);
	$errors = $merch->validate();
	if(!empty($errors)){
		return $errors;
	}
	$result = getMerch($merch->id);
	$errors = $result[0];
	if(!empty($errors)){
		return array($errors);
	}
	$result = $result[1];
	$originalName = $result['name'];
	if($originalName != $merch->name){
		$query = "SELECT count(*) FROM merchandise WHERE `name` = '$merch->name';";
		$found = getCount($query);
		if($found > 0){
			return array("There already exists merchandise named '$name'.");
		}
	}
	$query = "UPDATE merchandise SET `name`='$merch->name',`description`='$merch->description', `cost`= $merch->cost, `quantity`=$merch->quantity, `infinite`=$merch->infinite WHERE `id`=$merch->id;";
	$result2 = update($query);
	if($result2){
		return null;
	}
	return null;
}
function createMerch($data){
	$merch = new MerchData();
	$merch->setFromArray($data);
	$errors = $merch->validate();
	if(!empty($errors)){
		return $errors;
	}
	$query = "SELECT count(*) FROM merchandise WHERE `name` = '$merch->name';";
	$found = getCount($query);
	if($found > 0){
		return array("There already exists merchandise named '$merch->name'.");
	}
		
	$query = "INSERT INTO merchandise (`name`, `description`, `cost`, `quantity`, `infinite`) VALUES ('$merch->name','$merch->description', $merch->cost, $merch->quantity, $merch->infinite);";
	$id = create($query);
	if($id < 1){
		return array("Failed to create merchandise named $merch->name.");
	}
	return null;
}
?>
