<?php defined('BASEPATH') or exit('No direct script access allowed');
class Lottery extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function autoLottery()
	{
		$winner_total = 0;
		$count = 0;
		$lottery_id = 0;
		$ll_query = $this->lottery_model->getLotteryList();
		if (!empty($ll_query)) {
			foreach ($ll_query as $ll_row) {
				$lottery_id = $ll_row['id'];
				echo 'id:' . $ll_row['id'];
				if (strtotime($ll_row["draw_date"]) <= strtotime('now') && $ll_row['draw_over'] == '0') {
					$lpl_query = $this->lottery_model->getLotteryPoolList($ll_row['id']);
					if (!empty($lpl_query)) {
						foreach ($lpl_query as $lpl_row) {
							if ($lpl_row['winner'] == '1') {
								$count++;
							}
						}
						$winner_total = $ll_row['number_limit'] - $count;
						echo 'lottery_id:' . $ll_row['id'] . '  winner_total:' . $winner_total . '  count:' . $count;
					}
				}
			}
		}
		if ($lottery_id > 0) {
			if ($winner_total > 0) {
				$lprl_query = $this->lottery_model->getLotteryPoolRandList($lottery_id, $winner_total);
				if (!empty($lprl_query)) {
					foreach ($lprl_query as $lprl_row) {
						echo "抽獎期數：" . $lprl_row['lottery_id'] . "中獎ID：" . $lprl_row['id'] . "中獎memid：" . $lprl_row['users_id'] . "<br>";
						$this->db->where('id', $lprl_row['id']);
						$this->db->update('lottery_pool', array('winner' => '1'));
					}
				}
			}
			$this->db->where('id', $lottery_id);
			$this->db->update('lottery', array('draw_over' => 1));
		}
	}

	function autoLotterySendMail($id)
	{
		$lottery_pool = $this->mysql_model->_select('lottery_pool', 'id', $id, 'row');
		if (!empty($lottery_pool)) {
			$userDetail = $this->users_model->getUserDetail($lottery_pool['users_id']);
			$ll_row = $this->lottery_model->getLotteryList($lottery_pool['lottery_id'], 1);
			$product_combine = $this->mysql_model->_select('product_combine', 'product_id', $ll_row['product_id'], 'row');
			if (!empty($userDetail) && !empty($ll_row)) {
				$sp_row = $this->product_model->getSingleProduct($ll_row['product_id']);
				if ($ll_row['draw_over'] == '1' && !empty($sp_row)) {
					$datetime = date('Y-m-d H:i:s', strtotime('now'));
					$draw_date_2d = date("Y-m-d H:i:s", strtotime("+2 Day", strtotime($ll_row['draw_date'])));
					// echo $nowtime . '<br>' . $datetime . '<br>' . $draw_date_2d;
					if ($datetime > $draw_date_2d) {
						$draw_date_3d = date("Y年m月d日 H時", strtotime("+2 Day", strtotime($ll_row['fill_up_date'])));
					} else {
						$draw_date_3d = date("Y年m月d日 H時", strtotime("+2 Day", strtotime($ll_row['draw_date'])));
					}

					$subject = '※重要※ 夥伴玩具線上抽選活動-中籤通知！';
					if ($ll_row['email_subject'] != '') {
						$subject = $ll_row['email_subject'];
					}

					// 加载邮件模板文件
					$mail_data = array(
						'subject' => $subject,
						'webname' => get_setting_general('name'),
						'email' => get_setting_general('email'),
						'tel' => get_setting_general('phone1'),
						'cname' => $userDetail['full_name'],
						'lottery_name' => $sp_row['product_name'],
						'lottery_url' => base_url() . 'cart/add_combine?is_lottery=true&lottery_id=' . $lottery_pool['lottery_id'] . '&qty=1&combine_id=' . $product_combine['id'],
						'date_end_pay' => $draw_date_3d
					);
					$body = $this->load->view('lottery/lottery_mail_template', $mail_data, true); // 将视图内容作为字符串返回
					$this->load->library('email');
					// 賣家資料
					$this->email->set_smtp_host(get_setting_general('smtp_host'));
					$this->email->set_smtp_user(get_setting_general('smtp_user'));
					$this->email->set_smtp_pass(get_setting_general('smtp_pass'));
					$this->email->set_smtp_port(get_setting_general('smtp_port'));
					$this->email->set_smtp_crypto(get_setting_general('smtp_crypto'));
					// 買家資料
					$this->email->to($userDetail['email']);
					$this->email->from(get_setting_general('email'), get_setting_general('name'));
					$this->email->subject($subject);
					$this->email->message($body);

					$send_mail = 'OK';
					try {
						if ($this->email->send()) {
							// echo "1";
							$msg_mail = 'mailer_sent';
							$msg = 'success';
							$send_data = array(
								'send_mail' => $send_mail,
								'msg_mail' => $msg_mail,
								'msg' => $msg,
							);
							$this->db->where('id', $lottery_pool['id']);
							$this->db->update('lottery_pool', $send_data);
						} else {
							throw new Exception('unknown error');
						}
					} catch (Exception $e) {
						// echo "0";
						$msg_mail = $e->getMessage();
						$msg = 'error';
						$send_data = array(
							'send_mail' => $send_mail,
							'msg_mail' => $msg_mail,
							'msg' => $msg,
						);
						$this->db->where('id', $lottery_pool['id']);
						$this->db->update('lottery_pool', $send_data);
					}
					if ($ll_row['sms_subject'] != '' && $ll_row['sms_content'] != '' && $userDetail['phone'] != '') {
						$this->load->library('sms');
						$userID = "partnertoys";
						$password = "Ji394cji3104";
						$subject = $ll_row['sms_subject'];
						$content = $ll_row['sms_content'];
						$mobile = $userDetail['phone'];
						$sendTime = '';

						// 傳送簡訊
						if ($this->sms->sendSMS($userID, $password, $subject, $content, $mobile, $sendTime)) {
							// echo "傳送簡訊成功，餘額為：" . $sms->credit . "，此次簡訊批號為：" . $sms->batchID . "<br />\r\n";
						} else {
							// echo "傳送簡訊失敗，" . $sms->processMsg . "<br />\r\n";
						}
					}
				}
			}
		}
	}

	function autoLotteryState()
	{
		$lottery_array = $this->mysql_model->_select('lottery', 'lottery_end', '0');
		foreach ($lottery_array as $row) {
			$nowtime = strtotime('now');
			$id = $row['id'];
			$number_limit = $row['number_limit'];
			$number_remain = $row['number_remain'];
			$filter_black = $row['filter_black'];
			$draw_date = $row["draw_date"];
			$draw_date_2d = strtotime("+2 Day", strtotime($draw_date));
			$fill_up_date = $row["fill_up_date"];
			$fill_up_date_2d = strtotime("+2 Day", strtotime($fill_up_date));

			if (!empty($id)) {
				$winner = $this->lottery_model->getLotteryPoolWinnerCount($id);
				$fill_up = $this->lottery_model->getLotteryPoolFillUpCount($id);
				echo '抽選人數:' . $number_limit . '<br>';
				$number_remain = $number_limit - (count($winner) + count($fill_up));
				echo '剩餘抽選人數:' . $number_remain . '<br>';
				if (!empty($id) && $nowtime > $draw_date_2d && $filter_black == 0) {
					echo '正取更新<br>';
					$this->update_number_remain($id, $number_remain, $filter_black);
					foreach ($winner as $un_winner) {
						if ($un_winner['order_state'] != 'pay_ok') {
							echo $un_winner['users_id'] . ' - <br>';
							$this->update_abandon_abstain($un_winner['id']);
						}
					}
				}
				if (!empty($id) && $nowtime > $fill_up_date_2d && $fill_up_date != '0000-00-00 00:00:00' && $filter_black == 999) {
					echo '遞補更新<br>';
					$this->update_number_remain($id, $number_remain, $filter_black);
					foreach ($fill_up as $un_fill_up) {
						if ($un_fill_up['order_state'] != 'pay_ok') {
							echo $un_fill_up['users_id'] . ' - <br>';
							$this->update_abandon_abstain($un_fill_up['id']);
						}
					}
				}
				$send_mail_array = $this->lottery_model->getNotOKLotterySendMail();
				if (!empty($send_mail_array)) {
					$this->autoLotterySendMail($send_mail_array['id']);
				}
			}
		}
	}

	public function update_abandon_abstain($id)
	{
		$data = array(
			'order_state' => 'un_order',
			'abstain' => '1',
			'abandon' => '1',
		);
		$this->db->where('id', $id);
		$this->db->update('lottery_pool', $data);
	}

	public function update_number_remain($id, $count, $filter_black)
	{
		if ($filter_black == 0) {
			$filter_black = 1;
		} else {
			$filter_black = 100;
		}

		$data = array(
			'number_remain' => $count,
			'filter_black' => $filter_black,
		);
		$this->db->where('id', $id);
		$this->db->update('lottery_pool', $data);
	}

	function get_order_list($member_id, $product_id)
	{
		// $order_list = "select * from order_list where memid='$member_id' ORDER BY odid DESC";
		// $order_result = mysqli_query($this->Dbobj->getdbconnect(), $order_list);
		// if (mysqli_num_rows($order_result) > 0) {
		// 	foreach ($order_result as $order_row) {
		// 		$odid = $order_row['odid'];
		// 		$odno = $order_row['odno'];
		// 		if($order_row['state']=='7' || $order_row['state']=='8' || $order_row['state']=='9' || $order_row['state']=='10'){
		// 			// return false;
		// 		} else {
		// 			if ($order_row['RtnCode'] == '1' || $order_row['pay_state'] == '2') {
		// 				if ($this->get_order_dtl($odid, $product_id) == 'OK') {
		// 					return [$odid, $odno, 'OK'];
		// 				}
		// 			}
		// 		}
		// 	}
		// }
		// return false;
	}

	function get_order_dtl($odid, $product_id)
	{
		// $order_dtl = "select dtlid from order_dtl where odid='$odid' && prdid='$product_id' limit 1";
		// $order_dtl_result = mysqli_query($this->Dbobj->getdbconnect(), $order_dtl);
		// if (mysqli_num_rows($order_dtl_result) > 0) {
		// 	return 'OK';
		// } else {
		// 	return false
		// }
	}
}
