<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Public_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
        $this->load->model('order_model');
        if (!$this->ion_auth->logged_in())
        {
         $this->session->sess_destroy();
         redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $this->data['page_title'] = '訂單';
        $this->data['orders'] = $this->order_model->get_customer_order($this->ion_auth->user()->row()->id);
        $this->render('order/index');
    }

    public function view($id)
    {
        $this->data['page_title'] = '查看訂單';
        $this->data['order'] = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
        $this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $id);
        $this->load->view('order/view', $this->data);
    }

    public function checkout()
    {
        $this->data['page_title'] = '結帳';
        $this->data['banner'] = $this->home_model->GetBanner();
        $this->render('store/checkout');
    }

    public function atm()
    {
        $this->data['page_title'] = 'ATM付款';
        $this->data['banner'] = $this->home_model->GetBanner();
        $this->render('store/checkout-atm-callback');
    }

    public function credit()
    {
        $this->data['page_title'] = '信用卡付款';
        $this->data['banner'] = $this->home_model->GetBanner();
        $this->render('store/checkout-credit-callback');
    }

    public function cancel($id)
    {
        $data = array(
            'order_step' => 'cancel',
            'order_pay_status' => 'cancel',
            'order_void' => '1',
            'updater_id' => $this->ion_auth->user()->row()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('order_id', $id);
        $this->db->update('orders', $data);
        //
        $item_data = array(
            'order_item_void' => '1',
        );
        $this->db->where('order_id', $id);
        $this->db->update('order_item', $item_data);

        $this->session->set_flashdata('message', '取消訂單成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function void($id)
    {
        $data = array(
            'order_step' => 'void',
            'order_pay_status' => 'return',
            'order_void' => '1',
            'updater_id' => $this->ion_auth->user()->row()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('order_id', $id);
        $this->db->update('orders', $data);
        //
        $item_data = array(
            'order_item_void' => '1',
        );
        $this->db->where('order_id', $id);
        $this->db->update('order_item', $item_data);

        $this->session->set_flashdata('message', '退單成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

}