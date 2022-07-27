<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('cart');
	}

	public function index() {
		$this->data['page_title'] = '結帳';

		//
		$this->data['user_data']['name'] = '';
        $this->data['user_data']['phone'] = '';
        $this->data['user_data']['email'] = '';
        $this->data['user_data']['address'] = '';
        if ($this->ion_auth->logged_in() && !empty($this->current_user)){
        	$this->data['user_data']['name'] = $this->current_user->full_name;
        	$this->data['user_data']['phone'] = $this->current_user->phone;
        	$this->data['user_data']['email'] = $this->current_user->email;
        	$this->data['user_data']['address'] = $this->current_user->address;
        }
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
		$this->db->select('MAX(order_number) as last_number');
    	$this->db->like('order_number', $y.$m.$d, 'after');
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

		$delivery_cost = 0;

		$order_delivery_address = '';
		if($this->input->post('county')!=''){
			$order_delivery_address .= $this->input->post('county');
		}
		if($this->input->post('district')!=''){
			$order_delivery_address .= $this->input->post('district');
		}
		if($this->input->post('address')!=''){
			$order_delivery_address .= $this->input->post('address');
		}

		$order_total = intval($this->cart->total() + $delivery_cost);

		$order_pay_status = 'not_paid';

		$insert_data = array(
			'order_number' => $order_number,
			'order_date' => date("Y-m-d"),
			'customer_name' => $this->input->post('name'),
			'customer_phone' => $this->input->post('phone'),
			'customer_email' => $this->input->post('email'),
			'order_total' => $order_total,
			'order_discount_total' => $order_total,
			// 'order_discount_price' => get_empty($discount_price),
			'order_delivery_cost' => $delivery_cost,
			'order_delivery_address' => $order_delivery_address,
			'order_store_name' => get_empty($this->input->post('storename')),
			'order_store_address' => get_empty($this->input->post('storeaddress')),
			'order_delivery' => $this->input->post('checkout_delivery'),
			'order_payment' => $this->input->post('checkout_payment'),
			'order_pay_status' => $order_pay_status,
			'order_step' => 'confirm',
			'order_remark' => $this->input->post('remark'),
			// 'creator_id' => $this->ion_auth->user()->row()->id,
			'created_at' => $created_at,
		);
		$order_id = $this->mysql_model->_insert('orders', $insert_data);

		if ($cart = $this->cart->contents()):
			foreach ($cart as $cart_item):
				$order_item = array(
					'order_id' => $order_id,
					'product_combine_id' => $cart_item['id'],
					'product_id' => 0,
					'order_item_qty' => $cart_item['qty'],
					'order_item_price' => $cart_item['price'],
					'created_at' => $created_at,
				);
				$this->db->insert('order_item', $order_item);

				$this_product_combine_item = $this->mysql_model->_select('product_combine_item', 'product_combine_id', $cart_item['id']);
				if(!empty($this_product_combine_item)) { foreach($this_product_combine_item as $items) {
					$order_item = array(
						'order_id' => $order_id,
						'product_combine_id' => $items['product_combine_id'],
						'product_id' => $items['product_id'],
						'order_item_qty' => ($cart_item['qty']*$items['qty']),
						'order_item_price' => 0,
						'created_at' => $created_at,
					);
					$this->db->insert('order_item', $order_item);
				}}
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
		redirect(base_url() . 'checkout/success');
	}

	public function success()
	{
		$this->data['page_title'] = '訂單完成';
		$this->render('checkout/checkout_success');
	}

	public function get_store_info()
	{
		$this->load->view('checkout/get_store_info');
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

	public function send_order_email($order_number)
    {
        // 查詢訂單資訊
        $this->db->join('users', 'users.id = orders.customer_id');
        $this->db->where('order_number', $order_number);
        $this->db->limit(1);
        $query = $this->db->get('orders');
        if($query->num_rows()>0){
            $row = $query->row_array();

            $this->db->where('order_id', $row['order_id']);
            $query2 = $this->db->get('order_item');
        }

        $subject = '非常感謝您，您的訂單已接收 - '.get_setting_general('name');

        $header = '<img src="'.base_url().'assets/uploads/'.get_setting_general('logo').'" height="100px">
        <h3>'.$row['full_name'].' 您好：</h3>
        <h3>您在 '.get_setting_general('name').' 的訂單已完成訂購，以下是您的訂單明細：</h3>';


        $message = '<table style="width:100%;background:#fafaf8;padding:15px;">
        <tr style="border-bottom:2px solid #e41c10;">
            <td><h3>【訂購明細】</h3><hr></td>
        </tr>
        <tr>
            <td>
                店家名稱 : '.get_store_name($row['store_id']).'
            </td>
        </tr>
        <tr>
            <td>
                訂單編號 : '.$row['order_number'].'
            </td>
        </tr>
        <tr>
            <td>
                付款方式 : '.get_payment($row['order_payment']).'
            </td>
        </tr>
        <tr>
            <td>
                訂單狀況 : 接收訂單
            </td>
        </tr>
        <tr>
            <td>
                訂購日期 : '.$row['order_date'].'
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
        $total=0;
        if ($query2->num_rows() > 0) { foreach($query2->result_array() as $items){
            $content .= '<tr>';
                $content .= '<td>'.get_product_name($items['product_id']);
                $content .= '</td>';
                $content .= '<td style="text-align:right">NT$ '.number_format($items['order_item_price']).'</td>';
                $content .= '<td style="text-align:center">'.$items['order_item_qty'].'</td>';
                $content .= '<td style="text-align:right">NT$ '.number_format($items['order_item_price']*$items['order_item_qty']).'</td>';
            $content .= '</tr>';
            $total+=$items['order_item_qty']*$items['order_item_price'];
        $i++;
        }};

        $content .= '<tr><td colspan="4"><hr></td></tr>';
        $content .= '<tr>';
        $content .= '<td colspan="2"> </td>';
        $content .= '<td style="text-align:right"><strong>小計</strong></td>';
        $content .= '<td style="text-align:right">NT$ '.number_format($total).'</td>';
        $content .= '</tr>';
        $content .= '<tr>';
        $content .= '<td colspan="2"> </td>';
        $content .= '<td style="text-align:right"><strong>運費</strong></td>';
        $content .= '<td style="text-align:right">NT$ '.number_format($row['order_delivery_cost']).'</td>';
        $content .= '</tr>';
        $content .= '<tr>';
        $content .= '<td colspan="2"> </td>';
        $content .= '<td style="text-align:right"><strong>優惠券折抵</strong></td>';
        $content .= '<td style="text-align:right">NT$ -'.number_format($row['order_discount_price']).'</td>';
        $content .= '</tr>';
        $content .= '<tr>';
        $content .= '<td colspan="2"> </td>';
        $content .= '<td style="text-align:right"><strong>總計</strong></td>';
        $content .= '<td style="text-align:right">NT$ '.number_format($row['order_discount_total']).'</td>';
        $content .= '</tr>';
        $content .= '<tr><td colspan="4" text-align="center"><a href="'.base_url().'order" target="_blank" class="order-check-btn"style="color: #000;">訂單查詢</a></td></tr>';

        $content .= '</table>';

        $information = '<table style="width:100%;background:#fafaf8;padding:15px;">
        <tr style="border-bottom:2px solid #e41c10;">
            <td><h3>【收件資訊】</h3><hr></td>
        </tr>
        <tr>
            <td>
                收件姓名 : '.$row['customer_name'].'
            </td>
        </tr>
        <tr>
            <td>
                聯絡電話 : '.$row['customer_phone'].'
            </td>
        </tr>
        <tr>
            <td>
                收件地址 : '.$row['order_delivery_address'].'
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:100%;background:#fff;padding:15px 0px 15px 10px;border:1px dashed #979797;">
                    備註 : '.$row['order_remark'].'
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
                '.$header.'
                '.$message.'
                '.$content.'
                '.$information.'
                '.$footer.'
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
        if ($this->email->send()){
            // echo "<h4>Send Mail is Success.</h4>";
        } else {
            // echo "<h4>Send Mail is Fail.</h4>";
        }

        // 寄信給店家
        $subject = '有新的訂單 - 單號：'.$row['order_number'];
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
        if ($this->email->send()){
            // echo "<h4>Send Mail is Success.</h4>";
        } else {
            // echo "<h4>Send Mail is Fail.</h4>";
        }
    }

}