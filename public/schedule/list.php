<?php
require_once('../../assets/gateKeeper.php');
if(isset($_POST['scheduled'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=event&scheduled=$id");
	exit();
}
?>

<div class='basicPanel'/>
	<?php include '../../assets/showInfo.php'; ?>
	<?php include './weekView.php';?>
</div>
