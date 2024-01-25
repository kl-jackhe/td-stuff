<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posts extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['page_title'] = '最新訊息';

        $data = array();
        //total rows count
        $totalRec = count($this->posts_model->getPosts());
        //pagination configuration
        $config['target']      = '#data';
        $config['base_url']    = base_url() . 'posts/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 5;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //get the posts data
        $this->data['posts'] = $this->posts_model->getPosts(array('limit' => 5));

        if ($this->is_liqun_food || $this->is_td_stuff) {
            $this->data['posts_category'] = $this->posts_model->getPostCategoryId();
            $this->render('posts/index');
        }
        if ($this->is_partnertoys) {
            $this->data['posts_category'] = $this->menu_model->getSubMenuData(0, 3);
            $this->render('posts/partnertoys/partnertoys_index');
        }
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
        $post_category_id = $this->input->get('post_category_id');
        if (!empty($post_category_id)) {
            $conditions['search']['post_category_id'] = $post_category_id;
        }
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->posts_model->getPosts($conditions);
        //pagination configuration
        $config['target'] = '#data';
        $config['base_url'] = base_url() . 'posts/ajaxData';
        // $config['total_rows']  = $totalRec;
        // $config['per_page']    = 5;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $conditions['returnType'] = '';
        $this->data['posts'] = $this->posts_model->getPosts($conditions);
        //load the view
        $this->load->view('posts/ajax-data', $this->data, false);
    }

    public function view($id)
    {
        if ($id == 0) {
            redirect(base_url() . 'posts');
        }
        $this->data['post'] = $this->mysql_model->_select('posts', 'post_id', $id, 'row');
        $this->render('posts/view');
    }
}
