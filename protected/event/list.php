<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
if(isset($_POST['create'])){
	header("Location: ./index.php?type=create");
	exit();
}elseif(isset($_POST['event'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=update&event=$id");
	exit();
}else{
	$events = getEvents($_SESSION['hash']);
}
?>
<h1>Events</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($events)&&count($events)>0){
		foreach($events as $event){ ?>
			<form method='POST' action=''>
				<input type='text' value='<?php echo $event[0]; ?>' name='id' hidden/>
				<input type='submit' value='<?php echo $event[1]; ?>' name='event'/>
			</form>
	<?php }}else{ ?>
		<p>No events found.</p>
	<?php }?>
	</br>
	<form method='POST' action=''>
		<input type='submit' value='Create New Events' name='create' />
	</form>
</div>

