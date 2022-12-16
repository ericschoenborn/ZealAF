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
}elseif(isset($_POST['locaiton'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=update&location=$id");
	exit();
}else{
	$locations = getLocations($_SESSION['hash']);
}
?>
<h1>Locations</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($locations)&&count($locations)>0){
		foreach($locations as $location){ ?>
			<form method='POST' action=''>
				<input type='text' value='<?php echo $location[0]; ?>' name='id' hidden/>
				<input type='submit' value='<?php echo $location[1]; ?>' name='locaiton'/>
			</form>
	<?php }}else{ ?>
		<p>No locations found.</p>
	<?php }?>
	<br/>
	<form method='POST' action=''>
		<input type='submit' value='Create New Location' name='create' />
	</form>
</div>

