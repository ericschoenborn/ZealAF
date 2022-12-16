<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$schedule = new ScheduleData();
$schedule->setFromArray($_POST);
$scheduleTypes = array('weekly','bi-weekly','monthly','once');

$leaders;
$leaderOptions="";
if(isset($_POST['leaderOptions'])){
	$leaderOptions = $_POST['leaderOptions'];
	$leaders = unserialize($leaderOptions);
}else{
	$result = getLeaders($_SESSION['hash']);
	if(isset($result) && count($result) > 0){
		foreach($result as $r){
			$user = new UserData();
			$user->id = $r[0];
			$user->firstName = $r[1];
			$user->lastName = $r[2];
			$user->email = $r[3];
			$leaders[] = $user;
		}
	}
	$leaderOptions=serialize($leaders);
}

if(isset($_POST['eventId'])){
	$event = new EventData();
	$event->id = $_POST['eventId'];
	$schedule->event = $event;
}
if(isset($_POST['selectedLeaders']) && $_POST['selectedLeaders'] !=""){
	$userList = array();
	$selectedLeaders = $_POST['selectedLeaders'];
	foreach($selectedLeaders as $leader){
		$user = unserialize($leader);
		$userList[] = $user;
	}
	$schedule->leaders = $userList;
}
if(isset($_POST['leaderData']) && $_POST['leaderData'] !=''){
	$u = unserialize($_POST['leaderData']);
	$schedule->leaders[] = $u;

	$leaderList = unserialize($leaderOptions);
	foreach($leaderList as $key=>$led){
		if($led->email == $u->email){
			unset($leaderList[$key]);
		}
	}
	$leaders = $leaderList;
	$leaderOptions = serialize($leaderList);
}
if(isset($_POST['selectedLocation']) && $_POST['selectedLocation'] != ""){
	$location = new LocationData();
	$location->id = $_POST['selectedLocation'];
	$schedule->location = $location;
}
if(isset($_POST['spaceId'])){
	if(isset($_POST['selectedLocation']) && isset($_POST['locationId']) && $_POST['selectedLocation'] != $_POST['locationId']){
		$schedule->space = null;
	}else{
		$space = new SpaceData();
		$space->id = $_POST['spaceId'];
		$schedule->space = $space;
	}
}
$spaces;
$spaceOptions="";
function refreshSpaces($hash, $schedule){
	$result = getSpacesForLocation($_SESSION['hash'], $schedule->location->id);
	$spaces = array();
	if(isset($result) && count($result) > 0){
		foreach($result as $r){
			$space = new SpaceData();
			$space->id = $r[0];
			$space->name = $r[1];
			$spaces[] = $space;
		}
	}
	return [$spaceOptions=serialize($spaces), $spaces];

}
if(isset($_POST['spaceOptions'])){
	if(isset($_POST['selectedLocation']) && isset($_POST['locationId']) && $_POST['selectedLocation'] != $_POST['locationId']){
		[$spaceOptions, $spaces] = refreshSpaces($_SESSION['hash'], $schedule);
	}else{
		$spaceOptions = $_POST['spaceOptions'];
		$spaces = unserialize($spaceOptions);
	}
}elseif(isset($schedule->location) && isset($schedule->location->id)){
	[$spaceOptions, $spaces] = refreshSpaces($_SESSION['hash'], $schedule);
}
$events;
$eventOptions="";
if(isset($_POST['eventOptions'])){
	$eventOptions=$_POST['eventOptions'];
	$events=unserialize($eventOptions);
}else{
	$result = getEvents($_SESSION['hash']);
	if(isset($result) && count($result) > 0){
		foreach($result as $r){
			$event = new EventData();
			$event->id = $r[0];
			$event->name = $r[1];
			$events[] = $event;
		}
	}
	$eventOptions=serialize($events);
}
$locations;
$locationOptions="";
if(isset($_POST['locationOptions'])){
	$locationOptions=$_POST['locationOptions'];
	$locations=unserialize($locationOptions);
}else{
	$result = getLocations($_SESSION['hash']);
	if(isset($result) && count($result) > 0){
		foreach($result as $r){
			$location = new LocationData();
			$location->id = $r[0];
			$location->name = $r[1];
			$locations[] = $location;
		}
	}
	$locationOptions=serialize($locations);
}
if(isset($_POST['scheduleType'])){
	if($_POST['scheduleType'] == 'once'){
		$schedule->endDate ="";
	}
}

if(isset($_POST['removeLeader'])){
	$removeLeader = unserialize($_POST['removeLeader']);
	foreach($schedule->leaders as $key=>$leader){
		if($leader->email == $removeLeader->email){
			unset($schedule->leaders[$key]);
		}
	}
	$leaders[] = $removeLeader;
	$leaderOptions = serialize($leaders);

}
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['create'])){
	$info = createScheduledEvent($_SESSION['hash'], $schedule);
	header("Location: ./index.php?info=$info");
	exit();
}


?>
<h1>Create</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<form action='' method="post">
		<?php include './scheduleFields.php'; ?>		
		<input type='submit' value='Back' name='back'/>
		<input type='submit' value='Create' name='create'/>
	</form>
</div>
