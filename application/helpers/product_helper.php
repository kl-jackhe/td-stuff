<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function get_product_category_option($parent_id = 0, $sub_mark = '') {
	$CI = &get_instance();
	$CI->db->where('product_category_parent', $parent_id);
	$query = $CI->db->get('product_category');
	if ($query->num_rows() > 0) {
		foreach ($query->result_array() as $row) {
			echo '<option value="' . $row['product_category_id'] . '">' . $sub_mark . $row['product_category_name'] . '</option>';
			get_product_category_option($row['product_category_id'], $sub_mark . '－');
		}
	}
	return false;
}

function get_product_category_checkbox($parent_id = 0, $sub_mark = '') {
	$CI = &get_instance();
	$CI->db->where('product_category_parent', $parent_id);
	$query = $CI->db->get('product_category');
	if ($query->num_rows() > 0) {
		foreach ($query->result_array() as $row) {
			echo '<div class="checkbox">';
			echo '<label class="checkbox">';
			echo '<input type="checkbox" name="product_category[]" value="' . $row['product_category_id'] . '">';
			echo $sub_mark . $row['product_category_name'];
			echo '</label>';
			echo '</div>';
			get_product_category_checkbox($row['product_category_id'], $sub_mark . '－');
		}
	}
	return false;
}

function get_product_category_li($parent_id = 0, $sub_mark = '') {
	$CI = &get_instance();
	$CI->db->where('product_category_parent', $parent_id);
	$query = $CI->db->get('product_category');
	if ($query->num_rows() > 0) {
		foreach ($query->result_array() as $row) {
			echo '<li role="presentation">';
			echo '<a href="#' . $row["product_category_id"] . '" aria-controls="' . $row["product_category_id"] . '" role="tab" data-toggle="tab">' . $sub_mark . $row["product_category_name"] . '</a>';
			echo '</li>';
			get_product_category_li($row['product_category_id'], $sub_mark . '－');
		}
	}
	return false;
}

function get_product_category_checkbox_checked($product_id, $parent_id = 0, $sub_mark = '') {
	$CI = &get_instance();
	$CI->db->where('product_category_parent', $parent_id);
	$query = $CI->db->get('product_category');
	if ($query->num_rows() > 0) {
		foreach ($query->result_array() as $row) {
			$checked = '';
			$CI->db->where('product_id', $product_id);
			$query2 = $CI->db->get('product_category_list');
			if ($query2->num_rows() > 0) {
				foreach ($query2->result_array() as $cl) {
					if ($cl['product_category_id'] == $row['product_category_id']) {
						$checked = 'checked';
						break;
					}
				}
			}
			echo '<div class="checkbox">';
			echo '<label class="checkbox">';
			echo '<input type="checkbox" name="product_category[]" value="' . $row['product_category_id'] . '" ' . $checked . '>';
			echo $sub_mark . $row['product_category_name'];
			echo '</label>';
			echo '</div>';
			get_product_category_checkbox_checked($product_id, $row['product_category_id'], $sub_mark . '－');
		}
	}
	return false;
}

function get_product_category_td($parent_id = 0, $sub_mark = '') {
	$CI = &get_instance();
	$CI->db->where('product_category_parent', $parent_id);
	$query = $CI->db->get('product_category');
	if ($query->num_rows() > 0) {
		foreach ($query->result_array() as $row) {
			echo '<tr>';
			echo '<td width="50px">' . get_image($row['product_category_image']) . '</td>';
			echo '<td>' . $sub_mark . $row['product_category_name'] . '</td>';
			echo '<td>' . get_product_category_type_name($row['product_category_type']) . '</td>';
			echo '<td>' . $row['product_category_print'] . '</td>';
			echo '<td>' . get_yes_no($row['get_option']) . '</td>';
			echo '<td>';
			echo '<a href="category/edit/' . $row['product_category_id'] . '" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> ';
			echo '<a href="category/delete/' . $row['product_category_id'] . '" class="btn btn-danger btn-sm" onclick="return confirm("確定要刪除嗎?")"><i class="fa fa-trash-o"></i></a>';
			echo '</td>';
			echo '</tr>';
			get_product_category_td($row['product_category_id'], $sub_mark . '－');
		}
	}
}

function get_product_id_by_name($data) {
	$CI = &get_instance();
	$CI->db->select('product_id');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_name' => $data));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_id'];
		return $data;
	}
}

function get_product_name($id) {
	$CI = &get_instance();
	$CI->db->select('product_name');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_name'];
		return $data;
	}
}

function get_product_image($id) {
	$CI = &get_instance();
	$CI->db->select('product_image');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_image'];
		return $data;
	}
}

function get_product_description($id) {
	$CI = &get_instance();
	$CI->db->select('product_description');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		if (empty($row['product_description'])) {
			$data = '';
		} else {
			$data = '(' . $row['product_description'] . ')';
		}
		return $data;
	}
}

function get_product_specification_name($id) {
	$CI = &get_instance();
	$CI->db->select('specification');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product_specification', array('id' => $id));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		return $row['specification'];
	}
	return '';
}

function get_product_category($id) {
	$result = '';
	$CI = &get_instance();
	//$CI->db->select('product_category_list');
	$query = $CI->db->get_where('product_category_list', array('product_id' => $id));
	if (!empty($query->result_array())) {
		foreach ($query->result_array() as $data) {
			$result .= $data['product_category_id'] . ',';
		}
	}
	return $result;
}

function get_product_category_front($id) {
	$result = '';
	$CI = &get_instance();
	//$CI->db->select('product_category_list');
	$query = $CI->db->get_where('product_category_list', array('product_id' => $id));
	if (!empty($query->result_array())) {
		foreach ($query->result_array() as $data) {
			$result .= get_product_category_name($data['product_category_id']) . '-';
		}
	}
	return $result;
}

function get_product_category_get_option($id) {
	$CI = &get_instance();
	$CI->db->join('product_category_list', 'product_category_list.product_id = product.product_id');
	$CI->db->join('product_category', 'product_category.product_category_id = product_category_list.product_category_id');
	//$CI->db->where('product_category_list.product_category_id',$params['search']['category']);
	$CI->db->where('product.product_id', $id);
	$query = $CI->db->get('product');
	if ($query->num_rows() > 0) {
		$total = 0;
		foreach ($query->result_array() as $data) {
			$total += intval($data['get_option']);
			//echo $data['get_option'].'---';
		}
		if ($total >= 1) {
			return '1';
		}
	} else {
		return '0';
	}
}

function get_product_category_type($id) {
	$CI = &get_instance();
	$CI->db->join('product_category', 'product_category.product_category_id = product_category_list.product_category_id');
	//$CI->db->select('product_category');
	$query = $CI->db->get_where('product_category_list', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['product_category_type'];
		return $data;
	}
}

function get_product_category_print($id) {
	$CI = &get_instance();
	$CI->db->join('product_category', 'product_category.product_category_id = product.product_category');
	//$CI->db->select('product_category');
	$query = $CI->db->get_where('product', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['product_category_print'];
		return $data;
	}
}

function get_product_category_name($id) {
	$CI = &get_instance();
	$CI->db->select('product_category_name');
	$query = $CI->db->get_where('product_category', array('product_category_id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['product_category_name'];
		return $data;
	}
}

function get_product_category_type_name($data) {
	if ($data == 'drink') {
		return '飲料';
	} else {
		return '餐點';
	}
}

function get_product_unit($id) {
	$CI = &get_instance();
	$CI->db->select('product_unit');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_unit'];
		return $data;
	}
}

function get_product_sku($id) {
	$CI = &get_instance();
	$CI->db->select('product_sku');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $id));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_sku'];
		return $data;
	}
}

function get_product_weight($data) {
	$CI = &get_instance();
	$CI->db->select('product_weight');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $data));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_weight'];
		return $data;
	}
}

function get_product_price($data) {
	$CI = &get_instance();
	$CI->db->select('product_price');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $data));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_price'];
		return $data;
	}
}

function get_product_style($data) {
	$CI = &get_instance();
	$CI->db->select('product_style');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product', array('product_id' => $data));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['product_style'];
		return $data;
	}
}

function get_product_remaining_qty($product_id, $cart_qty) {
	$order_item_qty = 0;
	$CI = &get_instance();
	$CI->db->select('product_daily_stock');
	$CI->db->where('store_order_time_id', $store_order_time_id);
	$CI->db->where('product_id', $product_id);
	$CI->db->limit(1);
	$query = $CI->db->get('store_order_time_item');
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$product_daily_stock = $row['product_daily_stock'];
		// 如果每日庫存大餘0
		if ($product_daily_stock > 0) {
			$remaining = $product_daily_stock;

			$CI->db->join('orders', 'orders.order_id = order_item.order_id');
			$CI->db->select_sum('order_item_qty');
			$CI->db->like('order_date', $CI->session->userdata('delivery_date'));
			$CI->db->where('product_id', $product_id);
			$query2 = $CI->db->get('order_item');
			if ($query2->num_rows() > 0) {
				$row2 = $query2->row_array();
				$order_item_qty = $row2['order_item_qty'];
				$remaining -= $order_item_qty;

				if ($remaining - $cart_qty < 0) {
					return 0;
				} else {
					return $remaining - $cart_qty;
				}
			} else {
				return $product_daily_stock;
			}
		} else {
			return 0;
		}
	}
}

function get_cart_product_qty($product_id) {
	$CI = &get_instance();
	$qty = 0;
	if (!empty($CI->cart->contents())) {
		foreach ($CI->cart->contents() as $items) {
			if ($product_id == $items['id']) {
				$qty += $items['qty'];
			}
		}
	}
	return $qty;
}

function get_product_combine($data, $key = '') {
	if($key==''){
		return '';
	}
	$CI = &get_instance();
	$CI->db->select($key);
	$CI->db->limit(1);
	$query = $CI->db->get_where('product_combine', array('id' => $data));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row[$key];
		return $data;
	}
}

function get_product_combine_name($data) {
	$CI = &get_instance();
	$CI->db->select('name');
	$CI->db->limit(1);
	$query = $CI->db->get_where('product_combine', array('id' => $data));
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['name'];
		return $data;
	}
}