<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('3','4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
$schedule = new ScheduleData();
if(isset($_POST['id'])){
	$schedule->id = $_POST['id'];
	$schedule->event = $_POST['event'];
	$schedule->startDate = $_POST['date'];
	$schedule->startTime = $_POST['time'];
	$schedule->duration = $_POST['duration'];
	$schedule->location = $_POST['location'];
	$schedule->space = $_POST['space'];
}else{
	if(!isset($_GET['scheduled'])){
		header("Location: ./");
		exit();
	}
	$id = $_GET['scheduled'];
	$result = getSchedule($_SESSION['hash'], $id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$schedule->setFromArray($result[1]);
		$schedule->event = $schedule->event->name;
		$leaderResult = getLeadersForSchedule($_SESSION['hash'], $id);
		if(isset($leaderResult) && count($leaderResult) > 0){
			$l = array();
			foreach($leaderResult as $r){
				$user = (object) array('id'=> $r[0], 'firstName'=>$r[1], 'lastName'=>$r[2], 'email'=>$r[3]);
				$l[] = $user;
			}
			$schedule->leaders = $l;
		}
	}
}

$showSureDelete = false;
if(isset($_POST['selectedLeaders']) && $_POST['selectedLeaders'] !=""){
	$userList = array();
	$selectedLeaders = unserialize($_POST['selectedLeaders']);
	foreach($selectedLeaders as $leader){
		$user = $leader;
		$userList[] = $user;
	}
	$schedule->leaders = $userList;
}
if(isset($_POST['leaderData']) && $_POST['leaderData'] !=''){
	$u = unserialize($_POST['leaderData']);
	$schedule->leaders[] = $u;
}
$leaders;
$leaderOptions="";
if(isset($_POST['leaderOptions'])){
	$leaderOptions = $_POST['leaderOptions'];
	$leaders = unserialize($leaderOptions);
}else{
	$result = getLeaders($_SESSION['hash']);
	if(isset($result) && count($result) > 0){
		foreach($result as $r){
			if((isset($schedule->leaders) && count($schedule->leaders) > 0 && !in_array($r[3], array_column($schedule->leaders, 'email'))) || !isset($schedule->leaders)){
				$user = (object) array('id'=> $r[0], 'firstName'=>$r[1], 'lastName'=>$r[2], 'email'=>$r[3]);
				$leaders[] = $user;
			}
		}
	}
	$leaderOptions=serialize($leaders);
}
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['delete'])){
	$showSureDelete = true;
}elseif(isset($_POST['sureDelete'])){
	$info = "$schedule->event at $schedule->startDate has been removed";
	$error = deleteSchedule($_SESSION['hash'], $_POST['id']);
	if(!isset($error)){
		header("Location: ./?info=$info");
		exit();
	}
	$info = $error;
}elseif(isset($_POST['update'])){
	$error = updateScheduleLeaders($_SESSION['hash'], $schedule->leaders, $_POST['id']);
	if(isset($error)){
		$info = $error;
	}else{
		$info = "$schedule->event at $schedule->startDate has been updated";
		header("Location: ./index.php?info=$info");
		exit();
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
?>
<h1>Update</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if($showSureDelete){ ?>
		<form method='POST' action=''>
		<h1>Are You Sure?</h1>
			<input type='text' value='<?php echo $schedule->id; ?>' name='id' hidden/>
			<input type='text' name='event' value='<?php echo $schedule->event; ?>' hidden/>
			<input type='text' name='date' value='<?php echo $schedule->startDate; ?>' hidden/>
			<input type='text' name='time' value='<?php echo $schedule->startTime; ?>' hidden/>
			<input type='text' name='duration' value='<?php echo $schedule->duration; ?>' hidden/>
			<input type='text' name='location' value='<?php echo $schedule->location; ?>' hidden/>
			<input type='text' name='space' value='<?php echo $schedule->space; ?>' hidden/>
			<input type='text' name='name' value='<?php echo $schedule->event; ?>' hidden/>
			<input type='submit' value='No' name='no'/>
			<input type='submit' value='Yes, Delete' name='sureDelete'/>
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
		<label>Duration: <?php echo $schedule->duration;?></label></br>
		<label>Location: <?php echo $schedule->location; ?></label></br>
		<label>Space: <?php echo $schedule->space; ?></label></br>
<?php if(isset($schedule->leaders) && count($schedule->leaders)>0){ ?>
	<label for='Participants'>Leaders</label></br>
	<table border = '1'>
		<tr><th>Name</th><th>Remove</th></tr>
	<?php foreach($schedule->leaders as $leader){?>	
		<tr><td><input type='text' value='<?php echo "$leader->firstName $leader->lastName"; ?>' /></td>
		<td><input type='checkbox' name='removeLeader' value='<?php echo serialize($leader); ?>' onchange='this.form.submit()'/></td>
		</tr> 
	<?php } ?>
		<input type='text' name='selectedLeaders' value='<?php echo serialize($schedule->leaders); ?>' hidden/>
	</table>
<?php } ?>
<?php if(isset($leaders) && count($leaders) > 1){ ?>
	<label for='leaderData'/>Add Leader</label>
	<select name='leaderData' onchange='this.form.submit()'>
		<option style='display:none;'></option>
		<?php foreach($leaders as $leader){ ?>
			<option value='<?php echo serialize($leader); ?>'><?php echo "$leader->firstName $leader->lastName"; ?></option>
        <?php } ?>
	</select></br>
<?php } ?>

		<input type='submit' value='Back' name='back' />
		<input type='submit' value='Update' name='update' />
<?php	
$showDelete = gateCheck(array('4','5'));
if($showDelete){ ?>
		<input type='submit' value='Delete' name='delete' />
<?php } ?>
	</form>
<?php }else{ ?>
	<p>Scheduled event not found.</p>
<?php }?>

	<?php	} ?>
	</form>
</div>
