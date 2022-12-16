<?php
$user = new UserData();
$leaderEvents = array();
$participantEvents =array();

if(isset($_GET['user'])){
	$user->id = $_GET['user'];
}else{
	header("Location: ./index.php?info='faild to find user'");
	exit();
}
if(isset($_POST['removeParticipant'])){
	$scheduleParticipantId = $_POST['removeParticipant'];
	$result = removeParticipant($_SESSION['hash'], $scheduleParticipantId);
	$info = $result;
}
$result = getUser($_SESSION['hash'], $user->id);
if(isset($result) && isset($result[0])){
	$info = $result[0];
}else{
	$user = $result[1];
	$user->id = $id;
	$leaderEvents = getUserLeaderEvents($_SESSION['hash'], $user->id);
	$participantEvents = getUserParticipantEvents($_SESSION['hash'], $user->id);
}

?>
<h1>Events</h1>
<h3><?php echo "$user->firstName $user->lastName"; ?></h3>
<input type='text' name='id' value='<?php echo $user->id; ?>' hidden/>
<input type='text' name='firstName' value='<?php echo $user->firstName; ?>' hidden/>
<input type='text' name='lastName' value='<?php echo $user->lastName; ?>' hidden/>
<label>Events as Leader</label></br>
<?php if(isset($leaderEvents) && count($leaderEvents) > 0){ ?>
	<table border='1'>
		<tr><th>Name</th><th>Location</th><th>Space</th><th>Date</th><th>Time</th></tr>
		<?php foreach($leaderEvents as $le){?>
		 <tr><td><?php echo $le[0]; ?></td><td><?php echo $le[1]; ?></td><td><?php echo $le[2]; ?></td><td><?php echo $le[3]; ?></td><td><?php echo $le[4]; ?></td><tr>
		<?php }}else{ ?>
			<tr><td>None Found</td><td></td></tr>
		<?php } ?>
	</table></br>
<label>Events as Participant</label></br>
<?php if(isset($participantEvents) && count($participantEvents) > 0){ ?>
	<table border='1'>
		<tr><th>Name</th><th>Location</th><th>Space</th><th>Date</th><th>Time</th><th>Remove</th></tr>
		<?php foreach($participantEvents as $pe){?>
		 <tr><td><?php echo $pe[1]; ?></td><td><?php echo $pe[2]; ?></td><td><?php echo $pe[3]; ?></td><td><?php echo $pe[4]; ?></td><td><?php echo $pe[5] ?></td><td><input type='checkbox' name='removeParticipant' value='<?php echo $pe[0]; ?>' onchange='this.form.submit()'/></td><tr>
		<?php }}else{ ?>
			<tr><td>None Found</td><td></td></tr>
		<?php } ?>
	</table></br>

