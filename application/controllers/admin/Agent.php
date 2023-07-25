<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('sales_model');
        $this->load->model('agent_model');
	}

    function index()
    {
        $this->data['page_title'] = '代言人管理';
        $this->data['Agent'] = $this->agent_model->getAgentList();
        $this->data['Users'] = $this->agent_model->getUsersList();
        $this->render('admin/agent/index');
    }

    function createAgent() {
        if ($this->input->post('name') != '') {
            $repeatedAttempts = 0;
            $agentID = '';
            do {
                $agentID = 'A' .  date('ym') . get_random_string(3);
                $this->db->select('id');
                $this->db->where('id',$agentID);
                $this->db->limit(1);
                $ss_row =$this->db->get('agent')->row_array();
                if (!empty($ss_row)) {
                    $repeatedAttempts++;
                    if ($repeatedAttempts >= 5) {
                        break;
                    }
                } else {
                    break;
                }
            } while (true);
            if ($agentID != '') {
                $insertData = array(
                    'id' => $agentID,
                    'name' => $this->input->post('name'),
                    'users_id' => ($this->input->post('users_id') != '' ? $this->input->post('users_id') : 0),
                );
                $this->db->insert('agent',$insertData);
                if ($this->db->affected_rows() > 0) {
                    echo 'ok';
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function createAgentQuantity() {
        if ($this->input->post('agent_qty') > 0) {
            $conut = 0;
            for ($i=0; $i < $this->input->post('agent_qty'); $i++) {
                $repeatedAttempts = 0;
                $conut++;
                $agentID = '';
                do {
                    $agentID = 'A' .  date('ym') . get_random_string(3);
                    $this->db->select('id');
                    $this->db->where('id',$agentID);
                    $this->db->limit(1);
                    $ss_row =$this->db->get('agent')->row_array();
                    if (!empty($ss_row)) {
                        $repeatedAttempts++;
                        if ($repeatedAttempts >= 5) {
                            break;
                        }
                    } else {
                        break;
                    }
                } while (true);
                if ($agentID != '') {
                    $insertData = array(
                        'id' => $agentID,
                        'name' => $agentID,
                    );
                    $this->db->insert('agent',$insertData);
                    if ($this->db->affected_rows() > 0) {
                        $insertData = array(
                            'single_sales_id' => $this->input->post('sales_id'),
                            'agent_id' => $agentID,
                            'agent_name' => $conut,
                        );
                        $this->db->insert('single_sales_agent',$insertData);
                        if ($this->db->affected_rows() > 0) {
                            echo 'ok';
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    function selectAgentImport() {
        $agent_id_list = $this->input->post('agent_id_list');
        for ($i=0; $i < count($agent_id_list); $i++) {
            if (empty($this->sales_model->checkSingleSalesAgentIsDuplicate($this->input->post('sales_id'),$agent_id_list[$i]))) {
                $insertData = array(
                    'single_sales_id' => $this->input->post('sales_id'),
                    'agent_id' => $agent_id_list[$i],
                );
                $this->db->insert('single_sales_agent',$insertData);
                if ($this->db->affected_rows() > 0) {
                    echo 'ok';
                } else {
                    return false;
                }
            }
        }
    }


}