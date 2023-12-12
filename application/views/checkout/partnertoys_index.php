<?php
$count = 0;
$LogisticsSubType = '';
?>
<div role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="input-group mb-3 col-12 col-sm-8 supermarket">
            <div class="input-group-prepend">
                <span class="input-group-text">門市地址</span>
            </div>
            <input type="text" class="form-control" name="storeaddress" id="storeaddress" value="" placeholder="門市地址" readonly>
            <div style="width: 100%; margin-top: 15px;">
                <div id="app" v-if="showMap">
                    <?php
                    try {
                        require('ECPay.Logistics.Integration.php');
                        $obj = new ECPayLogistics();
                        $obj->Send = array(
                            'MerchantID' => '3382155',
                            'HashKey' => 'ZtzbR917Xc6Dn5qf',
                            'HashIV' => 'lpsDZrOpn8dxLSgM',
                            'MerchantTradeNo' => 'no' . date('YmdHis'),
                            'LogisticsType' => 'CVS',
                            'LogisticsSubType' => 'FAMIC2C',
                            'IsCollection' => IsCollection::NO,
                            'ServerReplyURL' => 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info.php',
                            'Device' => (wp_is_mobile()) ? Device::MOBILE : Device::PC
                        );
                        $html = $obj->CvsMap('選擇門市');
                        echo $html; // 將 HTML 輸出到控制台，以便檢查
                    } catch (Exception $e) {
                        echo ($e->getMessage());
                    }
                    ?>
                </div>
            </div>
            <div id="ecpStoreContainer"></div>
        </div>
        <!-- 地圖 -->
    </section>
</div>
<!-- purchase-steps -->
<script src="/assets/jquery.steps-1.1.0/jquery.steps.min.js"></script>
<!-- purchase-steps -->
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
    // 地圖
    const app = Vue.createApp({
        data() {
            return {
                showMap: false
            };
        },
        methods: {
            selectStore() {
                var selectedDelivery = $("input[name='checkout_delivery']:checked").val();

                if (selectedDelivery == 'family_pickup') {
                    // 在這裡顯示 HTML 或者執行其他相關操作
                    this.showMap = true;
                    <?php $LogisticsSubType = 'FAMIC2C'; ?>
                } else if (selectedDelivery == '711_pickup') {
                    // 在這裡顯示 HTML 或者執行其他相關操作
                    this.showMap = true;
                    <?php $LogisticsSubType = 'UNIMARTC2C'; ?>
                }
            }
        }
    });
    app.mount('#app');
</script>