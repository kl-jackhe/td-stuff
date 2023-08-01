<style>
select.district {
  margin-left: 5px;
}
.zipcode{
  display: none!important;
}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="form-inline form-group text-right">
      <input type="text" id="keywords" class="form-control" placeholder="訂單編號..." size="10">
      <input type="text" id="start_date" class="form-control datepicker" value="" placeholder="起始日期" size="9" autocomplete="off">
      <input type="text" id="end_date" class="form-control datepicker" value="" placeholder="終止日期" size="9" autocomplete="off">
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