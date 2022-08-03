<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Public_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '購物車';
		$this->render('checkout/cart');
	}

	public function mini_cart() {
		$this->load->view('checkout/mini-cart');
	}

	function add_combine() {
		$combine_id = $this->input->post('combine_id');
		$qty = $this->input->post('qty');

		$this_product_combine = $this->mysql_model->_select('product_combine', 'id', $combine_id, 'row');
		$this_product = $this->mysql_model->_select('product', 'product_id ', $this_product_combine['product_id'], 'row');

		$name = $this_product['product_name'] . ' - ' . $this_product_combine['name'];
		$price = $this_product_combine['current_price'];
		$image = '';
		// if($this_product['product_image']!=''){
		// 	$image = $this_product['product_image'];
		// }
		// if($this_product_combine['picture']!=''){
		// 	$image = $this_product_combine['picture'];
		// }

		$insert_data = array(
			'product_id' => $this_product_combine['product_id'],
			'id' => $this_product_combine['id'],
			'name' => $name,
			'price' => $price,
			'qty' => $qty,
			// 'image' => $image,
			'options' => array(
				'time' => get_random_string(15),
			),
		);
		echo $price;
		$rowid = $this->cart->insert($insert_data);
		if ($rowid) {
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

	/////////////////////////////////////////

	public function view() {
		$array = $this->cart->contents();
		header('Content-Type: application/json');
		echo json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		exit;
	}

}