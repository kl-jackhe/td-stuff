<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('banner_model');
	}

	public function index() {
		$this->data['page_title'] = 'Banner';

		$data = array();
		//total rows count
		$totalRec = 0;
		if ($this->banner_model->getRows() != false) {
			$totalRec = count($this->banner_model->getRows());
		}
		//pagination configuration
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'admin/banner/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination_admin->initialize($config);
		//get the posts data
		$this->data['banner'] = $this->banner_model->getRows(array('limit' => $this->perPage));

		$this->render('admin/banner/index');
	}

	function ajaxData() {
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
		if (!empty($status)) {
			$conditions['search']['status'] = $status;
		}
		//total rows count
		$totalRec = 0;
		if ($this->banner_model->getRows() != false) {
			$totalRec = count($this->banner_model->getRows());
		}
		//pagination configuration
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'admin/banner/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination_admin->initialize($config);
		//set start and limit
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		//get posts data
		$this->data['banner'] = $this->banner_model->getRows($conditions);
		//load the view
		$this->load->view('admin/banner/ajax-data', $this->data, false);
	}

	public function create() {
		$this->data['page_title'] = '新增Banner';
		$this->render('admin/banner/create');
	}

	public function insert() {
		if (empty($this->input->post('banner_image'))) {
			$image = 'no-image.jpg';
		} else {
			$image = $this->input->post('banner_image');
		}
		$data = array(
			'banner_name' => $this->input->post('banner_name'),
			'banner_on_the_shelf' => $this->input->post('banner_on_the_shelf'),
			'banner_off_the_shelf' => $this->input->post('banner_off_the_shelf'),
			'banner_image' => $image,
			'banner_link' => $this->input->post('banner_link'),
			'banner_sort' => $this->input->post('banner_sort'),
			'banner_status' => $this->input->post('banner_status'),
			'creator_id' => $this->ion_auth->user()->row()->id,
			'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('banner', $data);
		$this->session->set_flashdata('message', 'Banner建立成功！');
		redirect(base_url() . 'admin/banner');
	}

	public function edit($id) {
		$this->data['page_title'] = '編輯Banner';
		$this->data['banner'] = $this->mysql_model->_select('banner', 'banner_id', $id, 'row');
		$this->render('admin/banner/edit');
	}

	public function update($id) {
		if (empty($this->input->post('banner_image'))) {
			$image = 'no-image.jpg';
		} else {
			$image = $this->input->post('banner_image');
		}
		$data = array(
			'banner_name' => $this->input->post('banner_name'),
			'banner_on_the_shelf' => $this->input->post('banner_on_the_shelf'),
			'banner_off_the_shelf' => $this->input->post('banner_off_the_shelf'),
			'banner_image' => $image,
			'banner_link' => $this->input->post('banner_link'),
			'banner_sort' => $this->input->post('banner_sort'),
			'banner_status' => $this->input->post('banner_status'),
			'updater_id' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where('banner_id', $id);
		$this->db->update('banner', $data);
		$this->session->set_flashdata('message', 'Banner編輯成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete($id) {
		$this->db->where('banner_id', $id);
		$this->db->delete('banner');
		$this->session->set_flashdata('message', 'Banner刪除成功！');
		redirect(base_url() . 'admin/banner');
	}

	public function multiple_action() {
		if (!empty($this->input->post('banner_id'))) {
			foreach ($this->input->post('banner_id') as $banner_id) {
				if ($this->input->post('action') == 'delete') {
					$this->db->where('banner_id', $banner_id);
					$this->db->delete('banner');
					$this->session->set_flashdata('message', 'Banner刪除成功！');
				} elseif ($this->input->post('action') == 'on_the_shelf') {
					$data = array(
						'banner_status' => '1',
					);
					$this->db->where('banner_id', $banner_id);
					$this->db->update('banner', $data);
					$this->session->set_flashdata('message', 'Banner上架成功！');
				} elseif ($this->input->post('action') == 'go_off_the_shelf') {
					$data = array(
						'banner_status' => '2',
					);
					$this->db->where('banner_id', $banner_id);
					$this->db->update('banner', $data);
					$this->session->set_flashdata('message', 'Banner下架成功！');
				}
			}
		}
		redirect(base_url() . 'admin/banner');
	}

}