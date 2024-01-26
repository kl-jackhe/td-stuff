<style>
  select.district {
    margin-right: : 5px;
  }

  .zipcode {
    display: none !important;
  }

  label.required::before {
    content: '*';
    color: red;
    margin-right: 5px;
  }
</style>
<div class="row">
  <?php $attributes = array('class' => 'coupon', 'id' => 'coupon'); ?>
  <?php echo form_open('admin/coupon/update/' . $coupon['coupon_id'], $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
      <input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo $coupon['coupon_id'] ?>">
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="coupon_name" class="col-md-2 control-label required">優惠券名稱：</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="coupon_name" id="coupon_name" value="<?php echo $coupon['coupon_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_code" class="col-md-2 control-label required">優惠券代碼：</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="coupon_code" id="coupon_code" value="<?php echo $coupon['coupon_code'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_method" class="col-md-2 control-label required">優惠券類型：</label>
              <div class="col-md-4">
                <select class="form-control" id="coupon_method" name="coupon_method">
                  <option value="cash" <?php echo ($coupon['coupon_method'] == 'cash') ? ("selected") : (""); ?>>現金折扣</option>
                  <option value="percent" <?php echo ($coupon['coupon_method'] == 'percent') ? ("selected") : (""); ?>>百分比折扣</option>
                  <option value="free_shipping" <?php echo ($coupon['coupon_method'] == 'free_shipping') ? ("selected") : (""); ?>>免運費</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_number" class="col-md-2 control-label required">優惠券折扣：</label>
              <div class="col-md-4">
                <input type="number" class="form-control" id="coupon_number" name="coupon_number" value="<?php echo $coupon['coupon_number'] ?>" required>
                <p>現金折扣直接輸入數字, 例如: 折扣11元則輸入「11」, 百分比折扣則輸入小數點, 例如: 打85折則輸入「0.85」</p>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_use_limit" class="col-md-2 control-label">次數限定：</label>
              <div class="col-md-4">
                <label class="radio-inline">
                  <input type="radio" name="coupon_use_limit" id="coupon_use_limit1" value="once" <?php echo ($coupon['coupon_use_limit'] == 'once') ? ("checked") : (""); ?>> 使用一次
                </label>
                <label class="radio-inline">
                  <input type="radio" name="coupon_use_limit" id="coupon_use_limit2" value="repeat" <?php echo ($coupon['coupon_use_limit'] == 'repeat') ? ("checked") : (""); ?>> 多次使用
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_store_limit" class="col-md-2 control-label">店家限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <div style="display: inline-block;">
                    <?php if (!empty($store)) :
                      $att = 'id="coupon_store_limit" class="form-control chosen" data-rule-required="true"';
                      $data = array('0' => '請選擇店家');
                      foreach ($store as $c) {
                        $data[$c['store_id']] = $c['store_name'];
                      }
                      echo form_dropdown('coupon_store_limit', $data, $coupon['coupon_store_limit'], $att);
                    else :
                      echo '<input type="text" class="form-control" id="coupon_store_limit" name="coupon_store_limit" value="0" readonly>';
                    endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_amount_limit" class="col-md-2 control-label">金額限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select name="coupon_amount_limit" id="coupon_amount_limit" class="form-control">
                    <option value="1" <?php echo ($coupon['coupon_amount_limit'] == '1') ? ("selected") : (""); ?>>啟用</option>
                    <option value="0" <?php echo ($coupon['coupon_amount_limit'] != '1') ? ("selected") : (""); ?>>停用</option>
                  </select>
                  <label>金額</label>
                  <input type="number" class="form-control" name="coupon_amount_limit_number" id="coupon_amount_limit_number" value="<?php echo $coupon['coupon_amount_limit_number'] ?>">
                  <label>以上</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_localtion_limit" class="col-md-2 control-label">地區限定：</label>
              <div class="col-md-9">
                <div class="form-inline" id="twzipcode">
                  <div class="pull-left">
                    <select name="coupon_localtion_limit" id="coupon_localtion_limit" class="form-control">
                      <option value="1" <?php echo ($coupon['coupon_localtion_limit'] == '1') ? ("selected") : (""); ?>>啟用</option>
                      <option value="0" <?php echo ($coupon['coupon_localtion_limit'] != '1') ? ("selected") : (""); ?>>停用</option>
                    </select>
                  </div>
                  <div data-role="county" data-name="coupon_localtion_county" data-id="coupon_localtion_county" data-style="form-control pull-left"></div>
                  <div data-role="district" data-name="coupon_localtion_district" data-id="coupon_localtion_district" data-style="form-control pull-left"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_product_limit" class="col-md-2 control-label">商品限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select name="coupon_product_limit" id="coupon_product_limit" class="form-control">
                    <option value="1" <?php echo ($coupon['coupon_product_limit'] == '1') ? ("selected") : (""); ?>>啟用</option>
                    <option value="0" <?php echo ($coupon['coupon_product_limit'] != '1') ? ("selected") : (""); ?>>停用</option>
                  </select>
                  <div style="display: inline-block;">
                    <?php if (!empty($product)) :
                      $att = 'id="coupon_product_limit_product" class="form-control chosen" data-rule-required="true"';
                      $data = array('請選擇商品');
                      foreach ($product as $c) {
                        $data[$c['product_id']] = $c['product_name'];
                      }
                      echo form_dropdown('coupon_product_limit_product', $data, $coupon['coupon_product_limit_product'], $att);
                    else :
                      echo '<label>沒有商品</label><input type="text" class="form-control" id="coupon_product_limit_product" name="coupon_product_limit_product" value="0" readonly>';
                    endif; ?>
                  </div>
                  <label>類型</label>
                  <select name="coupon_product_limit_type" id="coupon_product_limit_type" class="form-control">
                    <option value="qty" <?php echo ($coupon['coupon_product_limit_type'] == 'qty') ? ("selected") : (""); ?>>數量</option>
                    <option value="price" <?php echo ($coupon['coupon_product_limit_type'] == 'price') ? ("selected") : (""); ?>>價格</option>
                  </select>
                  <label>數額</label>
                  <input type="number" class="form-control" name="coupon_product_limit_number" id="coupon_product_limit_number" value="<?php echo $coupon['coupon_product_limit_number'] ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_birthday_only" class="col-md-2 control-label">壽星限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select class="form-control" id="coupon_birthday_only" name="coupon_birthday_only">
                    <option value="1" <?php echo ($coupon['coupon_birthday_only'] == '1') ? ("selected") : (""); ?>>是</option>
                    <option value="0" <?php echo ($coupon['coupon_birthday_only'] != '1') ? ("selected") : (""); ?>>否</option>
                  </select>
                  <?php
                  $value_01 = '';
                  $value_03 = '';
                  $value_04 = '';
                  $value_02 = '';
                  $value_05 = '';
                  $value_06 = '';
                  $value_07 = '';
                  $value_08 = '';
                  $value_09 = '';
                  $value_10 = '';
                  $value_11 = '';
                  $value_12 = '';
                  foreach (explode(',', $coupon['coupon_birthday_month']) as $value) {
                    if ($value == '01') {
                      $value_01 = true;
                    };
                    if ($value == '02') {
                      $value_02 = true;
                    };
                    if ($value == '03') {
                      $value_03 = true;
                    };
                    if ($value == '04') {
                      $value_04 = true;
                    };
                    if ($value == '05') {
                      $value_05 = true;
                    };
                    if ($value == '06') {
                      $value_06 = true;
                    };
                    if ($value == '07') {
                      $value_07 = true;
                    };
                    if ($value == '08') {
                      $value_08 = true;
                    };
                    if ($value == '09') {
                      $value_09 = true;
                    };
                    if ($value == '10') {
                      $value_10 = true;
                    };
                    if ($value == '11') {
                      $value_11 = true;
                    };
                    if ($value == '12') {
                      $value_12 = true;
                    };
                  }
                  ?>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox1" value="01" <?php echo ($value_01 ? 'checked' : '') ?>> 1月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox2" value="02" <?php echo ($value_02 ? 'checked' : '') ?>> 2月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox3" value="03" <?php echo ($value_03 ? 'checked' : '') ?>> 3月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox4" value="04" <?php echo ($value_04 ? 'checked' : '') ?>> 4月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox5" value="05" <?php echo ($value_05 ? 'checked' : '') ?>> 5月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox6" value="06" <?php echo ($value_06 ? 'checked' : '') ?>> 6月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox7" value="07" <?php echo ($value_07 ? 'checked' : '') ?>> 7月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox8" value="08" <?php echo ($value_08 ? 'checked' : '') ?>> 8月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox9" value="09" <?php echo ($value_09 ? 'checked' : '') ?>> 9月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox10" value="10" <?php echo ($value_10 ? 'checked' : '') ?>> 10月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox11" value="11" <?php echo ($value_11 ? 'checked' : '') ?>> 11月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox12" value="12" <?php echo ($value_12 ? 'checked' : '') ?>> 12月
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label required">上下架日期：</label>
              <div class="col-md-3">
                <input type="text" class="form-control datetimepicker" name="coupon_on_date" id="coupon_on_date" value="<?php echo $coupon['coupon_on_date'] ?>" required>
              </div>
              <div class="col-md-1 text-center">～</div>
              <div class="col-md-3">
                <input type="text" class="form-control datetimepicker" name="coupon_off_date" id="coupon_off_date" value="<?php echo $coupon['coupon_off_date'] ?>" required>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php echo form_close() ?>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="border: 1px solid #ccc; padding: 10px; max-height: 200px; overflow-y: auto;">
      <table class="table table-bordered table-striped table-condensed">
        <tr class="info">
          <th width="25%">
            欄位
          </th>
          <th width="25%">
            值
          </th>
          <th width="25%">
            更新者
          </th>
          <th width="25%">
            更新時間
          </th>
        </tr>
        <?php if (!empty($change_log)) {
          foreach ($change_log as $cl) { ?>
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
        <?php }
        } ?>
      </table>
    </div>
  </div>
</div>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
  $.validator.setDefaults({
    submitHandler: function() {
      document.getElementById("coupon").submit();
      //alert("submitted!");
    }
  });
  $(document).ready(function() {
    $("#coupon").validate({});
  });
</script>

<script>
  $('#twzipcode').twzipcode({
    // 'detect': true, // 預設值為 false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'countySel': '<?php echo $coupon['coupon_localtion_county'] ?>',
    'districtSel': '<?php echo $coupon['coupon_localtion_district'] ?>',
    'hideCounty': [<?php if (!empty($hide_county)) {
                      foreach ($hide_county as $hc) {
                        echo '"' . $hc . '",';
                      }
                    } ?>],
    'hideDistrict': [<?php if (!empty($hide_district)) {
                        foreach ($hide_district as $hd) {
                          echo '"' . $hd . '",';
                        }
                      } ?>]
  });
</script>