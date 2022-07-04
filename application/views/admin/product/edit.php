<div class="row">
<?php $attributes = array('class' => 'product', 'id' => 'product');?>
<?php echo form_open('admin/product/update/' . $product['product_id'], $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="product_name">菜名 *</label>
          <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="product_price">價格 *</label>
          <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $product['product_price']; ?>" required>
        </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="product_daily_stock">每日庫存</label>
            <input type="text" class="form-control" id="product_daily_stock" name="product_daily_stock" value="<?php echo $product['product_daily_stock']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="product_person_buy">限購份數</label>
            <input type="text" class="form-control" id="product_person_buy" name="product_person_buy" value="<?php echo $product['product_person_buy']; ?>">
          </div>
        </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="product_description">備註 *</label>
          <input type="text" class="form-control" id="product_description" name="product_description" value="<?php echo $product['product_description']; ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="product_image" class="control-label">圖片</label>
          <div class="form-group">
            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=product_image<?php echo $product['product_id']; ?>&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
          </div>
          <?php if(!empty($product['product_image'])) { ?>
          <img src="/assets/uploads/<?php echo $product['product_image']; ?>" id="product_image<?php echo $product['product_id']; ?>_preview" class="img-responsive" style="<?php if (empty($product['product_image'])) {echo 'display: none';}?>">
          <?php } else { ?>
            <img src="" id="product_image<?php echo $product['product_id']; ?>_preview" class="img-responsive">
          <?php } ?>
          <input type="hidden" id="product_image<?php echo $product['product_id']; ?>" name="product_image" value="<?php echo $product['product_image']; ?>"/>
        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
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

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
$.validator.setDefaults({
  submitHandler: function() {
    document.getElementById("product").submit();
    //alert("submitted!");
  }
});
$(document).ready(function() {
  $("#product").validate({});
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