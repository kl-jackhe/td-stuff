<div class="row">
	<div class="col-md-12">
		<a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) . '/category' ?>" class="btn btn-info hidden-print">返回上一頁</a>
		<hr>
	</div>
	<div class="col-md-6">
		<div class="content-box-large">
			<?php $attributes = array('class' => 'product_category', 'id' => 'product_category');?>
			<?php echo form_open('admin/product/update_category/' . $category['product_category_id'], $attributes); ?>
			  	<div class="form-group">
			    	<label for="product_category_name">分類名稱</label>
			    	<input type="text" class="form-control" name="product_category_name" value="<?php echo $category['product_category_name']; ?>">
			  	</div>
			    <div class="form-group">
			  		<button type="submit" class="btn btn-primary">修改</button>
			  	</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>