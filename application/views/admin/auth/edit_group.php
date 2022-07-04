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
    <h1><?php echo lang('edit_group_heading');?></h1>
    <p><?php echo lang('edit_group_subheading');?></p>
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open(current_url());?>
    <div class="form-group">
      <?php echo lang('edit_group_name_label', 'group_name');?> <br />
      <?php echo form_input($group_name);?>
    </div>
    <div class="form-group">
      <?php echo lang('edit_group_desc_label', 'description');?> <br />
      <?php echo form_input($group_description);?>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">儲存修改</button>
    </div>
    <?php echo form_close() ?>
  </div>
</div>