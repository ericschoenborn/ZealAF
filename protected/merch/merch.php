<?php
require '../../assets/requestFunctions.php';

	function createMerch($hash, $data){
		$data->type = 'create';
		$data->hash = $hash;
		$response = sendPostRequest('http://34.138.189.81/zealaf/api/admin/merchApi.php', $data);
		$result = json_decode($response);
		return $result;
	}

	function deleteMerch($hash, $id){
		$data = array();
		$data['id'] = $id;
		$data['type'] = 'delete';
		$data['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/merchApi.php', $data);
		$result = json_decode($result);
		return $result;
	}

	function updateMerch($hash, $data){	
		$data->type = 'update';
		$data->hash = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/merchApi.php', $data);
		$result = json_decode($result);
		return $result;
	}

	function getMerch($hash, $id){
		$data = array();
		$data['id'] = $id;
		$data['type'] = 'getSingle';
		$data['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/merchApi.php', $data);
		$result = json_decode($result);
		return $result;
	}

	function getMerchandise($hash){
		$data = array();
		$data['type'] = 'getAll';
		$data['hash'] = $hash;
		$result = sendPostRequest('http://34.138.189.81/zealaf/api/admin/merchApi.php', $data);
		$result = json_decode($result);
		return $result;
	}
?>
