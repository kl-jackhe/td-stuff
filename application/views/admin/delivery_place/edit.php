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
  <?php $attributes = array('class' => 'delivery_place', 'id' => 'delivery_place'); ?>
  <?php echo form_open('admin/delivery_place/update/'.$delivery_place['delivery_place_id'] , $attributes); ?>
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
              <label for="delivery_place_name" class="col-sm-3 control-label">＊取餐點名稱：</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="delivery_place_name" id="delivery_place_name" value="<?php echo $delivery_place['delivery_place_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">＊地址：</label>
              <div class="col-md-9">
                <div id="twzipcode"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label"></label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="address" id="address" value="<?php echo $delivery_place['delivery_place_address'] ?>">
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
        document.getElementById("delivery_place").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#delivery_place").validate({});
});
</script>

<script>
  $('#twzipcode').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'countySel'   : '<?php echo $delivery_place['delivery_place_county'] ?>',
      'districtSel' : '<?php echo $delivery_place['delivery_place_district'] ?>'
  });
</script>