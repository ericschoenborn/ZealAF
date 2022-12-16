<?php
require_once('../mysql/requests.php');
require_once('./functions/event.php');
require_once('./functions/location.php');
require_once('./functions/space.php');
require_once('./functions/session.php');
require_once('../assets/scheduleData.php');

function getSchedule($id){
	$query = "SELECT scheduled.`id`, scheduled.`event_id`, scheduled.`date` as 'startDate', scheduled.`time` as 'startTime', scheduled.`duration`, locations.`name` as 'location', spaces.`name` as 'space' FROM scheduled, locations, spaces WHERE scheduled.`id` = '$id' AND locations.`id` = scheduled.`location_id` AND scheduled.`space_id` = spaces.`id`;";
	$result = getSingle($query);
	if($result){
		$s = new ScheduleData();
		$s->setFromArray($result);
		$eventResult= getEvent($result['event_id']);
		$s->event = $eventResult[1];	
		return array(null, $s);
	}else{
		return array("user not found.", $query);
	}
	return $result;
}
function getSchedules($weekStart, $weekEnd){
	$query = "SELECT `id`, `event_id`, `date` as 'startDate', `time` as 'startTime', `duration`, `location_id` FROM scheduled WHERE `date` >= '$weekStart' AND `date` <= '$weekEnd';";
	$result = getAll($query);
	if($result){
		$schedules = array();
		foreach($result as $item){
			$s = new ScheduleData();
			$s->id = $item['id'];
			$eventResult = getEvent($item['event_id']);
			$s->event = $eventResult[1];
			$s->startDate = $item['startDate'];
			$s->startTime = $item['startTime'];
			$s->duration = $item['duration'];
			$locationResult = getLocation($item['location_id']);
			$s->location = $locationResult[1];
			$schedules[] = $s;
		}
		return $schedules;
	}
	return array();
}
function getUserLeaderEvents($hash){
	$query = "SELECT schedule_leaders.`id`, events.`name`, scheduled.`date`, scheduled.`time`, scheduled.`location_id`, scheduled.`space_id` FROM sessions, scheduled, schedule_leaders, events WHERE sessions.`session_hash` = '$hash' AND schedule_leaders.`member_id` = sessions.`user_id` AND schedule_leaders.`scheduled_id` = scheduled.`id` AND scheduled.`event_id` = events.`id`;";
	$result = getAll($query);
	if($result){
		$leaderEvents = array();
		foreach($result as $item){
			$spaceResult = getSpace($item['space_id']);
			$space = "N/A";
			if(!isset($spacesResult[0])){
				$space = $spaceResult[1]['name'];
			}
			$locationResult = getLocation($item['location_id']);
			$location;
			if(!isset($locationResult[0])){
				$location = $locationResult[1]['name'];
			}
			$leaderEvents[]=array($item['name'], $location, $space, $item['date'], $item['time']);
		}
		return $leaderEvents;
	}
	return $query;
}
function getUserParticipantEvents($hash){
	$query = "SELECT schedule_participants.`id`, events.`name`, scheduled.`date`, scheduled.`time`, scheduled.`location_id`, scheduled.`space_id` FROM sessions, scheduled, schedule_participants, events WHERE sessions.`session_hash` = '$hash' AND schedule_participants.`member_id` = sessions.`user_id` AND schedule_participants.`scheduled_id` = scheduled.`id` AND scheduled.`event_id` = events.`id`;";
	
	$result = getAll($query);
	if($result){
		$participantEvents = array();
		foreach($result as $item){
			$spaceResult = getSpace($item['space_id']);
			$space = "N/A";
			if(!isset($spacesResult[0])){
				$space = $spaceResult[1]['name'];
			}
			$locationResult = getLocation($item['location_id']);
			$location;
			if(!isset($locationResult[0])){
				$location = $locationResult[1]['name'];
			}

			$participantEvents[]=array($item['id'], $item['name'], $location, $space, $item['date'], $item['time']);
		}
		return $participantEvents;
	}
	return array();
}
function removeParticipant($hash, $scheduleParticipantId){
	$result = getUserIdBySessionHash($hash);
	$errors = $result[0];
	if(!empty($errors)){
		return array($errors, null);
	}

	$query = "DELETE FROM schedule_participants WHERE `id` = $scheduleParticipantId;";
	$result = update($query);
	if($result > 0){	
		return "Participant removed";
	}else{
		return "Failed to remove participant";
	}
}
?>
