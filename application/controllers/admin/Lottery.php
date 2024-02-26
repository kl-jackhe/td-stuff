<?php defined('BASEPATH') or exit('No direct script access allowed');
class Lottery extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lottery_model');
    }

    function index()
    {
        $this->data['page_title'] = '抽選管理';
        $this->render('admin/lottery/index');
    }

    function ajaxData()
    {
        $conditions = array();
        $page = $this->input->get('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $keywords = $this->input->get('keywords');
        // $sortBy = $this->input->get('sortBy');
        // $category = $this->input->get('category');
        // $status = $this->input->get('status');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        // if(!empty($sortBy)){
        //     $conditions['search']['sortBy'] = $sortBy;
        // }
        // if(!empty($category)){
        //     $conditions['search']['category'] = $category;
        // }
        // if(!empty($status)){
        //     $conditions['search']['status'] = $status;
        // }
        $totalRec = (!empty($this->lottery_model->getRows($conditions)) ? count($this->lottery_model->getRows($conditions)) : 0);
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/lottery/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $this->data['lottery'] = $this->lottery_model->getRows($conditions);
        $this->load->view('admin/lottery/ajax-data', $this->data, false);
    }

    function create()
    {
        $this->data['page_title'] = '建立抽選活動';
        $this->data['product'] = $this->mysql_model->_select('product', 'product_category_id', '6');
        $this->render('admin/lottery/create');
    }

    function addLotteryEvent()
    {
        $insertData = array(
            'name' => $this->input->post('name'),
            'email_subject' => $this->input->post('email_subject'),
            'email_content' => $this->input->post('email_content'),
            'sms_subject' => $this->input->post('sms_subject'),
            'sms_content' => $this->input->post('sms_content'),
            'product_id' => $this->input->post('product'),
            'number_limit' => $this->input->post('number_limit'),
            'star_time' => $this->input->post('star_time'),
            'end_time' => $this->input->post('end_time'),
            'draw_date' => $this->input->post('draw_date'),
            'fill_up_date' => '0000-00-00 00:00:00',
        );
        $this->db->insert('lottery', $insertData);
        $id = $this->db->insert_id();
        redirect('admin/lottery/edit/' . $id);
    }

    function edit($id)
    {
        $this->data['page_title'] = '編輯抽選活動';
        $this->data['lottery'] = $this->mysql_model->_select('lottery', 'id', $id, 'row');
        $this->data['lottery_pool'] = $this->mysql_model->_select('lottery_pool', 'lottery_id', $id);
        $this->data['product'] = $this->mysql_model->_select('product', 'product_category_id', '6');
        $this->data['draw_date_3d'] = strtotime("+2 Day", strtotime($this->data['lottery']['draw_date']));
        $this->data['draw_date_3d_end'] = date("Y-m-d  H:i:s", strtotime("+2 day", strtotime($this->data['lottery']['draw_date'])));
        $this->data['fill_up_date_3d'] = strtotime("+2 Day", strtotime($this->data['lottery']['fill_up_date']));
        $this->data['fill_up_date_3d_end'] = date("Y-m-d  H:i:s", strtotime("+2 day", strtotime($this->data['lottery']['fill_up_date'])));
        $this->data['nowtime'] = strtotime('now');
        $this->render('admin/lottery/edit');
    }

    function editLotteryEvent($id)
    {
        $update_data = array(
            'name' => $this->input->post('name'),
            'email_subject' => $this->input->post('email_subject'),
            'email_content' => $this->input->post('email_content'),
            'sms_subject' => $this->input->post('sms_subject'),
            'sms_content' => $this->input->post('sms_content'),
            'product_id' => $this->input->post('product'),
            'number_limit' => $this->input->post('number_limit'),
            'number_remain' => $this->input->post('number_remain'),
            'star_time' => $this->input->post('star_time'),
            'end_time' => $this->input->post('end_time'),
            'draw_date' => $this->input->post('draw_date'),
            'fill_up_date' => $this->input->post('fill_up_date'),
        );
        $this->db->where('id', $id);
        $this->db->update('lottery', $update_data);
        $this->session->set_flashdata('更新成功');
        redirect('admin/lottery/edit/' . $id);
    }

    function deleteLotteryEvent()
    {
        $id = $_GET['id'];
        $query_find = "select * from lottery where id='$id'";
        $result2 = mysqli_query($dblink, $query_find);
        if (mysqli_num_rows($result2) > 0) {
            $query = "delete from lottery where id='$id'";
            mysqli_query($dblink, $query) || die("Can't delete lottery info. Reason: " . mysqli_error($dblink));
        }
        $query_find = "select * from lottery_pool where lottery_id='$id'";
        $result2 = mysqli_query($dblink, $query_find);
        if (mysqli_num_rows($result2) > 0) {
            $query = "delete from lottery_pool where lottery_id=$id";
            mysqli_query($dblink, $query) || die("Can't delete lottery info. Reason: " . mysqli_error($dblink));
        }
    }

    // 指定抽選
    function specify_lottery($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $lotter_pool = $this->db->get('lottery_pool')->row_array();
        $lottery_id = $lotter_pool['lottery_id'];
        $this->db->where('id', $lottery_id);
        $lottery = $this->db->get('lottery')->row_array();

        if ($lottery['draw_over'] == 0 && $lottery['number_limit'] > 0) {
            $this->db->where('id', $id);
            $this->db->update('lottery_pool', ['winner' => '1']);
        } else if ($lottery['draw_over'] == 1 && $lottery['number_remain'] > 0) {
            $this->db->where('id', $id);
            $this->db->update('lottery_pool', ['fill_up' => '1']);
        } else {
            echo "
            <script>
                alert('已沒有名額可以進行抽選！');
                location='/admin/lottery/edit/" . $lottery_id . "';
            </script>";
        }

        echo "
        <script>
            alert('預定選中完成');
            location='/admin/lottery/edit/" . $lottery_id . "';
        </script>";
    }

    // 開始抽選
    function reservationWiner($lottery_id)
    {
        $this->db->where('id', $lottery_id);
        $lottery = $this->db->get('lottery')->row_array();
        if (!empty($lottery)) :
            $count = 0;
            $draw_over = $lottery['draw_over'];
            $number_limit = $lottery['number_limit'];
            $number_remain = $lottery['number_remain'];
        endif;

        if ($draw_over == 0) {
            // 正取
            $this->db->where('lottery_id', $lottery_id);
            $this->db->where('winner', '0');
            $this->db->where('fill_up', '0');
            $lottery_pool = $this->db->get('lottery_pool')->result_array();

            if (!empty($lottery_pool)) {
                $update_data = array(
                    'draw_over' => '1',
                );
                $this->db->where('id', $lottery_id);
                $this->db->update('lottery', $update_data);

                // 随机抽取指定数量的结果
                shuffle($lottery_pool); // 将结果集打乱顺序
                $selected_lottery_pool = array_slice($lottery_pool, 0, $number_limit); // 从打乱后的数组中取出指定数量的元素

                foreach ($selected_lottery_pool as $row) {
                    if ($row['winner'] == '0' && $row['fill_up'] == '0' && $row['abandon'] == '0' && $row['blacklist'] == '0') {
                        $this->db->where('id', $row['id']);
                        $this->db->update('lottery_pool', ['winner' => '1']);
                        $this->autoLotterySendMail($row['id']);
                        $count++;
                    }
                }

                echo "
                <script>
                    alert('正取成功抽選" . $count . "人');
                    location='/admin/lottery/edit/" . $lottery_id . "';
                </script>";
            } else {
                echo "
                <script>
                    alert('無人報名');
                    location='/admin/lottery/edit/" . $lottery_id . "';
                </script>";
            }
        } else {
            // 備取遞補
            if ($number_remain > 0) {
                // 備取
                $this->db->where('lottery_id', $lottery_id);
                $this->db->where('winner', '0');
                $this->db->where('fill_up', '0');
                $lottery_pool = $this->db->get('lottery_pool')->result_array();

                if (!empty($lottery_pool)) {
                    // 随机抽取指定数量的结果
                    shuffle($lottery_pool); // 将结果集打乱顺序
                    $selected_lottery_pool = array_slice($lottery_pool, 0, $number_remain); // 从打乱后的数组中取出指定数量的元素

                    foreach ($selected_lottery_pool as $row) {
                        if ($row['winner'] == '0' && $row['fill_up'] == '0' && $row['abandon'] == '0' && $row['blacklist'] == '0') {
                            $this->db->where('id', $row['id']);
                            $this->db->update('lottery_pool', ['fill_up' => '1']);
                            $this->autoLotterySendMail($row['id']);
                            $count++;
                        }
                    }

                    echo "
                    <script>
                        alert('備取成功抽選" . $count . "人');
                        location='/admin/lottery/edit/" . $lottery_id . "';
                    </script>";
                } else {
                    echo "
                    <script>
                        alert('報名名額不足');
                        location='/admin/lottery/edit/" . $lottery_id . "';
                    </script>";
                }
            } else {
                echo "
                <script>
                    alert('已沒有名額可以進行抽選！');
                    location='/admin/lottery/edit/" . $lottery_id . "';
                </script>";
            }
        }
        // redirect('admin/lottery/edit/' . $lottery_id);
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

    // 結束抽選
    function finishLotteryEvent($id)
    {
        $this->db->where('id', $id);
        $this->db->update('lottery', ['lottery_end' => '1']);
        $this->session->set_flashdata('已結束此期抽選');
        redirect('admin/lottery/edit/' . $id);
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
                    // if ($ll_row['sms_subject'] != '' && $ll_row['sms_content'] != '' && $userDetail['phone'] != '') {
                    //     $this->load->library('sms');
                    //     $userID = "partnertoys";
                    //     $password = "Ji394cji3104";
                    //     $subject = $ll_row['sms_subject'];
                    //     $content = $ll_row['sms_content'];
                    //     $mobile = $userDetail['phone'];
                    //     $sendTime = '';

                    //     // 傳送簡訊
                    //     if ($this->sms->sendSMS($userID, $password, $subject, $content, $mobile, $sendTime)) {
                    //         // echo "傳送簡訊成功，餘額為：" . $sms->credit . "，此次簡訊批號為：" . $sms->batchID . "<br />\r\n";
                    //     } else {
                    //         // echo "傳送簡訊失敗，" . $sms->processMsg . "<br />\r\n";
                    //     }
                    // }
                }
            }
        }
    }


    function addMemberBlackList()
    {
        $lottery_id = $_GET['id'];
        $count = 0;
        $query = "select * from lottery_pool where lottery_id='$lottery_id' && order_state!='pay_ok' && abandon=1 && blacklist=0";
        $result = mysqli_query($dblink, $query);
        if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_array($result)) {
                $count++;
                $id = $row['id'];
                $member_id = $row['member_id'];
                echo $count . ' - ' . $row['member_id'] . '<br>';
                $query = "update lottery_pool set ";
                $query .= "blacklist='1'"; //1黑名單
                $query .= " where id=$id";
                mysqli_query($dblink, $query) || die("Can't insert lottery_pool info. Reason: " . mysqli_error($dblink));
                $query = "update member set ";
                $query .= "black_tag='1'"; //1標記黑名單
                $query .= " where memid=$member_id";
                mysqli_query($dblink, $query) || die("Can't insert member info. Reason: " . mysqli_error($dblink));
            }
        endif;
        $query = "update lottery set ";
        $query .= "state='end'";
        $query .= " where id=$lottery_id";
        mysqli_query($dblink, $query) || die("Can't update lottery info. Reason: " . mysqli_error($dblink));
    }

    function deleteMemberBlackList()
    {
        $id = $_GET['id'];
        $member_id = $_GET['member_id'];
        $query = "select * from lottery_pool INNER JOIN member on lottery_pool.member_id = member.memid where lottery_id=$id && memid=$member_id group by memid";
        $result = mysqli_query($dblink, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $query = "update lottery_pool set ";
                $query .= "blacklist='0'";
                $query .= " where member_id=$member_id";
                mysqli_query($dblink, $query) || die("Can't update lottery_pool info. Reason: " . mysqli_error($dblink));
                $query = "update member set ";
                $query .= "black_tag='0'";
                $query .= " where memid=$member_id";
                mysqli_query($dblink, $query) || die("Can't update member info. Reason: " . mysqli_error($dblink));
            }
        }
    }
}
