<?php
function sendPasswordRecovery($email, $hash){
	$subject = "Password Reset";
	$message = "Your Zeal account has had a password reset request.\r\n";
	$message.= "If you did not request this please contact zeal.\r\n";
	$message.="http://34.138.189.81/zealaf/myUser/passwordReset.php/?email=$email&hash=$hash";
	return sendEmail($email, $subject, $message);
}
function sendEmail($email, $subject, $message){
	return mail($email, $subject, $message,"From: schoeric@gvsu.edu");
}
?>

