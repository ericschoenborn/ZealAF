<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once('../../assets/userData.php');
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('3','4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

if(!isset($_GET['user'])){
	header("Location: ./");
	exit();
}
$id = $_GET['user'];
$controlType;
if(isset($_POST['back'])){
	header("Location: ./");
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
<form method='POST' action=''>
	<input type='submit' value='Info' name='control' <?php if($controlType=='Info'){ echo 'disabled'; } ?>/>
	<input type='submit' value='Achievements' name='control' <?php if($controlType=='Achievements'){ echo 'disabled'; } ?> />
	<input type='submit' value='Events' name='control' <?php if($controlType=='Events'){ echo 'disabled'; } ?> />
	<input type='submit' value='Deficits' name='control' <?php if($controlType=='Deficits'){ echo 'disabled'; } ?> />
</form>
<div class='basicPanel'>
	<form method='POST' action=''>
		<input type='text' value='<?php echo $controlType; ?>' name='controlType' hidden/>
		<?php include '../../assets/showInfo.php'; ?>
		<?php if($controlType == 'Info'){
			include './userFields.php'; 
		}elseif($controlType == 'Achievements'){
			include './achievementFields.php';
		}elseif($controlType == 'Events'){
			include './eventFields.php';
		}elseif($controlType == 'Deficits'){
			include './deficits.php';
		}?>
		<?php if(!isset($_POST['delete'])){ ?>
			<input type='text' value='<?php echo $id; ?>' name='id' hidden/>
			<input type='submit' value='Back' name='back' />
			<?php if($controlType != 'Deficits' && $controlType != 'Events'){ ?>
				<input type='submit' value='Update' name='update' />
			<?php } ?>
			<?php if($controlType == 'Info'){ ?> 
				<input type='submit' value='Delete' name='delete' />
			<?php } ?>
		<?php } ?>
	</form>
</div>
