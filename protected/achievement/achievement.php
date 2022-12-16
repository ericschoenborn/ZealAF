<?php
require '../../assets/requestFunctions.php';

	function createAchievement($hash, $achievementData){
		$achievementData['type'] = 'create';
		$achievementData['hash'] = $hash;
		$response = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $achievementData);
		$result = json_decode($response);
		return $result;
	}

	function deleteAchievement($hash, $id){
		$achievementData = array();
		$achievementData['id'] = $id;
		$achievementData['type'] = 'delete';
		$eachievementData['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $achievementData);
		$result = json_decode($result);
		return $result;
	}

	function updateAchievement($hash, $achievementData){	
		$achievementData['type'] = 'update';
		$achievementData['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $achievementData);
		$result = json_decode($result);
		return $result;
	}

	function getAchievement($hash, $id){
		$achievementData = array();
		$achievementData['id'] = $id;
		$achievementData['type'] = 'getSingle';
		$achievementData['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $achievementData);
		$result = json_decode($result);
		return $result;
	}

	function getAchievements($hash){
		$achievementData = array();
		$achievementData['type'] = 'getAll';
		$achievementData['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/achievementApi.php', $achievementData);
		$result = json_decode($result);
		return $result;
	}
?>
