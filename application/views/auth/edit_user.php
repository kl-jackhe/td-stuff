<link rel="stylesheet" href="/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"> -->
<style>
    .form-horizontal .control-label{
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
@media (max-width: 480px) {
    #sub_menu a {
        width: 24%;
        padding: 6px;
    }
}
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container">
            <div class="box">
                <div class="" id="sub_menu">
                    <h3 class="fs-18 color-595757">Hi
                        <?php echo $this->ion_auth->user()->row()->full_name ?>
                    </h3>
                    <a href="/auth/edit_user/<?php echo $this->ion_auth->user()->row()->id ?>" class="btn fs-13" style="background: gray; color: white;">個人資料</a>
                    <!-- <a href="/coupon" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">優惠券管理</a> -->
                    <a href="/order" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">訂單管理</a>
                    <!-- <a href="/my_address" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">常用地址</a> -->
                </div>
                <div class="col-md-12">
                    <div class="row" style="border: 2px solid gray;">
                        <div class="col-md-6 col-md-offset-3">
                            <?php $att = "class='form-horizontal' id='edit_user_form'"; ?>
                            <?php echo form_open(uri_string(), $att);?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">姓名</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $user->full_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">電子信箱</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->email ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">行動電話</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $user->phone ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">地址</label>
                                <div class="col-md-9">
                                    <div id="twzipcode"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $user->address ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">生日</label>
                                <div class="col-md-9">
                                    <?php if($user->birthday=='0000-00-00'){ ?>
                                        <input type="text" class="form-control datepicker" name="birthday" id="birthday" value="<?php echo $user->birthday ?>" autocomplete="off" readonly>
                                    <?php } else { ?>
                                        <input type="text" class="form-control" name="birthday" id="birthday" value="<?php echo $user->birthday ?>" autocomplete="off" readonly>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">更改密碼</label>
                                <div class="col-md-9">
                                    <?php echo form_input($password);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">確認密碼</label>
                                <div class="col-md-9">
                                    <?php echo form_input($password_confirm);?>
                                </div>
                            </div>
                            <?php // echo form_hidden('id', $user->id);?>
                            <input type="hidden" id="id" name="id" value="<?php echo $user->id ?>">
                            <?php echo form_hidden($csrf); ?>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <!-- <button type="submit" class="btn btn-info pull-right">儲存</button> -->
                                    <span class="btn btn-info pull-right" onclick="form_submit()">儲存</span>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
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

function form_submit(){
    var id = document.getElementById("id").value;
    var phone = document.getElementById("phone").value;

    if(phone!='<?php echo $user->phone ?>'){
        $.ajax({
            url: "<?php echo base_url(); ?>auth/identity_check_with_id",
            method: "get",
            data: { id: id, identity: phone },
            success: function(data) {
                if(data=='1'){
                    alert('此電話號碼已存在');
                } else {
                    var code_num = document.getElementById("code_num").value;
                    var sms_code = document.getElementById("sms_code").value;
                    if(code_num==''){
                        alert('修改手機號碼需要重新驗證。');
                    } else {
                        if(code_num==sms_code){
                            // alert('OOO');
                            $('#edit_user_form').submit();
                        } else {
                            alert('驗證碼不正確');
                        }
                    }
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