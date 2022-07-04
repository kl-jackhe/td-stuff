<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_address extends Public_Controller {

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
         $this->session->sess_destroy();
         redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $this->data['page_title'] = '常用地址';
        $this->data['my_address'] = $this->mysql_model->_select('users_address', 'user_id', $this->ion_auth->user()->row()->id);
        $this->render('my_address/index');
    }

    public function view($id)
    {
        $this->data['page_title'] = '查看訂單';
        $this->data['order'] = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
        $this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $id);
        $this->load->view('order/view', $this->data);
    }

    public function insert()
    {
        $this->db->where('user_id', $this->ion_auth->user()->row()->id);
        $query = $this->db->get('users_address');
        if($query->num_rows()>0){
            $data = array(
                'user_id'  => $this->ion_auth->user()->row()->id,
                'county'   => $this->input->post('county'),
                'district' => $this->input->post('district'),
                'address'  => $this->input->post('address'),
            );
            $this->db->insert('users_address',$data);
        } else {
            $data = array(
                'user_id'  => $this->ion_auth->user()->row()->id,
                'county'   => $this->input->post('county'),
                'district' => $this->input->post('district'),
                'address'  => $this->input->post('address'),
                'used'     => 1,
            );
            $this->db->insert('users_address',$data);
        }

        $this->session->set_flashdata('message', '常用地址新增成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('user_id', $this->ion_auth->user()->row()->id);
        $this->db->where('id', $id);
        $this->db->delete('users_address');
        $this->session->set_flashdata('message', '常用地址刪除成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function set_default()
    {
        $data = array(
            'used' => 0,
        );
        $this->db->where('user_id', $this->ion_auth->user()->row()->id);
        $this->db->update('users_address', $data);
        //
        $item_data = array(
            'used' => 1,
        );
        $this->db->where('id', $this->input->post('id'));
        if($this->db->update('users_address', $item_data)){
            echo '1';
        } else {
            echo '0';
        }
    }

}