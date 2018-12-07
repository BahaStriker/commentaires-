<?php

Class Redirect {

    public static function to($location = NULL) {

        if(!is_null($location)) {

            if(is_numeric($location)) {

                switch ($location) {
                    case 404:
                        header('HTTP/1.1 404 Not Found');
                        include_once 'includes/errors/404.php';
                        exit();
                        break;
                }
            }
            header('Location:' . $location);
            exit();
        }
    }

    public static function back() {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
