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
	<div class="col-md-4">
		<h1><?php echo lang('reset_password_heading');?></h1>
		<div id="infoMessage"><?php echo $message;?></div>
		<?php echo form_open('auth/reset_password/' . $code);?>
		<p>
			<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
			<?php echo form_input($new_password);?>
		</p>
		<p>
			<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
			<?php echo form_input($new_password_confirm);?>
		</p>
		<?php echo form_input($user_id);?>
		<?php echo form_hidden($csrf); ?>
		<p><button type="submit" class="btn btn-primary">儲存修改</button></p>
		<?php echo form_close() ?>
	</div>
</div>