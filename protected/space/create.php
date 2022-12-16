<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

$info;
$name = "";
$description = "";
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['create'])){
	$error = createSpace($_SESSION['hash'], $_POST);
	$name = $_POST['name'];
	if(isset($error)){
		$info = $error;	
		$description = $_POST['description'];
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
		<label for='name'>Name: </label><input type='text' value='<?php echo $name ?>' name='name' /></br>
		<label for='description'>Description: </label><input type='text' value='<?php echo $description ?>' name='description' /></br>
		<input type='submit' value='Back' name='back' />
		<input type='submit' value='create' name='create' />
	</form>
</div>
