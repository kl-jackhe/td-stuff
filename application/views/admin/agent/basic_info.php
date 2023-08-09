<style>
    .padding_style {
        padding-bottom: 15px;
    }
</style>
<div class="row">
    <div class="col-md-12 padding_style">
        <h4 style="font-weight: bold;display: inline-block;">代言人資料</h4>
        <span class="btn btn-success btn-sm" style="position: relative;top: -2px;" onclick="updateAgent()">更新代言人資料</span>
    </div>
    <div class="col-md-4 col-sm-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">ID</span>
            <input type="text" class="form-control" id="agent_id" value="<?=$agent['id']?>" readonly>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">代言人名稱</span>
            <input type="text" class="form-control" id="agent_name" value="<?=$agent['name']?>">
        </div>
    </div>
    <div class="col-md-4 col-sm-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">會員連結資料  <i class="fa-solid fa-circle-question" data-html="true" data-toggle="tooltip" data-original-title="◎ 代言人如果是會員，可以選擇會員資料進行連動紀錄。<br>◎ 代言人如果沒有會員資料，則可以不用選擇！"></i></span>
            <select id="agent_users_id" class="form-control chosen">
                <? if ($agent['id'] == 0) {?>
                    <option value="" selected>選擇會員</option>
                <?}
                if (!empty($Users)) {
                    foreach ($Users as $row) {?>
                        <option value="<?=$row['id'] ?>" <?=($agent['users_id'] == $row['id'] ? 'selected' : '')?>><?=$row['full_name'] . ' - ' . $row['username'] ?></option>
                    <?}
                }?>
            </select>
        </div>
        <input type="hidden" id="users_id" value="<?=$agent['users_id']?>">
    </div>
    <div class="col-md-4 col-sm-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">姓名</span>
            <input type="text" class="form-control" id="agent_full_name" value="<?=$agent['full_name']?>">
        </div>
    </div>
    <div class="col-md-4 col-sm-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">電話</span>
            <input type="text" class="form-control" id="agent_phone" value="<?=$agent['phone']?>">
        </div>
    </div>
    <div class="col-md-4 col-sm-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">地址</span>
            <input type="text" class="form-control" id="agent_address" value="<?=$agent['address']?>">
        </div>
    </div>
    <div class="col-md-12 padding_style">
        <div class="input-group">
            <span class="input-group-addon">備註</span>
            <textarea class="form-control" id="agent_remark" rows="5"><?=$agent['remark']?></textarea>
        </div>
    </div>
    <? if ($agent['users_id'] != 0) {?>
        <div class="col-md-12">
            <hr>
            <h4 style="font-weight: bold;display: inline-block;padding-bottom: 15px;">會員資料</h4>
            <span class="btn btn-success btn-sm" style="position: relative;top: -2px;" onclick="updateUsers()">更新會員資料</span>
        </div>
        <div class="col-md-2 col-sm-12 padding_style">
            <div class="input-group">
                <span class="input-group-addon">姓名</span>
                <input type="text" class="form-control" id="users_full_name" value="<?=$agent['users_full_name']?>">
            </div>
        </div>
        <div class="col-md-2 col-sm-12 padding_style">
            <div class="input-group">
                <span class="input-group-addon">電話</span>
                <input type="text" class="form-control" id="users_phone" value="<?=$agent['users_phone']?>">
            </div>
        </div>
        <div class="col-md-4 col-sm-12 padding_style">
            <div class="input-group">
                <span class="input-group-addon">電子郵件</span>
                <input type="text" class="form-control" id="users_email" value="<?=$agent['users_email']?>">
            </div>
        </div>
        <div class="col-md-4 padding_style">
            <div class="input-group">
                <span class="input-group-addon">地址</span>
                <input type="text" class="form-control" id="users_address" value="<?=$agent['users_address']?>">
            </div>
        </div>
    <?}?>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

function updateUserData() {
  $.ajax({
    url: '/auth/edit_user/' + $('#user_id').val(),
    type: 'POST',
    data: {
      first_name: $('#first_name').val(),
      password: $('#password').val(),
      password_confirm: $('#password_confirm').val(),
    },
    success: function(data) {
      location.reload();
    }
  });
}
function updateAgent() {
    $.ajax({
        type: "POST",
        url: '/admin/agent/updateAgent',
        data: {
            id: $('#agent_id').val(),
            name: $('#agent_name').val(),
            users_id: $('#agent_users_id').val(),
            full_name: $('#agent_full_name').val(),
            phone: $('#agent_phone').val(),
            address: $('#agent_address').val(),
            remark: $('#agent_remark').val(),
        },
        success: function(data) {
                alert('更新成功！');
                location.reload();
        },
        error: function(data) {
            console.log('Update Error');
        }
    });
}
function updateUsers() {
    $.ajax({
        type: "POST",
        url: '/admin/user/updateUsers',
        data: {
            id: $('#users_id').val(),
            full_name: $('#users_full_name').val(),
            phone: $('#users_phone').val(),
            email: $('#users_email').val(),
            address: $('#users_address').val(),
        },
        success: function(data) {
                alert('更新成功！');
                location.reload();
        },
        error: function(data) {
            console.log('Update Error');
        }
    });
}
</script>