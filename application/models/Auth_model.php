<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getAuthVisiterCategory()
    {
        $this->db->select('*');
        $query = $this->db->get('auth_visiter_category')->result_array();
        return (!empty($query) ? $query : false);
    }

    function getAuthMemberCategory()
    {
        $this->db->select('*');
        $query = $this->db->get('auth_member_category')->result_array();
        return (!empty($query) ? $query : false);
    }
}
