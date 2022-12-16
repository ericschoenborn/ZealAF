<?php
	require_once(__DIR__.'/accessTag.php');
	require_once(__DIR__.'/session.php');

function grantAccess($hash, $requirements){
		$result = getUserIdBySessionHash($hash);
		$error = $result[0];
		if(!empty($error)){
			return $error;
		}
		$id = $result[1];
		return validateUserById($id, $requirements);
	}

?>
