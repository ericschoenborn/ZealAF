<?php
require_once('../../mysql/requests.php');
function getAccessTagNamesForUser($userId){
	$query = "select `access_id` FROM user_access WHERE `user_id` = '$userId';";

	$result = getAll($query);
	if($result){
		$accessIds = array();
		foreach($result as $item){
			$accessIds[] = $item['access_id'];
		}
		$accessIdString = implode("','", $accessIds);
		$query = "select `id`, `name` From access_tags WHERE `id` in ('$accessIdString');";
		$accessResult = getAll($query);
		$accessTags = array();
		if($accessResult){
			foreach($accessResult as $a){
				$accessTags[] = array($a['id'],$a['name']);
			}
		}
		return $accessTags;
	}
	return array();
}
function getAccessTags(){
	$query = "select `id`, `name` FROM access_tags;";
	$result = getAll($query);
	$accessTags = array();
	if($result){
		if($result){
			foreach($result as $a){
				$accessTags[] = array($a['id'],$a['name']);
			}
		}
		return $accessTags;
	}
	return array();
}
function updateUserAccess($data){
	$userId = $data['id'];
	if($userId < 1){
		return "Bad data";
	}
	$query="DELETE FROM user_access WHERE `user_id` = '$userId'";
	$result = update($query);
	$accessTags = $data['accessTags'];
	if(count($accessTags)>0){
		$values = "";
		foreach($accessTags as $tags){
			if(strlen($values)>0){
				$values .= ",";
			}
			$values .= "('$userId','$tags[0]')";
		}
		$query = "INSERT INTO user_access(`user_id`,`access_id`) VALUES $values;";
		$lastId = create($query);
		if($lastId<1){
			return "No change detected.";
		}
	}
	return null;
}
function getAccessTag($id){
	return "not implimented";
}
function updateAccessTag($id){
	return "not implimented";
}
function deleteAccessTag($id){
	return "not implimented";
}
?>
