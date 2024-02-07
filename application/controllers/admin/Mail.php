<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mail extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mail_model');
    }

    function index()
    {
        $this->data['page_title'] = '郵件管理';

        $data = array();
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->mail_model->getRows($conditions);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/mail/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the mail data
        $conditions['returnType'] = '';
        $this->data['mails'] = $this->mail_model->getRows(array('limit' => $this->perPage));

        $this->render('admin/mail/index');
    }

    function ajaxData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->get('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($sortBy)) {
            $conditions['search']['sortBy'] = $sortBy;
        }
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->mail_model->getRows($conditions);
        //pagination configuration
        $config['target'] = '#datatable';
        $config['base_url'] = base_url() . 'admin/mail/ajaxData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get mail data
        $conditions['returnType'] = '';
        $this->data['mails'] = $this->mail_model->getRows($conditions);
        //load the view
        $this->load->view('admin/mail/ajax-data', $this->data);
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('contid'))) {
            foreach ($this->input->post('contid') as $contid) {
                if ($this->input->post('action') == 'delete') {
                    $this->db->where('contid', $contid);
                    $this->db->delete('contact');
                    $this->session->set_flashdata('message', '刪除成功！');
                }
            }
        }
        redirect(base_url() . 'admin/mail');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '回覆郵件';
        $this->data['mail'] = $this->mysql_model->_select('contact', 'contid', $id, 'row');
        $this->render('admin/mail/edit');
    }

    public function update($id)
    {
        $data = array(
            'desc2'         => $this->input->post('desc2'),
            'state'         => 1,
            'state_member'  => 0,
            'datetime2'     => date('Y-m-d H:i:s'),
        );

        $this->db->where('contid', $id);
        $this->db->update('contact', $data);

        $this->session->set_flashdata('message', '回覆成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('contid', $id);
        $this->db->delete('contact');
        $this->session->set_flashdata('message', '刪除成功！');

        redirect(base_url() . 'admin/mail');
    }
}
