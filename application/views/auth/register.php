<div role="main" class="main pt-xlg-main">
    <section>
        <div class="container">
            <div class="box mt-md">
                <div class="row justify-content-center">
                    <div class="col-md-6 my-5" style="box-shadow: 6px 6px 20px grey; padding: 30px 60px;">
                        <?php $attributes = array('id' => 'register');?>
                        <?php echo form_open('register', $attributes); ?>
                        <div class="form-content">
                            <div class="form-group">
                              <a href="/login">←返回登入</a>
                              <?php echo $message; ?>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-6">
                                    <h4>行動電話</h4>
                                    <div class="form-group">
                                      <div class="input-group">
                                          <input type="number" class="form-control" id="identity" name="identity" placeholder="09xxxxxxxx" required>
                                          <span class="input-group-addon" id="getrandombtn" onclick="random_number(this.id)" style="background: #3bccde; color: white; cursor: pointer;">傳送</span>
                                      </div>
                                      <small>以行動電話作為登入帳號</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4>驗證碼</h4>
                                    <div class="form-group">
                                      <div class="input-group">
                                          <input type="number" class="form-control" id="sms_code" name="sms_code" placeholder="請輸入驗證碼" onchange="check_identity_code()" required>
                                          <input type="hidden" class="form-control" name="code_num" id="code_num">
                                          <span class="input-group-addon" id="getrandombtn" onclick="check_identity_code()" style="background: #3bccde; color: white; cursor: pointer;">驗證</span>
                                      </div>
                                      <small id="sms_code_text"></small>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <h4>姓名</h4>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="請輸入姓名" required>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <h4>電子信箱</h4>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="請輸入E-Mail" onchange="check_email()" required>
                                    <small id="email_text"></small>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <h4>密碼</h4>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="6-15 個字元" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <h4>確認密碼</h4>
                                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="請再輸入一次密碼" required>
                                    </div>
                                </div>
                            </div>
                            <?php if (get_setting_general('coupon_active') == 'y') {?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <h4>推薦碼</h4>
                                        <input type="text" class="form-control" id="recommend_code" name="recommend_code" value="<?php echo $this->session->userdata('recommend_code') ?>">
                                    </div>
                                </div>
                            </div>
                            <?php } else {?>
                                <input type="hidden" id="recommend_code" name="recommend_code" value="">
                            <?php }?>
                            <!-- <div class="row">
                              <div class="form-group">
                                  <h4>LINE User ID</h4>
                                  <input type="text" class="form-control" id="line_id" name="line_id" value="" readonly="">
                              </div>
                            </div> -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="agree" name="agree" required> 我同意<a href="/about/rule" class="use-modal-btn">網站服務條款</a>及<a href="/about/privacy_policy" class="use-modal-btn">隱私政策</a>
                                        </label>
                                    </div>
                                    <!-- <label id="agree-error" class="error" for="agree"></label> -->
                                </div>
                            </div>
                        </div>
                        <span id="error_text" style="color: red; font-weight: bold;"></span>
                        <input type="hidden" id="email_ok" value="0">
                        <input type="hidden" id="identity_ok" value="0">
                        <input type="hidden" id="line_id" name="line_id" value="">
                        <input type="hidden" name="now_url" value="<?php echo base_url() . $_SERVER['REQUEST_URI'] ?>">
                        <div class="form-action clearfix">
                            <span class="btn btn-info btn-lg btn-block mt-xl mr-lg" onclick="form_check()">免費註冊</span>
                            <!-- <input type="submit" value="免費註冊" class="btn btn-info btn-lg btn-block mt-xl mr-lg"> -->
                            <!-- <a href="/line/binding" class="btn btn-info btn-lg btn-block mt-xl mr-lg visible-xs visible-sm">已註冊, 綁定LINE</a> -->
                            <a href="line://app/1653916968-qzXZEm7Y" class="btn btn-info btn-lg btn-block mt-xl mr-lg visible-xs visible-sm">已註冊, 綁定LINE</a>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
  function random_number(objid) {
    if(document.getElementById("identity").value!=''){
      var identity = document.getElementById("identity").value;
      $.ajax({
        url: "<?php echo base_url(); ?>auth/identity_check",
        method: "get",
        data: { identity: identity },
        success: function(data) {
          if(data=='0'){
            var rand_code = Math.floor((Math.random() * 100000) + 1);
            document.getElementById("code_num").value = rand_code;
            $.ajax({
              url: "<?php echo base_url(); ?>store/send_sms",
              method: "post",
              data: { phone: identity, code: rand_code },
              success: function(data) {
                waiting(30,objid);
                alert('請接收簡訊。');
              }
            });
          } else {
            $('#identity').val('');
            $('#identity').focus();
            alert('此行動電話已註冊。');
          }
        }
      });
      return false;
    } else {
      alert('請輸入手機號碼。');
    }
  }

  var currentsecond;
  function waiting(countdownfrom,objid)
  {
    currentsecond=countdownfrom+1;
    setTimeout("countredirect('"+objid+"')",1000);
    return;
  }

  function countredirect(objid){
    if (currentsecond!=1){
      currentsecond-=1;
      $('#'+objid).css("pointer-events", "none");
      $('#'+objid).html(currentsecond)+'秒後重新獲取';
    } else {
      $('#'+objid).html('重新獲取');
      $('#'+objid).css("pointer-events", "auto");
      return;
    }
    setTimeout("countredirect('"+objid+"')",1000)  ;
  }

  function check_email(){
    var email = document.getElementById("email").value;
    $.ajax({
      url: "<?php echo base_url(); ?>auth/email_check",
      method: "get",
      data: { email:email },
      success: function(data) {
        if(data==0){
          // alert('可以使用');
          $('#email_text').html('可以使用');
          $('#email_ok').val('1');
        } else {
          // alert('此電子郵件已經被註冊過了');
          $('#email_text').html('此電子郵件已經被註冊過了');
          $('#email_ok').val('0');
        }
      }
    });
  }
  function check_identity_code(){
    var code_num = document.getElementById("code_num").value;
    var sms_code = document.getElementById("sms_code").value;
    if(code_num != "" && sms_code != "" && code_num==sms_code){
      // alert('驗證碼正確');
      $('#sms_code_text').html('驗證碼正確');
      $('#identity_ok').val('1');
    } else {
      // alert('錯誤，驗證碼不正確');
      $('#sms_code_text').html('錯誤，驗證碼不正確');
      $('#identity_ok').val('0');
    }
  }
  function form_check(){
    var email_ok = $('#email_ok').val();
    var identity_ok = $('#identity_ok').val();
    var password = $('#password').val();
    var password_confirm = $('#password_confirm').val();
    var agree = $('#agree:checkbox:checked').length;
    if(password==password_confirm){
      if(agree>0){
      } else {
        $('#error_text').html('請勾選');
      }
      if(identity_ok==1){
      } else {
        $('#error_text').html('手機驗證不通過。');
      }
      if(email_ok==1){
      } else {
        $('#error_text').html('電子郵件不正確。');
      }
      if(email_ok==1 && identity_ok==1 && agree>0){
        // alert('Submit');
        document.getElementById("register").submit();
      }
    } else {
      $('#error_text').html('密碼與確認密碼不符。');
    }
  }
</script>

<!-- <script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<!-- <script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script> -->
<!-- <script>
$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("register").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
    // validate signup form on keyup and submit
    $("#register").validate({
        rules: {
            sms_code: {
                required: true,
                equalTo: "#code_num"
            },
            agree: "required",
            topic: "required"
        },
        messages: {
            sms_code: {
                required: "請輸入驗證碼。",
                equalTo: "驗證碼不正確！"
            },
            agree: "請勾選。",
            topic: "Please select at least 2 topics"
        }
    });
});
</script> -->

<!-- <script>
$(document).ready(function() {
  if (LIFF_userID != "") {
    setTimeout("get_register_line_id()", 300);
  } else {
    setTimeout("get_register_line_id()", 300);
  }
});

function get_register_line_id() {
    if (LIFF_userID != "") {
        // alert(LIFF_userID);
        $('#line_id').val(LIFF_userID);
    } else {
        console.log("等候LIFF加載...");
        if($('#line_id').val()==''){
          setTimeout("get_register_line_id()", 300);
        }
    }
};
</script> -->