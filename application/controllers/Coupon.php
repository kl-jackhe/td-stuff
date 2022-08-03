<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends Public_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('coupon_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $this->data['page_title'] = '優惠券';
        $this->data['user_coupon'] = $this->coupon_model->get_user_all_coupon($this->ion_auth->user()->row()->id);
        $this->render('coupon/index');
    }

    public function insert()
    {
        // $this->db->select('*');
        $this->db->where('coupon_type', 'general');
        $this->db->where('coupon_code', $this->input->post('coupon_code'));
        $query = $this->db->get('coupon');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            // $data = $row['coupon_code'];
            $this->db->where('user_id', $this->ion_auth->user()->row()->id);
            $this->db->where('coupon_code', $this->input->post('coupon_code'));
            $query2 = $this->db->get('user_coupon');
            if ($query2->num_rows() > 0) {
                $this->session->set_flashdata('message', '此優惠券已取得！');
            } else {
                $insert_data = array(
                    'user_id'            => $this->ion_auth->user()->row()->id,
                    'coupon_name'        => $row['coupon_name'],
                    'coupon_code'        => $this->input->post('coupon_code'),
                    'coupon_expiry_date' => $row['coupon_off_date'],
                    'creator_id'         => $this->ion_auth->user()->row()->id,
                    'created_at'         => date('Y-m-d H:i:s'),
                );
                $this->db->insert('user_coupon', $insert_data);
                $this->session->set_flashdata('message', '優惠券取得成功！');
            }
        } else {
            $this->session->set_flashdata('message', '此優惠券不存在！');
        }
        redirect( base_url() . 'coupon');
    }

}