<?php
require_once('../../mysql/requests.php');
require_once('../../assets/scheduleData.php');
require_once('../functions/event.php');
require_once('../functions/location.php');
require_once('../functions/scheduleLeaders.php');

function getSchedule($id){
	$query = "SELECT `id`, `event_id`, `date` as 'startDate', `time` as 'startTime', `duration`, `location_id` FROM scheduled WHERE `id` = '$id' ;";
	$result = getSingle($query);
	if($result){
		$s = new ScheduleData();
		$s->setFromArray($result);
		$eventResult= getEvent($result['event_id']);
		$s->event = $eventResult[1];	
		return array(null, $s);
	}else{
		return array("user not found.", null);
	}
	return $result;
}
?>
