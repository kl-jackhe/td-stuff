<div class="row">
  <div class="col-md-6">
    <?php echo form_open("admin/auth/create_franchisee_user");?>
    <?php
    if($identity_column!=='email') {
      echo '<div class="form-group">';
      echo '＊'.lang('create_user_identity_label', 'identity');
      echo '';
      echo form_error('identity');
      echo form_input($identity);
      echo '</div>';
    } ?>
    <div class="form-group">
      ＊<?php echo lang('create_user_store_code_label', 'store_code');?>
      <?php echo form_input($store_code);?>
    </div>
    <div class="form-group">
      ＊<?php echo lang('create_user_email_label', 'email');?>
      <?php echo form_input($email);?>
    </div>
    <div class="form-group">
      ＊<?php echo lang('create_user_password_label', 'password');?>
      <?php echo form_input($password);?>
    </div>
    <div class="form-group">
      ＊<?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
      <?php echo form_input($password_confirm);?>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">建立</button>
    </div>
    <?php echo form_close() ?>
  </div>
</div>