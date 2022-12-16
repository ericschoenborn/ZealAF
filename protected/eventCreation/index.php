<?php
//      public $name;
//      public $description;
//      public $cost;
//      public $requirement;
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../assets/eventData.php');
	require_once('./eventCreation.php');
 session_start();
	$eventData = new EventData();
	$reqCount = 0;
	$showPunchCost = false;
	$showPassCost = false;
	$showStaffCost = false;
	if(isset($_POST['create'])){
		$_POST['type'] = 'create';
		$_POST['hash'] = $_SESSION['hash'];
		echo createEvent($_POST);
	}else{
		if(isset($_POST['reqCount'])){
			$reqCount = $_POST['reqCount'];
		}
		if(isset($_POST['showPunchCost'])){
			$showPunchCost = true;
		}
		if(isset($_POST['removePunchCost'])){
			$showPunchCost = false;
		}
		if(isset($_POST['showPassCost'])){
			$showPassCost = true;
		}
		if(isset($_POST['removePassCost'])){
			$showPassCost = false;
		}
		if(isset($_POST['showStaffCost'])){
			$showStaffCost = true;
		}
		if(isset($_POST['removeStaffCost'])){
			$showStaffCost = false;
		}


        	if(isset($_POST['create'])){
                	$errors = createNewUser($_POST);
                	echo $errors;
                	echo gettype($errors);
                	$errors = json_decode($errors);
                	if(!empty($errors)){
                        	foreach($errors as &$error){
                                	echo $error;
                        	}
                        	$eventData->setFromArray($_POST);
                	}
		}elseif(isset($_POST['req'])){
			if($reqCount < 15){
				$reqCount = $reqCount +1;
			}
		}elseif(isset($_POST['decReq'])){
			if($reqCount > 0){
				$reqCount = $reqCount -1;
			}
		}
	}
?>
<html>
	<head>
		<title>New Event</title>
	</head>
	<body>
<?php include '../../assets/protectedNavigation.php'; ?>
				<h1>New Event</h1>
<form action='index.php' method="post">
                        <label for='name'>Name</label><input type='text' name='name' value='<?php echo $eventData->eName; ?>'/></br>
                        <label for='description'>Description</label><input type='text' name='description' value='<?php echo $eventData->eDescription; ?>' /></br>
			<label for='cost'>Cost</label><input type='text' name='cost'  value='<?php echo $eventData->cost; ?>' /></br>
			<?php if($showPunchCost){ ?>
				<label for='Punch Cost'>Punch Cost</label><input type='number' min='1' max='10' step='1' name='punchCoast'/><input type='submit' value='Remove Punch Cost' name='removePunchCost'/></br>
				<input type='text' value='keep' name='showPunchCost' hidden/>
			<?php }else{ ?>
				<input type='submit' value='Add Punch Cost' name='showPunchCost'/></br>
			<?php } ?>
			<?php if($showPassCost){ ?>
				<label for='Pass Cost'>Class Pass Cost</label><input type='number' min='0' max='9999' step='.01' name='passCost'/><input type='submit' value='Remove Class Pass Cost' name='removePassCost'/></br>
				<input type='text' value='keep' name='showPassCost' hidden/>
			<?php }else{ ?>
				<input type='submit' value='Add Class Pass Cost' name='showPassCost'/></br>
			<?php } ?>
			<?php if($showStaffCost){ ?>
				<label for='Staff Cost'>Staff Costs</label><input type='number' min='0' max='9999' step='.01'/><input type='submit' value='Remove Staff Cost' name='removeStaffCost'/></br>
				<input type='text' value='keep' name='showStaffCost' hidden/>
			<?php }else{ ?>
				<input type='submit' value='Add Staff Cost' name='showStaffCost'/></br>
			<?php } ?>

			<label for='req'>Requirements</label><input type='submit' value='+' name='req'/><input type='submit' name='decReq' value='-'></br>
			<?php
       				$reps = 0;
				while($reps < $reqCount){
					$reps = $reps +1;
					echo "<label for='req$reps'>Requirement $reps</label><input type='text' name='req$reps'/></br>";
				}
				echo "<input type='number' name='reqCount' value='$reqCount' hidden/></br>";
			?>

			<input type='submit' value='Create' name='create'/>
                </form>
	</body>
</html>

