<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('home_model');
		$this->load->model('store_model');
		$this->load->model('coupon_model');
		$this->load->model('service_area_model');
	}

	public function index() {
		$this->data['page_title'] = '跨區美食';
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->data['hide_county'] = $this->service_area_model->get_hide_county();
		$this->data['hide_district'] = $this->service_area_model->get_hide_district();
		if (!empty($_GET['county']) && !empty($_GET['district']) && !empty($_GET['address'])) {
			// 清空購物車
			$this->cart->destroy();
			$data = array(
				// 清空配送日期
				'delivery_date' => '',
				// 清空配送時間
				'delivery_time' => '',
				// 清空配送地點
				'delivery_place' => '',
				// 清空優惠券
				'coupon_id' => '0',
				'coupon_code' => '0',
				'coupon_method' => '',
				'coupon_price' => '0',
				// 儲存城市
				'county' => $this->input->get('county'),
				// 儲存區域
				'district' => $this->input->get('district'),
				// 儲存地址
				'address' => $this->input->get('address'),
			);
			$this->session->set_userdata($data);
			// 儲存配送地址
			$this->session->unset_userdata('custom_address');
			$data = array(
				'custom_address' => $this->input->get('county') . $this->input->get('district') . $this->input->get('address'),
			);
			$this->session->set_userdata($data);
			// 儲存查詢的地址
			if ($this->ion_auth->logged_in()) {
				$users_address = $this->home_model->get_users_address($this->ion_auth->user()->row()->id);
				if ($users_address) {
					$this->data['users_address']['county'] = $users_address['county'];
					$this->data['users_address']['district'] = $users_address['district'];
					$this->data['users_address']['address'] = $users_address['address'];
					$data = array(
						'delivery_place' => $users_address['county'] . $users_address['district'] . $users_address['address'],
					);
					$this->session->set_userdata($data);
				} else {
					$this->data['users_address']['county'] = '';
					$this->data['users_address']['district'] = '';
					$this->data['users_address']['address'] = '';
					$data = array(
						'delivery_place' => '',
					);
					$this->session->set_userdata($data);
				}
			} else {
				set_cookie("user_county", $this->input->get('county'), 30 * 86400);
				set_cookie("user_district", $this->input->get('district'), 30 * 86400);
				set_cookie("user_address", $this->input->get('address'), 30 * 86400);
			}
			//
			$coordinates = get_coordinates($this->input->get('county') . $this->input->get('district') . $this->input->get('address'));
			if (!empty($coordinates['district']) && !empty($coordinates['route'])) {
				// 儲存郵遞區號
				$this->session->unset_userdata('zipcode');
				$zipcode_data = array(
					'zipcode' => $coordinates['zipcode'],
				);
				$this->session->set_userdata($zipcode_data);
				// echo $this->input->get('county').$this->input->get('district').$this->input->get('address');
				if ($this->input->get('district') == $coordinates['district']) {
					if (strpos($this->input->get('address'), $coordinates['route']) !== false || strpos($this->input->get('address'), get_road_turn($coordinates['route'])) !== false) {
						$this->data['store_order_time_date'] = $this->store_model->getSearchStoreDate();
						$this->data['store_order_time'] = $this->store_model->getSearchStore();
					} else {
						$this->data['store_order_time_date'] = array();
						$this->data['store_order_time'] = array();
					}
				} else {
					$this->data['store_order_time_date'] = array();
					$this->data['store_order_time'] = array();
				}
			} else {
				$this->data['store_order_time_date'] = array();
				$this->data['store_order_time'] = array();
			}
			// $this->data['store_0'] = $this->store_model->getSearchStore_0();
			// $this->data['store_1'] = $this->store_model->getSearchStore_1();
			// 查詢配送點
			// $this->data['delivery_place'] = $this->store_model->getSearchDeliveryPlace($this->session->userdata('county'),$this->session->userdata('district'),$this->session->userdata('address'));
			$data = array(
				'delivery_place' => $this->input->get('county') . $this->input->get('district') . $this->input->get('address'),
			);
			$this->session->set_userdata($data);
		} else {
			$this->cart->destroy();
			$this->session->unset_userdata('delivery_place');
			$this->session->unset_userdata('coupon_id');
			$this->session->unset_userdata('coupon_code');
			$this->session->unset_userdata('coupon_method');
			$this->session->unset_userdata('coupon_price');
			$this->session->unset_userdata('county');
			$this->session->unset_userdata('district');
			$this->session->unset_userdata('address');
			// 取得客戶地址
			if ($this->ion_auth->logged_in()) {
				$users_address = $this->home_model->get_users_address($this->ion_auth->user()->row()->id);
				$this->data['users_address']['county'] = $users_address['county'];
				$this->data['users_address']['district'] = $users_address['district'];
				$this->data['users_address']['address'] = $users_address['address'];
				$data = array(
					'delivery_place' => $users_address['county'] . $users_address['district'] . $users_address['address'],
				);
				$this->session->set_userdata($data);
			} else {
				$this->data['users_address']['county'] = get_cookie("user_county", true);
				$this->data['users_address']['district'] = get_cookie("user_district", true);
				$this->data['users_address']['address'] = get_cookie("user_address", true);
				$data = array(
					'delivery_place' => $this->data['users_address']['county'] . $this->data['users_address']['district'] . $this->data['users_address']['address'],
				);
				$this->session->set_userdata($data);
			}
		}
		// header('Content-Type: application/json');
		// echo json_encode($this->data['delivery_place'], JSON_PRETTY_PRINT);
		$this->render('store/index');
	}

	public function view($id) {
		// 如果為不同可訂購時段，清除購物車
		if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $items) {
				if ($items['store_order_time'] != $id) {
					// echo '<script>alert("'.$items['store_order_time'].' - '.$id.'")</script>';
					$this->cart->destroy();
				}
			}
		}
		// if (!$this->ion_auth->logged_in())
		// {
		//     redirect('login', 'refresh');
		// }
		$this->data['page_title'] = '選擇商品';
		$this_store_order_time = $this->mysql_model->_select('store_order_time', 'store_order_time_id', $id, 'row');
		// 儲存配送日期
		// if (!empty($this->input->get('delivery_date'))) {
		// 	$data = array(
		// 		'delivery_date' => $this->input->get('delivery_date'),
		// 	);
		// 	$this->session->set_userdata($data);
		// }
		// 儲存店家
		// $data = array(
		//    'store' => $this_store_order_time['store_id'],
		// );
		// $this->session->set_userdata($data);
		// 儲存店家地址
		// $data = array(
		//    'store_address' => get_store_address($this_store_order_time['store_id']),
		// );
		// $this->session->set_userdata($data);
		// 儲存運費
		// $data = array(
		// 	// 'delivery_cost' => get_store_delivery_cost($this_store_order_time['store_id']),
		// 	'delivery_cost' => $this_store_order_time['delivery_cost'],
		// );
		// $this->session->set_userdata($data);
		// $this->data['delivery_place'] = $this->mysql_model->_select('delivery_place');
		// $this->data['delivery_place'] = $this->store_model->getSearchDeliveryPlace($this->session->userdata('county'),$this->session->userdata('district'),$this->session->userdata('address'));
		if ($this->ion_auth->logged_in()) {
			$this->data['user_coupon'] = $this->coupon_model->get_user_coupon($this->ion_auth->user()->row()->id);
		} else {
			$this->data['user_coupon'] = NULL;
		}
		// $this->data['product'] = $this->mysql_model->_select('product', 'store_id', $id);
		// $this->data['store'] = $this->mysql_model->_select('store', 'store_id', $id,'row');
		$this->data['store_order_time'] = $this->store_model->get_store_order_time_with_store($id);
		$this->data['store_order_time_item'] = $this->store_model->get_store_order_time_item_with_product($id);
		$aaa = get_store_id_by_store_order_time($id);
		$this->data['product_banner'] = $this->mysql_model->_select('product_banner', 'product_banner_store', $aaa, 'row');
		// $this->data['users_delivery_time'] = $this->store_model->get_users_delivery_time($this->ion_auth->user()->row()->id);
		$this->render('store/view');
	}

	public function checkout() {
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		}
		$this->data['page_title'] = '結帳';
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->render('store/checkout');
	}

	public function form_check() {
		// 如果是今天的話
		$delivery_date = $this->session->userdata('delivery_date');
		$delivery_time = $this->session->userdata('delivery_time');
		// $delivery_date = '2019-09-17';
		// $delivery_time = '11:00-11:30';
		if ($delivery_date == date('Y-m-d')) {

			if (date('H:i') < substr($delivery_time, 0, 5)) {
				echo 'yes';
			} else {
				echo 'no';
			}

		} else {
			echo 'yes';
		}
	}

	public function cart_price_check() {
		if (get_setting_general('cart_lowest_price_limit') != '' || get_setting_general('cart_lowest_price_limit') != '0') {
			if ($this->cart->total() >= get_setting_general('cart_lowest_price_limit')) {
				echo 'yes';
			} else {
				echo get_setting_general('cart_lowest_price_limit');
			}
		} else {
			echo 'yes';
		}
	}

	public function save_order() {
		$this->data['page_title'] = '結帳';
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		}

		// 依照單據日期取得單據編號
		// $order_number = get_order_number_by_type('orders','order_number',date('Y-m-d'));

		$date = date('Y-m-d');
		$ymd = date('Ymd');
		$h = date('H');
		$this->db->like('order_number', $ymd, 'after');
		$this->db->order_by('order_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$aaa = $row->order_number;
			$bbb = substr($aaa, 0, 12);
			$order_number = $bbb += 1;
			$order_number = $order_number . $h;
		} else {
			$order_number = $ymd . '0901' . $h;
		}

		$created_at = date("Y-m-d H:i:s");

		// 判斷是否滿%元免運
		$delivery_cost = ((get_setting_general('is_no_delivery_cost') == '1' && get_setting_general('is_no_delivery_cost_number') != '' && get_setting_general('is_no_delivery_cost_number') != '0' && $this->cart->total() >= get_setting_general('is_no_delivery_cost_number')) ? ('0') : ($this->session->userdata('delivery_cost')));

		// 判斷是否全站免運
		if ($delivery_cost != 0) {
			$delivery_cost = (get_setting_general('all_no_delivery_cost') == '') ? ($this->session->userdata('delivery_cost')) : ('0');
		}

		// 服務費
		// $service_cost = ((get_setting_general('no_service_cost')=='')?(round($this->cart->total()*0.1)):('0'));
		$service_cost = 0;

		$discount_price = 0;
		if ($this->session->userdata('coupon_method') == 'cash') {
			$discount_price += $this->session->userdata('coupon_price');
		}

		if ($this->session->userdata('coupon_method') == 'percent') {
			$discount_price += $this->cart->total() * (1 - $this->session->userdata('coupon_price'));
		}

		if ($this->session->userdata('coupon_method') == 'free_shipping') {
			$delivery_cost = 0;
		}

		$order_total = intval((($this->cart->total() + $delivery_cost) + $service_cost) - $discount_price);

		$order = array(
			'order_number' => $order_number,
			'order_date' => $this->session->userdata('delivery_date'),
			'store_id' => $this->session->userdata('store'),
			'customer_id' => $this->ion_auth->user()->row()->id,
			'customer_name' => $this->input->post('checkout_name'),
			'customer_phone' => $this->input->post('checkout_phone'),
			'customer_email' => $this->input->post('checkout_email'),
			'order_total' => (($this->cart->total() + $delivery_cost) + $service_cost),
			'order_discount_total' => $order_total,
			'order_discount_price' => get_empty($discount_price),
			'order_delivery_cost' => get_empty($delivery_cost),
			'order_delivery_place' => get_empty($this->session->userdata('delivery_place')),
			'order_delivery_address' => get_empty($this->session->userdata('custom_address')),
			'order_delivery_time' => get_empty($this->session->userdata('delivery_time')),
			'order_payment' => $this->input->post('checkout_payment'),
			'order_pay_status' => 'not_paid',
			'order_coupon' => get_empty($this->session->userdata('coupon_id')),
			'order_step' => 'accept',
			'order_remark' => $this->input->post('checkout_remark'),
			'creator_id' => $this->ion_auth->user()->row()->id,
			'created_at' => $created_at,
		);

		$order_id = $this->mysql_model->_insert('orders', $order);

		if ($cart = $this->cart->contents()):

			foreach ($cart as $item):
				$order_item = array(
					'order_id' => $order_id,
					'product_id' => $item['id'],
					'order_item_qty' => $item['qty'],
					'order_item_price' => $item['price'],
					'created_at' => $created_at,
				);
				$this->db->insert('order_item', $order_item);
			endforeach;

		endif;

		// 更新優惠券使用狀態
		if ($this->session->userdata('coupon_id') != '0' && $this->session->userdata('coupon_code') != '0') {
			$user_id = $this->ion_auth->user()->row()->id;

			$this->db->where('coupon_code', $this->session->userdata('coupon_code'));
			$this->db->where('user_id', $user_id);
			$this->db->where('coupon_is_uesd', 'n');
			$this->db->order_by('coupon_expiry_date', 'asc');
			$this->db->limit(1);
			$query = $this->db->get('user_coupon');
			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				$update_data = array(
					'coupon_is_uesd' => 'y',
				);
				$this->db->where('user_coupon_id', $row['user_coupon_id']);
				$this->db->update('user_coupon', $update_data);

			}

			// $update_data = array(
			//     'coupon_is_uesd' => 'y',
			// );
			// $this->db->where('coupon_code', $this->session->userdata('coupon_code'));
			// $this->db->where('user_id', $user_id);
			// $this->db->update('user_coupon', $update_data);
		}

		// 儲存訂單其他資訊
		$session_data = array(
			'order_number' => $order_number,
			'user_name' => $this->input->post('checkout_name'),
			'user_phone' => $this->input->post('checkout_phone'),
			'user_email' => $this->input->post('checkout_email'),
			'remark' => $this->input->post('checkout_remark'),
			'payment' => $this->input->post('checkout_payment'),
		);
		$this->session->set_userdata($session_data);

		// 取貨付款
		if ($this->input->post('checkout_payment') == 'cash_on_delivery') {

			// Start 寄信給買家、賣家
			// $this->send_order_email($order_number);

			redirect('store/order_success');

			// 綠界-信用卡
		} elseif ($this->input->post('checkout_payment') == 'credit') {

			// Start 寄信給買家、賣家
			// $this->send_order_email($order_number);

			/**
			 *    Credit信用卡付款產生訂單範例
			 */

			//載入SDK(路徑可依系統規劃自行調整)
			include 'ECPay.Payment.Integration.php';
			try {

				$obj = new ECPay_AllInOne();

				// 測試環境
				// $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5"; //服務位置
				// $obj->HashKey     = '5294y06JbISpM5x9' ; //測試用Hashkey，請自行帶入ECPay提供的HashKey
				// $obj->HashIV      = 'v77hoKGq4kWxNNIS' ; //測試用HashIV，請自行帶入ECPay提供的HashIV
				// $obj->MerchantID  = '2000132'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
				// $obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密

				// 正式環境
				$obj->ServiceURL = "https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5"; //服務位置
				$obj->HashKey = 'H2jCwAEjf2VVCbrX'; //測試用Hashkey，請自行帶入ECPay提供的HashKey
				$obj->HashIV = 'e0a5MtggjlNETHFo'; //測試用HashIV，請自行帶入ECPay提供的HashIV
				$obj->MerchantID = '3004957'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
				$obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密

				//基本參數(請依系統規劃自行調整)
				$MerchantTradeNo = $order_number . substr(time(), 4, 6);
				$obj->Send['MerchantTradeNo'] = $MerchantTradeNo; //訂單編號
				$obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
				$obj->Send['TotalAmount'] = $order_total; //交易金額
				$obj->Send['TradeDesc'] = get_empty_remark($this->input->post('checkout_remark')); //交易描述
				$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit; //付款方式:Credit
				$obj->Send['ReturnURL'] = base_url(); //付款完成通知回傳的網址
				$obj->Send['OrderResultURL'] = base_url() . "store/check_pay/" . $order_number; //付款完成通知回傳的網址
				//$obj->Send['ClientBackURL']     = base_url(); //付款完成後，顯示返回商店按鈕

				//$obj->Send['NeedExtraPaidInfo'] = ECPay_ExtraPaymentInfo::Yes;
				//訂單的商品資料
				// array_push($obj->Send['Items'], array(
				//     'Name' => "網路訂單",
				//     'Price' => (int)$price,
				//     'Currency' => "元",
				//     'Quantity' => (int) "1筆",
				//     'URL' => "dedwed"
				// ));
				if ($cart = $this->cart->contents()):
					foreach ($cart as $item):
						array_push($obj->Send['Items'], array(
							'Name' => get_product_name($item['id']),
							'Price' => (int) $item['price'],
							'Currency' => "元",
							'Quantity' => (int) $item['qty'],
							'URL' => "dedwed",
						));
					endforeach;
				endif;
				//Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
				//以下參數不可以跟信用卡定期定額參數一起設定
				$obj->SendExtend['CreditInstallment'] = 0; //分期期數，預設0(不分期)
				$obj->SendExtend['InstallmentAmount'] = 0; //使用刷卡分期的付款金額，預設0(不分期)
				$obj->SendExtend['Redeem'] = false; //是否使用紅利折抵，預設false
				$obj->SendExtend['UnionPay'] = false; //是否為聯營卡，預設false;
				//Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
				//以下參數不可以跟信用卡分期付款參數一起設定
				// $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
				// $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
				// $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
				// $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串

				//產生訂單(auto submit至ECPay)
				$obj->CheckOut();

			} catch (Exception $e) {
				echo $e->getMessage();
			}

			// $this->render('store/checkout-credit-callback');

			// Line Pay
		} elseif ($this->input->post('checkout_payment') == 'line_pay') {

			// Start 寄信給買家、賣家
			// $this->send_order_email($order_number);

			// Line Pay
			// New -----
			$channelId = "1605255943"; // 通路ID
			$channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰
			// Get Base URL path without filename
			// $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);
			$input = $_POST;
			// $input['isSandbox'] = (isset($input['isSandbox'])) ? true : false;
			// $input['isSandbox'] = true;
			$input['isSandbox'] = false;
			// Create LINE Pay client
			$linePay = new \yidas\linePay\Client([
				'channelId' => $channelId,
				'channelSecret' => $channelSecret,
				'isSandbox' => $input['isSandbox'],
			]);
			// Create an order based on Reserve API parameters
			$orderParams = [
				"amount" => $order_total,
				"currency" => 'TWD',
				"orderId" => $order_number,
				"packages" => [
					[
						"id" => "test1",
						"amount" => $order_total,
						"name" => "package name",
						"products" => [
							[
								"name" => 'Bytheway - 外送餐點',
								"quantity" => 1,
								"price" => $order_total,
								"imageUrl" => 'https://bytheway.com.tw/assets/images/line_pay_img.jpg',
							],
						],
					],
				],
				"redirectUrls" => [
					"confirmUrl" => base_url() . "store/line_pay_confirm",
					"cancelUrl" => base_url(),
				],
				"options" => [
					"display" => [
						"checkConfirmUrlBrowser" => true,
					],
				],
			];
			// Online Reserve API
			$response = $linePay->request($orderParams);
			// Check Reserve API result
			if (!$response->isSuccessful()) {
				die("<script>alert('ErrorCode {$response['returnCode']}: " . addslashes($response['returnMessage']) . "');history.back();</script>");
			}
			// Save the order info to session for confirm
			$_SESSION['linePayOrder'] = [
				'transactionId' => (string) $response["info"]["transactionId"],
				'params' => $orderParams,
				'isSandbox' => $input['isSandbox'],
			];
			// Save input for next process and next form
			$_SESSION['config'] = $input;
			// Redirect to LINE Pay payment URL
			header('Location: ' . $response->getPaymentUrl());

			// Old -----
			// require_once("Chinwei6_LinePay.php");

			// // Sandbox 環境 API 地址
			// $apiEndpoint   = "https://sandbox-api-pay.line.me/v2/payments/";
			// $channelId     = "1615286713"; // 通路ID
			// $channelSecret = "aea053e1d9b81686fe2283f28057f9ff"; // 通路密鑰

			// // Real 環境 API 地址
			// // $apiEndpoint   = "https://api-pay.line.me/v2/payments/request";
			// // $channelId     = "1605255943"; // 通路ID
			// // $channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰

			// // 建立 Chinwei6\LinePay 物件
			// $LinePay = new Chinwei6\LinePay($apiEndpoint, $channelId, $channelSecret);

			// // 建立訂單資訊作為 POST 的參數
			// $params = [
			//     "productName"     => "Bytheway - 外送餐點",
			//     "productImageUrl" => 'https://bytheway.com.tw/assets/images/line_pay_img.jpg',
			//     // "productImageUrl" => base_url().'assets/images/line_pay_img.jpg',
			//     "amount"          => $order_total,
			//     "currency"        => "TWD",
			//     "confirmUrl"      => base_url().'store/line_pay_confirm',
			//     "orderId"         => $order_number,
			//     "confirmUrlType"  => "CLIENT",
			//     // "confirmUrlType"  => "SERVER",
			// ];

			// try {
			//     $LinePay = new Chinwei6\LinePay($apiEndpoint, $channelId, $channelSecret);

			//     // Save params in the _SESSION
			//     $_SESSION['cache'] = [
			//         "apiEndpoint"   => $apiEndpoint,
			//         "channelId"     => $channelId,
			//         "channelSecret" => $channelSecret,
			//         "amount"        => $order_total,
			//         "currency"      => 'TWD',
			//     ];

			//     $result = $LinePay->reserve($params);
			//     // echo '<pre class="code">';
			//     // echo json_encode($result, JSON_PRETTY_PRINT);
			//     // echo '</pre>';

			//     if(isset($result['info']['paymentUrl']['web'])){
			//         // echo '<a target="_blank" href="' . $result['info']['paymentUrl']['web'] . '">點此連至 Line 頁面登入帳戶</a>';
			//         redirect($result['info']['paymentUrl']['web']);
			//     }
			// }
			// catch(Exception $e) {
			//     echo '<pre class="code">';
			//     echo $e->getMessage();
			//     echo '</pre>';
			// }

			// Aftee Pay
		} elseif ($this->input->post('checkout_payment') == 'aftee_pay') {

			// 設定各data按照key的字⺟順序排列
			// 物件排列
			if ($cart = $this->cart->contents()):
				foreach ($cart as $item):
					$item = array(
						'shop_item_id' => $item['id'],
						'item_name' => get_product_name($item['id']),
						'item_price' => $item['price'],
						'item_count' => $item['qty'],
						// 'item_url' => base_url().'store/product/'.$item['id'],
					);
					ksort($item);
					$items[] = $item;
				endforeach;
			endif;

			// 運費（若無則不須填寫）
			if (isset($delivery_cost) && $delivery_cost > 0) {
				$item = array(
					'shop_item_id' => 99999,
					'item_name' => '運費',
					'item_price' => $delivery_cost,
					'item_count' => 1,
				);
				ksort($item);
				$items[] = $item;
			}

			// 其他⼿續費（若無則不須填寫）
			// if (isset($sessionData['otherCharges']) && $sessionData['otherCharges'] > 0) {
			//     $item = array(
			//         'shop_item_id' => 'otherCharges',
			//         'item_name' => '其他⼿續費',
			//         'item_price' => $sessionData['otherCharges'],
			//         'item_count' => 1,
			//     );
			//     ksort($item);
			//     $items[] = $item;
			// }

			// 消費者
			$customer = array(
				'customer_name' => $this->input->post('checkout_name'), // 消費者姓名
				'zip_code' => '', // 郵遞區號
				'address' => $this->session->userdata('custom_address'), // 地址
				'email' => $this->input->post('checkout_email'), // 電⼦郵件
			);
			ksort($customer);

			// 收件地址
			$dest_customer = array(
				'dest_customer_name' => '', // 消費者姓名
				'dest_zip_code' => '', // 郵遞區號
				'dest_address' => '', // 地址
				'dest_tel' => $this->input->post('checkout_phone'), // 電話號碼
			);
			ksort($dest_customer);
			$dest_customers[] = $dest_customer;

			// ⽀付data
			$settlementdata = array(
				'amount' => $order_total, // 消費⾦額
				'sales_settled' => 'true', // 交易確認
				'customer' => $customer, // 消費者
				'dest_customers' => $dest_customers, // 收件地址
				'items' => $items, // 商品明細
			);
			ksort($settlementdata);

			// 複數商品的消費⾦額加總
			// foreach ($items as $item){
			//     $settlementdata['amount'] += $item['item_price'] * $item['item_count'];
			// }

			// echo '<pre>';
			// print_r($settlementdata);
			// echo '</pre>';

			// 商家secret key（範例：ATONE_SHOP_SECRET_KEY）⾄於最前⽅
			$checksum = 'HFvym3WHI169nh5TjhrxLA' . ',';
			// 結合付款資訊各要素數值進⾏loop
			foreach ($settlementdata as $key1 => $value1) {
				if (is_array($settlementdata[$key1])) {
					// 要素為陣列（array）（包含關聯數組Associative Array） ->收件地址、消費者
					foreach ($value1 as $key2 => $value2) {
						if (is_array($value1[$key2])) {
							// 要素為item時再⾏loop
							foreach ($value2 as $itemKey => $itemValue) {
								$checksum .= $itemValue;
							}
						} else {
							$checksum .= $value2;
						}
					}
				} else {
					$checksum .= $value1;
				}
			}
			$checksum .= 'mcc00044-00001';

			// echo '<pre>';
			// echo $order_number;
			// echo '</pre>';

			// echo $order_total;

			// echo '<pre>';
			// echo 'checksum: -----> '.$checksum;
			// echo '</pre>';

			// echo '<pre>';
			// echo 'hash sha256: -----> '.hash('sha256', $checksum);
			// echo '</pre>';

			// 字串經sha256轉為hash後再經Base64進⾏encode
			$checksum = base64_encode(hash('sha256', $checksum, true));

			// echo '<pre>';
			// echo 'hash sha256 & base64_encode: -----> '.$checksum;
			// echo '</pre>';

			$this->data['order_number'] = $order_number;
			// $this->data['order_total'] = $order_total;
			$this->data['order_total'] = $order_total;
			$this->data['delivery_cost'] = $delivery_cost;
			$this->data['customer_name'] = $this->input->post('checkout_name');
			$this->data['customer_phone'] = $this->input->post('checkout_phone');
			$this->data['customer_address'] = $this->session->userdata('custom_address');
			$this->data['customer_zipcode'] = $this->session->userdata('zipcode');
			$this->data['customer_email'] = $this->input->post('checkout_email');
			$this->data['order_remark'] = get_empty_remark($this->input->post('checkout_remark'));
			$this->data['checksum'] = $checksum;
			$this->load->view('store/after-pay', $this->data);

		}
	}

	public function order_success() {
		$this->data['page_title'] = '接收訂單';
		$this->render('store/checkout-cash-on-delivery-callback');
	}

	public function credit_pay($order_id) {
		$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		$this_order_item = $this->mysql_model->_select('order_item', 'order_id', $order_id);

		/**
		 *    Credit信用卡付款產生訂單範例
		 */

		//載入SDK(路徑可依系統規劃自行調整)
		include 'ECPay.Payment.Integration.php';
		try {

			$obj = new ECPay_AllInOne();

			// 測試環境
			// $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5"; //服務位置
			// $obj->HashKey     = '5294y06JbISpM5x9' ; //測試用Hashkey，請自行帶入ECPay提供的HashKey
			// $obj->HashIV      = 'v77hoKGq4kWxNNIS' ; //測試用HashIV，請自行帶入ECPay提供的HashIV
			// $obj->MerchantID  = '2000132'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
			// $obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密

			// 正式環境
			$obj->ServiceURL = "https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5"; //服務位置
			$obj->HashKey = 'H2jCwAEjf2VVCbrX'; //測試用Hashkey，請自行帶入ECPay提供的HashKey
			$obj->HashIV = 'e0a5MtggjlNETHFo'; //測試用HashIV，請自行帶入ECPay提供的HashIV
			$obj->MerchantID = '3004957'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
			$obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密

			// 基本參數(請依系統規劃自行調整)
			$order_number = $this_order['order_number'];
			$MerchantTradeNo = $order_number . substr(time(), 4, 6);
			$obj->Send['MerchantTradeNo'] = $MerchantTradeNo; //訂單編號
			$obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
			$obj->Send['TotalAmount'] = floatval($this_order['order_discount_total']); //交易金額
			$obj->Send['TradeDesc'] = get_empty_remark($this_order['order_remark']); //交易描述
			$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit; //付款方式:Credit
			$obj->Send['ReturnURL'] = base_url(); //付款完成通知回傳的網址
			$obj->Send['OrderResultURL'] = base_url() . "store/check_pay/" . $order_number; //付款完成通知回傳的網址
			//$obj->Send['ClientBackURL']     = base_url();                                     //付款完成後，顯示返回商店按鈕

			//$obj->Send['NeedExtraPaidInfo'] = ECPay_ExtraPaymentInfo::Yes;
			//訂單的商品資料
			// array_push($obj->Send['Items'], array(
			//     'Name' => "網路訂單",
			//     'Price' => (int)1000,
			//     'Currency' => "元",
			//     'Quantity' => (int) "1筆",
			//     'URL' => "dedwed"
			// ));

			if (!empty($this_order_item)) {
				foreach ($this_order_item as $item) {
					array_push($obj->Send['Items'], array(
						'Name' => get_product_name($item['product_id']),
						'Price' => (int) $item['order_item_price'],
						'Currency' => "元",
						'Quantity' => (int) $item['order_item_qty'],
						'URL' => "dedwed",
					));
				}}

			// echo '<pre>';
			// print_r($obj);
			// echo '</pre>';

			//Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
			//以下參數不可以跟信用卡定期定額參數一起設定
			$obj->SendExtend['CreditInstallment'] = 0; //分期期數，預設0(不分期)
			$obj->SendExtend['InstallmentAmount'] = 0; //使用刷卡分期的付款金額，預設0(不分期)
			$obj->SendExtend['Redeem'] = false; //是否使用紅利折抵，預設false
			$obj->SendExtend['UnionPay'] = false; //是否為聯營卡，預設false;

			//Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
			//以下參數不可以跟信用卡分期付款參數一起設定
			// $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
			// $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
			// $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
			// $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串

			//產生訂單(auto submit至ECPay)
			$obj->CheckOut();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function check_pay($MerchantTradeNo) {
		$rtncode = @$_POST['RtnCode'];
		// echo $rtncode.'<br>';
		$merchanttradeno = @$_POST['MerchantTradeNo'];
		// $merchanttradeno = substr($merchanttradeno, 0, 14);
		// echo $merchanttradeno.'<br>';
		$order_number = substr($merchanttradeno, 0, 14);

		// 查詢訂單資訊
		$this->db->join('users', 'users.id = orders.customer_id');
		$this->db->where('order_number', $order_number);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$this->data['order'] = $row;
			$this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $row['order_id']);
		}

		if ($rtncode == '1') {

			$data = array(
				'order_pay_status' => 'paid',
				'order_pay_feedback' => get_empty($merchanttradeno),
			);
			$this->db->where('order_number', $order_number);
			$this->db->update('orders', $data);

			// // Start 寄信給買家
			// $this->send_order_email($order_number);

			$this->render('store/checkout-credit-callback');
		} else {
			$this->render('store/checkout-credit-callback-fail');
		}
	}

	public function ecpay_refound($order_id) {
		$order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		$order_number = $order['order_number'];
		$MerchantTradeNo = $order_number . substr(time(), 4, 6);
		// Start 退刷
		// 載入SDK(路徑可依系統規劃自行調整)
		include 'ECPay.Payment.Integration.php';
		try {

			$obj = new ECPay_AllInOne();

			$ThatTime = "20:00:00";
			if (time() >= strtotime($ThatTime)) {
				$action = 'R';
			} else {
				$action = 'N';
			}

			// $capture = array(
			//     'MerchantID' => '3004957',
			//     'MerchantTradeNo' => $order['order_pay_feedback'],
			//     'CaptureAMT' => 0,
			//     'UserRefundAMT' => 0
			// );

			// $tradeNo = array(
			//     'DateType' => '',
			//     'BeginDate' => '',
			//     'EndDate' => '',
			//     'MediaFormated' => ''
			// );

			$the_action_arr = array(
				'MerchantID' => '3004957',
				// 'MerchantTradeNo' => $MerchantTradeNo,
				'MerchantTradeNo' => $order['order_pay_feedback'],
				'TradeNo' => $order['order_pay_feedback'],
				'Action' => $action,
				'TotalAmount' => floatval($order['order_discount_total']),
				'CheckMacValue' => 1,
				'EncryptType' => 1,
			);

			$obj->ServiceURL = "https://payment.ecpay.com.tw/CreditDetail/DoAction"; //服務位置
			$obj->HashKey = 'H2jCwAEjf2VVCbrX'; //測試用Hashkey，請自行帶入ECPay提供的HashKey
			$obj->HashIV = 'e0a5MtggjlNETHFo'; //測試用HashIV，請自行帶入ECPay提供的HashIV
			$obj->MerchantID = '3004957'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
			$obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密

			// $obj->MerchantTradeNo   = $MerchantTradeNo;                                 //訂單編號
			// $obj->MerchantTradeDate = date('Y/m/d H:i:s');                              //交易時間
			// $obj->TotalAmount       = floatval($this_order['order_discount_total']);    //交易金額
			// $obj->TradeDesc         = get_empty_remark($this_order['order_remark']);    //交易描述
			// $obj->ChoosePayment     = ECPay_PaymentMethod::Credit;                     //付款方式:Credit
			// $obj->ReturnURL         = base_url();                                       //付款完成通知回傳的網址
			// $obj->OrderResultURL    = base_url()."store/check_pay/".$order_number;      //付款完成通知回傳的網址

			// $obj->Capture = $capture;
			// $obj->TradeNo = $tradeNo;
			$obj->Action = $the_action_arr;

			$obj->DoAction();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		// End 退刷
	}

	public function line_pay($order_id) {
		$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		// $this_order_item = $this->mysql_model->_select('order_item', 'order_id', $order_id);

		$channelId = "1605255943"; // 通路ID
		$channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰
		// Get Base URL path without filename
		// $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);
		$input = $_POST;
		// $input['isSandbox'] = (isset($input['isSandbox'])) ? true : false;
		// $input['isSandbox'] = true;
		$input['isSandbox'] = false;
		// Create LINE Pay client
		$linePay = new \yidas\linePay\Client([
			'channelId' => $channelId,
			'channelSecret' => $channelSecret,
			'isSandbox' => $input['isSandbox'],
		]);
		// Create an order based on Reserve API parameters
		$orderParams = [
			"amount" => floatval($this_order['order_discount_total']),
			"currency" => 'TWD',
			"orderId" => $this_order['order_number'],
			"packages" => [
				[
					"id" => "test1",
					"amount" => floatval($this_order['order_discount_total']),
					"name" => "package name",
					"products" => [
						[
							"name" => 'Bytheway - 外送餐點',
							"quantity" => 1,
							"price" => floatval($this_order['order_discount_total']),
							"imageUrl" => 'https://bytheway.com.tw/assets/images/line_pay_img.jpg',
						],
					],
				],
			],
			"redirectUrls" => [
				"confirmUrl" => base_url() . "store/line_pay_confirm",
				"cancelUrl" => base_url(),
			],
			"options" => [
				"display" => [
					"checkConfirmUrlBrowser" => true,
				],
			],
		];
		// Online Reserve API
		$response = $linePay->request($orderParams);
		// Check Reserve API result
		if (!$response->isSuccessful()) {
			die("<script>alert('ErrorCode {$response['returnCode']}: " . addslashes($response['returnMessage']) . "');history.back();</script>");
		}
		// Save the order info to session for confirm
		$_SESSION['linePayOrder'] = [
			'transactionId' => (string) $response["info"]["transactionId"],
			'params' => $orderParams,
			'isSandbox' => $input['isSandbox'],
		];
		// Save input for next process and next form
		$_SESSION['config'] = $input;
		// Redirect to LINE Pay payment URL
		header('Location: ' . $response->getPaymentUrl());
	}

	public function line_pay_confirm() {
		// New -----
		$channelId = "1605255943"; // 通路ID
		$channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰
		// Get saved config
		$config = $_SESSION['config'];
		// Create LINE Pay client
		$linePay = new \yidas\linePay\Client([
			'channelId' => $channelId,
			'channelSecret' => $channelSecret,
			'isSandbox' => ($config['isSandbox']) ? true : false,
		]);
		// Successful page URL
		$successUrl = base_url();
		// Get the transactionId from query parameters
		$transactionId = (string) $_GET['transactionId'];
		// Get the order from session
		$order = $_SESSION['linePayOrder'];
		// Check transactionId (Optional)
		if ($order['transactionId'] != $transactionId) {
			die("<script>alert('TransactionId doesn\'t match');location.href=" . base_url() . ";</script>");
		}
		// Online Confirm API
		try {
			$response = $linePay->confirm($order['transactionId'], [
				'amount' => (integer) $order['params']['amount'],
				'currency' => $order['params']['currency'],
			]);
		} catch (\yidas\linePay\exception\ConnectException $e) {

			// Implement recheck process
			die("Confirm API timeout! A recheck mechanism should be implemented.");
		}
		// Save error info if confirm fails
		if (!$response->isSuccessful()) {
			$_SESSION['linePayOrder']['confirmCode'] = $response['returnCode'];
			$_SESSION['linePayOrder']['confirmMessage'] = $response['returnMessage'];
			$_SESSION['linePayOrder']['isSuccessful'] = false;
			die("<script>alert('Refund Failed\\nErrorCode: {$_SESSION['linePayOrder']['confirmCode']}\\nErrorMessage: {$_SESSION['linePayOrder']['confirmMessage']}');location.href='{$successUrl}';</script>");
		}
		// Code for saving the successful order into your application database...
		$_SESSION['linePayOrder']['isSuccessful'] = true;

		$rtncode = $response['returnCode'];
		$return_order_id = $response['info']['orderId'];
		$order_number = $return_order_id;

		// 查詢訂單資訊
		$this->db->join('users', 'users.id = orders.customer_id');
		$this->db->where('order_number', $order_number);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$this->data['order'] = $row;
			$this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $row['order_id']);
		}

		if ($rtncode == '0000') {

			$update_data = array(
				'order_pay_status' => 'paid',
				'order_pay_feedback' => get_empty($transactionId),
			);
			$this->db->where('order_number', $order_number);
			$this->db->update('orders', $update_data);

			// // Start 寄信給買家
			// $this->send_order_email($order_number);

			$this->render('store/checkout-line-pay-callback');

		}
		// Redirect to successful page
		// header("Location: {$successUrl}");

		// Old -----
		// require_once("Chinwei6_LinePay.php");

		// if(isset($_GET['transactionId']) && isset($_SESSION['cache'])) {
		//     $apiEndpoint   = $_SESSION['cache']['apiEndpoint'];
		//     $channelId     = $_SESSION['cache']['channelId'];
		//     $channelSecret = $_SESSION['cache']['channelSecret'];

		//     $params = [
		//         "amount"   => $_SESSION['cache']['amount'],
		//         "currency" => $_SESSION['cache']['currency'],
		//     ];

		//     try {
		//         $LinePay = new Chinwei6\LinePay($apiEndpoint, $channelId, $channelSecret);

		//         $result = $LinePay->confirm($_GET['transactionId'], $params);
		//         // echo '<pre class="code">';
		//         // echo json_encode($result, JSON_PRETTY_PRINT);
		//         // echo '</pre>';

		//         $rtncode = $result['returnCode'];
		//         $return_order_id = $result['info']['orderId'];
		//         $order_number = $return_order_id;

		//         // 查詢訂單資訊
		//         $this->db->join('users', 'users.id = orders.customer_id');
		//         $this->db->where('order_number', $order_number);
		//         $this->db->limit(1);
		//         $query = $this->db->get('orders');
		//         if($query->num_rows()>0){
		//             $row = $query->row_array();
		//             $this->data['order'] = $row;
		//             $this->data['order_item'] = $this->mysql_model->_select('order_item','order_id', $row['order_id']);
		//         }

		//         if($rtncode == '0000'){

		//             $update_data = array(
		//                 'order_pay_status' => 'paid',
		//                 'order_pay_feedback' => get_empty($result['info']['transactionId']),
		//             );
		//             $this->db->where('order_number', $order_number);
		//             $this->db->update('orders', $update_data);

		//             // Start 寄信給買家
		//             $this->send_order_email($order_number);

		//             $this->render('store/checkout-line-pay-callback');
		//         }

		//     }
		//     catch(Exception $e) {
		//         echo '<pre class="code">';
		//         echo $e->getMessage();
		//         echo '</pre>';
		//     }

		//     unset($_SESSION['cache']);
		// } else {
		//     echo '<pre class="code">';
		//     echo "No Params";
		//     echo '</pre>';
		// }

	}

	// public function line_pay_refund($order_id)
	// {
	//     $this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
	//     if(empty($this_order['order_pay_feedback'])){
	//         header("Location: ".base_url()."");
	//     } else {

	//         $channelId     = "1605255943"; // 通路ID
	//         $channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰
	//         // Get saved config
	//         // $config = $_SESSION['config'];
	//         // $config['isSandbox'] = true;
	//         $config['isSandbox'] = false;
	//         // Create LINE Pay client
	//         $linePay = new \yidas\linePay\Client([
	//             'channelId' => $channelId,
	//             'channelSecret' => $channelSecret,
	//             'isSandbox' => ($config['isSandbox']) ? true : false,
	//         ]);
	//         // Successful page URL
	//         $successUrl = base_url().'order';
	//         // Get the transactionId from query parameters
	//         $transactionId = (string) $this_order['order_pay_feedback'];
	//         // Get the order from session
	//         // $order = $_SESSION['linePayOrder'];
	//         // Check transactionId (Optional)
	//         // if ($order['transactionId'] != $transactionId) {
	//         //     die("<script>alert('TransactionId doesn\'t match');location.href='".base_url()."';</script>");
	//         // }
	//         // API
	//         try {
	//             // Online Refund API
	//             $refundParams = ($this_order['order_discount_total']!="") ? ['refundAmount' => (integer) $this_order['order_discount_total']] : null;
	//             // $response = $linePay->refund($order['transactionId'], $refundParams);
	//             $response = $linePay->refund($this_order['order_pay_feedback'], $refundParams);

	//             // Save error info if confirm fails
	//             if (!$response->isSuccessful()) {
	//                 die("<script>alert('Refund Failed\\nErrorCode: {$response['returnCode']}\\nErrorMessage: {$response['returnMessage']}');location.href='{$successUrl}';</script>");
	//             }
	//             // Use Details API to confirm the transaction and get refund detail info
	//             $response = $linePay->details([
	//                 // 'transactionId' => [$order['transactionId']],
	//                 'transactionId' => $this_order['order_pay_feedback'],
	//             ]);
	//             // Check the transaction
	//             if (!isset($response["info"][0]['refundList']) || $response["info"][0]['transactionId'] != $transactionId) {
	//                 die("<script>alert('Refund Failed');location.href='{$successUrl}';</script>");
	//             }
	//         } catch (\yidas\linePay\exception\ConnectException $e) {

	//             // Implement recheck process
	//             die("Refund/Details API timeout! A recheck mechanism should be implemented.");
	//         }
	//         // Code for saving the successful order into your application database...
	//         $_SESSION['linePayOrder']['refundList'] = $response["info"][0]['refundList'];
	//         // Redirect to successful page
	//         header("Location: {$successUrl}");

	//     }
	// }

	public function atm() {
		$this->data['page_title'] = 'ATM付款';
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->render('store/checkout-atm-callback');
	}

	public function credit() {
		$this->data['page_title'] = '信用卡付款';
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->render('store/checkout-credit-callback');
	}

	public function credit_fail() {
		$this->data['page_title'] = '信用卡付款失敗';
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->render('store/checkout-credit-callback-fail');
	}

	public function after_pay_checksum() {

		// 設定各data按照key的字⺟順序排列
		// 物件排列
		$item = array(
			'shop_item_id' => 1,
			'item_name' => '牛肉麵',
			'item_price' => 100,
			'item_count' => 1,
		);
		ksort($item);
		$items[] = $item;

		// 運費（若無則不須填寫）
		$item = array(
			'shop_item_id' => 99999,
			'item_name' => '運費',
			'item_price' => 200,
			'item_count' => 1,
		);
		ksort($item);
		$items[] = $item;

		// 其他⼿續費（若無則不須填寫）
		// if (isset($sessionData['otherCharges']) && $sessionData['otherCharges'] > 0) {
		//     $item = array(
		//         'shop_item_id' => 'otherCharges',
		//         'item_name' => '其他⼿續費',
		//         'item_price' => $sessionData['otherCharges'],
		//         'item_count' => 1,
		//     );
		//     ksort($item);
		//     $items[] = $item;
		// }

		// 消費者
		$customer = array(
			'customer_name' => 'ADMIN', // 消費者姓名
			'zip_code' => '', // 郵遞區號
			'address' => '臺北市中山區遼寧街224號', // 地址
			'email' => 'admin@admin.com', // 電⼦郵件
		);
		ksort($customer);

		// 收件地址
		$dest_customer = array(
			'dest_customer_name' => '', // 消費者姓名
			'dest_zip_code' => '', // 郵遞區號
			'dest_address' => '', // 地址
			'dest_tel' => '0921168585', // 電話號碼
		);
		ksort($dest_customer);
		$dest_customers[] = $dest_customer;

		// ⽀付data
		$settlementdata = array(
			'amount' => 300, // 消費⾦額
			'sales_settled' => 'true', // 交易確認
			'customer' => $customer, // 消費者
			'dest_customers' => $dest_customers, // 收件地址
			'items' => $items, // 商品明細
		);
		ksort($settlementdata);

		// 複數商品的消費⾦額加總
		// foreach ($items as $item){
		//     $settlementdata['amount'] += $item['item_price'] * $item['item_count'];
		// }

		// echo '<pre>';
		// print_r($settlementdata);
		// echo '</pre>';

		// 商家secret key（範例：ATONE_SHOP_SECRET_KEY）⾄於最前⽅
		$checksum = 'HFvym3WHI169nh5TjhrxLA' . ',';
		// 結合付款資訊各要素數值進⾏loop
		foreach ($settlementdata as $key1 => $value1) {
			if (is_array($settlementdata[$key1])) {
				// 要素為陣列（array）（包含關聯數組Associative Array） ->收件地址、消費者
				foreach ($value1 as $key2 => $value2) {
					if (is_array($value1[$key2])) {
						// 要素為item時再⾏loop
						foreach ($value2 as $itemKey => $itemValue) {
							$checksum .= $itemValue;
						}
					} else {
						$checksum .= $value2;
					}
				}
			} else {
				$checksum .= $value1;
			}
		}
		$checksum .= 'shop-user-no-001';

		// echo $order_total;

		// echo '<pre>';
		// echo 'checksum: -----> '.$checksum;
		// echo '</pre>';

		// echo '<pre>';
		// echo 'hash sha256: -----> '.hash('sha256', $checksum);
		// echo '</pre>';

		// 字串經sha256轉為hash後再經Base64進⾏encode
		$checksum = base64_encode(hash('sha256', $checksum, true));
		// echo '<pre>';
		// echo 'hash sha256 & base64_encode: -----> '.$checksum;
		// echo '</pre>';

		$data['checksum'] = $checksum;
		$this->load->view('store/after-pay-test.php', $data);
	}

	public function after_pay_confirm() {
		// $order_number = $this->input->post('order_number');
		$order_number = $this->input->get('order_number');

		$update_data = array(
			'order_pay_status' => 'paid',
		);
		$this->db->where('order_number', $order_number);
		$this->db->update('orders', $update_data);

		// Start 寄信給買家
		// $this->send_order_email($order_number);

		// echo $order_number;

		// $this->render('store/checkout-line-pay-callback');

		redirect(base_url() . 'store/after_pay_success/' . $order_number, 'refresh');

	}

	public function after_pay_success($order_number) {
		// 查詢訂單資訊
		$this->db->join('users', 'users.id = orders.customer_id');
		$this->db->where('order_number', $order_number);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$this->data['order'] = $row;
			$this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $row['order_id']);
		}

		$this->render('store/checkout-after-pay-callback');
	}

	public function send_order_email_page() {
		$this->render('store/send-order-email');
	}

	public function send_order_email($order_number) {
		// 查詢訂單資訊
		$this->db->join('users', 'users.id = orders.customer_id');
		$this->db->where('order_number', $order_number);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			$this->db->where('order_id', $row['order_id']);
			$query2 = $this->db->get('order_item');
		}

		$subject = '非常感謝您，您的訂單已接收 - ' . get_setting_general('name');

		$header = '<img src="' . base_url() . 'assets/uploads/' . get_setting_general('logo') . '" height="100px">
        <h3>' . $row['full_name'] . ' 您好：</h3>
        <h3>您在 ' . get_setting_general('name') . ' 的訂單已完成訂購，以下是您的訂單明細：</h3>';

		$message = '<table style="width:100%;background:#fafaf8;padding:15px;">
        <tr style="border-bottom:2px solid #e41c10;">
            <td><h3>【訂購明細】</h3><hr></td>
        </tr>
        <tr>
            <td>
                店家名稱 : ' . get_store_name($row['store_id']) . '
            </td>
        </tr>
        <tr>
            <td>
                訂單編號 : ' . $row['order_number'] . '
            </td>
        </tr>
        <tr>
            <td>
                付款方式 : ' . get_payment($row['order_payment']) . '
            </td>
        </tr>
        <tr>
            <td>
                訂單狀況 : 接收訂單
            </td>
        </tr>
        <tr>
            <td>
                訂購日期 : ' . $row['order_date'] . '
            </td>
        </tr>
        </table>
        ';

		$content = '<table cellpadding="6" cellspacing="1" style="width:100%" border="0">';

		$content .= '<tr>';
		$content .= '<th style="text-align:left;">商品名稱</th>';
		$content .= '<th style="text-align:right;">價格</th>';
		$content .= '<th style="text-align:center;">數量</th>';
		$content .= '<th style="text-align:right">小計</th>';
		$content .= '</tr>';

		$i = 1;
		$total = 0;
		if ($query2->num_rows() > 0) {
			foreach ($query2->result_array() as $items) {
				$content .= '<tr>';
				$content .= '<td>' . get_product_name($items['product_id']);
				$content .= '</td>';
				$content .= '<td style="text-align:right">NT$ ' . number_format($items['order_item_price']) . '</td>';
				$content .= '<td style="text-align:center">' . $items['order_item_qty'] . '</td>';
				$content .= '<td style="text-align:right">NT$ ' . number_format($items['order_item_price'] * $items['order_item_qty']) . '</td>';
				$content .= '</tr>';
				$total += $items['order_item_qty'] * $items['order_item_price'];
				$i++;
			}};

		$content .= '<tr><td colspan="4"><hr></td></tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:right"><strong>小計</strong></td>';
		$content .= '<td style="text-align:right">NT$ ' . number_format($total) . '</td>';
		$content .= '</tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:right"><strong>運費</strong></td>';
		$content .= '<td style="text-align:right">NT$ ' . number_format($row['order_delivery_cost']) . '</td>';
		$content .= '</tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:right"><strong>優惠券折抵</strong></td>';
		$content .= '<td style="text-align:right">NT$ -' . number_format($row['order_discount_price']) . '</td>';
		$content .= '</tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:right"><strong>總計</strong></td>';
		$content .= '<td style="text-align:right">NT$ ' . number_format($row['order_discount_total']) . '</td>';
		$content .= '</tr>';
		$content .= '<tr><td colspan="4" text-align="center"><a href="' . base_url() . 'order" target="_blank" class="order-check-btn"style="color: #000;">訂單查詢</a></td></tr>';

		$content .= '</table>';

		$information = '<table style="width:100%;background:#fafaf8;padding:15px;">
        <tr style="border-bottom:2px solid #e41c10;">
            <td><h3>【收件資訊】</h3><hr></td>
        </tr>
        <tr>
            <td>
                收件姓名 : ' . $row['customer_name'] . '
            </td>
        </tr>
        <tr>
            <td>
                聯絡電話 : ' . $row['customer_phone'] . '
            </td>
        </tr>
        <tr>
            <td>
                收件地址 : ' . $row['order_delivery_address'] . '
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:100%;background:#fff;padding:15px 0px 15px 10px;border:1px dashed #979797;">
                    備註 : ' . $row['order_remark'] . '
                </div>
            </td>
        </tr>
        </table>
        ';

		$footer = '<div style="width:750px;height:70px;;background:#f0f6fa;"><span style="display:block;padding:15px;font-size:12px;">此郵件是系統自動傳送，請勿直接回覆此郵件</span><div>';

		// Get full html:
		$body = '<html>
          <head>
            <style>
                #main-div{
                    font-family: Microsoft JhengHei;
                    color : #222;
                }
                .right{
                    text-align: right;
                }
                .order-check-btn{
                    display:block;
                    margin:10px auto;
                    width:180px;
                    height:40px;
                    line-height:40px;
                    background:#e7462b;
                    border-bottom:3px solid #cf3020;
                    border-radius:5px;
                    font-size:16px;
                    text-align:center;
                    text-decoration:none;
                    color:#fff;
                }
            </style>
          </head>
          <body>
            <div id="main-div" style="max-width:750px;font-size:14px;border:1px solid #979797; padding:20px;">
                ' . $header . '
                ' . $message . '
                ' . $content . '
                ' . $information . '
                ' . $footer . '
            </div>
          </body>
        </html>';

		$this->load->library('email');

		// 寄信給賣家
		$this->email->set_smtp_host("mail.kuangli.tw");
		$this->email->set_smtp_user("btw@kuangli.tw");
		$this->email->set_smtp_pass("Btw@admin");
		$this->email->set_smtp_port("587");
		$this->email->set_smtp_crypto("");

		$this->email->to($row['customer_email']);
		$this->email->from(get_setting_general('email'), get_setting_general('name'));
		$this->email->subject($subject);
		$this->email->message($body);
		if ($this->email->send()) {
			// echo "<h4>Send Mail is Success.</h4>";
		} else {
			// echo "<h4>Send Mail is Fail.</h4>";
		}

		// 寄信給店家
		$subject = '有新的訂單 - 單號：' . $row['order_number'];
		$this->email->set_smtp_host("mail.kuangli.tw");
		$this->email->set_smtp_user("btw@kuangli.tw");
		$this->email->set_smtp_pass("Btw@admin");
		$this->email->set_smtp_port("587");
		$this->email->set_smtp_crypto("");

		// $this->email->to(get_setting_general('email'));
		// $this->email->to('shung.lung@haohuagroup.com.tw','peizhen@haohuagroup.com.tw','carina.fan@haohuagroup.com.tw');
		$list = array(get_setting_general('email1'), get_setting_general('email2'), get_setting_general('email3'));
		$this->email->to($list);
		$this->email->from(get_setting_general('email'), get_setting_general('name'));
		$this->email->subject($subject);
		$this->email->message($body);
		if ($this->email->send()) {
			// echo "<h4>Send Mail is Success.</h4>";
		} else {
			// echo "<h4>Send Mail is Fail.</h4>";
		}
	}

	public function test_send_email() {
		//Load email library
		$this->load->library('email');

		$this->email->set_smtp_host("mail.kuangli.tw");
		$this->email->set_smtp_user("btw@kuangli.tw");
		$this->email->set_smtp_pass("Btw@admin");
		$this->email->set_smtp_port("587");
		$this->email->set_smtp_crypto("");

		//Email content
		$htmlContent = '<h1>Sending email via SMTP server</h1>';
		$htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

		$list = array('a0935756869@gmail.com', 'sianming30@gmail.com', 'sianming31@gmail.com');
		$this->email->to($list);
		// $this->email->to('a0935756869@gmail.com', 'sianming30@gmail.com', 'sianming31@gmail.com');
		$this->email->from('service1@bythewaytaiwan.com', get_setting_general('name'));
		$this->email->subject('How to send email via SMTP server in CodeIgniter');
		$this->email->message($htmlContent);

		//Send email
		if ($this->email->send()) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function load_cart() {
		$output = '';
		foreach ($this->cart->contents() as $items) {
			$output .= '
        <tr>
            <td>
                <ul id="orderlist" style="margin-bottom: 0px; border: none;">
                    <li>
                        <div class="col-md-4" style="padding-left: 5px; padding-right: 5px;">
                            <p class="pull-left fs-13 color-595757">' . $items['name'] . '</p>
                        </div>
                        <div class="col-md-2 text-center" style="padding-left: 5px; padding-right: 5px;">╳ ' . $items['qty'] . '</div>
                        <div class="col-md-4" style="padding-left: 5px; padding-right: 5px;">
                            <p class="pull-right fs-13 color-595757">NT$ ' . $items['subtotal'] . '</p>
                        </div>
                        <div class="col-md-1 pull-right" style="padding-left: 5px;">
                            <img src="/assets/images/store/delete-btn.png" class="remove_item" id="cart_' . $items['id'] . '" data-id="' . $items['id'] . '" data-rowid="' . $items["rowid"] . '" height="16px" style="margin-top: -2px; cursor: pointer;">
                        </div>
                    </li>
                </ul>
            </td>
        </tr>';
		}

		if (empty($this->cart->contents())) {
			$output = '<tr>
            <td>
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <h4 class="fs-13 color-221814">您尚未選擇餐點</h4>
                    </div>
                </div>
            </td>
        </tr>';
		}

		echo $output;
	}

	public function load_cart_no_remove() {
		$output = '';
		foreach ($this->cart->contents() as $items) {
			$output .= '
        <tr>
            <td>
                <ul id="orderlist" style="margin-bottom: 0px; border: none;">
                    <li>
                        <div class="col-md-4" style="padding-left: 5px; padding-right: 5px;">
                            <p class="pull-left fs-13 color-595757">' . $items['name'] . '</p>
                        </div>
                        <div class="col-md-4 text-center" style="padding-left: 5px; padding-right: 5px;">╳ ' . $items['qty'] . '</div>
                        <div class="col-md-4" style="padding-left: 5px; padding-right: 5px;">
                            <p class="pull-right fs-13 color-595757">NT$ ' . $items['subtotal'] . '</p>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>';
		}

		if (empty($this->cart->contents())) {
			$output = '<tr>
            <td>
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <h4 class="fs-13 color-221814">您尚未選擇餐點</h4>
                    </div>
                </div>
            </td>
        </tr>';
		}

		echo $output;
	}

	public function load_cart_price() {
		// 判斷是否滿%元免運
		$delivery_cost = ((get_setting_general('is_no_delivery_cost') == '1' && get_setting_general('is_no_delivery_cost_number') != '' && get_setting_general('is_no_delivery_cost_number') != '0' && $this->cart->total() >= get_setting_general('is_no_delivery_cost_number')) ? ('0') : ($this->session->userdata('delivery_cost')));

		// 判斷是否全站免運
		if ($delivery_cost != 0) {
			$delivery_cost = ((get_setting_general('all_no_delivery_cost') == '') ? ($this->session->userdata('delivery_cost')) : ('0'));
		}

		// 服務費
		// $service_cost = ((get_setting_general('no_service_cost')=='')?(round($this->cart->total()*0.1)):('0'));
		$service_cost = 0;

		$discount_price = 0;
		if ($this->session->userdata('coupon_method') == 'cash') {
			$discount_price += $this->session->userdata('coupon_price');
		}

		if ($this->session->userdata('coupon_method') == 'percent') {
			$discount_price += $this->cart->total() * (1 - $this->session->userdata('coupon_price'));
		}

		if ($this->session->userdata('coupon_method') == 'free_shipping') {
			$delivery_cost = 0;
		}

		$order_total = intval((($this->cart->total() + $delivery_cost) + $service_cost) - $discount_price);

		$output = '';
		$output .= '
        <li>
            <div class="col-md-6">
                <p class="pull-left fs-13 color-595757">小計：</p>
            </div>
            <div class="col-md-6">
                <p class="pull-right fs-13 color-595757">NT$ ' . $this->cart->total() . '</p>
            </div>
        </li>
        <li>
            <div class="col-md-6">
                <p class="pull-left fs-13 color-595757">運費：</p>
            </div>
            <div class="col-md-6">
                <p class="pull-right fs-13 color-595757">NT$ ' . $delivery_cost . '</p>
            </div>
        </li>
        <li style="display: none;">
            <div class="col-md-6">
                <p class="pull-left fs-13 color-595757">服務費：</p>
            </div>
            <div class="col-md-6">
                <p class="pull-right fs-13 color-595757">NT$ ' . $service_cost . '</p>
            </div>
        </li>
        <li>
            <div class="col-md-6">
                <p class="pull-left fs-13 color-595757">優惠券折抵：</p>
            </div>
            <div class="col-md-6">
                <p class="pull-right fs-13 color-595757">NT$ -' . number_format($discount_price) . '</p>
            </div>
        </li>
        <li>
            <hr style="background: #3bccde; color: #3bccde; height: 3px">
        </li>
        <li>
            <div class="col-md-6">
                <p class="pull-left fs-16 color-595757 bold">總計</p>
            </div>
            <div class="col-md-6">
                <p class="pull-right fs-16 color-595757 bold">NT$ ' . $order_total . '</p>
            </div>
        </li>
        ';
		echo $output;
	}

	public function get_order_total() {
		// 判斷是否滿%元免運
		$delivery_cost = ((get_setting_general('is_no_delivery_cost') == '1' && get_setting_general('is_no_delivery_cost_number') != '' && get_setting_general('is_no_delivery_cost_number') != '0' && $this->cart->total() >= get_setting_general('is_no_delivery_cost_number')) ? ('0') : ($this->session->userdata('delivery_cost')));

		// 判斷是否全站免運
		if ($delivery_cost != 0) {
			$delivery_cost = ((get_setting_general('all_no_delivery_cost') == '') ? ($this->session->userdata('delivery_cost')) : ('0'));
		}

		// 服務費
		// $service_cost = ((get_setting_general('no_service_cost')=='')?(round($this->cart->total()*0.1)):('0'));
		$service_cost = 0;

		$discount_price = 0;
		if ($this->session->userdata('coupon_method') == 'cash') {
			$discount_price += $this->session->userdata('coupon_price');
		}

		if ($this->session->userdata('coupon_method') == 'percent') {
			$discount_price += $this->cart->total() * (1 - $this->session->userdata('coupon_price'));
		}

		if ($this->session->userdata('coupon_method') == 'free_shipping') {
			$delivery_cost = 0;
		}

		$order_total = intval((($this->cart->total() + $delivery_cost) + $service_cost) - $discount_price);

		return $order_total;
	}

	public function send_sms() {
		$phone = $this->input->post('phone');
		$code = $this->input->post('code');
		// $code = str_pad(rand(0, pow(10, 5) - 1), 5, '0', STR_PAD_LEFT);
		$bitly = 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=52414831&password=haohua&dstaddr=' . $phone . '&encoding=UTF8&smbody=歡迎您加入Bytheway順便一提，您的手機驗證碼為: 「 ' . $code . ' 」。請於十分鐘內完成註冊程序。&response=http://192.168.1.200/smreply.asp';

		// $bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;

		// get the url
		//could also use cURL here
		file_get_contents($bitly);
		// $response = file_get_contents($bitly);

		// //根據 json 還是 xml 來解析回傳內容
		// if(strtolower($format) == 'json')
		// {
		//     // $json = @json_decode($response,true);
		//     $json = @json_decode($bitly,true);
		//     return $json['results'][$url]['shortUrl'];
		// } else {
		//     $xml = simplexml_load_string($response);
		//     return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
		// }
	}

	public function update_order_step() {
		// $sql = "UPDATE orders SET order_step = 'prepare' WHERE order_date = '".date('Y-m-d')."'";
		$update_data = array(
			'order_step' => 'prepare',
		);
		$this->db->where('order_date', date('Y-m-d'));
		if ($this->db->update('orders', $update_data)) {
			echo 'O訂單狀態更新成功。';
		} else {
			echo 'X訂單狀態更新失敗。';
		}
	}

	public function get_user_address() {
		$this->db->where('user_id', $this->ion_auth->user()->row()->id);
		$this->db->where('used', 1);
		$query = $this->db->get('users_address');
		if ($query->num_rows() > 0) {
			$row = $query->result_array();
			header('Content-Type: application/json');
			echo json_encode($row, JSON_PRETTY_PRINT);
		} else {
			echo 0;
		}
	}

	public function test() {
		$date = date('Y-m-d');
		$ymd = date('Ymd');
		$h = date('H');
		$this->db->like('order_number', $ymd, 'after');
		$this->db->order_by('order_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$aaa = $row->order_number;
			$bbb = substr($aaa, 0, 12);
			$order_number = $bbb += 1;
			$order_number = $order_number . $h;
		} else {
			$order_number = $ymd . '0901' . $h;
		}
		echo $order_number;
	}

	public function test111() {
		$url = "https://maps.google.com/maps/api/geocode/json?address=台北市內湖區中山北路六段100號&sensor=false&language=zh-TW&key=AIzaSyBzfMl1G0OrMw6cdVydIA4vxiGFmX9P-TI";
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
					$return = array(
						'lat' => $response_a->results[0]->geometry->location->lat,
						'lng' => $response_a->results[0]->geometry->location->lng,
						// 'county' => $response_a->results[0]->address_components[3]->long_name,
						'district' => $response_a->results[0]->address_components[$i]->long_name,
						// 'zipcode' => $response_a->results[0]->address_components[5]->long_name
					);
				}
				if ($response_a->results[0]->address_components[$i]->types[0] == 'administrative_area_level_1') {
					$return['county'] = $response_a->results[0]->address_components[$i]->long_name;
				}
			}
			echo '<pre>';
			print_r($return);
			echo '</pre>';

			// return $return;
		}
	}

}