<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
if(isset($_POST['create'])){
	header("Location: ./index.php?type=create");
	exit();
}elseif(isset($_POST['achievement'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=update&achievement=$id");
	exit();
}else{
	$achievements = getAchievements($_SESSION['hash']);
}
?>
<h1>Achievements</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($achievements)&&count($achievements)>0){
		foreach($achievements as $achi){ ?>
			<form method='POST' action=''>
				<input type='text' value='<?php echo $achi[0]; ?>' name='id' hidden/>
				<input type='submit' value='<?php echo $achi[1]; ?>' name='achievement'/>
			</form>
	<?php }}else{ ?>
		<p>No achievements found.</p>
	<?php }?>
	</br>
	<form method='POST' action=''>
		<input type='submit' value='Create New Achievement' name='create' />
	</form>
</div>

