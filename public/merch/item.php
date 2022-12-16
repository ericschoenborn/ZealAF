<?php
require_once('../../assets/gateKeeper.php');

$showSureDelete = false;
$merch = new MerchData();
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['toCart']) && isset($_SESSION['hash'])){
	$merch->setFromArray($_POST);
	$wanted = $_POST['wanted'];
	$name = $_POST['name'];
	$info="$wanted $name(s) added to your cart";
	$error = merchToCart($_SESSION['hash'], $merch, $wanted);
	if(isset($error)){
		$info = $error;
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
	$result = getMerch($id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$merch = $result[1];
	}
}
?>
<h1>Item Description</h1>
<div class='basicPanel'>
	<form method='POST' action=''>
<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($merch)){ ?>
		<input type='text' name='id' value='<?php echo $merch->id; ?>' hidden/>
		<input type='text' name='name' value='<?php echo $merch->name ?>' hidden/>
		<input type='text' name='description' value='<?php echo $merch->description ?>' hidden/>
		<input type='number' name='cost' value='<?php echo $merch->cost ?>' hidden/>
		<input type='number' name='quantity' value='<?php echo $merch->quantity ?>' hidden/>
		<input type='number' name='infinite' value='<?php echo $merch->infinite ?>' hidden/>

		<label for='name'>Name: </label><span name='name'><?php echo $merch->name ?></span></br>
		<label for='description'>Description: </label></br><span name='description'><?php echo $merch->description ?></span></br>
		<label for='cost'>Cost: </label><span name='cost'>$<?php echo $merch->cost ?></span></br>
		<label for='quantity'>Quantity: </label>
			<span>
				<?php if($merch->infinite == 0){
					echo $merch->quantity;
				}else{
					echo "Infinite";
				}?>
			</span></br>
		<?php $showContent = gateCheck(array('1','2','3','4','5'));
		if($showContent){?>
			<input type='number' name='wanted' value='1' min='1' max='<?php if($merch->infinite ==0){echo $merch->quantity; }else{ echo "100"; }?>' step='1'/>

			<input type='submit' value='Add To Cart' name='toCart' />
		<?php } ?>
	<?php }else{ ?>
		<p>Merchandise not found.</p>
	<?php }?>
		</br><input type='submit' value='Back' name='back' />
	</form>
</div>
