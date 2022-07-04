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
</style>
<div class="row">
    <div class="col-md-6">
        <?php $att = "class='form-horizontal'"; ?>
        <?php echo form_open(uri_string(), $att);?>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">修改</button>
                <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
                <hr>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">姓名</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $user->full_name; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">電子信箱</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->email ?>">
                <?php if($user->active!=1){echo '<label style="color: red;">未認證</label>';} ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">手機</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $user->phone ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">更改密碼</label>
            <div class="col-md-9">
                <?php echo form_input($password);?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">確認密碼</label>
            <div class="col-md-9">
                <?php echo form_input($password_confirm);?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">性別</label>
            <div class="col-md-9">
                <select name="gender" id="gender" class="form-control">
                    <option value="man" <?php if($user->gender=='man'){echo 'selected';} ?>>男</option>
                    <option value="girl" <?php if($user->gender=='girl'){echo 'selected';} ?>>女</option>
                    <option value="other" <?php if($user->gender=='other'){echo 'selected';} ?>>其他</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">生日</label>
            <div class="col-md-9">
                <input type="text" class="form-control datepicker" name="birthday" id="birthday" value="<?php echo $user->birthday ?>" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">地址</label>
            <div class="col-md-9">
                <div id="twzipcode"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label"></label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="address" id="address" value="<?php echo $user->address ?>">
            </div>
        </div>
        <?php if ($this->ion_auth->is_admin()): ?>
        <h3>帳號群組</h3>
        <?php foreach ($groups as $group):?>
        <div class="checkbox">
          <label class="checkbox">
            <?php
            $gID=$group['id'];
            $checked = null;
            $item = null;
            foreach($currentGroups as $grp) {
              if ($gID == $grp->id) {
                $checked= ' checked="checked"';
                break;
              }
            } ?>
            <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
            <?php echo htmlspecialchars($group['description'],ENT_QUOTES,'UTF-8');?>
          </label>
        </div>
        <?php endforeach?>
        <?php endif ?>
        <?php echo form_hidden('id', $user->id);?>
        <?php echo form_hidden($csrf); ?>
        <?php echo form_close() ?>
    </div>
</div>
<script src="/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script> -->
<script src="/node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-TW.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.zh-TW.min.js"></script> -->
<script>
$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
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

function random_number(objid) {
    var x = Math.floor((Math.random() * 100000) + 1);
    document.getElementById("code_num").value = x;
    DisableEnable(objid);
    var phone = document.getElementById("phone").value;
    var wnd = window.open('http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=27786658&password=aa19971225&dstaddr=' + phone + '&encoding=UTF8&smbody=您的結帳驗證碼為: ' + x + ' ,請在十分鐘內完成結帳流程。&response=http://192.168.1.200/smreply.asp', 'connectWindow', 'width=200,height=100,scrollbars=yes');
    setTimeout(function() {
        wnd.close();
    }, 500);
    return false;
}
var time = 30000;

function DisableEnable(objid) {
    if (time <= 0) {
        document.getElementById(objid).value = '重新獲取';
        document.getElementById(objid).disabled = false;
        time = 40000;
    } else {
        document.getElementById(objid).disabled = true;
        document.getElementById(objid).value = (time / 1000) + '秒後重試';
        setTimeout("DisableEnable('" + objid + "')", 1000);
    }
    time -= 1000;
}
</script>