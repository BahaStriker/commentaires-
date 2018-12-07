<?php
/**
* Let's validate everything
*
*/

Class Validate {

	private $_passed	=	false, // We privatly didn't pass :c
			$_errors	=	array(),
			$_db		=	NULL;


	public function __construct() {
		$this->_db	=	DB::getInstance();
	}

	public function check($source, $items = array()) { // Let's check items for bombs
		foreach($items as $item => $rules) {
			$itemName	=	$rules['name'];
			foreach ($rules as $rule => $rule_value) {
				$value 	=	trim($source[$item]);
				$item 	=	escape($item); // oh oh 

				if($rule === 'required' && empty($value)) {
					$this->addError("{$itemName} is required!");
				} 
				elseif(!empty($value)) {
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$itemName} must be a minimum of {$rule_value} characters.");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$itemName} must be a maximum of {$rule_value} characters.");
							}
							break;
						case 'matches':
							if($value !== $source[$rule_value]) {
								$this->addError("{$rule_value} must match {$itemName}");
							}
							break;
						case 'unique':
							$check 	= $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count() !== 0){
								$this->addError("{$itemName} already exists.");
							}
							break;	
						case 'isEmail':
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError("{$itemName} must be a valid Email address.");
							}
							break;
						case 'format':
							if(!preg_match($rule_value, $value)){
								$this->addError("Invalid {$itemName} format.");
							}
							break;
					}
				}
			}
		}

		if(empty($this->_errors)){
			$this->_passed	=	true;
		}

		return $this;
	}

	private function addError($error) {
		//PRIVATE means PRIVATE so no comments for you
		$this->_errors[]	=	$error;
	}

	public function passed() {
		return $this->_passed;
	}

	public function errors() {
		return $this->_errors;
	}

}
