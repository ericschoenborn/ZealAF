<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

$info;
$merch = new MerchData();
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['create'])){
	$merch->setFromArray($_POST);
	$merch->infinite = 0;
	if(isset($_POST['infinite'])){
		$merch->infinite = 1;
		$merch->quantity = 0;
	}
	$error = createMerch($_SESSION['hash'], $merch);
		
	$name = $_POST['name'];
	if(isset($error)){
		$info = $error;	
		$merch->setFromArray($_POST);
	}else{
		header("Location: ./index.php?info=$name created");
		exit();
	}
}
?>
<h1>Create</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<form method='POST' action=''>
		<?php include('./merchFields.php'); ?>
		<input type='submit' value='Back' name='back' />
		<input type='submit' value='create' name='create' />
	</form>
</div>
