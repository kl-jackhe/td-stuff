<div class="row">
<?php $attributes = array('class' => 'post', 'id' => 'post'); ?>
<?php echo form_open('admin/posts/insert' , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">建立</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
  </div>
  <div class="col-md-12">
    <div class="content-box-large">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <?php if(!empty($category)): ?>
            <label for="post_category">分類</label>
            <?php $att = 'id="post_category" class="form-control chosen" data-rule-required="true"';
            $data = array();
            foreach ($category as $c){
            $data[$c['post_category_id']] = $c['post_category_name'];
            }
            echo form_dropdown('post_category', $data, '0', $att);
            else: echo '<label>沒有分類</label><input type="text" class="form-control" id="post_category" name="post_category" value="0" readonly>';
            endif; ?>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="post_title">標題 *</label>
            <input type="text" class="form-control" id="post_title" name="post_title" required>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>照片</label><br>
            <img src="" id="post_image_preview" class="img-responsive" style="width: 100px;">
            <input type="hidden" id="post_image" name="post_image">
            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=post_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top:5px;">選擇照片</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="post_content">描述 *</label>
            <textarea class="form-control tinymce" name="post_content" id="post_content" cols="30" rows="20"></textarea>
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
        document.getElementById("post").submit();
        //alert("submitted!");
    }
});
</script>