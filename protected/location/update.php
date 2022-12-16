<?php
require_once('../../assets/gateKeeper.php');
$showContent = gateCheck(array('4','5'));
if(!$showContent){
	header("Location: ../../?info=you have been logged out");
	exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
$id = 0;
$showUpdateSpaces = false;
$showSureDelete = false;
$location;
$locationSpaces = array();
$spaces = array();
if(isset($_POST['sureDelete'])){
	$name = $_POST['name'];
	$info ="Location $name Deleted";
	$error = deleteLocation($_SESSION['hash'], $_POST['id']);
	if(isset($error)){
		$info = $error;
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}
if(isset($_POST['back'])){
	header("Location: ./");
	exit();
}elseif(isset($_POST['addSpace'])){
	$location = (object) array('name' => $_POST['name'], 'address'=>$_POST['address'],'description' => $_POST['description']);
	$locationSpaces = unserialize($_POST['lSpaces']);
	$spaces = unserialize($_POST['spaces']);
	$spaceName = $_POST['addSpace'];
	[$locationSpaces, $spaces] = adjustSpaces($locationSpaces, $spaces, $spaceName);
	$serialLocationSpaces = serialize($locationSpaces);
	$serialSpaces = serialize($spaces);
	$id=$_POST['id'];
}elseif(isset($_POST['removeSpace'])){
	$location = (object) array('name' => $_POST['name'], 'address'=>$_POST['address'],'description' => $_POST['description']);

	$locationSpaces = unserialize($_POST['lSpaces']);
	$spaces = unserialize($_POST['spaces']);
	$spaceName = $_POST['removeSpace'];
	[$spaces, $locationSpaces] = adjustSpaces($spaces, $locationSpaces, $spaceName);
	$serialLocationSpaces = serialize($locationSpaces);
	$serialSpaces = serialize($spaces);
	$id = $_POST['id'];
}elseif(isset($_POST['update'])){
	$name = $_POST['name'];
	$info ="Location $name Updated";
	$locationSpaces = unserialize($_POST['lSpaces']);
	$spaces = unserialize($_POST['spaces']);
	$error = updateLocation($_SESSION['hash'], $_POST, $locationSpaces);
	if(isset($error)){
		$info = $error;
		$location = (object) array('name' => $_POST['name'], 'address'=>$_POST['address'],'description' => $_POST['description']);
		$id=$_POST['id'];
		$serialLocationSpaces = serialize($locationSpaces);
		$serialSpaces = serialize($spaces);
	}else{
		header("Location: ./index.php?info=$info");
		exit();
	}
}elseif(isset($_POST['delete'])){
	$showSureDelete = true;
	$id = $_POST['id'];
	$name = $_POST['name'];
}else{
	if(!isset($_GET['location'])){
		header("Location: ./");
		exit();
	}
	$id = $_GET['location'];
	$result = getLocation($_SESSION['hash'], $id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$location = $result[1];
	}
	$locationSpaces = getSpacesForLocation($_SESSION['hash'], $id);
	 
	$spaces = getSpaces($_SESSION['hash']);
	[$spaces, $locationSpaces] = removeUsedSpaces($spaces, $locationSpaces);
	$serialLocationSpaces = serialize($locationSpaces);
	$serialSpaces = serialize($spaces);
}
?>
<h1>Update</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if($showSureDelete){ ?>
		<form method='POST' action=''>
			<h1>Are You Sure?</h1>
			<input type='text' value='<?php echo $id ?>' name='id' hidden/>
			<input type='text' name='name' value='<?php echo $name; ?>' hidden/>
			<input type='submit' value='No' name='no'/>
			<input type='submit' value='Yes, Delete' name='sureDelete'/>
		</form>
	<?php }else{ ?>

	<?php if(isset($location) && !$showUpdateSpaces){?>
		<form method='POST' action=''>
			<input type='text' value='<?php echo $id; ?>' name='id' hidden/>
			<label for='name'>Name: </label><input type='text' value='<?php echo $location->name; ?>' name='name'/></br>
			<label for='name'>Address: </label><input type='text' value='<?php echo $location->address; ?>' name='address'/></br>
			<label for='description'>Description: </label><input type='text' value='<?php echo $location->description; ?>' name='description'/></br>
			<p>Current Spaces</p>
			<?php foreach($locationSpaces as $lspace){ 
					$spaceName = $lspace[1];?>
					<input type='submit' value='<?php echo $spaceName;?>' name='removeSpace'/><br/>
			<?php } ?>
			<p>Availible Spaces</p>
				<?php foreach($spaces as $space){ 
				$spaceName = $space[1];?>
				<input type='submit' value='<?php echo $spaceName;?>' name='addSpace'/><br/>
			<?php } ?>
			</br>
			<input type='submit' value='Back' name='back' />
			<input type='submit' value='Update' name='update' />
			<input type='submit' value='Delete' name='delete' />
			<input type='text' name='lSpaces' value='<?php echo $serialLocationSpaces;?>' hidden/>
			<input type='text' name='spaces' value='<?php echo $serialSpaces;?>' hidden/>
		</form>
	<?php }else{ ?>
		<p>Location not found.</p>
	<?php }?>

<?php	} ?>
</form>
</div>
