<div class="row">
<?php $attributes = array('class' => 'post', 'id' => 'post');?>
<?php echo form_open('admin/posts/update/' . $post['post_id'], $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
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
            <?php $att = 'id="category_id" class="form-control chosen" data-rule-required="true"';
            $data = array();
            foreach ($category as $c){
            $data[$c['post_category_id']] = $c['post_category_name'];
            }
            echo form_dropdown('post_category', $data, $post['post_category'], $att);
            else: echo '<label>沒有分類</label><input type="text" class="form-control" id="post_category" name="post_category" value="0" readonly>';
            endif; ?>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="post_title">標題 *</label>
            <input type="text" class="form-control" id="post_title" name="post_title" value="<?php echo $post['post_title'] ?>" required>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label>照片</label><br>
            <?php if(!empty($post['post_image'])) { ?>
            <img src="/assets/uploads/<?php echo $post['post_image']; ?>" id="post_image_preview" class="img-responsive" style="<?php if (empty($post['post_image'])) {echo 'display: none';}?>">
            <?php } else { ?>
              <img src="" id="post_image_preview" class="img-responsive">
            <?php } ?>
            <input type="hidden" id="post_image" name="post_image" value="<?php echo $post['post_image']; ?>"/>
            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=post_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top:5px;">選擇照片</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="post_content">描述 *</label>
            <textarea class="form-control tinymce" name="post_content" id="post_content" cols="30" rows="20"><?php echo $post['post_content'] ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
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