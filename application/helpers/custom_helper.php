<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function html_excerpt($str, $count = 50, $end_char = '&#8230;') {
	$str = strip_all_tags($str, true);
	$str = mb_substr($str, 0, $count);
	// remove part of an entity at the end
	$str = preg_replace('/&[^;\s]{0,6}$/', '', $str);
	return $str . $end_char;
}

function strip_all_tags($string, $remove_breaks = false) {
	$string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
	$string = strip_tags($string);

	if ($remove_breaks) {
		$string = preg_replace('/[\r\n\t ]+/', ' ', $string);
	}

	return trim($string);
}

function get_order_number_by_type($type, $number, $date) {
	$CI = &get_instance();
	$y = substr($date, 0, 4);
	$m = substr($date, 5, 2);
	$d = substr($date, 8, 2);
	$hi = date('Hi');
	$CI->db->select('MAX(' . $number . ') as last_number');
	$CI->db->like($number, $y . $m . $d . $hi, 'after');
	$query = $CI->db->get($type);
	if ($query->num_rows() > 0) {
		$row = $query->row();
		if ($row->last_number == null) {
			$last_number = $y . $m . $d . $hi . '01';
		} else {
			$last_number = $row->last_number;
			$last_number++;
		}
	}
	return $last_number;
}

function get_change_log($type, $type_id) {
	$CI = &get_instance();
	$CI->db->where('change_log_column', $type);
	$CI->db->where('change_log_column_id', $type_id);
	$CI->db->order_by('change_log_created_at', 'desc');
	$query = $CI->db->get('change_log');
	return ($query->num_rows() > 0) ? $query->result_array() : false;
}

function get_yes_no($data) {
	if ($data == '1') {
		return "是";
	} else {
		return "否";
	}
}

function get_marry($data) {
	if ($data == '1') {
		return "已婚";
	} else {
		return "未婚";
	}
}

function get_soldier($data) {
	if ($data == '1') {
		return "已役";
	} else {
		return "未役";
	}
}

function get_sex($data) {
	if ($data == 'M') {
		return "男";
	} elseif ($data == 'F') {
		return "女";
	} else {
		return '';
	}
}

function get_etag($data) {
	if ($data == '1') {
		return "是";
	} else {
		return "否";
	}
}

function get_cash_type($data) {
	if ($data == '1') {
		return "收入";
	} else {
		return "支出";
	}
}

function get_pay_type($data) {
	if ($data == 'cash') {
		return "現金";
	} elseif ($data == 'credit') {
		return "信用卡";
	}
}

function get_offer_type($data) {
	if ($data == 'cash') {
		return "現金";
	} elseif ($data == 'percent') {
		return "百分比";
	}
}

function get_is_warehouse($data) {
	if ($data == '0') {
		return "未入庫";
	} else {
		return "全部入庫";
	}
}

function get_out_of_stock($data) {
	if ($data == '0') {
		return "未出庫";
	} else {
		return "全部出庫";
	}
}

function get_change_way($data) {
	if ($data == '1') {
		return "<i class='fa fa-arrow-up' style='color: #15b74e;'></i>";
	} else {
		return "<i class='fa fa-arrow-down' style='color: #fb3838;'></i>";
	}
}

function get_void($data) {
	if ($data == '1') {
		return "<span style='color: red;'>作廢</span>";
	} else {
		return "";
	}
}

function get_order_eat_type($data) {
	switch ($data) {
		case 'in':
			return "內用";
			break;
		case 'out':
			return "外帶";
			break;
		case 'call':
			return "電話";
			break;
		case 'delivery':
			return "外送";
			break;
	}
}

function get_offer_item_type($data) {
	switch ($data) {
		case 'single':
			return "單一商品";
			break;
		case 'category':
			return "商品分類";
			break;
		case 'cart':
			return "購物車";
			break;
	}
}

function get_contact_person_address_type($data) {
	switch ($data) {
		case 'r':
			return "登記地址";
			break;
		case 's':
			return "配送地址";
			break;
		case 'i':
			return "發票地址";
			break;
	}
}

function get_coupon_use_limit($data) {
	switch ($data) {
		case 'once':
			return "一次性";
			break;
		case 'repeat':
			return "可重複使用";
			break;
	}
}

function get_coupon_is_uesd($data) {
	switch ($data) {
		case 'y':
			return "已使用";
			break;
		case 'n':
			return "未使用";
			break;
	}
}

function get_stock_type($data) {
	switch ($data) {
		case '1':
			return "生產";
			break;
		case '2':
			return "進貨";
			break;
		case '3':
			return "銷貨";
			break;
		case '4':
			return "POS";
			break;
		case '5':
			return "調撥";
			break;
		case '6':
			return "報廢";
			break;
		case '7':
			return "盤點";
			break;
		case '8':
			return "銷貨退回";
			break;
		case '9':
			return "進貨退出";
			break;
		case '10':
			return "調整";
			break;
		case '11':
			return "分裝";
			break;
	}
}

function get_pay_status($data) {
	switch ($data) {
		case 'not_paid':
			return "未付款";
			break;
		case 'paid':
			return "已付款";
			break;
		case 'finish':
			return "已完成";
			break;
		case 'return':
			return "已退款";
			break;
		case 'cancel':
			return "取消";
			break;
	}
}

function get_order_step($data) {
	switch ($data) {
		case 'accept':
			return "接收訂單";
			break;
		case 'prepare':
			return "餐點準備中";
			break;
		case 'shipping':
			return "餐點運送中";
			break;
		case 'arrive':
			return "司機抵達";
			break;
		case 'picked':
			return "已取餐";
			break;
		case 'cancel':
			return "取消訂單";
			break;
		case 'void':
			return "已退單";
			break;
	}
}

function get_delivery($data) {
	switch ($data) {
		case 'home_delivery_frozen':
			return "冷凍宅配";
			break;
		case '711_pickup_frozen':
			return "7-11 超商取貨";
			break;
	}
}

function get_payment($data) {
	switch ($data) {
		case 'credit':
			return "信用卡";
			break;
		case 'cash_on_delivery':
			return "餐到付款";
			break;
		case 'line_pay':
			return "Line Pay";
			break;
		case 'after_pay':
			return "後支付";
			break;
	}
}

function get_en_date($data) {
	switch ($data) {
	case 'Jan':
		return "01";
		break;
	case 'Feb':
		return "02";
		break;
	case 'Mar':
		return "03";
		break;
	case 'Apr':
		return "04";
		break;
	case 'May':
		return "05";
		break;
	case 'Jun':
		return "06";
		break;
	case 'Jul':
		return "07";
		break;
	case 'Aug':
		return "08";
		break;
	case 'Sep':
		return "09";
		break;
	case 'Oct':
		return "10";
		break;
	case 'Nov':
		return "11";
		break;
	case 'Dec':
		return "12";
		break;
	}
}

function get_null($data) {
	if (empty($data)) {
		return null;
	} else {
		return $data;
	}
}

function get_empty($data) {
	if (empty($data)) {
		return '';
	} else {
		return $data;
	}
}

function get_empty_remark($data) {
	if (empty($data)) {
		return '無';
	} else {
		return $data;
	}
}

function get_chinese_weekday($datetime) {
	$weekday = date('w', strtotime($datetime));
	$weeklist = array('日', '一', '二', '三', '四', '五', '六');
	return $weeklist[$weekday];
}

function get_image($data) {
	if (!empty($data)) {
		$result = '<a href="/assets/uploads/' . $data . '" data-fancybox data-caption="' . $data . '"><img src="/assets/uploads/' . $data . '" class="img-responsive" /></a>';
	} else {
		$result = '<img src="/assets/images/no-image.jpg" class="img-responsive" />';
	}
	return $result;
}

function check_delivery_time($store_order_time_id, $delivery_time) {
	$CI = &get_instance();
	$CI->db->where('store_order_time_id', $store_order_time_id);
	$CI->db->like('delivery_time', $delivery_time);
	$query = $CI->db->get('store_order_time');
	if ($query->num_rows() > 0) {
		return 'checked';
	} else {
		return '';
	}
}

function check_area_delivery_time($store_order_time_area_id, $delivery_time) {
	$CI = &get_instance();
	$CI->db->where('store_order_time_area_id', $store_order_time_area_id);
	$CI->db->like('delivery_time', $delivery_time);
	$query = $CI->db->get('store_order_time_area');
	if ($query->num_rows() > 0) {
		return 'checked';
	} else {
		return '';
	}
}

function get_last_order_date($id) {
	$CI = &get_instance();
	// $CI->db->select('coupon_name');
	$CI->db->where('customer_id', $id);
	$CI->db->order_by('order_date', 'desc');
	$CI->db->limit(1);
	$query = $CI->db->get('orders');
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['order_date'];
		return $data;
	} else {
		return '';
	}
}

function get_coupon_id_by_code($id) {
	$CI = &get_instance();
	$CI->db->select('coupon_id');
	$query = $CI->db->get_where('coupon', array('coupon_code' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['coupon_id'];
		return $data;
	} else {
		return 0;
	}
}

function get_coupon_number_by_code($id) {
	$CI = &get_instance();
	$CI->db->select('coupon_number');
	$query = $CI->db->get_where('coupon', array('coupon_code' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['coupon_number'];
		return $data;
	} else {
		return 0;
	}
}

function get_coupon_name($id) {
	$CI = &get_instance();
	$CI->db->select('coupon_name');
	$query = $CI->db->get_where('coupon', array('coupon_id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['coupon_name'];
		return $data;
	} else {
		return '';
	}
}

function get_cart_option($data) {
	if ($data == '正常') {
		return '';
	} else {
		return $data . ' ';
	}
}

function get_cart_output($data) {
	if ($data == '') {
		return '';
	} else {
		return $data . ' ';
	}
}

function get_post_category_name($id) {
	$CI = &get_instance();
	$CI->db->select('post_category_name');
	$CI->db->limit(1);
	$query = $CI->db->get_where('post_category', array('post_category_id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['post_category_name'];
		return $data;
	}
}

function get_user_username($id) {
	$CI = &get_instance();
	$CI->db->select('username');
	$CI->db->limit(1);
	$query = $CI->db->get_where('users', array('id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['username'];
		return $data;
	}
}

function get_user_full_name($id) {
	$CI = &get_instance();
	$CI->db->select('full_name');
	$CI->db->limit(1);
	$query = $CI->db->get_where('users', array('id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['full_name'];
		return $data;
	}
}

function get_user_email($id) {
	$CI = &get_instance();
	$CI->db->select('email');
	$CI->db->limit(1);
	$query = $CI->db->get_where('users', array('id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['email'];
		return $data;
	}
}

function get_user_phone($id) {
	$CI = &get_instance();
	$CI->db->select('phone');
	$CI->db->limit(1);
	$query = $CI->db->get_where('users', array('id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['phone'];
		return $data;
	}
}

function get_user_address($id) {
	$CI = &get_instance();
	$CI->db->limit(1);
	$query = $CI->db->get_where('users', array('id' => $id));
	if ($query->num_rows() > 0) {
		$result = $query->row_array();
		$data = $result['county'] . $result['district'] . $result['address'];
		return $data;
	}
}

function get_setting_general($name) {
	$CI = &get_instance();
	$CI->db->where('setting_general_name', $name);
	$CI->db->select('setting_general_value');
	$CI->db->limit(1);
	$query = $CI->db->get('setting_general');
	if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$data = $row['setting_general_value'];
		return $data;
	}
}

function get_tw_date($data) {
	$result = str_replace('-', '', $data);
	$result = substr($result, 0, 8);
	$result = $result - 19110000;
	$y = substr($result, 0, 3);
	$m = substr($result, 3, 2);
	$d = substr($result, 5, 2);
	return $y . '年' . $m . '月' . $d . '日';
}

function get_expatriate_name($id) {
	$CI = &get_instance();
	$CI->db->join('employee', 'employee.employee_id = users.id');
	$CI->db->join('users_groups', 'users_groups.user_id = users.id');
	$CI->db->join('groups', 'groups.id = users_groups.group_id');
	$CI->db->where('groups.name', 'expatriate');
	$CI->db->where('users.id', $id);
	$query = $CI->db->get('users');
	if ($query->num_rows() > 0) {
		//$result = $query->row_array();
		//$data = $result['employee_category'];
		//return $data;
		return TRUE;
	}
}

function get_random_string($str_len) {
	$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$shuffled = str_shuffle($str);
	return substr($shuffled, 0, $str_len);
}

function check_have_string($string, $text) {
	if (!empty($string)) {
		$str1 = $string;
		$str2 = $text;
		if (false !== ($rst = strpos($str1, $str2))) {
			// echo 'find';
			return TRUE;
		} else {
			// echo 'not find';
			return FALSE;
		}
	}
}

/**
 * 計算兩組經緯度座標 之間的距離
 * params ：lat1 緯度1； lng1 經度1； lat2 緯度2； lng2 經度2； len_type （1:m or 2:km);
 * return m or km
 */
define('PI', 3.1415926535898);
define('EARTH_RADIUS', 6378.137);
function GetDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 0) {
	$radLat1 = $lat1 * PI / 180.0;
	$radLat2 = $lat2 * PI / 180.0;
	$a = $radLat1 - $radLat2;
	$b = ($lng1 * PI / 180.0) - ($lng2 * PI / 180.0);
	$s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
	$s = $s * EARTH_RADIUS;
	$s = round($s * 1000);
	if ($len_type > 1) {
		$s /= 1000;
	}
	return round($s, $decimal);
}

// 地址取得經緯度 - old
function Getlatlng($address) {
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&language=zh-TW&key=AIzaSyBzfMl1G0OrMw6cdVydIA4vxiGFmX9P-TI";
	$geo = file_get_contents($url);
	$geo = json_decode($geo, true);
	$geo_status = $geo['status'];
	// echo "$geo_status";
	if ($geo_status == "OVER_QUERY_LIMIT") {die("OVER_QUERY_LIMIT");}
	if ($geo_status != "OK");

	$geo_address = $geo['results'][0]['formatted_address'];
	// $num_components = count($geo['results'][0]['address_components']);
	//郵遞區號、經緯度
	// $geo_zip = $geo['results'][0]['address_components'][$num_components-1]['long_name'];
	$geo_lat = $geo['results'][0]['geometry']['location']['lat'];
	$geo_lng = $geo['results'][0]['geometry']['location']['lng'];
	// $geo_location_type = $geo['results'][0]['geometry']['location_type'];

	return array('lat' => $geo_lat, 'lng' => $geo_lng);
}

// 地址取得經緯度 - new
function get_coordinates($address) {
	$return = array();
	$address = urlencode($address);
	$url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&language=zh-TW&key=AIzaSyBzfMl1G0OrMw6cdVydIA4vxiGFmX9P-TI";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
	$response_a = json_decode($response);
	$status = $response_a->status;

	if ($status == 'ZERO_RESULTS') {
		return FALSE;
	} else {
		for ($i = 0; $i < count($response_a->results[0]->address_components); $i++) {
			if ($response_a->results[0]->address_components[$i]->types[0] == 'administrative_area_level_3') {
				$return['lat'] = $response_a->results[0]->geometry->location->lat;
				$return['lng'] = $response_a->results[0]->geometry->location->lng;
				$return['district'] = $response_a->results[0]->address_components[$i]->long_name;
			}
			if ($response_a->results[0]->address_components[$i]->types[0] == 'administrative_area_level_1') {
				$return['county'] = $response_a->results[0]->address_components[$i]->long_name;
			}
			if ($response_a->results[0]->address_components[$i]->types[0] == 'route') {
				$return['route'] = $response_a->results[0]->address_components[$i]->long_name;
			}
			if ($response_a->results[0]->address_components[$i]->types[0] == 'street_number') {
				$return['street_number'] = $response_a->results[0]->address_components[$i]->long_name;
			}
			if ($response_a->results[0]->address_components[$i]->types[0] == 'postal_code') {
				$return['zipcode'] = $response_a->results[0]->address_components[$i]->long_name;
			}
		}
		// echo '<pre>';
		// print_r($return);
		// echo '</pre>';

		return $return;
	}
}

// 兩組經緯度取得距離與時間-走路
function GetWalkingDistance($lat1, $long1, $lat2, $long2) {
	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=walking&language=zh-TW&key=AIzaSyBzfMl1G0OrMw6cdVydIA4vxiGFmX9P-TI";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
	$response_a = json_decode($response, true);
	$dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
	$time = $response_a['rows'][0]['elements'][0]['duration']['value'];

	return array('distance' => $dist, 'time' => $time);
}

// 兩組經緯度取得距離與時間-開車
function GetDrivingDistance($lat1, $long1, $lat2, $long2) {
	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=zh-TW&key=AIzaSyBzfMl1G0OrMw6cdVydIA4vxiGFmX9P-TI";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
	$response_a = json_decode($response, true);
	$dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
	$time = $response_a['rows'][0]['elements'][0]['duration']['value'];

	return array('distance' => $dist, 'time' => $time);
}

function check_mobile() {
	$regex_match = "/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
	$regex_match .= "htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
	$regex_match .= "blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
	$regex_match .= "symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
	$regex_match .= "jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
	$regex_match .= ")/i";
	return preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}

function wp_is_mobile() {
	static $is_mobile = null;

	if (isset($is_mobile)) {
		return $is_mobile;
	}

	if (empty($_SERVER['HTTP_USER_AGENT'])) {
		$is_mobile = false;
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false// many mobile devices (all iPhone, iPad, etc.)
		 || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}

function userAgent($ua) {

	$iphone = strstr(strtolower($ua), 'mobile'); //Search for 'mobile' in user-agent (iPhone have that)
	$android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
	$windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)

	function androidTablet($ua) {
		//Find out if it is a tablet
		if (strstr(strtolower($ua), 'android')) {
			//Search for android in user-agent
			if (!strstr(strtolower($ua), 'mobile')) { //If there is no ''mobile' in user-agent (Android have that on their phones, but not tablets)
				return true;
			}
		}
	}
	$androidTablet = androidTablet($ua); //Do androidTablet function
	$ipad = strstr(strtolower($ua), 'ipad'); //Search for iPad in user-agent

	if ($androidTablet || $ipad) {
		//If it's a tablet (iPad / Android)
		return 'tablet';
	} elseif ($iphone && !$ipad || $android && !$androidTablet || $windowsPhone) {
		//If it's a phone and NOT a tablet
		return 'mobile';
	} else {
		//If it's not a mobile device
		return 'desktop';
	}
}

function check_link($target_link) {
	$link = '';
	if (!empty($target_link)) {
		$str1 = $target_link;
		$str2 = 'http';
		if (false !== ($rst = strpos($str1, $str2))) {
			// echo 'find';
			$link .= $target_link;
		} else {
			// echo 'not find';
			$link .= 'http://' . $target_link;
		}
	}
	return $link;
}

function utf8_to_big5($string) {
	return mb_convert_encoding($string, "Big5", "UTF-8");
}

function utf8_to_big5_array($array) {
	array_walk_recursive($array, function (&$item, $key) {
		if (!mb_detect_encoding($item, 'big5', true)) {
			// $item = iconv('utf-8','big5',$item);
			$item = mb_convert_encoding($item, 'big5', 'utf-8');
		}
	});
	return $array;
}