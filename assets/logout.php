<?php
	session_start();
	session_unset();
	session_destroy();
	header('Location: /zealaf/index.php');
	exit();
?>

