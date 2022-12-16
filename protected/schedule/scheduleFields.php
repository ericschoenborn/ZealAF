<input type='text' value='<?php echo $schedule->id; ?>' name='id' hidden />
<label for='eventId'>Event</label>
<select name='eventId'>
	<option style='display:none;'></option>
	<?php foreach($events as $event){?>
		<option value='<?php echo $event->id;?>' <?php if($schedule->event && $event->id == $schedule->event->id){ echo 'selected';} ?>><?php echo $event->name; ?></option>
        <?php } ?>
</select><input type='text' name='eventOptions' value='<?php echo $eventOptions ?>' hidden/></br>
<label for='scheduleType'/>Schedule Type</label>
<select name='scheduleType' onchange='this.form.submit()'>
	<?php foreach($scheduleTypes as $type){?>
		<option value="<?php echo $type;?>" <?php if($type == $schedule->scheduleType){ echo 'selected';} ?>><?php echo $type; ?></option>
        <?php } ?>
</select></br>
<label for='startDate'>Start Date</label><input type='date' name='startDate' value='<?php echo $schedule->startDate; ?>'/></br>
<?php if($schedule->scheduleType != "once"){ ?>
	<label for='endDate'>End Date</label><input type='date' name='endDate' value='<?php echo $schedule->endDate; ?>'/></br>
<?php }else{ ?><input type='date' name='endDate' value='' hidden/><?php } ?>
<label for='startTime'>Start Time</label><input type='time' name='startTime' value='<?php echo $schedule->startTime; ?>' /></br>
<label for='duration'>Duration</label><input type='number' name='duration' value='<?php echo $schedule->duration; ?>' min='0' max='8' step='.5'/>hours</br>
<label for='selectedLocaiton'/>Location</label>
<select name='selectedLocation' onchange='this.form.submit()'>
	<option style='display:none;'></option>
	<?php foreach($locations as $loc){ ?>
        	<option value="<?php echo $loc->id;?>"<?php if($schedule->location && $loc->id == $schedule->location->id){ echo 'selected';} ?>><?php echo $loc->name; ?></option>
	<?php } ?>
	<?php if($schedule->location && $schedule->location->id){ ?>
		<input type='text' name='locationId' value='<?php echo $schedule->location->id ?>' hidden/>
	<?php } ?>
</select></br><input type='text' name='locaitonOptions' value='<?php echo $locationOptions ?>' hidden/>
<?php if(isset($schedule->location)){ ?>
        <label for='spaceId'>Space</label>
        <select name='spaceId'>
		<option style='display:none;'></option>
		<?php foreach($spaces as $space){?>
                        <option value="<?php echo $space->id;?>"<?php if($schedule->space && $space->id == $schedule->space->id){ echo 'selected';} ?>><?php echo $space->name; ?></option>
                <?php } ?>
        </select></br><input type='text' name='spaceOptions' value='<?php echo $spaceOptions ?>' hidden/>
	<?php } ?>
<?php if(isset($schedule->leaders) && count($schedule->leaders)>0){ ?>
	<label for='Participants'>Leaders</label></br>
	<table border = '1'>
		<tr><th>Name</th><th>Remove</th></tr>
	<?php foreach($schedule->leaders as $leader){?>	
		<tr><td><input type='text' value='<?php echo "$leader->firstName $leader->lastName"; ?>' /></td>
		<td><input type='checkbox' name='removeLeader' value='<?php echo serialize($leader); ?>' onchange='this.form.submit()'/></td>
		</tr> 
		<input type='text' name='selectedLeaders[]' value='<?php echo serialize($leader); ?>' hidden />
	<?php } ?>
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
<input type='text' name='leaderOptions' value='<?php echo $leaderOptions ?>' hidden/></br>

