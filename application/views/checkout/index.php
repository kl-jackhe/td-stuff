<?php
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

    .wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active {
        background: none;
        color: #fff;
        cursor: auto;
    }
    .wizard > .steps .disabled a, .wizard > .steps .disabled a:hover, .wizard > .steps .disabled a:active {
        background: none;
        color: #fff;
        cursor: auto;
    }
    .wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active {
        background: none;
        color: #fff;
    }

    .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active {
        background: #420452;
    }

    .wizard ul li a div p{
        background: #420452;
        border-radius: 50%;
        padding: 3px 15px 3px 15px;
    }

    .wizard .steps .row {
        justify-content: center;
        margin: 0px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .wizard_section_title {
        color: #524431;
    }
    #wizard {
        margin-bottom: 20px;
    }
    @media (max-width: 767.98px) {
        .wizard ul li a div p{
            width: 100%;
        }
    }
</style>
<div role="main" class="main">
    <section class="form-section">
        <?php $attributes = array('id' => 'checkout_form');?>
        <?php echo form_open('checkout/save_order', $attributes); ?>
        <div class="container">
            <div class="row justify-content-center" style="padding-left: 25px;padding-right: 25px;">
                <div id="wizard" class="wizard">
                    <h3>確認訂單</h3>
                    <section>
                        <h3 style="margin-top: 0px;">您共選擇 (
                        <?=$count?> 個項目 )</h3>
                        <table class="table table-hover m_table_none">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
<<<<<<< Updated upstream
                                    <th scope="col" class="text-nowrap" style="width: 100px;">圖片</th>
=======
                                    <th scope="col">圖片</th>
>>>>>>> Stashed changes
                                    <th scope="col" class="text-nowrap">商品</th>
                                </tr>
                            </thead>
                            <tbody>
<<<<<<< Updated upstream
                                <?php $i = 1;?>
                                <?php foreach ($this->cart->contents() as $items): ?>
=======
>>>>>>> Stashed changes
                                <tr style="border-top:1px solid dimgray;">
                                    <td>1</td>
                                    <td>
                                        <a href="#">
                                            <?php if($items['image']!='') { ?>
                                                <img style="width: 100%;" src="/assets/uploads/<?php echo $items['image']; ?>" alt="<?php echo $items['name']; ?>">
                                            <?php } ?>
                                        </a>
<<<<<<< Updated upstream
                                    </th>
                                    <td>
                                        <?php echo $items['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['price']; ?>
                                    </td>
                                    <td>
                                        <?php echo $items['qty']; ?>
                                    </td>
                                    <td>
                                        <span><?php echo $items['subtotal']; ?></span>
                                    </td>
                                </tr>
                                <?php $i++;?>
                                <?php endforeach;?>
                                <tr style="border-top: 1px solid dimgray;">
                                    <td colspan="4"></td>
                                    <td>總計</td>
                                    <td>
                                        <span style="color: #dd0606;font-weight: bold;"><?php echo $this->cart->total() ?></span>
                                    </td>
=======
                                    </td>
                                    <td>
                                        <p>保溫杯</p>
                                        <p>金額：$150</p>
                                        <p>數量：1</p>
                                        <p>小計：$150</p>
                                    </td>
>>>>>>> Stashed changes
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <span style="text-align:right;">購物車小計：<span style="color: #dd0606;font-weight: bold;"> $150</span></span>
                    </section>
                    <h3>付款方式</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 py-2">
                                    <h3 style="margin: 0px;">購物車小計：<span style="font-size:24px;color: red;">NT$ <?php echo $this->cart->total() ?></span></h3>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 py-2">
                                    <h3>購物須知</h3>
                                    <p>1. 目前訂單量較多，預計3-5個工作天內出貨(不含假日)。</p>
                                    <p>2. 超商取貨者，請務必確認手機號碼是否正確。</p>
                                </div>
                                <div class="col-12">
                                    <hr>
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
                                    <h3>總計：<span style="font-size:24px;color: red;">NT$ <?php echo $this->cart->total() ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>收件資訊</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="form-group row p-3 justify-content-center" style="padding-bottom:50px !important;">
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
                                <div class="input-group mb-3 col-12 col-sm-4">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">縣 / 市</label>
                                  </div>
                                  <div class="twzipcode"></div>
                                  <!-- <select class="custom-select" id="inputGroupSelect01">
                                    <option selected>選擇 縣/市</option>
                                    <option value="1">台中</option>
                                  </select> -->
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-4">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">區域</label>
                                  </div>
                                  <!-- <select class="custom-select" id="inputGroupSelect01">
                                    <option selected>選擇 區域</option>
                                    <option value="1">401 東區</option>
                                  </select> -->
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
                    <h3>訂單備註</h3>
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
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
    $('#twzipcode').twzipcode({
    // 'detect': true, // 預設值為 false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'countySel'   : '<?php if (!empty($this->input->get('county'))) {echo $this->input->get('county');} else {echo $users_address['county'];}?>',
    'districtSel' : '<?php if (!empty($this->input->get('district'))) {echo $this->input->get('district');} else {echo $users_address['district'];}?>',
    'hideCounty' : [<?php if (!empty($hide_county)) {foreach ($hide_county as $hc) {echo '"' . $hc . '",';}}?>],
    'hideDistrict': [<?php if (!empty($hide_district)) {foreach ($hide_district as $hd) {echo '"' . $hd . '",';}}?>]
});
</script>