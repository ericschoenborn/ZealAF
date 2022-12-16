<?php
$userAchievements = getUserAchievements($_SESSION['hash']);
?>
<div class='basicPanel'/>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($userAchievements) && count($userAchievements) > 0){ ?>
		<table border='1'>
			<tr><th>Name</th></tr>
			<?php foreach($userAchievements as $ua){?>
			 <tr><td><?php echo $ua[0]; ?></td><tr>	
			<?php }?>
		</table>	
	<?php }else{ ?>
		<p>None Found</p>
	<?php } ?>
</div>
	
