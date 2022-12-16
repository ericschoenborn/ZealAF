<?php
	require_once(dirname(__DIR__).'/../mysql/requests.php');
	function getAccessTagsForUser($userId){
		$query = "select `access_id` FROM user_access WHERE `user_id` = '$userId';";

		$result = getAll($query);
		if($result){
			$accessTagss = array();
			foreach($result as $item){
				$accessTags[] = $item['access_id'];
			}
			return $accessTags;
		}
		return array();
	}
	function createUserAccess($userId, $accessId){
$createQuery = "insert into access_tags(`user_id`,`access_id`) VALUES ('$userId', '$accessId');";
		$id = create($createQuery);
		if($id < 1){
			return array("Failed to create access.");
		}
	}
	function validateUserById($userId, $validIds){
		$tags = getAccessTagsForUser($userId);
		$commonTags = array_intersect($validIds, $tags);
		if($commonTags > 0){
			return null;
		}
		return "Access Denied";
	}

?>
