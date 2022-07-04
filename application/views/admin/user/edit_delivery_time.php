<div class="row">
  <div class="col-md-6" id="used-table">
    <?php echo form_open(uri_string());?>

    <label><input type="checkbox" id="checkAll"> 全選</label>

    <?php foreach ($delivery_time as $delivery_time){ ?>
    <div class="checkbox">
      <label class="checkbox">
        <?php
        $checked = null;
        if(!empty($users_delivery_time)) { foreach($users_delivery_time as $udt) {
          if ($udt['delivery_time_id']==$delivery_time['delivery_time_id']) {
            $checked=' checked="checked"';
            break;
          }
        }} ?>
        <input type="checkbox" name="delivery_time[]" value="<?php echo $delivery_time['delivery_time_id'];?>"<?php echo $checked;?>>
        <?php echo $delivery_time['delivery_time_name']; ?>
      </label>
    </div>
    <?php } ?>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">儲存修改</button>
    </div>
    <?php echo form_close() ?>
  </div>
</div>

<script>
  $("#checkAll").click(function(){
    $('#used-table input:checkbox').not(this).prop('checked', this.checked);
  });
</script>