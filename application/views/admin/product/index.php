<style>
  .product_edit_style {
    padding-bottom: 20px;
    white-space: nowrap;
  }

  .product_edit_style a {
    color: #0080FF;
    position: relative;
    text-decoration: none;
  }

  .product_edit_style a::before {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 100%;
    height: 1.5px;
    /* 底線高度 */
    background-color: #0080FF;
    /* 底線颜色 */
    transition: right 0.3s ease;
    /* 過渡效果，使底線動畫顯示 */
  }

  .product_edit_style a:hover::before {
    right: 0;
  }

  #positionBtn {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #contradictionBtn {
    <?php if (isset($enable_status) && $enable_status[0]['contradiction_status'] == 1) : ?>background-color: #ec6262;
    <?php else : ?>background-color: #4dcf4d;
    <?php endif; ?>color: #fff;
    box-shadow: 2px 2px 4px gray;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    border: 1px solid transparent;
    border-radius: 4px;
  }
</style>

<div class="row">
  <div class="col-md-4">
    <div class="row" id="positionBtn">
      <div class="col-md-4">
        <a target="_blank" href="/admin/product/create/0" class="btn btn-primary">新增商品</a>
      </div>
      <div class="col-md-8">
        <?php if (isset($enable_status) && $enable_status[0]['contradiction_status'] == 1) : ?>
          <a id="contradictionBtn" onclick="contradition(1)">不可同時預購</a>
        <?php else : ?>
          <a id="contradictionBtn" onclick="contradition(0)">可同時預購</a>
        <?php endif; ?>

      </div>
    </div>
    <!-- <a href="/admin/product/add_on_group" class="btn btn-info">加購項目</a> -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button> -->
  </div>
  <div class="col-md-8">
    <div class="form-inline form-group text-right">
      <input type="text" id="keywords" class="form-control" placeholder="搜尋商品名稱..." />
      <select id="status" class="form-control" onchange="searchFilter()">
        <option value="1">上架中</option>
        <option value="2">已下架</option>
      </select>
      <button onclick="searchFilter()" class="btn btn-primary"><i class="fa fa-search"></i> 搜尋</button>
    </div>
  </div>
</div>
<div class="table-responsive" id="datatable">
  <?php require 'ajax-data.php'; ?>
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
        url: '/admin/product/update_sales_status/' + product_id,
        type: 'POST',
        data: {
          sales_status: $('#sales_status_' + product_id).val()
        },
      })
      .done(function() {
        console.log("success");
        searchFilter();
      })
      .fail(function() {
        console.log("error");
      });
  }

  function contradition($now_status) {

    // 發送 AJAX 請求
    $.ajax({
      url: '/admin/product/contradiction',
      type: 'POST',
      data: {
        status: $now_status
      },
      success: function(response) {
        if (response == 'successful') {
          // 重新加載整個網頁
          location.reload();
        }
        console.log(response);
      },
      error: function(error) {
        console.error(error);
      },
    });
  }
</script>