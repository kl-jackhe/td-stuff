<div class="row">
  <?php $attributes = array('class' => 'create_product', 'id' => 'create_product');?>
  <?php echo form_open('admin/product/insert', $attributes); ?>
  	<div class="col-md-12">
      	<div class="form-group">
      		<!-- <input type="hidden" name="store_id" value="<?php echo $store_id; ?>"> -->
        	<button type="submit" class="btn btn-primary">建立</button>
      	</div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="product_name">菜名 *</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
            <input type="hidden" id="store_id" name="store_id" value="<?php echo $this->uri->segment(4) ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="product_price">價格 *</label>
            <input type="text" class="form-control" id="product_price" name="product_price" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="product_daily_stock">每日庫存</label>
            <input type="text" class="form-control" id="product_daily_stock" name="product_daily_stock">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="product_person_buy">限購份數</label>
            <input type="text" class="form-control" id="product_person_buy" name="product_person_buy">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="product_description">備註 *</label>
            <!-- <input type="text" class="form-control" id="product_description" name="product_description"> -->
            <textarea id="product_description" name="product_description" class="form-control"></textarea>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="product_image" class="control-label">圖片</label>
            <div class="form-group">
              <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
            </div>
            <img src="" id="add_product_image_preview" class="img-responsive" style="display: none;">
            <input type="hidden" id="add_product_image" name="product_image"/>
          </div>
        </div>
      </div>
    </div>
  <?php echo form_close() ?>
</div>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
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
function responsive_filemanager_callback(field_id)
{
  if (field_id) {
      //console.log(field_id);
      var url = jQuery('#' + field_id).val();
      document.getElementById(field_id+'_preview').src = '<?php echo base_url(); ?>assets/uploads/' + url;
      $('#'+field_id+'_preview').show();
  }
}
</script>