<?php $subtotal = 0;
$count = 0;
foreach ($this->cart->contents() as $items) {
	$count++;
}?>
<style>
    label.error {
        color: red;
        font-weight: bold;
        font-size: 85%;
    }
</style>
<div role="main" class="main pt-signinfo">
    <section class="form-section">
        <div class="container">
            <div class="box mt-md">
                <div class="col-md-12">
                    <h3 class="fs-18 color-595757">Hi <?php echo $this->ion_auth->user()->row()->full_name ?></h3>
                </div>
                <div class="col-md-7" style="margin-bottom: 30px;">
                    <?php $attributes = array('id' => 'checkout_form');?>
                    <?php echo form_open('store/save_order?botID=' . $this->session->userdata('botID'), $attributes); ?>
                    <div class="form-content" style="border: 3px solid #DCDEDD; border-radius: 8px; padding: 22px 15px;">
                        <div id="pay">
                            <h3 class="pb-md fs-16 color-595757 bold">1. 收件人資訊</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fs-13 color-595757">收件人姓名*</label>
                                        <input type="text" class="form-control" id="checkout_name" name="checkout_name" required value="<?php echo $this->ion_auth->user()->row()->full_name ?>">
                                        <small id="checkout_name_notice" style="color: red; font-weight: bold; display: none;">請輸入收件人姓名</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fs-13 color-595757">收件人電話*</label>
                                        <input type="text" class="form-control" id="checkout_phone" name="checkout_phone" required value="<?php echo $this->ion_auth->user()->row()->phone ?>">
                                        <small id="checkout_phone_notice" style="color: red; font-weight: bold; display: none;">請輸入收件人電話</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fs-13 color-595757">備註<span>（想對BTW說）</span></label>
                                        <textarea type="text" class="form-control" id="checkout_remark" name="checkout_remark" rows="3" maxlength="20"></textarea>
                                    </div>
                                </div>
                            </div>
                            <h3 class="pb-md fs-16 color-595757 bold">2. 付款</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fs-13 color-595757">帳單寄送方式</label>
                                        <input type="text" class="form-control" name="checkout_email" id="checkout_email" placeholder="0101010101@test.com" required value="<?php echo $this->ion_auth->user()->row()->email ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-lg">
                                    <label class="fs-13 color-595757">付款方式</label>
                                    <select name="checkout_payment" id="checkout_payment" class="form-control">
                                        <option value="cash_on_delivery">餐到付款</option>
                                        <option value="credit">信用卡</option>
                                        <option value="line_pay">Line Pay</option>
                                        <!-- <option value="aftee_pay">Aftee Pay</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-lg">
                                    <div class="form-group">
                                        <label class="checkbox-inline fs-13 color-595757 bold">
                                            <input type="checkbox" id="checkout_agree" name="checkout_agree" required> 我同意<a href="/about/rule" class="use-modal-btn">網站服務條款</a>及<a href="/about/privacy_policy" class="use-modal-btn">隱私政策</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-6">
                                    <!-- <button type="submit" class="btn btn-info btn-block">付款去</button> -->
                                    <span class="btn btn-info btn-block" onclick="form_check()">付款去</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="col-md-5">
                    <div class="checkout-list" style="box-shadow: none; border: none;">
                        <div class="row">
                            <div class="col-md-12" style="box-shadow: 3px 3px 10px 0px grey; padding: 30px; border-left: none;">
                                <!-- <div style="padding: 10px 15px; background: #03B4C6; color: white;">
                                    <h4 class="fs-20 color-white bold nopadding">預估取餐時間</h4>
                                    <h4 class="fs-13 color-white bold nopadding"><?php echo $this->session->userdata('delivery_date') ?> 12:30</h4>
                                </div> -->
                                <table class="table table-bordered">
                                    <tbody id="cart_details">

                                    </tbody>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">使用優惠券</h4>
                                                <h5 class="fs-13"><?php echo get_coupon_name($this->session->userdata('coupon_id')) ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">取餐地點</h4>
                                                <h5 class="fs-13"><?php echo $this->session->userdata('delivery_place') ?></h5>
                                                <!-- <h5 class="fs-13"><?php echo get_delivery_place_name($this->session->userdata('delivery_place')) ?></h5> -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">取餐日期</h4>
                                                <h5 class="fs-13"><?php echo $this->session->userdata('delivery_date') ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">取餐時間</h4>
                                                <h5 class="fs-13"><?php echo $this->session->userdata('delivery_time') ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <ul id="load_cart_price" style="border: none;">

                                </ul>
                                <ul style="border: none;">
                                    <li>
                                        <span class="btn btn-block mt-md" style="border: 1px solid #00BFD5; color: #00BFD5;" onclick="history.back()">修改訂單</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#cart_details').load("<?php echo base_url(); ?>store/load_cart_no_remove");
        $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
        $(document).on('click', '.remove_item', function() {
            var rowid = this.id;
            $.ajax({
                url: "<?php echo base_url(); ?>cart/remove",
                method: "POST",
                data: { rowid: rowid },
                success: function(data) {
                    $('#cart_details').load("<?php echo base_url(); ?>store/load_cart");
                    $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
                }
            });
        });
    });

    function checkout_step_1() {
        var checkout_name = $('#checkout_name').val();
        var checkout_phone = $('#checkout_phone').val();
        if(checkout_name!='' && checkout_phone!='') {
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
            url: "<?php echo base_url(); ?>store/form_check",
            method: "GET",
            data: { },
            success: function(data) {
                if(data=='yes'){
                    $('#checkout_form').submit();
                } else {
                    alert('配送時間已經超過當前時間，情重新選擇配送時間。');
                }
            }
        });
    }
</script>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("checkout_form").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  // validate signup form on keyup and submit
  $("#checkout_form").validate({
      rules: {
          sms_code: {
              required: true,
              equalTo: "#code_num"
          },
          checkout_agree: "required",
          checkout_email: "required",
          topic: "required"
      },
      messages: {
          sms_code: {
              required: "請輸入驗證碼。",
              equalTo: "驗證碼不正確！"
          },
          checkout_agree: "請勾選。",
          checkout_email: "請輸入電子郵件。",
          topic: "Please select at least 2 topics"
      }
  });
});
</script>