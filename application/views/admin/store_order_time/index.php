<style>
#twzipcode select {
  margin-left: 5px;
}
.zipcode{
  display: none!important;
}
</style>
<div class="row">
  <div class="col-md-4">
    <a href="/admin/store_order_time/create_before" class="btn btn-primary modal-btn">新增可訂購時段</a>
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button> -->
  </div>
  <div class="col-md-8">
    <div id="twzipcode" class="form-inline text-right">
      <!-- <div class="pull-right">
        <select id="sortBy" class="form-control" onchange="searchFilter()">
          <option value="">排序</option>
          <option value="asc">升冪</option>
          <option value="desc">降冪</option>
        </select>
      </div> -->
      <div data-role="district" data-name="district" data-id="district" data-style="form-control pull-right" onchange="searchFilter()"></div>
      <div data-role="county" data-name="county" data-id="county" data-style="form-control pull-right" onchange="searchFilter()"></div>
      <div class="pull-right">
        <select id="category" class="form-control chosen" onchange="searchFilter()">
          <option value="">---選擇店家---</option>
          <?php if(!empty($store)) { foreach ($store as $data) {
            echo '<option value='.$data['store_id'].'>'.$data['store_number'].' - '.$data['store_name'].'</option>';
          }} ?>
        </select>
      </div>
    </div>
    <!-- <div class="pull-right">
        <input type="text" id="keywords" class="form-control" placeholder="店名..." onkeyup="searchFilter()"/>
    </div> -->
    <!-- <div class="form-inline text-right">
      <select id="status" class="form-control" onchange="searchFilter()">
        <option value="1">啟用的</option>
        <option value="2">無效的</option>
      </select>
    </div> -->
  </div>
</div>
<div class="table-responsive" id="datatable">
  <?php require('ajax-data.php'); ?>
</div>

<!-- Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">匯出資料</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open('export/'.$this->uri->segment(1)); ?>
          <div class="form-group">
            <select name="type" class="form-control">
              <!-- <option value="xls" selected="">Excel</option> -->
              <option value="csv">CSV</option>
              <!-- <option value="pdf">PDF</option> -->
            </select>
          </div>
          <div class="form-group">
            <label for="store_birthday">起始日期:</label>
             <input type="text" class="form-control datepicker" name="start_date" id="start_date" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="store_birthday">終止日期:</label>
             <input type="text" class="form-control datepicker" name="end_date" id="end_date" autocomplete="off">
          </div>
          <button type="submit" name="import" class="btn btn-primary">匯出</button>
        <?php echo form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script src="/assets/admin/js/jquery.twzipcode-with-all.js"></script>
<script>
  $('#twzipcode').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'onDistrictSelect': '',
      // 'countySel' : '臺北市',
  });
</script>