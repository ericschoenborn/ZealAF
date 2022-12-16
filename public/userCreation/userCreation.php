<?php
	require '../../assets/requestFunctions.php';
	function createNewUser($userInfo){
		$response = sendPostRequest('http://34.138.189.81/zealaf/api/userApi.php', $userInfo);
		return $response;
	}
?>
