<?php
$showContent = gateCheck(array('1','2','3','4','5'));
if($showContent){
	if(isset($_POST['update'])){
		$_POST['hash'] = $_SESSION['hash'];
		$_POST['type'] = 'update';
		$errors = updateUser($_POST);
		if(!empty($errors[0])){
			$info = $errors;
		}
		$userData = new userData();
		$userData->setFromArray($_POST);
		$serializedUser = serialize($userData);	
	}elseif(isset($_POST['updatePass'])){
		$_POST['hash'] = $_SESSION['hash'];
		$_POST['type'] = 'updatePass';
		$result = updatePassword($_POST);
		$errors = $result[0];
		if(!empty($errors)){
			$info = $errors;
		}	
		$userData = unserialize($_POST['userData']);
	}else{
		$userData;
		$data['type'] = 'hash';
		$data['hash'] = $_SESSION['hash'];
		$result = getUser($data);
		$errors = $result[0];
		$userData=$result[1];
		if(!empty($errors)){
			$info = $errors;
			$showContent = false;
		}
	$serializedUser = serialize($userData);
	}
}
?>
<div class='basicPanel'/>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if($showContent){ 
		if(isset($_POST['passChange'])){?>
			<form action='index.php' method='POST'>
				<label for='original'>Original Password</lable><input type='password' name='original'/></br>
				<label for='new'>New Password</lable><input type='password' name='new'/></br>
				<label for='conf'>Confirm Password</lable><input type='password' name='conf'/></br>
				<input type='submit' value='Update' name='updatePass'/>
				<input type='submit' value='Cancel' name='cancel'/>
				<input type-'hidden' name='userData' value='<?php echo $serializedUser ?>' hidden/>
			</form>
		<?php }else{ ?>
			<form action='index.php' method='POST'>
				<label for='email'>Email</label><input type='text' name='email' value='<?php echo $userData->email; ?>' disabled/></br>
				<label for='passChange'>Password<label/><input type='submit' value='Change Password' name='passChange'/></br>
				<label for='firstName'>First Name</label><input type='text' name='firstName' value='<?php echo $userData->firstName; ?>' /></br>
				<label for='middleName'>Middle Name</lable><input type='text' name='middleName' value='<?php echo $userData->middleName; ?>' /></br>
				<label for='lastName'>LastName</lable><input type='text' name='lastName' value='<?php echo $userData->lastName; ?>'/></br>
				<label for='dob'>D.O.B.</lable><input type='date' name='dob' value='<?php echo $userData->dob; ?>' readonly/></br>
				<label for='phone'>Phone #</lable><input type='text' name='phone' value='<?php echo $userData->phone; ?>'  /></br>
				<label for='pronouns'>Pronouns</lable><input type='text' name='pronouns' value='<?php echo $userData->pronouns; ?>'  /></br>
				<input type-'hidden' name='userData' value='<?php echo $serializedUser ?>' hidden/>
		<?php if(!isset($_POST['delete'])){ ?>
			<input type='submit' value='Back' name='back' />
			<input type='submit' value='Update' name='update' />
			<input type='submit' value='Delete' name='delete' />
		<?php } ?>
	</form>
<?php  }}?>
</div>
