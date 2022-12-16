<?php
require_once('../../assets/userData.php');
require_once('../../assets/gateKeeper.php');
require_once('./myUser.php');
$controlType;
if(isset($_POST['back'])){
	header("Location: ../../");
	exit();
}
if(isset($_POST['control'])){
	$controlType = $_POST['control'];
}elseif(isset($_POST['controlType'])){
	$controlType = $_POST['controlType'];
}else{
	$controlType = 'Info';
}
?>
<html>
	<head>
		<title>Profile</title>
		<style><?php include '../../assets/css/global.css'; ?></style>
	</head>
	<body>
		<?php include '../../assets/banner.php'; ?>
		<?php include '../../assets/navigation.php'; ?>
		</br>
	<?php $showContent = gateCheck(array('1','2','3','4','5'));
	if($showContent){ ?>

	<form method='POST' action=''>
		<input type='submit' value='Info' name='control' <?php if($controlType=='Info'){ echo 'disabled'; } ?>/>
		<input type='submit' value='Achievements' name='control' <?php if($controlType=='Achievements'){ echo 'disabled'; } ?> />
		<input type='submit' value='Events' name='control' <?php if($controlType=='Events'){ echo 'disabled'; } ?> />
		<input type='submit' value='Deficits' name='control' <?php if($controlType=='Deficits'){ echo 'disabled'; } ?> />
		<input type='text' value='<?php echo $controlType; ?>' name='controlType' hidden/>
	<br/>
	<?php if($controlType == 'Info'){
			include './userFields.php'; 
		}elseif($controlType == 'Achievements'){
			include './achievementFields.php';
		}elseif($controlType == 'Events'){
			include './eventFields.php';
		}elseif($controlType == 'Deficits'){
			include './deficites.php';
		}?>
	</form>
<?php }else{
	include '../../assets/login.php';
	} ?>
</body>
</html>
