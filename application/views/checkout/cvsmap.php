    <?php
    $storeType = null;
    $device = $this->input->get('device');
    $checkout = $this->input->get('checkout');
    // 選完門市後導向(手機與PC導向不同)
    $excuteUrl = ($device != 'mobile') ? 'get_store_info.php' : 'get_store_info_location.php';
    $returnUrl = base_url() . $excuteUrl;
    try {
        if ($checkout == "711_pickup") {
            $storeType = LogisticsSubType::UNIMART_C2C;
        } elseif ($checkout == "family_pickup") {
            $storeType = LogisticsSubType::FAMILY_C2C;
        } elseif ($checkout == "hi_life_pickup") {
            $storeType = LogisticsSubType::HILIFE_C2C;
        }
        $deviceType = ($device != 'mobile') ? Device::PC : Device::MOBILE;
        // controller有引入ECPay.Logistics.Integration並new物件回傳至obj
        $obj->Send = array(
            'MerchantID' => '3382155',
            'HashKey' => 'ZtzbR917Xc6Dn5qf',
            'HashIV' => 'lpsDZrOpn8dxLSgM',
            'MerchantTradeNo' => 'no' . date('YmdHis'),
            'LogisticsSubType' => $storeType,
            'IsCollection' => IsCollection::NO,
            'ServerReplyURL' => $returnUrl,
            // 'ExtraData' => '測試額外資訊',
            'Device' => $deviceType
            // 'MerchantID' => '5294y06JbISpM5x9',                                            //廠商編號(由Ecpay 提供)
            // 'HashKey' => 'v77hoKGq4kWxNNIS',
            // 'HashIV' => '2000132',
            // 'MerchantTradeNo' => "TNO" . time(),                    //廠商交易編號, 自定不可重複，須與物流訂單交易編號相同，查單或檢查碼會用到
            // 'LogisticsType' => 'CVS',            //物流類型

            //當物流類型為 CVS 時，子物流類型選擇以下類型
            //---B2C---
            //FAMI：全家
            //UNIMART：統一超商
            //HILIFE：萊爾富
            //---C2C---
            //FAMIC2C：全家店到店
            //UNIMARTC2C：統一超商交貨便
            //HILIFEC2C:萊爾富店到店
            // 'LogisticsSubType' => 'UNIMART',		//統一超商

            // 'LogisticsSubType' => $_GET["sn"],        //統一超商

            //'LogisticsSubType' => LogisticsSubType::UNIMART,

            // 'IsCollection' => 'N',        //是否代收貨款	是 (Y) / 否 (N)
            //'IsCollection' => IsCollection::NO,	

            //選完商店後會將頁面導到指定的網址
            // 'ServerReplyURL' => $ServerReplyURL,

            //額外資訊
            //供廠商傳遞保留的資訊，在回傳參數中，會回到Server 端回覆網址時原值回傳。?a=1
            // 'ExtraData' => 'test1234',

            //使用設備	根據 Device 類型，來顯示相對應之電子地圖。0：PC（預設值）1：Mobile
            // 'Device' => '0'
            //'Device' => Device::PC
        );
        // 製作綠界地圖網頁
        $html = $obj->CvsMap('電子地圖');
        echo "<p>&nbsp;</p>";
        echo '<div id="hiddenContainer" style="display: none;">' . $html . '</div>';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script>
        // 一進網頁就自動按按鈕
        $(document).ready(function() {
            // 找到按鈕元素並模擬點擊事件
            var button = $('#__paymentButton');
            if (button.length) {
                button.click();
            }
        });
    </script>