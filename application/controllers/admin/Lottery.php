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

    // 結束抽選
    function finishLotteryEvent($id)
    {
        $this->db->where('id', $id);
        $this->db->update('lottery', ['lottery_end' => '1']);
        $this->session->set_flashdata('已結束此期抽選');
        redirect('admin/lottery/edit/' . $id);
    }

    // 開始抽選
    function reservationWiner()
    {
        $id = $_GET['id'];
        $memid = $_GET['memid'];
        $query = "select * from lottery where id='$id'";
        $result = mysqli_query($dblink, $query);
        if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_array($result)) {
                $draw_over = $row['draw_over'];
                $number_remain = $row['number_remain'];
            }
        endif;
        if ($draw_over == 0) {
            // 正取
            $query = "select * from lottery_pool where lottery_id='$id' && id='$memid'";
            $result = mysqli_query($dblink, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['winner'] == '0' && $row['fill_up'] == '0' && $row['abandon'] == '0' && $row['blacklist'] == '0') {
                        $query = "update lottery_pool set ";
                        $query .= "winner='1'";
                        $query .= " where id=$memid";
                        mysqli_query($dblink, $query) || die("Can't update lottery_pool info. Reason: " . mysqli_error($dblink));
                        break;
                    }
                }
            }
        } else {
            // 備取遞補
            if ($number_remain > 0) {
                $query = "select * from lottery_pool where lottery_id='$id' && id='$memid'";
                $result = mysqli_query($dblink, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['winner'] == '0' && $row['fill_up'] == '0' && $row['abandon'] == '0' && $row['blacklist'] == '0') {
                            $query = "update lottery_pool set ";
                            $query .= "fill_up='1'";
                            $query .= " where id=$memid";
                            mysqli_query($dblink, $query) || die("Can't update lottery_pool info. Reason: " . mysqli_error($dblink));
                            $number_remain = $number_remain - 1;
                            $query = "update lottery set ";
                            $query .= "number_remain='$number_remain'"; //釋出名額數
                            $query .= " where id=$id";
                            mysqli_query($dblink, $query) || die("Can't insert lottery info. Reason: " . mysqli_error($dblink));
                            break;
                        }
                    }
                }
            } else {
                echo "<script>location='lottery_table.php?tree=6&act=mdy&id=$id';alert('沒有名額可以進行遞補抽選！');</script>";
                exit;
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

    // 指定抽選
    function specify_lottery($id)
    {
        $this->db->where('id', $id);
        $this->db->update('lottery_pool', ['winner' => '1']);
        $this->session->set_flashdata('預定選中完成');
        
        echo '<script>window.history.back();</script>';
    }
}
