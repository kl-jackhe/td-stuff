<?php defined('BASEPATH') or exit('No direct script access allowed');

class Order extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('order_model');
		$this->load->model('sales_model');
		$this->load->model('agent_model');
		$this->load->model('product_model');

		$this->data['step_list'] = array(
			'' => '訂單狀態',
			'confirm' => '訂單確認',
			'pay_ok' => '已收款',
			'process' => '待出貨',
			'preparation' => '調貨中',
			'shipping' => '已出貨',
			'complete' => '完成',
			'order_cancel' => '訂單取消',
			'invalid' => '訂單不成立',
			'returning' => '退貨處理中',
			'return_complete' => '訂單已退貨',
		);
	}

	public function index()
	{
		$this->data['page_title'] = '訂單管理';
		$this->data['payment'] = $this->order_model->getPaymentList();
		$this->data['delivery'] = $this->order_model->getDeliveryList();
		$this->data['single_sales'] = $this->sales_model->getSingleSalesList();
		$this->data['agent'] = $this->agent_model->getAgentList();
		$this->data['product'] = $this->product_model->getProductList();
		$this->render('admin/order/index');
	}

	function ajaxData()
	{
		$conditions = array();
		//calc offset number
		$page = $this->input->get('page');
		if (!$page) {
			$offset = 0;
			$this->input->set_cookie("order_page", '0', 3600);
		} else {
			$offset = $page;
			$this->input->set_cookie("order_page", $page, 3600);
		}
		//set conditions for search
		$keywords = $this->input->get('keywords');
		$product = $this->input->get('product');
		$category = $this->input->get('category');
		$category1 = $this->input->get('category1');
		$category2 = $this->input->get('category2');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$sales = $this->input->get('sales');
		$agent = $this->input->get('agent');
		setcookie('order_keywords', $keywords, time() + 3600, '/');
		setcookie('order_product', $product, time() + 3600, '/');
		setcookie('order_category', $category, time() + 3600, '/');
		setcookie('order_category1', $category1, time() + 3600, '/');
		setcookie('order_category2', $category2, time() + 3600, '/');
		setcookie('order_start_date', $start_date, time() + 3600, '/');
		setcookie('order_end_date', $end_date, time() + 3600, '/');
		setcookie('order_sales', $sales, time() + 3600, '/');
		setcookie('order_agent', $agent, time() + 3600, '/');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}
		if (!empty($product)) {
			$conditions['search']['product'] = $product;
		}
		if (!empty($category)) {
			$conditions['search']['step'] = $category;
		}
		if (!empty($category1)) {
			$conditions['search']['delivery'] = $category1;
		}
		if (!empty($category2)) {
			$conditions['search']['payment'] = $category2;
		}
		if (!empty($start_date)) {
			$conditions['search']['start_date'] = $start_date;
		}
		if (!empty($end_date)) {
			$conditions['search']['end_date'] = $end_date;
		}
		if (!empty($sales)) {
			$conditions['search']['sales'] = $sales;
		}
		if (!empty($agent)) {
			$conditions['search']['agent'] = $agent;
		}
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->order_model->getRows($conditions);
		//pagination configuration
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'admin/order/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination_admin->initialize($config);
		//set start and limit
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		//get posts data
		$conditions['returnType'] = '';
		$this->data['orders'] = $this->order_model->getRows($conditions);
		//load the view
		$this->load->view('admin/order/ajax-data', $this->data, false);
	}

	public function view($id)
	{
		$this->data['page_title'] = '訂單明細';
		$this->data['order'] = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
		$this->data['order_item'] = $this->mysql_model->_select('order_item', 'order_id', $id);
		if($this->is_partnertoys){
			$this->data['guestbook'] = $this->order_model->getGuestBook($id);
		}

		// echo '<pre>';
		// echo 'order_item = ';
		// print_r($this->data['order_item']);
		// echo '</pre>';

		// $this->db->select_sum('order_item_qty');
		// $this->db->select('order_id,product_combine_id,order_item_price');
		// $this->db->where('order_id', $id);
		// $this->db->where('product_id', 0);
		// $this->db->group_by('product_combine_id');
		// $this->db->order_by('order_item_id', 'asc');
		// $this->data['order_item'] = $this->db->get('order_item')->result_array();
		$this->render('admin/order/view');
	}

	public function getOrderItem($id)
	{
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($this->mysql_model->_select('order_item', 'order_id', $id)));
	}

	public function message_delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('guestbook');
		$this->session->set_flashdata('message', '刪除成功');
		echo '<script>window.history.back()</script>';
		// redirect('admin/order/view/' . $id);
	}

	public function message_insert($id)
	{
		$content = $this->input->post('content');
		$symMessage = $this->input->post('symMessage');
		$data = array(
			'user_id' => 0,
			'order_id' => $id,
			'content' => $content,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$new_id = $this->mysql_model->_insert('guestbook', $data);
		$this->session->set_flashdata('message', '留言成功');
		if ($symMessage == '1') {
			$this->send_message_email($new_id);
		}
		redirect('admin/order/view/' . $id);
	}

	public function send_message_email($id)
	{
		$subject = '夥伴玩具有限公司 - 訂單留言回覆';
		$guestbook = $this->mysql_model->_select('guestbook', 'id', $id, 'row');
		$order = $this->mysql_model->_select('orders', 'order_id', $guestbook['order_id'], 'row');
		$user = $this->mysql_model->_select('users', 'id', $order['customer_id'], 'row');
		// 加载邮件模板文件
		$mail_data = array(
			'subject' => $subject,
			'webname' => get_setting_general('name'),
			'email' => get_setting_general('email'),
			'tel' => get_setting_general('phone1'),
			'cname' => $user['full_name'],
			'content' => $guestbook['content'],
			'created_at' => $guestbook['created_at'],
		);
		$body = $this->load->view('order/mail_template_guest_tw', $mail_data, true); // 将视图内容作为字符串返回
		$this->load->library('email');
		// 賣家資料
		$this->email->set_smtp_host(get_setting_general('smtp_host'));
		$this->email->set_smtp_user(get_setting_general('smtp_user'));
		$this->email->set_smtp_pass(get_setting_general('smtp_pass'));
		$this->email->set_smtp_port(get_setting_general('smtp_port'));
		$this->email->set_smtp_crypto(get_setting_general('smtp_crypto'));
		// 買家資料
		$this->email->to($user['email']);
		$this->email->from(get_setting_general('email'), get_setting_general('name'));
		$this->email->subject($subject);
		$this->email->message($body);

		try {
			if ($this->email->send()) {
				echo "1";
			} else {
				throw new Exception('unknown error');
			}
		} catch (Exception $e) {
			echo "0";
		}
	}

	public function update_remittance_account($id)
	{
		$data = array(
			'remittance_account' => $this->input->post('remittance_account'),
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('order_id', $id);
		$this->db->update('orders', $data);

		$this->session->set_flashdata('message', '訂單更新成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function updata_self_logistics($id)
	{
		$data = array(
			'SelfLogistics' => $this->input->post('self_logistics'),
		);
		$this->db->where('order_id', $id);
		$this->db->update('orders', $data);

		$this->session->set_flashdata('message', '訂單更新成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function updata_all_pay_logistics_id($id)
	{
		$data = array(
			'AllPayLogisticsID' => $this->input->post('all_pay_logistics_id'),
		);
		$this->db->where('order_id', $id);
		$this->db->update('orders', $data);

		$this->session->set_flashdata('message', '訂單更新成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}


	function selectBoxChangeStep()
	{
		foreach ($this->input->post('id_list') as $id) {
			$this->update_step($id, $this->input->post('step'));
		}
	}

	public function update_step($id = '', $step = '')
	{
		if ($id == '') {
			$id = $this->input->post('id');
		}
		if ($step == '') {
			$step = $this->input->post('step');
		}

		// 已取貨
		if ($step == 'picked') {
			$data = array(
				'order_step' => $step,
				'order_pay_status' => 'paid',
				'updater_id' => $this->current_user->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$this->db->where('order_id', $id);
			$this->db->update('orders', $data);
			// 取消
		} elseif ($step == 'cancel') {
			// 如果是LINE PAY，刷退
			$this_order = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
			if ($this_order['order_payment'] == 'line_pay' && $this_order['order_pay_status'] == 'paid') {
				$this->line_pay_refund($id);
			}
			$data = array(
				'order_step' => 'cancel',
				'order_pay_status' => 'cancel',
				'order_void' => '1',
				'updater_id' => $this->current_user->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$this->db->where('order_id', $id);
			$this->db->update('orders', $data);
			//
			$item_data = array(
				'order_item_void' => '1',
			);
			$this->db->where('order_id', $id);
			$this->db->update('order_item', $item_data);
			// 退單
		} elseif ($step == 'void') {
			// 如果是LINE PAY，刷退
			$this_order = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
			if ($this_order['order_payment'] == 'line_pay' && $this_order['order_pay_status'] == 'paid') {
				$this->line_pay_refund($id);
			}
			$data = array(
				'order_step' => 'void',
				'order_pay_status' => 'return',
				'order_void' => '1',
				'updater_id' => $this->current_user->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$this->db->where('order_id', $id);
			$this->db->update('orders', $data);
			//
			$item_data = array(
				'order_item_void' => '1',
			);
			$this->db->where('order_id', $id);
			$this->db->update('order_item', $item_data);
			// 其他
		} else {
			$data = array(
				'order_step' => $step,
				'updater_id' => $this->current_user->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			if ($step == 'pay_ok') {
				// 已收款
				$data['state'] = 1;
			}
			$this->db->where('order_id', $id);
			$this->db->update('orders', $data);
		}

		$this_order = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
		$this_order_item = $this->mysql_model->_select('order_item', 'order_id', $id);

		// if($step!='prepare' && $step!='shipping' && $step!='arrive'){
		if ($step == 'picked' || $step == 'cancel' || $step == 'void') {
			// Start 寄信給買家

			$subject = '您的訂單 ' . $this_order['order_number'] . ' ' . get_order_step($step) . ' - ' . get_setting_general('name');

			$header = '<img src="' . base_url() . 'assets/uploads/bytheway.png" height="100px">
            <h3>' . get_user_full_name($this_order['customer_id']) . ' 您好：</h3>
            <h3>您在 ' . get_setting_general('name') . ' 的訂單，以下是您的訂單明細：</h3>';

			$message = '<table style="width:100%;background:#fafaf8;padding:15px;">
            <tr style="border-bottom:2px solid #e41c10;">
                <td><h3>【訂購明細】</h3><hr></td>
            </tr>
            <tr>
                <td>
                    訂單編號 : ' . $this_order['order_number'] . '
                </td>
            </tr>
            <tr>
                <td>
                    付款方式 : ' . get_payment($this_order['order_payment']) . '
                </td>
            </tr>
            <tr>
                <td>
                    訂單狀況 : ' . get_order_step($step) . '
                </td>
            </tr>
            <tr>
                <td>
                    訂購日期 : ' . $this_order['order_date'] . '
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
			if (!empty($this_order_item)) {
				foreach ($this_order_item as $items) {
					$content .= '<tr>';
					$content .= '<td>' . get_product_name($items['product_id']);
					$content .= '</td>';
					$content .= '<td style="text-align:right">$ ' . number_format($items['order_item_price']) . '</td>';
					$content .= '<td style="text-align:center">' . $items['order_item_qty'] . '</td>';
					$content .= '<td style="text-align:right">$ ' . number_format($items['order_item_qty'] * $items['order_item_price']) . '</td>';
					$content .= '</tr>';
					$i++;
				}
			}

			$content .= '<tr><td colspan="4"><hr></td></tr>';
			$content .= '<tr>';
			$content .= '<td colspan="2"> </td>';
			$content .= '<td style="text-align:right"><strong>小計</strong></td>';
			$content .= '<td style="text-align:right">NT$ ' . number_format($this_order['order_total'] - $this_order['order_delivery_cost'] - $this_order['order_discount_price']) . '</td>';
			$content .= '</tr>';
			$content .= '<tr>';
			$content .= '<td colspan="2"> </td>';
			$content .= '<td style="text-align:right"><strong>運費</strong></td>';
			$content .= '<td style="text-align:right">NT$ ' . number_format($this_order['order_delivery_cost']) . '</td>';
			$content .= '</tr>';
			$content .= '<tr>';
			$content .= '<td colspan="2"> </td>';
			$content .= '<td style="text-align:right"><strong>優惠券折抵</strong></td>';
			$content .= '<td style="text-align:right">NT$ -' . number_format($this_order['order_discount_price']) . '</td>';
			$content .= '</tr>';
			$content .= '<tr>';
			$content .= '<td colspan="2"> </td>';
			$content .= '<td style="text-align:right"><strong>總計</strong></td>';
			$content .= '<td style="text-align:right">NT$ ' . number_format($this_order['order_discount_total']) . '</td>';
			$content .= '</tr>';
			$content .= '<tr><td colspan="4" text-align="center"><a href="' . base_url() . 'order" target="_blank" class="order-check-btn" style="color: #000;">訂單查詢</a></td></tr>';

			$content .= '</table>';

			$information = '<table style="width:100%;background:#fafaf8;padding:15px;">
            <tr style="border-bottom:2px solid #e41c10;">
                <td><h3>【收件資訊】</h3><hr></td>
            </tr>
            <tr>
                <td>
                    收件姓名 : ' . $this_order['customer_name'] . '
                </td>
            </tr>
            <tr>
                <td>
                    聯絡電話 : ' . $this_order['customer_phone'] . '
                </td>
            </tr>
            <tr>
                <td>
                    收件地址 : ' . $this_order['order_delivery_address'] . '
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:100%;background:#fff;padding:15px 0px 15px 10px;border:1px dashed #979797;">
                        備註 : ' . $this_order['order_remark'] . '
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

			$this->email->set_smtp_host("mail.td-stuff.com");
			$this->email->set_smtp_user("service@td-stuff.com");
			$this->email->set_smtp_pass("Td-stuff@admin");
			$this->email->set_smtp_port("587");
			$this->email->set_smtp_crypto("");

			$this->email->to($row['customer_email']);
			$this->email->from('service@td-stuff.com', get_setting_general('name'));
			$this->email->subject($subject);
			$this->email->message($body);

			// $this->email->send();
			if ($this->email->send()) {
				// echo "<h4>Send Mail is Success.</h4>";
			} else {
				// echo "<h4>Send Mail is Fail.</h4>";
			}
			// End 寄信給買家
		}

		if ($step == 'arrive' || $step == 'cancel' || $step == 'void') {
			// 寄簡訊給買家
			$phone = $this_order['customer_phone'];
			$order_number = $this_order['order_number'];
			$url = 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=52414831&password=haohua&dstaddr=' . $phone . '&encoding=UTF8&smbody=' . get_setting_general('name') . ' 您的訂單 ' . $order_number . ' ' . get_order_step($step) . '。&response=http://192.168.1.200/smreply.asp';

			file_get_contents($url);
			// 寄簡訊給買家
		}

		if ($this->is_td_stuff) {
			// if ($step == 'pay_ok' || $step == 'process' || $step == 'confirm' || $step == 'invalid') {
			// 	$this->order_synchronize($id);
			// } else {
			// 	$this->order_update_synchronize($id);
			// }
			if ($step != 'invalid') {
				$this->order_synchronize($id);
			}
		}

		if ($this->is_liqun_food) {
			// if ($step == 'pay_ok' || $step == 'process' || $step == 'confirm' || $step == 'invalid') {
			// 	$this->order_synchronize($id);
			// } else {
			// 	$this->order_update_synchronize($id);
			// }
			if ($step != 'invalid') {
				$this->order_synchronize($id);
			}
		}

		//庫存回補
		if ($step == 'order_cancel' && !empty($this_order_item) && !empty($this_order)) {
			$inventory = array();
			foreach ($this_order_item as $toi_row) {
				if ($toi_row['product_id'] > 0) {
					if (array_key_exists($toi_row['product_id'], $inventory)) {
						$inventory[$toi_row['product_id']] += $toi_row['order_item_qty'];
					} else {
						$inventory[$toi_row['product_id']] = $toi_row['order_item_qty'];
					}
				}
			}
			if (!empty($inventory)) {
				foreach ($inventory as $key => $value) {
					$this->db->select('excluding_inventory');
					$this->db->where('product_id', $key);
					$p_row = $this->db->get('product')->row_array();
					if (!empty($p_row)) {
						if ($p_row['excluding_inventory'] == false) {
							$this->db->set('inventory', 'inventory + ' . $value, FALSE);
							$this->db->where('product_id', $key);
							$this->db->update('product');

							$inventory_log = array(
								'product_id' => $key,
								'source' => 'OrderBackfill',
								'change_history' => $value,
								'change_notes' => $this_order['order_number'],
							);
							$this->db->insert('inventory_log', $inventory_log);
						}
					}
				}
			}
		}
		// $this->session->set_flashdata('message', '訂單更新成功！');
		// redirect($_SERVER['HTTP_REFERER']);
	}

	public function multiple_action()
	{
		if (!empty($this->input->post('order_id'))) {
			foreach ($this->input->post('order_id') as $order_id) {
				if ($this->input->post('action') == 'accept') {
					$data = array(
						'order_step' => 'accept',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					// $this->session->set_flashdata('message', '接收訂單');
				} elseif ($this->input->post('action') == 'prepare') {
					$data = array(
						'order_step' => 'prepare',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					// $this->session->set_flashdata('message', '餐點準備中');
				} elseif ($this->input->post('action') == 'shipping') {
					$data = array(
						'order_step' => 'shipping',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					// $this->session->set_flashdata('message', '餐點運送中');
				} elseif ($this->input->post('action') == 'arrive') {
					$data = array(
						'order_step' => 'arrive',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					// $this->session->set_flashdata('message', '司機抵達');
				} elseif ($this->input->post('action') == 'picked') {
					$data = array(
						'order_step' => 'picked',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					// $this->session->set_flashdata('message', '已取餐');
				} elseif ($this->input->post('action') == 'cancel') {
					$data = array(
						'order_step' => 'cancel',
						'order_pay_status' => 'cancel',
						'order_void' => '1',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					//
					$item_data = array(
						'order_item_void' => '1',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('order_item', $item_data);
					$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
					if ($this_order['order_payment'] == 'line_pay' && $this_order['order_pay_status'] == 'paid') {
						$this->line_pay_refund($order_id);
					}
					// $this->session->set_flashdata('message', '取消訂單');
				} elseif ($this->input->post('action') == 'void') {
					$data = array(
						'order_step' => 'void',
						'order_pay_status' => 'return',
						'order_void' => '1',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('orders', $data);
					//
					$item_data = array(
						'order_item_void' => '1',
					);
					$this->db->where('order_id', $order_id);
					$this->db->update('order_item', $item_data);
					$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
					if ($this_order['order_payment'] == 'line_pay' && $this_order['order_pay_status'] == 'paid') {
						$this->line_pay_refund($order_id);
					}
					// $this->session->set_flashdata('message', '已退單');
				} elseif ($this->input->post('action') == 'pdf') {
					redirect(base_url() . 'admin/order/dompdf_download/' . $order_id);
				}
			}
		} else {
			$this->session->set_flashdata('message', '請選擇單據');
		}
		// redirect( base_url() . 'admin/order');
	}

	public function line_pay_refund($order_id)
	{
		$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		if (!empty($this_order['order_pay_feedback'])) {
			// header("Location: ".base_url()."admin/order");

			$channelId = "1605255943"; // 通路ID
			$channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰
			// Get saved config
			// $config = $_SESSION['config'];
			// $config['isSandbox'] = true;
			$config['isSandbox'] = false;
			// Create LINE Pay client
			$linePay = new \yidas\linePay\Client([
				'channelId' => $channelId,
				'channelSecret' => $channelSecret,
				'isSandbox' => ($config['isSandbox']) ? true : false,
			]);
			// Successful page URL
			$successUrl = base_url() . 'admin/order';
			// Get the transactionId from query parameters
			$transactionId = (string) $this_order['order_pay_feedback'];
			// Get the order from session
			// $order = $_SESSION['linePayOrder'];
			// Check transactionId (Optional)
			// if ($order['transactionId'] != $transactionId) {
			//     die("<script>alert('TransactionId doesn\'t match');location.href='".base_url()."';</script>");
			// }
			// API
			try {
				// Online Refund API
				$refundParams = ($this_order['order_discount_total'] != "") ? ['refundAmount' => (int) $this_order['order_discount_total']] : null;
				// $response = $linePay->refund($order['transactionId'], $refundParams);
				$response = $linePay->refund($this_order['order_pay_feedback'], $refundParams);

				// Save error info if confirm fails
				if (!$response->isSuccessful()) {
					die("<script>alert('Refund Failed\\nErrorCode: {$response['returnCode']}\\nErrorMessage: {$response['returnMessage']}');location.href='{$successUrl}';</script>");
				}
				// Use Details API to confirm the transaction and get refund detail info
				$response = $linePay->details([
					// 'transactionId' => [$order['transactionId']],
					'transactionId' => $this_order['order_pay_feedback'],
				]);
				// Check the transaction
				if (!isset($response["info"][0]['refundList']) || $response["info"][0]['transactionId'] != $transactionId) {
					die("<script>alert('Refund Failed');location.href='{$successUrl}';</script>");
				}
			} catch (\yidas\linePay\exception\ConnectException $e) {

				// Implement recheck process
				die("Refund/Details API timeout! A recheck mechanism should be implemented.");
			}
			// Code for saving the successful order into your application database...
			$_SESSION['linePayOrder']['refundList'] = $response["info"][0]['refundList'];
			// Redirect to successful page
			// header("Location: {$successUrl}");

		}
	}

	function order_synchronize($order_id, $action = 'do')
	{
		$api_url = '';
		if ($this->is_td_stuff) {
			$api_url = 'http://erp.vei-star.com';
		}
		if ((strpos(base_url(), 'test01.liqun-food.com') !== false)){
			$api_url = 'http://test-lichun.kuangli.tw';
		}
		if ((strpos(base_url(), 'akai-shop.com') !== false)){
			$api_url = 'http://system.liqun-food.com';
		}

		$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		$array = array(
			'ErrorCode' => '',
			'Errors' => null,
			'Message' => 'ok',
			'IsSuccess' => true,
			'Data' => array(
				'order' => array(),
				'order_item' => array(),
				'product_item' => array(),
			)
		);
		$order = $this_order;
		$order['order_delivery_name'] = get_delivery($this_order['order_delivery']);
		$order['order_payment_name'] = get_payment($this_order['order_payment']);
		$array['Data']['order'] = $order;

		// $this->db->select('order_item.*');
		// $this->db->join('product', 'product.product_id = order_item.product_id');
		$this->db->where('order_id', $this_order['order_id']);
		// $this->db->where('product_id', 0);
		$query = $this->db->get('order_item');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $item) {
				if ($item['product_id'] == 0) {
					$order_item = $item;

					$pc = $this->mysql_model->_select('product_combine', 'id', $item['product_combine_id'], 'row');
					$order_item['product_combine'] = $pc;

					$product = $this->mysql_model->_select('product', 'product_id', $pc['product_id'], 'row');
					$order_item['product_sku'] = $product['product_sku'];
					$order_item['product_name'] = $product['product_name'];
					$order_item['product_price'] = $product['product_price'];

					$pci = $this->mysql_model->_select('product_combine_item', 'product_combine_id', $item['product_combine_id']);
					if (!empty($pci)) {
						foreach ($pci as $qqq) {
							$order_item['product_combine_item'][] = $qqq;
						}
					}

					array_push($array['Data']['order_item'], $order_item);
				}

				// if($item['product_id']>0){
				$order_item = $item;

				$pc = $this->mysql_model->_select('product_combine', 'id', $item['product_combine_id'], 'row');
				$order_item['product_combine'] = $pc;

				$product = $this->mysql_model->_select('product', 'product_id', $pc['product_id'], 'row');
				$order_item['product_sku'] = $product['product_sku'];
				$order_item['product_name'] = $product['product_name'];
				$order_item['product_price'] = $product['product_price'];
				$order_item['specification_name'] = get_product_specification_name($item['specification_id']);

				$order_item['product_unit'] = '';
				$order_item['product_specification'] = '';
				$this->db->where('product_combine_id', $item['product_combine_id']);
				$this->db->where('product_id', $pc['product_id']);
				$query = $this->db->get('product_combine_item');
				if ($query->num_rows() > 0) {
					$row = $query->row_array();
					$order_item['product_unit'] = $row['product_unit'];
					$order_item['product_specification'] = $row['product_specification'];
				};

				array_push($array['Data']['product_item'], $order_item);
				// }
			}
		}

		if ($action == 'read') {
			header('Content-Type: application/json');
			echo json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			exit;
		}

		if ($api_url != '') {
			$make_call = $this->callAPI('POST', $api_url . '/api/vei_star/sales_order/save', json_encode($array));
			$response = json_decode($make_call, true);
			if ($response['IsSuccess'] == true || $response['IsSuccess'] == 1) {
				echo 'send success.';
			} else {
				// echo 'send fail.';
				print_r($response);
			}
		} else {
			echo 'empty api_url';
		}
	}

	function order_update_synchronize($order_id, $action = 'do')
	{
		$api_url = '';
		if ($this->is_td_stuff) {
			$api_url = 'http://erp.vei-star.com';
		}

		$this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
		$array = array(
			'ErrorCode' => '',
			'Errors' => null,
			'Message' => 'ok',
			'IsSuccess' => true,
			'Data' => array(
				'order' => array(),
				'order_item' => array(),
				'product_item' => array(),
			)
		);
		$order = $this_order;
		$order['order_delivery_name'] = get_delivery($this_order['order_delivery']);
		$order['order_payment_name'] = get_payment($this_order['order_payment']);
		$array['Data']['order'] = $order;

		// $this->db->select('order_item.*');
		// $this->db->join('product', 'product.product_id = order_item.product_id');
		$this->db->where('order_id', $this_order['order_id']);
		// $this->db->where('product_id', 0);
		$query = $this->db->get('order_item');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $item) {
				if ($item['product_id'] == 0) {
					$order_item = $item;

					$pc = $this->mysql_model->_select('product_combine', 'id', $item['product_combine_id'], 'row');
					$order_item['product_combine'] = $pc;

					$product = $this->mysql_model->_select('product', 'product_id', $pc['product_id'], 'row');
					$order_item['product_sku'] = $product['product_sku'];
					$order_item['product_name'] = $product['product_name'];
					$order_item['product_price'] = $product['product_price'];

					$pci = $this->mysql_model->_select('product_combine_item', 'product_combine_id', $item['product_combine_id']);
					if (!empty($pci)) {
						foreach ($pci as $qqq) {
							$order_item['product_combine_item'][] = $qqq;
						}
					}

					array_push($array['Data']['order_item'], $order_item);
				}

				// if($item['product_id']>0){
				$order_item = $item;

				$pc = $this->mysql_model->_select('product_combine', 'id', $item['product_combine_id'], 'row');
				$order_item['product_combine'] = $pc;

				$product = $this->mysql_model->_select('product', 'product_id', $pc['product_id'], 'row');
				$order_item['product_sku'] = $product['product_sku'];
				$order_item['product_name'] = $product['product_name'];
				$order_item['product_price'] = $product['product_price'];
				$order_item['specification_name'] = get_product_specification_name($item['specification_id']);

				$order_item['product_unit'] = '';
				$order_item['product_specification'] = '';
				$this->db->where('product_combine_id', $item['product_combine_id']);
				$this->db->where('product_id', $pc['product_id']);
				$query = $this->db->get('product_combine_item');
				if ($query->num_rows() > 0) {
					$row = $query->row_array();
					$order_item['product_unit'] = $row['product_unit'];
					$order_item['product_specification'] = $row['product_specification'];
				};

				array_push($array['Data']['product_item'], $order_item);
				// }
			}
		}

		if ($action == 'read') {
			header('Content-Type: application/json');
			echo json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
			exit;
		}

		if ($api_url != '') {
			$make_call = $this->callAPI('POST', $api_url . '/api/vei_star/sales_order/update', json_encode($array));
			$response = json_decode($make_call, true);
			if ($response['IsSuccess'] == true || $response['IsSuccess'] == 1) {
				echo 'send success.';
			} else {
				// echo 'send fail.';
				print_r($response);
			}
		} else {
			echo 'empty api_url';
		}
	}

	//////////////////////////////////////////

	function getallheaders()
	{
		$headers = array();
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}

	function get_token()
	{
		foreach ($this->getallheaders() as $name => $value) {
			if ($name == 'X-Token') {
				$X_TOKEN = $value;
			}
		}
		if (!empty($X_TOKEN)) {
			return $X_TOKEN;
		} else {
			return false;
		}
	}

	function check_token($X_TOKEN)
	{
		if (empty($X_TOKEN)) {
			$X_ERROR_CODE = '990102';
			$array = array(
				'ErrorCode' => '1',
				'Errors' => ['no token.'],
				'Message' => 'no token.',
				'IsSuccess' => false,
				'Data' => null
			);
			header('Content-Type: application/json');
			header('X_ERROR_CODE: ' . $X_ERROR_CODE);
			echo json_encode($array, JSON_UNESCAPED_UNICODE);
			exit;
		} else {
			$key = 'KUANGLIP';
			// 解密
			$x_token_decrypt = $this->decryptStr($X_TOKEN, $key);
			if ($x_token_decrypt == 'mei-fresh') {
				//
			} else {
				$X_ERROR_CODE = '990102';
				$array = array(
					'ErrorCode' => '1',
					'Errors' => ['token error.'],
					'Message' => 'token error.',
					'IsSuccess' => false,
					'Data' => null
				);
				header('Content-Type: application/json');
				header('X_ERROR_CODE: ' . $X_ERROR_CODE);
				echo json_encode($array, JSON_UNESCAPED_UNICODE);
				exit;
			}
		}
	}

	// 加密
	function encryptStr($str, $key)
	{
		$block = mcrypt_get_block_size('des', 'ecb');
		$pad = $block - (strlen($str) % $block);
		$str .= str_repeat(chr($pad), $pad);
		$enc_str = mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
		return base64_encode($enc_str);
	}

	// 解密
	function decryptStr($str, $key)
	{
		$str = base64_decode($str);
		$str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
		$block = mcrypt_get_block_size('des', 'ecb');
		$pad = ord($str[($len = strlen($str)) - 1]);
		return substr($str, 0, strlen($str) - $pad);
	}

	function callAPI($method, $url, $data)
	{
		// $key = 'KUANGLIP';
		// $X_TOKEN = $this->encryptStr('mei-fresh', $key);

		$curl = curl_init();
		switch ($method) {
			case "GET":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}
		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			// 'X-Token: '.$X_TOKEN,
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		// EXECUTE:
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
}
