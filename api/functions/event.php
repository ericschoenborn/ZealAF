<?php
require_once(dirname(__DIR__).'/../mysql/requests.php');
require_once(dirname(__DIR__).'/../assets/eventData.php');

function deleteEvent($id){
	$getEventSchedules = "SELECT `date`, `time` FROM scheduled WHERE `event_id` = $id;";
	$scheduels = getAll($getEventSchedules);
	if($scheduels){
		$dateTimes = "Please delete events schuduled at theses times before deleteing this event:";
		foreach($scheduels as $s){
			$date = $s['date'];
			$time = $s['time'];
			$dateTimes.= " $date @ $time,";
		}
		$dateTimes = substr($dateTimes, 0 ,-1);
		return $dateTimes;
	}

	$transaction = getTransactionStart();
	$removeRequirements = "DELETE FROM event_requirements WHERE `event_id` = $id;";
	$RRResult = updateWithTransaction($transaction, $removeRequirements);
	if(isset($RRResult[1])){
		rollBack($transaction);
		return "Failed to remove requirements";
	}
	$query = "DELETE FROM events WHERE `id` = $id;";
	$result = updateWithTransaction($transaction,$query);
	if(!isset($result[1])){	
		commit($transaction);
		return null;
	}else{
		rollBack($transaction);
		return "Failed to remove event.";
	}
}function getEvent($id){
	$query = "select `name`, `description`, `cost`, `use_punch_cost` as 'usePunchCost', `punch_cost` as 'punchCost', `use_class_pass_cost` as 'usePassCost', `class_pass_cost` as 'passCost', `use_staff_cost` as 'useStaffCost', `staff_cost` as 'staffCost', `display_color` as 'displayColor' FROM events WHERE `id` = '$id';";
	$result = getSingle($query);
	if($result){	
		return array(null, $result);
	}else{
		return array("Event not found.", $result);
	}
}
function getEvents(){
	$query = "SELECT `id`, `name` FROM events;";
	$result = getAll($query);
	if($result){
		$events = array();
		foreach($result as $item){
			$events[] = array($item['id'], $item['name']);
		}
		return $events;
	}
	return array();
}
function updateEvent($data){
	$event = new EventData();
	$event->setFromArray($data);
	$errors = $event->validate();
	if(!empty($errors)){
		return $errors;
	}
	$result = getEvent($data['id']);
	$errors = $result[0];
	if(!empty($errors)){
		return $errors;
	}
	['name' => $name, 'cost'=>$address, 'description' => $description,'cost'=>$cost,'id' => $id, 'usePunchCost'=>$usePunchCost, 'punchCost'=>$punchCost,'usePassCost'=>$usePassCost,'passCost'=>$passCost,'useStaffCost'=>$useStaffCost,'staffCost'=>$staffCost,'displayColor'=>$displayColor] = $data;
	$result = $result[1];
	$originalName = $result['name'];
	if($originalName != $name){
		$query = "SELECT count(*) FROM events WHERE `name` = '$name';";
		$found = getCount($query);
		if($found > 0){
			return "There already exists an event named '$name'.";
		}
	}
	$query = "UPDATE events SET `name`='$name',`description`='$description',`cost`=$cost,`use_punch_cost`=$usePunchCost,`punch_cost`=$punchCost,`use_class_pass_cost`=$usePassCost,`class_pass_cost`=$passCost,`use_staff_cost`=$useStaffCost,`staff_cost`=$staffCost,`display_color`='$displayColor' WHERE `id`=$id;";
	$result2 = update($query);
	return null;
}
function createEvent($data){
	$event = new EventData();
	$event->setFromArray($data);
	$errors = $event->validate();
	if(!empty($errors)){
		return $errors;
	}
	$name = $data['name'];
	$query = "SELECT count(*) FROM events WHERE `name` = '$name';";
	$found = getCount($query);
	if($found > 0){
		return array("There already exists an event named '$name'.");
	}
	['cost'=>$cost, 'description' => $description,'usePunchCost'=>$usePunchCost, 'punchCost'=>$punchCost,'usePassCost'=>$usePassCost,'passCost'=>$passCost,'useStaffCost'=>$useStaffCost,'staffCost'=>$staffCost,'displayColor'=>$displayColor] = $data;

	$query = "INSERT INTO events (`name`, `description`,`cost`,`use_punch_cost`,`punch_cost`,`use_class_pass_cost`,`class_pass_cost`,`use_staff_cost`,`staff_cost`,`display_color`) VALUES ('$name','$description',$cost,$usePunchCost,$punchCost,$usePassCost,$passCost,$useStaffCost,$staffCost,'$displayColor');";	
	$id = create($query);
	if($id < 1){
		return array("Failed to create Event named $name.");
	}
	return $id;
}
?>
