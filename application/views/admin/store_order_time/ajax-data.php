<?php // echo $this->ajax_pagination_admin->create_links(); ?>
<table class="table table-striped table-bordered table-hover" id="data-table">
  <thead>
    <tr class="info">
      <th>店家</th>
      <th>取餐區</th>
      <th>可訂購日</th>
      <th>結單時間</th>
      <th>操作</th>
    </tr>
  </thead>
  <?php if(!empty($store_order_time)): foreach($store_order_time as $data): ?>
    <tr>
      <td><?php echo get_store_name($data['store_id']) ?></td>
      <td><?php echo $data['delivery_county'] ?><?php echo $data['delivery_district'] ?></td>
      <td><?php echo $data['store_order_time'] ?></td>
      <td><?php echo $data['store_close_time'] ?></td>
      <td>
        <?php if(date('Y-m-d')<=$data['store_order_time']){ ?>
          <a href="/admin/store_order_time/edit/<?php echo $data['store_order_time_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> 編輯</a>
          <!-- <a href="/admin/store_order_time/delete/<?php echo $data['store_order_time_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i> 刪除</a> -->
        <?php } ?>
      </td>
    </tr>
  <?php endforeach ?>
  <?php else: ?>
    <!-- <tr>
      <td colspan="15"><center>對不起, 沒有資料 !</center></td>
    </tr> -->
  <?php endif; ?>
</table>

<script>
$(document).ready(function() {
  $('#data-table').DataTable( {
    // "order": [[ 0, "desc" ]],
    stateSave: true,
    ordering: false,
    bFilter: false,
    // bLengthChange: false,
    "dom": '<"top"iflp<"clear">>',
    "language": {
      "processing":   "處理中...",
      "loadingRecords": "載入中...",
      "lengthMenu":   "顯示 _MENU_ 項結果",
      "zeroRecords":  "沒有符合的結果",
      "emptyTable":   "沒有資料",
      "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
      "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
      "infoFiltered": "(從 _MAX_ 項結果中過濾)",
      "infoPostFix":  "",
      "search":       "搜尋:",
      "paginate": {
          "first":    "第一頁",
          "previous": "上一頁",
          "next":     "下一頁",
          "last":     "最後一頁"
      },
      "aria": {
          "sortAscending":  ": 升冪排列",
          "sortDescending": ": 降冪排列"
      }
    }
  });
});
</script>