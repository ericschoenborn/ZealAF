<?php
$user = new UserData(); 

if(isset($_GET['user'])){
	$user->id = $_GET['user'];
}else{
	header("Location: ./index.php?info='faild to find user'");
	exit();
}
if(isset($_POST['removeDeficit'])){
	$result = removeUserDeficit($_SESSION['hash'], $_POST['removeDeficit']);
	if(isset($result)){
		$info = $result;
	}
}
$result = getUser($_SESSION['hash'], $user->id);
if(isset($result) && isset($result[0])){
	$info = $result[0];
}else{
	$user = $result[1];
	$user->id = $id;
}
$deficits = getUserDeficits($_SESSION['hash'], $user->id);
$total =0;
?>
<h1>Deficits</h1>
<h3><?php echo "$user->firstName $user->lastName"; ?></h3>

<?php if(isset($deficits) && count($deficits) > 0){ ?>
<table border='1'>
	<tr><th>Purchase Date</th><th>Item Name</th><th>Cost</th><th>Remove</th></tr>
	<?php foreach($deficits as $d){
		$total += $d[3]; ?>
		<tr>
			<td><?php echo $d[1]; ?></td>
			<td><?php echo $d[2]; ?></td>
			<td><?php echo  "$".number_format($d[3], 2, '.', ''); ?></td>
			<td><input type='checkbox' name='removeDeficit' value='<?php echo $d[0]; ?>' onchange='this.form.submit()'/></td>	</tr>
	<?php } ?>
	<tr>
		<td></td>
		<td>Total</td>
		<td><?php echo  "$".number_format($total, 2, '.', ''); ?></td>
	</tr>
</table>
<?php }else{ echo "No deficits found</br>";} ?>

