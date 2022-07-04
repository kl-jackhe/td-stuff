<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Line extends Public_Controller {

    function __construct()
    {
        parent::__construct();
        $this->config->load('ion_auth', TRUE);
        $this->identity_column = $this->config->item('identity', 'ion_auth');
    }

    public function register()
    {
        $this->data['page_title'] = '會員註冊';
        // 儲存推薦碼
        if(!empty($this->input->get('recommend_code'))){
            $data = array(
                'recommend_code' => $this->input->get('recommend_code'),
            );
            $this->session->set_userdata($data);
        }
        $this->data['message'] = '';
        $this->load->view('line/register', $this->data);
        // $this->render('auth/register');
    }

    public function edit_user()
    {
        $this->data['page_title'] = '編輯會員資料';
        $this->load->view('line/edit_user', $this->data);
        // $this->render('auth/edit_user');
    }

    public function share_register_number()
    {
        $this->data['page_title'] = '分享推薦序號';
        $this->load->view('line/share_register_number', $this->data);
        // $this->render('line/share_register_number');
    }

    public function store()
    {
        $this->data['page_title'] = '跨區美食';
        $this->load->view('line/store', $this->data);
        // $this->render('line/store');
    }

    public function freeshipping()
    {
        $this->data['page_title'] = '免運跨區美食';
        $this->load->view('line/freeshipping', $this->data);
        // $this->render('line/freeshipping');
    }

    public function my_address()
    {
        $this->data['page_title'] = '我的地址';
        $this->load->view('line/my_address', $this->data);
        // $this->render('line/my_address');
    }

    public function coupon()
    {
        $this->data['page_title'] = '優惠券';
        $this->load->view('line/coupon', $this->data);
        // $this->render('line/coupon');
    }

    public function order()
    {
        $this->data['page_title'] = '訂單';
        $this->load->view('line/order', $this->data);
        // $this->render('line/order');
    }

    public function news()
    {
        // redirect( base_url() . 'posts');
        $this->data['page_title'] = '最新消息';
        $this->load->view('line/news', $this->data);
        // $this->render('line/coupon');
    }

    public function binding()
    {
        $this->data['page_title'] = '綁定LINE ID';
        $this->render('line/binding');
    }

    public function close()
    {
        $this->load->view('line/close');
    }

    public function check_user()
    {
        $query = $this->db->select('*')
                          ->where('oauth_uid', $this->input->get('line_id'))
                          ->limit(1)
                          ->order_by('id', 'desc')
                          ->get('users');

        if ($query->num_rows() === 1)
        {
            $user = $query->row();

            $session_data = [
                'identity'             => $user->{$this->identity_column},
                $this->identity_column => $user->{$this->identity_column},
                'email'                => $user->email,
                'user_id'              => $user->id,
                'old_last_login'       => $user->last_login,
                'last_check'           => time(),
            ];

            $this->session->set_userdata($session_data);

            $line_data = array(
               'line_id' => $this->input->get('line_id'),
            );
            $this->session->set_userdata($line_data);
            // echo $url;
            echo '1';
        } else {
            echo '0';
        }
    }

    public function line_pay_test()
    {
        $channelId     = "1605255943"; // 通路ID
        $channelSecret = "b8f35d1420c340b188c3c7affb3ce65b"; // 通路密鑰
        // Get Base URL path without filename
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);
        $input = $_POST;
        // $input['isSandbox'] = (isset($input['isSandbox'])) ? true : false;
        $input['isSandbox'] = true;
        // $input['isSandbox'] = false;
        // Create LINE Pay client
        $linePay = new \yidas\linePay\Client([
            'channelId' => $channelId,
            'channelSecret' => $channelSecret,
            'isSandbox' => $input['isSandbox'],
        ]);
        // Create an order based on Reserve API parameters
        $orderParams = [
            "amount" => 5,
            "currency" => 'TWD',
            "orderId" => "SN" . date("YmdHis") . (string) substr(round(microtime(true) * 1000), -3),
            "packages" => [
                [
                    "id" => "test1",
                    "amount" => 5,
                    "name" => "包裝名稱",
                    "products" => [
                        [
                            "name" => 'Bytheway - 外送餐點',
                            "quantity" => 1,
                            "price" => 5,
                            "imageUrl" => 'https://bytheway.com.tw/assets/images/line_pay_img.jpg',
                        ],
                    ],
                ],
            ],
            "redirectUrls" => [
                "confirmUrl" => base_url()."line/line_pay_test_confirm",
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
    }

    public function line_pay_test_confirm()
    {
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
        // Redirect to successful page
        header("Location: {$successUrl}");
    }

}