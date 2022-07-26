<link rel="stylesheet" href="/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"> -->
<style>
.fixed-bottom {
    display: none;
}
.form-horizontal .control-label {
    text-align: left;
}
select.county {
  width: 48%;
  float: left;
}
select.district {
  width: 48%;
  float: left;
  margin-left: 4%;
}
input.zipcode{
  width:33%;
  display: none;
}
#twzipcode {
    width: 65%;
}
@media (max-width: 480px) {
    #sub_menu a {
        width: 24%;
        padding: 6px;
    }
}
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container py-5">
            <div class="box">
                <div class="col-md-12" id="sub_menu">
                    <!-- <h3 class="fs-18 color-595757">Hi
                        <?php echo $this->ion_auth->user()->row()->full_name ?>
                    </h3> -->
                    <a href="/auth/edit_user/<?php echo $this->ion_auth->user()->row()->id ?>" class="btn fs-13" style="background: #420252; color: white;">個人資料</a>
                    <!-- <a href="/coupon" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">優惠券管理</a> -->
                    <a href="/order" class="btn fs-13" style="border: 1px solid #420252; color: gray; border-bottom: none;">訂單管理</a>
                    <!-- <a href="/my_address" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">常用地址</a> -->
                </div>
                <div class="row justify-content-center py-3" style="border: 2px solid #420252;border-radius: 15px;">
                    <div class="col-12 col-md-6">
                        <?php $att = "class='form-horizontal' id='edit_user_form'";?>
                        <?php echo form_open(uri_string(), $att); ?>
                        <h3>基本資料&ensp;<i class="fas fa-users-cog"></i></h3>
                        <hr>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">姓名</span>
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $user->full_name; ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">電子郵件</span>
                                <span class="input-group-text"><i class="fas fa-envelope"></i></i></span>
                            </div>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->email ?>" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">聯絡電話</span>
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $user->phone ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">地址</span>
                                <span class="input-group-text"><i class="fas fa-street-view"></i></span>
                            </div>
                            <div id="twzipcode"></div>
                            <div class="col-12 p-0" style="margin-top: 15px;">
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo $user->address ?>" placeholder="詳細地址">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">生日</span>
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                            </div>
                            <?php if ($user->birthday == '0000-00-00') {?>
                            <input type="text" class="form-control datepicker" name="birthday" id="birthday" value="<?php echo $user->birthday ?>" autocomplete="off" readonly>
                            <?php } else {?>
                            <input type="text" class="form-control" name="birthday" id="birthday" value="<?php echo $user->birthday ?>" autocomplete="off" readonly>
                            <?php }?>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">密碼</span>
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <?php echo form_input($password); ?>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">確認密碼</span>
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <?php echo form_input($password_confirm); ?>
                        </div>
                        <?php // echo form_hidden('id', $user->id);?>
                        <input type="hidden" id="id" name="id" value="<?php echo $user->id ?>">
                        <?php echo form_hidden($csrf); ?>
                        <span class="btn btn-primary pull-right" onclick="form_submit()">儲存</span>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script src="/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script> -->
<script src="/node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-TW.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.zh-TW.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    startDate: '1900-01-01',
    autoclose: true,
    clearBtn: true,
    todayBtn: true,
    todayHighlight: true,
    language: 'zh-TW'
});
$('#twzipcode').twzipcode({
    // 'detect': true, // 預設值為 false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'countySel': '<?php echo $user->county ?>',
    'districtSel': '<?php echo $user->district ?>'
});

function isOS() {
    return navigator.userAgent.match(/ipad|iphone/i);
}

function form_submit() {
    var id = document.getElementById("id").value;
    var phone = document.getElementById("phone").value;

    if (phone != '<?php echo $user->phone ?>') {
        $.ajax({
            url: "<?php echo base_url(); ?>auth/identity_check_with_id",
            method: "get",
            data: { id: id, identity: phone },
            success: function(data) {
                if (data == '1') {
                    alert('此電話號碼已存在');
                } else {
                    $('#edit_user_form').submit();
                }
            }
        });
    } else {
        // alert('same phone.');
        $('#edit_user_form').submit();
    }
}

$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("edit_user_form").submit();
        //alert("submitted!");
    }
});

$(document).ready(function() {
    // validate signup form on keyup and submit
    $("#edit_user_form").validate({
        rules: {
            sms_code: {
                // required: true,
                equalTo: "#code_num"
            },
            password_confirm: {
                equalTo: "#password"
            },
            agree: "required",
            topic: "required"
        },
        messages: {
            sms_code: {
                // required: "請輸入驗證碼。",
                equalTo: "驗證碼不正確！"
            },
            password_confirm: {
                equalTo: "確認密碼與更改密碼不相符！"
            },
            agree: "請勾選。",
            topic: "Please select at least 2 topics"
        }
    });
});
</script>