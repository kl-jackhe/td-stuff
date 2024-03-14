<?php defined('BASEPATH') or exit('No direct script access allowed');

class fmtoken extends Public_Controller
{
    private $fm_token; // 全家API Token
    function __construct()
    {
        parent::__construct();

        // Check全家API生命週期
        $now_time = time() + 60; // 获取未来1分钟后时间的时间戳
        $tmp_token = $this->session->userdata('fm_token');
        $tmp_token_life = $this->session->userdata('fm_token_life');
        // $tmp_token = '';
        // $tmp_token_life = 0;
        if (empty($tmp_token) || empty($tmp_token_life) || $now_time >= $tmp_token_life) {
            $this->fm_token = '';
        } else {
            $this->fm_token = $tmp_token;
        }
    }

    // 取得全家API_TOKEN
    public function get_ecb_token()
    {

        if (!empty($this->fm_token)) {
            return $this->fm_token;
        }

        $API_ID = get_setting_general('FM_API_ID');
        $API_KEY = get_setting_general('FM_API_KEY');

        $url = 'https://ecbypass.com.tw/api/v2/token/authorize.php';

        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic " . base64_encode($API_ID . ':' . $API_KEY)
        );

        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", $header),
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);


        if ($res === FALSE) {
            // 處理錯誤
            echo "Error: Unable to fetch data.";
        } else {
            // 解析 JSON
            $data = json_decode($res, true);

            // 檢查 JSON 解析是否成功
            if (json_last_error() === JSON_ERROR_NONE) {
                // 檢查 API 回應
                if (isset($data['response']) && $data['response'] === 'success') {
                    // update token and token_life
                    $this->session->set_userdata('fm_token', $data['data']['access_token']);
                    $this->session->set_userdata('fm_token_life', $data['data']['expires_in']);
                    // echo '<pre>';
                    // print_r($data);
                    // echo '</pre>';
                    return $data['data']['access_token'];
                } else {
                    // 處理 API 錯誤回應
                    echo 'API Error: ' . (isset($data['error']) ? $data['error'] : 'Unknown error');
                    // 顯示完整的 API 回應
                    // echo '<pre>';
                    // print_r($data);
                    // echo '</pre>';
                    return false;
                }
            } else {
                // 處理 JSON 解析錯誤
                echo 'JSON Error: ' . json_last_error_msg();
                return false;
            }
        }
    }

    // 取得全家地圖
    public function fm_map($freeze = false, $size = '')
    {
        $url = 'https://ecbypass.com.tw/api/v2/Map/index.php?MapReplyURL=' . base_url() . '/checkout/fm_store_info&freeze=false';
        if ($freeze) {
            $url = 'https://ecbypass.com.tw/api/v2/Map/index.php?MapReplyURL=' . base_url() . '/checkout/fm_store_info&freeze=' . $freeze . '&size=' . $size;
        }

        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer " . $this->get_ecb_token()
        );

        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", $header),
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            echo ($res);
        }
    }

    // FM B2C create order
    public function fm_add_b2c_order($type, $id)
    {
        // order information
        $order_info = $this->mysql_model->_select('orders', 'order_id', $id, 'row');

        if (empty($order_info)) {
            return false;
        }

        $data = array();

        if ($type == 'normal') {
            // Call API Link
            $url = 'https://ecbypass.com.tw/api/v2/B2C/AddOrder/index.php';
            // 准备要发送的数据
            $data = array(
                'Data' => array(
                    array(
                        'EshopIdOrderNo' => $order_info['order_number'],
                        'OrderDate' => date('Y-m-d H:i:s'),
                        'OrderAmount' => $order_info['order_discount_total'],
                        'ServiceType' => 2,
                        'ReceiverName' => $order_info['customer_name'],
                        'ReceiverPhone' => $order_info['customer_phone'],
                        'ReceiverStoreID' => $order_info['store_id'],
                        'Remark' => $order_info['order_remark']
                    ),
                )
            );
        } elseif ($type == 'cold') {
            // Call API Link
            $url = 'https://ecbypass.com.tw/api/v2/B2C/AddColdOrder/index.php';
            // 准备要发送的数据
            $data = array(
                'Data' => array(
                    array(
                        'EshopIdOrderNo' => $order_info['order_number'],
                        'OrderDate' => date('Y-m-d H:i:s'),
                        'BageSize' => ((float)$order_info['order_weight'] >= 5.000) ? 'S105' : 'S60',
                        'ShippDate' => date('Y-m-d', strtotime('+5 days')),
                        'OrderAmount' => $order_info['order_discount_total'],
                        'ServiceType' => 2,
                        'ReceiverName' => $order_info['customer_name'],
                        'ReceiverPhone' => $order_info['customer_phone'],
                        'ReceiverStoreID' => $order_info['store_id'],
                        'Remark' => $order_info['order_remark']
                    ),
                )
            );
        }

        // 将数据编码为 JSON 格式
        $json_data = json_encode($data);

        // 准备请求头
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->get_ecb_token(),
        );

        // 设置请求选项
        $options = array(
            'http' => array(
                'method' => 'POST', // 使用 POST 方法发送数据
                'header' => implode("\r\n", $header),
                'content' => $json_data, // 将 JSON 数据放在请求主体中
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            $res = json_decode($res, true);
            // echo '<pre>';
            // print_r($res);
            // echo '</pre>';
            if (!empty($res['result'][$order_info['order_number']]['ecno'])) {
                $update_data = array(
                    'fm_ecno' => $res['result'][$order_info['order_number']]['ecno'],
                    'fm_type' => 'b2c',
                    'fm_cold' => ($type == 'cold') ? 1 : 0,
                );
                $this->db->where('order_id', $id);
                $this->db->update('orders', $update_data);

                echo "<script>alert('success');window.history.back()</script>";
                return true;
            } else {
                echo "<script>alert('error');window.history.back()</script>";
                return false;
            }
        }
    }

    // FM C2C create order
    public function fm_add_c2c_order($type, $id)
    {
        // order information
        $order_info = $this->mysql_model->_select('orders', 'order_id', $id, 'row');

        if (empty($order_info)) {
            return false;
        }

        $data = array();

        if ($type == 'normal') {
            // Call API Link
            $url = 'https://ecbypass.com.tw/api/v2/C2C/AddOrder/index.php';
            // 准备要发送的数据
            $data = array(
                'Data' => array(
                    array(
                        'EshopIdOrderNo' => $order_info['order_number'],
                        'OrderDate' => date('Y-m-d H:i:s'),
                        'OrderAmount' => $order_info['order_discount_total'],
                        'ServiceType' => 2,
                        'ReceiverName' => $order_info['customer_name'],
                        'ReceiverPhone' => $order_info['customer_phone'],
                        'ReceiverStoreID' => $order_info['store_id'],
                        'Remark' => $order_info['order_remark']
                    ),
                )
            );
        } elseif ($type == 'cold') {
            // Call API Link
            $url = 'https://ecbypass.com.tw/api/v2/C2C/AddColdOrder/index.php';
            // 准备要发送的数据
            $data = array(
                'Data' => array(
                    array(
                        'EshopIdOrderNo' => $order_info['order_number'],
                        'OrderDate' => date('Y-m-d H:i:s'),
                        'BageSize' => ((float)$order_info['order_weight'] >= 5.000) ? 'S105' : 'S60',
                        'ShippDate' => date('Y-m-d', strtotime('+5 days')),
                        'OrderAmount' => $order_info['order_discount_total'],
                        'ServiceType' => 2,
                        'ReceiverName' => $order_info['customer_name'],
                        'ReceiverPhone' => $order_info['customer_phone'],
                        'ReceiverStoreID' => $order_info['store_id'],
                        'Remark' => $order_info['order_remark'],
                        'ReservedNo' => $order_info['order_store_ReservedNo'],
                    ),
                )
            );
        }

        // 将数据编码为 JSON 格式
        $json_data = json_encode($data);

        // 准备请求头
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->get_ecb_token(),
        );

        // 设置请求选项
        $options = array(
            'http' => array(
                'method' => 'POST', // 使用 POST 方法发送数据
                'header' => implode("\r\n", $header),
                'content' => $json_data, // 将 JSON 数据放在请求主体中
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            $res = json_decode($res, true);
            // echo '<pre>';
            // print_r($res);
            // echo '</pre>';
            if (!empty($res['result'][$order_info['order_number']]['ecno'])) {
                $update_data = array(
                    'fm_ecno' => $res['result'][$order_info['order_number']]['ecno'],
                    'fm_type' => 'c2c',
                    'fm_cold' => ($type == 'cold') ? 1 : 0,
                );
                $this->db->where('order_id', $id);
                $this->db->update('orders', $update_data);

                echo "<script>alert('success');window.history.back()</script>";
                return true;
            } else {
                echo "<script>alert('error');window.history.back()</script>";
                return false;
            }
        }
    }

    // Get FM B2C logistic
    public function fm_b2c_logistic($fm_ecno)
    {
        $url = 'https://ecbypass.com.tw/api/v2/B2C/Logistic/index.php';

        // 准备要发送的数据
        $data = array(
            'Data' => array($fm_ecno),
        );

        // 将数据编码为 JSON 格式
        $json_data = json_encode($data);

        // 准备请求头
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->get_ecb_token(),
        );

        // 设置请求选项
        $options = array(
            'http' => array(
                'method' => 'POST', // 使用 POST 方法发送数据
                'header' => implode("\r\n", $header),
                'content' => $json_data, // 将 JSON 数据放在请求主体中
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            $res = json_decode($res, true);
            echo '<pre>';
            print_r($options);
            echo '</pre>';
            echo '<pre>';
            print_r($res);
            echo '</pre>';
            if ($res['response'] == "success") {
                if ($res['result'][$fm_ecno]['status'] == "success") {
                    $update_data = array(
                        'AllPayLogisticsID' => $res['result'][$fm_ecno]['logistics'],
                    );
                    $this->db->where('fm_ecno', $fm_ecno);
                    $this->db->update('orders', $update_data);
                }
                // echo "<script>alert('success');window.history.back()</script>";
                return true;
            } else {
                // echo "<script>alert('error');window.history.back()</script>";
                return false;
            }
        } else {
            echo '<pre>';
            print_r($res);
            echo '</pre>';
            echo "<script>alert('error, no response.');window.history.back()</script>";
            return false;
        }
    }

    // Get FM C2C logistic
    public function fm_c2c_logistic($fm_ecno)
    {
        $url = 'https://ecbypass.com.tw/api/v2/C2C/Logistic/index.php';

        // 准备要发送的数据
        $data = array(
            'Data' => array($fm_ecno),
        );

        // 将数据编码为 JSON 格式
        $json_data = json_encode($data);

        // 准备请求头
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->get_ecb_token(),
        );

        // 设置请求选项
        $options = array(
            'http' => array(
                'method' => 'POST', // 使用 POST 方法发送数据
                'header' => implode("\r\n", $header),
                'content' => $json_data, // 将 JSON 数据放在请求主体中
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            $res = json_decode($res, true);
            echo '<pre>';
            print_r($options);
            echo '</pre>';
            echo '<pre>';
            print_r($res);
            echo '</pre>';
            if ($res['response'] == "success") {
                if ($res['result'][$fm_ecno]['status'] == "success") {
                    $update_data = array(
                        'AllPayLogisticsID' => $res['result'][$fm_ecno]['logistics'],
                    );
                    $this->db->where('fm_ecno', $fm_ecno);
                    $this->db->update('orders', $update_data);
                }
                // echo "<script>alert('success');window.history.back()</script>";
                return true;
            } else {
                // echo "<script>alert('error');window.history.back()</script>";
                return false;
            }
        } else {
            echo "<script>alert('error, no response.');window.history.back()</script>";
            return false;
        }
    }

    // Print FM B2C logistic
    public function fm_b2c_print($fm_ecno)
    {
        $url = 'https://ecbypass.com.tw/api/v2/B2C/Logistic/print.php';

        // 准备要发送的数据
        $data = array(
            'Data' => [$fm_ecno],
        );

        // 将数据编码为 JSON 格式
        $json_data = json_encode($data);

        // 准备请求头
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->get_ecb_token(),
        );

        // 设置请求选项
        $options = array(
            'http' => array(
                'method' => 'POST', // 使用 POST 方法发送数据
                'header' => implode("\r\n", $header),
                'content' => $json_data, // 将 JSON 数据放在请求主体中
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            // $res = json_decode($res, true);
            echo '<pre>';
            print_r($res);
            echo '</pre>';
        } else {
            echo '<pre>';
            print_r($res);
            echo '</pre>';
            echo "<script>alert('error, no response.');window.history.back()</script>";
            return false;
        }
    }

    // Print FM C2C logistic
    public function fm_c2c_print($fm_ecno)
    {
        $url = 'https://ecbypass.com.tw/api/v2/C2C/Logistic/print.php';

        // 准备要发送的数据
        $data = array(
            'Data' => [$fm_ecno],
        );

        // 将数据编码为 JSON 格式
        $json_data = json_encode($data);

        // 准备请求头
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->get_ecb_token(),
        );

        // 设置请求选项
        $options = array(
            'http' => array(
                'method' => 'POST', // 使用 POST 方法发送数据
                'header' => implode("\r\n", $header),
                'content' => $json_data, // 将 JSON 数据放在请求主体中
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );

        $context = stream_context_create($options);

        $res = @file_get_contents($url, false, $context);

        if (!empty($res)) {
            // $res = json_decode($res, true);
            echo '<pre>';
            print_r($res);
            echo '</pre>';
        } else {
            echo '<pre>';
            print_r($res);
            echo '</pre>';
            echo "<script>alert('error, no response.');window.history.back()</script>";
            return false;
        }
    }
}
