<?php
require_once('../../mysql/requests.php');
require_once('../../assets/userData.php');
require_once('./functions/accessTag.php');

function updateScheduleLeaders($leaders, $id){
	$query = "DELETE FROM schedule_leaders WHERE `scheduled_id` = $id;";
	$result = update($query);

	if(isset($leaders) && count($leaders) >0){
		$values = "";
		foreach($leaders as $l){
			if(strlen($values)>0){
				$values .= ",";
			}
			$leaderId = $l['id'];
			$values .= "('$id','$leaderId')";
		}
		$query = "INSERT INTO schedule_leaders(`scheduled_id`,`member_id`) VALUES $values;";
		$lastId = create($query);
		if($lastId<1){
			return "update schedule leaders error";
		}	
	}
	return null;
}

function getLeadersForSchedule($id){
	$query="SELECT members.`id`, members.`first_name`, members.`last_name`, members.`email` FROM members, schedule_leaders WHERE members.`id` = schedule_leaders.`member_id` AND schedule_leaders.`scheduled_id` = '$id'";	
	$result = getAll($query);
	if($result){
		$users = array();
		foreach($result as $item){
			$users[] = array($item['id'], $item['first_name'], $item['last_name'], $item['email']);
		}
		return $users;
	}
	return array();
}

function getLeaders(){
	$query="SELECT DISTINCT members.`id`, members.`first_name`, members.`last_name`, members.`email` FROM members, user_access WHERE members.`id` = user_access.`user_id` AND user_access.`access_id` IN (3,4,5);";
	$result = getAll($query);
	if($result){
		$users = array();
		foreach($result as $item){
			$users[] = array($item['id'], $item['first_name'], $item['last_name'], $item['email']);
		}
		return $users;
	}
	return array();
}

function getUsers(){
	$query="SELECT `id`, `first_name`, `last_name`, `email` FROM members";
	$result = getAll($query);
	if($result){
		$users = array();
		foreach($result as $item){
			$users[] = array($item['id'], $item['first_name'], $item['last_name'], $item['email']);
		}
		return $users;
	}
	return array();
}
function updateUser($data){
	$user = new UserData();
	$user->setFromArray($data);
	$errors = $user->validate();
	if(!empty($errors)){
		return array($errors, null);
	}
	['id'=>$id,'email'=>$email, 'originalEmail'=>$originalEmail,'firstName' => $first, 'middleName' => $middle, 'lastName' => $last, 'phone' => $phone, 'pronouns' => $pronouns] = $data;
	if($email != $originalEmail){
		$emailQuery ="select count(*) from members Where `email` = '$email';";
		$found = getCount($emailQuery);
		if($found > 0){
			return array("Email '$email' is already registered.", null);
		}

	}
	$query = "UPDATE members SET `first_name`='$first',`middle_name`='$middle', `last_name`='$last', `email`='$email', `phone`='$phone', `pronouns`='$pronouns' WHERE `id`=$id;";
	$result2 = update($query);
	if($result2){
		return array(null,null);
	}
	return array("No change detected.", null);
}

function getUser($id){
	$query = "select `email`, `first_name` as 'firstName', `middle_name` as 'middleName', `last_name` as 'lastName', `dob`, `phone`, `pronouns` FROM members WHERE `id` = $id;";
	$result = getSingle($query);
	if($result){
		$user = new UserData();
		$user->setFromArray($result);
		$accessTags= getAccessTagNamesForUser($id);
		$user->accessTags = $accessTags;	
		return array(null, $user);
	}else{
		return array("user not found.", null);
	}
	return $result;
}
function deleteUser($id){
	$getDeficits = "SELECT count(*) FROM user_deficit WHERE `user_id` = $id;";
	$found = getCount($getDeficits);
	if($found > 0){
		return "Please remove users deficits before deleting";
	}
	$transaction = getTransactionStart();
	$removeAsLeader = "DELETE FROM schedule_leaders WHERE `member_id` = $id;";
	$RLResult = updateWithTransaction($transaction, $removeAsLeader);
	if(isset($RLResult[1])){
		rollBack($transaction);
		return "Failed to remove as leader";
	}
	$removeAsParticipant = "DELETE FROM schedule_participants WHERE `member_id` = $id;";
	$RPResult = updateWithTransaction($transaction, $removeAsParticipant);
	if(isset($RPResult[1])){
		rollBack($transaction);
		return "Failed to remove as leader";
	}
	$removeCart = "DELETE FROM car WHERE `user_id` = $id;";
	$RCResult = updateWithTransaction($transaction, $removeCart);
	if(isset($RLResult[1])){
		rollBack($transaction);
		return "Failed to remove as leader";
	}
	$removeAccess = "DELETE FROM user_access WHERE `user_id` = $id;";
	$RAResult = updateWithTransaction($transaction, $removeAccess);
	if(isset($RAResult[1])){
		rollBack($transaction);
		return "Failed to remove as leader";
	}
	$query = "DELETE FROM members WHERE `id` = $id;";
	$result = updateWithTransaction($transaction, $query);
	if(!isset($result[1])){	
		commit($transaction);
		return null;
	}else{
		rollBack($transaction);
		return array("Failed to delete User");
	}
}
?>
