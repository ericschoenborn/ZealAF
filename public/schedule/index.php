<?php
require_once('../../assets/gateKeeper.php');
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

session_start();
require_once('./schedule.php');
require_once('../../assets/scheduleData.php');
require_once('../../assets/eventData.php');
require_once('../../assets/locationData.php');
require_once('../../assets/spaceData.php');
require_once('../../assets/userData.php');
$showEvent = false;
if(isset($_GET['type']) && $_GET['type']=='event'){
	$showEvent = true;
}
$info;
if(isset($_GET['info'])){
	$info = $_GET['info'];
}
?>
<html>
	<head>
		<title>Scheduled Events</title>
		<style><?php include '../../assets/css/global.css'; ?></style>
	</head>
	<body>
		<?php include '../../assets/banner.php'; ?>
		<?php include '../../assets/navigation.php'; ?>
		</br>
		<?php 
			if($showEvent){
				include './event.php';
			}else{
				include './list.php';
			}
		?>
	</body>
</html>

