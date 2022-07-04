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
		<?php echo form_open('admin/setting/update_general?type=recommend_coupon',array('class'=>'form-horizontal')); ?>
		<div class="tabbable">
		  	<!-- Nav tabs -->
		  	<ul class="nav nav-tabs" role="tablist">
		      	<li role="presentation" class="active">
		      		<a href="#coupon" aria-controls="coupon" role="tab" data-toggle="tab">推薦碼優惠券設定</a>
		      	</li>
		  	</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="coupon">
					
					<div class="form-group">
		              <label for="coupon_active" class="col-md-2 control-label">是否啟用</label>
		              <div class="col-md-4">
		                <label class="radio-inline">
		                  <input type="radio" name="coupon_active" id="coupon_active1" value="y" <?php echo (get_setting_general('coupon_active')=='y'?'checked':'') ?>> 啟用
		                </label>
		                <label class="radio-inline">
		                  <input type="radio" name="coupon_active" id="coupon_active2" value="n" <?php echo (get_setting_general('coupon_active')=='n'?'checked':'') ?>> 禁用
		                </label>
		              </div>
		            </div>
					<div class="form-group">
		              <label for="coupon_method" class="col-md-2 control-label">＊優惠券類型：</label>
		              <div class="col-md-4">
		                <select class="form-control" id="coupon_method" name="coupon_method">
		                  <option value="cash" <?php echo (get_setting_general('coupon_method')=='cash'?'selected':'') ?>>現金折扣</option>
		                  <option value="percent" <?php echo (get_setting_general('coupon_method')=='percent'?'selected':'') ?>>百分比折扣</option>
		                </select>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="coupon_number" class="col-md-2 control-label">＊優惠券折扣：</label>
		              <div class="col-md-4">
		                <input type="number" class="form-control" id="coupon_number" name="coupon_number" value="<?php echo get_setting_general('coupon_number') ?>" required>
		                <p>現金折扣直接輸入數字, 例如: 折扣11元則輸入「11」, 百分比折扣則輸入小數點, 例如: 打85折則輸入「0.85」</p>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="coupon_use_limit" class="col-md-2 control-label">次數限定</label>
		              <div class="col-md-4">
		                <label class="radio-inline">
		                  <input type="radio" name="coupon_use_limit" id="coupon_use_limit1" value="once" <?php echo (get_setting_general('coupon_use_limit')=='once'?'checked':'') ?>> 使用一次
		                </label>
		                <label class="radio-inline">
		                  <input type="radio" name="coupon_use_limit" id="coupon_use_limit2" value="repeat" <?php echo (get_setting_general('coupon_use_limit')=='repeat'?'checked':'') ?>> 多次使用
		                </label>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="coupon_amount_limit" class="col-md-2 control-label">金額限定</label>
		              <div class="col-md-9">
		                <div class="form-inline">
		                  <select name="coupon_amount_limit" id="coupon_amount_limit" class="form-control">
		                    <option value="1" <?php echo (get_setting_general('coupon_amount_limit')=='1'?'selected':'') ?>>啟用</option>
		                    <option value="0" <?php echo (get_setting_general('coupon_amount_limit')=='0'?'selected':'') ?>>停用</option>
		                  </select>
		                  <label>金額</label>
		                  <input type="number" class="form-control" name="coupon_amount_limit_number" id="coupon_amount_limit_number" value="<?php echo get_setting_general('coupon_amount_limit_number') ?>">
		                  <label>以上</label>
		                </div>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="coupon_localtion_limit" class="col-md-2 control-label">地區限定</label>
		              <div class="col-md-9">
		                <div class="form-inline" id="twzipcode">
		                  <div class="pull-left">
		                    <select name="coupon_localtion_limit" id="coupon_localtion_limit" class="form-control">
		                      <option value="1" <?php echo (get_setting_general('coupon_localtion_limit')=='1'?'selected':'') ?>>啟用</option>
		                      <option value="0" <?php echo (get_setting_general('coupon_localtion_limit')=='0'?'selected':'') ?>>停用</option>
		                    </select>
		                  </div>
		                  <div data-role="county" data-name="coupon_localtion_county" data-id="coupon_localtion_county" data-style="form-control pull-left"></div>
		                  <div data-role="district" data-name="coupon_localtion_district" data-id="coupon_localtion_district" data-style="form-control pull-left"></div>
		                </div>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="coupon_product_limit" class="col-md-2 control-label">商品限定</label>
		              <div class="col-md-9">
		                <div class="form-inline">
		                  <select name="coupon_product_limit" id="coupon_product_limit" class="form-control">
		                    <option value="1" <?php echo (get_setting_general('coupon_product_limit')=='1'?'selected':'') ?>>啟用</option>
		                    <option value="0" <?php echo (get_setting_general('coupon_product_limit')=='0'?'selected':'') ?>>停用</option>
		                  </select>
		                  <div style="display: inline-block;">
		                    <?php if(!empty($product)):
		                      $att = 'id="coupon_product_limit_product" class="form-control chosen" data-rule-required="true"';
		                      $data = array('0' => '請選擇商品');
		                      foreach ($product as $c)
		                      {
		                        $data[$c['product_id']] = $c['product_name'];
		                      }
		                      echo form_dropdown('coupon_product_limit_product', $data, get_setting_general('coupon_product_limit_product'), $att);
		                    else:
		                      echo '<label>沒有商品</label><input type="text" class="form-control" id="coupon_product_limit_product" name="coupon_product_limit_product" value="0" readonly>';
		                    endif; ?>
		                  </div>
		                  <label>類型</label>
		                  <select name="coupon_product_limit_type" id="coupon_product_limit_type" class="form-control">
		                    <option value="qty" <?php echo (get_setting_general('coupon_product_limit_type')=='qty'?'selected':'') ?>>數量</option>
		                    <option value="price" <?php echo (get_setting_general('coupon_product_limit_type')=='price'?'selected':'') ?>>價格</option>
		                  </select>
		                  <label>數額</label>
		                  <input type="number" class="form-control" name="coupon_product_limit_number" id="coupon_product_limit_number" value="<?php echo get_setting_general('coupon_product_limit_number') ?>">
		                </div>
		              </div>
		            </div>
		            <div class="form-group">
		              <label for="coupon_birthday_only" class="col-md-2 control-label">壽星限定</label>
		              <div class="col-md-9">
		              	<div class="form-inline">
			                <select class="form-control" id="coupon_birthday_only" name="coupon_birthday_only">
			                  	<option value="1" <?php echo (get_setting_general('coupon_birthday_only')=='1'?'selected':'') ?>>是</option>
			                  	<option value="0" <?php echo (get_setting_general('coupon_birthday_only')=='0'?'selected':'') ?>>否</option>
			                </select>
		              	</div>
		              </div>
		            </div>
		            <div class="form-group">
		              <label class="col-md-2 control-label">＊上下架日期：</label>
		              <div class="col-md-3">
		                <input type="text" class="form-control datetimepicker" name="coupon_on_date" id="coupon_on_date" value="<?php echo get_setting_general('coupon_on_date') ?>" required>
		              </div>
		              <div class="col-md-1 text-center">～</div>
		              <div class="col-md-3">
		                <input type="text" class="form-control datetimepicker" name="coupon_off_date" id="coupon_off_date" value="<?php echo get_setting_general('coupon_off_date') ?>" required>
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