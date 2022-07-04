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
  <?php $attributes = array('class' => 'create_order_time_form', 'id' => 'create_order_time_form'); ?>
  <?php echo form_open('admin/store_order_time_area/insert' , $attributes); ?>
    <div class="col-md-12">
      <div class="form-group">
        <!-- <input type="hidden" name="store_id" value="<?php // echo $store_id; ?>"> -->
        <!-- <button type="submit" class="btn btn-primary">建立</button> -->
        <span class="btn btn-primary" onclick="create_form_check()">建立</span>
        <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <!-- <div class="form-group">
                <h4><?php // echo $store['store_name'] ?> - 可訂購時段：</h4>
              </div> -->
              <?php $row = implode(',', $_POST['store']); ?>
              <input type="hidden" name="store" value="<?php echo $row ?>">
              <div class="form-group">
                <label class="col-md-4 control-label">＊可訂購日：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="create_date_pick"><i class="fa fa-calendar"></i></span>
                        <input class="form-control" type="text" name="store_order_time_area" id="create_store_order_time_area" required="" autocomplete="off">
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <input type="text" class="form-control" id="create_store_order_time_area" name="store_order_time_area" autocomplete="off" required="">
                  </div> -->
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊結單時間：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="text" class="form-control timepicker" data-date-format="HH:mm" name="store_close_time" autocomplete="off" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊運費：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input type="number" class="form-control" name="delivery_cost" autocomplete="off" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">＊取餐區：</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <div id="twzipcode3">
                      <div data-role="county" data-name="delivery_county" data-required="1"></div>
                      <div data-role="district" data-name="delivery_district" data-required="1"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 checkbox-group required" style="padding-top: 15px;">
              <div class="row">
                <!-- <div class="col-md-2" style="display: <?php // echo (check_have_string($store['store_support_time'],'早餐')?'block':'none') ?>">
                  <label>早餐時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='早餐') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>"> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div> -->
                <div class="col-md-2" style="display: <?php // echo (check_have_string($store['store_support_time'],'午餐')?'block':'none') ?>">
                  <label>午餐時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='午餐') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>"> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
                <div class="col-md-2" style="display: <?php // echo (check_have_string($store['store_support_time'],'下午茶')?'block':'none') ?>">
                  <label>下午茶時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='下午茶') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>"> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
                <div class="col-md-2" style="display: <?php // echo (check_have_string($store['store_support_time'],'晚餐')?'block':'none') ?>">
                  <label>晚餐時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='晚餐') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>"> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
                <div class="col-md-2" style="display: <?php // echo (check_have_string($store['store_support_time'],'宵夜')?'block':'none') ?>">
                  <label>宵夜時段：</label>
                  <?php if(!empty($meal_time)) { foreach($meal_time as $mt) { ?>
                    <?php if($mt['meal_time_type']=='宵夜') { ?>
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="delivery_time[]" value="<?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>"> <?php echo $mt['meal_time_content_start'].'-'.$mt['meal_time_content_end'] ?>
                          </label>
                      </div>
                    <?php } ?>
                  <?php }} ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if(!empty($_POST['store'])){
          for($i = 0; $i < count($_POST['store']); $i++){
            // echo $_POST['store'][$i].', ';
            $this->db->where('store_id', $_POST['store'][$i]);
            $query = $this->db->get('product');
            if($query->num_rows()>0){ ?>
              <div class="col-md-12">
                  <h3><?php echo get_store_name($_POST['store'][$i]) ?></h3>
                  <div class="form-group">
                    <table class="table table-bordered">
                      <tr class="info">
                        <th style="width: 20%;">啟用</th>
                        <th style="width: 40%;">名稱</th>
                        <th style="width: 20%;">每日庫存</th>
                        <th style="width: 20%;">限購份數</th>
                      </tr>
                      <?php foreach($query->result_array() as $data){ ?>
                        <tr>
                          <td class="text-center">
                            <select name="use[]" class="form-control">
                              <option value="1">Ｏ</option>
                              <option value="0">Ｘ</option>
                            </select>
                            <input type="hidden" name="product_id[]" value="<?php echo $data['product_id'] ?>">
                            <input type="hidden" name="store_id[]" value="<?php echo $data['store_id'] ?>">
                          </td>
                          <td><?php echo $data['product_name'] ?></td>
                          <td>
                            <input type="text" class="form-control" name="product_daily_stock[]" value="<?php echo $data['product_daily_stock'] ?>">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="product_person_buy[]" value="<?php echo $data['product_person_buy'] ?>">
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                  </div>
                </div>
          <?php }}
        } ?>
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

$('.datepicker_mu').datepicker({
  format: "yyyy-mm-dd",
  //autoclose: true,
  clearBtn: true,
  todayBtn: true,
  todayHighlight: true,
  weekStart: 0,
  multidate: true,
  language: 'zh-TW'
});

$('.datetimepicker').datetimepicker({
    locale: 'zh-TW',
    format: 'YYYY-MM-DD HH:mm:ss'
});

$('.timepicker').datetimepicker({
    locale: 'zh-TW',
    format: 'HH:mm'
});

function create_form_check()
{
  if( $('div.checkbox-group.required :checkbox:checked').length > 0 ){
    $('#create_order_time_form').submit();
  } else {
    alert('請選擇送餐時段。');
  }
}

</script>

<script>
  $('#twzipcode3').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
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
        $('input#create_store_order_time_area').val("");
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
            $('input#create_store_order_time_area').val(res);
        }
        //$('#create_store_order_time_area').datepicker('remove');
        // 毎選擇一次日期範圍，日期選擇器也會更新
        // $('#create_store_order_time_area').datepicker('update');
    }
);
$(document).on('click', '.cancelBtn', function() {
    //$('input.cancelBtn').on("cancel.daterangepicker", function(ev, picker) {
    //$(this).val("");
    $('input#create_store_order_time_area').val("");
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