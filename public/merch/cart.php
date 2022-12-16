<?php
$showContent = gateCheck(array('1','2','3','4','5'));
if(!$showContent){
	header("Location: ./");
	exit();
}
$info;
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['deficitePay'])){
	$cartIds = unserialize($_POST['cartIds']);
	$result = payWithDeficit($_SESSION['hash'], $cartIds);
	if(!isset($result)){
		header("Location: ./?info=Items scuccessfully purchased");
		exit();
	}
	$info = $result;
}elseif(isset($_POST['creditPay'])){
	$cartIds = unserialize($_POST['cartIds']);
	$result = payWithCredit($_SESSION['hash'], $cartIds);
	$info = $result;
}elseif(isset($_POST['decItem'])){
	$id = $_POST['decItem'];
	$result = decromentCartItem($_SESSION['hash'], $id);
}elseif(isset($_POST['incItem'])){
	$id = $_POST['incItem'];
	$result = incromentCartItem($_SESSION['hash'], $id);
}
$cartItems = getCartItems($_SESSION['hash']);
$total =0;
$cartIds = array();
if(isset($cartItems) && count($cartItems) >0){
	foreach($cartItems as $ci){
		$cartIds[]=$ci[0];
		$amount = $ci[2] * $ci[3];
		$total += $amount;
	}
}
?>
<h1>Cart</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<form method='POST' action=''>
	<?php if(isset($cartItems) && count($cartItems) >0){ ?>
		<input type='text' name='cartIds' value='<?php echo serialize($cartIds); ?>' hidden/>
		<table border='1'>
			<tr><th>Name</th><th>Quantity</th><th>Cost</th></tr>	
			<?php foreach($cartItems as $ci){ ?>
			<tr>
				<td><?php echo $ci[1]; ?></td>
				<td>
				<input type='checkbox' name='decItem' value='<?php echo $ci[0]; ?>' <?php if($ci[3] < 1 ){ echo "disabled"; }else{ echo "onchange='this.form.submit()'"; } ?>/><?php echo $ci[3]; ?><input type='checkbox' name='incItem' value='<?php echo $ci[0]; ?>' onchange='this.form.submit()'/></td>
			<td><?php $amount = number_format(($ci[2] * $ci[3]), 2, '.', ''); echo "$$amount"; ?></td>
			</tr>
			<?php } ?>
			<tr><td></td><td>Total</td><td><?php echo "$".number_format($total, 2, '.', ''); ?></td></tr>
		</table>
		</br>
		<input type='submit' value='Pay at Zeal' name='deficitePay' /></br>
		<input type='submit' value='Pay with credit' name='creditPay' /></br>
	<?php }else{ ?>
		<p>No items in cart</p>
	<?php } ?>
	<input type='submit' value='Back' name='back' />
	</form>
</div>

