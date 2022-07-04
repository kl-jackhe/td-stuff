<div class="row">
  <?php $attributes = array('class' => 'driver', 'id' => 'driver'); ?>
  <?php echo form_open('admin/driver/edit_user/'.$user->id , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
      <hr>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="full_name" class="col-md-3 control-label">＊姓名：</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $user->full_name; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">電子信箱</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->email ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="col-md-3 control-label">＊手機：</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $user->phone ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="company" class="col-md-3 control-label">＊車隊：</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="company" id="company" value="<?php echo $user->company ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">更改密碼</label>
              <div class="col-md-5">
                <?php echo form_input($password);?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">確認密碼</label>
              <div class="col-md-5">
                <?php echo form_input($password_confirm);?>
              </div>
            </div>
            <?php echo form_hidden('id', $user->id);?>
            <?php echo form_hidden($csrf); ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php echo form_close() ?>
</div>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("driver").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#driver").validate({});
});
</script>