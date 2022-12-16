<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}
if(isset($_POST['create'])){
	header("Location: ./index.php?type=create");
	exit();
}elseif(isset($_POST['merch'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=update&merch=$id");
	exit();
}else{
	$merch = getMerchandise($_SESSION['hash']);
}
?>
<h1>Merchandise</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($merch)&&count($merch)>0){
		foreach($merch as $m){ ?>
			<form method='POST' action=''>
				<input type='text' value='<?php echo $m[0]; ?>' name='id' hidden/>
				<input type='submit' value='<?php echo $m[1]; ?>' name='merch'/>
			</form>
	<?php }}else{ ?>
		<p>No Merchandise found.</p>
	<?php }?>
	<br/>
	<form method='POST' action=''>
		<input type='submit' value='Create New Merchandise' name='create' />
	</form>
</div>

