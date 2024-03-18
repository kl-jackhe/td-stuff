<style>
  select.district {
    margin-left: 5px;
  }

  .zipcode {
    display: none !important;
  }

  .chosen-container {
    border: 0 !important;
    text-align: left !important;
  }

  #product_chosen {
    width: 601px !important;
  }

  @media (max-width: 767px) {
    #product_chosen {
      width: 100% !important;
    }
  }
</style>
<div class="row">
  <!-- <div class="col-md-6">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button>
  </div> -->
  <div class="col-md-12">
    <div class="form-inline form-group text-right">
      <input type="text" id="keywords" class="form-control" placeholder="訂單編號 / 姓名 / 電話" value="<?= (isset($_COOKIE['order_keywords']) ? $_COOKIE['order_keywords'] : '') ?>">
      <select id="product" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">商品</option>
        <? if (!empty($product)) {
          foreach ($product as $row) { ?>
            <option value="<?= $row['product_id'] ?>" <?= (isset($_COOKIE['order_product']) && $_COOKIE['order_product'] == $row['product_id'] ? 'selected' : '') ?>><?= $row['product_name'] ?></option>
        <? }
        } ?>
      </select>
      <select id="category2" class="form-control" onchange="searchFilter()">
        <option value="">付款方式</option>
        <? if (!empty($payment)) {
          foreach ($payment as $row) { ?>
            <option value="<?= $row['payment_code'] ?>" <?= (isset($_COOKIE['order_category2']) && $_COOKIE['order_category2'] == $row['payment_code'] ? 'selected' : '') ?>><?= $row['payment_name'] ?></option>
        <? }
        } ?>
      </select>
      <select id="category1" class="form-control" onchange="searchFilter()">
        <option value="">配送方式</option>
        <? if (!empty($delivery)) {
          foreach ($delivery as $row) { ?>
            <option value="<?= $row['delivery_name_code'] ?>" <?= (isset($_COOKIE['order_category1']) && $_COOKIE['order_category1'] == $row['delivery_name_code'] ? 'selected' : '') ?>><?= $row['delivery_name'] ?></option>
        <? }
        } ?>
      </select>
      <select id="category" class="form-control" onchange="searchFilter()">
        <? foreach ($step_list as $key => $value) { ?>
          <option value="<?= $key ?>" <?= (isset($_COOKIE['order_category']) && $_COOKIE['order_category'] == $key ? 'selected' : '') ?>><?= $value ?></option>
        <? } ?>
      </select>
      <input type="text" id="start_date" class="form-control datepicker" value="<?= (isset($_COOKIE['order_start_date']) ? $_COOKIE['order_start_date'] : '') ?>" placeholder="起始日期" size="9" autocomplete="off">
      <input type="text" id="end_date" class="form-control datepicker" value="<?= (isset($_COOKIE['order_end_date']) ? $_COOKIE['order_end_date'] : '') ?>" placeholder="終止日期" size="9" autocomplete="off">
      <select id="sales" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">銷售頁面</option>
        <? if (!empty($single_sales)) {
          foreach ($single_sales as $row) { ?>
            <option value="<?= $row['id'] ?>" <?= (isset($_COOKIE['order_sales']) && $_COOKIE['order_sales'] == $row['id'] ? 'selected' : '') ?>><?= $row['id'] . ' - ' . get_product_name($row['product_id']) ?></option>
        <? }
        } ?>
      </select>
      <select id="agent" class="form-control chosen_other" onchange="searchFilter()">
        <option value="">代言人</option>
        <? if (!empty($agent)) {
          foreach ($agent as $row) { ?>
            <option value="<?= $row['id'] ?>" <?= (isset($_COOKIE['order_agent']) && $_COOKIE['order_agent'] == $row['id'] ? 'selected' : '') ?>><?= $row['name'] ?></option>
        <? }
        } ?>
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

<!-- operateModal -->
<div class="modal fade" id="operateModal" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <select class="form-control" id="selectStep">
          <option value="">----選擇訂單狀態----</option>
          <? foreach ($step_list as $key => $value) {
            if ($key != '') { ?>
              <option value="<?= $key ?>"><?= $value ?></option>
          <? }
          } ?>
        </select>
      </div>
      <div class="modal-footer">
        <span class="btn btn-primary" onclick="selectBoxChangeStep()">修改</span>
        <span class="btn btn-danger" data-dismiss="modal">關閉</span>
      </div>
    </div>
  </div>
</div>

<!-- mfp view -->
<script>
  $(document).ready(function() {
    $('.popup-link').magnificPopup({
      type: 'inline',
      midClick: true // 允许使用中键点击
      // 更多配置项可以根据需求添加
    });
  });

  function toggleTermsPopup(id) {
    // Ajaxリクエストで注文の詳細を取得し、詳細を表示する
    $.ajax({
      url: '/admin/order/getOrderItem/' + id,
      type: 'post',
      success: function(data) {
        const magnificPopup = $.magnificPopup.instance;

        // 切り替え弾出窗口的顯示狀態
        if (magnificPopup.isOpen) {
          magnificPopup.close();
        } else {
          magnificPopup.open({
            items: {
              src: '#detailOrder'
            },
            type: 'inline'
            // 更多 Magnific Popup 配置项可根据需要添加
          });

          // 注文の詳細を表示する
          displayOrderDetails(data);
        }
      }
    });
  }

  function displayOrderDetails(data) {
    // データをもとに注文の詳細を表示する処理を実装する
    // ここに注文の詳細を表示するためのコードを追加する
    // dataは配列なので、適切にループして詳細を表示する必要があります
    // 注文の詳細を表示するためのHTMLを構築する
    var html = '';
    html += '<tr>';
    html += '<th>商品編號</th>';
    html += '<th>商品名稱 </th>';
    html += '<th>商品規格</th>';
    html += '<th>數量</th>';
    html += '</tr>';
    
    for (var i = 0; i < data.length; i++) {
      var orderItem = data[i];
      // 注文の詳細を表示するためのHTMLを生成する
      html += '<tr>';
      html += '<td nowrap="nowrap">' + orderItem.cargo_id + '</td>';
      html += '<td class="remarks">' + orderItem.product_name + '</td>';
      html += '<td class="remarks">' + orderItem.product_combine_name + '</td>';
      html += '<td nowrap="nowrap">' + orderItem.order_item_qty + '</td>';
      html += '</tr>';
    }

    // HTMLを挿入する
    $('#detailOrder .orderItems').html(html);
  }
</script>

<!-- operateModal -->
<script>
  $('#twzipcode').twzipcode({
    // 'detect': true, // 預設值為 false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'onDistrictSelect': '',
  });

  $(document).ready(function() {
    searchFilter('<?php echo get_cookie('order_page') ?>');

    $(".chosen_other").chosen({
      no_results_text: "沒有找到。",
      search_contains: true,
      // width: "100%",
    });
  });

  function changeStep(id, source) {
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

  function selectAll() {
    if ($('#selectAll').val() == 1) {
      $('#selectAll').val(0);
      $('.selectAll').removeClass('fa-square-check');
      $('.selectAll').addClass('fa-square');
      $('input[type="checkbox"]').prop('checked', false);
    } else {
      $('#selectAll').val(1);
      $('.selectAll').removeClass('fa-square');
      $('.selectAll').addClass('fa-square-check');
      $('input[type="checkbox"]').prop('checked', true);
    }
  }

  function selectBoxChangeStep() {
    var checkedInputsArray = $('input[name="selectCheckbox"]:checked').map(function() {
      return this.value;
    }).get();
    if ($.isEmptyObject(checkedInputsArray)) {
      alert('請選擇訂單！');
      return;
    }
    if ($('#selectStep').val() == '') {
      alert('請選擇狀態！');
      return;
    }
    if (confirm('訂定要變更訂單狀態？')) {
      $.ajax({
        type: "POST",
        url: '/admin/order/selectBoxChangeStep',
        data: {
          id_list: checkedInputsArray,
          step: $('#selectStep').val(),
        },
        success: function(data) {
          $('#operateModal').modal('hide');
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
<!-- 產生FM訂單 -->
<script>
  function fmOrderBtn(orderId) {
    var orderType = $('#orderType').val();

    // 构建完整的URL
    var url = '/fmtoken/' + orderType + '/' + orderId;

    // 跳转到URL
    window.location.href = url;
  }
</script>