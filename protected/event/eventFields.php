<label for='name'>Name</label><input type='text' name='name' value='<?php echo $event->name ?>'/></br>
                        <label for='description'>Description</label><input type='text' name='description' value='<?php echo $event->description; ?>' /></br>
			<label for='cost'>Cost</label><input type='number' name='cost'  value='<?php echo $event->cost; ?>' min='0.00' max='999.99' step='.01'/></br>
			<?php if($event->usePunchCost){ ?>
			<label for='Punch Cost'>Punch Cost</label><input type='number' value='<?php echo $event->punchCost ?>' min='1' max='10' step='1' name='punchCost'/><input type='submit' value='Remove Punch Cost' name='removePunchCost'/></br>
				<input type='number' value=1 name='usePunchCost' hidden/>
			<?php }else{ ?>
				<input type='submit' value='Add Punch Cost' name='showPunchCost'/></br>
				<input type='number' name='punchCost' value=0 hidden/>
				<input type='number' name='usePunchCost' value=0 hidden/>
			<?php } ?>
			<?php if($event->usePassCost){ ?>
			<label for='Pass Cost'>Class Pass Cost</label><input type='number' value='<?php echo $event->passCost ?>'min='0' max='9999' step='.01' name='passCost'/><input type='submit' value='Remove Class Pass Cost' name='removePassCost'/></br>
				<input type='number' value=1 name='usePassCost' hidden/>
			<?php }else{ ?>
				<input type='submit' value='Add Class Pass Cost' name='showPassCost'/></br>
				<input type='number' name='passCost' value=0 hidden/>
				<input type='number' name='usePassCost' value=0 hidden/>
			<?php } ?>
			<?php if($event->useStaffCost){ ?>
			<label for='Staff Cost'>Staff Costs</label><input type='number' name='staffCost' value='<?php echo $event->staffCost ?>' min='0' max='9999' step='.01'/><input type='submit' value='Remove Staff Cost' name='removeStaffCost'/></br>
				<input type='number' value=1 name='useStaffCost' hidden/>
			<?php }else{ ?>
				<input type='submit' value='Add Staff Cost' name='showStaffCost'/></br>
				<input type='number' name='staffCost' value=0 hidden/>
				<input type='number' name='useStaffCost' value=0 hidden/>
			<?php } ?>
				<label for='displayColor'>Display Color</label><input type='color' name='displayColor' value='<?php echo $event->displayColor ?>'/></br>	
				<label>Requirements</label></br>
				<?php if(isset($event->requirements)){ foreach($event->requirements as $r){?>
			<input type='checkbox' name='remove' value='<?php echo $r; ?>' onchange='this.form.submit()'/> <input type='text' value='<?php echo $r; ?>' name='requirements[]'></br>
			<?php } }
			if(isset($options) && count($options) > 0){ ?>
			<label for='option'>Add Requirement</label>
			<select name='option' onchange='this.form.submit()'>
				<option style='display:none;'></option>
				<?php foreach($options as $o){?>
					<option value="<?php echo $o;?>"><?php echo $o; ?></option>
				<?php } ?>
			</select>
			<?php } ?>
			<input type='text' name='currentOptions' value='<?php echo $currentOptions ?>' hidden/></br>

