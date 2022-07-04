<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>後支付</title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css?v=3.3.7">
    <!-- 測試環境 -->
    <script src="https://ct-auth.np-pay.com/v1/aftee.js"></script>
    <!-- 正式環境 -->
    <!-- <script src="https://auth.aftee.tw/v1/aftee.js"></script> -->
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4" style="padding-top: 30px;">
                <button class="btn btn-primary btn-block" id="np-button">前往付款</button>
                <div id="aaa"></div>
                <div id="bbb"></div>
                <div id="ccc"></div>
                <div id="ddd"></div>
                <div id="message" style="display: none;">
                    <img src="/assets/images/loading.gif" id="loading" style="height: 25px;">
                    <span>處理中，請稍候，請勿關閉此視窗。</span>
                </div>
            </div>
        </div>
    </div>
    <script>
    // ⽀付⽤Javascript object data（JSON）
    var data = {
        "amount": <?php echo $order_total; ?>, // 付款⾦額:必填
        "shop_transaction_no": "<?php echo $order_number; ?>", // 店舖交易ID:必填
        "user_no": "mcc00044-00001", // 商家會員ID:選填
        // "user_no": "shop-user-no-001", // 商家會員ID:選填
        "sales_settled": true, // 交易確認
        // "transaction_options": [3], //交易選項
        "description_trans": "", //店舖交易備註:選填
        "checksum": "<?php echo $checksum; ?>", // 驗證碼
        "customer": { // :必填
            "customer_name": "<?php echo $customer_name; ?>",
            "customer_family_name": "",
            "customer_given_name": "",
            "phone_number": "<?php echo $customer_phone; ?>",
            "birthday": "",
            "sex_division": "",
            "company_name": "",
            "department": "",
            "zip_code": "",
            "address": "<?php echo $customer_address; ?>",
            "email": "<?php echo $customer_email; ?>",
            "total_purchase_count": "",
            "total_purchase_amount": "",
        },
        "dest_customers": [{ // 商品提供者
            "dest_customer_name": "",
            "dest_company_name": "",
            "dest_department": "",
            "dest_zip_code": "",
            "dest_address": "",
            "dest_tel": "",
            "dest_email": ""
        }],
        "items": [ // 商品明細
            <?php if ($cart = $this->cart->contents()){ foreach ($cart as $item){ ?>
            {
                "shop_item_id": "<?php echo $item['id'] ?>", // 店舖商品ID: 必填
                "item_name": "<?php echo get_product_name($item['id']) ?>", // 商品名稱: 必填
                "item_price": <?php echo $item['price'] ?>, // 商品單價:必填
                "item_count": <?php echo $item['qty'] ?>, // 個數: 必填
                // "item_url": "<?php // echo base_url().'store/product/'.$item['id'] ?>" // 商品URL: 必填
            },
            <?php }} ?>
            <?php if (isset($delivery_cost) && $delivery_cost > 0) { ?>
            {
                "shop_item_id": "99999", // 店舖商品ID: 必填
                "item_name": "運費", // 商品名稱: 必填
                "item_price": <?php echo $delivery_cost ?>, // 商品單價:必填
                "item_count": 1, // 個數: 必填
            },
            <?php } ?>
        ]
    }
    Aftee.config({
        // 預設
        // pub_key: "7jqf-uzmxDnJoOwpw8smUQ",
        // pre_token: "W2yAg_sHhOUbNdXTafe_f23B",
        // 測試
        pub_key: "erq8fDKgGIaWyB04tIswog",
        // pre_token: "HFvym3WHI169nh5TjhrxLA",
        payment: data,
        // 認證完成同時、亦或會員註冊完成同時呼叫
        authenticated: function(authentication_token, user_no) {
            // 設定callback
            // alert('驗證完成');
            // document.getElementById("aaa").innerHTML = 'authentication_token: '+authentication_token;
            // document.getElementById("bbb").innerHTML = 'user_no: '+user_no;
        },
        // 付款popup畫⾯關閉同時呼叫
        cancelled: function() {
            // 設定callback
            alert('取消付款');
        },
        // 審查結果NG後、按下關閉認證表格按鍵同時呼叫
        failed: function(response) {
            // 設定callback
            alert('failed');
        },
        // 審查結果OK後⾃動關閉認證表格同時呼叫
        succeeded: function(response) {
            // 設定callback
            // alert('succeeded');
            // document.getElementById("ccc").innerHTML = 'succeeded: '+response['id'];
            // document.getElementById("ddd").innerHTML = 'succeeded: '+response['authorization_result'];
            if(response['authorization_result']==1){
                // $('#message').show();
                document.getElementById("np-button").style.display="none";
                document.getElementById("message").style.display="block";
                window.location = '<?php echo base_url() ?>store/after_pay_confirm?order_number=<?php echo $order_number; ?>';
                // var order_number = <?php echo $order_number; ?>;
                // $.ajax({
                //     url: "<?php echo base_url(); ?>store/after_pay_confirm",
                //     method: "POST",
                //     data: { order_number: order_number },
                //     success: function(data) {
                //         // alert(data);
                //         window.location = '<?php echo base_url() ?>store/after_pay_success/'+data;
                //         // if(data==1){
                //             // alert('ok');
                //         // }
                //     }
                // });
            }
        },
        // 發⽣錯誤時呼叫
        error: function(name, message, errors) {
            // 設定callback
            alert('error');
        }
    });
    var button = document.getElementById("np-button");
    button.addEventListener("click", function(e) {
        Aftee.start(); // 點擊時顯⽰popup畫⾯
    }, false)
    // $(document).ready(function() {
    //     Aftee.start(); // 顯⽰popup畫⾯
    // });
    </script>
    <!-- <script src="/node_modules/jquery/dist/jquery.min.js"></script> -->
</body>

</html>