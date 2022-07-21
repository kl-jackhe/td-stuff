<?php $subtotal = 0;
$count = 0;
foreach ($this->cart->contents() as $items) {
	$count++;
}?>
<style>
    select.county {
        width: 48%!important;
        float: left;
    }
    select.district {
        width: 48%!important;
        float: left;
        margin-left: 4%;
    }
    input.zipcode{
        width:33%;
        display: none;
    }
    p {
        margin: 0px;
    }
    .fixed-bottom {
        display: none;
    }
    .wizard > .content {
        overflow-y: auto;
    }
    .wizard > .actions {
        text-align: center;
    }
    .wizard > .content > .body {
        width: 100%;
        height: 100%;
    }
    .wizard > .steps .number {
        font-size: 32px;
    }
    .wizard ul, .tabcontrol ul {
        text-align: center;
    }
    .wizard > .steps a, .wizard > .steps a:hover, .wizard > .steps a:active {
        padding: 10px 10px;
        font-size: 20px;
    }
    @media (max-width: 767.98px) {
        /*.right-box {
            position: static;
            padding: 0px;
        }*/
    }
</style>
<div role="main" class="main">
    <section class="form-section">
        <?php $attributes = array('id' => 'checkout_form');?>
        <?php echo form_open('checkout/save_order?botID=' . $this->session->userdata('botID'), $attributes); ?>
        <div class="container">
            <div class="row justify-content-center" style="padding-left: 25px;padding-right: 25px;">
                <!-- <div class="col-12 text-center">
                    <p style="font-size:30px;">訂購只要四步驟</p>
                </div> -->
                <div id="wizard" class="wizard">
                    <div class=""></div>
                    <h3>確認訂單內容</h3>
                    <section>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-nowrap">商品</th>
                                    <th scope="col" class="text-nowrap">價格</th>
                                    <th scope="col" class="text-nowrap">數量</th>
                                    <th scope="col" class="text-nowrap">小計</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                <?php foreach ($this->cart->contents() as $items): ?>
                                <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                                <tr style="border-top:1px solid dimgray;">
                                    <th scope="row">
                                        <?=$i?>
                                    </th>
                                    <td>
                                        <?php echo $items['name']; ?>
                                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                        <p>
                                            <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                            <strong>
                                                <?php echo $option_name; ?>:</strong>
                                            <?php echo $option_value; ?><br />
                                            <?php endforeach;?>
                                        </p>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?php echo $this->cart->format_number($items['price']); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->cart->format_number($items['qty']); ?>
                                    </td>
                                    <td><span>
                                            <?php echo $this->cart->format_number($items['subtotal']); ?></span></td>
                                </tr>
                                <?php $i++;?>
                                <?php $subtotal = $subtotal + $this->cart->format_number($items['subtotal']);?>
                                <?php endforeach;?>
                                <tr style="border-top:1px solid dimgray;">
                                    <td colspan="3"></td>
                                    <td>總計</td>
                                    <td><span>
                                            <?=$subtotal?></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div class="dropdown text-center">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            不會訂購嗎？
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <h5>直接私訊我，也可以幫你下單哦!</h5>
                            <a class="dropdown-item btn" href="https://line.me/R/ti/p/@504bdron">請洽 LINE 客服</a>
                          </div>
                        </div> -->
                    </section>
                    <h3>選擇付款方式</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 py-2">
                                    <h3 style="margin: 0px;">購物車小計：<span style="font-size:24px;color: red;">NT$ <?=$subtotal?></span></h3>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 py-2">
                                    <h3>購物須知</h3>
                                    <p>1. 目前訂單量較多，預計3-5個工作天內出貨(不含假日)。</p>
                                    <p>2. 超商取貨者，請務必確認手機號碼是否正確。</p>
                                </div>
                                <!-- <div class="col-12">
                                    <h3>優惠卷/折扣卷</h3>
                                    <div class="row">
                                        <label for="inputPassword" class="col-3 col-form-label">輸入優惠碼</label>
                                        <div class="col-3">
                                            <input type="password" class="form-control" id="inputPassword">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="exampleFormControlSelect1" class="col-3 col-form-label">選擇優惠卷</label>
                                        <div class="col-3">
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                <option>1</option>
                                                <option>2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-12 col-md-6 py-2">
                                    <h3>運送方式</h3>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkout_payment" id="checkout_payment" value="option1" checked>
                                        <label class="form-check-label" for="checkout_payment">
                                            宅配(冷凍)(台灣本島)+150
                                        </label>
                                        <p>文字描述</p>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment-method" id="payment-method2" value="option2">
                                        <label class="form-check-label" for="payment-method2">
                                            全家(冷凍)超商取貨+150
                                        </label>
                                        <p>文字描述</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 py-2">
                                    <h3>付款方式</h3>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkout_payment" id="checkout_payment" value="option1" checked>
                                        <label class="form-check-label" for="checkout_payment">
                                            銀行匯款
                                        </label>
                                        <span>文字描述</span>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment-method" id="payment-method2" value="option2">
                                        <label class="form-check-label" for="payment-method2">
                                            信用卡
                                        </label>
                                        <span>文字描述</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3>總計：<span style="font-size:24px;color: red;">NT$ <?=$subtotal?></span></h3>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>填寫收件資料</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="form-group row p-3" style="padding-bottom:50px !important;">
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">姓名</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="範例：王小明" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">電話</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="範例：0987654321" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Email</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="範例：test@test.com.tw" required>
                                </div>
                                <div class="col-12"></div>
                                <div class="input-group mb-3 col-12 col-sm-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">縣 / 市</label>
                                  </div>
                                  <select class="custom-select" id="inputGroupSelect01">
                                    <option selected>選擇 縣/市</option>
                                    <option value="1">台中</option>
                                  </select>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">區域</label>
                                  </div>
                                  <select class="custom-select" id="inputGroupSelect01">
                                    <option selected>選擇 區域</option>
                                    <option value="1">401 東區</option>
                                  </select>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">地址</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="可不用輸入縣市及區域" required>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>其他補充資訊</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="row p-3">
                                <div class="form-group col-12">
                                    <label class="col-form-label">訂單備註</label>
                                    <textarea name="remark" style="width:100%;" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-12 py-5">
                                <p>服務條款： 按一下按鈕送出訂單，即表示您確認已詳閱隱私政策，並且同意 龍寶嚴選 的<a href="./PrivacyPolicy.html" target="_blank">使用條款</a>。</p>
                                </div>
                                <div class="col-12">
                                    <a href="#" type="button" id="One-click-checkout" onclick="form_check()" class="btn btn-primary w-100">下單購買</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?php echo form_close() ?>
    </section>
</div>
<!-- <script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script> -->
<!-- <script>
function checkout_step_1() {
    var checkout_name = $('#checkout_name').val();
    var checkout_phone = $('#checkout_phone').val();
    if (checkout_name != '' && checkout_phone != '') {
        // $('#received').removeClass('in');
        // $('#pay').addClass('in');
        $('#received').slideUp();
        $('#pay').slideDown();
        $('#step1_btn').fadeIn();
        $('#checkout_name_notice').fadeOut();
        $('#checkout_phone_notice').fadeOut();
    } else {
        $('#checkout_name_notice').fadeIn();
        $('#checkout_phone_notice').fadeIn();
    }
}

function checkout_step_2() {
    $('#received').slideDown();
    $('#pay').slideUp();
    $('#step1_btn').fadeOut();
    // $('#received').addClass('in');
    // $('#pay').removeClass('in');
}
function form_check() {
    $.ajax({
        url: "<?php echo base_url(); ?>checkout/form_check",
        method: "GET",
        data: {},
        success: function(data) {
            // if(data=='yes'){
            //     $('#checkout_form').submit();
            // } else {
            //     alert('配送時間已經超過當前時間，情重新選擇配送時間。');
            // }
            $('#checkout_form').submit();
        }
    });
}
</script> -->