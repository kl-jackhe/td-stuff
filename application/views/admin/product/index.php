<div class="row">
  <div class="col-md-4">
    <a target="_blank" href="/admin/product/create/0" class="btn btn-primary">新增商品</a>
    <a href="/admin/product/category" class="btn btn-success">商品分類</a>
    <!-- <a href="/admin/product/add_on_group" class="btn btn-info">加購項目</a> -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button> -->
  </div>
  <div class="col-md-8">
    <div class="form-inline form-group text-right">
      <input type="text" id="keywords" class="form-control" placeholder="搜尋..."/>
      <select id="status" class="form-control" onchange="searchFilter()">
        <option value="1">上架中</option>
        <option value="2">已下架</option>
      </select>
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
        <?php echo form_open('export/' . $this->uri->segment(1)); ?>
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
<script>
$(document).ready(function() {
  searchFilter();
});

function update_sales_status(product_id) {
  $.ajax({
    url: '/admin/product/update_sales_status/'+product_id,
    type: 'POST',
    data: {sales_status: $('#sales_status_'+product_id).val()},
  })
  .done(function() {
    console.log("success");
    searchFilter();
  })
  .fail(function() {
    console.log("error");
  });
}
</script>