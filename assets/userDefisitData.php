<?php
class UserDeffisiteData{
	public $id;
	public $item_id;
	public $user_id;
	public $date;
	public $cost;

	function setFromArray($values){
		foreach($values as $key => $value){
			if(property_exists($this, $key)){
				$this->{$key} = $value;
			}
		}
	}
}
?>
