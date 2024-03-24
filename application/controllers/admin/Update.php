<?php defined('BASEPATH') or exit('No direct script access allowed');

class Update extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index($version = '202308231510')
    {
        if ($version != '') {
            $this->version = $version;
            echo '
            <html><head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"></head>';
            echo '<body>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h4>自動更新程序</h4>
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="border: 1px solid gray; padding: 15px;">';
            $query = $this->db->query("SHOW TABLES LIKE 'update_log'");
            if ($query->num_rows() > 0) {
                // 已經存在
                $this->update_202308161240();
                $this->update_202308161230();
                $this->update_202308191205();
                $this->update_202308201555();
                $this->update_202308212140();
                $this->update_202308212210();
                $this->update_202308231510();
                $this->update_202308301910();
                $this->update_202309051540();
                $this->update_202309051755();
                $this->update_202309061300();
                $this->update_202309061750();
                $this->update_202309071240();
                $this->update_202309121800();
                $this->update_202309191500();
                $this->update_202310251330();
                $this->update_202310251800();
                $this->update_202310311530();
                $this->update_202311081430();
                $this->update_202311211630();
                $this->update_202312051900();
                $this->update_202312062000();
                $this->update_202312121540();
                $this->update_202312121541();
                $this->update_202312122310();
                $this->update_202312122315();
                $this->update_202312122325();
                $this->update_202312131400();
                $this->update_202312132220();
                $this->update_202312142100();
                $this->update_202312151515();
                $this->update_202312151520();
                $this->update_202312151530();
                $this->update_202312151535();
                $this->update_202312161325();
                $this->update_202312181700();
                $this->update_202312181730();
                $this->update_202312171935();
                $this->update_202312201430();
                $this->update_202312211000();
                $this->update_202312231600();
                $this->update_202312231630();
                $this->update_202312271600();
                $this->update_202312271800();
                $this->update_202312291830();
                $this->update_202312311830();
                $this->update_202401012000();
                $this->update_202401081530();
                $this->update_202401111630();
                $this->update_202401121730();
                $this->update_202401122200();
                $this->update_202401151500();
                $this->update_202401151900();
                $this->update_202401172030();
                $this->update_202401181930();
                $this->update_202401182000();
                $this->update_202401191900();
                $this->update_202401231430();
                $this->update_202401262230();
                $this->update_202401260000();
                $this->update_202401291410();
                $this->update_202401291600();
                $this->update_202402021730();
                $this->update_202402141400();
                $this->update_202402200216();
                $this->update_202402220300();
                $this->update_202402281618();
                $this->update_202402291446();
                $this->update_202402292254();
                $this->update_202403011721();
                $this->update_202403051007();
                $this->update_202403051354();
                $this->update_202403131212();
                $this->update_202403131156();
                $this->update_202403201604();
                $this->update_202403211521();
                $this->update_202403241905();
                if ($this->is_partnertoys) {
                    // $this->import_post_sql();
                    // $this->import_product_old_sql();
                    // $this->import_member_sql();
                    // $this->create_product_combine();
                    // $this->upload_orders();
                    // $this->upload_orders_item();
                    // $this->upload_lottery();
                    // $this->upload_lottery_pool();
                    // $this->upload_product_img();
                    // $this->upload_guestbook();
                }
            } else {
                // 不存在
                $this->update_202308161130();
            }
            '</div>
                </div>
            </div>';
            echo '<hr>';
            echo '<a href="/admin" class="btn btn-primary">回到控制台</a>';
            echo '</body></html>';
        }
    }

    function upload_guestbook()
    {
        $version = 'upload_guestbook';
        $description = 'transition upload_guestbook data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {

            $this->db->select('*');
            $query = $this->db->get('guestbook_old')->result_array();

            foreach ($query as $row) {

                // Create an associative array with field names as keys
                $data = array(
                    'id' => $row['guestid'],
                    'order_id' => $row['odid'],
                    'user_id' => $row['memid'],
                    'content' => $row['content'],
                    'response_status' => 1,
                    'created_at' => $row['datetime'],
                );

                // echo '<pre>';
                // echo 'data : ';
                // print_r($data);
                // echo '</pre>';

                // Insert row data into the database
                $this->db->insert('guestbook', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function upload_product_img()
    {
        $version = 'upload_product_img';
        $description = 'transition upload_product_img data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {

            $this->db->select('*');
            $query = $this->db->get('prd_picture');
            $images = $query->result_array();

            foreach ($images as $row) {

                // Create an associative array with field names as keys
                $data = array(
                    'id' => $row['picid'],
                    'product_id' => $row['prdid'],
                    'picture' => 'Product/show/55/' . $row['filename'],
                    'sort' => ($row['sort'] == null) ? '' : $row['sort'],
                );

                // echo '<pre>';
                // echo 'data : ';
                // print_r($data);
                // echo '</pre>';

                // Insert row data into the database
                $this->db->insert('product_img', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function upload_lottery_pool()
    {
        $version = 'upload_lottery_pool';
        $description = 'transition lottery_pool_anti data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {

            $this->db->select('*');
            $query = $this->db->get('lottery_pool_anti');
            $lottery_pool = $query->result_array();

            foreach ($lottery_pool as $row) {

                // Create an associative array with field names as keys
                $data = array(
                    'id' => $row['id'],
                    'lottery_id' => $row['lottery_id'],
                    'users_id' => $row['member_id'],
                    'send_mail' => $row['send_mail'],
                    'abstain' => $row['abstain'],
                    'winner' => $row['winner'],
                    'alternate' => $row['alternate'],
                    'fill_up' => $row['fill_up'],
                    'blacklist' => $row['blacklist'],
                    'abandon' => $row['abandon'],
                    'order_state' => $row['order_state'],
                    // 'order_id' => $row['order_odno'],
                    'order_number' => $row['order_odno'],
                    'msg_mail' => $row['msg_mail'],
                    'msg' => $row['msg'],
                    'create_time' => $row['create_time'],
                );

                // echo '<pre>';
                // echo 'data : ';
                // print_r($data);
                // echo '</pre>';

                // Insert row data into the database
                $this->db->insert('lottery_pool', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function upload_lottery()
    {
        $version = 'upload_lottery';
        $description = 'transition lottery_anti data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {

            $this->db->select('*');
            $query = $this->db->get('lottery_anti');
            $lottery = $query->result_array();

            foreach ($lottery as $row) {

                // Create an associative array with field names as keys
                $data = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'email_subject' => $row['email_subject'],
                    'email_content' => $row['email_content'],
                    'sms_subject' => $row['sms_subject'],
                    'sms_content' => $row['sms_content'],
                    'product_id' => $row['product_id'],
                    'number_limit' => $row['number_limit'],
                    'number_remain' => $row['number_remain'],
                    'number_alternate' => $row['number_alternate'],
                    'star_time' => $row['star_time'],
                    'end_time' => $row['end_time'],
                    'draw_date' => $row['draw_date'],
                    'fill_up_date' => $row['fill_up_date'],
                    'draw_over' => $row['draw_over'],
                    'fill_up_over' => $row['fill_up_over'],
                    'filter_black' => $row['filter_black'],
                    'state' => $row['state'],
                    'lottery_end' => $row['lottery_end'],
                    'create_time' => $row['create_time'],
                );

                // echo '<pre>';
                // echo 'data : ';
                // print_r($data);
                // echo '</pre>';

                // Insert row data into the database
                $this->db->insert('lottery', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function upload_orders_item()
    {
        $version = 'upload_orders_item';
        $description = 'transition order_item data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {

            $this->db->select('*');
            $query = $this->db->get('order_dtl');
            $order_dtl = $query->result_array();

            foreach ($order_dtl as $row) {

                $self_orders = $this->mysql_model->_select('orders', 'order_id', $row['odid'], 'row');
                $product_id = $row['prdid'];
                $self_product_combine = $this->mysql_model->_select('product_combine', 'product_id', $product_id, 'row');
                if (empty($self_product_combine)) {
                    continue;
                }
                if (empty($self_orders)) {
                    continue;
                }
                // $this->db->where('order_item_id', $row['dtlid']);
                // $tmp_query = $this->db->get('order_item');
                // if (!empty($tmp_query)) {
                //     continue;
                // }

                // if (is_array($row)) {
                //     foreach ($row as $key => $value) {
                //         // 检查 $value 是否为 null，如果是，则替换为空字符串
                //         if ($value === null) {
                //             $row[$key] = '';
                //         }
                //     }
                // }

                // Create an associative array with field names as keys
                $data = array(
                    'order_item_id' => $row['dtlid'],
                    'order_id' => $row['odid'],
                    'product_combine_id' => $self_product_combine['id'],
                    'product_combine_name' => $row['pdname'],
                    'customer_id' => $self_orders['customer_id'],
                    'product_id' => $self_product_combine['product_id'],
                    'product_name' => $row['pname'],
                    'order_item_qty' => $row['num'],
                    'order_item_price' => $row['price'],
                    'created_at' => $self_orders['created_at'],
                );

                // echo '<pre>';
                // echo 'data : ';
                // print_r($data);
                // echo '</pre>';

                // Insert row data into the database
                $this->db->insert('order_item', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function upload_orders()
    {
        $version = 'upload_orders';
        $description = 'transition orders data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $this->db->select('*');
            $query = $this->db->get('order_list');
            $order_list = $query->result_array();

            $this->db->select('*');
            $query = $this->db->get('order_cvs');
            $order_cvs = $query->result_array();

            foreach ($order_list as $row) {
                $new_date = date('Y-m-d', strtotime($row['oddate'])); // 將日期轉換為 Y-m-d 格式

                $order_delivery_transfer = array(
                    '0' => 'ktj_main_delivery',
                    '1' => 'ktj_main_delivery',
                    '3' => '711_pickup',
                    '4' => 'family_pickup',
                    '6' => 'ktj_main_delivery',
                    '8' => 'sf_mc_express_delivery',
                    '12' => 'ktj_main_delivery',
                    '13' => 'ktj_sub_delivery',
                    '14' => 'free_delivery',
                    '15' => 'free_delivery',
                    '16' => 'free_delivery',
                    '17' => 'sf_hk_express_delivery',
                    '18' => 'sf_cn_express_delivery',
                    '19' => 'sf_others_express_delivery',
                );
                $order_delivery = $order_delivery_transfer[$row['shipid']];

                $order_payment = ($row['kindid'] == 1 || $row['kindid'] == 23 || $row['kindid'] == 24) ? 'ecpay_ATM' : (($row['kindid'] == 2 || $row['kindid'] == 22) ? 'ecpay_credit' : 'ecpay_CVS');

                $this_order_status = array(
                    '1' => 'confirm',
                    '2' => 'preparation',
                    '5' => 'shipping',
                    '7' => 'return_complete',
                    '8' => 'order_cancel',
                    '9' => 'complete',
                    '10' => 'return_complete',
                );

                $this_order_pay_status = array(
                    '1' => 'not_paid',
                    '2' => 'paid',
                    '3' => 'return',
                );

                if (is_array($row)) {
                    foreach ($row as $key => $value) {
                        // 检查 $value 是否为 null，如果是，则替换为空字符串
                        if ($value === null) {
                            $row[$key] = '';
                        }
                    }
                }

                // $this->db->where('order_id', $row['odid']);
                // $tmp_query = $this->db->get('orders');
                // if (!empty($tmp_query)) {
                //     continue;
                // }

                // Create an associative array with field names as keys
                $data = array(
                    'order_id' => $row['odid'],
                    'order_number' => $row['odno'],
                    'order_date' => $new_date,
                    'customer_id' => $row['memid'],
                    'customer_name' => $row['username1'],
                    'customer_phone' => $row['mobile1'],
                    'customer_email' => $row['email1'],
                    'order_total' => (int)$row['price'] + (int)$row['cost'],
                    'order_discount_total' => (int)$row['price'] + (int)$row['cost'],
                    // 'order_discount_price' => $row['price'],
                    'order_delivery_cost' => $row['cost'],
                    // 'order_delivery_place' => $row['order_delivery_place'],
                    'order_delivery_address' => ($row['code1'] . $row['addr1']),
                    // 'order_delivery_time' => $row['order_delivery_time'],
                    // 'store_id' => $row['store_id'],
                    // 'order_store_name' => $row['order_store_name'],
                    // 'order_store_address' => $row['order_store_address'],
                    'order_delivery' => $order_delivery,
                    'order_payment' => $order_payment,
                    'InvoiceNumber' => ($row['invoid'] != null) ? $row['invoid'] : '',
                    // 'SelfLogistics' => $row['SelfLogistics'],
                    // 'AllPayLogisticsID' => $row['AllPayLogisticsID'],
                    'CVSPaymentNo' => $row['send_no'],
                    'order_step' => !empty($this_order_status[$row['state']]) ? $this_order_status[$row['state']] : 'invalid',
                    'order_pay_status' => !empty($this_order_pay_status[$row['pay_state']]) ? $this_order_pay_status[$row['pay_state']] : 'cancel',
                    // 'order_pay_feedback' => $row['order_pay_feedback'],
                    'MerchantID' => $row['MerchantID'],
                    'MerchantTradeNo' => $row['MerchantTradeNo'],
                    'PaymentDate' => $row['PaymentDate'],
                    'PaymentType' => $row['PaymentType'],
                    'PaymentTypeChargeFee' => $row['PaymentTypeChargeFee'],
                    'RtnCode' => $row['RtnCode'],
                    'RtnMsg' => $row['RtnMsg'],
                    'SimulatePaid' => $row['SimulatePaid'],
                    'TradeAmt' => $row['TradeAmt'],
                    'PayAmt' => $row['PayAmt'],
                    'TradeNo' => $row['TradeNo'],
                    'TradeDate' => $row['TradeDate'],
                    'PaymentNo' => $row['PaymentNo'],
                    'VirtualAccount' => $row['VirtualAccount'],
                    'BankCode' => $row['BankCode'],
                    'ExpireDate' => $row['ExpireDate'],
                    'invoid' => $row['invoid'],
                    'send_date' => $row['send_date'],
                    'send_type' => $row['send_type'],
                    'send_no' => $row['send_no'],
                    'upay_no' => $row['upay_no'],
                    'upay_price' => $row['upay_price'],
                    'upay_name' => $row['upay_name'],
                    'upay_date' => $row['upay_date'],
                    'upay_memo' => $row['upay_memo'],
                    'stock_makeup' => $row['stock_makeup'],
                    'point_enabled' => $row['point_enabled'],
                    'point_price' => $row['point_price'],
                    'state' => empty($this_order_status[$row['state']]) ? '1' : (($this_order_status[$row['state']] == 'confirm' && $this_order_pay_status[$row['pay_state']] == 'paid') ? '0' : 1),
                    'created_at' => $row['oddate'],
                );

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';

                // Insert row data into the database
                $this->db->insert('orders', $data);
            }

            foreach ($order_cvs as $row) {

                if (is_array($row)) {
                    foreach ($row as $key => $value) {
                        // 检查 $value 是否为 null，如果是，则替换为空字符串
                        if ($value === null) {
                            $row[$key] = '';
                        }
                    }
                }

                // Create an associative array with field names as keys
                $data = array(
                    'store_id' => $row['CVSStoreID'],
                    'order_store_name' => $row['CVSStoreName'],
                    'order_store_address' => $row['CVSAddress'],
                    'AllPayLogisticsID' => $row['AllPayLogisticsID'],
                );

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';

                // Update row data into the database
                $this->db->where('order_number', $row['odno']);
                $this->db->update('orders', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }


    function create_product_combine()
    {
        $version = 'create_product_combine';
        $description = 'create product combine';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $this->db->select('*');
            $query = $this->db->get('prd_detail');
            $prd_detail = $query->result_array();

            foreach ($prd_detail as $row) {
                $product = $this->mysql_model->_select('product', 'product_id', $row['prdid'], 'row');
                if (empty($product)) {
                    continue;
                }
                echo '<pre>';
                echo 'product =';
                print_r($product);
                echo '</pre>';

                // Create an associative array with field names as keys
                $data = array(
                    'id' => $row['pdid'],
                    'product_id' => $row['prdid'],
                    'cargo_id' => $row['pdno'],
                    'name' => $row['pdname'],
                    'quantity' => $row['stock'],
                    'price' => $product['product_price'],
                    'current_price' => $product['product_price'],
                    'picture' => $product['product_image'],
                    // 'description' => $product['product_note'],
                    'create_time' => date('Y-m-d H:i:s'),
                );

                echo '<pre>';
                print_r($data);
                echo '</pre>';

                // Insert row data into the database
                $this->db->insert('product_combine', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function import_member_sql()
    {
        $version = 'import_member_sql';
        $description = 'transition member data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $this->db->select('*');
            $query = $this->db->get('member');
            $products = $query->result_array();

            foreach ($products as $row) {
                $created_at = $row['datetime'];
                $updated_at = $row['datetime2'];

                // Create an associative array with field names as keys
                $user_data = array(
                    'id' => $row['memid'],
                    'fb_id' => $row['fbid'],
                    'ip_address' => $row['login_ip'],
                    'username' => (!empty($row['mobile'] && $row['mobile'] != null) ? $row['mobile'] : (!empty($row['email'] && $row['email'] != null) ? $row['email'] : (!empty($row['fbid'] && $row['fbid'] != null) ? $row['fbid'] : $row['memid']))),
                    'gender' => ($row['sex'] == '1' ? 'Male' : 'Female'),
                    'password' => $row['pwd'],
                    'active' => 1,
                    'email' => $row['email'],
                    'full_name' => $row['username'],
                    'phone' => ((!empty($row['mobile']) && $row['mobile'] != null) ? $row['mobile'] : ''),
                    'birthday' => (($row['birthday'] != null) ? $row['birthday'] : ''),
                    'is_send_email' => (($row['is_send_email'] != null) ? $row['is_send_email'] : 0),
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                );

                echo '<pre>';
                print_r($user_data);
                echo '</pre>';

                // Insert row data into the database
                $this->db->insert('users', $user_data);

                $groups_data = array(
                    'user_id' => $row['memid'],
                    'group_id' => 2,
                );

                $this->db->insert('users_groups', $groups_data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function import_product_old_sql()
    {
        $version = 'import_product_old_sql';
        $description = 'transition product data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {

            $this->db->select('*');
            $query = $this->db->get('product_old');
            $products = $query->result_array();

            foreach ($products as $row) {

                $cate_id = 0;
                // Convert date format from '0000/00/00' to '0000-00-00 00:00:00'
                $created_at = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $row['datetime'])));
                $updated_at = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $row['datetime2'])));
                if ($row['cateid2'] == '76') {
                    $cate_id = 1;
                }
                if ($row['cateid2'] == '77') {
                    $cate_id = 3;
                }
                if ($row['cateid2'] == '79') {
                    $cate_id = 5;
                }
                if ($row['cateid2'] == '80') {
                    $cate_id = 4;
                }
                if ($row['cateid2'] == '78') {
                    $cate_id = 2;
                }

                $product_img = 'Product/' . $row['filename'];
                $price = ($row['price'] != null) ? $row['price'] : (($row['spec_price'] != null) ? $row['price'] != null : 0);

                // Check if there are more rows in $post_contents
                // Get the first row from $post_contents

                // Create an associative array with field names as keys
                $data = array(
                    'product_id' => $row['prdid'],
                    'product_category_id' => $cate_id,
                    'product_name' => $row['pname'],
                    'product_sku' => $row['prdno'],
                    'product_price' => $price,
                    'product_description' => $row['content'],
                    'product_note' => nl2br($row['desc1']),
                    'product_image' => $product_img,
                    'product_status' => ($row['state'] == 2) ? 1 : 2,
                    'distribute_at' => $created_at,
                    'discontinued_at' => $updated_at,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                );

                echo '<pre>';
                print_r($data);
                echo '</pre>';

                // Insert row data into the database
                $this->db->insert('product', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function import_post_sql()
    {
        $version = 'import_post_sql';
        $description = 'transition news data';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $this->db->select('*');
            $query = $this->db->get('news');
            $news = $query->result_array();

            foreach ($news as $row) {

                $cate_id = 0;
                // Convert date format from '0000/00/00' to '0000-00-00 00:00:00'
                $created_at = date('Y-m-d H:i:s', strtotime($row['datetime']));
                $updated_at = date('Y-m-d H:i:s', strtotime($row['datetime2']));
                if ($row['kindid'] == '92') {
                    $cate_id = 1;
                }
                if ($row['kindid'] == '93') {
                    $cate_id = 2;
                }
                if ($row['kindid'] == '118') {
                    $cate_id = 3;
                }
                if ($row['kindid'] == '119') {
                    $cate_id = 4;
                }
                if ($row['kindid'] == '120') {
                    $cate_id = 5;
                }
                if ($row['kindid'] == '117') {
                    $cate_id = 6;
                }

                $post_img = 'News/img/' . $row['filename'];

                if (empty($row['filename'])) {
                    continue;
                }

                // Create an associative array with field names as keys
                $data = array(
                    'post_id' => $row['newsid'],
                    'post_category' => $cate_id,
                    'post_title' => $row['subject'],
                    'post_content' => $row['desc1'],
                    'post_image' => $post_img,
                    'post_status' => ($row['state'] == 'y') ? 1 : 2,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                );

                echo '<pre>';
                print_r($data);
                echo '</pre>';

                // Insert row data into the database
                $this->db->insert('posts', $data);
            }

            // $insertData = array(
            //     'version' => $version,
            //     'description' => $description,
            // );
            // if ($this->db->insert('update_log', $insertData)) {
            //     echo '<p>' . $version . ' - ' . $description . '</p>';
            // }
        }
    }

    function update_202403241905()
    {
        $version = '202403241905';
        $description = '[delivery] create [free_shipping_enable]&[free_shipping_limit]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'free_shipping_enable'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `delivery` ADD `free_shipping_enable` tinyint(2) NOT NULL AFTER `according_cost`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'free_shipping_limit'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `delivery` ADD `free_shipping_limit` int(11) NOT NULL AFTER `free_shipping_enable`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403211521()
    {
        $version = '202403211521';
        $description = '[product] create [safe_inventory]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'safe_inventory'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `safe_inventory` int(11) NOT NULL AFTER `inventory`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403201604()
    {
        $version = '202403201604';
        $description = '[product] create [seo_title][seo_keyword][seo_description]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'seo_title'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `seo_title` varchar(50) NOT NULL AFTER `product_add_on_price`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'seo_keyword'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `seo_keyword` varchar(300) NOT NULL AFTER `seo_title`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'seo_description'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `seo_description` varchar(500) NOT NULL AFTER `seo_keyword`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403131156()
    {
        $version = '202403131156';
        $description = '新增資料表[guestbook]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'guestbook'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `guestbook` (
                    `id` int(11) NOT NULL,
                    `order_id` int(11) NOT NULL,
                    `user_id` int(11) NOT NULL,
                    `content` mediumtext NOT NULL,
                    `response_status` tinyint(2) default 0 NOT NULL,
                    `created_at` datetime NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `guestbook` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `guestbook` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403131212()
    {
        $version = '202403131212';
        $description = '[orders] create [order_cpname][order_cpno]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'order_cpname'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `order_cpname` varchar(50) NOT NULL AFTER `order_delivery_address`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'order_cpno'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `order_cpno` varchar(50) NOT NULL AFTER `order_cpname`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403051354()
    {
        $version = '202403051354';
        $description = '新增資料表[product_img]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'product_img'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `product_img` (
                    `id` int(11) NOT NULL,
                    `product_id` int(11) NOT NULL,
                    `subid` int(11) NOT NULL,
                    `sort` int(11) NOT NULL,
                    `picture` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `product_img` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `product_img` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403051007()
    {
        $version = '202403051007';
        $description = '[banner] create [banner_image_mobile]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM banner LIKE 'banner_image_mobile'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `banner` ADD `banner_image_mobile` varchar(50) NOT NULL AFTER `banner_image`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202403011721()
    {
        $version = '202403011721';
        $description = '[orders] create [fm_type][fm_cold]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'fm_type'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `fm_type` varchar(50) NOT NULL AFTER `fm_ecno`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'fm_cold'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `fm_cold` tinyint(1) NOT NULL AFTER `fm_type`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402292254()
    {
        $version = '202402292254';
        $description = '[orders] create [fm_ecno]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'fm_ecno'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `fm_ecno` varchar(50) NOT NULL AFTER `order_number`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402291446()
    {
        $version = '202402291446';
        $description = '[orders] create [order_weight]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'order_weight'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `order_weight` decimal(13,3) NOT NULL DEFAULT 0.000 AFTER `customer_email`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402281618()
    {
        $version = '202402281618';
        $description = '[orders] create [order_store_ReservedNo]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'order_store_ReservedNo'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `order_store_ReservedNo` varchar(300) NOT NULL AFTER `order_store_address`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402220300()
    {
        $version = '202402220300';
        $description = '[users] create [Country][province][zipcode]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'Country'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `users` ADD `Country` varchar(10) NOT NULL AFTER `phone`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'provinc'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `users` ADD `province` varchar(10) NOT NULL AFTER `Country`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'zipcode'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `users` ADD `zipcode` varchar(10) NOT NULL AFTER `address`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402200216()
    {
        $version = '202402200216';
        $description = '[orders] create [state]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'state'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `state` tinyint(1) NOT NULL DEFAULT 1 AFTER `agent_profit_amount`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402141400()
    {
        $version = '202402141400';
        $description = '[menu] and the sons insert col [position_sort]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $tables = ['menu', 'sub_menu', 'sub_son_menu', 'sub_sub_son_menu'];
            $newColumnName = 'position_sort';

            foreach ($tables as $table) {
                $query = $this->db->query("SHOW COLUMNS FROM $table LIKE 'sort'");
                if ($query->num_rows() > 0) {
                    // Add the new column
                    $this->db->query("ALTER TABLE `$table` ADD `$newColumnName` int(11) NOT NULL AFTER `sort`;");

                    // Update the new column with values from the sort column
                    $this->db->query("UPDATE `$table` SET `$newColumnName` = `sort`;");
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202402021730()
    {
        $version = '202402021730';
        $description = '[orders]新增欄位[used_coupon_id]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'used_coupon_id'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `used_coupon_id` int(11) NOT NULL AFTER `store_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401291600()
    {
        $version = '202401291600';
        $description = '[new_coupon]新增欄位[use_member_enable]&[use_member_type]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM new_coupon LIKE 'use_member_enable'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `new_coupon` ADD `use_member_enable` tinyint(1) NOT NULL AFTER `use_type_number`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM new_coupon LIKE 'use_member_type'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `new_coupon` ADD `use_member_type` varchar(20) NOT NULL AFTER `use_member_enable`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401291410()
    {
        $version = '202401291410';
        $description = '新增資料表[new_coupon_custom]&[new_coupon_product]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'new_coupon_custom'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `new_coupon_custom` (
                    `id` int(11) NOT NULL,
                    `coupon_id` int(11) NOT NULL,
                    `custom_id` int(11) NOT NULL,
                    `type` varchar(20) NOT NULL,
                    `discount_amount` decimal(6) NOT NULL,
                    `use_limit_enable` tinyint(1) NOT NULL,
                    `use_limit_number` int(11) NOT NULL,
                    `use_type_enable` tinyint(1) NOT NULL,
                    `use_type_name` varchar(20) NOT NULL,
                    `use_type_number` int(11) NOT NULL,
                    `use_product_enable` tinyint(1) NOT NULL,
                    `distribute_at` datetime NOT NULL,
                    `discontinued_at` datetime NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `new_coupon_custom` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `new_coupon_custom` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'new_coupon_product'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `new_coupon_product` (
                    `id` int(11) NOT NULL,
                    `coupon_id` int(11) NOT NULL,
                    `use_product_id` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `new_coupon_product` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `new_coupon_product` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401260000()
    {
        $version = '202401260000';
        $description = '[new_coupon]新增欄位[use_product_enable]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM new_coupon LIKE 'use_product_enable'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `new_coupon` ADD `use_product_enable` tinyint(1) NOT NULL AFTER `use_type_number`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401262230()
    {
        $version = '202401262230';
        $description = '新增資料表[new_coupon]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'new_coupon'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `new_coupon` (
                    `id` int(11) NOT NULL,
                    `name` varchar(50) NOT NULL,
                    `type` varchar(20) NOT NULL,
                    `discount_amount` decimal(6) NOT NULL,
                    `use_limit_enable` tinyint(1) NOT NULL,
                    `use_limit_number` int(11) NOT NULL,
                    `use_type_enable` tinyint(1) NOT NULL,
                    `use_type_name` varchar(20) NOT NULL,
                    `use_type_number` int(11) NOT NULL,
                    `distribute_at` datetime NOT NULL,
                    `discontinued_at` datetime NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `new_coupon` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `new_coupon` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401231430()
    {
        $version = '202401231430';
        $description = '[product]新增欄位[booking_date]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'booking_date'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `booking_date` varchar(20) NOT NULL AFTER `product_category_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401191900()
    {
        $version = '202401191900';
        $description = '[order_item]新增欄位[cargo_id]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'cargo_id'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `order_item` ADD `cargo_id` varchar(100) NOT NULL AFTER `product_combine_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401182000()
    {
        $version = '202401182000';
        $description = '[sub_sub_son_menu]新增欄位[description]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM sub_sub_son_menu LIKE 'description'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `sub_sub_son_menu` ADD `description` LONGTEXT NOT NULL AFTER `code`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401181930()
    {
        $version = '202401181930';
        $description = '[sub_son_menu]新增欄位[description]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM sub_son_menu LIKE 'description'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `sub_son_menu` ADD `description` LONGTEXT NOT NULL AFTER `code`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401172030()
    {
        $version = '202401172030';
        $description = '[product_combine]新增欄位[cargo_id]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_combine LIKE 'cargo_id'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product_combine` ADD `cargo_id` varchar(50) NOT NULL AFTER `product_id`;");
            }


            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401151900()
    {
        $version = '202401151900';
        $description = '[product_tag]新增欄位[name]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_tag LIKE 'name'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product_tag` ADD `name` varchar(50) NOT NULL AFTER `parent_id`;");
            }


            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401151500()
    {
        $version = '202401151500';
        $description = '新增資料表[features_pay]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'features_pay'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `features_pay` (
                    `pay_id` int(2) NOT NULL,
                    `pay_name` varchar(30) NOT NULL,
                    `payment_status` tinyint(1) NOT NULL,
                    `MerchantID` varchar(10) NOT NULL,
                    `HashKey` varchar(64) NOT NULL,
                    `HashIV` varchar(64) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `features_pay` ADD PRIMARY KEY (`pay_id`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401122200()
    {
        $version = '202401122200';
        $description = '[product]新增欄位[Sales_volume]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'Sales_volume'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `Sales_volume` int(11) NOT NULL DEFAULT 0 AFTER `volume_height`;");
            }


            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401121730()
    {
        $version = '202401121730';
        $description = '新增資料表[product_tag][product_tag_lang][product_tag_content]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'product_tag'")->result_array();
            if (empty($query)) {
                $this->db->query("CREATE TABLE `product_tag` (
              `id` int(11) NOT NULL,
              `parent_id` int(11) NOT NULL,
              `code` varchar(30) NOT NULL,
              `sort` decimal(6,2) NOT NULL,
              `status` tinyint(4) NOT NULL DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `product_tag`
              ADD PRIMARY KEY (`id`),
              ADD KEY `parent_id` (`parent_id`),
              ADD KEY `code` (`code`),
              ADD KEY `status` (`status`);");
                $this->db->query("ALTER TABLE `product_tag` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $query = $this->db->query("SHOW TABLES LIKE 'product_tag_content'")->result_array();
            if (empty($query)) {
                $this->db->query("CREATE TABLE `product_tag_content` (
              `id` int(11) NOT NULL,
              `product_tag_id` int(11) NOT NULL,
              `product_id` int(11) NOT NULL,
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `product_tag_content`
              ADD PRIMARY KEY (`id`),
              ADD KEY `product_tag_id` (`product_tag_id`),
              ADD KEY `product_id` (`product_id`);");
                $this->db->query("ALTER TABLE `product_tag_content` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            // $query = $storeDB->query("SHOW TABLES LIKE 'product_tag'")->result_array();
            // if (empty($query)) {
            //     $this->db->query("CREATE TABLE `product_tag` (
            //   `id` int(11) NOT NULL,
            //   `parent_id` int(11) NOT NULL,
            //   `code` varchar(30) NOT NULL,
            //   `sort` decimal(6,2) NOT NULL,
            //   `status` tinyint(4) NOT NULL DEFAULT '1',
            //   `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            //   `updated_at` datetime NOT NULL
            // ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            //     $this->db->query("ALTER TABLE `product_tag`
            //   ADD PRIMARY KEY (`id`),
            //   ADD KEY `parent_id` (`parent_id`),
            //   ADD KEY `code` (`code`),
            //   ADD KEY `status` (`status`);");
            //     $this->db->query("ALTER TABLE `product_tag` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            // }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401111630()
    {
        $version = '202401111630';
        $description = '[orders]新增欄位[SelfLogistics]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'SelfLogistics'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `SelfLogistics` varchar(30) NOT NULL AFTER `InvoiceNumber`;");
            }


            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401081530()
    {
        $version = '202401081530';
        $description = '新增資料表[sub_sub_son_menu]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'sub_sub_son_menu'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `sub_sub_son_menu` (
                    `id` int(11) NOT NULL,
                    `parent_id` int(11) NOT NULL,
                    `grandparent_id` int(11) NOT NULL,
                    `grandparent_parent_id` int(11) NOT NULL,
                    `code` varchar(30) NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` int(11) NOT NULL,
                    `type` varchar(30) NOT NULL,
                    `status` tinyint(4) NOT NULL DEFAULT 1,
                    `switch` tinyint(4) NOT NULL DEFAULT 0,
                    `updated_at` datetime NOT NULL,
                    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `sub_sub_son_menu` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `sub_sub_son_menu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202401012000()
    {
        $version = '202401012000';
        $description = '[sub_menu]新增欄位[switch]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM sub_menu LIKE 'switch'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `sub_menu` ADD `switch` tinyint(4) NOT NULL DEFAULT 0 AFTER `status`;");
            }


            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312311830()
    {
        $version = '202312311830';
        $description = '[banner]新增欄位[banner_type]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM banner LIKE 'banner_type'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `banner` ADD `banner_type` varchar(30) NOT NULL  AFTER `banner_id`;");
            }


            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312291830()
    {
        $version = '202312291830';
        $description = '新增資料表[sub_son_menu]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'sub_son_menu'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `sub_son_menu` (
                    `id` int(11) NOT NULL,
                    `parent_id` int(11) NOT NULL,
                    `grandparent_id` int(11) NOT NULL,
                    `grandparent_parent_id` int(11) NOT NULL,
                    `code` varchar(30) NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` int(11) NOT NULL,
                    `type` varchar(30) NOT NULL,
                    `status` tinyint(4) NOT NULL DEFAULT 1,
                    `switch` tinyint(4) NOT NULL DEFAULT 0,
                    `updated_at` datetime NOT NULL,
                    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `sub_son_menu` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `sub_son_menu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312271800()
    {
        $version = '202312271800';
        $description = '[sub_menu]新增欄位[parent_id]&[type]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM sub_menu LIKE 'parent_id'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `sub_menu` ADD `parent_id` int(11) NOT NULL  AFTER `id`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM sub_menu LIKE 'type'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `sub_menu` ADD `type` varchar(30) NOT NULL  AFTER `sort`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }
    function update_202312271600()
    {
        $version = '202312271600';
        $description = '[product_combine]新增欄位[limit_qty]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_combine LIKE 'limit_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product_combine` ADD `limit_qty` varchar(64) NOT NULL  AFTER `limit_enable`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312231630()
    {
        $version = '202312231630';
        $description = '[contradiction]新增欄位[name]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM contradiction LIKE 'name'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `contradiction` ADD `name` varchar(128) NOT NULL  AFTER `id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312231600()
    {
        $version = '202312231600';
        $description = '新增資料表[contradiction]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'contradiction'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `contradiction` (
                    `id` int(11) NOT NULL,
                    `contradiction_status` int(1) NOT NULL,
                    `created_at` datetime NOT NULL,
                    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `contradiction` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `contradiction` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312211000()
    {
        $version = '202312211000';
        $description = '[order_item]新增欄位[product_combine_name]&[product_name]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'product_combine_name'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `order_item` ADD `product_combine_name` varchar(128) NOT NULL  AFTER `product_combine_id`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'product_name'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `order_item` ADD `product_name` varchar(128) NOT NULL  AFTER `product_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312201430()
    {
        $version = '202312201430';
        $description = '[order_item]新增欄位[customer_id]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'customer_id'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `order_item` ADD `customer_id` int(11) NOT NULL  AFTER `product_combine_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312171935()
    {
        $version = '202312171935';
        $description = '[menu]新增欄位[type]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM menu LIKE 'type'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `menu` ADD `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `sort`;");

                $insertData = array(
                    'version' => $version,
                    'description' => $description,
                );
                if ($this->db->insert('update_log', $insertData)) {
                    echo '<p>' . $version . ' - ' . $description . '</p>';
                }
            }
        }
    }

    function update_202312181730()
    {
        $version = '202312181730';
        $description = '新增資料表[auth_member_category]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'auth_member_category'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `auth_member_category` (
                    `auth_category_id` int(11) NOT NULL,
                    `auth_category_name` varchar(20) NOT NULL,
                    `created_at` datetime NOT NULL,
                    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `auth_member_category` ADD PRIMARY KEY (`auth_category_id`);");
                $this->db->query("ALTER TABLE `auth_member_category` MODIFY `auth_category_id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312181700()
    {
        $version = '202312181700';
        $description = '新增資料表[auth_visiter_category]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'auth_visiter_category'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `auth_visiter_category` (
                    `auth_category_id` int(11) NOT NULL,
                    `auth_category_name` varchar(20) NOT NULL,
                    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` datetime NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `auth_visiter_category` ADD PRIMARY KEY (`auth_category_id`);");
                $this->db->query("ALTER TABLE `auth_visiter_category` MODIFY `auth_category_id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312161325()
    {
        $version = '202312161325';
        $description = '新增資料表[standard_page_list][franchisee_data_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'standard_page_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `standard_page_list` (
                    `id` int(11) NOT NULL,
                    `page_name` varchar(50) NOT NULL,
                    `page_title` varchar(50) NOT NULL,
                    `page_info` text NOT NULL,
                    `page_img` varchar(50) NOT NULL,
                    `page_lang` varchar(50) NOT NULL,
                    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` datetime NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `standard_page_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `standard_page_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'franchisee_data_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `franchisee_data_list` (
                    `id` int(11) NOT NULL,
                    `users_id` int(11) NOT NULL,
                    `store_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `start_date` DATETIME NOT NULL,
                    `end_date` DATETIME NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `franchisee_data_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `franchisee_data_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `franchisee_data_list` ADD INDEX(`users_id`);");
                $this->db->query("ALTER TABLE `franchisee_data_list` ADD INDEX(`store_code`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312151535()
    {
        $version = '202312151535';
        $description = '[product_unit]新增欄位[weight,volume_length,volume_width,volume_height]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'weight'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `unit`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'volume_length'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `volume_length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `weight`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'volume_width'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `volume_width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_length`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'volume_height'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `volume_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_width`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312151530()
    {
        $version = '202312151530';
        $description = '新增資料表[menu][sub_menu][menu_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'menu'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `menu` (
                    `id` int(11) NOT NULL,
                    `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `menu` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `menu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'sub_menu'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `sub_menu` (
                    `id` int(11) NOT NULL,
                    `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `sub_menu` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `sub_menu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'menu_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `menu_list` (
                    `id` int(11) NOT NULL,
                    `sub_menu_id` int(11) NOT NULL,
                    `upper_layer_id` int(11) NOT NULL,
                    `upper_layer_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `menu_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `menu_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `menu_list` ADD INDEX(`sub_menu_id`);");
                $this->db->query("ALTER TABLE `menu_list` ADD INDEX(`upper_layer_id`);");
                $this->db->query("ALTER TABLE `menu_list` ADD INDEX(`upper_layer_code`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312151520()
    {
        $version = '202312151520';
        $description = '[tab_store]新增欄位[code]&新增資料表[tab_category_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM tab_store LIKE 'code'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `tab_store` ADD `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `id`;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'tab_category_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `tab_category_list` (
                    `id` int(11) NOT NULL,
                    `product_category_id` int(11) NOT NULL,
                    `upper_layer_id` int(11) NOT NULL,
                    `upper_layer_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `tab_category_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `tab_category_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `tab_category_list` ADD INDEX(`product_category_id`);");
                $this->db->query("ALTER TABLE `tab_category_list` ADD INDEX(`upper_layer_id`);");
                $this->db->query("ALTER TABLE `tab_category_list` ADD INDEX(`upper_layer_code`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312151515()
    {
        $version = '202312151515';
        $description = '[product_category]新增欄位[product_category_sort][product_category_code]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_category LIKE 'product_category_sort'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_category` ADD `product_category_sort` int(8) NOT NULL AFTER `product_category_print`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_category LIKE 'product_category_code'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_category` ADD `product_category_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `product_category_parent`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312142100()
    {
        $version = '202312142100';
        $description = '[orders]新增欄位[InvoiceNumber]&[AllPayLogisticsID]&[CVSPaymentNo]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'CVSPaymentNo'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `CVSPaymentNo` varchar(20) NOT NULL  AFTER `order_payment`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'AllPayLogisticsID'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `AllPayLogisticsID` varchar(10) NOT NULL  AFTER `order_payment`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'InvoiceNumber'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `InvoiceNumber` varchar(10) NOT NULL  AFTER `order_payment`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }
    function update_202312132220()
    {
        $version = '202312132220';
        $description = '優化資料庫-新增索引';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'product_category_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD INDEX(`product_category_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_combine LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_combine` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_combine_item LIKE 'product_combine_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_combine_item` ADD INDEX(`product_combine_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_combine_item LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_combine_item` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_specification LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_specification` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_combine LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_combine` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_combine_item LIKE 'product_combine_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_combine_item` ADD INDEX(`product_combine_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_combine_item LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_combine_item` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_specification LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_specification` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_unit LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_unit` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `order_item` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'product_combine_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `order_item` ADD INDEX(`product_combine_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'specification_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `order_item` ADD INDEX(`specification_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_sales` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'fb_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD INDEX(`fb_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users_address LIKE 'user_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users_address` ADD INDEX(`user_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_category_list LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_category_list` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_category_list LIKE 'product_category_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_category_list` ADD INDEX(`product_category_id`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312131400()
    {
        $version = '202312131400';
        $description = '[users]新增欄位[store_code]&[groups]新增參數[franchisee]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'store_code'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `store_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ip_address`;");
            }

            $this->db->select('id');
            $this->db->where('name', 'franchisee');
            $this->db->limit(1);
            $g_row = $this->db->get('groups')->row_array();
            if (empty($g_row)) {
                $this->db->insert('groups', array('id' => 99, 'name' => 'franchisee', 'description' => '加盟主'));
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312122325()
    {
        $version = '202312122325';
        $description = '[orders]新增欄位參數';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'order_pay_status'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `order_pay_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_payment`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'merID'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `merID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_status`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'authCode'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `authCode` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `merID`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'lidm'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `lidm` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `authCode`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'authAmt'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `authAmt` decimal(13,2) NOT NULL AFTER `lidm`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'xid'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `xid` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `authAmt`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'MerchantID'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `MerchantID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `xid`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'MerchantTradeNo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `MerchantTradeNo` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `MerchantID`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentDate'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentDate` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `MerchantTradeNo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentType'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentType` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `PaymentDate`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentTypeChargeFee'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentTypeChargeFee` decimal(13,2) NOT NULL AFTER `PaymentType`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'RtnCode'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `RtnCode` int(11) NOT NULL AFTER `PaymentTypeChargeFee`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'RtnMsg'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `RtnMsg` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `RtnCode`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'SimulatePaid'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `SimulatePaid` int(1) NOT NULL AFTER `RtnMsg`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'TradeAmt'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `TradeAmt` decimal(13,2) NOT NULL AFTER `SimulatePaid`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PayAmt'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PayAmt` decimal(13,2) NOT NULL AFTER `TradeAmt`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'TradeNo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `TradeNo` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `PayAmt`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'TradeDate'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `TradeDate` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `TradeNo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentNo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentNo` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `TradeDate`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'VirtualAccount'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `VirtualAccount` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `PaymentNo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'BankCode'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `BankCode` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `VirtualAccount`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'ExpireDate'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `ExpireDate` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `BankCode`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'invoid'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `invoid` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ExpireDate`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'send_date'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `send_date` date NOT NULL AFTER `invoid`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'send_type'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `send_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `send_date`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'send_no'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `send_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `send_type`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_no'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_no` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `send_no`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_price'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_price` decimal(13,2) NOT NULL AFTER `upay_no`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_name'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `upay_price`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_date'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_date` date NOT NULL AFTER `upay_name`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_memo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_memo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `upay_date`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'stock_makeup'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `stock_makeup` int(8) NOT NULL AFTER `upay_memo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'point_enabled'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `point_enabled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `stock_makeup`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'point_price'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `point_price` decimal(13,2) NOT NULL AFTER `point_enabled`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312122315()
    {
        $version = '202312122315';
        $description = '[users&users_address]變更[address]長度->300';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'address'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users` CHANGE `address` `address` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users_address LIKE 'address'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users_address` CHANGE `address` `address` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312122310()
    {
        $version = '202312122310';
        $description = '[users]新增欄位[register_source,black_tag,point,fb_id,is_send_email]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'black_tag'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `black_tag` int(11) NOT NULL AFTER `status`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'register_source'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `register_source` int(11) NOT NULL AFTER `black_tag`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'point'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `point` int(11) NOT NULL AFTER `company`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'fb_id'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `fb_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `id`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'is_send_email'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `is_send_email` tinyint(1) NOT NULL;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312121541()
    {
        $version = '202312121541';
        $description = '[delivery]新增欄位*limit*[weight,weight_unit,volume_length,volume_width,volume_height]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_weight'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `shipping_cost`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_weight_unit'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_weight_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_weight`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_volume_length'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_volume_length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_weight_unit`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_volume_width'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_volume_width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_volume_length`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_volume_height'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_volume_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_volume_width`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312121540()
    {
        $version = '202312121540';
        $description = '[product]新增欄位[product_weight,volume_length,volume_width,volume_height]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'product_weight'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `product_weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `product_sku`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'volume_length'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `volume_length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `product_weight`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'volume_width'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `volume_width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_length`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'volume_height'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `volume_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_width`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312062000()
    {
        $version = '202312062000';
        $description = '[product]新增欄位[discontinued_at]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'discontinued_at'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `discontinued_at` datetime NOT NULL  AFTER `updater_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202312051900()
    {
        $version = '202312051900';
        $description = '[product]新增欄位[distribute_at]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'distribute_at'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `distribute_at` datetime NOT NULL  AFTER `updater_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202311211630()
    {
        $version = '202311211630';
        $description = '新增資料表[lottery][lottery_pool]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'lottery'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `lottery` (
                  `id` int(8) NOT NULL,
                  `name` varchar(255) NOT NULL,
                  `email_subject` varchar(100) NOT NULL,
                  `email_content` text NOT NULL,
                  `sms_subject` varchar(255) NOT NULL,
                  `sms_content` varchar(255) NOT NULL,
                  `product_id` int(8) NOT NULL,
                  `number_limit` int(8) NOT NULL,
                  `number_remain` int(8) NOT NULL,
                  `number_alternate` int(8) NOT NULL,
                  `star_time` datetime NOT NULL,
                  `end_time` datetime NOT NULL,
                  `draw_date` datetime NOT NULL,
                  `fill_up_date` datetime NOT NULL,
                  `draw_over` int(8) NOT NULL,
                  `fill_up_over` int(8) NOT NULL,
                  `filter_black` int(8) NOT NULL,
                  `state` varchar(255) NOT NULL,
                  `lottery_end` int(8) NOT NULL,
                  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `lottery` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `lottery` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `lottery` ADD INDEX(`product_id`);");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'lottery_pool'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `lottery_pool` (
                  `id` int(8) NOT NULL,
                  `lottery_id` int(8) NOT NULL,
                  `users_id` int(8) NOT NULL,
                  `send_mail` text NOT NULL,
                  `abstain` int(8) NOT NULL,
                  `winner` int(8) NOT NULL,
                  `alternate` int(8) NOT NULL,
                  `fill_up` int(8) NOT NULL,
                  `blacklist` int(8) NOT NULL,
                  `abandon` int(8) NOT NULL,
                  `order_state` varchar(255) NOT NULL,
                  `order_id` int(11) NOT NULL,
                  `order_number` varchar(15) NOT NULL,
                  `msg_mail` varchar(255) NOT NULL,
                  `msg` varchar(255) NOT NULL,
                  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `lottery_pool` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `lottery_pool` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `lottery_pool` ADD INDEX(`lottery_id`);");
                $this->db->query("ALTER TABLE `lottery_pool` ADD INDEX(`users_id`);");
                $this->db->query("ALTER TABLE `lottery_pool` ADD INDEX(`order_id`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202311081430()
    {
        $version = '202311081430';
        $description = '[users]資料表[email]移除唯一值';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'email'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users` DROP INDEX `uc_email`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202310311530()
    {
        $version = '202310311530';
        $description = '新增資料表[delivery_range_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'delivery_range_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `delivery_range_list` (
                    `id` int(11) NOT NULL,
                    `delivery_id` int(11) NOT NULL,
                    `source` varchar(100) NOT NULL,
                    `source_id` int(11) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `delivery_range_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `delivery_range_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `delivery_range_list` ADD INDEX(`delivery_id`);");
                $this->db->query("ALTER TABLE `delivery_range_list` ADD INDEX(`source_id`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202310251800()
    {
        $version = '20231025180';
        $description = '新增資料表[tab_store]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'tab_store'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `tab_store` (
                    `id` int(11) NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `tab_store` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `tab_store` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202310251330()
    {
        $version = '202310251330';
        $description = 'delivery insertData[home_delivery]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'delivery';");
            if ($query->num_rows() > 0) {
                $this->db->select('id');
                $this->db->where('delivery_name_code', 'home_delivery');
                $this->db->limit(1);
                $d_row = $this->db->get('delivery')->row_array();
                if (empty($d_row)) {
                    $insertData = array(
                        'delivery_name_code' => 'home_delivery',
                        'delivery_name' => '一般宅配',
                    );
                    $this->db->insert('delivery', $insertData);
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309191500()
    {
        $version = '202309191500';
        $description = 'setting_general insertData[join_member_info]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('join_member_info');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
                    }
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309121800()
    {
        $version = '202309121800';
        $description = '[order_item]新增欄位[specification_str]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'specification_str'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `order_item` ADD `specification_str` varchar(300) NOT NULL  AFTER `specification_id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309071240()
    {
        $version = '202309071240';
        $description = '[product]新增欄位[product_sku]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'product_sku'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `product_sku` varchar(50) NOT NULL  AFTER `product_name`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309061750()
    {
        $version = '202309061750';
        $description = '[product]新增欄位[stock_overbought]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'stock_overbought'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `stock_overbought` TINYINT(2) NOT NULL DEFAULT '1' AFTER `excluding_inventory`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309061300()
    {
        $version = '202309061300';
        $description = '新增資料表[notify]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'notify'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("CREATE TABLE `notify` (
                    `id` int(11) NOT NULL,
                    `title` varchar(50) NOT NULL,
                    `content` varchar(500) NOT NULL,
                    `source` varchar(20) NOT NULL,
                    `read` TINYINT(2) NOT NULL DEFAULT '1',
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `notify` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `notify` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309051755()
    {
        $version = '202309051755';
        $description = '[product]新增欄位[excluding_inventory]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'excluding_inventory'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `excluding_inventory` TINYINT(2) NOT NULL DEFAULT '1' AFTER `inventory`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202309051540()
    {
        $version = '202309051540';
        $description = '新增資料表[inventory_log]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'inventory_log'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("CREATE TABLE `inventory_log` (
                    `id` int(11) NOT NULL,
                    `product_id` int(11) NOT NULL,
                    `source` varchar(20) NOT NULL,
                    `change_history` decimal(13,4) NOT NULL,
                    `change_notes` varchar(50) NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `inventory_log` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `inventory_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `inventory_log` ADD INDEX(`product_id`);");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308301910()
    {
        $version = '202308301910';
        $description = '[product]新增欄位[inventory]&[single_sales_agent]新增欄位[signature_file]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'inventory'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `inventory` decimal(13,4) NOT NULL AFTER `sort`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'signature_file'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `signature_file` varchar(100) NOT NULL AFTER `income`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308231510()
    {
        $version = '202308231510';
        $description = 'setting_general insertData[mail_header_text,mail_boddy_text,mail_other_text,mail_footer_text]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('mail_header_text', 'mail_boddy_text', 'mail_other_text', 'mail_footer_text');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
                    }
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308212210()
    {
        $version = '202308212210';
        $description = 'setting_general insertData[smtp_host,smtp_user,smtp_pass,smtp_port,smtp_crypto]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('smtp_host', 'smtp_user', 'smtp_pass', 'smtp_port', 'smtp_crypto');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
                    }
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308212140()
    {
        $version = '202308212140';
        $description = 'setting_general insertData[facebook,line,instagram,tiktok,xiaohongshu,single_sales_error_info]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('official_facebook_1_qrcode', 'official_facebook_2_qrcode', 'official_line_1_qrcode', 'official_line_2_qrcode', 'official_instagram_1_qrcode', 'official_instagram_2_qrcode', 'official_tiktok_1_qrcode', 'official_tiktok_2_qrcode', 'official_xiaohongshu_1_qrcode', 'official_xiaohongshu_2_qrcode', 'single_sales_error_info');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
                    }
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308201555()
    {
        $version = '202308201555';
        $description = '[users]新增欄位[join_status]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'join_status'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `users` ADD `join_status` varchar(30) NOT NULL AFTER `id`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308191205()
    {
        $version = '202308191205';
        $description = 'setting_general insertData[facebook,line,instagram,tiktok,xiaohongshu,logo_max_width,shopping_notes]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('logo_max_width', 'official_facebook_1', 'official_facebook_2', 'official_line_1', 'official_line_2', 'official_instagram_1', 'official_instagram_2', 'official_tiktok_1', 'official_tiktok_2', 'official_xiaohongshu_1', 'official_xiaohongshu_2', 'shopping_notes');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
                    }
                }
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308161240()
    {
        $version = '202308161240';
        $description = 'single_sales_agent->income,order_qty,finish_qty,cancel_qty,other_qty,turnover_amount,turnover_rate';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'order_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `order_qty` int(11) NOT NULL AFTER `start_hits`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'finish_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `finish_qty` int(11) NOT NULL AFTER `order_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'cancel_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `cancel_qty` int(11) NOT NULL AFTER `finish_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'other_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `other_qty` int(11) NOT NULL AFTER `cancel_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'turnover_rate'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `turnover_rate` float(6,2) NOT NULL AFTER `other_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'turnover_amount'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `turnover_amount` decimal(13,4) NOT NULL AFTER `turnover_rate`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'income'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `income` decimal(13,4) NOT NULL AFTER `turnover_amount`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308161230()
    {
        $version = '202308161230';
        $description = 'single_sales->qty,unit,default_profit_percentage';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'qty'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("ALTER TABLE `single_sales` ADD `qty` decimal(13,4) NOT NULL AFTER `cost`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'unit'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("ALTER TABLE `single_sales` ADD `unit` varchar(10) NOT NULL AFTER `qty`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'default_profit_percentage'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("ALTER TABLE `single_sales` ADD `default_profit_percentage` float(6,2) NOT NULL AFTER `unit`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308161130()
    {
        $version = '202308161130';
        $description = '新增資料表[update_log]';
        $query = $this->db->query("SHOW TABLES LIKE 'update_log'");
        if ($query->num_rows() > 0) {
            // 已經存在
        } else {
            // 不存在
            $this->db->query("CREATE TABLE `update_log` (
                `id` int(11) NOT NULL,
                `version` varchar(20) NOT NULL,
                `description` varchar(100) NOT NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            $this->db->query("ALTER TABLE `update_log` ADD PRIMARY KEY (`id`);");
            $this->db->query("ALTER TABLE `update_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        }

        $query = $this->db->query("SHOW TABLES LIKE 'update_log'");
        if ($query->num_rows() > 0) {
            // 已經存在
            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        } else {
            // 不存在
        }
    }
}
