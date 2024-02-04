<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posts extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('posts_model');
        $this->load->model('menu_model');
    }

    public function index()
    {
        $this->data['page_title'] = '最新消息';

        $data = array();
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->posts_model->getRows($conditions);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/posts/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['category'] = $this->mysql_model->_select('post_category');
        $conditions['returnType'] = '';
        $this->data['posts'] = $this->posts_model->getRows(array('limit' => $this->perPage));

        $this->render('admin/posts/index');
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
        $category = $this->input->get('category');
        $status = $this->input->get('status');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($sortBy)) {
            $conditions['search']['sortBy'] = $sortBy;
        }
        if (!empty($category)) {
            $conditions['search']['category'] = $category;
        }
        if(!empty($status)){
            $conditions['search']['status'] = $status;
        }
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->posts_model->getRows($conditions);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/posts/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $conditions['returnType'] = '';
        $this->data['posts'] = $this->posts_model->getRows($conditions);
		$this->data['post_category'] = $this->mysql_model->_select('post_category');
        //load the view
        $this->load->view('admin/posts/ajax-data', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = '新增文章';
        if ($this->is_partnertoys) {
            $this->data['category'] = $this->menu_model->getSubMenuData(0, 3);
        } else {
            $this->data['category'] = $this->mysql_model->_select('post_category');
        }
        $this->render('admin/posts/create');
    }

    public function insert()
    {
        $data = array(
            'post_category' => $this->input->post('post_category'),
            'post_title'    => $this->input->post('post_title'),
            'post_content'  => $this->input->post('post_content'),
            'post_image'    => $this->input->post('post_image'),
            'creator_id'    => $this->current_user->id,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->mysql_model->_insert('posts', $data);

        $this->session->set_flashdata('message', '文章建立成功！');
        redirect(base_url() . 'admin/posts');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯文章';
        if ($this->is_partnertoys) {
            $this->data['category'] = $this->menu_model->getSubMenuData(0, 3);
        } else {
            $this->data['category'] = $this->mysql_model->_select('post_category');
        }
        $this->data['post'] = $this->mysql_model->_select('posts', 'post_id', $id, 'row');
        $this->render('admin/posts/edit');
    }

    public function update($id)
    {
        $data = array(
            'post_category' => $this->input->post('post_category'),
            'post_title'    => $this->input->post('post_title'),
            'post_content'  => $this->input->post('post_content'),
            'post_image'    => $this->input->post('post_image'),
            'updater_id'    => $this->current_user->id,
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->where('post_id', $id);
        $this->db->update('posts', $data);

        $this->session->set_flashdata('message', '文章更新成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('post_id', $id);
        $this->db->delete('posts');

        redirect(base_url() . 'admin/posts');
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('post_id'))) {
            foreach ($this->input->post('post_id') as $post_id) {
                if ($this->input->post('action') == 'delete') {
                    $this->db->where('post_id', $post_id);
                    $this->db->delete('posts');
                    $this->session->set_flashdata('message', '文章刪除成功！');
                }
            }
        }
        redirect(base_url() . 'admin/posts');
    }

    // 文章分類 ---------------------------------------------------------------------------------

    public function category()
    {
        $this->data['page_title'] = '文章分類';
        $this->data['category'] = $this->mysql_model->_select('post_category');

        $this->render('admin/posts/category/index');
    }

    public function insert_category()
    {
        $this->data['page_title'] = '新增文章分類';

        $data = array(
            'post_category_name'      => $this->input->post('post_category_name'),
            'creator_id'              => $this->current_user->id,
            'created_at'              => date('Y-m-d H:i:s'),
        );

        $this->db->insert('post_category', $data);
        redirect(base_url() . 'admin/posts/category');
    }

    public function edit_category($id)
    {
        $this->data['page_title'] = '編輯文章分類';
        $this->data['category'] = $this->mysql_model->_select('post_category', 'post_category_id', $id, 'row');

        $this->render('admin/posts/category/edit');
    }

    public function update_category($id)
    {
        $data = array(
            'post_category_name'      => $this->input->post('post_category_name'),
            'updater_id'              => $this->current_user->id,
            'updated_at'              => date('Y-m-d H:i:s'),
        );
        $this->db->where('post_category_id', $id);
        $this->db->update('post_category', $data);

        redirect(base_url() . 'admin/posts/category');
    }

    public function delete_category($id)
    {
        $this->db->where('post_category_id', $id);
        $this->db->delete('post_category');

        redirect(base_url() . 'admin/posts/category');
    }
}
