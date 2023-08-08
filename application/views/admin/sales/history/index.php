<style>
select.district {
  margin-left: 5px;
}
.zipcode{
  display: none!important;
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
        <?if (!empty($SingleSales)) {
          foreach ($SingleSales as $row) {?>
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
      <button onclick="searchFilter()" class="btn btn-primary"><i class="fa fa-search"></i> 搜尋</button>
    </div>
  </div>
</div>
<div class="table-responsive" id="datatable">
  <?php require 'ajax-data.php';?>
</div>

<script>
  $(document).ready(function () {
    searchFilter();
  });
</script>