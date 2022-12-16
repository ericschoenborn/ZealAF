<?php
class EventData{
	public $id;
	public $name;
	public $description;
	public $cost;
	public $usePunchCost;
	public $usePassCost;
	public $useStaffCost;
	public $punchCost;
	public $passCost;
	public $staffCost;
	public $displayColor;
	public $requirements;

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
		$errors = array_merge($errors,$this->validatePunchCost());
		$errors = array_merge($errors,$this->validatePassCost());
		$errors = array_merge($errors,$this->validateStaffCost());
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
			if(strlen($this->cost)==0){
				$errors[] = "A cost is required.";
			}elseif($this->cost > 999.99 || $this->cost < 0.00){
				$errors[] = "A cost must be between $0.00 and $999.99";
			}
			return $errors;
	}
	function validatePunchCost(){
		$errors = array();
		if($this->usePunchCost == 1){
			if(strlen($this->punchCost)==0){
				$errors[] = "A punch cost is required.";
			}elseif($this->punchCost > 100 || $this->punchCost < 1){
				$errors[] = "A cost must be between 1 and 100";
			}
		}
		return $errors;
	}
	function validatePassCost(){
		$errors = array();
		if($this->usePassCost == 1){
			if(strlen($this->passCost)==0){
				$errors[] = "A pass cost is required.";
			}elseif($this->passCost > 999.99 || $this->passCost < 0.00){
				$errors[] = "A pass cost must be between $0.00 and $999.99";
			}
		}
		return $errors;
	}
	function validateStaffCost(){
		$errors = array();
		if($this->useStaffCost == 1){
			if(strlen($this->staffCost)==0){
				$errors[] = "A staff cost is required.";
			}if($this->staffCost > 999.99 || $this->staffCost < 0.00){
				$errors[] = "A staff cost must be between $0.00 and $999.99";
			}
		}
		return $errors;
	}
}
?>
