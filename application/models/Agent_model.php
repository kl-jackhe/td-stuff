<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()) {
        $this->db->select('id,name,users_id,status,created_at,updated_at');
        if (!empty($params['search']['status'])) {
            $this->db->where('status', ($params['search']['status'] == 'Enabled' ? true : false));
        }
        $query = $this->db->get('agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getAgentList() {
        $this->db->select('id,name,users_id,status,created_at,updated_at');
        $this->db->where('status',1);
        $query = $this->db->get('agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getUsersList() {
        $this->db->select('users.id,users.username,users.email,users.full_name,users.phone,users.birthday');
        $this->db->join('users_groups','users_groups.user_id = users.id');
        $this->db->where('users_groups.group_id', 2);
        $this->db->where('users.active', 1);
        $query = $this->db->get('users')->result_array();
        return (!empty($query)? $query : false);
    }

    function getAgentName($agent_id) {
        $this->db->select('id,name');
        $this->db->where('id', $agent_id);
        $this->db->limit(1);
        $row = $this->db->get('agent')->row_array();
        return (!empty($row)? $row['name'] : '');
    }

    function getAgentDetail($id) {
        $this->db->select('agent.id,agent.name,agent.full_name,agent.phone,agent.address,agent.remark,agent.users_id,agent.status,agent.created_at,agent.updated_at');
        $this->db->select('users.username,users.gender,users.email AS users_email,users.full_name AS users_full_name,users.phone AS users_phone,users.county,users.district,users.address AS users_address,users.birthday,users.company,users.status AS users_status');
        $this->db->join('users','users.id = agent.users_id');
        $this->db->where('agent.id', $id);
        $this->db->limit(1);
        $row = $this->db->get('agent')->row_array();
        return (!empty($row)? $row : false);
    }

}