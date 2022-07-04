<div class="row">
  <?php $attributes = array('class' => 'product_banner', 'id' => 'product_banner'); ?>
  <?php echo form_open('admin/product_banner/update/'.$product_banner['product_banner_id'] , $attributes); ?>
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
              <label for="product_banner_name" class="col-sm-3 control-label">＊標題：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="product_banner_name" id="product_banner_name" value="<?php echo $product_banner['product_banner_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_store" class="col-sm-3 control-label">＊店家：</label>
              <?php if(!empty($store)): ?>
                <div class="col-sm-9">
                <?php $att = 'id="product_banner_store" class="form-control chosen" data-rule-required="true"';
                $data = array("0" => "---請選擇---");
                foreach ($store as $c)
                { $data[$c['store_id']] = $c['store_name']; }
                echo form_dropdown('product_banner_store', $data, $product_banner['product_banner_store'], $att); ?>
                <?php else: echo '<label>沒有店家</label><input type="text" class="form-control" id="product_banner_store" name="product_banner_store" value="0" readonly>';
                endif; ?>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_on_the_shelf" class="col-sm-3 control-label">＊上架時間：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control datetimepicker" name="product_banner_on_the_shelf" id="product_banner_on_the_shelf" value="<?php echo $product_banner['product_banner_on_the_shelf'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_off_the_shelf" class="col-sm-3 control-label">＊下架時間：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control datetimepicker" name="product_banner_off_the_shelf" id="product_banner_off_the_shelf" value="<?php echo $product_banner['product_banner_off_the_shelf'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_status" class="col-sm-3 control-label">下架?：</label>
              <div class="col-sm-9">
                <label class="radio-inline">
                  <input type="radio" name="product_banner_status" id="product_banner_status1" value="2" <?php if($product_banner['product_banner_status']==2){echo 'checked';} ?>> 是
                </label>
                <label class="radio-inline">
                  <input type="radio" name="product_banner_status" id="product_banner_status2" value="1" <?php if($product_banner['product_banner_status']==1){echo 'checked';} ?>> 否
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_link" class="col-sm-3 control-label">＊連結：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="product_banner_link" id="product_banner_link" value="<?php echo $product_banner['product_banner_link'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_sort" class="col-sm-3 control-label">＊順序：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="product_banner_sort" id="product_banner_sort" value="<?php echo $product_banner['product_banner_sort'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="product_banner_content" class="col-sm-3 control-label">＊圖片：</label>
              <div class="col-sm-9">
                <img src="/assets/uploads/<?php echo $product_banner['product_banner_image'] ?>" id="product_banner_image_preview" class="img-responsive" style="<?php if(empty($product_banner['product_banner_image'])){echo 'display: none';} ?>">

                <input type="hidden" id="product_banner_image" name="product_banner_image" value="<?php echo $product_banner['product_banner_image'] ?>"/>

                <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=product_banner_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
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
        document.getElementById("product_banner").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#product_banner").validate({});
});
</script>