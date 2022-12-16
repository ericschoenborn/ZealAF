<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('3','4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

$showSureDelete = false;
$merch = new MerchData();
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['update'])){
	$merch->setFromArray($_POST);
	$name = $_POST['name'];
	$info="Updated $name";
	$merch->infinite = 0;
	if(isset($_POST['infinite'])){
		$merch->infinite = 1;
		$merch->quantity = 0;
	}
	$error = updateMerch($_SESSION['hash'], $merch);
	if(isset($error)){
		$info = $error;
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}elseif(isset($_POST['delete'])){
	$showSureDelete = true;
	$merch->setFromArray($_POST);
}elseif(isset($_POST['sureDelete'])){
	$name = $_POST['name'];
	$info ="Merchandise $name Deleted";
	$error = deleteMerch($_SESSION['hash'], $_POST['id']);
	if(isset($error)){
		$info = $error;
		$merch->setFromArray($_POST);
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}else{
	if(!isset($_GET['merch'])){
		header("Location: ./");
		exit();
	}
	$id = $_GET['merch'];
	$result = getMerch($_SESSION['hash'], $id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$merch = $result[1];
	}
}
?>
<h1>Update</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<form method='POST' action=''>
	<?php	if($showSureDelete){?>
		<input type='text' name='id' value='<?php echo $merch->id; ?>' hidden/>
		<input type='text' name='name' value='<?php echo $merch->name; ?>' hidden/>
		<input type='text' name='description' value='<?php echo $merch->description; ?>' hidden/>
		<input type='number' name='cost' value='<?php echo $merch->cost; ?>' hidden/>
		<input type='number' name='quantity' value='<?php echo $merch->quantity; ?>' hidden/>
		<input type='number' name='infinite' value='<?php echo $merch->infinite; ?>' hidden/>

		<h1>Are You Sure?</h1>
		<input type='text' value='<?php echo $merch->id ?>' name='id' hidden/>
		<input type='submit' value='No' name='no'/>
		<input type='submit' value='Yes, Delete' name='sureDelete'/>
	<?php }else{ ?>

	<?php if(isset($merch)){ ?>
		<input type='text' name='id' value='<?php echo $merch->id; ?>' hidden/>
		<?php include('./merchFields.php'); ?>
		<input type='submit' value='Update' name='update' />
		<input type='submit' value='Delete' name='delete' />
		</br>
	<?php }else{ ?>
		<p>Merchandise not found.</p>
	<?php }?>
		<input type='submit' value='Back' name='back' />
	<?php	} ?>
	</form>
</div>
