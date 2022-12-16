<?php
require_once('../../mysql/requests.php');
require_once('../../assets/scheduleData.php');
require_once('../functions/event.php');
require_once('../functions/location.php');
require_once('../functions/space.php');

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
function createSchedule($data){
	$schedule = new ScheduleData();
	$schedule->setFromArray($data);
	$counter = 0;
	$transaction = getTransactionStart();
	if($schedule->scheduleType == "once"){
		$schedule->endDate = $schedule->startDate;
	}
	while($schedule->startDate <= $schedule->endDate){
		$query = getScheduleCreateQuery($schedule);
		$result = createWithTransaction($transaction, $query);
		if($result[0]>0 && !isset($result[1])){
			$query = getScheduleLeadersCreateQuery($result[0], $schedule);
			$result2 = createWithTransaction($transaction, $query);
			if($result2[0]<1 || isset($result[1])){
				rollBack($transaction);
				return "Failed to craete schedule leaders.";
			}
		}else{
			rollBack($transaction);
			return "Failed to create schedule::$result[0]";
		}
		$counter++;
		if($schedule->scheduleType == "monthly"){
			$schedule->startDate = date('Y-m-d', strtotime($schedule->startDate.' + 1 month'));
		}elseif($schedule->scheduleType == "weekly"){
			$schedule->startDate = date('Y-m-d', strtotime($schedule->startDate.' + 7 days'));
		}elseif($schedule->scheduleType == "bi-weekly"){
			$schedule->startDate = date('Y-m-d', strtotime($schedule->startDate.' + 14 days'));
		}elseif($schedule->scheduleType == "once"){
			break;
		}
	}
	commit($transaction);	
	return "Created $counter scheduled events.";
}
function getScheduleCreateQuery($schedule){
	$query = "INSERT INTO scheduled (`event_id`,`date`,`time`, `duration`";
	$eventId = $schedule->event['id'];
	$values = "VALUES($eventId,'$schedule->startDate','$schedule->startTime',$schedule->duration";
	if(isset($schedule->location)){
		$query .= ",`location_id`";
		$locationId = $schedule->location['id'];
		$values .= ",$locationId";
	}
	if(isset($schedule->space)){
		$query .= ",`space_id`";
		$spaceId = $schedule->space['id'];
		$values .= ",$spaceId";
	}
	return "$query)$values);";
}
function getScheduleLeadersCreateQuery($id, $schedule){
	$query = "INSERT INTO schedule_leaders (`scheduled_id`, `member_id`) Values";
	$values = "";

	foreach($schedule->leaders as $leader){
		if(strlen($values)>0){
			$values .= ",";
		}
		$leaderId = $leader['id'];
		$values .= "('$id','$leaderId')";
	}
	return "$query $values;";
}
function deleteSchedule($id){
	$transaction = getTransactionStart();
	$deleteLeaders = "DELETE FROM schedule_leaders WHERE `scheduled_id` = $id;";
	$DLResult = updateWithTransaction($transaction, $deleteLeaders);
	if(isset($DLResult[1])){
		rollBack($transaction);
		return "Failed to remove leaders";
	}
	$deleteParticipants = "DELETE FROM schedule_participants WHERE `scheduled_id` = $id;";
	$DPResult = updateWithTransaction($transaction, $deleteParticipants);
	if(isset($DPResult[1])){
		rollBack($transaction);
		return "Failed to remove participants";
	}
	$query = "DELETE FROM scheduled WHERE `id` = $id;";
	$result = updateWithTransaction($transaction, $query);
	if(!isset($result[1])){
		commit($transaction);	
		return null;
	}else{
		rollback($transaction);
		return "Failed to delete Schedule";
	}
}
function getUserLeaderEvents($id){
	$query = "SELECT schedule_leaders.`id`, events.`name`, scheduled.`date`, scheduled.`time`, scheduled.`location_id`, scheduled.`space_id` FROM scheduled, schedule_leaders, events WHERE schedule_leaders.`member_id` = $id AND schedule_leaders.`scheduled_id` = scheduled.`id` AND scheduled.`event_id` = events.`id`;";
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
function getUserParticipantEvents($id){
	$query = "SELECT schedule_participants.`id`, events.`name`, scheduled.`date`, scheduled.`time`, scheduled.`location_id`, scheduled.`space_id` FROM scheduled, schedule_participants, events WHERE schedule_participants.`member_id` = $id AND schedule_participants.`scheduled_id` = scheduled.`id` AND scheduled.`event_id` = events.`id`;";
	
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
function removeParticipant($id){
	$query = "DELETE FROM schedule_participants WHERE `id` = $id;";
	$result = update($query);
	if($result > 0){	
		return "Participant removed";
	}else{
		return "Failed to remove participant";
	}
}
?>
