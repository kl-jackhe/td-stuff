<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_tag extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('product_tag_model');
		// $language_list = array();
		// $language = get_setting_general_real('language');
        // $language_second = get_setting_general_real('language_second');
        // $language_third = get_setting_general_real('language_third');
        // if ($language != '') {
        //     $language_list[] = $language;
        // }
        // if ($language_second != '') {
        //     $language_list[] = $language_second;
        // }
        // if ($language_third != '') {
        //     $language_list[] = $language_third;
        // }
        // $this->data['language_list'] = $language_list;
        $this->data['product'] = $this->product_model->getProductList();
		$this->data['product_category'] = $this->product_model->get_product_category();
	}

	function index() {
		$this->data['page_title'] = $this->lang->line('product_tag_manage');
		$this->render('product_tag/index');
	}

	function ajaxData() {
		$conditions = array();
		$page = $this->input->get('page');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}
		$conditions['search']['sortBy'] = $this->input->get('sortBy');
		$conditions['search']['status'] = $this->input->get('status');
		$totalRec = $this->product_tag_model->getRowsCount($conditions);
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'product_tag/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = 100;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		$conditions['start'] = $offset;
		$conditions['limit'] = 100;
		$this->data['Product_tag'] = $this->product_tag_model->getRows($conditions);
		$this->load->view('product_tag/ajax-data', $this->data, false);
	}

	// function createProductTag() {
	// 	if ($this->checkProductTagNameIsRepeat() == 'is_empty') {
	// 		$this->db->insert('Product_tag', array('sort' => $this->input->post('sort')));
	//         if ($this->db->affected_rows() > 0) {
	//             $insert_id = $this->db->insert_id();
	//             if ($insert_id > 0) {
	//             	foreach ($this->input->post('lang_name_array') as $value) {
	// 					$insertData = array(
	// 	                	'product_tag_id' => $insert_id,
	// 	                    'lang' => $value['lang'],
	// 	                    'name' => $value['name'],
	// 	                );
	// 	                $this->db->insert('product_tag_lang', $insertData);
	// 				}
	// 				update_menu_version();
	//             }
	//         }
	//         echo "yes";
	// 	} else {
	// 		echo "no";
	// 	}
	// }

	// function checkProductTagNameIsRepeat($product_tag_id=0,$lang='',$name='') {
	// 	$this->db->select('id');
	// 	$this->db->where('lang',$lang);
	// 	if ($product_tag_id > 0) {
	// 		$this->db->where('product_tag_id !=',$product_tag_id);
	// 		$this->db->where('name',$name);
	// 	} else {
	// 		$this->db->where_in('name',$this->input->post('name_array'));
	// 	}
	// 	$this->db->limit(1);
	// 	$row = $this->db->get('product_tag_lang')->row_array();
	// 	return (!empty($row)?'not_empty':'is_empty');
	// }

	// function getProductTagLangDetail($id) {
	// 	$this->db->select('id,product_tag_id,name,lang');
	// 	$this->db->where('product_tag_id',$id);
	// 	$query = $this->db->get('product_tag_lang')->result_array();
	// 	echo json_encode($query);
	// }

	// function updateProductTag() {
	// 	$isRepeatStr = '';
	// 	$this->db->where('id',$this->input->post('id'));
	// 	$this->db->update('Product_tag',array('sort' => $this->input->post('sort')));
	// 	$this->deleteProductTagNotName($this->input->post('id'),$this->input->post('lang_name_array'));
	// 	foreach ($this->input->post('lang_name_array') as $value) {
	// 		$data = array(
    //         	'product_tag_id' => $this->input->post('id'),
    //             'lang' => $value['lang'],
    //             'name' => $value['name'],
    //             ($value['lang_id'] == 0 ? 'created_at' : 'updated_at') => date('Y-m-d H:i:s'),
    //         );
    //         if ($this->checkProductTagNameIsRepeat($this->input->post('id'),$value['lang'],$value['name']) == 'is_empty') {
	//             if ($this->checkProductTagLangList($this->input->post('id'),$value['lang']) == 'is_empty' && $value['lang_id'] == 0) {
	// 				$this->db->insert('product_tag_lang', $data);
	// 			} else {
	// 				$this->db->where('id',$value['lang_id']);
    //         		$this->db->update('product_tag_lang',$data);
	// 			}
	// 			update_menu_version();
	// 		} else {
	// 			$isRepeatStr .= $this->lang->line($value['lang']) . ' - ' . $value['name'] . ' ' . $this->lang->line('duplicate_name') . ', ';
	// 		}
	// 	}
	// 	echo $isRepeatStr;
	// }

	// function deleteProductTagNotName($product_tag_id,$lang_name_array) {
    //     $productTagLangId = array();
    //     foreach ($lang_name_array as $value) {
    //         $productTagLangId[] = $value['lang_id'];
    //     }
    //     if (!empty($productTagLangId)) {
    //     	$this->db->where('product_tag_id',$product_tag_id);
    //         $this->db->where_not_in('id',$productTagLangId);
    //         $this->db->delete('product_tag_lang');
    //         update_menu_version();
    //     }
    // }

	// function checkProductTagLangList($product_tag_id,$lang) {
	// 	$this->db->select('id');
	// 	$this->db->where('product_tag_id',$product_tag_id);
	// 	$this->db->where('lang',$lang);
	// 	$this->db->limit(1);
	// 	$row = $this->db->get('product_tag_lang')->row_array();
	// 	return (!empty($row)?'not_empty':'is_empty');
	// }

	// function updateProductTagContent() {
	// 	if (!empty($this->input->post('product_list'))) {
	// 		$this->db->where('product_tag_id',$this->input->post('id'));
	// 		$this->db->where_not_in('product_id',$this->input->post('product_list'));
	// 		$this->db->delete('product_tag_content');
	// 		foreach ($this->input->post('product_list') as $pl_row) {
	// 			$data = array(
	// 				'product_tag_id' => $this->input->post('id'),
	// 				'product_id' => $pl_row,
	// 			);
	// 			$this->db->select('id,product_tag_id,product_id');
	// 			$this->db->where('product_tag_id',$this->input->post('id'));
	// 			$this->db->where('product_id',$pl_row);
	// 			$this->db->limit(1);
	// 			$ptc_row = $this->db->get('product_tag_content')->row_array();
	// 			if (empty($ptc_row)) {
	// 				$this->db->insert('product_tag_content',$data);
	// 			}
	// 		}
	// 	} else {
	// 		$this->db->where('product_tag_id',$this->input->post('id'));
	// 		$this->db->delete('product_tag_content');
	// 	}
	// 	update_menu_version();
	// }

    // function getProductList($product_tag_id) {
    // 	$product_list = array();
    // 	$this->db->select('product_id');
    // 	$this->db->where('product_status', '1');
    // 	$p_query = $this->db->get('product')->result_array();
    // 	if (!empty($p_query)) {
    // 		foreach ($p_query as $p_row) {
    // 			$product_list[] = array(
    // 				'product_id' => $p_row['product_id'],
    // 				'product_name' => get_lang('product_name', $p_row['product_id'], $this->language),
    // 				'selected' => (!empty($this->product_tag_model->getProductTagContentSelectList($product_tag_id,$p_row['product_id'])) ? '1' : '0')
    // 			);
    // 		}
    // 	}
    // 	echo json_encode((!empty($product_list) ? $product_list : false));
    // }

	// function updateProductTagStatus() {
	// 	$this->db->where('id',$this->input->post('id'));
	// 	$this->db->update('Product_tag', array('status' => ($this->input->post('status') == 1 ? false : true )));
	// 	update_menu_version();
	// }

	// function removeSingleProductTag() {
	// 	$this->db->where('id',$this->input->post('id'));
	// 	$this->db->delete('Product_tag');
	// 	$this->db->where('product_tag_id',$this->input->post('id'));
	// 	$this->db->delete('product_tag_content');
	// 	$this->db->where('product_tag_id',$this->input->post('id'));
	// 	$this->db->delete('product_tag_lang');
	// 	update_menu_version();
	// }
}