<style>
select.county {
  width: 48%;
  float: left;
}
select.district {
  width: 48%;
  float: left;
  margin-left: 4%;
}
input.zipcode{
  width:33%;
  display: none;
}
</style>
<div class="row">
  <?php $attributes = array('class' => 'edit_order_time_form', 'id' => 'edit_order_time_form'); ?>
  <?php echo form_open('admin/store_order_time/update/'.$id , $attributes); ?>
    <div class="col-md-12">
      <div class="form-group">
        <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
        <!-- <button type="submit" class="btn btn-primary">修改</button> -->
        <span class="btn btn-primary" onclick="edit_form_check()">修改</span>
        <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <h4><?php echo $store['store_name'] ?> - 可訂購時段：</h4>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊可訂購日：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="text" class="form-control" name="store_order_time" value="<?php echo $store_order_time['store_order_time'] ?>" autocomplete="off" required="" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊結單時間：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="text" class="form-control timepicker" data-date-format="HH:mm:ss" name="store_close_time" value="<?php echo $store_order_time['store_close_time'] ?>" autocomplete="off" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊運費：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="number" class="form-control" name="delivery_cost" value="<?php echo $store_order_time['delivery_cost'] ?>" autocomplete="off" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊取餐區：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <div id="twzipcode4">
                      <div data-role="county" data-name="delivery_county" data-required="1"></div>
                      <div data-role="district" data-name="delivery_district" data-required="1"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row checkbox-group required" style="padding-top: 15px;">
            <div class="col-md-6">
              <div style="display: <?php echo (check_have_string($store['store_support_time'],'早餐')?'block':'none') ?>">
              <label>早餐時段：</label>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="07:00-07:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'07:00-07:30') ?>> 07:00-07:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="07:30-08:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'07:30-08:00') ?>> 07:30-08:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="08:00-08:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'08:00-08:30') ?>> 08:00-08:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="08:30-09:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'08:30-09:00') ?>> 08:30-09:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="09:00-09:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'09:00-09:30') ?>> 09:00-09:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="09:30-10:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'09:30-10:00') ?>> 09:30-10:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="10:00-10:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'10:00-10:30') ?>> 10:00-10:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="10:30-11:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'10:30-11:00') ?>> 10:30-11:00
                    </label>
                </div>
              </div>
              <div style="display: <?php echo (check_have_string($store['store_support_time'],'午餐')?'block':'none') ?>">
                <label>午餐時段：</label>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="11:00-11:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'11:00-11:30') ?>> 11:00-11:30
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="11:30-12:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'11:30-12:00') ?>> 11:30-12:00
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="12:00-12:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'12:00-12:30') ?>> 12:00-12:30
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="12:30-13:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'12:30-13:00') ?>> 12:30-13:00
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="13:00-13:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'13:00-13:30') ?>> 13:00-13:30
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="13:30-14:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'13:30-14:00') ?>> 13:30-14:00
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="14:00-14:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'14:00-14:30') ?>> 14:00-14:30
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="14:30-15:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'14:30-15:00') ?>> 14:30-15:00
                      </label>
                  </div>
                </div>
                <div style="display: <?php echo (check_have_string($store['store_support_time'],'下午茶')?'block':'none') ?>">
                  <label>下午茶時段：</label>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="15:00-15:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'15:00-15:30') ?>> 15:00-15:30
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="15:30-16:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'15:30-16:00') ?>> 15:30-16:00
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="16:00-17:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'16:00-17:30') ?>> 16:00-17:30
                      </label>
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="delivery_time[]" value="17:30-18:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'17:30-18:00') ?>> 17:30-18:00
                      </label>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div style="display: <?php echo (check_have_string($store['store_support_time'],'晚餐')?'block':'none') ?>">
                <label>晚餐時段：</label>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="18:00-18:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'18:00-18:30') ?>> 18:00-18:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="18:30-19:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'18:30-19:00') ?>> 18:30-19:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="19:00-19:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'19:00-19:30') ?>> 19:00-19:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="19:30-20:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'19:30-20:00') ?>> 19:30-20:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="20:00-20:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'20:00-20:30') ?>> 20:00-20:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="20:30-21:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'20:30-21:00') ?>> 20:30-21:00
                    </label>
                </div>
              </div>
              <div style="display: <?php echo (check_have_string($store['store_support_time'],'宵夜')?'block':'none') ?>">
                <label>宵夜時段：</label>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="21:00-21:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'21:00-21:30') ?>> 21:00-21:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="21:30-22:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'21:30-22:00') ?>> 21:30-22:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="22:00-22:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'22:00-22:30') ?>> 22:00-22:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="22:30-23:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'22:30-23:00') ?>> 22:30-23:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="23:00-23:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'23:00-23:30') ?>> 23:00-23:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="23:30-00:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'23:30-00:00') ?>> 23:30-00:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="00:00-00:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'00:00-00:30') ?>> 00:00-00:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="00:30-01:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'00:30-01:00') ?>> 00:30-01:00
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="01:00-01:30" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'01:00-01:30') ?>> 01:00-01:30
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="delivery_time[]" value="01:30-02:00" <?php echo check_delivery_time($store_order_time['store_order_time_id'],'01:30-02:00') ?>> 01:30-02:00
                    </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php if(!empty($product)) { ?>
              <table class="table table-bordered">
                <tr class="info">
                  <th style="width: 20%;">啟用</th>
                  <th style="width: 40%;">名稱</th>
                  <th style="width: 20%;">每日庫存</th>
                  <th style="width: 20%;">限購份數</th>
                </tr>
                <?php foreach($product as $data) { ?>
                  <?php
                  $checked = null;
                  $aaa = null;
                  $bbb = null;
                  ?>
                  <?php if(!empty($store_order_time_item)) { ?>
                  <?php foreach($store_order_time_item as $sott) { ?>
                    <?php
                    if($data['product_id']==$sott['product_id']){
                      $checked = '1';
                      $aaa = $sott['product_daily_stock'];
                      $bbb = $sott['product_person_buy'];
                      break;
                    } else {
                      //
                    } ?>
                  <?php }} ?>
                  <tr>
                    <td class="text-center">
                      <select name="use[]" class="form-control">
                        <option value="1" <?php echo ($checked==1)?('selected'):('') ?>>Ｏ</option>
                        <option value="0" <?php echo ($checked==0)?('selected'):('') ?>>Ｘ</option>
                      </select>
                      <input type="hidden" name="product_id[]" value="<?php echo $data['product_id'] ?>">
                    </td>
                    <td><?php echo $data['product_name'] ?></td>
                    <td>
                      <input type="text" class="form-control" name="product_daily_stock[]" value="<?php echo ($aaa=='')?('0'):($aaa) ?>" placeholder="每日庫存">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="product_person_buy[]" value="<?php echo ($bbb=='')?('0'):($bbb) ?>" placeholder="每人限購份數">
                    </td>
                  </tr>
                <?php } ?>
              </table>
            <?php } ?>
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
    document.getElementById("create_product").submit();
    //alert("submitted!");
  }
});

$(document).ready(function() {
  $("#create_product").validate({});
});

$('.fancybox').fancybox({
  'width'     : 1920,
  'height'    : 1080,
  'type'      : 'iframe',
  'autoScale' : false
});

// $('.datepicker').datepicker({
//   format: "yyyy-mm-dd",
//   autoclose: true,
//   clearBtn: true,
//   todayBtn: true,
//   todayHighlight: true,
//   language: 'zh-TW'
// });

$('.datetimepicker').datetimepicker({
    locale: 'zh-TW',
    format: 'YYYY-MM-DD HH:mm:ss'
});

$('.timepicker').datetimepicker({
    locale: 'zh-TW',
    format: 'HH:mm'
});

function edit_form_check()
{
  if( $('div.checkbox-group.required :checkbox:checked').length > 0 ){
    $('#edit_order_time_form').submit();
  } else {
    alert('請選擇送餐時段。');
  }
}

</script>

<script>
  $('#twzipcode4').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'countySel'   : '<?php echo $store_order_time['delivery_county'] ?>',
      'districtSel' : '<?php echo $store_order_time['delivery_district'] ?>',
      // 'hideCounty' : [<?php if(!empty($hide_county)){ foreach($hide_county as $hc){ echo '"'.$hc.'",'; }} ?>],
      // 'hideDistrict': [<?php if(!empty($hide_district)){ foreach($hide_district as $hd){ echo '"'.$hd.'",'; }} ?>]
      'hideDistrict': ['全區']
  });
</script>