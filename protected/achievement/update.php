<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
$id = 0;
$showSureDelete = false;
$space;
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['update'])){
	$error = updateAchievement($_SESSION['hash'], $_POST);
	if(isset($error)){
		$info = $error;
		$achievement = (object) array('name' => $_POST['name'], 'description' => $_POST['description']);
		$id=$_POST['id'];
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}elseif(isset($_POST['delete'])){
	$showSureDelete = true;
	$id = $_POST['id'];
	$achievement = (object) array('name' => $_POST['name'], 'description' => $_POST['description']);
	$id=$_POST['id'];
}elseif(isset($_POST['sureDelete'])){
	$info ='space Deleted';
	$error = deleteAchievement($_SESSION['hash'], $_POST['id']);
	if(isset($error)){
		$info = $error;
		$achievement = (object) array('name' => $_POST['name'], 'description' => $_POST['description']);
		$id=$_POST['id'];
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}else{
	if(!isset($_GET['achievement'])){
		header("Location: ./");
		exit();
	}
	$id = $_GET['achievement'];
	$result = getAchievement($_SESSION['hash'], $id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$achievement = $result[1];
	}
}
?>
<h1>Update</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<form method='POST' action=''>
		<?php	if($showSureDelete){?>
			<input type='text' value='<?php echo $id; ?>' name='id' hidden/>
			<input type='text' value='<?php echo $achievement->name; ?>' name='name' hidden/>
			<input type='text' value='<?php echo $achievement->description; ?>' name='description' hidden/></br>
			<h1>Are You Sure?</h1>
			<input type='text' value='<?php echo $id ?>' name='id' hidden/>
			<input type='submit' value='No' name='no'/>
			<input type='submit' value='Yes, Delete' name='sureDelete'/>
		<?php }else{ ?>
			<?php if(isset($achievement)){?>
				<input type='text' value='<?php echo $id; ?>' name='id' hidden/>
				<label for='name'>Name: </label><input type='text' value='<?php echo $achievement->name; ?>' name='name'/></br>
				<label for='description'>Description: </label><input type='text' value='<?php echo $achievement->description; ?>' name='description'/></br>
			<?php }else{ ?>
				<p>No space found.</p>
			<?php }?>
			<input type='submit' value='Back' name='back' />
			<input type='submit' value='Update' name='update' />
			<input type='submit' value='Delete' name='delete' />
		<?php	} ?>
	</form>
</div>
