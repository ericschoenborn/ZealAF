<?php
require_once(dirname(__DIR__).'/../mysql/requests.php');
require_once(dirname(__DIR__).'/../assets/merchData.php');
require_once(__DIR__.'/session.php');


function getDeficits($hash){
	$query = "select user_deficit.`name`, user_deficit.`cost`, user_deficit.`date` FROM user_deficit, sessions WHERE sessions.`session_hash` ='$hash' AND sessions.`user_id` =  user_deficit.`user_id`;";
	$result = getAll($query);
	if($result){
		$merch = array();
		foreach($result as $item){
			$merch[] = array($item['name'], $item['cost'], $item['date']);
		}
		return $merch;
	}
	return $query;
}
?>
