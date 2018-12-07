<?php

Class Input {

	private $_form = '';

	public static function exists($type = 'POST') {
		switch($type){
			case 'POST' :
				return (!empty($_POST)) ? true : false;
				break;

			case 'GET' :
				return (!empty($_GET)) ? true : false;
				break;
			default :
				return false;
				break;	
		}
	}

	public static function get($item) {
		// There once was a man named Dave
		if(isset($_POST[$item])) {
			// Whose code just wouldn't behave
			return $_POST[$item];
		}
		// He left to go to a meetin'
		elseif(isset($_GET[$item]))	{
			// And left his memory a leakin'
			return $_GET[$item];
		}

		return ''; //What did you excpect? it leaked pretty hard
	}

/* FIXME: please god, when will the hurting stop? This method is so
   fucking broken it's not even funny. */

/*	public function form($method, $action = '#', $items  = array()) {
		foreach ($items as $item => $fields) {
			
			$item 	=	escape($item);

			foreach ($fields as $field => $field_value) {
				@$form_fields	.=	"{$field}='{$field_value}'";

				if($field !== $field_value && $field === 'id'){
					break;
				}
			}

			@$form .= "<input {$form_fields} name='{$item}'>";
			
		}

		$last	=	"<form action='". $action ."' method='". $method ."'>". $form ."</form>";

		return $last;

	}

	public function create() {
		return $this->_form;
	}
*/
}
