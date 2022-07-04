<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function general()
    {
        $this->data['page_title'] = '全站設定';
        $this->data['product'] = $this->mysql_model->_select('product');
        $this->load->model('service_area_model');
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->render('admin/setting/general');
    }

    public function update_general()
    {
        if($this->input->get('type')=='all_coupon' || $this->input->get('type')=='recommend_coupon'){
            $updated_at = date('Y-m-d H:i:s');
            $query = $this->db->get('setting_general');
            foreach($query->result_array() as $value){
                // echo "欄位: ".($key)." 的值: ".($value)."<br>";
                foreach ($_POST as $post_key => $post_value) {
                    if( !is_array( $post_value ) ){
                        // echo "欄位: ".($post_key)." 的值: ".($post_value)."<br>";
                        if($value['setting_general_name']==$post_key){
                            if($value['setting_general_value']!=$post_value){
                                echo $post_key." [值] ".$post_value."<br>";
                                $insert_data = array(
                                    'change_log_column'     => 'recommend_coupon',
                                    'change_log_column_id'  => 0,
                                    'change_log_key'        => $post_key,
                                    'change_log_value'      => $post_value,
                                    'change_log_creator_id' => $this->ion_auth->user()->row()->id,
                                    'change_log_created_at' => $updated_at,
                                );
                                $this->db->insert('change_log', $insert_data);
                            }
                        }
                    }
                }
            }
        }

        $query = $this->db->get('setting_general');
        foreach($query->result_array() as $result){
            // if(!empty($this->input->post($result['setting_general_name']))){
            if(isset($_POST[$result['setting_general_name']])){
                $data = array(
                    'setting_general_value' => $this->input->post($result['setting_general_name']),
                );
                $this->db->where('setting_general_name', $result['setting_general_name']);
                $this->db->update('setting_general', $data);
            }

        }

        $this->session->set_flashdata('message', '設定成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function invoice()
    {
        $this->data['page_title'] = '發票';
        $this->data['invoice'] = $this->mysql_model->_select('setting_invoice');

        $this->render('setting/invoice/index');
    }

    public function invoice_edit($id)
    {
        $this->data['page_title'] = '編輯發票';
        $this->data['invoice'] = $this->mysql_model->_select('setting_invoice','invoice_month',$id,'row');
        $this->render('setting/invoice/edit');
    }

    public function invoice_update($id)
    {
        $data = array(
            'invoice_code'      => $this->input->post('invoice_code'),
            'invoice_now'       => $this->input->post('invoice_now'),
            'invoice_min'       => $this->input->post('invoice_min'),
            'invoice_max'       => $this->input->post('invoice_max'),
            'invoice_min_spare' => $this->input->post('invoice_min_spare'),
            'invoice_max_spare' => $this->input->post('invoice_max_spare'),
        );

        $this->db->where('invoice_month', $id);
        $this->db->update('setting_invoice', $data);
        $this->session->set_flashdata('message', '發票更新成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    // 商品單位 ---------------------------------------------------------------------------------

    public function unit()
    {
        $this->data['page_title'] = '商品單位';
        $this->data['unit'] = $this->mysql_model->_select('unit');

        $this->render('setting/unit/index');
    }

    public function insert_unit()
    {
        $this->data['page_title'] = '新增商品單位';

        $data = array(
            'unit_name'  => $this->input->post('unit_name'),
            'creator_id' => $this->ion_auth->user()->row()->id,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('unit', $data);
        redirect( base_url() . 'setting/unit');
    }

    public function edit_unit($id)
    {
        $this->data['page_title'] = '編輯商品單位';
        $this->data['unit'] = $this->mysql_model->_select('unit','unit_id',$id,'row');

        $this->render('setting/unit/edit');
    }

    public function update_unit($id)
    {
        $data = array(
            'unit_name'  => $this->input->post('unit_name'),
            'updater_id' => $this->ion_auth->user()->row()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('unit_id', $id);
        $this->db->update('unit', $data);

        redirect( base_url() . 'setting/unit');
    }

    public function delete_unit($id)
    {
        $this->db->where('unit_id', $id);
        $this->db->delete('unit');
        redirect( base_url() . 'setting/unit');
    }

    // 運送方式 ---------------------------------------------------------------------------------

    public function delivery()
    {
        $this->data['page_title'] = '運送方式';
        $this->data['delivery'] = $this->mysql_model->_select('delivery');

        $this->render('setting/delivery/index');
    }

    public function insert_delivery()
    {
        $this->data['page_title'] = '新增運送方式';

        $data = array(
            'delivery_name' => $this->input->post('delivery_name'),
            'creator_id'    => $this->ion_auth->user()->row()->id,
            'created_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->insert('delivery', $data);
        redirect( base_url() . 'setting/delivery');
    }

    public function edit_delivery($id)
    {
        $this->data['page_title'] = '編輯運送方式';
        $this->data['delivery'] = $this->mysql_model->_select('delivery','delivery_id',$id,'row');

        $this->render('setting/delivery/edit');
    }

    public function update_delivery($id)
    {
        $data = array(
            'delivery_name' => $this->input->post('delivery_name'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );
        $this->db->where('delivery_id', $id);
        $this->db->update('delivery', $data);

        redirect( base_url() . 'setting/delivery');
    }

    public function delete_delivery($id)
    {
        $this->db->where('delivery_id', $id);
        $this->db->delete('delivery');
        redirect( base_url() . 'setting/delivery');
    }

    // 付款方式 ---------------------------------------------------------------------------------

    public function payment()
    {
        $this->data['page_title'] = '付款方式';
        $this->data['payment'] = $this->mysql_model->_select('payment');

        $this->render('setting/payment/index');
    }

    public function insert_payment()
    {
        $this->data['page_title'] = '新增付款方式';

        $data = array(
            'payment_name' => $this->input->post('payment_name'),
            'creator_id'   => $this->ion_auth->user()->row()->id,
            'created_at'   => date('Y-m-d H:i:s'),
        );

        $this->db->insert('payment', $data);
        redirect( base_url() . 'setting/payment');
    }

    public function edit_payment($id)
    {
        $this->data['page_title'] = '編輯付款方式';
        $this->data['payment'] = $this->mysql_model->_select('payment','payment_id',$id,'row');

        $this->render('setting/payment/edit');
    }

    public function update_payment($id)
    {
        $data = array(
            'payment_name' => $this->input->post('payment_name'),
            'updater_id'   => $this->ion_auth->user()->row()->id,
            'updated_at'   => date('Y-m-d H:i:s'),
        );
        $this->db->where('payment_id', $id);
        $this->db->update('payment', $data);

        redirect( base_url() . 'setting/payment');
    }

    public function delete_payment($id)
    {
        $this->db->where('payment_id', $id);
        $this->db->delete('payment');
        redirect( base_url() . 'setting/payment');
    }

    // 國家 ---------------------------------------------------------------------------------

    public function country()
    {
        $this->data['page_title'] = '國家';
        $this->data['country'] = $this->mysql_model->_select('country');

        $this->render('setting/country/index');
    }

    public function insert_country()
    {
        $this->data['page_title'] = '新增國家';

        $data = array(
            'country_code' => $this->input->post('country_code'),
            'country_name' => $this->input->post('country_name'),
            'creator_id'   => $this->ion_auth->user()->row()->id,
            'created_at'   => date('Y-m-d H:i:s'),
        );

        $this->db->insert('country', $data);
        redirect( base_url() . 'setting/country');
    }

    public function edit_country($id)
    {
        $this->data['page_title'] = '編輯國家';
        $this->data['country'] = $this->mysql_model->_select('country','country_id',$id,'row');

        $this->render('setting/country/edit');
    }

    public function update_country($id)
    {
        $data = array(
            'country_code' => $this->input->post('country_code'),
            'country_name' => $this->input->post('country_name'),
            'updater_id'   => $this->ion_auth->user()->row()->id,
            'updated_at'   => date('Y-m-d H:i:s'),
        );
        $this->db->where('country_id', $id);
        $this->db->update('country', $data);

        redirect( base_url() . 'setting/country');
    }

    public function delete_country($id)
    {
        $this->db->where('country_id', $id);
        $this->db->delete('country');
        redirect( base_url() . 'setting/country');
    }

    // 可訂購時段 ---------------------------------------------------------------------------------

    public function delivery_time()
    {
        $this->data['page_title'] = '可訂購時段';
        $this->data['delivery_time'] = $this->mysql_model->_select('delivery_time');

        $this->render('setting/delivery_time/index');
    }

    public function insert_delivery_time()
    {
        $this->data['page_title'] = '新增可訂購時段';

        $data = array(
            'delivery_time_name' => $this->input->post('delivery_time_name'),
            'creator_id'         => $this->ion_auth->user()->row()->id,
            'created_at'         => date('Y-m-d H:i:s'),
        );

        $this->db->insert('delivery_time', $data);
        redirect( base_url() . 'admin/setting/delivery_time');
    }

    public function edit_delivery_time($id)
    {
        $this->data['page_title'] = '編輯可訂購時段';
        $this->data['delivery_time'] = $this->mysql_model->_select('delivery_time','delivery_time_id',$id,'row');

        $this->render('setting/delivery_time/edit');
    }

    public function update_delivery_time($id)
    {
        $data = array(
            'delivery_time_name' => $this->input->post('delivery_time_name'),
            'updater_id'         => $this->ion_auth->user()->row()->id,
            'updated_at'         => date('Y-m-d H:i:s'),
        );
        $this->db->where('delivery_time_id', $id);
        $this->db->update('delivery_time', $data);

        redirect( base_url() . 'admin/setting/delivery_time');
    }

    public function delete_delivery_time($id)
    {
        $this->db->where('delivery_time_id', $id);
        $this->db->delete('delivery_time');
        redirect( base_url() . 'admin/setting/delivery_time');
    }

}