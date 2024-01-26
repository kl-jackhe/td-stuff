<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <a href="/admin/coupon/create" class="btn btn-primary">新增優惠券</a>
    </div>
  </div>
  <!-- <div class="col-md-10">
    <div class="form-inline text-right">
      <input type="text" id="keywords" class="form-control" placeholder="優惠券名稱或代碼..." onkeyup="searchFilter()" />
      <select id="category" class="form-control" onchange="searchFilter()">
        <option value="">優惠券類別</option>
        <option value="general">一般優惠券</option>
        <option value="recommend">推薦碼優惠券</option>
      </select>
      <label>優惠日：</label>
      <input type="text" id="start_date" class="form-control datetimepicker" onkeyup="searchFilter()" />
      <label>~</label>
      <input type="text" id="end_date" class="form-control datetimepicker" onkeyup="searchFilter()" />
      <span class="btn btn-primary" onclick="searchFilter()">查詢</span>
    </div>
  </div> -->
</div>
<div class="table-responsive" id="datatable">
  <?php require('coupon_data.php'); ?>
</div>