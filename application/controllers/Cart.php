<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['page_title'] = '購物車';
		$this->render('checkout/cart');
	}

	public function mini_cart()
	{
		$this->load->view('checkout/mini-cart');
	}

	function add_combine()
	{
		$i = 0;

		// echo '<pre>';
		// print_r($this->cart->contents(true));
		// echo '</pre>';

		$specification_name = $this->input->post('specification_name');
		$specification_qty = $this->input->post('specification_qty');
		$specification_id = $this->input->post('specification_id');

		$combine_id = $this->input->post('combine_id');
		$qty = $this->input->post('qty');

		$this_product_combine = $this->mysql_model->_select('product_combine', 'id', $combine_id, 'row');
		$this_product = $this->mysql_model->_select('product', 'product_id ', $this_product_combine['product_id'], 'row');
		$this_contradiction = $this->mysql_model->_select('contradiction', 'name', 'product', 'row');

		if ($this->is_partnertoys) {
			if ($this_contradiction['contradiction_status'] == 1) {
				if (!empty($this->cart->contents(true)) && $this->cart->total_items() > 0) {
					$cart_item = $this->cart->contents(true);
					foreach ($cart_item as $self) {
						if (($self['product_category_id'] == '1' && $this_product['product_category_id'] != '1') || ($self['product_category_id'] != '1' && $this_product['product_category_id'] == '1')) {
							echo 'contradiction';
							return;
						}
					}
				}
			}
		}

		$name = $this_product['product_name'] . ' - ' . $this_product_combine['name'];
		$price = $this_product_combine['current_price'];
		if (!empty($specification_qty)) {
			foreach ($specification_qty as $row) {
				if ($row != 0) {
					$specification_name_array[] = $specification_name[$i];
					$specification_id_array[] = $specification_id[$i];
					$specification_qty_array[] = $row;
				}
				$i++;
			}
		}
		$insert_data = array(
			'product_id' => $this_product_combine['product_id'],
			'product_category_id' => $this_product['product_category_id'],
			'id' => $this_product_combine['id'],
			'name' => $name,
			'price' => $price,
			'qty' => $qty,
			'specification' => array(
				'specification_name' => $specification_name_array,
				'specification_id' => $specification_id_array,
				'specification_qty' => $specification_qty_array,
			),
			'image' => $this_product_combine['picture'],
			'options' => array(
				'time' => get_random_string(15),
			),
		);
		$rowid = $this->cart->insert($insert_data);
		if ($rowid) {
			return true;
		} else {
			return false;
		}
	}

	function add_single_sales_combine()
	{
		$i = 0;
		$specification_name = $this->input->post('specification_name');
		$specification_qty = $this->input->post('specification_qty');
		$specification_id = $this->input->post('specification_id');

		$combine_id = $this->input->post('combine_id');
		$qty = $this->input->post('qty');

		$this_product_combine = $this->mysql_model->_select('single_product_combine', 'id', $combine_id, 'row');
		$this_product = $this->mysql_model->_select('product', 'product_id ', $this_product_combine['product_id'], 'row');

		$name = $this_product['product_name'] . ' - ' . $this_product_combine['name'];
		$price = $this_product_combine['current_price'];
		if (!empty($specification_qty)) {
			foreach ($specification_qty as $row) {
				if ($row != 0) {
					$specification_name_array[] = $specification_name[$i];
					$specification_id_array[] = $specification_id[$i];
					$specification_qty_array[] = $row;
				}
				$i++;
			}
		}
		$insert_data = array(
			'product_id' => $this_product_combine['product_id'],
			'id' => $this_product_combine['id'],
			'name' => $name,
			'price' => $price,
			'qty' => $qty,
			'specification' => array(
				'specification_name' => $specification_name_array,
				'specification_id' => $specification_id_array,
				'specification_qty' => $specification_qty_array,
			),
			'image' => $this_product_combine['picture'],
			'options' => array(
				'time' => get_random_string(15),
			),
		);
		$rowid = $this->cart->insert($insert_data);
		if ($rowid) {
			return true;
		} else {
			return false;
		}
	}

	public function update_qty()
	{
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'qty' => $this->input->post('qty'),
		);
		$this->cart->update($data);
	}

	public function update_price()
	{
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'price' => $this->input->post('price'),
		);
		$this->cart->update($data);
	}

	public function remove()
	{
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	public function remove_all()
	{
		$this->cart->destroy();
	}

	public function check_cart_is_empty()
	{
		$count = 0;
		if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $items) {
				$count++;
			}
		}
		echo $count;
	}

	/////////////////////////////////////////

	public function view()
	{
		$array = $this->cart->contents();
		header('Content-Type: application/json');
		echo json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		exit;
	}
}
