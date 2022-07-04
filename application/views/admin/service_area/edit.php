<div class="row">
  <?php $attributes = array('class' => 'service_area', 'id' => 'service_area'); ?>
  <?php echo form_open('admin/service_area/update/'.$service_area['service_area_id'] , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-6">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="service_area_county" class="col-md-3 control-label">＊縣市：</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="service_area_county" id="service_area_county" value="<?php echo $service_area['service_area_county'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">＊區域：</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name="service_area_district" id="service_area_district" value="<?php echo $service_area['service_area_district'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="service_area_status" class="col-md-3 control-label">＊開放?：</label>
              <div class="col-md-5">
                <select class="form-control" id="service_area_status" name="service_area_status">
                  <option value="1" <?php echo($service_area['service_area_status']=='1')?("selected"):(""); ?>>開放</option>
                  <option value="0" <?php echo($service_area['service_area_status']=='0')?("selected"):(""); ?>>關閉</option>
                </select>
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
        document.getElementById("service_area").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#service_area").validate({});
});
</script>