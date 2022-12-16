<?php
	$users;
	if(isset($_POST['user'])){
		$id = $_POST['id'];
		header("Location: ./index.php?type=update&user=$id");
		exit();
	}else{
		$response = getUsers($_SESSION['hash']);
		foreach($response as $r){
			$u = new UserData();
			$u->id = $r[0];
			$u->firstName = $r[1];
			$u->lastName = $r[2];
			$u->email = $r[3];
			$users[]=$u;
		}
		usort($users, "cmp");	
	}
	function cmp($a, $b){
		return strcmp($a->lastName, $b->lastName);
	}
?>
<h1>Users</h1>
<div class='basicPanel'>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($users)&&count($users)>0){
		foreach($users as $user){ ?>
			<form method='POST' action=''>
				<input type='text' value='<?php echo $user->id; ?>' name='id' hidden/>
				<input type='submit' value='<?php echo "$user->lastName, $user->firstName : $user->email"; ?>' name='user'/>
			</form>
	<?php }}else{ ?>
		<p>No events found.</p>
	<?php }?>
</div>
