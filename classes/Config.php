<?php
/*
 * You may think you know what the following code does.
 * But you dont. Trust me.
 * Fiddle with it, and youll spend many sleepless
 * nights cursing the moment you thought you'd be clever
 * enough to "optimize" the code below.
 * Now close this file and go play with something else.
 */ 

Class Config {
    // OK, OK You're stubborn I'll explain
    public static function get($path = NULL){
        
        if($path){ // Let's check if it's not null cuz we know it's cool

            $config =   $GLOBALS['config']; // because I can
            $path   =   explode('/', $path); // damn it we exploded the path

            foreach($path as $bit){ // we collect the exploded path
                if(isset($config[$bit])){
                    $config =   $config[$bit]; // our jar for the collected stuff
                }
            }
            
            return $config; // let's return the jar and pretend nothing happened
        }

        return false; // lol. null.
    }

}
