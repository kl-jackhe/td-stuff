<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lottery_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()) {
        $this->db->select('id,name,email_subject,email_content,sms_subject,sms_content,product_id,number_limit,number_remain,number_alternate,star_time,end_time,draw_date,fill_up_date,draw_over,fill_up_over,filter_black,state,lottery_end,create_time');
        // if(!empty($params['search']['keywords'])){
        //     $this->db->like('banner_name',$params['search']['keywords']);
        // }
        $this->db->order_by('id', 'desc');
        if (array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        } elseif (!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get('lottery')->result_array();
        return (!empty($query)?$query:false);
    }

    function getLotteryList($lotteryID = 0, $limit = 0) {
        $this->db->select('id,name,email_subject,email_content,sms_subject,sms_content,product_id,number_limit,number_remain,number_alternate,star_time,end_time,draw_date,fill_up_date,draw_over,fill_up_over,filter_black,state,lottery_end,create_time');
        if ($lotteryID > 0 && $limit > 0) {
            $this->db->where('id', $lotteryID);
            $this->db->limit($limit);
            $query = $this->db->get('lottery')->row_array();
        } else {
            $this->db->where('draw_over', '0');
            $query = $this->db->get('lottery')->result_array();
        }
        return (!empty($query)?$query:false);
    }

    function getLotteryPoolList($lotteryID, $source = '') {
        $this->db->select('id,lottery_id,users_id,send_mail,abstain,winner,alternate,fill_up,blacklist,abandon,order_state,order_id,order_number,msg_mail,msg,create_time');
        $this->db->where('lottery_id', $lotteryID);
        if ($source != '') {
            $this->db->where($source, '1');
        } else {
            $this->db->where('blacklist', '0');
        }
        $query = $this->db->get('lottery_pool')->result_array();
        return (!empty($query)?$query:false);
    }

    function getLotteryPoolRandList($lotteryID, $winnerTotal) {
        $this->db->select('id,lottery_id,users_id,send_mail,abstain,winner,alternate,fill_up,blacklist,abandon,order_state,order_id,order_number,msg_mail,msg,create_time');
        $this->db->where('lottery_id', $lotteryID);
        $this->db->where('blacklist', '0');
        $this->db->order_by('RAND()');
        $this->db->limit($winnerTotal);
        $query = $this->db->get('lottery_pool')->result_array();
        return (!empty($query)?$query:false);
    }

    function getLotteryPoolSendMailList() {
        $this->db->select('id,lottery_id,users_id,send_mail,abstain,winner,alternate,fill_up,blacklist,abandon,order_state,order_id,order_number,msg_mail,msg,create_time');
        $this->db->group_start();
        $this->db->where('fill_up', '1');
        $this->db->or_where('winner', '1');
        $this->db->group_end();
        $this->db->where('send_mail', '');
        $this->db->where('blacklist', '0');
        $this->db->limit(1);
        $row = $this->db->get('lottery_pool')->row_array();
        return (!empty($row)?$row:false);
    }

    function getLotteryDrawList() {
        $this->db->select('id,name,email_subject,email_content,sms_subject,sms_content,product_id,number_limit,number_remain,number_alternate,star_time,end_time,draw_date,fill_up_date,draw_over,fill_up_over,filter_black,state,lottery_end,create_time');
        $this->db->where('draw_over', '1');
        $this->db->where('lottery_end', '0');
        $query = $this->db->get('lottery')->result_array();
        return (!empty($query)?$query:false);
    }
}