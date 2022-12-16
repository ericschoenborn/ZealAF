<?php 
if(isset($info)){
	if(gettype($info) == 'array'){
		foreach($info as $i){
			echo "<p>$i</p>";
		}
	}else{
		echo "<p>$info</p>";
	}
}
?>
