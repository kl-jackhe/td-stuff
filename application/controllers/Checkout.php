<?php defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends Public_Controller
{
	private $aesKey;
	private $aesIv;

	function __construct()
	{
		parent::__construct();
		$this->load->model('checkout_model');

		$this->load->library('email');
		$this->load->library('ecpay_payment');
		$this->load->library('ecpay_invoices');
		$this->load->library('ecpay_logistics');

		if ($this->is_liqun_food) {
			$this->load->model('coupon_model');
		}

		// Check if aesKey and aesIv are already set in flashdata(userdata)
		if (!$this->session->userdata('aesKey') || !$this->session->userdata('aesIv')) {
			// If not set, generate new random values
			$this->aesKey = openssl_random_pseudo_bytes(32); // 256 bits (32 bytes) key
			$this->aesIv = openssl_random_pseudo_bytes(16);  // 128 bits (16 bytes) IV

			// Save them in flashdata(userdata)
			$this->session->set_userdata('aesKey', $this->aesKey);
			$this->session->set_userdata('aesIv', $this->aesIv);
		} else {
			// If already set, retrieve them from flashdata(userdata)
			$this->aesKey = $this->session->userdata('aesKey');
			$this->aesIv = $this->session->userdata('aesIv');
		}
	}

	// function testencode()
	// {
	// 	redirect(base_url() . 'checkout/testdecode/' . $this->aesEncrypt('12345', $this->aesKey, $this->aesIv));
	// }
	// function testdecode($value)
	// {
	// 	echo $this->aesDecrypt($value, $this->aesKey, $this->aesIv);
	// }

	public function index()
	{
		$this->data['page_title'] = '結帳';

		$this->db->select('*');
		$this->db->where('payment_status', 1);
		$this->db->order_by('sort', 'asc');
		$this->data['payment'] = $this->db->get('payment')->result_array();
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'delivery_status', '1');

		$this->data['user_data']['name'] = '';
		$this->data['user_data']['phone'] = '';
		$this->data['user_data']['email'] = '';
		$this->data['user_data']['Country'] = '';
		$this->data['user_data']['province'] = '';
		$this->data['user_data']['county'] = '';
		$this->data['user_data']['district'] = '';
		$this->data['user_data']['address'] = '';
		$this->data['user_data']['zipcode'] = '';
		if ($this->ion_auth->logged_in() && !empty($this->current_user)) {
			$this->data['user_data']['name'] = $this->current_user->full_name;
			$this->data['user_data']['phone'] = $this->current_user->phone;
			$this->data['user_data']['email'] = $this->current_user->email;
			$this->data['user_data']['Country'] = $this->current_user->Country;
			$this->data['user_data']['province'] = $this->current_user->province;
			$this->data['user_data']['county'] = $this->current_user->county;
			$this->data['user_data']['district'] = $this->current_user->district;
			$this->data['user_data']['address'] = $this->current_user->address;
			$this->data['user_data']['zipcode'] = $this->current_user->zipcode;
		} else {
			$this->data['user_data']['name'] = get_cookie("user_name", true);
			$this->data['user_data']['phone'] = get_cookie("user_phone", true);
			$this->data['user_data']['email'] = get_cookie("user_email", true);
			$this->data['user_data']['address'] = get_cookie("user_address", true);
		}
		$this->setMemberInfo($this->data['user_data']['phone']);

		if ($this->is_td_stuff) {
			$this->render('checkout/index');
		}
		if ($this->is_liqun_food) {
			$this->data['use_coupon'] = array();
			// 優惠券
			$coupon_arr = $this->checkout_model->getCoustomCoupons($this->session->userdata('user_id'));
			if (!empty($coupon_arr)) {
				foreach ($coupon_arr as &$self) {
					$save_arr = $this->checkout_model->getCouponName($self['coupon_id']);
					$self['name'] = $save_arr['name'];
				}
				unset($self);  // 解除引用，以防止后续代码中意外修改 $self 导致原数组变动
			}
			$this->data['coupon'] = $coupon_arr;

			// 購物車重
			$total_weight = 0;
			$cart_item = $this->cart->contents(true);
			foreach ($cart_item as $self) {
				$total_weight += ((float)$self['options']['weight'] * (float)$self['qty']);
			}
			$this->data['total_weight'] = $total_weight;

			// 是否有冷凍商品
			$this->data['is_frozen'] = false;
			// echo '<pre>';
			// print_r($this->data['coupon']);
			// echo '</pre>';
			$this->render('checkout/liqun_index');
		}
		if ($this->is_partnertoys) {
			$self = $this->checkout_model->getECPay();
			$this->data['ECPay_status'] = $self['payment_status'];
			$this->data['city'] = $this->mysql_model->_select('city');
			$this->data['country'] = $this->mysql_model->_select('country');
			$this->data['region'] = $this->mysql_model->_select('region');
			$this->data['close_count'] = count($this->data['payment']);
			$this->data['instructions'] = $this->auth_model->getStandardPageList('ShoppingNotes_tw');
			foreach ($this->data['payment'] as $tmp) :
				if ($tmp['payment_status'] == 0) :
					$this->data['close_count']--;
				endif;
			endforeach;
			$this->render('checkout/partnertoys/partnertoys_index');
			// $this->render('checkout/partnertoys_index');
		}
	}

	// 回傳FM CVS Store Information
	public function fm_store_info()
	{
		$this->load->view('checkout/get_fm_store_info');
	}

	// 回傳ECP CVS Store Information
	public function ecp_store_info($name)
	{
		if ($this->is_partnertoys) {
			$this->load->view('checkout/partnertoys/' . $name);
		} else {
			$this->load->view('checkout/' . $name);
		}
	}

	// 導向綠界地圖按鈕頁面
	public function cvsmap()
	{
		$data['obj'] = $this->ecpay_logistics->load();
		$data['self_value'] = $this->checkout_model->getECPay();
		$this->load->view('checkout/cvsmap', $data);
	}

	public function save_extend_info()
	{
		try {
			// 載入綠界金流API
			$obj = $this->ecpay_payment->load();
			$ECPay = $this->checkout_model->getECPay();

			if ($ECPay['payment_status'] == 1) :
				// 正式環境
				$obj->HashKey = $ECPay['HashKey'];
				$obj->HashIV = $ECPay['HashIV'];
				$obj->MerchantID = $ECPay['MerchantID'];
				$obj->EncryptType = '1';
			else :
				// 測試環境
				$obj->HashKey     = '5294y06JbISpM5x9'; //測試用Hashkey，請自行帶入ECPay提供的HashKey
				$obj->HashIV      = 'v77hoKGq4kWxNNIS'; //測試用HashIV，請自行帶入ECPay提供的HashIV
				$obj->MerchantID  = '2000132'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
				$obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密
			endif;

			/* 取得回傳參數 */
			$arFeedback = $obj->CheckOutFeedback();
			//$arFeedback = $obj->CheckOutFeedback($arr);

			$szMerchantID = '';
			$szMerchantTradeNo = '';
			$szPaymentDate = '';
			$szPaymentType = '';
			$szPaymentTypeChargeFee = '';
			$szRtnCode = '';
			$szRtnMsg = '';
			$szSimulatePaid = '';
			$szTradeAmt = '';
			$szPayAmt = '';
			$szTradeDate = '';
			$szTradeNo = '';
			$szVirtualAccount = '';
			$szBankCode = '';
			$szPaymentNo = '';
			$szExpireDate = '';


			/* 檢核與變更訂單狀態 */
			if (sizeof($arFeedback) > 0) {
				foreach ($arFeedback as $key => $value) {
					switch ($key) {
							/* 支付後的回傳的基本參數 */
						case "MerchantID":
							$szMerchantID = $value;
							break;								//特店編號 String(10)
						case "MerchantTradeNo":
							$szMerchantTradeNo = $value;
							break;		//*特店交易編號 String (20)
						case "PaymentDate":
							$szPaymentDate = $value;
							break;							//會員付款日期
						case "PaymentType":
							$szPaymentType = $value;
							break;							//會員選擇的付款方式 = WebATM_TAISHIN
						case "PaymentTypeChargeFee":
							$szPaymentTypeChargeFee = $value;
							break;			//通路費 Money

						case "RtnCode":
							$szRtnCode = $value;
							break;						//交易狀態 Int, 程式回傳的交易狀態代碼說明
							//1.ATM 回傳值時為 2 時，交易狀 態為取號成功，其餘為失敗。
							//2.CVS/BARCODE 回傳值時為 10100073 時，交易狀態為取號成功，其餘為失敗。
						case "RtnMsg":
							$szRtnMsg = $value;
							break;							//交易訊息 String(200) = Get VirtualAccount Succeeded

						case "SimulatePaid":
							$szSimulatePaid = $value;
							break;		//是否為模擬付款Int  1-模擬付款，0-非模擬付款
						case "TradeAmt":
							$szTradeAmt = $value;
							break;					//交易金額 int = 20000
						case "PayAmt":
							$szPayAmt = $value;
							break;							//實際付款金額=交易金額-折抵金額 (於V1.1.30新增此欄位)
						case "TradeDate":
							$szTradeDate = $value;
							break;					//訂單成立時間 String(20) = 2012/03/15 17:40:58
						case "TradeNo":
							$szTradeNo = $value;
							break;						//*綠界的交易編號  String(20) = 201203151740582564
							//case "PaymentNo": $szPaymentNo = $value; break;		//超商代碼(14) LKK16052642678	(( 與CVS相同 ))

							//ChoosePayment = ATM
						case "vAccount":
							$szVirtualAccount = $value;
							break;			//ATM 繳費虛擬帳號 String (16) = 9103522175887271
						case "BankCode":
							$szBankCode = $value;
							break;					//ATM 繳費銀行代碼 String (3) = 812
							//case "ExpireDate": $szExpireDate = $value; break;				//ATM 繳費期限 String (10) = 2013/12/16	(( 與CVS相同 ))

							//ChoosePayment = CVS 或 BARCODE
						case "PaymentNo":
							$szPaymentNo = $value;
							break;				//CVS 代碼繳費 String(14) = GW130412257496
						case "ExpireDate":
							$szExpireDate = $value;
							break;					//CVS 繳費期限 String(20) = 2013/12/16 18:00:00
						default:
							break;
					}		//switch__end
				}		//foreach__end

				if (empty($szPaymentTypeChargeFee)) {
					$szPaymentTypeChargeFee = 0;
				}		//通路費 Money
				if (empty($szRtnCode)) {
					$szRtnCode = 0;
				}		//交易狀態 Int(11), ATM = 2:取號成功 CVS或BARCODE = 10100073:取號成功 其餘為失敗
				if (empty($szTradeAmt)) {
					$szTradeAmt = 0;
				}	//綠界交易金額 float
				if (empty($szPayAmt)) {
					$szPayAmt = 0;
				}			//實際付款金額
				if (empty($szSimulatePaid)) {
					$szSimulatePaid = 0;
				}		//return.php 才會用到


				$update_data = array(
					'MerchantID' => $szMerchantID,
					'MerchantTradeNo' => $szMerchantTradeNo,
					'PaymentDate' => $szPaymentDate,
					'PaymentType' => $szPaymentType,
					'PaymentTypeChargeFee' => $szPaymentTypeChargeFee,
					'RtnCode' => $szRtnCode,
					'SimulatePaid' => $szSimulatePaid,
					'RtnMsg' => $szRtnMsg,
					'TradeAmt' => $szTradeAmt,
					'PayAmt' => $szPayAmt,
					'TradeDate' => $szTradeDate,
					'TradeNo' => $szTradeNo,
					'VirtualAccount' => $szVirtualAccount,
					'BankCode' => $szBankCode,
					'PaymentNo' => $szPaymentNo,
					'ExpireDate' => $szExpireDate,
				);

				$this->db->where('MerchantTradeNo', $szMerchantTradeNo);
				$this->db->update('orders', $update_data);

				print '1|OK';
			} else {
				print '0|Fail';
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function setMemberInfo($phone)
	{
		unset($_SESSION['member_id']);
		unset($_SESSION['member_join_status']);
		unset($_SESSION['member_username']);
		unset($_SESSION['member_full_name']);
		unset($_SESSION['member_phone']);
		unset($_SESSION['member_email']);
		$sessionData = array(
			'member_id' => '',
			'member_join_status' => '',
			'member_username' => '',
			'member_full_name' => '',
			'member_phone' => '',
			'member_email' => '',
		);
		$row = $this->checkThereAreMembers($phone);
		if (!empty($row)) {
			$sessionData['member_id'] = $row['id'];
			$sessionData['member_join_status'] = $row['join_status'];
			$sessionData['member_username'] = $row['username'];
			$sessionData['member_full_name'] = $row['full_name'];
			$sessionData['member_phone'] = $row['phone'];
			$sessionData['member_email'] = $row['email'];
		}
		$this->session->set_userdata($sessionData);
	}

	function set_user_data()
	{
		set_cookie("user_name", $this->input->post('name'), time() + 31536000);
		set_cookie("user_phone", $this->input->post('phone'), time() + 31536000);
		set_cookie("user_email", $this->input->post('email'), time() + 31536000);
		set_cookie("user_address", $this->input->post('address'), time() + 31536000);
	}

	// ECP pay
	public function ecp_repay_order($order_id = 0)
	{
		$this->data['page_title'] = '結帳';

		// 類別分類
		$current_url = $_SERVER['REQUEST_URI'];
		$query_string = parse_url($current_url, PHP_URL_QUERY);
		$decoded_data = $this->security_url->fixedDecryptData($query_string);
		if (!empty($query_string)) {
			if (!empty($decoded_data) && !empty($decoded_data['getorders'])) {
				$order_id = $decoded_data['getorders'];
			}
		}

		$orders = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		if (!empty($orders) && $orders['customer_id'] != $this->session->userdata('user_id')) {
			echo '<script>
					alert("未認證操作請重新嘗試");
					window.location.href = "' . base_url() . 'auth"
				  </script>';
		}

		$pay_order = $this->checkout_model->getSelectedOrder($order_id);

		// 綠界支付
		if (!empty($pay_order) && ($pay_order['order_payment'] == 'ecpay_credit' || $pay_order['order_payment'] == 'ecpay_ATM' || $pay_order['order_payment'] == 'ecpay_CVS')) {
			/**
			 *    Credit信用卡付款產生訂單範例
			 */

			//載入SDK(路徑可依系統規劃自行調整)
			try {
				// 載入綠界金流API
				$obj = $this->ecpay_payment->load();
				$ECPay = $this->checkout_model->getECPay();

				if ($ECPay['payment_status'] == 1) :
					// 正式環境
					$obj->ServiceURL = "https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5"; //服務位置
					$obj->HashKey = $ECPay['HashKey'];
					$obj->HashIV = $ECPay['HashIV'];
					$obj->MerchantID = $ECPay['MerchantID'];
					$obj->EncryptType = '1';
				else :
					// 測試環境
					$obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5"; //服務位置
					$obj->HashKey     = '5294y06JbISpM5x9'; //測試用Hashkey，請自行帶入ECPay提供的HashKey
					$obj->HashIV      = 'v77hoKGq4kWxNNIS'; //測試用HashIV，請自行帶入ECPay提供的HashIV
					$obj->MerchantID  = '2000132'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
					$obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密
				endif;

				//基本參數(請依系統規劃自行調整)
				$MerchantTradeNo = $pay_order['order_number'] . substr(time(), 4, 6);
				if (strlen($MerchantTradeNo) > 20) {
					$MerchantTradeNo = $pay_order['order_number'] . substr(time(), 6, 4);
				}

				// 存取MerchantTradeNo編號
				if ($this->input->post('checkout_payment') == 'ecpay_ATM' || $this->input->post('checkout_payment') == 'ecpay_CVS') {
					// 存取MerchantTradeNo編號
					$this->db->where('order_number', $pay_order['order_number']);
					$this->db->update('orders', ['MerchantTradeNo' => $MerchantTradeNo]);
				}

				$obj->Send['MerchantTradeNo'] = $MerchantTradeNo; //訂單編號
				$obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
				$obj->Send['TotalAmount'] = (int)$pay_order['order_total']; //交易金額
				$obj->Send['TradeDesc'] = get_empty_remark('網站訂單: ' . $pay_order['order_remark']); //交易描述
				$obj->Send['PaymentType'] = "aio"; //交易類型 String(20) 請固定填入 aio
				// 可以決定ATM或Credit支付
				if ($pay_order['order_payment'] == 'ecpay_credit') {
					$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit; //付款方式
				} else if ($pay_order['order_payment'] == 'ecpay_ATM') {
					$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::ATM; //付款方式
				} else if ($pay_order['order_payment'] == 'ecpay_CVS') {
					$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::CVS; //付款方式
				}
				// POST會傳到這
				$obj->Send['ReturnURL'] = base_url() . "checkout/save_extend_info"; //付款完成通知回傳的網址
				$obj->Send['OrderResultURL'] = base_url() . "checkout/check_pay/" . $pay_order['order_number']; //付款完成通知回傳的網址
				$obj->Send['ClientBackURL'] = base_url(); //付款完成後，顯示返回商店按鈕
				$obj->Send['PaymentInfoURL'] = base_url() . "checkout/save_extend_info";
				$obj->SendExtend['PaymentInfoURL'] = base_url() . "checkout/save_extend_info"; 	//伺服器端回傳付款相關資訊。

				$obj->Send['NeedExtraPaidInfo'] = ECPay_ExtraPaymentInfo::Yes;
				//訂單的商品資料
				array_push($obj->Send['Items'], array(
					'Name' => "網購商品",
					'Price' => (int)$pay_order['order_total'],
					'Currency' => "元",
					'Quantity' => (int) "1筆",
					'URL' => "dedwed"
				));
				$obj->SendExtend['CreditInstallment'] = 0; //分期期數，預設0(不分期)
				$obj->SendExtend['InstallmentAmount'] = 0; //使用刷卡分期的付款金額，預設0(不分期)
				$obj->SendExtend['Redeem'] = false; //是否使用紅利折抵，預設false
				$obj->SendExtend['UnionPay'] = false; //是否為聯營卡，預設false;

				//產生訂單(auto submit至ECPay)
				$obj->CheckOut();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	// Line Pay
	function line_repay_order($order_id = 0)
	{
		$this->data['page_title'] = '結帳';

		// 類別分類
		$current_url = $_SERVER['REQUEST_URI'];
		$query_string = parse_url($current_url, PHP_URL_QUERY);
		$decoded_data = $this->security_url->fixedDecryptData($query_string);
		if (!empty($query_string)) {
			if (!empty($decoded_data) && !empty($decoded_data['getorders'])) {
				$order_id = $decoded_data['getorders'];
			}
		}

		$orders = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		if (!empty($orders) && $orders['customer_id'] != $this->session->userdata('user_id')) {
			echo '<script>
					alert("未認證操作請重新嘗試");
					window.location.href = "' . base_url() . 'auth"
				  </script>';
		}

		$pay_order = $this->checkout_model->getSelectedOrder($order_id);

		// Line Pay
		if (!empty($pay_order) && $pay_order['order_payment'] == 'line_pay') {

			// Line Pay
			// New -----
			$channelId     = "2000014653"; // 通路ID
			$channelSecret = "af271193c5642181568b743846d72e60"; // 通路密鑰
			$channelImage  = 'https://td-stuff.com/assets/uploads/web_logo_td.png';
			if ($this->is_liqun_food) {
				$channelId     = get_setting_general('lp_channel_id'); // 通路ID
				$channelSecret = get_setting_general('lp_channel_secret_key'); // 通路密鑰
				$channelImage  = base_url() . '/assets/uploads/' . get_setting_general('logo');
			}
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
				"amount" => (int)$pay_order['order_discount_total'],
				"currency" => 'TWD',
				"orderId" => $pay_order['order_number'],
				"packages" => [
					[
						"id" => "test1",
						"amount" => (int)$pay_order['order_discount_total'],
						"name" => "package name",
						"products" => [
							[
								"name" => '網購商品',
								"quantity" => 1,
								"price" => (int)$pay_order['order_discount_total'],
								"imageUrl" => $channelImage,
							],
						],
					],
				],
				"redirectUrls" => [
					"confirmUrl" => base_url() . "checkout/line_pay_confirm",
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
	}

	public function save_order()
	{
		$this->data['page_title'] = '結帳';
		$this->load->model('product_model');

		if ($this->session->userdata('single_sales_status') == 'Test') {
			$this->render('single_sales/error');
			return;
		}

		if ($this->cart->total_items() <= 0) {
			echo '
				<script>
					alert("購物車查無內容");
					window.location.href = "' . base_url() . '";
				</script>';
			return;
		}

		$selected_coupon_id = 0;
		$selected_coupon_name = '';

		if (!empty($this->input->post('used_coupon'))) {
			$coupon_custom_id = $this->input->post('used_coupon');

			$selected_custom_coupon = $this->mysql_model->_select('new_coupon_custom', 'id', $coupon_custom_id, 'row');

			// echo '<pre>';
			// print_r($selected_custom_coupon);
			// echo '</pre>';
			if (!empty($selected_custom_coupon)) {
				$now_time = date("Y-m-d H:i:s");
				$limit_number = (int)$selected_custom_coupon['use_limit_number'] - 1;
				$self_coupon = $this->mysql_model->_select('new_coupon', 'id', $selected_custom_coupon['coupon_id'], 'row');

				if ($selected_custom_coupon['type'] == 'percent' || $selected_custom_coupon['type'] == 'cash') {
					$check_cart_total = $this->cart->total();
					$check_discount = $selected_custom_coupon['discount_amount'];
					// echo '<pre>';
					// print_r($check_cart_total);
					// echo '</pre>';
					// echo '<pre>';
					// print_r($check_discount);
					// echo '</pre>';
					// echo '<pre>';
					// print_r((int)($check_cart_total * $check_discount));
					// echo '</pre>';
					// echo '<pre>';
					// print_r((int)$this->input->post('cart_total'));
					// echo '</pre>';
					if ((float)$check_discount < 1.00) {
						$check_cart_total = $check_cart_total * $check_discount;
					} else {
						$check_cart_total = $check_cart_total - $check_discount;
					}
					if ((int)$check_cart_total != (int)$this->input->post('cart_total')) {
						echo '
							<script>
								alert("購物車金額計算發生錯誤請重新嘗試，若嘗試多次仍無果請聯繫客服，造成您的不便敬請見諒謝謝。");
								window.location.href = "' . base_url() . 'checkout";
							</script>';
						return;
					}
				}

				// checking coupon used limit and exist
				if ($limit_number < 0 || empty($self_coupon) || $now_time < $self_coupon['distribute_at'] || $now_time > $self_coupon['discontinued_at']) {
					echo '
					<script>
						alert("優惠券錯誤請重新嘗試");
						window.location.href = "' . base_url() . 'checkout";
					</script>';
					return;
				}
				$selected_coupon_id = $self_coupon['id'];
				$selected_coupon_name = $self_coupon['name'];

				if ($limit_number) {
					// 更新使用次數
					$data = array(
						'use_limit_number' => $limit_number,
					);
					$this->db->where('id', $coupon_custom_id);
					$this->db->update('new_coupon_custom', $data);
				} else {
					// 若使用完畢自動刪除
					$this->db->where('id', $coupon_custom_id);
					$this->db->delete('new_coupon_custom');
				}
			}
		}

		$date = date('Y-m-d');
		$y = substr($date, 0, 4);
		$m = substr($date, 5, 2);
		$d = substr($date, 8, 2);
		$this->db->select('MAX(order_number) as last_number');
		$this->db->like('order_number', $y . $m . $d, 'after');
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			if ($row->last_number == null) {
				$order_number = $y . $m . $d . '00001';
			} else {
				$order_number = preg_replace('/[^\d]/', '', $row->last_number);
				$order_number++;
			}
		}

		if ($this->input->post('become_member_quickly') == 'yes') {
			$u_row = $this->checkThereAreMembers($this->input->post('phone'));
			if (empty($u_row)) {
				$this->createUsers($this->input->post('name'), $this->input->post('phone'), $this->input->post('email'), $this->input->post('password'), $this->input->post('become_member_quickly'));
			}
			if (!empty($u_row)) {
				if ($u_row['join_status'] == 'NotJoin') {
					$this->updateJoinUser($u_row, $this->input->post('password'));
				}
			}
		}

		// $customer_id = (isset($this->current_user->id) ? $this->current_user->id : $this->get_users_id());
		$customer_id = (isset($this->current_user->id) ? $this->current_user->id : -1);

		$order_delivery_address = '';
		// 郵遞區號
		if (!empty($this->input->post('Country')) && $this->input->post('Country') == '中國' && !empty($this->input->post('cn_zipcode'))) {
			$order_delivery_address .= '' . $this->input->post('cn_zipcode') . '';
		} else if (!empty($this->input->post('Country')) && $this->input->post('Country') == '臺灣' && !empty($this->input->post('tw_zipcode'))) {
			$order_delivery_address .= '' . $this->input->post('tw_zipcode') . '';
		}

		// 國家
		if (!empty($this->input->post('Country'))) {
			$order_delivery_address .= $this->input->post('Country');
		}

		// 省鄉鎮市區
		if (!empty($this->input->post('Country')) && $this->input->post('Country') == '中國') {
			if (!empty($this->input->post('cn_province'))) {
				$order_delivery_address .= $this->input->post('cn_province');
			}
			if (!empty($this->input->post('cn_county'))) {
				$order_delivery_address .= $this->input->post('cn_county');
			}
			if (!empty($this->input->post('cn_district'))) {
				$order_delivery_address .= $this->input->post('cn_district');
			}
		} else if (!empty($this->input->post('Country')) && $this->input->post('Country') == '臺灣') {
			if (!empty($this->input->post('tw_county'))) {
				$order_delivery_address .= $this->input->post('tw_county');
			}
			if (!empty($this->input->post('tw_district'))) {
				$order_delivery_address .= $this->input->post('tw_district');
			}
		}

		// 詳細地址
		if (!empty($this->input->post('address'))) {
			$order_delivery_address .= $this->input->post('address');
		}

		// 使用之coupon
		if (empty($this->input->post('used_coupon'))) {
			if ((int)$this->cart->total() != (int)$this->input->post('cart_total')) {
				echo '
				<script>
					alert("購物車金額計算發生錯誤請重新嘗試，若嘗試多次仍無果請聯繫客服，造成您的不便敬請見諒謝謝。");
					window.location.href = "' . base_url() . 'checkout";
				</script>';
				return;
			}
		}

		$delivery_cost = 0;
		if (!empty($this->input->post('checkout_delivery'))) {
			$self = $this->checkout_model->getDelivery($this->input->post('checkout_delivery'));
			if ($self['free_shipping_enable']) {
				if ((int)$this->input->post('cart_total') >= $self['free_shipping_limit']) {
					$delivery_cost = 0;
				}
			} else {
				$delivery_cost = $self['shipping_cost'];
			}
		}

		if ($this->input->post('shipping_amount') == 0) {
			$delivery_cost = 0;
		}

		$weight_exceed = $this->input->post('weight_exceed_amount');
		$order_total = intval($this->cart->total() + (int)$delivery_cost);
		$order_discount_total = intval((int)$this->input->post('cart_total') + (int)$delivery_cost);
		$order_discount_price = intval((int)$this->cart->total() - (int)$this->input->post('cart_total'));

		// 超重額外付款
		if (!empty($weight_exceed)) {
			$order_discount_total += (int)$weight_exceed;
		}

		// 檢查金額是否正確
		$check_end_discount = $order_discount_total - (int)$this->input->post('cart_total') - $delivery_cost - $weight_exceed;
		$check_end_origin = $order_discount_total - (int)$this->cart->total() - $order_discount_price - $delivery_cost - $weight_exceed;
		if ($check_end_discount || $check_end_origin) {
			echo '
			<script>
				alert("購物車金額計算發生錯誤請重新嘗試，若嘗試多次仍無果請聯繫客服，造成您的不便敬請見諒謝謝。");
				window.location.href = "' . base_url() . 'checkout";
			</script>';
			return;
		}

		$order_pay_status = 'not_paid';

		$created_at = date("Y-m-d H:i:s");

		// 客戶及訂單資料新增至資料庫
		$insert_data = array(
			'order_number' => $order_number,
			'order_date' => date("Y-m-d"),
			'used_coupon_id' => $selected_coupon_id,
			'used_coupon_name' => $selected_coupon_name,
			'customer_id' => $customer_id,
			'customer_name' => $this->input->post('name'),
			'customer_phone' => $this->input->post('phone'),
			'customer_email' => $this->input->post('email'),
			'weight_exceed_count' => ($weight_exceed / 50),
			'weight_exceed_amount' => $weight_exceed,
			'order_total' => $order_total,
			'order_discount_total' => $order_discount_total,
			'order_discount_price' => $order_discount_price,
			'order_delivery_cost' => $delivery_cost,
			'order_delivery_address' => $order_delivery_address,
			'store_id' => get_empty($this->input->post('storeid')),
			'order_store_name' => get_empty($this->input->post('storename')),
			'order_store_address' => get_empty($this->input->post('storeaddress')),
			'order_store_ReservedNo' => get_empty($this->input->post('ReservedNo')),
			'order_delivery' => $this->input->post('checkout_delivery'),
			'order_payment' => $this->input->post('checkout_payment'),
			'order_pay_status' => $order_pay_status,
			'order_step' => 'confirm',
			'order_remark' => $this->input->post('remark'),
			'single_sales_id' => ($this->session->userdata('single_sales_id') != '' ? $this->session->userdata('single_sales_id') : ''),
			'agent_id' => ($this->session->userdata('agent_id') != '' ? $this->session->userdata('agent_id') : ''),
			// 'creator_id' => $this->ion_auth->user()->row()->id,
			'created_at' => $created_at,
		);

		if ($this->is_partnertoys) {
			// 抬頭&統編
			$insert_data['order_cpname'] = !empty($this->input->post('order_cpname')) ? $this->input->post('order_cpname') : '';
			$insert_data['order_cpno'] = !empty($this->input->post('order_cpno')) ? $this->input->post('order_cpno') : '';
		}
		if ($this->is_liqun_food) {
			// 訂單重量
			$insert_data['order_weight'] = $this->input->post('weight_amount');
			$insert_data['in_free_shipping_range'] = $this->input->post('in_free_shipping_range');
			if ($insert_data['order_delivery'] == 'family_limit_5_frozen_pickup' || $insert_data['order_delivery'] == 'family_limit_10_frozen_pickup') {
				// 冷凍訂單
				$insert_data['fm_cold'] = 1;
			}
		}
		// echo '<pre>';
		// print_r($this->fm_b2c_frozen($insert_data));
		// echo '</pre>';

		// return;
		$order_id = $this->mysql_model->_insert('orders', $insert_data);

		// 阿凱的冰箱自動拆單
		if ($this->is_liqun_food) {
			if (!empty($weight_exceed)) {
				// 參數
				$count = $weight_exceed / 50;
				$main_order_number = $order_number;

				// 產生空訂單
				while ($count--) {
					// 訂單編號
					$date = date('Y-m-d');
					$y = substr($date, 0, 4);
					$m = substr($date, 5, 2);
					$d = substr($date, 8, 2);
					$this->db->select('MAX(order_number) as last_number');
					$this->db->like('order_number', $y . $m . $d, 'after');
					$query = $this->db->get('orders');
					if ($query->num_rows() > 0) {
						$row = $query->row();
						if ($row->last_number == null) {
							$sub_order_number = $y . $m . $d . '00001';
						} else {
							$sub_order_number = preg_replace('/[^\d]/', '', $row->last_number);
							$sub_order_number++;
						}
					}
					$exceed_data = array(
						'order_number' => $sub_order_number,
						'main_order_number' => $main_order_number,
						'fm_cold' => !empty($insert_data['fm_cold']) ?: 0,
						'order_date' => date("Y-m-d"),
						'used_coupon_id' => $selected_coupon_id,
						'used_coupon_name' => $selected_coupon_name,
						'in_free_shipping_range' => $this->input->post('in_free_shipping_range'),
						'customer_id' => $customer_id,
						'customer_name' => $this->input->post('name'),
						'customer_phone' => $this->input->post('phone'),
						'customer_email' => $this->input->post('email'),
						'order_total' => 0,
						'order_discount_total' => 0,
						'order_discount_price' => 0,
						'order_delivery_cost' => 0,
						'order_delivery_address' => $order_delivery_address,
						'store_id' => get_empty($this->input->post('storeid')),
						'order_store_name' => get_empty($this->input->post('storename')),
						'order_store_address' => get_empty($this->input->post('storeaddress')),
						'order_store_ReservedNo' => get_empty($this->input->post('ReservedNo')),
						'order_delivery' => $this->input->post('checkout_delivery'),
						'order_payment' => $this->input->post('checkout_payment'),
						'order_pay_status' => $order_pay_status,
						'order_step' => 'confirm',
						'order_remark' => $this->input->post('remark'),
						'single_sales_id' => ($this->session->userdata('single_sales_id') != '' ? $this->session->userdata('single_sales_id') : ''),
						'agent_id' => ($this->session->userdata('agent_id') != '' ? $this->session->userdata('agent_id') : ''),
						'created_at' => $created_at,
					);
					$this->db->insert('orders', $exceed_data);
				}
			}
		}

		foreach ($this->cart->contents() as $cart_item) :
			// echo '<pre>';
			// print_r ($cart_item);
			// echo '</pre>';
			$this_product_combine = $this->mysql_model->_select('product_combine', 'id', $cart_item['id'], 'row');
			// echo '<pre>';
			// print_r ($this_product_combine);
			// echo '</pre>';
			$this_product = $this->mysql_model->_select('product', 'product_id', $cart_item['product_id'], 'row');
			// echo '<pre>';
			// print_r ($this_product);
			// echo '</pre>';

			// 抽選單
			if (!empty($this->session->userdata('user_id'))) {
				$this_lottery = $this->mysql_model->_select('lottery', 'product_id', $this_product['product_id'], 'row');
				if (!empty($this_lottery)) {
					$this->db->where('users_id', $this->session->userdata('user_id'));
					$this->db->where('lottery_id', $this_lottery['id']);
					$this_lottery_pool = $this->db->get('lottery_pool')->row_array();
					if (!empty($this_lottery_pool)) {
						$self_lottery_pool = array(
							'order_id' => $order_id,
							'order_number' => $order_number,
						);
						$this->db->where('id', $this_lottery_pool['id']);
						$this->db->update('lottery_pool', $self_lottery_pool);
					}
				}
			}

			// 存商品項目
			$order_item = array(
				'order_id' => $order_id,
				'product_combine_id' => $cart_item['id'],
				'cargo_id' => $this_product_combine['cargo_id'],
				'product_combine_name' => $this_product_combine['name'],
				'customer_id' => $customer_id,
				'product_id' => $this_product['product_id'],
				'product_name' => $this_product['product_name'],
				'order_item_qty' => $cart_item['qty'],
				'order_item_price' => $cart_item['price'],
				'created_at' => $created_at,
			);
			$this->db->insert('order_item', $order_item);

			// 計算商品方案庫存
			if ($this->is_partnertoys || $this->is_liqun_food) {
				$self = $this->mysql_model->_select('product_combine', 'id', $cart_item['id'], 'row');
				$inventory_data = array(
					'quantity' => ((int)$this_product_combine['quantity'] - (int)$cart_item['qty']),
				);
				$this->db->where('id', $cart_item['id']);
				$this->db->update('product_combine', $inventory_data);
			}


			// liqun 熱門商品功能數量計算
			if ($this->is_liqun_food) {
				$tmp_cnt = $this->product_model->getSingleProduct($cart_item['product_id']);
				$cnt = (int)$cart_item['qty'] + (int)$tmp_cnt['Sales_volume'];
				$this->db->where('product_id', $cart_item['product_id']);
				$this->db->update('product', ['Sales_volume' => $cnt]);
			}

			$this_product_combine_item = $this->mysql_model->_select('product_combine_item', 'product_combine_id', $cart_item['id']);
			if (!empty($this_product_combine_item)) {
				$inventory = array();
				foreach ($this_product_combine_item as $items) {
					// $order_item = array(
					// 	'order_id' => $order_id,
					// 	'product_combine_id' => $items['product_combine_id'],
					// 	'customer_id' => $customer_id,
					// 	'product_id' => $items['product_id'],
					// 	'order_item_qty' => ($cart_item['qty'] * $items['qty']),
					// 	'order_item_price' => 0,
					// 	'created_at' => $created_at,
					// );
					// $this->db->insert('order_item', $order_item);
					if (array_key_exists($items['product_id'], $inventory)) {
						$inventory[$items['product_id']] += ($cart_item['qty'] * $items['qty']);
					} else {
						$inventory[$items['product_id']] = ($cart_item['qty'] * $items['qty']);
					}
				}
				if (!empty($inventory)) {
					foreach ($inventory as $key => $value) {
						$this->db->select('excluding_inventory');
						$this->db->where('product_id', $key);
						$p_row = $this->db->get('product')->row_array();
						if (!empty($p_row)) {
							if ($p_row['excluding_inventory'] == false) {
								$this->db->set('inventory', 'inventory - ' . $value, FALSE);
								$this->db->where('product_id', $key);
								$this->db->update('product');

								$inventory_log = array(
									'product_id' => $key,
									'source' => 'Order',
									'change_history' => -$value,
									'change_notes' => $order_number,
								);
								$this->db->insert('inventory_log', $inventory_log);
							}
						}
					}
				}
			}
			// 規格(依情況註解)
			if (!empty($cart_item['specification']['specification_id'])) {
				$sp_qty = 0;
				$qty_array = 0;
				foreach ($cart_item['specification']['specification_qty'] as $row) {
					$specification_id[$sp_qty] = $row;
					$sp_qty++;
				}
				foreach ($cart_item['specification']['specification_id'] as $row) {
					$order_item = array(
						'order_id' => $order_id,
						'product_combine_id' => $items['product_combine_id'],
						'product_id' => $items['product_id'],
						'order_item_qty' => 0,
						'order_item_price' => 0,
						'specification_id' => $row,
						'specification_str' => $this->product_model->getSpecificationStr($row),
						'specification_qty' => $specification_id[$qty_array],
						'created_at' => $created_at,
					);
					$this->db->insert('order_item', $order_item);
					$qty_array++;
				}
			}
		endforeach;

		// Start 寄信給買家、賣家(可以砍掉echo部分)
		$this->send_order_email($order_id);

		// 清除購物車
		$this->cart->destroy();

		// payment
		if ($this->input->post('checkout_payment') == 'ecpay_credit' || $this->input->post('checkout_payment') == 'ecpay_ATM' || $this->input->post('checkout_payment') == 'ecpay_CVS') {

			// ECP pay
			$this->ecp_repay_order($order_id);
		} elseif ($this->input->post('checkout_payment') == 'line_pay') {

			// LINE Pay
			$this->line_repay_order($order_id);
		} else {
			// BANK Pay

			// 訂單ID加密
			redirect(base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv));
		}
	}

	function checkThereAreMembers($phone)
	{
		$this->db->select('id,join_status,username,email,full_name,phone,status');
		$this->db->where('username', trim($phone));
		$this->db->limit(1);
		$row = $this->db->get('users')->row_array();
		return ((!empty($row)) ? $row : false);
	}

	function createUsers($name, $phone, $email, $password, $become_member_quickly = '')
	{
		$additional_data = array(
			'join_status' => ($become_member_quickly == 'yes' ? 'IsJoin' : 'NotJoin'),
			'full_name' => $name,
			'phone' => $phone,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$this->ion_auth->register($phone, $password, $email, $additional_data, array('2'));
	}

	function get_users_id()
	{
		$users_id = 0;
		$row = $this->checkThereAreMembers($this->input->post('phone'));
		if (!empty($row)) {
			$users_id = $row['id'];
		} else {
			$this->createUsers($this->input->post('name'), $this->input->post('phone'), $this->input->post('email'), get_random_string(10));
			$u_row = $this->checkThereAreMembers($this->input->post('phone'));
			if (!empty($u_row)) {
				$users_id = $u_row['id'];
			}
		}
		return $users_id;
	}

	function updateJoinUser($userData, $password)
	{
		if (!empty($userData)) {
			$data = array(
				'join_status' => 'IsJoin',
				'password' => $password,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$this->ion_auth->update($userData['id'], $data);
		}
	}

	// 參數處理完後回傳處
	public function success($order_id)
	{
		// if ($this->is_partnertoys) {
		// 	$this->data['obj'] = $this->ecpay_payment->load();
		// }

		$this->data['page_title'] = '訂單完成';

		// 訂單ID解密
		// $this->data['order'] = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		// $this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $order_id);
		$this->data['order'] = $this->mysql_model->_select('orders', 'order_id', $this->aesDecrypt($order_id, $this->aesKey, $this->aesIv), 'row');
		$this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $this->aesDecrypt($order_id, $this->aesKey, $this->aesIv));

		if (!empty($this->data['order'])) {
			$this->data['users'] = $this->mysql_model->_select('users', 'id', $this->data['order']['customer_id'], 'row');
			// debug unknow users relogin
			if (!empty($this->data['users'])) {
				if (empty($this->session->userdata('user_id'))) {
					$query = $this->db->select('full_name, username, email, id, fb_id, password, phone, active, last_login')
						->where('id', $this->data['order']['customer_id'])
						->limit(1)
						->order_by('id', 'desc')
						->get($this->ion_auth_model->tables['users']);
					$user = $query->row();
					$this->ion_auth_model->set_session($user);
					$this->ion_auth_model->update_last_login($user->id);
				}
			}
		}

		$this->render('checkout/checkout_success');
	}

	// 加密
	function format_invoice_eim($eim)
	{
		$count = 0;
		$text = '';
		if (!empty(trim($eim))) {
			if (mb_strlen($eim, 'utf-8') == 8) {
				if (preg_match("/^[0-9]+$/", $eim)) {
					$count++;
				}
				if ($count > 0) {
					$text = $eim;
				}
			} else {
				$text = '';
			}
		}
		return trim($text);
	}

	// 綠界金流付完款後回傳參數的索引
	// type=POST
	public function check_pay($order_number)
	{
		// 檢查金流回傳值
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';

		// return;

		// 查詢訂單資訊
		$row = $this->mysql_model->_select('orders', 'order_number', $order_number, 'row');
		$order_id = !empty($row) ? $row['order_id'] : 0;

		// 檢查顧客資料
		// echo '<pre>';
		// print_r($row);
		// echo '</pre>';

		// CVS and ATM return value test
		// try {
		// 	$this->save_extend_info();
		// } catch (Exception $e) {
		// 	echo $e->getMessage();
		// }

		if ($this->input->post('RtnCode') == '1' && $order_id > 0) {
			// 更新訂單是否付款成功及付款成功後
			$data = array(
				'order_pay_status' => 'paid', // 已付款
				'MerchantID' => get_empty($this->input->post('MerchantID')),
				'MerchantTradeNo' => get_empty($this->input->post('MerchantTradeNo')),
				'PaymentDate' => get_empty($this->input->post('PaymentDate')),
				'PaymentType' => get_empty($this->input->post('PaymentType')),
				'PaymentTypeChargeFee' => get_empty($this->input->post('PaymentTypeChargeFee')),
				'RtnCode' => get_empty($this->input->post('RtnCode')),
				'RtnMsg' => get_empty($this->input->post('RtnMsg')),
				'SimulatePaid' => get_empty($this->input->post('SimulatePaid')),
				'TradeAmt' => get_empty($this->input->post('TradeAmt')),
				'TradeNo' => get_empty($this->input->post('TradeNo')),
				'TradeDate' => get_empty($this->input->post('TradeDate')),
				'state' => 0,
			);
			$this->db->where('order_id', $order_id);
			$this->db->update('orders', $data);

			// 抽選單
			$this->db->where('order_id', $order_id);
			$this->db->where('order_number', $order_number);
			$this_lottery_pool = $this->db->get('lottery_pool')->row_array();
			if (!empty($this_lottery_pool)) {
				$self_lottery_pool = array(
					'order_state' => 'pay_ok',
				);
				$this->db->where('id', $this_lottery_pool['id']);
				$this->db->update('lottery_pool', $self_lottery_pool);
			}

			// 是否為現貨(是才開發票)[待修改]
			$autoEnable = true;
			if ($this->is_partnertoys) {
				$odit = $this->mysql_model->_select('order_item', 'order_id', $order_id);
				if (!empty($odit)) {
					foreach ($odit as $self) {
						if ($autoEnable) {
							$product_type = $this->mysql_model->_select('product', 'product_id', $self['product_id'], 'row');
							if ($product_type['product_category_id'] == 1 || $product_type['product_category_id'] == 6) {
								$autoEnable = false;
							}
						} else {
							break;
						}
					}
				}
			}

			if ($autoEnable) {
				// 開發票
				try {
					// 載入綠界發票API
					$obj = $this->ecpay_invoices->load();
					$ECPay = $this->checkout_model->getECPay();

					if ($ECPay['payment_status'] == 1) :
						// 服務參數 (正式環境)
						$obj->Invoice_Url = 'https://einvoice.ecpay.com.tw/Invoice/Issue';
						$obj->MerchantID = $ECPay['MerchantID'];
						$obj->HashKey = $ECPay['HashKey'];
						$obj->HashIV = $ECPay['HashIV'];
					else :
						// 服務參數 (測試環境)
						$obj->Invoice_Url = 'https://einvoice-stage.ecpay.com.tw/Invoice/Issue';
						$obj->MerchantID = '2000132';
						$obj->HashKey = 'ejCk326UnaZWKisg';
						$obj->HashIV = 'q9jcZX8Ib9LM8wYk';
					endif;

					// 商品資訊
					array_push(
						$obj->Send['Items'],
						array(
							'ItemName' => '網站訂購商品乙批',
							'ItemCount' => 1,
							'ItemWord' => '批',
							'ItemPrice' => $this->input->post('TradeAmt'),
							'ItemTaxType' => EcpayTaxType::Dutiable,
							'ItemAmount' => $this->input->post('TradeAmt'),
							'ItemRemark' => '網站訂購商品'
						)
					);

					// 發票資訊
					$obj->Send['RelateNumber'] = $this->input->post('MerchantTradeNo'); // 綠界訂單編號
					$obj->Send['CustomerID'] = $row['customer_id']; // userid
					$obj->Send['CustomerIdentifier'] = $this->format_invoice_eim($row['order_number']); // 身分證號(這邊用訂單編號)
					$obj->Send['CustomerName'] = $row['customer_name']; // name
					$obj->Send['CustomerAddr'] = 'TEST_ADDRESS'; // address
					$obj->Send['CustomerPhone'] = $row['customer_phone']; // phone
					$obj->Send['CustomerEmail'] = $row['customer_email']; // email
					$obj->Send['ClearanceMark'] = ''; // 通關方式
					$obj->Send['Print'] = EcpayPrintMark::No; // 是否印發票
					$obj->Send['Donation'] = EcpayDonation::No; // 捐贈
					$obj->Send['LoveCode'] = ''; //愛心碼
					$obj->Send['CarruerType'] = EcpayCarruerType::None; // 有無載具
					$obj->Send['CarruerNum'] = ''; // 載具號
					$obj->Send['TaxType'] = EcpayTaxType::Dutiable; // 課稅類別預設為應稅
					$obj->Send['SalesAmount'] = $this->input->post('TradeAmt'); // 價格
					$obj->Send['InvoiceRemark'] = ''; // 發票備註
					$obj->Send['InvType'] = EcpayInvType::General; // 一般稅額
					$obj->Send['vat'] = EcpayVatType::Yes; // 是否含稅

					// 送出
					$invoice = $obj->Check_Out();

					if ($invoice['RtnCode'] == '1') {
						// print_r($invoice['InvoiceNumber']);
						$data = array(
							'invoid' => get_empty($invoice['InvoiceNumber']),
							'InvoiceNumber' => get_empty($invoice['InvoiceNumber']),
						);
						$this->db->where('order_id', $order_id);
						$this->db->update('orders', $data);
					}

					// 檢查發票資料
					// echo '<pre>';
					// print_r($invoice);
					// echo '</pre>';
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}

			// 託運單
			try {
				// 載入綠界託運API
				$obj = $this->ecpay_logistics->load();
				$ECPay = $this->checkout_model->getECPay();

				if ($ECPay['payment_status'] == 1) :
					// 服務參數 (正式環境)
					$obj->Send['MerchantID'] = $ECPay['MerchantID'];
					$obj->HashKey = $ECPay['HashKey'];
					$obj->HashIV = $ECPay['HashIV'];
				else :
					// 服務參數 (測試環境)
					$obj->Send['MerchantID'] = '2000132';
					$obj->HashKey = '5294y06JbISpM5x9';
					$obj->HashIV = 'v77hoKGq4kWxNNIS';
				endif;

				$LogisticsSubType = ($row['order_delivery'] != '711_pickup') ? LogisticsSubType::FAMILY_C2C : LogisticsSubType::UNIMART_C2C;

				$obj->Send['MerchantTradeNo'] = $this->input->post('MerchantTradeNo'); //綠界訂單編號
				$obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); // 物流單生成時間
				$obj->Send['LogisticsType'] = LogisticsType::CVS; // 超商物流選擇
				$obj->Send['LogisticsSubType'] = $LogisticsSubType; // 超商選擇
				$obj->Send['GoodsAmount'] = (int)$this->input->post('TradeAmt'); // 商品總價
				$obj->Send['GoodsName'] = 'Cargo'; // 商品名稱
				$obj->Send['SenderName'] = get_setting_general('short_name'); // 電商名稱
				$obj->Send['SenderPhone'] = get_setting_general('phone1'); // 電商電話
				$obj->Send['SenderCellPhone'] = get_setting_general('cellphone1'); // 電商手機
				$obj->Send['ReceiverName'] = $row['customer_name'];
				$obj->Send['ReceiverPhone'] = '';
				$obj->Send['ReceiverCellPhone'] = $row['customer_phone'];
				$obj->Send['ReceiverEmail'] = '';
				$obj->Send['TradeDesc'] = '';
				$obj->Send['ServerReplyURL'] = base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv); // 訂單ID加密
				$obj->Send['ClientReplyURL'] = '';
				$obj->Send['LogisticsC2CReplyURL'] = base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv); // 訂單ID加密
				$obj->Send['Remark'] = '';
				$obj->PostParams['ReceiverStoreID'] = $row['store_id'];
				// $obj->SendExtend['ReturnStoreID'] = $row['store_id'];

				// 送出(記得這邊API要改動不然有BUG)
				$response = $obj->BGCreateShippingOrder($row['store_id']);

				if ($response['ResCode'] == '1') {
					// print_r($response['AllPayLogisticsID']);
					// print_r($response['CVSPaymentNo']);check_pay
					$data = array(
						'AllPayLogisticsID' => get_empty($response['AllPayLogisticsID']),
						'CVSPaymentNo' => get_empty($response['CVSPaymentNo']),
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
				}

				// 檢查託運單資料
				// echo '<pre>';
				// print_r($response);
				// echo '</pre>';
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			// 訂單ID加密
			// redirect(base_url() . 'checkout/success/' . $order_id);
			redirect(base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv));
		} else {
			// 訂單ID加密
			// redirect(base_url() . 'checkout/success/' . $order_id);
			redirect(base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv));
		}
	}

	public function line_pay_confirm()
	{
		// New -----
		$channelId     = "2000014653"; // 通路ID
		$channelSecret = "af271193c5642181568b743846d72e60"; // 通路密鑰
		if ($this->is_liqun_food) {
			$channelId     = get_setting_general('lp_channel_id'); // 通路ID
			$channelSecret = get_setting_general('lp_channel_secret_key'); // 通路密鑰
		}
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
				'amount' => (int) $order['params']['amount'],
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
		$order_id = 0;
		$this->db->select('order_id');
		$this->db->where('order_number', $order_number);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$order_id = $row['order_id'];
		}

		if ($rtncode == '0000' && $order_id > 0) {
			$update_data = array(
				'order_pay_status' => 'paid',
				'order_pay_feedback' => get_empty($transactionId),
			);
			$this->db->where('order_id', $order_id);
			$this->db->update('orders', $update_data);

			redirect(base_url() . 'checkout/success/' . $order_id);
		} else {
			// redirect(base_url() . 'checkout/success/' . $order_id);
		}
		// Redirect to successful page
		// header("Location: {$successUrl}");
	}

	public function get_store_info()
	{
		$this->load->view('checkout/get_store_info');
	}

	public function form_check()
	{
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

	public function send_order_email($order_id)
	{
		// 查詢訂單資訊
		// $this->db->join('users', 'users.id = orders.customer_id');
		$this->db->where('order_id', $order_id);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			$this->db->where('order_id', $row['order_id']);
			$query2 = $this->db->get('order_item');
		}

		$subject = '非常感謝您，您的訂單已接收 - ' . get_setting_general('name');

		$header = '<img src="' . base_url() . 'assets/uploads/' . get_setting_general('logo') . '" height="100px">
        <h3>' . $row['customer_name'] . ' 您好：</h3>
        <h3>您在 ' . get_setting_general('name') . ' 的訂單已完成訂購，以下是您的訂單明細：</h3>';

		$message = '<table style="width:100%;background:#fafaf8;padding:15px;">
        <tr style="border-bottom:2px solid #e41c10;">
            <td><h3>【訂購明細】</h3><hr></td>
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
                訂單狀況 : 訂單確認
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
		$content .= '<thead>';
		$content .= '<tr>';
		$content .= '<th style="text-align:center;">#</th>';
		$content .= '<th style="text-align:center;">圖片</th>';
		$content .= '<th style="text-align:left;">商品</th>';
		$content .= '</tr>';
		$content .= '</thead>';

		$content .= '<tbody>';
		$i = 1;
		$total = 0;
		if ($query2->num_rows() > 0) {
			foreach ($query2->result_array() as $items) {
				if ($items['product_id'] == 0) {
					$content .= '<tr>';
					$content .= '<td style="text-align:center">' . $i . '</td>';
					$query_img = $this->mysql_model->_select('product_combine', 'id', $items['product_combine_id'], 'row');
					foreach ($query_img as $img) {
						$content .= '<td style="text-align:center"><img src="' . base_url() . 'assets/uploads/' . $img['picture'] . '" height="80px"></td>';
					}
					$content .= '<td style="text-align:left">';
					$content .= '<div>';
					$x = 0;
					$this->db->select('*');
					$this->db->from('product_combine');
					$this->db->join('product_combine_item', 'product_combine.id = product_combine_item.product_combine_id', 'right');
					$this->db->where('product_combine.id', $items['product_combine_id']);
					$query_product = $this->db->get();
					foreach ($query_product->result_array() as $product) {
						if ($x < 1) {
							$content .= get_product_name($product['product_id']) . ' - ' . get_product_combine_name($product['product_combine_id']);
						}
						$content .= '<ul style="color: gray;">';
						$content .= '<li style="list-style-type: circle;">';
						$content .= $product['qty'] . ' ' . $product['product_unit'];
						if (!empty($product['product_specification'])) {
							$content .= ' - ' . $product['product_specification'];
						}
						foreach ($query2->result_array() as $specification_item) {
							if ($specification_item['specification_id'] != 0 && $specification_item['order_item_qty'] == 0 && $items['product_combine_id'] == $specification_item['product_combine_id']) {
								$this->db->select('*');
								$this->db->from('product_specification');
								$this->db->where('id', $specification_item['specification_id']);
								$query_specification = $this->db->get();
								foreach ($query_specification->result_array() as $row_specification) {
									$content .= '<br>' . '✓ ' . $row_specification['specification'] . ' x ' . $specification_item['specification_qty'];
								}
							}
						}
						$content .= '</li>';
						$content .= '</ul>';
						$x++;
					}
					$content .= '</div>';
					$content .= '<div>金額：$' . number_format($items['order_item_price']) . '</div>';
					$content .= '<div>數量：' . $items['order_item_qty'] . '</div>';
					$content .= '<div>小計：<span style="color:#dd0606;">$' . number_format($items['order_item_qty'] * $items['order_item_price']) . '</span></div>';
					$content .= '</td>';
					$content .= '</tr>';
					$content .= '</tbody>';
					$total += $items['order_item_qty'] * $items['order_item_price'];
					$i++;
				}
			}
		};

		$content .= '<tr><td colspan="3"><hr></td></tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:left;font-weight: bold;font-size: 16px;"><strong>小計：</strong><span style="color: #dd0606;">$' . number_format($total) . '</sapn></td>';
		$content .= '</tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:left;font-weight: bold;font-size: 16px;"><strong>運費：</strong><span style="color: #dd0606;">$' . number_format($row['order_delivery_cost']) . '</sapn></td>';
		$content .= '</tr>';
		$content .= '<tr>';
		$content .= '<td colspan="2"> </td>';
		$content .= '<td style="text-align:left;font-weight: bold;font-size: 16px;"><strong>總計：</strong><span style="color: #dd0606;">$' . number_format($row['order_discount_total']) . '</sapn></td>';
		$content .= '</tr>';
		// $content .= '<tr><td colspan="4" text-align="center"><a href="' . base_url() . 'order" target="_blank" class="order-check-btn"style="color: #000;">訂單查詢</a></td></tr>';

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
                    訂單備註：' . $row['order_remark'] . '
                </div>
            </td>
        </tr>
        </table>
        <br>';

		if (get_setting_general('mail_footer_text') != '') {
			$information .= '<h4>' . get_setting_general('mail_footer_text') . '</h4>';
		}

		if (get_setting_general('official_line_1_qrcode') != '') {
			$information .= '<h3>【官方客服LINE QR Code】</h3>
        		<img src="' . base_url() . 'assets/uploads/' . get_setting_general('official_line_1_qrcode') . '" height="150px">';
		}

		$footer = '<div style="width:100%;height:50px;;background:#f0f6fa;"><span style="display:block;padding:15px;font-size:12px;">此郵件是系統自動傳送，請勿直接回覆此郵件</span><div>';

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


		// 寄信給賣家
		$this->email->set_smtp_host(get_setting_general('smtp_host'));
		$this->email->set_smtp_user(get_setting_general('smtp_user'));
		$this->email->set_smtp_pass(get_setting_general('smtp_pass'));
		$this->email->set_smtp_port(get_setting_general('smtp_port'));
		$this->email->set_smtp_crypto(get_setting_general('smtp_crypto'));

		$this->email->to($row['customer_email']);
		$this->email->from('service@td-stuff.com', get_setting_general('name'));
		$this->email->subject($subject);
		$this->email->message($body);
		// echo $content;
		if ($this->email->send()) {
			// echo "1";
		} else {
			// echo "0";
		}
	}

	public function test_send_email()
	{
		echo 'ccc___';

		$this->email->set_smtp_host("mail.td-stuff.com");
		$this->email->set_smtp_user("service@td-stuff.com");
		$this->email->set_smtp_pass("Td-stuff@admin");
		$this->email->set_smtp_port("587");
		$this->email->set_smtp_crypto("");

		//Email content
		$htmlContent = '<h1>Sending email via SMTP server</h1>';
		$htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

		$list = array('a0935756869@gmail.com', 'sianming30@gmail.com', 'sianming31@gmail.com');
		$list = array('a0935756869@gmail.com');
		$this->email->to($list);
		$this->email->from('service@td-stuff.com', get_setting_general('name'));
		$this->email->subject('How to send email via SMTP server in CodeIgniter');
		$this->email->message($htmlContent);

		//Send email
		if ($this->email->send()) {
			echo '1';
		} else {
			echo '0';
		}
	}

	function test_qpay($order_id = 0)
	{
		if ($order_id == 0) {
			exit;
		}

		$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');

		$qpay = new \Sinopac\QPay();
		$qpay->setShopNo('NA0216_001');
		$qpay->setFirstHashPair('8806BFF40F5E43D6', 'F53EEDD2E4C946B8');
		$qpay->setSecondHashPair('9E45ED540B944B81', '6E0DED3AE3684258');

		// Enabling sandbox mode will send API request to Sinopac's testing server.
		$qpay->enableSandbox();

		$data = [
			'shop_no' => 'NA0216_001',
			'order_no' => 'C' . date("YmdHis"),
			'amount' => 5000,
			'cc_auto_billing' => 'Y',
			'cc_expired_billing_days' => 7,
			'cc_expired_minutes' => 10,
			'product_name' => '信用卡訂單',
			'return_url' => base_url() . 'checkout/test_qpay_return',
			'backend_url' => 'http://10.11.22.113:8803/QPay.ApiClient/AutoPush/PushSuccess',
		];

		$results = $qpay->createOrderByCreditCard($data);

		if (!empty($results['Message'])) {
			print_r($results['Message']);
		}
	}

	function test_qpay_return()
	{
		print_r($_POST);
	}

	function aesEncrypt($data, $key, $iv)
	{
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
		return base64_encode($encrypted);
	}

	function aesDecrypt($data, $key, $iv)
	{
		$decrypted = openssl_decrypt(base64_decode($data), 'aes-256-cbc', $key, 0, $iv);
		return $decrypted;
	}
}
