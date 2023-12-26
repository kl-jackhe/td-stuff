<div class="main pt-signinfo">
  <div class="row">
    <div class="col-md-6">
      <h4>請先建立帳號、電子郵件及密碼, 建立完成後在完善基本資料。</h4>
      <hr>
      <div id="infoMessage"><?php echo $message;?></div>
      <?php echo form_open("admin/auth/create_user");?>
      <?php
      if($identity_column!=='email') {
      echo '<div class="form-group">';
        echo lang('create_user_identity_label', 'identity');
        echo '';
        echo form_error('identity');
        echo form_input($identity);
        echo '</div>';
      } ?>
      <div class="form-group">
        <?php echo lang('create_user_email_label', 'email');?>
        <?php echo form_input($email);?>
      </div>
      <div class="form-group">
        <?php echo lang('create_user_password_label', 'password');?>
        <?php echo form_input($password);?>
      </div>
      <div class="form-group">
        <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
        <?php echo form_input($password_confirm);?>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">建立</button>
      </div>
      <?php echo form_close() ?>
    </div>
  </div>
</div>