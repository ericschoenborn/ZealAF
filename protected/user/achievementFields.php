<?php
$user = new UserData(); 
$achievements = array();
$userAchievements =array();

if(isset($_GET['user'])){
	$user->id = $_GET['user'];
}else{
//	header("Location: ./index.php?info='faild to find user'");
//	exit();
}
if(isset($_POST['achievement']) && $_POST['achievement'] != ""){
	$user->firstName = $_POST['firstName'];
	$user->lastName = $_POST['lastName'];
	$achievements = unserialize($_POST['achievements']);
	$userAchievements = unserialize($_POST['userAchievements']);
	$achievement = unserialize($_POST['achievement']);
	foreach($achievements as $key=>$a){
		if($a[0] == $achievement[0]){
			unset($achievements[$key]);
		}
	}
	$userAchievements[] = $achievement;
}elseif(isset($_POST['removeAchievement'])){
	$user->id = $_POST['id'];
	$user->firstName = $_POST['firstName'];
	$user->lastName = $_POST['lastName'];
	$achievements = unserialize($_POST['achievements']);
	$userAchievements = unserialize($_POST['userAchievements']);
	$achievement = unserialize($_POST['removeAchievement']);
	foreach($userAchievements as $key=>$a){
		if($a[0] == $achievement[0]){
			unset($userAchievements[$key]);
		}
	}
	$achievements[] = $achievement;

}elseif(isset($_POST['update'])){
	$userAchievements = unserialize($_POST['userAchievements']);
	$user->id = $_POST['id'];
	$user->firstName = $_POST['firstName'];
	$user->lastName = $_POST['lastName'];
	$errors = updateUserAchievements($_SESSION['hash'], $user->id, $userAchievements);
	if(!isset($errors)){
		header("Location: ./?info=Successfully updated achievements for $user->firstName $user->lastName");
		exit();
	}
	$achievements = unserialize($_POST['achievements']);
	$info = $errors;
}else{
	$result = getUser($_SESSION['hash'], $user->id);
	if(isset($result) && isset($result[0])){
		$info = $result[0];
	}else{
		$user = $result[1];
		$user->id = $id;
		$achievements = getAchievements($_SESSION['hash'], $user->id);
		$userAchievements = getUserAchievements($_SESSION['hash'], $user->id);
	}
}
?>
<h1>Achievement</h1>
<h3><?php echo "$user->firstName $user->lastName"; ?></h3>
<input type='text' name='id' value='<?php echo $user->id; ?>' hidden/>
<input type='text' name='firstName' value='<?php echo $user->firstName; ?>' hidden/>
<input type='text' name='lastName' value='<?php echo $user->lastName; ?>' hidden/>
<input type='text' name='achievements' value='<?php echo serialize($achievements) ?>' hidden/>
<input type='text' name='userAchievements' value='<?php echo serialize($userAchievements) ?>' hidden/>
<label>User Achievements</label></br>
<?php if(isset($userAchievements) && count($userAchievements) > 0){ ?>
	<table border='1'>
		<tr><th>Name</th><th>Remove</th></tr>
		<?php foreach($userAchievements as $ua){?>
		 <tr><td><?php echo $ua[1]; ?></td><td><input type='checkbox' name='removeAchievement' value='<?php echo serialize($ua); ?>' onchange='this.form.submit()'/></td><tr>
		<?php }}else{ ?>
			<tr><td>None Found</td><td></td></tr>
		<?php } ?>
	</table></br>
<?php if(isset($achievements) && count($achievements) > 0){ ?>	
	<label for='accessTag'>Add Achievement</label>
	<select name='achievement' onchange='this.form.submit()'>
		<option style='display:none;'></option>
		<?php foreach($achievements as $a){?>
			<option value='<?php echo serialize($a);?>'><?php echo $a[1]; ?></option>
		<?php } ?>
	</select>
	<br/>
<?php } ?>

