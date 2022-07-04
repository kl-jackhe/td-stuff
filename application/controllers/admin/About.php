<?php defined('BASEPATH') OR exit('No direct script access allowed');

class About extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function brand()
    {
        $this->data['page_title'] = '編輯品牌故事';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','brand','row');
        $this->render('admin/about/brand');
    }

    public function update_brand()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'brand');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '品牌故事編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function history()
    {
        $this->data['page_title'] = '編輯創業故事';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','history','row');
        $this->render('admin/about/history');
    }

    public function update_history()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'history');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '創業故事編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function team()
    {
        $this->data['page_title'] = '編輯車隊介紹';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','team','row');
        $this->render('admin/about/team');
    }

    public function update_team()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'team');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '車隊介紹編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function cross_industry_alliance()
    {
        $this->data['page_title'] = '編輯異業合作';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','cross_industry_alliance','row');
        $this->render('admin/about/cross_industry_alliance');
    }

    public function update_cross_industry_alliance()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'cross_industry_alliance');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '異業合作編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function shop_alliance()
    {
        $this->data['page_title'] = '編輯店家合作';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','shop_alliance','row');
        $this->render('admin/about/shop_alliance');
    }

    public function update_shop_alliance()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'shop_alliance');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '店家合作編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function how_to_buy()
    {
        $this->data['page_title'] = '編輯收費方式';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','how_to_buy','row');
        $this->render('admin/about/how_to_buy');
    }

    public function update_how_to_buy()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => '',
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'how_to_buy');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '收費方式編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function privacy_policy()
    {
        $this->data['page_title'] = '編輯隱私權保護政策';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','privacy_policy','row');
        $this->render('admin/about/privacy_policy');
    }

    public function update_privacy_policy()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'privacy_policy');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '隱私權保護政策編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function rule()
    {
        $this->data['page_title'] = '編輯使用條款與條件';
        $this->data['data'] = $this->mysql_model->_select('about','about_target','rule','row');
        $this->render('admin/about/rule');
    }

    public function update_rule()
    {
        $data = array(
            'about_content' => $this->input->post('about_content'),
            'about_image'   => $this->input->post('about_image'),
            'updater_id'    => $this->ion_auth->user()->row()->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('about_target', 'rule');
        $this->db->update('about', $data);
        $this->session->set_flashdata('message', '使用條款與條件編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('driver_id', $id);
        $this->db->delete('driver');
        $this->session->set_flashdata('message', '司機刪除成功！');
        redirect( base_url() . 'driver');
    }

}