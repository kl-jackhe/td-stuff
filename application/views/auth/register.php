<div role="main" class="main pt-xlg-main">
    <section class="content_auto_h">
        <div class="container">
            <div class="box mt-md">
                <div class="row justify-content-center">
                    <div class="col-md-6" style="box-shadow: 6px 6px 20px grey; padding: 30px 60px;">
                        <?php $attributes = array('id' => 'register');?>
                        <?php echo form_open('register', $attributes); ?>
                        <div class="form-content">
                            <div class="form-group">
                                <a href="/login">←返回登入</a>
                                <?php echo $message; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>行動電話  <small style="color: #C52B29;">以行動電話作為登入帳號</small></label>
                                        <input type="text" class="form-control" id="identity" name="identity" placeholder="09xxxxxxxx" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>姓名</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入姓名" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>電子信箱  <small id="email_text" style="color: #C52B29;"></small></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="請輸入E-Mail" onchange="check_email()" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>密碼</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="6-15 個字元" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>確認密碼</label>
                                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="請再輸入一次密碼" required>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row d-none">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="agree" name="agree"> 我同意<a href="/about/rule" class="use-modal-btn">網站服務條款</a>及<a href="/about/privacy_policy" class="use-modal-btn">隱私政策</a>
                                        </label>
                                    </div>
                                    <label id="agree-error" class="error" for="agree"></label>
                                </div>
                            </div> -->
                        </div>
                        <span id="error_text" style="color: red; font-weight: bold;"></span>
                        <input type="hidden" id="email_ok" value="0">
                        <input type="hidden" id="identity_ok" value="0">
                        <!-- <input type="hidden" name="now_url" value="<?php echo base_url() . $_SERVER['REQUEST_URI'] ?>"> -->
                        <div class="form-action clearfix">
                            <span class="btn btn-info btn-lg btn-block mt-xl mr-lg" onclick="form_check()">免費註冊</span>
                            <!-- <input type="submit" value="免費註冊" class="btn btn-info btn-lg btn-block mt-xl mr-lg"> -->
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
  function check_email(){
    var email = document.getElementById("email").value;
    $.ajax({
      url: "/auth/email_check",
      method: "get",
      data: { email: email },
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
  function form_check(){
    var email_ok = $('#email_ok').val();
    var password = $('#password').val();
    var password_confirm = $('#password_confirm').val();
    // var agree = $('#agree:checkbox:checked').length;
    if(password==password_confirm){
      // if(agree>0){
      // } else {
      //   $('#error_text').html('請勾選');
      //   return false;
      // }
      if(email_ok==1){
      } else {
        $('#error_text').html('電子郵件不正確。');
        return false;
      }
      // if(email_ok==1 && agree>0){
        // alert('Submit');
        document.getElementById("register").submit();
      // }
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