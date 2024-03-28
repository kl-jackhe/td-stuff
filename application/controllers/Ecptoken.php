<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ecptoken extends Public_Controller
{
    private $aesKey;
    private $aesIv;

    function __construct()
    {
        parent::__construct();
        $this->load->model('checkout_model');
        $this->load->library('ecpay_payment');
        $this->load->library('ecpay_invoices');
        $this->load->library('ecpay_logistics');

        // Check if aesKey and aesIv are already set in flashdata(userdata)
        if (!$this->session->userdata('aesKey') || !$this->session->userdata('aesIv')) {
            // If not set, generate new random values
            $this->aesKey = openssl_random_pseudo_bytes(32); // 256 bits (32 bytes) key
            $this->aesIv = openssl_random_pseudo_bytes(16);  // 128 bits (16 bytes) IV

            // Save them in flashdata(userdata)
            $this->session->set_userdata('aesKey', $this->aesKey);
            $this->session->set_userdata('aesIv', $this->aesIv);
        } else {
            // If already set, retrieve them from flashdata(userdata)
            $this->aesKey = $this->session->userdata('aesKey');
            $this->aesIv = $this->session->userdata('aesIv');
        }
    }
    function ecp_add_order($order_id)
    {
        $LogisticsSubType = null;
        $row = $this->mysql_model->_select('orders', 'order_id', $order_id, 'row');
        if (!empty($row)) {
            // 託運單
            try {
                // 載入綠界託運API
                $obj = $this->ecpay_logistics->load();
                $ECPay = $this->checkout_model->getECPay();

                if ($ECPay['payment_status'] == 1) :
                    // 服務參數 (正式環境)
                    $obj->Send['MerchantID'] = $ECPay['MerchantID'];
                    $obj->HashKey = $ECPay['HashKey'];
                    $obj->HashIV = $ECPay['HashIV'];
                else :
                    // 服務參數 (測試環境)
                    $obj->Send['MerchantID'] = '2000132';
                    $obj->HashKey = '5294y06JbISpM5x9';
                    $obj->HashIV = 'v77hoKGq4kWxNNIS';
                endif;

                if ($row['order_delivery'] == "711_pickup") {
                    $LogisticsSubType = LogisticsSubType::UNIMART_C2C;
                } elseif ($row['order_delivery'] == "family_pickup") {
                    $LogisticsSubType = LogisticsSubType::FAMILY_C2C;
                } elseif ($row['order_delivery'] == "hi_life_pickup") {
                    $LogisticsSubType = LogisticsSubType::HILIFE_C2C;
                }

                //基本參數(請依系統規劃自行調整)
                $MerchantTradeNo = $row['order_number'] . substr(time(), 4, 6);
                if (strlen($MerchantTradeNo) > 20) {
                    $MerchantTradeNo = $row['order_number'] . substr(time(), 6, 4);
                }
                if (!empty($row['MerchantTradeNo'])) {
                    $obj->Send['MerchantTradeNo'] = $row['MerchantTradeNo']; //綠界訂單編號
                } else {
                    $obj->Send['MerchantTradeNo'] = $MerchantTradeNo; //綠界訂單編號
                }
                $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); // 物流單生成時間
                $obj->Send['LogisticsType'] = LogisticsType::CVS; // 超商物流選擇
                $obj->Send['LogisticsSubType'] = $LogisticsSubType; // 超商選擇
                $obj->Send['GoodsAmount'] = (int)$row['order_discount_total']; // 商品總價
                $obj->Send['GoodsName'] = 'Cargo'; // 商品名稱
                $obj->Send['SenderName'] = get_setting_general('short_name'); // 電商名稱
                $obj->Send['SenderPhone'] = get_setting_general('phone1'); // 電商電話
                $obj->Send['SenderCellPhone'] = get_setting_general('cellphone1'); // 電商手機
                $obj->Send['ReceiverName'] = $row['customer_name'];
                $obj->Send['ReceiverPhone'] = '';
                $obj->Send['ReceiverCellPhone'] = $row['customer_phone'];
                $obj->Send['ReceiverEmail'] = '';
                $obj->Send['TradeDesc'] = '';
                $obj->Send['ServerReplyURL'] = base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv); // 訂單ID加密
                $obj->Send['ClientReplyURL'] = '';
                $obj->Send['LogisticsC2CReplyURL'] = base_url() . 'checkout/success/' . $this->aesEncrypt($order_id, $this->aesKey, $this->aesIv); // 訂單ID加密
                $obj->Send['Remark'] = '';
                $obj->PostParams['ReceiverStoreID'] = $row['store_id'];
                // $obj->SendExtend['ReturnStoreID'] = $row['store_id'];

                // 送出(記得這邊API要改動不然有BUG)
                $response = $obj->BGCreateShippingOrder($row['store_id']);

                if ($response['ResCode'] == '1') {
                    // print_r($response['AllPayLogisticsID']);
                    // print_r($response['CVSPaymentNo']);check_pay
                    $data = array(
                        'AllPayLogisticsID' => get_empty($response['AllPayLogisticsID']),
                        'CVSPaymentNo' => get_empty($response['CVSPaymentNo']),
                    );
                    if (empty($row['MerchantTradeNo'])) {
                        $data['MerchantTradeNo'] = $MerchantTradeNo; //綠界訂單編號
                    }
                    $this->db->where('order_id', $order_id);
                    $this->db->update('orders', $data);
                }

                // 檢查託運單資料
                // echo '<pre>';
                // print_r($response);
                // echo '</pre>';

                echo "<script>alert('" . json_encode($response) . "');window.history.back();</script>";
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    function aesEncrypt($data, $key, $iv)
    {
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted);
    }

    function aesDecrypt($data, $key, $iv)
    {
        $decrypted = openssl_decrypt(base64_decode($data), 'aes-256-cbc', $key, 0, $iv);
        return $decrypted;
    }
}
