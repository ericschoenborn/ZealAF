<?php
session_start();
$info = "";
if(isset($_GET['info'])){
	$info = $_GET['info'];
}
?>
<html>
        <head>
		<title>Zeal AF</title>
		<style><?php include './assets/css/global.css'; ?></style>
        </head>
	<body>
		<?php include './assets/banner.php'; ?>
		<?php include './assets/navigation.php'; ?>
		<?php include './assets/protectedNavigation.php'; ?>
		<br/>
		<div class='basicPanel'>
			<?php if(isset($info)){ ?>
				<p> <?php echo $info; ?></p>
			<?php } ?>
			
			<?php if(!isset($_SESSION['hash'])){
				include './assets/login.php';
			}?>
			<div class='logoHolder'>
				<img src='/zealaf/assets/imgs/zeal.png' alt='zeal logo' class='logo'>
			</div>
		</div>
        </body>
</html>
