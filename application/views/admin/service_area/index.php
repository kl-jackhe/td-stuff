<style>
#twzipcode select {
  margin-right: 5px;
}
.zipcode {
  display: none!important;
}
#district {
  display: none!important;
}
</style>

<?php $attributes = array('class' => 'service_area', 'id' => 'service_area'); ?>
<?php echo form_open('admin/service_area/multiple_action' , $attributes); ?>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="form-inline">
        <div id="twzipcode">
          <div data-role="district" data-name="district" data-id="district" data-class="form-control pull-left" onchange="searchFilter()"></div>
          <div data-role="county" data-name="county" data-id="county" data-class="form-control pull-left" onchange="searchFilter()"></div>
        </div>
        <select name="action" id="action" class="form-control">
          <option value="0">--動作--</option>
          <option value="open">開放</option>
          <option value="close">關閉</option>
        </select>
        <button type="subit" class="btn btn-primary">操作</button>
      </div>
    </div>
  </div>
</div>

<div class="table-responsive" id="datatable">
  <?php require('ajax-data.php'); ?>
</div>

<?php echo form_close() ?>

<script>
  $('#twzipcode').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'onDistrictSelect': '',
      // 'countySel' : '臺北市',
  });
</script>