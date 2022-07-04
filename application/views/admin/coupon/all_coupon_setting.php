<style>
	#logo_preview{
		background: #efefef;
		border: 1px solid #000;
	}
	select.district {
	  margin-right: : 5px;
	}
	.zipcode{
	  display: none!important;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open('admin/setting/update_general?type=all_coupon',array('class'=>'form-horizontal')); ?>
		<div class="tabbable">
		  	<!-- Nav tabs -->
		  	<ul class="nav nav-tabs" role="tablist">
		  		<li role="presentation" class="active">
		      		<a href="#all_coupon" aria-controls="all_coupon" role="tab" data-toggle="tab">全站優惠設定</a>
		      	</li>
		  	</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="all_coupon">
					<div class="form-group">
						<div class="col-md-6">
							<div class="form-inline">
								優惠時間：
								<input type="text" name="discount_start_time" id="discount_start_time" class="form-control datetimepicker" value="<?php echo get_setting_general('discount_start_time') ?>"/>
								~
								<input type="text" name="discount_end_time" id="discount_end_time" class="form-control datetimepicker" value="<?php echo get_setting_general('discount_end_time') ?>"/>
							</div>
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<div class="col-md-6">
							<div class="form-inline">
								運費：
								<input type="text" name="delivery_cost" id="delivery_cost" class="form-control" value="<?php echo get_setting_general('delivery_cost') ?>" size="6"/>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div class="form-inline">
								<select name="all_no_delivery_cost" id="all_no_delivery_cost" class="form-control">
									<option value="1" <?php if (get_setting_general('all_no_delivery_cost')=='1') {echo 'selected';} ?>>Ｏ 啟用</option>
									<option value="" <?php if (get_setting_general('all_no_delivery_cost')!='1') {echo 'selected';} ?>>Ｘ 禁用</option>
								</select>
								<label>全站免運</label>
							</div>
							<!-- <div class="checkbox">
								<label>
									<input type="checkbox" name="all_no_delivery_cost" id="all_no_delivery_cost" value="1" <?php if(get_setting_general('all_no_delivery_cost')=='1') { echo 'checked'; } ?>> 全站免運
						  		</label>
	  						</div> -->
  						</div>
					</div>
					<div class="form-group hide">
						<div class="col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="no_service_cost" id="no_service_cost" value="1" <?php if(get_setting_general('no_service_cost')=='1') { echo 'checked'; } ?>> 全站免服務費
						  		</label>
	  						</div>
  						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div class="form-inline">
								<select name="is_food_discount" id="is_food_discount" class="form-control">
									<option value="1" <?php if (get_setting_general('is_food_discount')=='1') {echo 'selected';} ?>>Ｏ 啟用</option>
									<option value="" <?php if (get_setting_general('is_food_discount')!='1') {echo 'selected';} ?>>Ｘ 禁用</option>
								</select>
								餐費
								<input type="text" name="food_discount_number" id="food_discount_number" class="form-control" style="width: auto; display: inline-block;" size="6" value="<?php echo get_setting_general('food_discount_number') ?>"> 折
								<!-- <div class="checkbox">
									<label>
										<input type="checkbox" name="is_food_discount" id="is_food_discount" value="1" <?php if(get_setting_general('is_food_discount')=='1') { echo 'checked'; } ?>> 
							  		</label>
		  						</div> -->
		  					</div>
  						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div class="form-inline">
								<select name="is_no_delivery_cost" id="is_no_delivery_cost" class="form-control">
									<option value="1" <?php if (get_setting_general('is_no_delivery_cost')=='1') {echo 'selected';} ?>>Ｏ 啟用</option>
									<option value="" <?php if (get_setting_general('is_no_delivery_cost')!='1') {echo 'selected';} ?>>Ｘ 禁用</option>
								</select>
								滿
								<input type="text" name="is_no_delivery_cost_number" id="is_no_delivery_cost_number" class="form-control" style="width: auto; display: inline-block;" size="6" value="<?php echo get_setting_general('is_no_delivery_cost_number') ?>"> 元免運
							</div>
							<!-- <div class="checkbox">
								<label>
									<input type="checkbox" name="is_no_delivery_cost" id="is_no_delivery_cost" value="1" <?php if(get_setting_general('is_no_delivery_cost')=='1') { echo 'checked'; } ?>> 
						  		</label>
	  						</div> -->
  						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<div class="form-inline">
								購物車最低購買金額：
								<input type="text" name="cart_lowest_price_limit" id="cart_lowest_price_limit" class="form-control" value="<?php echo get_setting_general('cart_lowest_price_limit') ?>" size="6"/>
								<small style="color: red;">如不限制，請留空或輸入0</small>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<input type="submit" name="submit" value="儲存設定" class="btn btn-primary"/>
			</div>
		</div>
		<?php echo form_close() ?>
	</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="border: 1px solid #ccc; padding: 10px; max-height: 200px; overflow-y: auto;">
      <table class="table table-bordered table-striped table-condensed">
        <tr class="info">
          <th>
            欄位
          </th>
          <th>
            值
          </th>
          <th>
            更新者
          </th>
          <th>
            更新時間
          </th>
        </tr>
      <?php if(!empty($change_log)) { foreach($change_log as $cl) { ?>
        <tr>
          <td>
            <?php echo $this->lang->line($cl['change_log_key']); ?>
          </td>
          <td>
            <?php echo $cl['change_log_value'] ?>
          </td>
          <td>
            <?php echo get_user_full_name($cl['change_log_creator_id']) ?>
          </td>
          <td>
            <?php echo $cl['change_log_created_at'] ?>
          </td>
        </tr>
      <?php }} ?>
      </table>
    </div>
  </div>
</div>

<script>
	$('#twzipcode').twzipcode({
      	// 'detect': true, // 預設值為 false
      	'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      	'countySel'   : '<?php echo get_setting_general('coupon_localtion_county') ?>',
      	'districtSel' : '<?php echo get_setting_general('coupon_localtion_district') ?>',
      	'hideCounty' : [<?php if(!empty($hide_county)){ foreach($hide_county as $hc){ echo '"'.$hc.'",'; }} ?>],
      	'hideDistrict': [<?php if(!empty($hide_district)){ foreach($hide_district as $hd){ echo '"'.$hd.'",'; }} ?>]
  	});
</script>