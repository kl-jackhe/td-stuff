<div class="row">
  <?php $attributes = array('class' => 'driver', 'id' => 'driver'); ?>
  <?php echo form_open('admin/driver/create_user' , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">建立</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
      <hr>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="full_name" class="col-sm-3 control-label">＊姓名：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="full_name" id="full_name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="col-sm-3 control-label">＊手機：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="phone" id="phone" required>
              </div>
            </div>
            <div class="form-group">
              <label for="company" class="col-sm-3 control-label">＊車隊：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="company" id="company" required>
              </div>
            </div>
            <?php
            if($identity_column!=='email') {
              echo '<div class="form-group">';
              echo '<label for="identity" class="col-sm-3 control-label">＊帳號：</label>';
              echo '<div class="col-md-5">';
              echo form_error('identity');
              echo form_input($identity);
              echo '</div>';
              echo '</div>';
            } ?>
            <div class="form-group">
              <label for="driver_name" class="col-sm-3 control-label">
                <?php echo lang('create_user_email_label', 'email');?>
              </label>
              <div class="col-sm-5">
                <?php echo form_input($email);?>
              </div>
            </div>
            <div class="form-group">
              <label for="driver_name" class="col-sm-3 control-label">
                <?php echo lang('create_user_password_label', 'password');?>
              </label>
              <div class="col-sm-5">
                <?php echo form_input($password);?>
              </div>
            </div>
            <div class="form-group">
              <label for="driver_name" class="col-sm-3 control-label">
                <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
              </label>
              <div class="col-sm-5">
                <?php echo form_input($password_confirm);?>
              </div>
            </div>
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