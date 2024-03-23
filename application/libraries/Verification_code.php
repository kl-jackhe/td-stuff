<?php (!defined('BASEPATH')) and exit('No direct script access allowed');

class Verification_code
{
    function __construct()
    {
        $this->ci = &get_instance();
    }

    function generateVerificationCode()
    {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= mt_rand(0, 9);
        }
        $time = time() + 600;

        $data = array(
            'code' => $code,
            'life' => $time
        );
        return $data;
    }
}
