<?php
function sendPostRequest($location, $userData){
	$postData = http_build_query($userData);
	$request = array('http' =>
		array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postData
		)
	);
	$context = stream_context_create($request);
	$result = file_get_contents($location, false, $context);
	return $result;
}
?>
