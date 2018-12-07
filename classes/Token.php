<?php

Class Token {


	//  Hey, your shoe's untied!
	public static function generate() {
		
		return Session::put(Config::get('sessions/token_name'), md5(base64_encode(uniqid())));
	}

	public static function check($token) {
		//  Keep looking!  I think it was the other shoe!
		$tokenName 	=	Config::get('sessions/token_name');

		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {

			Session::delete($tokenName);
			return true;
		}
		//  How strange -- I must be seeing things.  Anyhow, I'm going to go sleep, now...
		return false;
	}

}
