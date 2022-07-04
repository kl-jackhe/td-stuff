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
  <?php echo form_open('admin/store/insert' , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">建立</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="store_name" class="col-sm-3 control-label">＊店名：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="store_name" id="store_name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">＊地址：</label>
              <div class="col-md-9">
                <div id="twzipcode"></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="address" id="address">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">＊封面照片</label>

              <div class="col-md-9">
                <img src="/assets/uploads/" id="store_image_preview" class="img-responsive" style="display: none">

                <input type="hidden" id="store_image" name="store_image"/>

                <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=store_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇照片</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">＊營業時間：</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="store_open_time" id="store_open_time" required>
              </div>
              <div class="col-md-1">～</div>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="store_close_time" id="store_close_time" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">＊公休日：</label>
              <div class="col-sm-5">
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
                echo form_dropdown('store_off_day', $options, '0', $att); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">＊歇業?：</label>
              <div class="col-sm-5">
                <?php $options = array (
                    "2" => '否',
                    "1" => '是',
                );
                $att = 'class="form-control" id="store_status"';
                echo form_dropdown('store_status', $options, "0", $att); ?>
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
        document.getElementById("store").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#store").validate({});
});
</script>

<script>
  $('#twzipcode').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
  });
</script>