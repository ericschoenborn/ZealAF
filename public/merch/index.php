<?php
session_start();
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once('../../assets/gateKeeper.php');
require_once('./merch.php');
require_once('../../assets/merchData.php');
$showCart = false;
$showItem = false;
if(isset($_POST['cart'])){
	header("Location: ./index.php?type=cart");
	exit();
}elseif(isset($_GET['type']) && $_GET['type']=='cart'){
	$showCart = true;
}elseif(isset($_GET['type']) && $_GET['type']=='item'){
	$showItem = true;
}
$info;
if(isset($_GET['info'])){
	$info = $_GET['info'];
}
?>
<html>
	<head>
		<title>Merchandise</title>
		<style><?php include '../../assets/css/global.css'; ?></style>
	</head>
	<body>
		<?php include '../../assets/banner.php'; ?>
		<?php include '../../assets/navigation.php'; ?>
		</br>
		<?php $showContent = gateCheck(array('1','2','3','4','5'));
		if($showContent){
			if(!$showCart){?>
			
			<form method='POST' action=''>
				<input type='submit' value='Go to cart' name='cart' />
			</form>
		<?php } ?>
		<?php }else{ echo "<p>You must login to purchase merchandise</p>"; } ?>
		<?php 
			if($showCart){
				include './cart.php';
			}elseif($showItem){
				include './item.php';
			}else{
				include './list.php';
			}
		?>
	</body>
</html>

