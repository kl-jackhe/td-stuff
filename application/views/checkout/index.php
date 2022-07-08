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
    .left-box {
        padding-bottom: 15px;
    }
    .right-box {
        position: fixed;
        top: 15%;
        right: 0px;
    }
    .number-money {
        text-align: right;
    }
    .add-product {
        background-color: rgba(125,125,125,0.8);
        border-radius: 10px;
        position: absolute;
        top: 0;
        right: 15px;
    }
    .add-product a {
        color: #ffffff;
    }
    .add-product a:hover {
        text-decoration:none;
        color: #ffffff;
    }
    #products-number {
        border-radius: 25px;
    }
    .name-size p {
        font-size: 18px;
    }
    .name-size span {
        font-size: 12px;
    }
    @media (max-width: 767.98px) {
        .right-box {
            position: static;
            padding: 0px;
        }
    }
</style>
<div role="main" class="main">
    <section class="form-section">
        <div class="container-fluid-fluid">
            <div class="row">
                <form action="">
                    <div class="col-12 px-md-5 left-box">
                        <div class="row">
                            <div class="col-12">
                                <h5>優惠卷</h5>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-4 col-form-label">輸入優惠碼</label>
                                    <div class="col-8">
                                        <input type="password" class="form-control" id="inputPassword">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleFormControlSelect1" class="col-4 col-form-label">選擇優惠卷</label>
                                    <div class="col-8">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option>1</option>
                                        <option>2</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12">
                                <h5>訂單資訊</h5>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">姓名</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">聯絡電話</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">Email</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">縣市</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">郵遞區號</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">地址</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">訂單備註</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12">
                                <h5>配送到不同地址</h5>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">姓名</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">聯絡電話</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">縣市</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">郵遞區號</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">地址</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label col-form-label-lg">訂單備註</label>
                                    <div class="col-12 col-sm-8">
                                      <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 right-box">
                        <div class="row p-3" style="background-color: rgba(125,125,125,0.3);">
                            <div class="col-12 col-md-12">
                                <h5 class="py-1 mb-4">您的訂單</h5>
                                <div class="form-group row">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-7 pt-2 name-size">
                                        <h5>貼布</h5>
                                        <p>飲品份量 Size of Beverage </p>
                                        <span>中杯 Medium</span>
                                        <p>飲品溫度 Beverage Temperature</p>
                                        <span>少冰 Less Ice</span>
                                        <p>甜度 Sweetness Level</p>
                                        <span>半糖 Half Sugar</span>
                                    </div>
                                    <div class="col-3 pt-2 text-right">
                                        <h5>$55</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p>小計</p>
                            </div>
                            <div class="col-6 number-money">
                                <p>$130.00</p>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-6">
                                <h5>總計</h5>
                            </div>
                            <div class="col-6 number-money">
                                <h5>$150.00</h5>
                            </div>
                            <div class="col-12 col-md-12">
                                <h5>付款方式</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment-method" id="payment-method1" value="option1" checked>
                                    <label class="form-check-label" for="payment-method1">
                                        現金支付
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment-method" id="payment-method2" value="option2">
                                    <label class="form-check-label" for="payment-method2">
                                        信用卡
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment-method" id="payment-method3" value="option3">
                                    <label class="form-check-label" for="payment-method3">
                                        LINE Pay / Other Pay
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>條款： 按一下按鈕送出訂單，即表示您確認已詳閱隱私政策，並且同意 龍寶嚴選 的<a href="./PrivacyPolicy.html" target="_blank">使用條款</a>。</p>
                            </div>
                            <div class="col-12">
                                <a href="#" type="button" id="One-click-checkout" data-toggle="modal" data-target="#one-checkout" class="btn btn-primary w-100">下單購買</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="one-checkout" tabindex="-1" role="dialog" aria-labelledby="one-checkout-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="one-checkout-title">訂單確認中...</h5>
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="Order-number-1" style="display: none;">訂單編號：<span id="#">20210509001</span></div>
                        <div id="Order-number-2" style="display: none;">取餐方式：<span id="#">自取</span></div>
                        <div id="Order-number-3" style="display: none;">訂單金額：$<span id="#">150</span></div>
                        <div id="Order-number-4" style="display: none;">付款方式：<span id="#">現金付款</span></div>
                        <div id="Order-number-5" style="display: none;">取餐時間：<span id="#">2021/05/11/11:00</span></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" disabled=""><span class="countdown">10</span>s後自動結帳</button>
                        <a class="btn btn-secondary" id="cancel-order" href="#" data-dismiss="modal" aria-label="Close">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function getLiffUserID() {
        if (LIFF_userID != "") {
            alert(LIFF_userID);
        } else {
            console.log("等候LIFF加載...");
            setTimeout("getLiffUserID()", 300);
        }
    };

    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
        'countySel'   : '<?php if (!empty($users_address)) {echo $users_address['county'];} else {echo $this->input->get('county');}?>',
        'districtSel' : '<?php if (!empty($users_address)) {echo $users_address['district'];} else {echo $this->input->get('district');}?>',
        'hideCounty' : [<?php if (!empty($hide_county)) {foreach ($hide_county as $hc) {echo '"' . $hc . '",';}}?>],
        'hideDistrict': [<?php if (!empty($hide_district)) {foreach ($hide_district as $hd) {echo '"' . $hd . '",';}}?>]
    });
</script>