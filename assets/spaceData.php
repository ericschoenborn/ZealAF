<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);


class SpaceData{
	public $id;
	public $name;
	public $description;

	function setFromArray($values){
		foreach($values as $key => $value){
			if(property_exists($this, $key)){
				$this->{$key} = $value;
			}
		}
	}
	function validate(){
		$errors = array();
		$errors = array_merge($errors,$this->validateName());	
		$errors = array_merge($errors,$this->validateDescription());
		return $errors;
	}
	function validateName(){
		$errors = array();
		if(empty($this->name)){
			$errors[] = "A name is required.";
		}elseif(strlen($this->name)>50){
			$errors[] = "A name can not have more than 50 characters.";
		}
		return $errors;
	}
	
	function validateDescription(){
		$errors = array();
		if(empty($this->description)){
			$errors[] = "A description is required.";
		}elseif(strlen($this->description)>300){
			$errors[] = "A description can not have more than 300 characters.";
		}
		return $errors;
	}


}
?>
