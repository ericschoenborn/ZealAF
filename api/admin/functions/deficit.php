<?php
require_once('../../mysql/requests.php');

function getUserDeficits($id){
	$query = "select `id`, `name`, `cost`, `date` FROM user_deficit WHERE user_deficit.`user_id` = $id;";
	$result = getAll($query);
	if($result){
		$debt = array();
		foreach($result as $item){
			$debt[] = array($item['id'], $item['date'], $item['name'], $item['cost']);
		}
		return $debt;
	}
	return $array();
}
function removeUserDeficit($deficitId){
	$query = "DELETE FROM user_deficit WHERE `id` = $deficitId;";
	$result = update($query);
	if($result > 0){	
		return null;
	}else{
		return "Failed to delete deficit";
	}
}
?>
