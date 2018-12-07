<?php 
/**
* For the brave souls who get this far: You are the chosen ones,
* the valiant knights of programming who toil away, without rest,
* fixing our most awful code. To you, true saviors, kings of men,
* I say this: never gonna give you up, never gonna let you down,
* never gonna run around and desert you. Never gonna make you cry,
* never gonna say goodbye. Never gonna tell a lie and hurt you.
*/


require_once 'core/init.php'; // Magic. Do not touch.

if(Input::exists()){ // I put on my robe and wizard hat...
	if(Token::check(Input::get('token'))) { // Abandon all hope, you who enter beyond this point
		$validate = new Validate();  // NOT FIT FOR HUMAN CONSUMPTION
		$validation = $validate->check($_POST, array( // and there is where the dragon lives
			'username'	=>	array(
				'name'		=>	'Username',
				'required'	=> 	true,
				'min'		=>	2,
				'max'		=>	20,
				'unique'	=>	'users',
				'format'	=> '/^[a-zA-Z0-9 ]*$/u' //this formula is right, work out the math yourself if you don't believe me
			),
			'password'	=>	array(
				'name'		=>	'Password',
				'required'	=>	true,
				'min'		=>	6
			),
			'password_again'	=>	array(
				'name'		=>	'Repeat Password',
				'required'	=>	true,
				'matches'	=>	'password'
			),
			'email'		=>	array(
				'name'		=>	'Email Address',
				'required'	=>	true,
				'isEmail'	=>	true,
				'unique'	=>	'users'
			),
			'name'		=>	array(
				'name'		=>	'Your Name',
				'required'	=>	true,
				'min'		=>	2,
				'max'		=>	50
			)
		));

		if($validation->passed()) { // Did we kill it?
			$user = new User(); // Billy go check the cave
			$salt = Hash::salt(Input::get('username'), '32'); // DON'T LIGHT IT UP

			try{ // RUN FOR YOUR LIVES IT'S BREATHING FIRE!
				$user->create(array(
					'username'	=>	Input::get('username'),
					'email'	=>	Input::get('email'),
					'password'	=>	Hash::make(Input::get('password'), $salt),
					'salt'	=>	$salt,
					'name'	=>	Input::get('name'),
					'created_at'	=>	date('Y-m-d H:i:s'),
				));
			} catch(Exception $e) {
				// We lost boyz
		} else {
			print_r($validation->errors()); // oh crap, we should do something.
		}
	}
}

if(Session::exists('alert')){
	echo Session::flash('alert');
}
?>

<!-- Here it is -->
<form method="POST">
	<input type="text" name="username" placeholder="Username" autocomplete="off" value="<?=Input::get('username')?>"> </br>
	<input type="password" name="password" placeholder="Password"></br>
	<input type="password" name="password_again" placeholder="Repeat Password"></br>
	<input type="email" name="email" placeholder="Email Address" autocomplete="off" value="<?=Input::get('email')?>"></br>
	<input type="text" name="name" placeholder="Your Name" value="<?=Input::get('name')?>"></br>
	<input type="hidden" name="token" value="<?=Token::generate()?>">
	<input type="submit" value="Register">
</form>
