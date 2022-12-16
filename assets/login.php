<?php
require_once(__DIR__.'/requestFunctions.php');
require_once(__DIR__.'/emailer.php');

session_start();
$loginInfo;
if(isset($_POST['login'])){
	if(!isset($_SESSION['hash'])){
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/loginApi.php', $_POST);
		$result = json_decode($result);
		$loggedIn = $result[0];
		$sessionHash = $result[1];
		$accessTags = $result[2];
		$loginMessage="";
		if($loggedIn){
			$_SESSION['hash'] = $sessionHash;
			$_SESSION['tags'] = $accessTags;
			$_SESSION['time_stamp'] = time();
		}else{
			$loginMessage = "Login has failed.";
		}
		$edge = $_POST['location'];
		header("Location: $edge/?info=$loginMessage");
		exit();
	}else{
		$loginInfo = "Log in failed.";
	}
}elseif(isset($_POST['recoverPassword'])){
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/loginApi.php', $_POST);
	$result = json_decode($result);
	$error = $result[0];
	$hash = $result[1];
	$loginInfo = "";
	if(isset($result[0])){
		$loginInfo = $result[0];
	}else{
		$loginInfo = "Check your email for password reset instructions";
		if(isset($hash)){
			$loginInfo = sendPasswordRecovery($_POST['email'], $hash);
		}
	}
	$edge = $_POST['location'];
	header("Location: $edge/?info=$loginInfo");
	exit();
}
?>
<?php if(isset($_SESSION['time_stamp'])){ ?>
<form method='POST' action='/zealaf/public/myUser/'>
	<h3>You are currently logged in</h3>
    <input type='submit' value='My Account'/>
</form>
<?php }else{ ?>
<form method='POST' action='/zealaf/assets/login.php'>
	<?php if(isset($loginInfo)){ ?> <p><?php echo $loginInfo; ?></p><?php } ?>
	<label for='email'>Email</label><input type='text' name='email' id='email'/></br>
	<label for='password'>Password</label><input type='password' name='password' id='password'/></br>
	<input type='hidden' name='location' value='<?php echo $_SERVER['PHP_SELF']?>'/>
	<input type='submit' value='Log In' name='login' id='login'/></br>
	<input type='submit' value='Forgot Password' name='recoverPassword'/>
</form>
<form method='POST' action='/zealaf/public/userCreation'>
    <input type='submit' value='New User'/>
</form>
<?php } ?>
