<?php
	require '../../assets/requestFunctions.php';
	function createEvent($eventInfo){
		$response = sendPostRequest('http://34.138.189.81/zealaf/api/eventApi.php', $eventInfo);
		return $response;
	}

?>
