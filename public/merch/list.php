<?php
if(isset($_POST['merch'])){
	$id = $_POST['id'];
	header("Location: ./index.php?type=item&merch=$id");
	exit();
}else{
	$merch = getMerchandise();
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
</div>

