<div class="row">
	<div class="col-md-6">
		<?php $attributes = array('class' => 'submit_form', 'id' => 'submit_form'); ?>
		<?php echo form_open('admin/setting/update_delivery_time/'.$delivery_time['delivery_time_id'] , $attributes); ?>
		  	<div class="form-group">
		    	<label for="delivery_time_name">名稱</label>
		    	<input type="text" class="form-control" name="delivery_time_name" value="<?php echo $delivery_time['delivery_time_name'] ?>">
		  	</div>
		  	<div class="form-group">
		  		<button type="submit" id="save-btn" class="btn btn-primary"><i class="fa fa-edit"></i> <?php echo $this->lang->line('save'); ?> (F2)</button>
		  	</div>
		<?php echo form_close() ?>
	</div>
</div>