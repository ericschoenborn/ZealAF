<?php
	require_once('../mysql/requests.php');
	function getUserAchievements($hash){
		$query = "SELECT achievements.`name` FROM sessions, achievements, user_achievements WHERE sessions.`session_hash` = '$hash' AND user_achievements.`user_id` = sessions.`user_id` AND user_achievements.`achievement_id` = achievements.`id`;";
		$result = getAll($query);
		if($result){
			$achievements = array();
			foreach($result as $item){
				$achievements[] = array($item['name']);
			}
			return $achievements;
		}
		return array();
	}
?>
