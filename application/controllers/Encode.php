<?php defined('BASEPATH') or exit('No direct script access allowed');

class Encode extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function getDataEncode($dataName)
    {
        $input = $this->input->post($dataName);
        $data = array(
            'type' => $dataName,
            $dataName => $input,
        );
        $src = $this->security_url->encryptData($data);
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

    function getMutiDataEncode($group)
    {
        $data = array();
        foreach ($group as $self) {
            $data[$self] = $this->input->post($self);
        }
        $src = $this->security_url->encryptData($data);
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
