<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lottery extends Admin_Controller {
    function __construct() {
        parent::__construct();
        
    }

    function autoLottery() {
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

    function autoLotterySendMail() {
    	$lpsml_query = $this->lottery_model->getLotteryPoolSendMailList();
    	if (!empty($lpsml_query)) {
    		foreach ($lpsml_query as $lpsml_row) {
    			$userDetail = $this->users_model->getUserDetail($lpsml_row['users_id']);
    			$ll_row = $this->lottery_model->getLotteryList($lpsml_row['lottery_id'], 1);
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
						$lottery_url = $_SERVER['SERVER_NAME'] . '/product/addLotteryProductToCart/' . $sp_row['product_id'];

						$subject = '※重要※ 夥伴玩具線上抽選活動-中籤通知！';
						if($ll_row['email_subject'] != ''){
							$subject = $ll_row['email_subject'];
						}
						$fileData = file_get_contents("/lottery/lottery_mail_template.php");
						$fileData = str_replace("{{subject}}", $subject, $fileData);
						// $fileData = str_replace("{{cpname}}", $_SESSION['sec_miya_cpname'], $fileData);
						$fileData = str_replace("{{webname}}", get_setting_general('name'), $fileData);
						$fileData = str_replace("{{email}}", get_setting_general('email'), $fileData);
						$fileData = str_replace("{{tel}}", get_setting_general('phone1'), $fileData);
						// ==================================================================================
						$fileData = str_replace("{{cname}}", $userDetail['full_name'], $fileData);
						$fileData = str_replace("{{lottery_name}}", $sp_row['product_name'], $fileData);
						$fileData = str_replace("{{lottery_url}}", $lottery_url, $fileData);
						$fileData = str_replace("{{date_end_pay}}", $draw_date_3d, $fileData);
						$body = $fileData;
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
						// echo $content;
						if ($this->email->send()) {
							echo "1";
							$this->db->where('id', $lpsml_row['id']);
							$this->db->update('lottery_pool', array('send_mail' => 'OK', 'msg_mail' => $msg_mail, 'msg' => $msg));
						} else {
							echo "0";
						}

						if ($ll_row['sms_subject'] != '' && $ll_row['sms_content'] != '' && $userDetail['phone'] != '') {
							$this->load->library('SMS');
							$userID = "partnertoys";
							$password = "Ji394cji3104";
							$subject = $ll_row['sms_subject'];
							$content = $ll_row['sms_content'];
							$mobile = $userDetail['phone'];
							// 傳送簡訊
							if($this->SMS->sendSMS($userID, $password, $subject, $content, $mobile, $sendTime)){
								// echo "傳送簡訊成功，餘額為：" . $sms->credit . "，此次簡訊批號為：" . $sms->batchID . "<br />\r\n";
							} else {
								// echo "傳送簡訊失敗，" . $sms->processMsg . "<br />\r\n";
							}
						}
					}
				}
    		}
    	}
    }

    function runLotteryState() {
    	$ldl_query = $this->lottery_model->getLotteryDrawList();
    	if (!empty($ldl_query)) {
    		foreach ($ldl_query as $ldl_row) {
				$nowtime = strtotime('now');
				$time = date('Y-m-d H:i:s', ($nowtime));
				$id = $ldl_row['id'];
				$number_limit = $ldl_row['number_limit'];
				$number_remain = $ldl_row['number_remain'];
				$filter_black = $ldl_row['filter_black'];
				$state = $ldl_row["state"];
				$product_id = $ldl_row["product_id"];
				$draw_date = $ldl_row["draw_date"];
				$draw_date_2d = strtotime("+2 Day", strtotime($draw_date));
				$fill_up_date = $ldl_row["fill_up_date"];
				$fill_up_date_2d = strtotime("+2 Day", strtotime($fill_up_date));
				echo '<br>抽選項次：' . $ldl_row['id'] . ' 抽選商品：' . $product_id . '<br>';
				$count = 0;
				echo '<br>=================正取=================<br>';
				$lpl_query = $this->lottery_model->getLotteryPoolList($id, 'winner');
				if (!empty($lpl_query)) {
					foreach ($lpl_query as $lpl_row) {
						[$odid, $odno, $OK] = $main->get_order_list($winner["member_id"], $product_id);
						if ($OK == 'OK') {
							$count++;
							echo "訂單編號：" . $odid . " - " . "流水號：" . $odno . " - " . $count . " 付款完成-會員ID：" . $winner["member_id"] . "＊＊" . " 商品ID：" . "$product_id" . " - OK" . "<br>";
							$this->db->where('id', $winner["id"]);
    						$this->db->update('lottery_pool', array('order_state' => 'pay_ok', 'order_number' => $odno));
						} else {
							$this->db->where('id', $winner["id"]);
    						$this->db->update('lottery_pool', array('order_state' => '', 'order_number' => ''));
						}
					}
				}
				echo '=================遞補=================<br>';
				$lpl_query = $this->lottery_model->getLotteryPoolList($id, 'fill_up');
				if (!empty($lpl_query)) {
					foreach ($lpl_query as $lpl_row) {
						[$odid, $odno, $OK] = $main->get_order_list($winner["member_id"], $product_id);
						if ($OK == 'OK') {
							$count++;
							echo "訂單編號：" . $odid . " - " . "流水號：" . $odno . " - " . $count . " 付款完成-會員ID：" . $winner["member_id"] . "＊＊" . " 商品ID：" . "$product_id" . " - OK" . "<br>";
							$this->db->where('id', $winner["id"]);
    						$this->db->update('lottery_pool', array('order_state' => 'pay_ok', 'order_number' => $odno));
						} else {
							$this->db->where('id', $winner["id"]);
    						$this->db->update('lottery_pool', array('order_state' => '', 'order_number' => ''));
						}
					}
				}
				echo '抽選人數:' . $number_limit . '<br>';
				$number_remain = $number_limit - $count;
				echo '剩餘抽選人數:' . $number_remain . '<br>';
				if (!empty($id) && $nowtime > $draw_date_2d && $filter_black == 0) {
					echo '正取更新<br>';
					if ($filter_black == 0) {
						$filter_black = 1;
					} else {
						$filter_black = 100;
					}
					$this->db->where('id', $id);
					$this->db->update('lottery', array('number_remain' => $number_remain,'filter_black' => $filter_black));
					$lpl_query = $this->lottery_model->getLotteryPoolList($id, 'winner');
					if (!empty($lpl_query)) {
						foreach ($lpl_query as $lpl_row) {
							if ($lpl_row['order_state'] != 'pay_ok') {
								echo $lpl_row['member_id'] . ' - <br>';
								$this->db->where('id', $lpl_row['id']);
	    						$this->db->update('lottery_pool', array('order_state' => 'un_order', 'abstain' => '1', 'abandon' => '1'));
							}
						}
					}
				}
				if (!empty($id) && $nowtime > $fill_up_date_2d && $fill_up_date != '0000-00-00 00:00:00' && $filter_black == 999) {
					echo '遞補更新<br>';
					if ($filter_black == 0) {
						$filter_black = 1;
					} else {
						$filter_black = 100;
					}
					$this->db->where('id', $id);
					$this->db->update('lottery', array('number_remain' => $number_remain,'filter_black' => $filter_black));
					$lpl_query = $this->lottery_model->getLotteryPoolList($id, 'fill_up');
					if (!empty($lpl_query)) {
						foreach ($lpl_query as $lpl_row) {
							if ($lpl_row['order_state'] != 'pay_ok') {
								echo $lpl_row['member_id'] . ' - <br>';
								$this->db->where('id', $lpl_row['id']);
	    						$this->db->update('lottery_pool', array('order_state' => 'un_order', 'abstain' => '1', 'abandon' => '1'));
							}
						}
					}
				}
			}
    	}
    }

	function get_order_list($member_id, $product_id) {
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

	function get_order_dtl($odid, $product_id) {
		// $order_dtl = "select dtlid from order_dtl where odid='$odid' && prdid='$product_id' limit 1";
		// $order_dtl_result = mysqli_query($this->Dbobj->getdbconnect(), $order_dtl);
		// if (mysqli_num_rows($order_dtl_result) > 0) {
		// 	return 'OK';
		// } else {
		// 	return false
		// }
	}
}