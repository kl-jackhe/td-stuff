<style>
  label.required::before {
    content: '* ';
    color: red;
  }
</style>
<div class="row">
  <?php $attributes = array('class' => 'mail', 'id' => 'mail'); ?>
  <?php echo form_open('admin/mail/update/' . $mail['contid'], $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
  </div>
  <div class="col-md-12">
    <div class="content-box-large">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="cpname">公司名稱：</label>
            <input type="text" class="form-control" name="cpname" id="cpname" value="<?php echo $mail['cpname'] ?>" readonly>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="custname">客戶名稱：</label>
            <input type="text" class="form-control" name="custname" id="custname" value="<?php echo $mail['custname'] ?>" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="gtime">方便連絡時段：</label>
            <input type="text" class="form-control" name="gtime" id="gtime" value="<?php echo ($mail['gtime'] == 1) ? '上午' : (($mail['gtime'] == 2) ? '中午' : (($mail['gtime'] == 3) ? '下午' : (($mail['gtime'] == 4) ? '晚上' : '皆可'))); ?>" readonly>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="tel">聯絡電話：</label>
            <input type="text" class="form-control" name="tel" id="tel" value="<?php echo $mail['tel'] ?>" readonly>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="email">電子信箱：</label>
            <input type="text" class="form-control" name="email" id="email" value="<?php echo $mail['email'] ?>" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="desc1">主旨：</label>
            <textarea class="form-control" name="desc1" id="desc1" cols="30" rows="5" readonly><?php echo $mail['desc1'] ?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="desc2" class="required">回覆：</label>
            <textarea class="form-control tinymce" name="desc2" id="desc2" cols="30" rows="20"><?php echo $mail['desc2'] ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
  $.validator.setDefaults({
    submitHandler: function() {
      document.getElementById("mail").submit();
      //alert("submitted!");
    }
  });
</script>