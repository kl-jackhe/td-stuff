<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '結帳';

		$this->data['payment'] = $this->mysql_model->_select('payment', 'payment_status', '1');
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'delivery_status', '1');

		$this->data['user_data']['name'] = '';
		$this->data['user_data']['phone'] = '';
		$this->data['user_data']['email'] = '';
		$this->data['user_data']['address'] = '';
		if ($this->ion_auth->logged_in() && !empty($this->current_user)) {
			$this->data['user_data']['name'] = $this->current_user->full_name;
			$this->data['user_data']['phone'] = $this->current_user->phone;
			$this->data['user_data']['email'] = $this->current_user->email;
			$this->data['user_data']['address'] = $this->current_user->address;
		} else {
			$this->data['user_data']['name'] = get_cookie("user_name", true);
			$this->data['user_data']['phone'] = get_cookie("user_phone", true);
			$this->data['user_data']['email'] = get_cookie("user_email", true);
			$this->data['user_data']['address'] = get_cookie("user_address", true);
		}
		$this->render('checkout/index');
	}

	function set_user_data() {
		set_cookie("user_name", $this->input->post('name'), 30 * 86400);
		set_cookie("user_phone", $this->input->post('phone'), 30 * 86400);
		set_cookie("user_email", $this->input->post('email'), 30 * 86400);
		set_cookie("user_address", $this->input->post('address'), 30 * 86400);
	}

	public function save_order() {
		$this->data['page_title'] = '結帳';

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
				$order_number = $y . $m . $d . '001';
			} else {
				$order_number = preg_replace('/[^\d]/', '', $row->last_number);
				$order_number++;
			}
		}

		$customer_id = 0;
		if (isset($this->current_user->id)) {
			$customer_id = $this->current_user->id;
		}

		$delivery_cost = 0;

		$order_delivery_address = '';
		if ($this->input->post('county') != '') {
			$order_delivery_address .= $this->input->post('county');
		}
		if ($this->input->post('district') != '') {
			$order_delivery_address .= $this->input->post('district');
		}
		if ($this->input->post('address') != '') {
			$order_delivery_address .= $this->input->post('address');
		}

		$order_total = intval($this->cart->total() + $delivery_cost);

		$order_pay_status = 'not_paid';

		$created_at = date("Y-m-d H:i:s");
		$insert_data = array(
			'order_number' => $order_number,
			'order_date' => date("Y-m-d"),
			'customer_id' => $customer_id,
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

		foreach ($this->cart->contents() as $cart_item):
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
			if (!empty($this_product_combine_item)) {
				foreach ($this_product_combine_item as $items) {
					$order_item = array(
						'order_id' => $order_id,
						'product_combine_id' => $items['product_combine_id'],
						'product_id' => $items['product_id'],
						'order_item_qty' => ($cart_item['qty'] * $items['qty']),
						'order_item_price' => 0,
						'created_at' => $created_at,
					);
					$this->db->insert('order_item', $order_item);
				}
			}
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
						'specification_qty' => $specification_id[$qty_array],
						'created_at' => $created_at,
					);
					$this->db->insert('order_item', $order_item);
					$qty_array++;
				}
			}
		endforeach;

		// Start 寄信給買家、賣家
		$this->send_order_email($order_id);

		// 綠界-信用卡
		if ($this->input->post('checkout_payment') == 'ecpay') {

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
				$obj->HashKey = 'ZtzbR917Xc6Dn5qf'; //測試用Hashkey，請自行帶入ECPay提供的HashKey
				$obj->HashIV = 'ZtzbR917Xc6Dn5qf'; //測試用HashIV，請自行帶入ECPay提供的HashIV
				$obj->MerchantID = '3382155'; //測試用MerchantID，請自行帶入ECPay提供的MerchantID
				$obj->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密

				//基本參數(請依系統規劃自行調整)
				$MerchantTradeNo = $order_number . substr(time(), 4, 6);
				$obj->Send['MerchantTradeNo'] = $MerchantTradeNo; //訂單編號
				$obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
				$obj->Send['TotalAmount'] = $order_total; //交易金額
				$obj->Send['TradeDesc'] = get_empty_remark('網站訂單: '.$this->input->post('remark')); //交易描述
				$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit; //付款方式:Credit
				$obj->Send['ReturnURL'] = base_url(); //付款完成通知回傳的網址
				$obj->Send['OrderResultURL'] = base_url() . "checkout/check_pay/" . $order_number; //付款完成通知回傳的網址
				//$obj->Send['ClientBackURL']     = base_url(); //付款完成後，顯示返回商店按鈕

				//$obj->Send['NeedExtraPaidInfo'] = ECPay_ExtraPaymentInfo::Yes;
				//訂單的商品資料
				array_push($obj->Send['Items'], array(
				    'Name' => "網購商品",
				    'Price' => (int)$order_total,
				    'Currency' => "元",
				    'Quantity' => (int) "1筆",
				    'URL' => "dedwed"
				));
				// if ($cart = $this->cart->contents()):
				// 	foreach ($cart as $item):
				// 		array_push($obj->Send['Items'], array(
				// 			'Name' => get_product_name($item['id']),
				// 			'Price' => (int) $item['price'],
				// 			'Currency' => "元",
				// 			'Quantity' => (int) $item['qty'],
				// 			'URL' => "dedwed",
				// 		));
				// 	endforeach;
				// endif;
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

		// Line Pay
		} elseif ($this->input->post('checkout_payment')=='line_pay') {

            // Line Pay
            // New -----
            $channelId     = "1605255943"; // 通路ID
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
                                "name" => '網購商品',
                                "quantity" => 1,
                                "price" => $order_total,
                                "imageUrl" => 'https://td-stuff.com/assets/uploads/web_logo_td.png',
                            ],
                        ],
                    ],
                ],
                "redirectUrls" => [
                    "confirmUrl" => base_url()."checkout/line_pay_confirm",
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
            header('Location: '. $response->getPaymentUrl() );

        }else {
			redirect(base_url() . 'checkout/success/' . $order_id);
		}
	}

	public function success($id) {
		$this->data['page_title'] = '訂單完成';
		$this->cart->destroy();

		// $this->db->where('session_id', $this->session_id);
		// $this->db->delete('cart');

		$this->data['order'] = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
		$this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $id);
		$this->render('checkout/checkout_success');
	}

	public function check_pay($order_number)
    {
        $rtncode = $_POST['RtnCode'];
        // echo $rtncode.'<br>';
        $merchanttradeno = $_POST['MerchantTradeNo'];
        // $merchanttradeno = substr($merchanttradeno, 0, 14);
        // echo $merchanttradeno.'<br>';
        // $order_number = substr($merchanttradeno, 0, 14);

        // 查詢訂單資訊
        $order_id = 0;
        $this->db->select('order_id');
        $this->db->where('order_number', $order_number);
        $this->db->limit(1);
        $query = $this->db->get('orders');
        if($query->num_rows()>0){
            $row = $query->row_array();
            $order_id = $row['order_id'];
        }

        if($rtncode == '1' && $order_id > 0){

            $data = array(
                'order_pay_status' => 'paid',
                'order_pay_feedback' => get_empty($merchanttradeno),
            );
            $this->db->where('order_id', $order_id);
            $this->db->update('orders', $data);

            redirect(base_url() . 'checkout/success/' . $order_id);
        } else {
            // redirect(base_url() . 'checkout/success/' . $order_id);
        }
    }

    public function line_pay_confirm()
    {
        // New -----
        $channelId     = "1605255943"; // 通路ID
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
            die("<script>alert('TransactionId doesn\'t match');location.href=".base_url().";</script>");
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
        $order_id = 0;
        $this->db->select('order_id');
        $this->db->where('order_number', $order_number);
        $this->db->limit(1);
        $query = $this->db->get('orders');
        if($query->num_rows()>0){
            $row = $query->row_array();
            $order_id = $row['order_id'];
        }

        if($rtncode == '0000' && $order_id > 0){
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

	public function get_store_info() {
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

	public function send_order_email($order_id) {
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
					$this->db->select('*');
					$this->db->from('product_combine');
					$this->db->where('id', $items['product_combine_id']);
					$query_img = $this->db->get();
					foreach ($query_img->result_array() as $img) {
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
				}}};

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
                    訂單備註：' . $row['order_remark'] . '
                </div>
            </td>
        </tr>
        </table>
        ';

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

		$this->load->library('email');

		// 寄信給賣家
		$this->email->set_smtp_host("mail.td-stuff.com");
		$this->email->set_smtp_user("service@td-stuff.com");
		$this->email->set_smtp_pass("Td-stuff@admin");
		$this->email->set_smtp_port("587");
		$this->email->set_smtp_crypto("");

		$this->email->to($row['customer_email']);
		$this->email->from('service@td-stuff.com', get_setting_general('name'));
		$this->email->subject($subject);
		$this->email->message($body);
		// echo $content;
		if ($this->email->send()) {
			echo "1";
		} else {
			echo "0";
		}
	}

	public function test_send_email() {
		echo 'ccc___';
		//Load email library
		$this->load->library('email');

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

	function test_qpay($order_id = 0) {
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

	function test_qpay_return() {
		print_r($_POST);
	}

}