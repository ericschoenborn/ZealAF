<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('3','4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
if(isset($_POST['create'])){
	header("Location: ./index.php?type=create");
	exit();
}elseif(isset($_POST['scheduled'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=update&scheduled=$id");
	exit();
}?>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php include './weekView.php';?>
	</br>
	<?php $showCreate = gateCheck(array('4','5'));
		if($showCreate){ ?>
		<form method='POST' action=''>
			<input type='submit' value='Create New Scheduled Events' name='create' />
		</form>
	<?php } ?>
</div>

