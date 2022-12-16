<?php
function getAll($query){
	$result = array();
	try{
		$pdo = getConnection();
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$result[] = $row;
		}
	}catch(PDOException $pe){
		die("Could not connect to the database");
	}
	return $result;
}

function getSingle($query){
	$result;
	try{
		$pdo = getConnection();
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $pe){
		die("Could not connect to the database");
	}
	return $result;
}
function getCount($query){
	try{
		$pdo = getConnection();
		$result = $pdo->query($query)->fetchColumn();
			return $result;
	}catch(PDOException $pe){
		return "Failed to find compairible";
	}
}
function create($query){
	try{
		$pdo = getConnection();
		$pdo->exec($query);
		return $pdo->lastInsertId();	
	}catch(PDOException $pe){
		return "Date store failed on create";
	}
}
function getTransactionStart(){
	$pdo = getConnection();
	$pdo->beginTransaction();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
}
function rollBack($pdo){
	$pdo->rollBack();
}
function commit($pdo){
	$pdo->commit();
}
function createWithTransaction($pdoTransaction, $query){
	try{
		$pdoTransaction->exec($query);
		return array($pdoTransaction->lastInsertId(), null);	
	}catch(PDOException $pe){
		return array(null,"Data store failed on create::$pe");
	}
}
function updateWithTransaction($pdoTransaction, $query){
	try{
		$pdoTransaction->exec($query);
		return array(1, null);
	}catch(PDOException $pe){
		return array(null,"Data store failed on create::$pe");
	}
}
function update($query){
	$pdo = getConnection();
	$req = $pdo->prepare($query);
	$req->execute();
	return $req->rowCount();
}
function deletes($query, $id){
	$sql = "DELETE FROM spaces WHERE `id`=?";
	$stmt= $pdo->prepare($sql);
	$stmt->execute([2]);
	return 1;
}
function getConnection(){
	$servername = '???????';
	$username = '???????';
	$password = '???????';
	$dbname = '???????';
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	return $pdo;
	}
?>
