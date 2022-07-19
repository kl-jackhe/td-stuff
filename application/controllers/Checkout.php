<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('home_model');
		$this->load->model('service_area_model');
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['page_title'] = '結帳';
		$this->data['hide_county'] = $this->service_area_model->get_hide_county();
		$this->data['hide_district'] = $this->service_area_model->get_hide_district();
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
		$this->render('checkout/index');
	}

	public function save_order() {
		$this->data['page_title'] = '結帳';
		// if (!$this->ion_auth->logged_in()) {
		// 	redirect('login', 'refresh');
		// }

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
		// $delivery_cost = ((get_setting_general('is_no_delivery_cost') == '1' && get_setting_general('is_no_delivery_cost_number') != '' && get_setting_general('is_no_delivery_cost_number') != '0' && $this->cart->total() >= get_setting_general('is_no_delivery_cost_number')) ? ('0') : ($this->session->userdata('delivery_cost')));

		// 判斷是否全站免運
		// if ($delivery_cost != 0) {
		// 	$delivery_cost = (get_setting_general('all_no_delivery_cost') == '') ? ($this->session->userdata('delivery_cost')) : ('0');
		// }

		// 服務費
		// $service_cost = ((get_setting_general('no_service_cost')=='')?(round($this->cart->total()*0.1)):('0'));
		// $service_cost = 0;

		// $discount_price = 0;
		// if ($this->session->userdata('coupon_method') == 'cash') {
		// 	$discount_price += $this->session->userdata('coupon_price');
		// }

		// if ($this->session->userdata('coupon_method') == 'percent') {
		// 	$discount_price += $this->cart->total() * (1 - $this->session->userdata('coupon_price'));
		// }

		// if ($this->session->userdata('coupon_method') == 'free_shipping') {
		// 	$delivery_cost = 0;
		// }

		// $order_total = intval((($this->cart->total() + $delivery_cost) + $service_cost) - $discount_price);

		$order = array(
			'order_number' => $order_number,
			// 'order_date' => $this->session->userdata('delivery_date'),
			// 'store_id' => $this->session->userdata('store'),
			// 'customer_id' => $this->ion_auth->user()->row()->id,
			'customer_name' => $this->input->post('checkout_name'),
			'customer_phone' => $this->input->post('checkout_phone'),
			'customer_email' => $this->input->post('checkout_email'),
			'order_total' => $this->input->post('order_total'),
			// 'order_total' => (($this->cart->total() + $delivery_cost) + $service_cost),
			// 'order_discount_total' => $order_total,
			// 'order_discount_price' => get_empty($discount_price),
			// 'order_delivery_cost' => get_empty($delivery_cost),
			// 'order_delivery_place' => get_empty($this->session->userdata('delivery_place')),
			// 'order_delivery_address' => get_empty($this->session->userdata('custom_address')),
			// 'order_delivery_time' => get_empty($this->session->userdata('delivery_time')),
			'order_payment' => $this->input->post('checkout_payment'),
			'order_pay_status' => 'not_paid',
			// 'order_coupon' => get_empty($this->session->userdata('coupon_id')),
			// 'order_step' => 'accept',
			// 'order_remark' => $this->input->post('checkout_remark'),
			// 'creator_id' => $this->ion_auth->user()->row()->id,
			// 'created_at' => $created_at,
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
		header('Location: /home/');
	}
	public function form_check() {
		// 如果是今天的話
		// $delivery_date = $this->session->userdata('delivery_date');
		// $delivery_time = $this->session->userdata('delivery_time');
		// // $delivery_date = '2019-09-17';
		// // $delivery_time = '11:00-11:30';
		// if ($delivery_date == date('Y-m-d')) {

		// 	if (date('H:i') < substr($delivery_time, 0, 5)) {
		// 		echo 'yes';
		// 	} else {
		// 		echo 'no';
		// 	}

		// } else {
		// 	echo 'yes';
		// }
		echo 'yes';
	}
}