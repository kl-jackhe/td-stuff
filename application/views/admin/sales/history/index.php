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
      <input type="text" id="keywords" class="form-control" placeholder="訂單編號 / 姓名 / 電話" value="<?=(isset($_COOKIE['order_keywords']) ? $_COOKIE['order_keywords'] : '' )?>">
      <select id="product" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">商品</option>
        <?if (!empty($product)) {
          foreach ($product as $row) {?>
            <option value="<?=$row['product_id']?>" <?=(isset($_COOKIE['order_product']) && $_COOKIE['order_product'] == $row['product_id'] ? 'selected' : '' )?>><?=$row['product_name']?></option>
          <?}
        }?>
      </select>
      <select id="category2" class="form-control" onchange="searchFilter()">
        <option value="">付款方式</option>
        <?if (!empty($payment)) {
          foreach ($payment as $row) {?>
            <option value="<?=$row['payment_code']?>" <?=(isset($_COOKIE['order_category2']) && $_COOKIE['order_category2'] == $row['payment_code'] ? 'selected' : '' )?>><?=$row['payment_name']?></option>
          <?}
        }?>
      </select>
      <select id="category1" class="form-control" onchange="searchFilter()">
        <option value="">配送方式</option>
        <?if (!empty($delivery)) {
          foreach ($delivery as $row) {?>
            <option value="<?=$row['delivery_name_code']?>" <?=(isset($_COOKIE['order_category1']) && $_COOKIE['order_category1'] == $row['delivery_name_code'] ? 'selected' : '' )?>><?=$row['delivery_name']?></option>
          <?}
        }?>
      </select>
      <select id="category" class="form-control" onchange="searchFilter()">
        <?foreach ($step_list as $key => $value) {?>
          <option value="<?=$key?>" <?=(isset($_COOKIE['order_category']) && $_COOKIE['order_category'] == $key ? 'selected' : '' )?>><?=$value?></option>
        <?}?>
      </select>
      <input type="text" id="start_date" class="form-control datepicker" value="<?=(isset($_COOKIE['order_start_date']) ? $_COOKIE['order_start_date'] : '' )?>" placeholder="起始日期" size="9" autocomplete="off">
      <input type="text" id="end_date" class="form-control datepicker" value="<?=(isset($_COOKIE['order_end_date']) ? $_COOKIE['order_end_date'] : '' )?>" placeholder="終止日期" size="9" autocomplete="off">
      <select id="sales" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">銷售頁面</option>
        <?if (!empty($single_sales)) {
          foreach ($single_sales as $row) {?>
            <option value="<?=$row['id']?>" <?=(isset($_COOKIE['order_sales']) && $_COOKIE['order_sales'] == $row['id'] ? 'selected' : '' )?>><?=$row['id'] . ' - ' . get_product_name($row['product_id'])?></option>
          <?}
        }?>
      </select>
      <select id="agent" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">代言人</option>
        <?if (!empty($agent)) {
          foreach ($agent as $row) {?>
            <option value="<?=$row['id']?>" <?=(isset($_COOKIE['order_agent']) && $_COOKIE['order_agent'] == $row['id'] ? 'selected' : '' )?>><?=$row['name']?></option>
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
    searchFilter(<?php echo get_cookie('order_page') ?>);

    $(".chosen_other").chosen({
      no_results_text: "沒有找到。",
      search_contains: true,
      // width: "100%",
    });
  });

  function changeStep(id,source) {
    if (confirm('訂定要變更訂單狀態？')) {
      $.ajax({
          type: "POST",
          url: '/admin/order/update_step',
          data: {
              id: id,
              step: $('#order_step_' + id + source).val(),
          },
          success: function(data) {
              searchFilter(<?php echo get_cookie('order_page') ?>);
          },
          error: function(data) {
              console.log(data);
              alert('異常錯誤！');
          }
      });
    }
  }
</script>