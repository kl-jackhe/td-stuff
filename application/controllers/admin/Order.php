<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('order_model');
	}

    public function index()
    {
        $this->data['page_title'] = '訂單';

        $data = array();
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->order_model->getRows($conditions);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/order/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['delivery_place'] = $this->mysql_model->_select('delivery_place');
        $this->data['orders'] = $this->order_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/order/index');
    }

    function ajaxData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->get('keywords');
        // $sortBy = $this->input->get('sortBy');
        $category = $this->input->get('category');
        $category2 = $this->input->get('category2');
        // $status = $this->input->get('status');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        // if(!empty($sortBy)){
        //     $conditions['search']['sortBy'] = $sortBy;
        // }
        if(!empty($category)){
            $conditions['search']['category'] = $category;
        }
        if(!empty($category2)){
            $conditions['search']['category2'] = $category2;
        }
        // if(!empty($status)){
        //     $conditions['search']['status'] = $status;
        // }
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->order_model->getRows($conditions);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/order/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $conditions['returnType'] = '';
        $this->data['orders'] = $this->order_model->getRows($conditions);
        //load the view
        $this->load->view('admin/order/ajax-data', $this->data, false);
        //$this->render('admin/order/ajax-pagination-data');
    }

    public function view($id)
    {
        $this->data['page_title'] = '訂單明細';
        $this->data['order'] = $this->mysql_model->_select('orders','order_id',$id,'row');
        $this->data['order_item'] = $this->mysql_model->_select('order_item','order_id',$id);
        $this->render('admin/order/view');
    }

    // public function update($id)
    // {
    //     $data = array(
    //         'order_step' => $this->input->post('order_step'),
    //         'updater_id' => $this->current_user->id,
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     );

    //     $this->db->where('order_id', $id);
    //     $this->db->update('orders', $data);

    //     $this->session->set_flashdata('message', '訂單更新成功！');
    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    public function update_step($id,$step = '')
    {
        if($step==''){
            $step = $this->input->post('order_step');
        }
        // 已取貨
        if($step=='picked'){
            $data = array(
                'order_step'       => $step,
                'order_pay_status' => 'paid',
                'updater_id'       => $this->current_user->id,
                'updated_at'       => date('Y-m-d H:i:s'),
            );
            $this->db->where('order_id', $id);
            $this->db->update('orders', $data);
        // 取消
        } elseif ($step=='cancel') {
            // 如果是LINE PAY，刷退
            $this_order = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
            if($this_order['order_payment']=='line_pay' && $this_order['order_pay_status']=='paid'){
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
        } elseif ($step=='void') {
            // 如果是LINE PAY，刷退
            $this_order = $this->mysql_model->_select('orders', 'order_id', $id, 'row');
            if($this_order['order_payment']=='line_pay' && $this_order['order_pay_status']=='paid'){
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
            $this->db->where('order_id', $id);
            $this->db->update('orders', $data);
        }

        $this_order = $this->mysql_model->_select('orders','order_id',$id,'row');
        $this_order_item = $this->mysql_model->_select('order_item','order_id',$id);

        // if($step!='prepare' && $step!='shipping' && $step!='arrive'){
        if($step=='picked' || $step=='cancel' || $step=='void'){
            // Start 寄信給買家
            
            $subject = '您的訂單 '.$this_order['order_number'].' '.get_order_step($step).' - '.get_setting_general('name');

            $header = '<img src="'.base_url().'assets/uploads/bytheway.png" height="100px">
            <h3>'.get_user_full_name($this_order['customer_id']).' 您好：</h3>
            <h3>您在 '.get_setting_general('name').' 的訂單，以下是您的訂單明細：</h3>';


            $message = '<table style="width:100%;background:#fafaf8;padding:15px;">
            <tr style="border-bottom:2px solid #e41c10;">
                <td><h3>【訂購明細】</h3><hr></td>
            </tr>
            <tr>
                <td>
                    訂單編號 : '.$this_order['order_number'].'
                </td>
            </tr>
            <tr>
                <td>
                    付款方式 : '.get_payment($this_order['order_payment']).'
                </td>
            </tr>
            <tr>
                <td>
                    訂單狀況 : '.get_order_step($step).'
                </td>
            </tr>
            <tr>
                <td>
                    訂購日期 : '.$this_order['order_date'].'
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
            if(!empty($this_order_item)){ foreach ($this_order_item as $items){
                $content .= '<tr>';
                    $content .= '<td>'.get_product_name($items['product_id']);
                    $content .= '</td>';
                    $content .= '<td style="text-align:right">$ '.number_format($items['order_item_price']).'</td>';
                    $content .= '<td style="text-align:center">'.$items['order_item_qty'].'</td>';
                    $content .= '<td style="text-align:right">$ '.number_format($items['order_item_qty']*$items['order_item_price']).'</td>';
                $content .= '</tr>';
            $i++;
            }}

            $content .= '<tr><td colspan="4"><hr></td></tr>';
            $content .= '<tr>';
            $content .= '<td colspan="2"> </td>';
            $content .= '<td style="text-align:right"><strong>小計</strong></td>';
            $content .= '<td style="text-align:right">NT$ '.number_format($this_order['order_total']-$this_order['order_delivery_cost']-$this_order['order_discount_price']).'</td>';
            $content .= '</tr>';
            $content .= '<tr>';
            $content .= '<td colspan="2"> </td>';
            $content .= '<td style="text-align:right"><strong>運費</strong></td>';
            $content .= '<td style="text-align:right">NT$ '.number_format($this_order['order_delivery_cost']).'</td>';
            $content .= '</tr>';
            $content .= '<tr>';
            $content .= '<td colspan="2"> </td>';
            $content .= '<td style="text-align:right"><strong>優惠券折抵</strong></td>';
            $content .= '<td style="text-align:right">NT$ -'.number_format($this_order['order_discount_price']).'</td>';
            $content .= '</tr>';
            $content .= '<tr>';
            $content .= '<td colspan="2"> </td>';
            $content .= '<td style="text-align:right"><strong>總計</strong></td>';
            $content .= '<td style="text-align:right">NT$ '.number_format($this_order['order_discount_total']).'</td>';
            $content .= '</tr>';
            $content .= '<tr><td colspan="4" text-align="center"><a href="'.base_url().'order" target="_blank" class="order-check-btn" style="color: #000;">訂單查詢</a></td></tr>';

            $content .= '</table>';

            $information = '<table style="width:100%;background:#fafaf8;padding:15px;">
            <tr style="border-bottom:2px solid #e41c10;">
                <td><h3>【收件資訊】</h3><hr></td>
            </tr>
            <tr>
                <td>
                    收件姓名 : '.$this_order['customer_name'].'
                </td>
            </tr>
            <tr>
                <td>
                    聯絡電話 : '.$this_order['customer_phone'].'
                </td>
            </tr>
            <tr>
                <td>
                    收件地址 : '.$this_order['order_delivery_address'].'
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:100%;background:#fff;padding:15px 0px 15px 10px;border:1px dashed #979797;">
                        備註 : '.$this_order['order_remark'].'
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

            $this->email->set_smtp_host("mail.kuangli.tw");
            $this->email->set_smtp_user("btw@kuangli.tw");
            $this->email->set_smtp_pass("Btw@admin");
            $this->email->set_smtp_port("587");
            $this->email->set_smtp_crypto("");

            $this->email->from('service1@bythewaytaiwan.com', get_setting_general('name'));
            $this->email->to($this_order['customer_email']);
            $this->email->subject($subject);
            $this->email->message($body);
            // $this->email->send();
            if ($this->email->send()){
                // echo "<h4>Send Mail is Success.</h4>";
            } else {
                // echo "<h4>Send Mail is Fail.</h4>";
            }
            // End 寄信給買家
        }

        if($step=='arrive' || $step=='cancel' || $step=='void'){
            // 寄簡訊給買家
            $phone = $this_order['customer_phone'];
            $order_number = $this_order['order_number'];
            $url = 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=52414831&password=haohua&dstaddr='.$phone.'&encoding=UTF8&smbody='.get_setting_general('name').' 您的訂單 '.$order_number.' '.get_order_step($step).'。&response=http://192.168.1.200/smreply.asp';

            file_get_contents($url);
            // 寄簡訊給買家
        }

        $this->session->set_flashdata('message', '訂單更新成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('order_id'))) {
            foreach ($this->input->post('order_id') as $order_id) {
                if($this->input->post('action')=='accept'){
                    $data = array(
                        'order_step' => 'accept',
                    );
                    $this->db->where('order_id', $order_id);
                    $this->db->update('orders', $data);
                    // $this->session->set_flashdata('message', '接收訂單');
                } elseif ($this->input->post('action')=='prepare') {
                    $data = array(
                        'order_step' => 'prepare',
                    );
                    $this->db->where('order_id', $order_id);
                    $this->db->update('orders', $data);
                    // $this->session->set_flashdata('message', '餐點準備中');
                } elseif ($this->input->post('action')=='shipping') {
                    $data = array(
                        'order_step' => 'shipping',
                    );
                    $this->db->where('order_id', $order_id);
                    $this->db->update('orders', $data);
                    // $this->session->set_flashdata('message', '餐點運送中');
                } elseif ($this->input->post('action')=='arrive') {
                    $data = array(
                        'order_step' => 'arrive',
                    );
                    $this->db->where('order_id', $order_id);
                    $this->db->update('orders', $data);
                    // $this->session->set_flashdata('message', '司機抵達');
                } elseif ($this->input->post('action')=='picked') {
                    $data = array(
                        'order_step' => 'picked',
                    );
                    $this->db->where('order_id', $order_id);
                    $this->db->update('orders', $data);
                    // $this->session->set_flashdata('message', '已取餐');
                } elseif ($this->input->post('action')=='cancel') {
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
                    if($this_order['order_payment']=='line_pay' && $this_order['order_pay_status']=='paid'){
                        $this->line_pay_refund($order_id);
                    }
                    // $this->session->set_flashdata('message', '取消訂單');
                } elseif ($this->input->post('action')=='void') {
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
                    if($this_order['order_payment']=='line_pay' && $this_order['order_pay_status']=='paid'){
                        $this->line_pay_refund($order_id);
                    }
                    // $this->session->set_flashdata('message', '已退單');
                } elseif ($this->input->post('action')=='pdf') {
                    redirect( base_url() . 'admin/order/dompdf_download/'.$order_id );
                }
            }
        } else {
            $this->session->set_flashdata('message', '請選擇單據');
        }
        // redirect( base_url() . 'admin/order');
    }

    // public function delete($id)
    // {
    //     $this->db->where('order_id', $id);
    //     $this->db->delete('orders');
    //     $this->db->where('order_id', $id);
    //     $this->db->delete('order_item');

    //     redirect( base_url() . 'admin/order');
    // }

    public function line_pay_refund($order_id)
    {
        $this_order = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
        if(!empty($this_order['order_pay_feedback'])){
            // header("Location: ".base_url()."admin/order");

            $channelId     = "1605255943"; // 通路ID
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
            $successUrl = base_url().'admin/order';
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
                $refundParams = ($this_order['order_discount_total']!="") ? ['refundAmount' => (integer) $this_order['order_discount_total']] : null;
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

}