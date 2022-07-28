<div role="main" class="main pt-signinfo">
  	<div class="row">
	    <div class="col-md-4 col-md-offset-4">
			<h3><?php echo lang('reset_password_heading');?></h3>
			<div id="infoMessage"><?php echo $message;?></div>
			<?php echo form_open('auth/reset_password/' . $code);?>
			<div class="form-group">
				<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
				<?php echo form_input($new_password);?>
			</div>
			<div class="form-group">
				<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
				<?php echo form_input($new_password_confirm);?>
			</div>
			<?php echo form_input($user_id);?>
			<?php echo form_hidden($csrf); ?>
			<div class="form-group">
				<button type="submit" class="btn btn-info">重設密碼</button>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>