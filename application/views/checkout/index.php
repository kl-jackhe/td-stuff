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
    /*.left-box {
        padding-bottom: 15px;
    }
    .right-box {
        position: fixed;
        top: 15%;
        right: 0px;
    }*/
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
    .fixed-bottom {
        display: none;
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
        <div class="container-fluid">
            <div class="row" style="padding-left: 25px;padding-right: 25px;">
                <div id="wizard" class="wizard">
            <h3>Keyboard</h3>
            <section>
                <p>Try the keyboard navigation by clicking arrow left or right!</p>
            </section>
            <h3>Effects</h3>
            <section>
                <p>Wonderful transition effects.</p>
            </section>
            <h3>Pager</h3>
            <section>
                <p>The next and previous buttons help you to navigate through your content.</p>
            </section>
        </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h4>優惠卷/折扣卷</h4>
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
                        <div class="col-12 col-md-6">
                            <h4>訂單資訊</h4>
                            <div class="form-group row">
                                <label for="checkout_name" class="col-12 col-sm-4 col-form-label">姓名</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control" name="checkout_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="checkout_phone" class="col-12 col-sm-4 col-form-label">聯絡電話</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control" name="checkout_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="checkout_email" class="col-12 col-sm-4 col-form-label">Email</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control" name="checkout_email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">縣市</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">郵遞區號</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">地址</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">訂單備註</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12 col-md-6">
                            <h4>配送到不同地址</h4>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">姓名</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">聯絡電話</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">縣市</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">郵遞區號</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">地址</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelLg" class="col-12 col-sm-4 col-form-label">訂單備註</label>
                                <div class="col-12 col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="background-color: #E0E0E0;">
            <div class="row py-5" style="padding-left: 25px;padding-right: 25px;">
                <div class="col-12">
                    <h4>訂單內容</h4>
                    <table class="table table-borderless table-dark" style="border-radius: 15px;">
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
      <th scope="row"><?=$i?></th>
      <td><?php echo $items['name']; ?>
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
      <td><?php echo $this->cart->format_number($items['price']); ?></td>
      <td><?php echo $this->cart->format_number($items['qty']); ?></td>
      <td><span><?php echo $this->cart->format_number($items['subtotal']); ?></span></td>
    </tr>
    <?php $i++;?>
                        <?php $subtotal = $subtotal + $this->cart->format_number($items['subtotal']);?>
                        <?php endforeach;?>
    <tr style="border-top:1px solid dimgray;">
    <td colspan="3"></td>
      <td>總計</td>
      <td><span><?=$subtotal?></span></td>
    </tr>
  </tbody>
</table>
<div class="col-12">
    <h4>配送/取貨方式</h4>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pickup" id="pickup" value="pickup" checked>
                        <label class="form-check-label" for="pickup">
                            超商取貨
                        </label>
                        <span>文字描述</span>
                        </div>
</div>
<div class="col-12">
    <h4>總計金額</h4>
    <p><?=$subtotal?></p>
    </div>
                </div>
                <div class="col-12">
                    <h4>付款方式</h4>
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
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment-method" id="payment-method3" value="option3">
                        <label class="form-check-label" for="payment-method3">
                            LINE Pay / Other Pay
                        </label>
                        <span>文字描述</span>
                    </div>
                </div>
                <div class="col-12 py-5">
                    <p>條款： 按一下按鈕送出訂單，即表示您確認已詳閱隱私政策，並且同意 龍寶嚴選 的<a href="./PrivacyPolicy.html" target="_blank">使用條款</a>。</p>
                </div>
                <div class="col-12">
                    <a href="#" type="button" id="One-click-checkout" onclick="form_check()" class="btn btn-primary w-100">下單購買</a>
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