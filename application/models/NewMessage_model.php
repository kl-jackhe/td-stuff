<?php defined('BASEPATH') OR exit('No direct script access allowed');

class NewMessage_model extends CI_Model {

	function __construct() {
		parent::__construct();
        $this->load->database();
	}
}