<style>
select.district {
  margin-right: : 5px;
}
.zipcode{
  display: none!important;
}
</style>
<div class="row">
  <?php $attributes = array('class' => 'coupon', 'id' => 'coupon'); ?>
  <?php echo form_open('admin/coupon/insert' , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">建立</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="coupon_name" class="col-md-2 control-label">＊優惠券名稱：</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="coupon_name" id="coupon_name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_code" class="col-md-2 control-label">＊優惠券代碼：</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="coupon_code" id="coupon_code" required>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_method" class="col-md-2 control-label">＊優惠券類型：</label>
              <div class="col-md-4">
                <select class="form-control" id="coupon_method" name="coupon_method">
                  <option value="cash">現金折扣</option>
                  <option value="percent">百分比折扣</option>
                  <option value="free_shipping">免運費</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_number" class="col-md-2 control-label">＊優惠券折扣：</label>
              <div class="col-md-4">
                <input type="number" class="form-control" id="coupon_number" name="coupon_number" value="0" required>
                <p>現金折扣直接輸入數字, 例如: 折扣11元則輸入「11」, 百分比折扣則輸入小數點, 例如: 打85折則輸入「0.85」</p>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_use_limit" class="col-md-2 control-label">次數限定：</label>
              <div class="col-md-4">
                <label class="radio-inline">
                  <input type="radio" name="coupon_use_limit" id="coupon_use_limit1" value="once" checked=""> 使用一次
                </label>
                <label class="radio-inline">
                  <input type="radio" name="coupon_use_limit" id="coupon_use_limit2" value="repeat"> 多次使用
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_store_limit" class="col-md-2 control-label">店家限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <div style="display: inline-block;">
                    <?php if(!empty($store)):
                      $att = 'id="coupon_store_limit" class="form-control chosen" data-rule-required="true"';
                      $data = array('0' => '請選擇店家');
                      foreach ($store as $c)
                      {
                        $data[$c['store_id']] = $c['store_name'];
                      }
                      echo form_dropdown('coupon_store_limit', $data, '0', $att);
                    else:
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
                    <option value="1">啟用</option>
                    <option value="0" selected>停用</option>
                  </select>
                  <label>金額</label>
                  <input type="number" class="form-control" name="coupon_amount_limit_number" id="coupon_amount_limit_number">
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
                      <option value="1">啟用</option>
                      <option value="0" selected>停用</option>
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
                    <option value="1">啟用</option>
                    <option value="0" selected>停用</option>
                  </select>
                  <div style="display: inline-block;">
                    <?php if(!empty($product)):
                      $att = 'id="coupon_product_limit_product" class="form-control chosen" data-rule-required="true"';
                      $data = array('0' => '請選擇商品');
                      foreach ($product as $c)
                      {
                        $data[$c['product_id']] = $c['product_name'];
                      }
                      echo form_dropdown('coupon_product_limit_product', $data, '0', $att);
                    else:
                      echo '<label>沒有商品</label><input type="text" class="form-control" id="coupon_product_limit_product" name="coupon_product_limit_product" value="0" readonly>';
                    endif; ?>
                  </div>
                  <label>類型</label>
                  <select name="coupon_product_limit_type" id="coupon_product_limit_type" class="form-control">
                    <option value="qty">數量</option>
                    <option value="price">價格</option>
                  </select>
                  <label>數額</label>
                  <input type="number" class="form-control" name="coupon_product_limit_number" id="coupon_product_limit_number">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="coupon_birthday_only" class="col-md-2 control-label">壽星限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select class="form-control" id="coupon_birthday_only" name="coupon_birthday_only">
                    <option value="1">是</option>
                    <option value="0" selected>否</option>
                  </select>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox1" value="01"> 1月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox2" value="02"> 2月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox3" value="03"> 3月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox4" value="04"> 4月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox5" value="05"> 5月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox6" value="06"> 6月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox7" value="07"> 7月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox8" value="08"> 8月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox9" value="09"> 9月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox10" value="10"> 10月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox11" value="11"> 11月
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="coupon_birthday_month[]" id="inlineCheckbox12" value="12"> 12月
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">＊上下架日期：</label>
              <div class="col-md-3">
                <input type="text" class="form-control datetimepicker" name="coupon_on_date" id="coupon_on_date" required>
              </div>
              <div class="col-md-1 text-center">～</div>
              <div class="col-md-3">
                <input type="text" class="form-control datetimepicker" name="coupon_off_date" id="coupon_off_date" required>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php echo form_close() ?>
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
      'hideCounty' : [<?php if(!empty($hide_county)){ foreach($hide_county as $hc){ echo '"'.$hc.'",'; }} ?>],
      'hideDistrict': [<?php if(!empty($hide_district)){ foreach($hide_district as $hd){ echo '"'.$hd.'",'; }} ?>]
  });
</script>