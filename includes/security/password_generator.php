<?php

function random_char($string) {
    $i = random_int(0,strlen($string)-1);
    return $string[$i];
}

function random_string($length, $char_set) {
    $output = '';
    for ($i=0; $i < $length; $i++) {
        $output .= random_char($char_set);
    }
    return $output;
}

function generate_password($length) {
    // define character sets
    $lower = 'abcdefghijklmnopqrstuvwxyz'; // implode(range('a','z'));
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // implode(range('A','Z'));
    $numbers = '0123456789'; // implode(range('0','9'));
    $symbols = '!@$%^*-?';

    $chars = $lower . $upper . $numbers . $symbols;
    
    return random_string($length, $chars);
}

$length = 12;

echo generate_password($length);