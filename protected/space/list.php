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
}elseif(isset($_POST['space'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=update&space=$id");
	exit();
}else{
	$spaces = getSpaces($_SESSION['hash']);
}
?>
<h1>Spaces</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($spaces)&&count($spaces)>0){
		foreach($spaces as $space){ ?>
			<form method='POST' action=''>
				<input type='text' value='<?php echo $space[0]; ?>' name='id' hidden/>
				<input type='submit' value='<?php echo $space[1]; ?>' name='space'/>
			</form>
	<?php }}else{ ?>
		<p>No spaces found.</p>
	<?php }?>
	<br>
	<form method='POST' action=''>
		<input type='submit' value='Create New Space' name='create' />
	</form>
</div>

