<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ecpay_invoices
{
    public function __construct()
    {
        // log_message('Debug', 'ECpay class is loaded.');
    }
    public function load()
    {
        include 'Ecpay.Invoice.php';
        $obj = new EcpayInvoice();
        return $obj;
    }
}