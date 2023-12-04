<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('posts_model');
	}

	public function index()
    {
        $this->data['page_title'] = '最新訊息';

        $data = array();
        //total rows count
        $totalRec = count($this->posts_model->getPosts());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'posts/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 5;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //get the posts data
        $this->data['posts'] = $this->posts_model->getPosts(array('limit'=>5));
        $this->data['posts_category'] = $this->posts_model->getPostCategoryId();

        $this->render('posts/index');
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
        //total rows count
        $totalRec = count($this->posts_model->getPosts($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'posts/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 5;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = 5;
        //get posts data
        $this->data['posts'] = $this->posts_model->getPosts($conditions);
        //load the view
        $this->load->view('posts/ajax-data', $this->data, false);
    }

	public function view($id)
	{
		$this->data['post'] = $this->mysql_model->_select('posts','post_id', $id, 'row');
		$this->render('posts/view');
	}

}