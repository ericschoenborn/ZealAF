<?php
ini_set('display_errors', 1);
      error_reporting(E_ALL);
require_once('../../mysql/requests.php');
function getUserAchievements($id){
	$query = "SELECT achievements.`id`, achievements.`name` FROM achievements, user_achievements WHERE user_achievements.`user_id` = $id AND user_achievements.`achievement_id` = achievements.`id`;";
	$result = getAll($query);
	if($result){
		$achievements = array();
		foreach($result as $item){
			$achievements[] = array($item['id'], $item['name']);
		}
		return $achievements;
	}
	return array();
}function updateUserAchievements($id, $achievements){
	$query = "DELETE FROM user_achievements WHERE `user_id` = $id;";
	$result = update($query);
	if(isset($achievements) && count($achievements) >0){
		$values = "";
		foreach($achievements as $a){
			if(strlen($values)>0){
				$values .= ",";
			}
			$achievementId = $a[0];
			$values .= "('$id','$achievementId')";
		}
		$query = "INSERT INTO user_achievements(`user_id`,`achievement_id`) VALUES $values;";
		$lastId = create($query);
		if($lastId<1){
			return "update user achievement error";
		}	
	}
	return null;
}
function deleteAchievement($id){
		$query = "DELETE FROM achievements WHERE `id` = $id;";
		$result = update($query);
		return $result;
		if($result > 0){	
			return "Achievement removed.";
		}else{
			return array($query);
		}
	}function getAchievement($id){
		$query = "select `name`, `description` FROM achievements WHERE `id` = $id;";
		$result = getSingle($query);
		if($result){	
			return array(null, $result);
		}else{
			return array("Achievement not found.", $result);
		}
	}
	function getAchievements(){
		$query = "SELECT `id`, `name` FROM achievements;";
		$result = getAll($query);
		if($result){
			$achievements = array();
			foreach($result as $item){
				$achievements[] = array($item['id'], $item['name']);
			}
			return $achievements;
		}
		return array();
	}
	function updateAchievement($achievementData){
		$errors = array();
		$errors = array_merge($errors,validateName($achievementData['name']));
		$errors = array_merge($errors,validateDescription($achievementData['description']));
		if(!empty($errors)){
			return array($errors);
		}
		$result = getAchievement($achievementData['id']);
		$errors = $result[0];
		if(!empty($errors)){
			return array($errors);
		}
		['name' => $name, 'description' => $description, 'id' => $id] = $achievementData;

		$result = $result[1];
		$originalName = $result['name'];
		if($originalName != $name){
			$query = "SELECT count(*) FROM achievements WHERE `name` = '$name';";
			$found = getCount($query);
			if($found > 0){
				return array("There already exists an achievement named '$name'.");
			}
		}
		$query = "UPDATE achievements SET `name`='$name',`description`='$description' WHERE `id`=$id;";
		$result2 = update($query);
		if($result2){
			return null;
		}
		return array("No change detected.");

	}
	function createAchievement($achievementData){
		$errors = array();
		$errors = array_merge($errors,validateName($achievementData['name']));
		$errors = array_merge($errors,validateDescription($achievementData['description']));
		if(!empty($errors)){
			return $errors;
		}
		$name = $achievementData['name'];
		$query = "SELECT count(*) FROM achievements WHERE `name` = '$name';";
		$found = getCount($query);
		if($found > 0){
			return array("There already exists an achievement named '$name'.");
		}

		
		$description = $achievementData['description'];
		$query = "INSERT INTO achievements (`name`, `description`) VALUES ('$name','$description');";	
		$id = create($query);
		if($id < 1){
			return array("Failed to create achievement named $name.");
		}
		return null;
	}
	function validateName($name){
		$errors = array();
		if(empty($name)){
			$errors[] = "A name is required.";
		}elseif(strlen($name)>50){
			$errors[] = "A name can not have more than 50 characters.";
		}
		return $errors;
	}

	function validateDescription($description){
		$errors = array();
		if(empty($description)){
			$errors[] = "A description is required.";
		}elseif(strlen($description)>300){
			$errors[] = "A description can not have more than 300 characters.";
		}
		return $errors;
	}

?>
