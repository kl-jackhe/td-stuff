<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ecpay_payment
{
    public function __construct()
    {
        // log_message('Debug', 'ECpay class is loaded.');
    }
    public function load()
    {
        include 'ECPay.Payment.Integration.php';
        $obj = new ECPay_AllInOne();
        return $obj;
    }
}
