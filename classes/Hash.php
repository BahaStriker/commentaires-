<?php

Class Hash {

    public static function make($string, $salt = '') { // Make me proud please

        return '$DR$'. hash('sha256', md5(base64_encode($string), true).$salt);
    }

    public static function salt($string, $length) { //Oh this is too salty

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        return openssl_encrypt($string, 'aes-256-cbc', $length, 0, $iv);
    }

    public static function unique() { // *blush*

        return self::make(unique());
    }

}
