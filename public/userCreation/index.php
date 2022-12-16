<?php
require 'userCreation.php';
require_once('../../assets/userData.php');
session_start();
$userData = new UserData();
if(isset($_POST['create'])){
	$errors = createNewUser($_POST);
	$errors = json_decode($errors);
	if(!empty($errors)){
		$info = $errors;
		$userData->setFromArray($_POST);
	}else{
		header("Location: http://34.138.189.81/zealaf/index.php?info='User created. Contact admin to get your account activated.'");
		exit();
	}
}
?>
<html>
	<head>
		<title>New User</title>
		<style><?php include '../../assets/css/global.css'; ?></style>
	</head>
	<body>
		<?php include '../../assets/navigation.php'; ?>
		<h1>New User</h1>
		<div class='basicPanel'>
			<?php include '../../assets/showInfo.php'; ?>
			<form action='index.php' method="post">
				<label for='email'>Email</lable><input type='text' name='email' value='<?php echo $userData->email; ?>'/></br>
				<label for='password'>Password</lable><input type='password' name='password'/></br>
				<label for='comPass'>Confirm Password</lable><input type='password' name='comPass'/></br>
				<label for='firstName'>First Name</label><input type='text' name='firstName' value='<?php echo $userData->firstName; ?>' /></br>
				<label for='middleName'>Middle Name</lable><input type='text' name='middleName'  value='<?php echo $userData->middleName; ?>' /></br>
				<label for='lastName'>LastName</lable><input type='text' name='lastName'  value='<?php echo $userData->lastName; ?>' /></br>
				<label for='dob'>D.O.B.</lable><input type='date' name='dob'  value='<?php echo $userData->dob; ?>' /></br>
				<label for='phone'>Phone#</lable><input type='text' name='phone'  value='<?php echo $userData->phone; ?>' /></br>
				<label for='pronouns'>Pronouns</lable><input type='text' name='pronouns'  value='<?php echo $userData->pronouns; ?>'/></br>
				<input type='submit' value='Create' name='create'/>
			</form>
		</div>
	</body>
</html>
