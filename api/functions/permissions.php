<?php
	function getPermissionErrorsByHash($hash, $accessTagIds){
		$id = getIdByHash($hash);
		$access = $accessTagIds;
		$invalid = validateUserById(2, $access);
		if(!empty($invalid)){
			return array($invalid);
		}

		return null;
	}
?>
