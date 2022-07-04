<div class="row">
  <?php $attributes = array('class' => 'team', 'id' => 'team'); ?>
  <?php echo form_open('admin/about/update_cross_industry_alliance', $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
      <hr>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label" for="about_image">圖片</label><br>

            <img src="/assets/uploads/<?php echo $data['about_image'] ?>" id="about_image_preview" class="img-responsive" style="<?php if(empty($data['about_image'])){echo 'display: none';} ?>">

            <input type="hidden" id="about_image" name="about_image" value="<?php echo $data['about_image'] ?>"/>

            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=about_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <textarea class="tinymce" name="about_content" id="about_content" cols="30" rows="10"><?php echo $data['about_content'] ?></textarea>
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
        document.getElementById("team").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#team").validate({});
});
</script>