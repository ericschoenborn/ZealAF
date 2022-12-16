<?php
require_once('../../assets/gateKeeper.php');
$schedule = new ScheduleData();
if(!isset($_GET['scheduled'])){
	header("Location: ./");
	exit();
}
$id = $_GET['scheduled'];
$result = getSchedule($id);
if(isset($result) && isset($result[0])){
	$info = $result[0];
}else{
	$schedule->setFromArray($result[1]);
	$schedule->event = $schedule->event->name;
	$leaderResult = getLeadersForSchedule($id);
	$userIsPrticipant = false;
	if(isset($leaderResult) && count($leaderResult) > 0){
		$l = array();
		foreach($leaderResult as $r){
			$user = (object) array('id'=> $r[0], 'firstName'=>$r[1], 'lastName'=>$r[2], 'email'=>$r[3]);
			$l[] = $user;
		}
		$schedule->leaders = $l;		
	}
	if(isset($_SESSION['hash'])){
		$userIsParticipant = getParticipantStatus($_SESSION['hash'], $id);
	}
}

$showSureLeave = false;
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['leave'])){
	$showSureLeave = true;
	$id = $_POST['id'];
}elseif(isset($_POST['sureLeave'])){
	$info = "You have been removed from $schedule->event on $schedule->startDate at $schedule->startTime";
	$error = leaveScheduledEvent($_SESSION['hash'], $_POST['id']);
	if(isset($error)){
		$info = $error;
	}
	header("Location: ./index.php?info=$info");
	exit();
}elseif(isset($_POST['join'])){
	$error = joinScheduledEvent($_SESSION['hash'], $_POST['id']);
	if(isset($error)){
		$info = $error;
	}else{
		$info = "You have joined $schedule->event on $schedule->startDate at $schedule->startTime";
		header("Location: ./index.php?info=$info");
		exit();
	}
}
?>
<h1>Event Info</h1>
<div class='basicPanel'/>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if($showSureLeave){ ?>
		<form method='POST' action=''>
			<h1>Are You Sure?</h1>
			<input type='text' value='<?php echo $schedule->id; ?>' name='id' hidden/>
			<input type='submit' value='No' name='no'/>
			<input type='submit' value='Yes, Leave' name='sureLeave'/>
		</form>
	<?php }else{ ?>
		<?php if(isset($schedule)){?>
			<form method='POST' action=''>
				<input type='text' name='id' value='<?php echo $schedule->id; ?>' hidden/>
				<input type='text' name='event' value='<?php echo $schedule->event; ?>' hidden/>
				<input type='text' name='date' value='<?php echo $schedule->startDate; ?>' hidden/>
				<input type='text' name='time' value='<?php echo $schedule->startTime; ?>' hidden/>
				<input type='text' name='duration' value='<?php echo $schedule->duration; ?>' hidden/>
				<input type='text' name='location' value='<?php echo $schedule->location; ?>' hidden/>
				<input type='text' name='space' value='<?php echo $schedule->space; ?>' hidden/>
				<input type='text' name='name' value='<?php echo $schedule->event; ?>' hidden/>
				<label>Event Name: <?php echo $schedule->event;?></label></br>
				<label>Date: <?php echo $schedule->startDate;?></label></br>
				<label>Start Time: <?php echo $schedule->startTime;?></label></br>
				<label>Duration: <?php echo (int)$schedule->duration;?> hours</label></br>
				<label>Location: <?php echo $schedule->location; ?></label></br>
				<label>Space: <?php echo $schedule->space; ?></label></br>
		<?php if(isset($schedule->leaders) && count($schedule->leaders)>0){ ?>
			<label for='Participants'>Leaders: </label></br>
			<table border = '1'>
				<tr><th>Name</th></tr>
				<?php foreach($schedule->leaders as $leader){?>	
					<tr><td><input type='text' value='<?php echo "$leader->firstName $leader->lastName"; ?>' /></td></tr> 
				<?php } ?>
			</table>
		<?php } ?>
	<input type='submit' value='Back' name='back' />
	<?php	if(isset($_SESSION['hash'])){ ?>
		<?php	if($userIsParticipant){ ?>
				<input type='submit' value='Leave Class' name='leave' />
		<?php }else{ ?>
		<input type='submit' value='Join Event' name='join' />
	<?php }} ?>
	</form>
<?php }else{ ?>
	<p>Scheduled event not found.</p>
<?php }?>

	<?php	} ?>
	</form>
</div>
