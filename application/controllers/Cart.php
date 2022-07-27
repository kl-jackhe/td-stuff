<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Public_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('home_model');
	}

	public function index() {
		$this->data['page_title'] = '購物車';
		$this->render('checkout/cart');
	}

	public function mini_cart()
	{
		$this->load->view('checkout/mini-cart');
	}

	public function add() {
		$price = get_product_price($this->input->post('id'));
		$insert_data = array(
			'id' => $this->input->post('id'),
			'name' => get_product_name($this->input->post('id')),
			'price' => $price,
			'qty' => $this->input->post('qty'),
		);
		$rowid = $this->cart->insert($insert_data);
		// $data = array(
		// 	'coupon_id' => '0',
		// 	'coupon_code' => '0',
		// 	'coupon_method' => '',
		// 	'coupon_price' => '0',
		// );
		// $this->session->set_userdata($data);
		// $price = 0;
		// if (get_setting_general('is_food_discount') == '1' && !empty(get_setting_general('food_discount_number') && get_setting_general('food_discount_number') != '0')) {
		// 	$price = (get_setting_general('food_discount_number') / 10) * get_product_price($this->input->post('id'));
		// } else {
		// 	$price = get_product_price($this->input->post('id'));
		// }

		// // 判斷這個商品是否有在購物車了
		// if (!empty($this->cart->contents())) {
		// 	// $do=0;
		// 	$rowid = '';
		// 	$product_id = '';
		// 	foreach ($this->cart->contents() as $items) {
		// 		// 有的話，更新數量
		// 		if ($items["id"] == $this->input->post('id')) {
		// 			// $update_data = array(
		// 			//     'rowid' => $items["rowid"],
		// 			//     'qty'   => $this->input->post('qty')
		// 			// );
		// 			// $rowid = $this->cart->update($update_data);
		// 			// $do++;
		// 			$rowid = $items["rowid"];
		// 			$product_id = $items["id"];
		// 			// 沒有的話，新增到購物車
		// 		} else {
		// 			// if($do==0){
		// 			//     $insert_data = array(
		// 			//         'id'    => $this->input->post('id'),
		// 			//         'name'  => get_product_name($this->input->post('id')),
		// 			//         'price' => $price,
		// 			//         'qty'   => $this->input->post('qty'),
		// 			//         'store_order_time' => $this->input->post('store_order_time'),
		// 			//     );
		// 			//     $rowid = $this->cart->insert($insert_data);
		// 			// }
		// 		}
		// 	}

		// 	if ($rowid != '') {
		// 		$update_data = array(
		// 			'rowid' => $rowid,
		// 			'qty' => $this->input->post('qty'),
		// 		);
		// 		$rowid = $this->cart->update($update_data);
		// 	} else {
		// 		$insert_data = array(
		// 			'id' => $this->input->post('id'),
		// 			'name' => get_product_name($this->input->post('id')),
		// 			'price' => $price,
		// 			'qty' => $this->input->post('qty'),
		// 			// 'store_order_time' => $this->input->post('store_order_time'),
		// 		);
		// 		$rowid = $this->cart->insert($insert_data);
		// 	}
		// } else {
		// 	$insert_data = array(
		// 		'id' => $this->input->post('id'),
		// 		'name' => get_product_name($this->input->post('id')),
		// 		'price' => $price,
		// 		'qty' => $this->input->post('qty'),
		// 	);
		// 	$rowid = $this->cart->insert($insert_data);
		// }

		// $insert_data = array(
		//     'id'    => $this->input->post('id'),
		//     'name'  => get_product_name($this->input->post('id')),
		//     'price' => $price,
		//     'qty'   => $this->input->post('qty'),
		//     'store_order_time' => $this->input->post('store_order_time'),
		// );
		// $rowid = $this->cart->insert($insert_data);

		// 判斷是否有超過每人限購數量
		// $aaa = 0;
		// foreach ($this->cart->contents() as $items) {
		// 	if ($items["id"] == $this->input->post('id')) {
		// 		$product_person_buy = get_product_person_buy($this->input->post('store_order_time_id'), $items["id"]);
		// 		if ($items["qty"] > $product_person_buy) {
		// 			$data = array(
		// 				'rowid' => $items["rowid"],
		// 				'qty' => $product_person_buy,
		// 			);
		// 			$this->cart->update($data);
		// 			$aaa += $product_person_buy;
		// 		} else {
		// 			//
		// 			$aaa += $this->input->post('qty');
		// 		}
		// 	}
		// }
		// echo $aaa;
	}

	function add_combine() {
		$combine_id = $this->input->post('combine_id');
		$qty = $this->input->post('qty');

		$this_product_combine = $this->mysql_model->_select('product_combine', 'id', $combine_id, 'row');
		$this_product = $this->mysql_model->_select('product', 'product_id ', $this_product_combine['product_id'], 'row');

		$name = $this_product['product_name'] .' - '. $this_product_combine['name'];
		$price = $this_product_combine['current_price'];
		$image = '';
		if($this_product['product_image']!=''){
			$image = $this_product['product_image'];
		}
		if($this_product_combine['picture']!=''){
			$image = $this_product_combine['picture'];
		}

		$insert_data = array(
			'id' => $this_product_combine['id'],
			'name' => $name,
			'price' => $price,
			'qty' => $qty,
			'image' => $image,
			'options' => array(
                'time' => get_random_string(15),
            )
		);
		echo $price;
		$rowid = $this->cart->insert($insert_data);
		if($rowid){
			return true;
		} else {
			return false;
		}
	}

	public function update_qty() {
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'qty' => $this->input->post('qty'),
		);
		$this->cart->update($data);
	}

	public function update_price() {
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'price' => $this->input->post('price'),
		);
		$this->cart->update($data);
	}

	public function remove() {
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	public function remove_all() {
		$this->cart->destroy();
	}

	public function check_cart_is_empty() {
		$count = 0;
		if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $items) {
				$count++;
			}
		}
		echo $count;
	}

}