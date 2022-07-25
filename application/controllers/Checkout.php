<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('cart');
	}

	public function index() {
		$this->data['page_title'] = '結帳';
		$this->render('checkout/index');
	}

	public function save_order() {
		// if (!$this->ion_auth->logged_in()) {
		// 	redirect('login', 'refresh');
		// }

		$this->data['page_title'] = '結帳';

		$date = date('Y-m-d');
		$y = substr($date, 0, 4);
    	$m = substr($date, 5, 2);
    	$d = substr($date, 8, 2);
		$CI->db->select('MAX(order_number) as last_number');
    	$CI->db->like('order_number', $y.$m.$d, 'after');
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			$row = $query->row();
	        if($row->last_number==null){
	            $order_number = $y.$m.$d.'001';
	        } else {
	            $order_number = preg_replace('/[^\d]/', '', $row->last_number);
	            $order_number++;
	        }
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

		// 儲存訂單其他資訊
		// $session_data = array(
		// 	'order_number' => $order_number,
		// 	'user_name' => $this->input->post('checkout_name'),
		// 	'user_phone' => $this->input->post('checkout_phone'),
		// 	'user_email' => $this->input->post('checkout_email'),
		// 	'remark' => $this->input->post('checkout_remark'),
		// 	'payment' => $this->input->post('checkout_payment'),
		// );
		// $this->session->set_userdata($session_data);

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
		}
		redirect(base_url() . 'order');
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