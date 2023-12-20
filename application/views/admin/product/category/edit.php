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
        			<label>上層分類</label>
        			<select class="form-control" name="product_category_parent">
          				<option value="0">選擇分類</option>
          				<?php echo get_product_category_option(0,'',$category['product_category_parent']) ?>
        			</select>
      			</div>
			  	<div class="form-group">
			    	<label for="product_category_sort">分類排序</label>
			    	<input type="text" class="form-control" name="product_category_sort" value="<?php echo $category['product_category_sort']; ?>">
			  	</div>
			  	<?if (!empty($delivery)) {?>
                    <div class="form-group">
                        <p style="color: red;">※無設定則任何配送方式都可使用！<br>※有設定則會依照設定值為主要配送方式！<br>※配送方式優先順序『全域 < 分類 < 商品 < 方案』</p>
                        <div class="input-group">
                            <span class="input-group-addon">指定配送方式</span>
                            <select name="delivery[]" id="delivery" class="form-control chosen" multiple>
                                <? foreach ($delivery as $d_row) {
                                    $is_use = '';
                                    if (!empty($use_delivery_list)) {
                                        foreach ($use_delivery_list as $udl_row) {
                                            if ($udl_row['delivery_id'] == $d_row['id']) {
                                                $is_use = 'selected';
                                                break;
                                            }
                                        }
                                    }?>
                                    <option value="<?=$d_row['id']?>" <?=($is_use != '' ? $is_use : '')?>><?=$d_row['delivery_name']?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                <?}?>
			    <div class="form-group">
			  		<button type="submit" class="btn btn-primary">修改</button>
			  	</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>