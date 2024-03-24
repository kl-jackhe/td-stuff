<?php defined('BASEPATH') or exit('No direct script access allowed');

class Encode extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function getDataEncode($dataName, $fixed = true)
    {
        $input = $this->input->post($dataName);
        $data = array(
            'type' => $dataName,
            $dataName => $input,
        );
        $src = $this->security_url->encryptData($data);
        if ($fixed) {
            $src = $this->security_url->fixedEncryptData($data);
        }
        if (!empty($src)) {
            $return_data = array(
                'result' => 'success',
                'src' => $src,
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($return_data));
        } else {
            $return_data = array(
                'result' => 'error',
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($return_data));
        }
        return;
    }

    function getMutiPostDataEncode($fixed = true)
    {
        $data = $this->input->post();
        $src = $this->security_url->encryptData($data);
        if ($fixed) {
            $src = $this->security_url->fixedEncryptData($data);
        }
        if (!empty($src)) {
            $return_data = array(
                'result' => 'success',
                'src' => $src,
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($return_data));
        } else {
            $return_data = array(
                'result' => 'error',
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($return_data));
        }
        return;
    }
}
