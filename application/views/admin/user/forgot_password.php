<style>
.form-group input{
display: block;
width: 100%;
height: 34px;
padding: 6px 12px;
font-size: 14px;
line-height: 1.42857143;
color: #555;
background-color: #fff;
border: 1px solid #ccc;
border-radius: 4px;
}
</style>
<div class="row">
  <div class="col-md-6">
    <h1><?php echo lang('forgot_password_heading');?></h1>
    <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open("auth/forgot_password");?>
    <div class="form-group">
      <label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
      <?php echo form_input($identity);?>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">儲存修改</button>
    </div>
    <?php echo form_close() ?>
  </div>
</div>