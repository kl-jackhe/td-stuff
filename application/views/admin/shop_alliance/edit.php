<style>
.form-horizontal .control-label{
    text-align: left;
}
input.zipcode{
  display: none;
}
#twzipcode select,input{
  float: left;
  width: auto;
  margin-right: 1%;
}
</style>
<div class="row">
  <?php $attributes = array('class' => 'shop_alliance', 'id' => 'shop_alliance'); ?>
  <?php echo form_open('admin/shop_alliance/update/'.$shop_alliance['shop_alliance_id'] , $attributes); ?>
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
              <label for="shop_alliance_name" class="col-sm-3 control-label">＊店名：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="shop_alliance_name" id="shop_alliance_name" value="<?php echo $shop_alliance['shop_alliance_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="shop_alliance_address" class="col-sm-3 control-label">地址：</label>
              <div class="col-sm-9">
                <div id="twzipcode" class="form-horizontal">
                  <div data-role="county" data-class="form-control" data-value="<?php echo $shop_alliance['shop_alliance_county'] ?>"></div>
                  <div data-role="district" data-class="form-control" data-value="<?php echo $shop_alliance['shop_alliance_district'] ?>"></div>
                  <input type="text" class="form-control" name="shop_alliance_address" id="shop_alliance_address" value="<?php echo $shop_alliance['shop_alliance_address'] ?>" style="float: left; width: auto">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="shop_alliance_contact_name" class="col-sm-3 control-label">＊聯絡人：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="shop_alliance_contact_name" id="shop_alliance_contact_name" value="<?php echo $shop_alliance['shop_alliance_contact_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="shop_alliance_email" class="col-sm-3 control-label">＊E-mail：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="shop_alliance_email" id="shop_alliance_email" value="<?php echo $shop_alliance['shop_alliance_email'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="shop_alliance_phone" class="col-sm-3 control-label">＊手機：</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="shop_alliance_phone" id="shop_alliance_phone" value="<?php echo $shop_alliance['shop_alliance_phone'] ?>" required>
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
        document.getElementById("shop_alliance").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#shop_alliance").validate({});
});
</script>

<script>
    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    });
</script>