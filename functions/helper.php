<?php
/*
* Call this if you need any kind of help 
*/


function escape($string){ 

    $ret_string = $string;
    $ret_string = htmlspecialchars ($ret_string);
    $ret_string = trim ($ret_string);
    return htmlentities($ret_string, ENT_QUOTES, 'UTF-8');
}

/*
* Was it helpful?
*/
