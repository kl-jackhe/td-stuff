<style>
#twzipcode select {
  margin-left: 5px;
}
.zipcode{
  display: none!important;
}
</style>
<div class="row">
  <div class="col-md-6">
    <a target="_blank" href="/admin/product/create/0" class="btn btn-primary">新增商品</a>
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button> -->
  </div>
  <div class="col-md-6">
    <div class="pull-right">
        <input type="text" id="keywords" class="form-control" placeholder="店名..." onkeyup="searchFilter()"/>
    </div>
    <!-- <div class="form-inline text-right">
      <select id="status" class="form-control" onchange="searchFilter()">
        <option value="1">啟用的</option>
        <option value="2">無效的</option>
      </select>
    </div> -->
  </div>
  <div class="col-md-12">
    <h4>商品管理</h4>
    <?php if (!empty($product)) {
	?>
    <div class="table-responsive">
      <table id="ProductTable" class="table table-bordered display">
        <thead>
          <tr class="info">
            <th>#</th>
            <th>商品圖片</th>
            <th>商品名稱</th>
            <th class="text-center">價格</th>
            <th>每日庫存</th>
            <th>限購份數</th>
            <!-- <th>描述</th> -->
            <th class="text-center">操作</th>
          </tr>
        </thead>
        <?php
$count = 0;
	foreach ($product as $data) {
		$count++;?>
          <tbody>
            <tr>
              <td><?=$count?></td>
              <td style="width: 50px;"><?php echo get_image($data['product_image']) ?></td>
              <td><?php echo $data['product_name'] ?></td>
              <td class="text-right"><?php echo $data['product_price'] ?></td>
              <td class="text-right"><?php echo $data['product_daily_stock'] ?></td>
              <td class="text-right"><?php echo $data['product_person_buy'] ?></td>
              <!-- <td><?php echo $data['product_description'] ?></td> -->
              <td>
                <a target="_blank" href="/admin/product/edit/<?php echo $data['product_id'] ?>" class="btn btn-primary">編輯</a>
                <a href="/admin/product/delete/<?php echo $data['product_id'] ?>" class="btn btn-danger" onClick="return confirm('您確定要刪除嗎?')">刪除</a>
              </td>
            </tr>
          </tbody>
        <?php }?>
      </table>
    </div>
    <?php }?>
  </div>
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
$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("store").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
  $("#store").validate({});
});
$('.create-modal-btn').on('click', function(e){
  e.preventDefault();
  //$('#use-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
  $('#create-Modal').modal('show');
});
</script>