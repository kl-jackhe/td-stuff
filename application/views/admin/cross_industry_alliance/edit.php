<div class="row">
  <?php $attributes = array('class' => 'cross_industry_alliance', 'id' => 'cross_industry_alliance'); ?>
  <?php echo form_open('admin/cross_industry_alliance/update/'.$cross_industry_alliance['cross_industry_alliance_id'] , $attributes); ?>
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
              <label for="cross_industry_alliance_name" class="col-sm-3 control-label">＊企業名稱：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cross_industry_alliance_name" id="cross_industry_alliance_name" value="<?php echo $cross_industry_alliance['cross_industry_alliance_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="cross_industry_alliance_number" class="col-sm-3 control-label">＊統一編號：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cross_industry_alliance_number" id="cross_industry_alliance_number" value="<?php echo $cross_industry_alliance['cross_industry_alliance_number'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="cross_industry_alliance_contact_name" class="col-sm-3 control-label">＊聯絡人：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cross_industry_alliance_contact_name" id="cross_industry_alliance_contact_name" value="<?php echo $cross_industry_alliance['cross_industry_alliance_contact_name'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="cross_industry_alliance_email" class="col-sm-3 control-label">＊E-mail：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cross_industry_alliance_email" id="cross_industry_alliance_email" value="<?php echo $cross_industry_alliance['cross_industry_alliance_email'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="cross_industry_alliance_content" class="col-sm-3 control-label">＊手機：</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cross_industry_alliance_phone" id="cross_industry_alliance_phone" value="<?php echo $cross_industry_alliance['cross_industry_alliance_phone'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="cross_industry_alliance_content" class="col-sm-3 control-label">＊服務需求：</label>
              <div class="col-sm-9">
                <textarea name="cross_industry_alliance_content" id="cross_industry_alliance_content" class="form-control" cols="30" rows="10" required><?php echo $cross_industry_alliance['cross_industry_alliance_content'] ?></textarea>
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
        document.getElementById("cross_industry_alliance").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#cross_industry_alliance").validate({});
});
</script>