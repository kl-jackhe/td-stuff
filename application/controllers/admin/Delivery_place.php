<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_place extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('delivery_place_model');
    }

    public function index()
    {
        $this->data['page_title'] = '取餐點';

        $data = array();
        //total rows count
        $totalRec = count($this->delivery_place_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/delivery_place/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['delivery_place'] = $this->delivery_place_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/delivery_place/index');
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
        $totalRec = count($this->delivery_place_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/delivery_place/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['delivery_place'] = $this->delivery_place_model->getRows($conditions);
        //load the view
        $this->load->view('admin/delivery_place/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增取餐點';
        $this->render('admin/delivery_place/create');
    }

    public function insert()
    {
        // 地址取得經緯度
        $address = $this->input->post('county').$this->input->post('district').$this->input->post('address');
        if(get_coordinates($address)!=false){
            $latlng = get_coordinates($address);
            $geo_lat = $latlng['lat'];
            $geo_lng = $latlng['lng'];
        } else {
            $geo_lat = 0;
            $geo_lng = 0;
        }
        // End 地址取得經緯度

        $data = array(
            'delivery_place_name'     => $this->input->post('delivery_place_name'),
            'delivery_place_county'   => $this->input->post('county'),
            'delivery_place_district' => $this->input->post('district'),
            'delivery_place_address'  => $this->input->post('address'),
            'delivery_place_lat'      => $geo_lat,
            'delivery_place_lng'      => $geo_lng,
            'creator_id'              => $this->ion_auth->user()->row()->id,
            'created_at'              => date('Y-m-d H:i:s'),
        );

        $this->db->insert('delivery_place', $data);
        $this->session->set_flashdata('message', '取餐點建立成功！');
        redirect( base_url() . 'admin/delivery_place');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯取餐點';
        $this->data['delivery_place'] = $this->mysql_model->_select('delivery_place','delivery_place_id',$id,'row');
        $this->render('admin/delivery_place/edit');
    }

    public function update($id)
    {
        // 地址取得經緯度
        $address = $this->input->post('county').$this->input->post('district').$this->input->post('address');
        if(get_coordinates($address)!=false){
            $latlng = get_coordinates($address);
            $geo_lat = $latlng['lat'];
            $geo_lng = $latlng['lng'];
        } else {
            $geo_lat = 0;
            $geo_lng = 0;
        }
        // End 地址取得經緯度

        $data = array(
            'delivery_place_name'     => $this->input->post('delivery_place_name'),
            'delivery_place_county'   => $this->input->post('county'),
            'delivery_place_district' => $this->input->post('district'),
            'delivery_place_address'  => $this->input->post('address'),
            'delivery_place_lat'      => $geo_lat,
            'delivery_place_lng'      => $geo_lng,
            'updater_id'              => $this->ion_auth->user()->row()->id,
            'updated_at'              => date('Y-m-d H:i:s'),
        );

        $this->db->where('delivery_place_id', $id);
        $this->db->update('delivery_place', $data);
        $this->session->set_flashdata('message', '取餐點編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('delivery_place_id', $id);
        $this->db->delete('delivery_place');
        $this->session->set_flashdata('message', '取餐點刪除成功！');
        redirect( base_url() . 'admin/delivery_place');
    }

}