<?php
require '../../assets/requestFunctions.php';

function payWithDeficit($hash, $ids){
	$data = array();
	$data['ids'] = $ids;
	$data['type'] = 'payWithDeficit';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function payWithCredit($hash, $ids){
	$data = array();
	$data['ids'] = $ids;
	$data['type'] = 'payWithCredit';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function merchToCart($hash, $data, $wanted){
	$data->type = 'merchToCart';
	$data->hash = $hash;
	$data->wanted = $wanted;
	$response = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($response);
	return $result;
}
function getMerch($id){
	$data = array();
	$data['id'] = $id;
	$data['type'] = 'getSingle';
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getMerchandise(){
	$data = array();
	$data['type'] = 'getAll';
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function getCartItems($hash){
	$data = array();
	$data['type'] = 'getCartItems';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function decromentCartItem($hash, $id){
	$data = array();
	$data['id'] = $id;
	$data['type'] = 'decromentCartItem';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
function incromentCartItem($hash, $id){
	$data = array();
	$data['id'] = $id;
	$data['type'] = 'incromentCartItem';
	$data['hash'] = $hash;
	$result = sendPostRequest('http://34.138.189.81/zealaf/api/merchApi.php', $data);
	$result = json_decode($result);
	return $result;
}
?>
