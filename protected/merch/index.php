<?php
session_start();
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once('../../assets/gateKeeper.php');
require_once('../../assets/merchData.php');
require_once('./merch.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
        header("Location: ../../?info=you have been logged out");
        exit();
}
$showUpdate = false;
$showCreate = false;
if(isset($_GET['type']) && $_GET['type']=='create'){
        $showCreate = true;
}elseif(isset($_GET['type']) && $_GET['type']=='update'){
        $showUpdate = true;
}
if(isset($_GET['info'])){
        $info = $_GET['info'];
}?>
<html>
	<head>
		<title>Merchandise</title>
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

