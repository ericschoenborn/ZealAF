<label for='name'>Name: </label><input type='text' name='name' value='<?php echo $merch->name ?>'/></br>
	<label for='description'>Description: </label><input type='text' name='description' value='<?php echo $merch->description ?>' /></br>
	<label for='cost'>Cost: </label><input type='number' name='cost' value='<?php echo $merch->cost ?>' min='0' max='9999' step='.01'/></br>
	<label for='quantity'>Quantity: </label><input type='number' name='quantity' value='<?php echo $merch->quantity ?>' min='0' max='9999' step='1'/></br>
	<label for='infinete'>Infinite: </label><input type='checkbox' name='infinite' value='<?php echo $merch->infinite ?>' <?php if($merch->infinite){ echo 'checked';} ?>/></br>

