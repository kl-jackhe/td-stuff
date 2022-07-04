<style>
  .form-horizontal .control-label{
    text-align: left;
  }
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
  <?php $attributes = array('class' => 'store', 'id' => 'store'); ?>
  <?php echo form_open('admin/store/update/'.$store['store_id'] , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal">
            <h4>店家資訊</h4>
            <div class="form-group">
              <label for="store_name" class="col-md-3 control-label">＊店家名稱：</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="store_name" id="store_name" value="<?php echo $store['store_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="store_link" class="col-md-3 control-label">店家詳情：</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="store_link" id="store_link" value="<?php echo $store['store_link'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">＊地址：</label>
              <div class="col-md-9">
                <div id="twzipcode2">
                  <div data-role="county" data-name="store_county" data-required="1"></div>
                  <div data-role="district" data-name="store_district" data-required="1"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label"></label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="address" id="address" value="<?php echo $store['store_address'] ?>" required>
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="store_delivery_cost" class="col-md-3 control-label">＊運費：</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="store_delivery_cost" id="store_delivery_cost" value="<?php echo $store['store_delivery_cost'] ?>" required>
              </div>
            </div> -->
            <div class="form-group">
              <label class="col-md-3 control-label">＊封面照片</label>
              <div class="col-md-9">
                <img src="/assets/uploads/<?php echo $store['store_image'] ?>" id="store_image_preview" class="img-responsive" style="height: 50px;<?php if(empty($store['store_image'])){echo 'display: none';} ?>">

                <input type="hidden" id="store_image" name="store_image" value="<?php echo $store['store_image'] ?>"/>

                <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=store_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">＊Banner照片</label>
              <div class="col-md-9">
                <img src="/assets/uploads/<?php echo $store['store_banner'] ?>" id="store_banner_preview" class="img-responsive" style="height: 50px;<?php if(empty($store['store_banner'])){echo 'display: none';} ?>">

                <input type="hidden" id="store_banner" name="store_banner" value="<?php echo $store['store_banner'] ?>"/>

                <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=store_banner&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">＊營業時間：</label>
              <div class="col-md-3">
                <input type="text" class="form-control timepicker" name="store_open_time" id="store_open_time" value="<?php echo $store['store_open_time'] ?>" required>
              </div>
              <div class="col-md-1">～</div>
              <div class="col-md-3">
                <input type="text" class="form-control timepicker" name="store_closing_time" id="store_closing_time" value="<?php echo $store['store_closing_time'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">＊供餐時段：</label>
              <div class="col-md-9">
                <!-- <label class="checkbox-inline">
                  <input type="checkbox" id="store_support_time1" name="store_support_time[]" value="早餐" <?php echo (check_have_string($store['store_support_time'],'早餐')?'checked':'') ?>> 早餐
                </label> -->
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_support_time2" name="store_support_time[]" value="午餐" <?php echo (check_have_string($store['store_support_time'],'午餐')?'checked':'') ?>> 午餐
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_support_time3" name="store_support_time[]" value="下午茶" <?php echo (check_have_string($store['store_support_time'],'下午茶')?'checked':'') ?>> 下午茶
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_support_time4" name="store_support_time[]" value="晚餐" <?php echo (check_have_string($store['store_support_time'],'晚餐')?'checked':'') ?>> 晚餐
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_support_time5" name="store_support_time[]" value="宵夜" <?php echo (check_have_string($store['store_support_time'],'宵夜')?'checked':'') ?>> 宵夜
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">＊公休日：</label>
              <div class="col-md-9">
                <div>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day1" name="store_off_day[]" value="星期一" <?php echo (check_have_string($store['store_off_day'], '星期一')?'checked':'') ?>> 星期一
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day2" name="store_off_day[]" value="星期二" <?php echo (check_have_string($store['store_off_day'], '星期二')?'checked':'') ?>> 星期二
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day3" name="store_off_day[]" value="星期三" <?php echo (check_have_string($store['store_off_day'], '星期三')?'checked':'') ?>> 星期三
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day4" name="store_off_day[]" value="星期四" <?php echo (check_have_string($store['store_off_day'], '星期四')?'checked':'') ?>> 星期四
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day5" name="store_off_day[]" value="星期五" <?php echo (check_have_string($store['store_off_day'], '星期五')?'checked':'') ?>> 星期五
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day6" name="store_off_day[]" value="星期六" <?php echo (check_have_string($store['store_off_day'], '星期六')?'checked':'') ?>> 星期六
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="store_off_day7" name="store_off_day[]" value="星期日" <?php echo (check_have_string($store['store_off_day'], '星期日')?'checked':'') ?>> 星期日
                </label>
                </div>
                <?php $options = array (
                    "無" => '公休日',
                    "星期一" => '星期一',
                    "星期二" => '星期二',
                    "星期三" => '星期三',
                    "星期四" => '星期四',
                    "星期五" => '星期五',
                    "星期六" => '星期六',
                    "星期日" => '星期日',
                );
                $att = 'class="form-control" id="store_off_day"';
                // echo form_dropdown('store_off_day', $options, $store['store_off_day'], $att); ?>
              </div>
            </div>
            <!-- <div class="form-group">
              <label class="col-md-3 control-label">＊歇業?：</label>
              <div class="col-md-3">
                <?php $options = array (
                    "1" => '否',
                    "2" => '是',
                );
                $att = 'class="form-control" id="store_status"';
                echo form_dropdown('store_status', $options, $store['store_status'], $att); ?>
              </div>
            </div> -->

          </div>
        </div>
        <div class="col-md-6">
          <h4>商品</h4>
          <div class="form-group">
            <a href="/admin/product/create/<?php echo $store['store_id'] ?>" class="btn btn-primary modal-btn">新增商品</a>
          </div>

          <?php if(!empty($product)) { ?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr class="info">
                <th>圖片</th>
                <th>菜名</th>
                <th class="text-center">價格</th>
                <th>每日庫存</th>
                <th>限購份數</th>
                <th>描述</th>
                <th class="text-center">操作</th>
              </tr>
              <?php foreach($product as $data) { ?>
                <tr>
                  <td style="width: 50px;"><?php echo get_image($data['product_image']) ?></td>
                  <td><?php echo $data['product_name'] ?></td>
                  <td class="text-right"><?php echo $data['product_price'] ?></td>
                  <td class="text-right"><?php echo $data['product_daily_stock'] ?></td>
                  <td class="text-right"><?php echo $data['product_person_buy'] ?></td>
                  <td><?php echo $data['product_description'] ?></td>
                  <td>
                    <a href="/admin/product/edit/<?php echo $data['product_id'] ?>" class="btn btn-primary modal-btn">編輯</a>
                    <a href="/admin/product/delete/<?php echo $data['product_id'] ?>" class="btn btn-danger" onClick="return confirm('您確定要刪除嗎?')">刪除</a>
                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>
          <?php } ?>
        </div>

        <!-- -------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------- -->
        <div class="col-md-6 hide">
          <h4>可訂購時段</h4>
          <div class="form-group">
            <a href="/admin/store/order_time_create/<?php echo $store['store_id'] ?>" class="btn btn-primary modal-btn">新增可訂購時段</a>
          </div>
          <?php if(!empty($store_order_time)) { ?>
            <table class="table table-bordered table-condensed table-hover" id="order_time_table">
              <thead>
                <tr class="info">
                  <th>可訂購日</th>
                  <th>結單時間</th>
                  <th>取餐區</th>
                  <th>操作</th>
                </tr>
              </thead>
              <?php foreach($store_order_time as $data) { ?>
                <tr>
                  <td><?php echo $data['store_order_time'] ?></td>
                  <td><?php echo $data['store_close_time'] ?></td>
                  <td><?php echo $data['delivery_county'] ?><?php echo $data['delivery_district'] ?></td>
                  <td>
                    <?php if(date('Y-m-d')<=$data['store_order_time']){ ?>
                      <a href="/admin/store/order_time_edit/<?php echo $store['store_id'] ?>/<?php echo $data['store_order_time_id'] ?>" class="btn btn-info btn-sm modal-btn"><i class="fa fa-edit"></i> 編輯</a>
                      <a href="/admin/store/order_time_delete/<?php echo $data['store_order_time_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i> 刪除</a>
                    <?php } ?>
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
        document.getElementById("store").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#store").validate({});
});
$('.create-modal-btn').on('click', function(e){
  e.preventDefault();
  //$('#use-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
  $('#create-Modal').modal('show');
});
</script>

<script>
  $('#twzipcode2').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'countySel'   : '<?php echo $store['store_county'] ?>',
      'districtSel' : '<?php echo $store['store_district'] ?>',
  });
  function create_form() {
    $('#create_form').show();
  }
</script>

<script>
$(document).ready(function() {
  $('#order_time_table').DataTable( {
    // "order": [[ 0, "desc" ]],
    // stateSave: true,
    ordering: false,
    // bFilter: false,
    // bLengthChange: false,
    "dom": '<"top"iflp<"clear">>',
    "language": {
      "processing":   "處理中...",
      "loadingRecords": "載入中...",
      "lengthMenu":   "顯示 _MENU_ 項結果",
      "zeroRecords":  "沒有符合的結果",
      "emptyTable":   "沒有資料",
      "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
      "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
      "infoFiltered": "(從 _MAX_ 項結果中過濾)",
      "infoPostFix":  "",
      "search":       "搜尋:",
      "paginate": {
          "first":    "第一頁",
          "previous": "上一頁",
          "next":     "下一頁",
          "last":     "最後一頁"
      },
      "aria": {
          "sortAscending":  ": 升冪排列",
          "sortDescending": ": 降冪排列"
      }
    }
  });
});
</script>