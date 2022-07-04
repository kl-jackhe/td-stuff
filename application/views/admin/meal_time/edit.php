<div class="row">
  <?php $attributes = array('class' => 'meal_time', 'id' => 'meal_time'); ?>
  <?php echo form_open('admin/meal_time/update/'.$meal_time['meal_time_id'] , $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>用餐時段</label>
            <?php $att = 'id="meal_time_type" class="form-control"';
            $data = array(
              '早餐' => '早餐',
              '午餐' => '午餐',
              '下午茶' => '下午茶',
              '晚餐' => '晚餐',
              '宵夜' => '宵夜',
            );
            echo form_dropdown('meal_time_type', $data, $meal_time['meal_time_type'], $att); ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>時段區間</label>
            <input type="text" class="form-control timepicker" name="meal_time_content_start" id="meal_time_content_start" data-date-format="HH:mm" value="<?php echo $meal_time['meal_time_content_start'] ?>" autocomplete="off" required>
            至
            <input type="text" class="form-control timepicker" name="meal_time_content_end" id="meal_time_content_end" data-date-format="HH:mm" value="<?php echo $meal_time['meal_time_content_end'] ?>" autocomplete="off" required>
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
        document.getElementById("meal_time").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#meal_time").validate({});
});
</script>