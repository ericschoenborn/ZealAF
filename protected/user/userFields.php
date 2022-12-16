<?php
$user = new UserData();
$showSureDelete = false;
$user->setFromArray($_POST);
$originalEmail = "";
$accessTags;
if(isset($_POST['accessOptions'])){
	$accessTags = unserialize($_POST['accessOptions']);
}else{
	$accessTags = getAccessTags($_SESSION['hash']);
}
if(isset($_POST['currentTags'])){
	$tags = array();
	foreach($_POST['currentTags'] as $serial){
		$tags[]= unserialize($serial);
	}
	$user->accessTags = $tags;
}
if(isset($_POST['originalEmail'])){
	$originalEmail = $_POST['originalEmail'];
}
if(isset($_POST['deleteTag'])){
	$f = $_POST['deleteTag'];
	foreach($user->accessTags as $key=>$at){
		if($_POST['deleteTag'] == $at[0]){
			unset($user->accessTags[$key]);
			$accessTags[]=$at;
		}
	}
}elseif(isset($_POST['accessTag']) && $_POST['accessTag'] != ""){
	$user->accessTags[] = unserialize($_POST['accessTag']);
}elseif(isset($_POST['delete'])){
	$showSureDelete = true;
	$id = $_POST['id'];
}elseif(isset($_POST['sureDelete'])){
	$fullName = $_POST['fullName'];
	$info ="User $fullName Deleted";
	$error = deleteUser($_SESSION['hash'], $_POST['id']);
	if(!isset($error)){
		header("Location: ./index.php?info=$info");
		exit();
	}
	$info = $error;
	$result = getUser($_SESSION['hash'], $user->id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$user = $result[1];
		$user->id = $id;
		$originalEmail = $user->email;
	}
}elseif(isset($_POST['update'])){
	$error = updateUser($_SESSION['hash'], $_POST, $originalEmail);
	if(isset($error)){
		$info = $error;
	}else{
		header("Location: ./index.php?info=User $user->firstName $user->lastName updated");
		exit();
	}
}else{
	if(!isset($user->id)){
		if(isset($_GET['user'])){
			$user->id = $_GET['user'];
		}else{
			header("Location: ./index.php?info='Faild to find user'");
			exit();
		}
	}	
	$result = getUser($_SESSION['hash'], $user->id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$user = $result[1];
		$user->id = $id;
		$originalEmail = $user->email;
	}	
}


if(isset($user->accessTags)){
	foreach($accessTags as $key=>$at){
		if(in_array($at,$user->accessTags)){
			unset($accessTags[$key]);
		}
	}
}
?>
<?php include '../../assets/showInfo.php'; ?>
<?php
if($showSureDelete){
?>
	<form method='POST' action=''>
	<h1>Are You Sure?</h1>
	<input type='text' name='id' value='<?php echo $user->id; ?>' hidden />
	<input type='text' name='fullName' value='<?php echo "$user->lastName, $user->firstName : $user->email"; ?>' hidden/>
	<input type='submit' value='No' name='no'/>
	<input type='submit' value='Yes, Delete' name='sureDelete'/>
	</form>
<?php }else{ ?>
	<?php if(isset($user)){?>
	<h1>UserData</h1>
	<form action='index.php' method="post">
		<label for='email'>Email</lable><input type='text' name='email' value='<?php echo $user->email; ?>'/></br>
		<input type='text' name='originalEmail' value='<?php echo $originalEmail ?>' hidden/>
		<label for='firstName'>First Name</label><input type='text' name='firstName' value='<?php echo $user->firstName; ?>' /></br>
		<label for='middleName'>Middle Name</lable><input type='text' name='middleName'  value='<?php echo $user->middleName; ?>' /></br>
		<label for='lastName'>LastName</lable><input type='text' name='lastName'  value='<?php echo $user->lastName; ?>' /></br>
		<label for='dob'>D.O.B.</lable><input type='date' name='dob'  value='<?php echo $user->dob; ?>' /></br>
		<label for='phone'>Phone #</lable><input type='text' name='phone'  value='<?php echo $user->phone; ?>' /></br>
		<label for='pronouns'>Pronouns</lable><input type='text' name='pronouns'  value='<?php echo $user->pronouns; ?>'/></br>
		<label>Access Tags</label></br>
		<?php if(isset($user->accessTags) && count($user->accessTags) >0){ ?>
			<table border='1'>
				<tr><th>Name</th><th>Remove</th></tr>
				<?php foreach($user->accessTags as $at){?>
		 		<tr>
					<td><input type='text' value='<?php echo serialize($at); ?>' name='currentTags[]' hidden/><?php echo $at[1]; ?></td><td><input type='checkbox' name='deleteTag' value='<?php echo $at[0]; ?>' onchange='this.form.submit()'/></td><tr>
				<?php } ?>
		<?php }else{ ?>
			<p>None Found</p>
		<?php } ?>
		</table>
		<?php if(isset($accessTags) && count($accessTags) >0){ ?>
			<label for='accessTag'>Add Access Tag</label>
			<select name='accessTag' onchange='this.form.submit()'>
				<option style='display:none;'></option>
				<?php foreach($accessTags as $at){?>
					<option value='<?php echo serialize($at);?>'><?php echo $at[1]; ?></option>
				<?php } ?>
		<?php } ?>
		<input type='text' name='accessOptions' value='<?php echo serialize($accessTags) ?>' hidden/>
		</br>
	</form>
<?php }} ?>

