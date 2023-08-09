<style>
select.district {
  margin-left: 5px;
}
.zipcode{
  display: none!important;
}
.chosen-container {
  border: 0 !important;
  text-align: left !important;
}
</style>
<div class="row">
  <!-- <div class="col-md-6">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button>
  </div> -->
  <div class="col-md-12">
    <div class="form-inline form-group text-right">
      <input type="text" id="keywords" class="form-control" placeholder="訂單編號 / 姓名 / 電話">
      <select id="product" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">商品</option>
        <?if (!empty($product)) {
          foreach ($product as $row) {?>
            <option value="<?=$row['product_id']?>"><?=$row['product_name']?></option>
          <?}
        }?>
      </select>
      <select id="category2" class="form-control" onchange="searchFilter()">
        <option value="">付款方式</option>
        <?if (!empty($payment)) {
          foreach ($payment as $row) {?>
            <option value="<?=$row['payment_code']?>"><?=$row['payment_name']?></option>
          <?}
        }?>
      </select>
      <select id="category1" class="form-control" onchange="searchFilter()">
        <option value="">配送方式</option>
        <?if (!empty($delivery)) {
          foreach ($delivery as $row) {?>
            <option value="<?=$row['delivery_name_code']?>"><?=$row['delivery_name']?></option>
          <?}
        }?>
      </select>
      <select id="category" class="form-control" onchange="searchFilter()">
        <option value="">訂單狀態</option>
        <option value="confirm">訂單確認</option>
        <option value="pay_ok">已收款</option>
        <option value="process">待出貨</option>
        <option value="shipping">已出貨</option>
        <option value="complete">完成</option>
        <option value="order_cancel">訂單取消</option>
      </select>
      <input type="text" id="start_date" class="form-control datepicker" value="" placeholder="起始日期" size="9" autocomplete="off">
      <input type="text" id="end_date" class="form-control datepicker" value="" placeholder="終止日期" size="9" autocomplete="off">
      <select id="sales" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">銷售頁面</option>
        <?if (!empty($single_sales)) {
          foreach ($single_sales as $row) {?>
            <option value="<?=$row['id']?>"><?=$row['id'] . ' - ' . get_product_name($row['product_id'])?></option>
          <?}
        }?>
      </select>
      <select id="agent" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">代言人</option>
        <?if (!empty($agent)) {
          foreach ($agent as $row) {?>
            <option value="<?=$row['id']?>"><?=$row['name']?></option>
          <?}
        }?>
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

  $(document).ready(function () {
    searchFilter();

    $(".chosen_other").chosen({
      no_results_text: "沒有找到。",
      search_contains: true,
      // width: "100%",
    });
  });
</script>