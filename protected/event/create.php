<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
require_once('../../assets/eventData.php');
$event = new EventData();
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
}elseif(isset($_POST['create'])){
	$error = createEvent($_SESSION['hash'], $_POST);
	if(isset($error)){
		$info = $error;
		$name = $_POST['name'];
		$description = $_POST['description'];
		$address = $_POST['cost'];
	}else{
		$name = $_POST['name'];
		$info = "Event '$name' Created";
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
}
if(isset($options) && isset($event->requirements)){
	foreach($options as $key=>$o){
		if(in_array($o, $event->requirements)){
			unset($options[$key]);
		}
	}
}
?>
<h1>Create</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<form action='' method="post">
		<?php include './eventFields.php'; ?>
		<input type='submit' value='Back' name='back'/>
		<input type='submit' value='Create' name='create'/>
	</form>
</div>
