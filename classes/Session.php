<?php
// a free massage session

Class Session {

	public static function exists($name) { // Looking for the masseuse ?

		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name, $value) { // It's ok choose one and we'll assign it for you
		return $_SESSION[$name]	=	$value; 
	}

	public static function get($name) { // There she comes
		return $_SESSION[$name]; 
	}

	public static function delete($name){ // Ouch, she says you're not worthy
		if(self::exists($name)) {
			unset($_SESSION[$name]); 
		}
	}

	// TODO - Comment this method
	public static function flash($name, $type = '', $string = '') {

		if(self::exists($name) && self::exists($name.'_'.$type)) {
			$session 	=	self::get($name);
			$name_type	=	self::get($name.'_'.$type);
			self::delete($name);
			self::delete($name.'_'.$type);

			switch ($name_type) {
				case 'primary':
					$class 	=	'alert-primary';	
					break;
				case 'secondary':
					$class 	=	'alert-secondary';	
					break;
				case 'success':
					$class 	=	'alert-success';	
					break;
				case 'danger':
					$class 	=	'alert-danger';	
					break;
				case 'warning':
					$class 	=	'alert-warning';	
					break;		
				case 'info':
					$class 	=	'alert-info';	
					break;
				case 'light':
					$class 	=	'alert-light';	
					break;
				case 'dark':
					$class 	=	'alert-dark';	
					break;		
				default:
					$class 	=	'alert-primary';
					break;
			}
			$alert 	=	'<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">
						  ' . $string . '
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>';
			return $alert;
		} else {
			self::put($name, $string);
			self::put($name.'_'.$type, $type);
		}

		return ''; // need a coffee to fix this.
	}
}
