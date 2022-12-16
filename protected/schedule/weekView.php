<?php
$weekStart;
$weekEnd;
$schedules;
if(isset($_POST['start']) && isset($_POST['end'])){
	$weekStart = date('Y-m-d', strtotime($_POST['start']));
	$weekEnd = date('Y-m-d', strtotime($_POST['end']));

}else{
	$day = date('w');
	$weekStart = date('Y-m-d', strtotime('-'.$day.' days'));
	$weekEnd = date('Y-m-d', strtotime('+'.(6-$day).' days'));
	$schedules = getSchedules($_SESSION['hash'],$weekStart, $weekEnd);
}
if(isset($_POST['addWeek'])){
	$weekStart = date('Y-m-d', strtotime($weekStart.' + 7 days'));
	$weekEnd = date('Y-m-d', strtotime($weekEnd.' + 7 days'));
	$schedules = getSchedules($_SESSION['hash'],$weekStart, $weekEnd);
}elseif(isset($_POST['minusWeek'])){
	$weekStart = date('Y-m-d', strtotime($weekStart.' - 7 days'));
	$weekEnd = date('Y-m-d', strtotime($weekEnd.' -  7 days'));
	$schedules = getSchedules($_SESSION['hash'],$weekStart, $weekEnd);
}
if(isset($schedules) && count($schedules) > 0){
	$times = array_map(function($o){ return $o->startTime; }, $schedules);
	$earlyTime = date('H',strToTime(min($times)));
	$lateTime = date('H',strToTime(max($times)));
}
?>
<h1>Week View</h1>
<form method='POST' action=''>
	<input type='text' value='<?php echo $weekStart; ?>' name='start' hidden/>
	<input type='text' value='<?php echo $weekEnd; ?>' name='end' hidden/>
	<input type='submit' value='<' name='minusWeek' style='display:inline'/>
	<h3 style='display:inline'><?php echo $weekStart ?> to <?php echo $weekEnd ?></h3>
	<input type='submit' value='>' name='addWeek' style='display:inline'/>
</form>
<?php if(isset($schedules) && count($schedules)>0){ ?>

<table border='1'>
	<tr><th>Time</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr>
<?php while($earlyTime <= $lateTime){ ?>
<tr><td><?php echo date("g:iA", strtotime("$earlyTime:00")); ?></td>
<?php $dayInd = 0;
	while($dayInd < 7){ ?>
<?php 
		$events = array_filter(
    			$schedules, 
			function($val) use($earlyTime, $dayInd){
				$late = $earlyTime + 1;
				$myDay = date('w', strtotime($val->startDate));
      			return $val->startTime >= $earlyTime && $val->startTime < $late && $dayInd == $myDay;

			});
		if(count($events)>0){ ?>
			<td><?php foreach($events as $e){ ?>
	<form method='POST' action=''>
	<input type='text' name='id' value='<?php echo $e->id; ?>' hidden/>
		<input type='submit' name='scheduled' value='<?php echo $e->event->name; ?>' style="background-color:<?php echo $e->event->displayColor; ?>;"></form>
			<?php } ?></td>
		<?php }else{ ?>
			<td></td>
	<?php } $dayInd++;
	} ?>
</tr>
<?php 
$earlyTime++;
} ?>
</table>
<?php } else{ echo "<p>No schedueld events this week</p>"; }?>
