<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ecpay_logistics
{
    public function __construct()
    {
        // log_message('Debug', 'ECpay class is loaded.');
    }
    public function load()
    {
        include 'ECPay.Logistics.Integration.php';
        $obj = new ECPayLogistics();
        return $obj;
    }
}
