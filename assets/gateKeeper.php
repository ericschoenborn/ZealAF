<?php
session_start();
function gateCheck($required){
	$showContent = false;
	if(isset($_SESSION['time_stamp'])){
		if(time()-$_SESSION['time_stamp'] > 3600){
			session_unset();
			session_destroy();
			header("Refresh:0",$_SERVER['PHP_SELF']);
			//exit();
		}else{
			$r = time()-$_SESSION['time_stamp'];
			if(!empty($required)){
				foreach($_SESSION['tags'] as $tag){
					if(in_array($tag, $required)){
						$showContent = true;
					}
				}
			}else{
				$showContent = true;
			}
		}
	}
	return $showContent;
}
?>
