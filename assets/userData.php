<?php
class UserData{
	public $id;
	public $email;
	public $firstName;
	public $middleName;
	public $lastName;
	public $dob;
	public $phone;
	public $pronouns;
	public $accessTags;

	function setFromArray($values){
		foreach($values as $key => $value){
			if(property_exists($this, $key)){
				$this->{$key} = $value;
			}
		}
	}
	function validate(){
		$errors = array();
		$errors = array_merge($errors,$this->validateEmail());
		$errors = array_merge($errors,$this->validateFirst());
		$errors = array_merge($errors,$this->validateMiddle());
		$errors = array_merge($errors,$this->validateLast());
		$errors = array_merge($errors,$this->validateDOB());
		$errors = array_merge($errors,$this->validatePhone());

		return $errors;
	}
	
	function validateEmail(){
		$errors = array();
		if(empty($this->email)){
			$errors[] = "An Email is required.";
		}
		if(strlen($this->email)>100){
			$errors[] = "An Email can not have more than 100 characters.";
		}
		//TODO: verify email
		return $errors;
	}

	function validatePassword($comPass){
		if(empty($this->password)){
			return array("A Password is required.");
		}
		if(strlen($password) > 30){
			return array("A Password can not have more than 30 characters.");
		}
		if(strcmp($this->password, $comPass)){
			return array("The passwords do not match.");
		}
		//TODO: password requirements
		return array();
	}

	function validateFirst(){
		$errors = array();
		if(empty($this->firstName)){
			$errors[] = "A First name is required.";
		}elseif(strlen($this->firstName)>15){
			$errors[] = "A First name can not have more than 15 characters.";
		}
		return $errors;
	}
	function validateMiddle(){
		$errors = array();
		if(empty($this->middleName)){
			$errors[] = "A Middle name is required.";
		}elseif(strlen($this->middleName)>15){
			$errors[] = "A Middle name can not have more than 15 characters.";
		}
		return $errors;
	}
	function validateLast(){
		$errors = array();
		if(empty($this->lastName)){
			$errors[] = "A Last name is required.";
		}elseif(strlen($this->lastName)>15){
			$errors[] = "A Last name can not have more than 15 characters.";
		}
		return $errors;
	}
	function validateDOB(){
		$errors = array();
		if(empty($this->dob)){
			$errors[] = "A Birth Date is required.";
		}else{
			$minDate = Date("1900-01-01");
			$maxDate = Date("Y-m-d");
			if($this->dob < $minDate){
				$errors[] = "The given Birth Date is too old.";
			}elseif($this->dob > $maxDate){
				$errors[] = "The given Birth Date is too young.";
			}
		}
		return $errors;
	}
	function validatePhone(){
		$errors = array();
		if(empty($this->phone)){
			$errors[] = "A Phone Number is required.";
		}elseif(strlen($this->phone) != 10){
			$errors[] = "A Phone Number must be 10 numbers. ex 1112223333";
		}elseif(!preg_match("/^\d+$/", $this->phone)){
			$errors[] = "A Phone Number must only contain numbers.";
		}
		return $errors;
	}

}
?>
