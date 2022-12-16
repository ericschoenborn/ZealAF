<?php
$leaderEvents = array();
$participantEvents =array();

if(isset($_POST['removeParticipant'])){
	$scheduleParticipantId = $_POST['removeParticipant'];
	$result = removeParticipant($_SESSION['hash'], $scheduleParticipantId);
}
$leaderEvents = getUserLeaderEvents($_SESSION['hash']);
$participantEvents = getUserParticipantEvents($_SESSION['hash']);


?>
<div class='basicPanel'/>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($leaderEvents) && count($leaderEvents) > 0){ ?>
		<label>Events as Leader</label></br>
		<table border='1'>
			<tr><th>Name</th><th>Location</th><th>Space</th><th>Date</th><th>Time</th></tr>
			<?php foreach($leaderEvents as $le){?>
			 <tr><td><?php echo $le[0]; ?></td><td><?php echo $le[1]; ?></td><td><?php echo $le[2]; ?></td><td><?php echo $le[3]; ?></td><td><?php echo $le[4]; ?></td><tr>
			<?php } ?>
		</table></br>
	<?php }else{ ?>
		<p>None Found</p>
	<?php } ?>
	<label>Events as Participant</label></br>
	<?php if(isset($participantEvents) && count($participantEvents) > 0){ ?>
		<table border='1'>
			<tr><th>Name</th><th>Location</th><th>Space</th><th>Date</th><th>Time</th><th>Remove</th></tr>
			<?php foreach($participantEvents as $pe){?>
			 <tr><td><?php echo $pe[1]; ?></td><td><?php echo $pe[2]; ?></td><td><?php echo $pe[3]; ?></td><td><?php echo $pe[4]; ?></td><td><?php echo $pe[5] ?></td><td><input type='checkbox' name='removeParticipant' value='<?php echo $pe[0]; ?>' onchange='this.form.submit()'/></td><tr>
			<?php } ?>
		</table></br>
	<?php }else{ ?>
		<p>None Found</p>
	<?php } ?>
</div>
