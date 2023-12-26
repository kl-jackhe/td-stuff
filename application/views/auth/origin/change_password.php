<div role="main" class="main pt-signinfo">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <h1><?php echo lang('change_password_heading');?></h1>
      <div id="infoMessage"><?php echo $message;?></div>
      <?php echo form_open("auth/change_password");?>
      <div class="form-group">
        <?php echo lang('change_password_old_password_label', 'old_password');?>
        <?php echo form_input($old_password);?>
      </div>
      <div class="form-group">
        <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
        <?php echo form_input($new_password);?>
      </div>
      <div class="form-group">
        <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?>
        <?php echo form_input($new_password_confirm);?>
      </div>
      <?php echo form_input($user_id);?>
      <div class="form-group">
        <?php echo form_submit('submit', lang('change_password_submit_btn'));?>
      </div>
      <?php echo form_close() ?>
    </div>
  </div>
</div>