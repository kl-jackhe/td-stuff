<style>
select.district {
  margin-left: 5px;
}
.zipcode{
  display: none!important;
}
</style>
<div class="row">
  <div class="col-md-6">
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button> -->
  </div>
  <div class="col-md-6">
    <div class="form-inline form-group text-right">
      <input type="text" id="keywords" class="form-control" placeholder="訂單編號..." size="10">
      <input type="text" id="start_date" class="form-control datepicker" value="" placeholder="起始日期" size="9" autocomplete="off">
      <input type="text" id="end_date" class="form-control datepicker" value="" placeholder="終止日期" size="9" autocomplete="off">
      <?$att = 'class="form-control" id="category" onchange="searchFilter()"';
      $options = array(
      	'' => '訂單狀態',
      	'confirm' => '訂單確認',
      	'pay_ok' => '已收款',
      	'process' => '待出貨',
      	'shipping' => '已出貨',
      	'complete' => '完成',
        'order_cancel' => '訂單取消',
      );
      echo form_dropdown('category', $options, '', $att);?>
      <select id="category2" class="form-control hide" onchange="searchFilter()">
        <option value="">訂單狀態</option>
        <option value="accept">接收訂單</option>
        <option value="prepare">餐點準備中</option>
        <option value="shipping">餐點運送中</option>
        <option value="arrive">司機抵達</option>
        <option value="picked">已取餐</option>
        <option value="cancel">取消訂單</option>
        <option value="void">已退單</option>
      </select>
      <input type="hidden" id="sortBy">
      <!-- <select id="sortBy" class="form-control" onchange="searchFilter()">
        <option value="0">排序</option>
        <option value="asc">升冪</option>
        <option value="desc">降冪</option>
      </select> -->
      <!-- <select id="status" class="form-control" onchange="searchFilter()">
        <option value="1">啟用的</option>
        <option value="2">無效的</option>
      </select> -->
      <button onclick="searchFilter()" class="btn btn-primary"><i class="fa fa-search"></i> 搜尋</button>
    </div>
  </div>
</div>
<div class="table-responsive" id="datatable">
  <?php require 'ajax-data.php';?>
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
        <?php echo form_open('admin/export/orders') ?>
          <div class="form-group">
            <select name="type" class="form-control">
              <option value="xls" selected="">Excel</option>
              <!-- <option value="csv">CSV</option> -->
              <!-- <option value="pdf">PDF</option> -->
            </select>
          </div>
          <div class="form-group">
            <label>起始日期</label>
             <input type="text" class="form-control datepicker" name="start_date" id="start_date" autocomplete="off">
          </div>
          <div class="form-group">
            <label>終止日期</label>
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

<script>
  $('#twzipcode').twzipcode({
      // 'detect': true, // 預設值為 false
      'css': ['form-control county', 'form-control district', 'form-control zipcode'],
      'onDistrictSelect': '',
  });
</script>