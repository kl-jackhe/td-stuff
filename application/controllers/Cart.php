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
		$this->data['cargo_weight'] = 0;
		$this->load->view('checkout/mini-cart');
	}

	function add_combine()
	{
		$i = 0;

		// echo '<pre>';
		// print_r($this->cart->contents(true));
		// echo '</pre>';

		if ($this->is_partnertoys) {
			if (empty($this->session->userdata('user_id'))) {
				echo '
				<script>
					alert("請先登入後在進行操作");
					window.location.href = "' . base_url() . 'auth' . '"
				</script>';
			}
		}

		$specification_name = $this->input->post('specification_name');
		$specification_qty = $this->input->post('specification_qty');
		$specification_id = $this->input->post('specification_id');

		if ($this->input->method() == 'post') {
			$combine_id = $this->input->post('combine_id');
			$qty = $this->input->post('qty');
			$weight = $this->input->post('weight');
			$is_lottery = $this->input->post('is_lottery');
			$lottery_id = $this->input->post('lottery_id');
		} else {
			// 待加密
			$combine_id = $this->input->get('combine_id');
			$qty = $this->input->get('qty');
			$weight = $this->input->get('weight');
			$is_lottery = $this->input->get('is_lottery');
			$lottery_id = $this->input->get('lottery_id');
		}

		// echo '<pre>';
		// print_r($combine_id);
		// print_r($qty);
		// print_r($is_lottery);
		// print_r($lottery_id);
		// echo '</pre>';

		$this_product_combine = $this->mysql_model->_select('product_combine', 'id', $combine_id, 'row');
		$this_product = $this->mysql_model->_select('product', 'product_id ', $this_product_combine['product_id'], 'row');
		$this_contradiction_enable = $this->mysql_model->_select('contradiction', 'name', 'product', 'row');
		$this_contradiction_date = $this->mysql_model->_select('contradiction', 'name', 'booking_date', 'row');

		if ($is_lottery == true) {
			$this_lottery = $this->mysql_model->_select('lottery', 'id', $lottery_id, 'row');
			if ($this_lottery['draw_over'] != 1 || $this_lottery['lottery_end'] == 1) {
				if ($this->input->method() == 'post') {
					echo 'not lottery time';
				} else {
					echo '
					<script>
						alert("非活動期間");
						window.location.href = "' . base_url() . 'auth?id=3' . '";
					</script>';
				}
				return;
			}
			$this->db->where('lottery_id', $lottery_id);
			$this->db->where('users_id', $this->session->userdata('user_id'));
			$lottery_user = $this->db->get('lottery_pool')->row_array();
			if (!empty($lottery_user)) {
				if ($lottery_user['winner'] != 1 && $lottery_user['fill_up'] != 1) {
					if ($this->input->method() == 'post') {
						echo 'unlottery user';
					} else {
						echo '
						<script>
							alert("非中獎客戶，請注意是否為中獎帳號");
							window.location.href = "' . base_url() . 'auth?id=3' . '";
						</script>';
					}
					return;
				}
				if ($lottery_user['order_state'] == 'pay_ok') {
					if ($this->input->method() == 'post') {
						echo 'only one';
					} else {
						echo '
						<script>
							alert("抽選商品僅限購一次");
							window.location.href = "' . base_url() . 'auth?id=3' . '";
						</script>';
					}
					return;
				}
			} else {
				if ($this->input->method() == 'post') {
					echo 'unknown user';
				} else {
					echo '
					<script>
						alert("找不到使用者");
						window.location.href = "' . base_url() . 'auth?id=3' . '";
					</script>';
				}
				return;
			}
		}

		if ($this->is_partnertoys) {
			// 檢查預購商品是否與其他商品一起下
			if ($this_contradiction_enable['contradiction_status'] == 1) {
				if (!empty($this->cart->contents(true)) && $this->cart->total_items() > 0) {
					$cart_item = $this->cart->contents(true);
					foreach ($cart_item as $self) {
						// 是否為預購與非預購一併下訂
						if (($self['product_category_id'] == '1' && $this_product['product_category_id'] != '1') || ($self['product_category_id'] != '1' && $this_product['product_category_id'] == '1')) {
							if ($this->input->method() == 'post') {
								echo 'contradiction';
							} else {
								echo '
								<script>
									alert("預購商品不得與其他類型商品一並選購，敬請見諒。");
									window.location.href = "' . base_url() . 'auth?id=3' . '";
								</script>';
							}
							return;
						}
						// 同為預購是否同月份
						elseif ($this_contradiction_date['contradiction_status'] == 1 && $this_product['product_category_id'] == '1' && $self['product_category_id'] == '1' && $self['options']['booking_date'] != $this_product['booking_date']) {
							echo 'contradiction_date';
							return;
						}
					}
				}
			}
			// 購物車是否有該物品
			if (!empty($this->cart->contents(true)) && $this->cart->total_items() > 0) {
				$cart_item = $this->cart->contents(true);
				foreach ($cart_item as $self) {
					$pd_id = $this->mysql_model->_select('product_combine', 'id', $self['id'], 'row');
					if ($pd_id['product_id'] == $this_product_combine['product_id']) {
						if ($is_lottery == true) {
							if ($this->input->method() == 'post') {
								echo 'lottery';
							} else {
								echo '
								<script>
									alert("抽選商品只能選購一個。");
									window.location.href = "' . base_url() . 'auth?id=3' . '";
								</script>';
							}
							return;
						}
					}
					if ($self['id'] == $this_product_combine['id']) {

						if ($this_product_combine['limit_enable'] == 'YES' && (int)$self['qty'] + (int)$qty > (int)$this_product_combine['limit_qty']) {
							echo 'exceed';
							return;
						}
						$rowid = $self['rowid'];
						$new_qty = (int)$self['qty'] + (int)$qty;

						$data = array(
							'rowid' => $rowid,
							'qty'	=> $new_qty
						);
						// 将修改后的内容重新设置回购物车
						$this->cart->update($data);
						echo 'updateSuccessful';
						return;
					}
				}
			}
		} else if ($this->is_liqun_food) {
			$total_weight = (float)($weight * $qty);
			$cart_item = $this->cart->contents(true);
			// checking weight
			foreach ($cart_item as $self) {
				$total_weight += ((float)$self['options']['weight'] * (float)$self['qty']);
			}
			// if ($total_weight > 10.00) {
			// 	echo 'weight_exceed';
			// 	return;
			// }
			// 購物車是否有該物品
			if (!empty($this->cart->contents(true)) && $this->cart->total_items() > 0) {
				foreach ($cart_item as $self) {
					if ($self['id'] == $this_product_combine['id']) {
						if ($this_product_combine['limit_enable'] == 'YES' && (int)$self['qty'] + (int)$qty > (int)$this_product_combine['limit_qty']) {
							echo 'exceed';
							return;
						}
						$rowid = $self['rowid'];
						$new_qty = (int)$self['qty'] + (int)$qty;

						$data = array(
							'rowid' => $rowid,
							'qty'	=> $new_qty
						);
						// 将修改后的内容重新设置回购物车
						$this->cart->update($data);
						echo 'updateSuccessful';
						return;
					}
				}
			}
		}

		$name = $this_product['product_name'] . ' - ' . $this_product_combine['name'];
		$price = $this_product_combine['current_price'];
		if (!empty($specification_qty) && $specification_qty != '') {
			foreach ($specification_qty as $row) {
				if ($row != 0) {
					$specification_name_array[] = $specification_name[$i];
					$specification_id_array[] = $specification_id[$i];
					$specification_qty_array[] = $row;
				}
				$i++;
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
		} else {
			$insert_data = array(
				'product_id' => $this_product_combine['product_id'],
				'product_category_id' => $this_product['product_category_id'],
				'id' => $this_product_combine['id'],
				'name' => $name,
				'price' => $price,
				'qty' => $qty,
				'image' => $this_product_combine['picture'],
				'options' => array(
					'time' => get_random_string(15),
				),
			);
		}

		if ($this->is_partnertoys) {
			$insert_data['options']['booking_date'] = $this_product['booking_date'];
		}
		if ($this->is_liqun_food) {
			$insert_data['options']['weight'] = $this->input->post('weight');
		}
		$rowid = $this->cart->insert($insert_data);
		if ($rowid) {
			if ($this->input->method() == 'post') {
				echo 'successful';
			} else {
				echo '
				<script>
					alert("加入購物車成功！");
					window.location.href = "' . base_url() . 'checkout' . '";
				</script>';
			}
			return;
		} else {
			echo 'unsuccessful';
		}
		return;
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
