<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meal_time extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('meal_time_model');
    }

    public function index()
    {
        $this->data['page_title'] = '用餐時段';

        $data = array();
        //total rows count
        $totalRec = count($this->meal_time_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/meal_time/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['meal_time'] = $this->meal_time_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/meal_time/index');
    }

    function ajaxData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        //set conditions for search
        // $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        // $category = $this->input->get('category');
        // $status = $this->input->get('status');
        $county = $this->input->get('county');
        $district = $this->input->get('district');
        // if(!empty($keywords)){
        //     $conditions['search']['keywords'] = $keywords;
        // }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        // if(!empty($category)){
        //     $conditions['search']['category'] = $category;
        // }
        // if(!empty($status)){
        //     $conditions['search']['status'] = $status;
        // }
        if(!empty($county)){
            $conditions['search']['county'] = $county;
        }
        if(!empty($district)){
            $conditions['search']['district'] = $district;
        }
        //total rows count
        $totalRec = count($this->meal_time_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/meal_time/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['meal_time'] = $this->meal_time_model->getRows($conditions);
        //load the view
        $this->load->view('admin/meal_time/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增用餐時段';
        $this->render('admin/meal_time/create');
    }

    public function insert()
    {
        $data = array(
            'meal_time_type'          => $this->input->post('meal_time_type'),
            'meal_time_content_start' => $this->input->post('meal_time_content_start'),
            'meal_time_content_end'   => $this->input->post('meal_time_content_end'),
            'creator_id'              => $this->ion_auth->user()->row()->id,
            'created_at'              => date('Y-m-d H:i:s'),
        );

        $this->db->insert('meal_time', $data);
        $this->session->set_flashdata('message', '用餐時段建立成功！');
        redirect( base_url() . 'admin/meal_time');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯用餐時段';
        $this->data['meal_time'] = $this->mysql_model->_select('meal_time','meal_time_id',$id,'row');
        $this->render('admin/meal_time/edit');
    }

    public function update($id)
    {
        $data = array(
            'meal_time_type'          => $this->input->post('meal_time_type'),
            'meal_time_content_start' => $this->input->post('meal_time_content_start'),
            'meal_time_content_end'   => $this->input->post('meal_time_content_end'),
            'updater_id'              => $this->ion_auth->user()->row()->id,
            'updated_at'              => date('Y-m-d H:i:s'),
        );

        $this->db->where('meal_time_id', $id);
        $this->db->update('meal_time', $data);
        $this->session->set_flashdata('message', '用餐時段編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('meal_time_id', $id);
        $this->db->delete('meal_time');
        $this->session->set_flashdata('message', '用餐時段刪除成功！');
        redirect( base_url() . 'admin/meal_time');
    }

}