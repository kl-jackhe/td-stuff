<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function get_random_string($str_len) {
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shuffled = str_shuffle($str);
    return substr($shuffled, 0, $str_len);
}