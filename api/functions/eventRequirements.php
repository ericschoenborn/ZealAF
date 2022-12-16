<?php
	require_once('../mysql/requests.php');
	function getAchievementIdsByNames($names){
		$stringNames = implode("','", $names);
		$query = "SELECT `id` FROM achievements WHERE `name` in ('$stringNames')";
		$result = getAll($query);
		if($result){
			$achievementsIds = array();
			foreach($result as $item){
				$achievementsIds[] = $item['id'];
			}
			return $achievementsIds;
		}
		return array();
	}

	function getRequirementsByEvent($eventId){
		$query = "select achievements.`name` FROM achievements, event_requirements WHERE event_requirements.`event_id` = '$eventId' AND achievements.`id` = event_requirements.`achievement_id`;";
		$result = getAll($query);
		if($result){
			$requirements = array();
			foreach($result as $item){
				$requirements[] = $item['name'];
			}
			return $requirements;
		}
		return array();
	}
	function getEventsByRequirement($requirementId){
		$query = "select events.`name` FROM events, event_requirements WHERE event_requirements.`requirement_id` = '$requirementId' AND event.`id` = event_requirements.`event_id`;";
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
	function updateEventRequirements($eventId,$requirementIds){
		if($eventId < 1){
			return "Bad data";
		}
		$query="DELETE FROM event_requirements WHERE `event_id` = '$eventId'";
		$result = update($query);
		if(count($requirementIds)>0){
			$values = "";
			foreach($requirementIds as $rid){
				if(strlen($values)>0){
					$values .= ",";
				}
				$values .= "('$eventId','$rid')";
			}
			$query = "INSERT INTO event_requirements(`event_id`,`achievement_id`) VALUES $values;";
			$lastId = create($query);
			if($lastId<1){
				return "update event requirement error";
			}
		}
		return null;
	}

//	function createLocationSpace($userId, $accessId){
//		$createQuery = "insert into user_access(`user_id`,`access_id`) VALUES ('$userId','$accessId');";
//		$id = create($createQuery);
//		if($id > 0){
//			return true;
//		}
//		return false;
//
//	}
?>
