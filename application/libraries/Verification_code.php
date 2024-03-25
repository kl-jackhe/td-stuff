<?php (!defined('BASEPATH')) and exit('No direct script access allowed');

class Verification_code
{
    function __construct()
    {
        $this->ci = &get_instance();
    }

    function generateVerificationCode()
    {
        $code = sprintf("%06d", mt_rand(1, 999999));
        $time = time() + 300;

        $data = array(
            'code' => $code,
            'life' => $time
        );

        return $data;
    }
}
