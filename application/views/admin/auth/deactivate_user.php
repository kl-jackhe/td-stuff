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
    <h1><?php echo lang('deactivate_heading');?></h1>
    <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
    <?php echo form_open("admin/auth/deactivate/".$user->id);?>
    <p>
      <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
      <input type="radio" name="confirm" value="yes" checked="checked" />
      <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
      <input type="radio" name="confirm" value="no" />
    </p>
    <?php echo form_hidden($csrf); ?>
    <?php echo form_hidden(array('id'=>$user->id)); ?>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">儲存修改</button>
    </div>
    <?php echo form_close() ?>
  </div>
</div>