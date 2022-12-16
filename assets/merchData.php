<?php
ini_set('display_errors', 1);
       error_reporting(E_ALL);

class MerchData{
	public $id;
	public $name;
	public $cost;
	public $description;
	public $quantity;
	public $infinite;
	public $type;

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
		$errors = array_merge($errors,$this->validateCost());
		$errors = array_merge($errors,$this->validateQuantity());
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
	function validateCost(){
			$errors = array();
			if(empty($this->cost)){
				$errors[] = "A cost is required.";
			}elseif($this->cost > 999.99 || $this->cost < 0.00){
				$errors[] = "A cost must be between $0.00 and 999.99";
			}
			return $errors;
	}
	function validateQuantity(){
		$errors = array();
		if($this->infinite == 0){
			if(empty($this->quantity)){
				$errors[] = "A quantity is needed if not infinite";
			}elseif($this->quantity > 999 || $this->quantity <= 0){
				$errors[] = "A quantity must be between 0 and 9999.";
			}
			return $errors;
		}
	}
}
?>
