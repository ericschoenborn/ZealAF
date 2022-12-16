<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../assets/eventData.php');
$event = new EventData();
$showSureDelete = false;
$options = array();
$currentOptions ="";
if(isset($_POST['currentOptions'])){
	$currentOptions = $_POST['currentOptions'];
	$options=unserialize($currentOptions);
}else{
	$result = getRequirements($_SESSION['hash']);
	if(isset($result) && count($result) > 0){
		foreach($result as $r){
			$options[]=$r[1];
		}
	}
	$currentOptions = serialize($options);
}
$event->setFromArray($_POST);
if(isset($_POST['back'])){
header("Location: ./");
	exit();
}elseif(isset($_POST['delete'])){
	$showSureDelete = true;
	$id = $_POST['id'];
}elseif(isset($_POST['sureDelete'])){
	$name = $_POST['name'];
	$info ="Space '$name' deleted";
	$error = deleteEvent($_SESSION['hash'], $_POST['id']);
	if(isset($error)){
		$info = $error;
	}
	header("Location: ./index.php?info=$info");
	exit();
}elseif(isset($_POST['removePunchCost'])){
	$event->usePunchCost = 0;
}elseif(isset($_POST['showPunchCost'])){
	$event->usePunchCost = 1;
}elseif(isset($_POST['removePassCost'])){
	$event->usePassCost = 0;
}elseif(isset($_POST['showPassCost'])){
	$event->usePassCost = 1;
}elseif(isset($_POST['removeStaffCost'])){
	$event->useStaffCost = 0;
}elseif(isset($_POST['showStaffCost'])){
	$event->useStaffCost = 1;
}elseif(isset($_POST['update'])){
	$error = updateEvent($_SESSION['hash'], $_POST);
	if(isset($error)){
		$info = $error;
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}elseif(isset($_POST['remove'])){
	$remove = $_POST['remove'];
	foreach($event->requirements as $key=>$r){
		if($r == $remove){
			unset($event->requirements[$key]);
		}
	}
}elseif(isset($_POST['option'])){
	$dropdown = $_POST['option'];
	$event->requirements[] = $dropdown;
}else{
	if(!isset($_GET['event'])){
		header("Location: ./");
		exit();
	}
	$id = $_GET['event'];
	$result = getEvent($_SESSION['hash'], $id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$event->setFromArray($result[1]);
		$event->id = $id;
	}
	$eventReqs = getRequirementsForEvent($_SESSION['hash'], $id);
	$event->requirements = array();
	if(isset($eventReqs) && count($eventReqs)>0){
		$event->requirements = $eventReqs;
	}
}
if(isset($options) && isset($event->requirements)){
	foreach($options as $key=>$o){
		if(in_array($o, $event->requirements)){
			unset($options[$key]);
		}
	}
}
?>
<h1>Update</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if($showSureDelete){ ?>
		<form method='POST' action=''>
			<h1>Are You Sure?</h1>
			<input type='text' value='<?php echo $event->id; ?>' name='id' hidden/>
			<input type='text' value='<?php echo $event->name; ?>' name='name' hidden/>
			<input type='submit' value='No' name='no'/>
			<input type='submit' value='Yes, Delete' name='sureDelete'/>
		</form>
	<?php }else{ ?>
		<?php if(isset($event)){?>
			<form method='POST' action=''>
				<?php include './eventFields.php'; ?>
				<input type='text' value='<?php echo $event->id; ?>' name='id' hidden/>
				<input type='submit' value='Back' name='back' />
				<input type='submit' value='Update' name='update' />
				<input type='submit' value='Delete' name='delete' />
			</form>
		<?php }else{ ?>
			<p>Location not found.</p>
		<?php }?>
	<?php	} ?>
</div>
