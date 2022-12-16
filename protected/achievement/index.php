<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

session_start();
require_once('./achievement.php');

$showUpdate = false;
$showCreate = false;
if($_GET['type']=='create'){
	$showCreate = true;
}elseif($_GET['type']=='update'){
	$showUpdate = true;
}
$info;
if(isset($_GET['info'])){
	$info = $_GET['info'];
}
?>
<html>
	<head>
		<title>Achievements</title>
		<style><?php include '../../assets/css/global.css'; ?></style>
	</head>
	<body>
		<?php include '../../assets/banner.php'; ?>
		<?php include '../../assets/navigation.php'; ?>
		<?php include '../../assets/protectedNavigation.php'; ?>
		</br>
		<?php 
			if($showCreate){
				include './create.php';
			}elseif($showUpdate){
				include './update.php';
			}else{
				include './list.php';
			}
		?>
	</body>
</html>

