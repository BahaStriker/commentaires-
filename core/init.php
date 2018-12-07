<?php
// Abandon all hope you who needs to debug this

session_start(); // I am not sure if we need this, but too scared to delete. 

$GLOBALS['config']  =   array(
    'mysql' =>  array(
        'host'  =>  '127.0.0.1',
        'user'  =>  'root',
        'pass'  =>  '',
        'db'    =>  'devrows'
    ),
    'remember'  =>  array(
        'cookie_name'   =>  'devrows.com',
        'cookie_expiry' =>  604800
    ),
    'sessions'  =>  array(
        'session_name'  =>  'devrows_session',
        'token_name'    =>  'devrows_token'
    )
);

// The root of all evil ... umm classes 
spl_autoload_register(function($class){
    
    require_once 'classes/' .   $class  .   '.php';
});

require_once 'functions/helper.php'; // Help me daddy

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('sessions/session_name'))) { // Where did mommy put the cookies
    
    $hash       =   Cookie::get(Config::get('remember/cookie_name')); // Here?
    $hashCheck  =   DB::getInstance()->get('users_session', array('hash', '=', $hash));
    // If this comment is removed the program will blow up
    if($hashCheck->count()) {
        $user   =   new User($hashCheck->first()->user_id);
        /* forgive me daddy for I have sinned, please work  */
        $user->login();
    }
}
