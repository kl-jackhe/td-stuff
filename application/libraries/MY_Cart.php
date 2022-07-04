<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

    // 允許購物車商品可以添加特殊字符
    //var $product_name_rules = '[:print:]';
    var $product_name_rules = '\d\D';

}