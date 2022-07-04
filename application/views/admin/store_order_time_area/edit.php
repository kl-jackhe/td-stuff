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
  <?php echo form_open('admin/store_order_time_area/update/'.$id , $attributes); ?>
    <div class="col-md-12">
      <div class="form-group">
        <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
        <!-- <button type="submit" class="btn btn-primary">修改</button> -->
        <span class="btn btn-primary" onclick="edit_form_check()">修改</span>
        <!-- <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a> -->
        &nbsp;<span>可訂購時段：<?php echo $store_order_time_area['store_order_time_area'] ?></span>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <!-- <div class="form-group">
                <h3><?php echo $store['store_name'] ?> - 可訂購時段：<?php echo $store_order_time_area['store_order_time_area'] ?></h3>
              </div> -->
              <div class="form-group">
                <label class="col-md-4 control-label">＊可訂購日：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon" id="create_date_pick"><i class="fa fa-calendar"></i></span>
                      <input type="text" class="form-control" name="store_order_time_area" id="edit_store_order_time_area" value="<?php echo $store_order_time_area['store_order_time'] ?>" autocomplete="off" required="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊結單時間：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="text" class="form-control timepicker" data-date-format="HH:mm:ss" name="store_close_time" value="<?php echo $store_order_time_area['store_close_time'] ?>" autocomplete="off" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊運費：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="number" class="form-control" name="delivery_cost" value="<?php echo $store_order_time_area['delivery_cost'] ?>" autocomplete="off" required="">
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
            <div class="col-md-12 checkbox-group required" style="padding-top: 15px;">
              <div class="row">
                <!-- <div class="col-md-2" style="display: <?php echo (check_have_string($store['store_support_time'],'早餐')?'block':'none') ?>">
                  <label>早餐時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='早餐') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>" <?php echo check_area_delivery_time($store_order_time_area['store_order_time_area_id'], $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end']) ?>> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div> -->
                <div class="col-md-2" style="display: <?php echo (check_have_string($store['store_support_time'],'午餐')?'block':'none') ?>">
                  <label>午餐時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='午餐') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>" <?php echo check_area_delivery_time($store_order_time_area['store_order_time_area_id'], $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end']) ?>> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
                <div class="col-md-2" style="display: <?php echo (check_have_string($store['store_support_time'],'下午茶')?'block':'none') ?>">
                  <label>下午茶時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='下午茶') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>" <?php echo check_area_delivery_time($store_order_time_area['store_order_time_area_id'], $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end']) ?>> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
                <div class="col-md-2" style="display: <?php echo (check_have_string($store['store_support_time'],'晚餐')?'block':'none') ?>">
                  <label>晚餐時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='晚餐') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>" <?php echo check_area_delivery_time($store_order_time_area['store_order_time_area_id'], $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end']) ?>> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
                <div class="col-md-2" style="display: <?php echo (check_have_string($store['store_support_time'],'宵夜')?'block':'none') ?>">
                  <label>宵夜時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='宵夜') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>" <?php echo check_area_delivery_time($store_order_time_area['store_order_time_area_id'], $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end']) ?>> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <h3><?php echo $store['store_name'] ?></h3>
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
                  <?php if(!empty($store_order_time_area_item)) { ?>
                  <?php foreach($store_order_time_area_item as $sott) { ?>
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

<!-- <script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<!-- <script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script> -->
<script>
// $.validator.setDefaults({
//   submitHandler: function() {
//     document.getElementById("create_product").submit();
//     //alert("submitted!");
//   }
// });

// $(document).ready(function() {
//   $("#create_product").validate({});
// });

// $('.fancybox').fancybox({
//   'width'     : 1920,
//   'height'    : 1080,
//   'type'      : 'iframe',
//   'autoScale' : false
// });

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
    // $('#edit_order_time_form').submit();

    // $('#save-btn').click(function(e){
        // e.preventDefault();
        var form = $('#edit_order_time_form');
        var url = form.attr('action');
        // console.log( $('#submit_form').serialize() );
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            // contentType: false,
            // cache: false,
            // processData: false,
            success : function(data)
            {
              // console.log('okok');
              searchFilter();
              $('#use-Modal').modal('hide');
              // console.log(data);
            },
            error: function(data)
            {
              console.log('無法送出');
            }
        })
    // });

  } else {
    alert('請選擇送餐時段。');
  }
}

</script>

<script>
  $('#twzipcode4').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'countySel'   : '<?php echo $store_order_time_area['delivery_county'] ?>',
      'districtSel' : '<?php echo $store_order_time_area['delivery_district'] ?>',
      // 'hideCounty' : [<?php if(!empty($hide_county)){ foreach($hide_county as $hc){ echo '"'.$hc.'",'; }} ?>],
      // 'hideDistrict': [<?php if(!empty($hide_district)){ foreach($hide_district as $hd){ echo '"'.$hd.'",'; }} ?>]
      'hideDistrict': ['全區']
  });
</script>

<script>
$('#create_date_pick').daterangepicker({
        // ranges: {
        //     '今天': [moment(new Date()), moment(new Date())],
        //     //'昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
        //     //'後七天': [moment().subtract('days', 6), moment()],
        //     //'後30天': [moment().subtract('days', 29), moment()],
        //     '這個月': [moment().startOf('month'), moment().endOf('month')],
        //     //'下個月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        // },
        opens: 'right',
        locale: {
            format: 'YYYY-MM-DD',
            separator: " ~ ",
            applyLabel: "確定",
            cancelLabel: "清除",
            fromLabel: "開始日期",
            toLabel: "結束日期",
            customRangeLabel: "自訂日期區間",
            daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
            monthNames: ["1月", "2月", "3月", "4月", "5月", "6月",
                "7月", "8月", "9月", "10月", "11月", "12月"
            ],
            firstDay: 0
        },
        // daysOfWeekDisabled: '0,6',
        // singleDatePicker: true,
        // isInvalidDate: function(date) {
        //     return (date.day() == 0 || date.day() == 6);
        // }
    },
    function(start, end) {
        //$('#qqq').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('input#edit_store_order_time_area').val("");
        var dt = new Date(start);
        var res = '';
        startDate = start.format('YYYY-MM-DD');
        endDate = end.format('YYYY-MM-DD');
        //console.log('Start Date: '+startDate);
        //console.log('End Date: '+endDate);
        while (dt < end) {
            result = formatDate(dt);
            //console.log(result);
            dt.setDate(dt.getDate() + 1);
            // 判斷是否為假日 Start
            // var myDate = new Date(result);
            // if (myDate.getDay() == 0 || myDate.getDay() == 6) {
            //     //alert('假日!');
            // } else {
            //     res += result + ',';
            //     //alert('平日!');
            // }
            // 判斷是否為假日 End
            res += result + ',';
            $('input#edit_store_order_time_area').val(res);
        }
        //$('#edit_store_order_time_area').datepicker('remove');
        // 毎選擇一次日期範圍，日期選擇器也會更新
        // $('#edit_store_order_time_area').datepicker('update');
    }
);
$(document).on('click', '.cancelBtn', function() {
    //$('input.cancelBtn').on("cancel.daterangepicker", function(ev, picker) {
    //$(this).val("");
    $('input#edit_store_order_time_area').val("");
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
}
</script>