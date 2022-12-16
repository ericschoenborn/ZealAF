<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__.'/user.php');
require_once(__DIR__.'/accessTag.php');
require_once(__DIR__.'/session.php');
function recoverPassword($email){
	$emailExists = emailExists($email);
	if($emailExists){
		$hash = createRecoverySession($email);
		return $hash;
	}
	return null;
}
function loginUser($loginInfo){
	$loggedin = false;
	$sessionHash = "";
	$accessTags = array();
$email = $loginInfo['email'];
	$password = $loginInfo['password'];
	if(!empty($email) && !empty($password)){
		$userId = getUserID($email, $password);
		
		if($userId > 0){
			$accessTags = getAccessTagsForUser($userId);
			if(empty($accessTags)){
				$sessionHash = "Account fault. Please contact admin.";
			}else{
			$sessionHash = createSession($userId, $email, $password);
				$loggedin = !empty($sessionHash);
			}
		}else{
			return array($loggedin, "Incorrect email or password", $accessTags);
		}
	}
	return array($loggedin, $sessionHash, $accessTags);
}
?>
