<?php

function read_dictionary($filename="") {
    $dictionary_file = "./dictionaries/{$filename}";
    return file($dictionary_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function pick_random($array) {
    $i = random_int(0, count($array)-1);
    return $array[$i];
}

function pick_random_symbol() {
    $symbols = '!@$%*-?';
    $i = random_int(0, strlen($symbols)-1);
    return $symbols[$i];
}

function pick_random_number($digits=1) {
    $min = pow(10, ($digits - 1));
    $max = pow(10, $digits) - 1;
    return strval(random_int($min,$max));
}

function filter_words_by_length($array, $length) {
    $select_words = array();
    foreach ($array as $word) {
        if (strlen($word) == $length) {
            $select_words[] = $word;
        }
    }
    return $select_words;
}

function pick_random_word($words, $length) {
    $select_words = filter_words_by_length($words, $length);
    return pick_random($select_words);
}

$words = read_dictionary('friendly_words.txt');

$length = 12;
$word_count = 2;
$digit_count = 2;
$symbol_count = 1;
$avg_wlength = ($length - $digit_count - $symbol_count) / $word_count;

$password = "";

$next_wlength = random_int($avg_wlength - 1, $avg_wlength + 1);
$password .= pick_random_word($words, $next_wlength);

$password .= pick_random_symbol();
$password .= pick_random_number($digit_count);

$next_wlength = $length - strlen($password);
$password .= pick_random_word($words, $next_wlength);

echo $password . '<br />';
echo strlen($password);