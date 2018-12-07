<?php

Class Cookie {

    /**
    * Mom I want cookies 
    * 
    * please @return true :c
    */

    public static function exists($name) {
        
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /**
    * 
    * @return array  Cookies!  Nom nom nom nom nom.
    */

    public static function get($name) {
        
        return $_COOKIE[$name];
    }

    /**
    * It's like a swear jar
    * You swear you @return a Cookie
    * I'm fucking sad.
    */

    public static function put($name, $value, $expiry) {

        if(setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }

        return false;
    }

    /**
    * Oh crap...
    */

    public static function delete($name) {
        
        self::put($name, '', time() - 1);
    }


}
