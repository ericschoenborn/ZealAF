<?php
require_once(dirname(__DIR__).'/../mysql/requests.php');
require_once(dirname(__DIR__).'/../assets/merchData.php');
require_once(__DIR__.'/session.php');


function getMerch($id){
	$query = "select `id`, `name`, `description`, `cost`, `quantity`, `infinite` FROM merchandise WHERE `id` = $id;";
	$result = getSingle($query);
	if($result){	
		return array(null, $result);
	}else{
		return array("Merchandise not found.", null);
	}
}
function getMerchandise(){
	$query = "SELECT `id`, `name` FROM merchandise;";
	$result = getAll($query);
	if($result){
		$merch = array();
		foreach($result as $item){
			$merch[] = array($item['id'], $item['name']);
		}
		return $merch;
	}
	return array();
}
function merchToCart($data){
	$userIdResult = getUserIdBySessionHash($data['hash']);
	if(!isset($userIdResult[1])){
		return "Failed to add $wanted $merch->name(s) to your cart";
	}
	$userId = $userIdResult[1];

	$merch = new MerchData();
	$merch->setFromArray($data);
	$errors = $merch->validate();
	if(!empty($errors)){
		return array($errors);
	}
	$wanted = $data['wanted'];
	if($merch->infinite == 0){
		$quantity = "SELECT `quantity` FROM merchandise WHERE `name` = '$merch->name';";
		$found = getSingle($quantity);
		$found = $found['quantity'];
		$left = $found - $wanted;
		if($found - $wanted < 0){
			return array("Merchandise $merch->name is out of stock");
		}
		$query = "UPDATE merchandise SET `quantity`=$left WHERE `id`=$merch->id;";
		$result2 = update($query);
		if(!$result2){
			return "Failed to add $wanted $merch->name(s) to your cart";
		}
	}
	$query = "INSERT INTO user_cart (`user_id`, `name`, `cost`, `quantity`) VALUES ($userId, '$merch->name', $merch->cost, $wanted);";
	$id = create($query);
	if($id < 1){
		return "Failed to add $wanted $merch->name(s) to your cart";
	}
	return null;
}
function getCartItems($hash){
	$query = "SELECT user_cart.`id`, user_cart.`name`, user_cart.`cost`, user_cart.`quantity` FROM sessions, user_cart WHERE sessions.`session_hash` = '$hash' AND user_cart.`user_id` = sessions.`user_id`;";
	$result = getAll($query);
	if($result){
		$merch = array();
		foreach($result as $item){
			$merch[] = array($item['id'],$item['name'], $item['cost'], $item['quantity']);
		}
		return $merch;
	}
	return array();
}
function decromentCartItem($id){
	$quantity = "SELECT merchandise.`infinite` FROM merchandise, user_cart WHERE user_cart.`id` = $id AND merchandise.`name` = user_cart.`name`;";
	$count = getSingle($quantity);
	$infinite = $count['infinite'];
	$query = "";
	if($infinite == 0){
		$query = "UPDATE user_cart, merchandise SET user_cart.`quantity`=user_cart.`quantity`-1, merchandise.`quantity` = merchandise.`quantity`+1 WHERE user_cart.`id`=$id AND merchandise.`name` = user_cart.`name`;";	
	}else{
		$query = "UPDATE user_cart SET `quantity`=`quantity`-1 WHERE `id`=$id;";
	}
	$result = update($query);
	if(!$result){
		return "Failed to update cart";
	}	

}
function incromentCartItem($id){
	$quantity = "SELECT merchandise.`quantity`, merchandise.`infinite` FROM merchandise, user_cart WHERE user_cart.`id` = $id AND merchandise.`name` = user_cart.`name`;";
	$count = getSingle($quantity);
	$avalible = $count['quantity'];
	$infinite = $count['infinite'];
	$query = "";
	if($infinite == 0){
		if($avalible -1 < 0){
			return "No more inventory";
		}
	
		$query = "UPDATE user_cart, merchandise SET user_cart.`quantity`=user_cart.`quantity`+1, merchandise.`quantity` = merchandise.`quantity`-1 WHERE user_cart.`id`=$id AND merchandise.`name` = user_cart.`name`;";
	}else{
		$query = "UPDATE user_cart SET `quantity`=`quantity`+1 WHERE `id`=$id;";
	}
	$result = update($query);
	if(!$result){
		return "Failed to update cart";
	}
}
function payWithDeficit($hash, $ids){
	if(!isset($ids) || count($ids) <1){
		return null;
	}
	$userIdResult = getUserIdBySessionHash($hash);
	if(!isset($userIdResult[1])){
		return "Failed to purchase";
	}
	$userId = $userIdResult[1];
	$idString="";
	if(isset($ids)){
		if(gettype($ids) != "array"){
			$idString = "$ids";
		}else{
			foreach($ids as $id){
				if(strlen($idString) > 0){
					$idString .= ",";
				}
				$idString .="$id";
			}
		}
	}
	$retrive = "SELECT `name`, `cost`, `quantity` FROM user_cart WHERE `id` IN ($idString);";
	$items = getAll($retrive);
	if(!$items){
		return "Failed to purchase";
	}
	$insert="INSERT INTO user_deficit (`user_id`, `name`, `cost`, `date`) VALUES";
	foreach($items as $i){
		$count = $i['quantity'];
		while($count > 0){
			$name = $i['name'];
			$cost = $i['cost'];
			$insert.="($userId, '$name', $cost, curdate())";
			$count--;
			$insert.=",";
		}
	}
	$insert = substr($insert, 0, -1);
	$insert.=";";
	$transaction = getTransactionStart();
	$remove = "DELETE FROM user_cart WHERE `user_id` = $userId;";
	$removeResult = updateWithTransaction($transaction, $remove);
	if($removeResult[0] > 0 && !isset($removeResult[1])){
		$insertResult = createWithTransaction($transaction, $insert);
		if($insertResult[0]<1 || isset($insertResult[1])){
			rollBack($transaction);
			return $insert;//"Failed to craete schedule leaders.";
		}
	}else{
		rollBack($transaction);
		return "Failed to purchase";
	}
	commit($transaction);
	return null;
}
function payWithCredit($hash, $ids){
	return "not implimented";
}
?>
