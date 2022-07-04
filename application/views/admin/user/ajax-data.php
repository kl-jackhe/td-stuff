<?php echo $this->ajax_pagination_admin->create_links(); ?>
<?php $attributes = array('class' => 'submit_form', 'id' => 'submit_form'); ?>
<?php echo form_open('admin/user/export' , $attributes); ?>
<div class="form-group">
  <div class="form-inline">
    <select name="action" id="action" class="form-control">
      <option value="export">匯出</option>
    </select>
    <button type="subit" class="btn btn-primary">操作</button>
  </div>
</div>

<table class="table table-striped table-bordered table-hover" id="data-table">
  <thead>
    <tr class="info">
      <th class="text-center"><input type="checkbox" id="checkAll"></th>
      <th>姓名</th>
      <th>Email</th>
      <th>電話號碼</th>
      <th>最近一筆訂單時間</th>
      <th>生日月份</th>
      <th>認證</th>
      <th>操作</th>
    </tr>
  </thead>
  <?php if(!empty($auth)): foreach($auth as $data): ?>
    <tr>
      <td class="text-center"><input type="checkbox" name="username[]" value="<?php echo $data['username'] ?>"></td>
      <td><?php echo $data['full_name'] ?></td>
      <td><?php echo $data['email'] ?></td>
      <td><?php echo $data['username'] ?></td>
      <td><?php echo get_last_order_date($data['user_id']) ?></td>
      <td><?php echo substr($data['birthday'],5,2) ?> 月</td>
      <td><?php echo get_yes_no($data['active']) ?></td>
      <td>
        <a href="/admin/user/edit_user/<?php echo $data['user_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> 編輯</a>
        <!-- <a href="/admin/user/edit_delivery_time/<?php echo $data['user_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> 編輯可訂購時段</a> -->
        <a href="/admin/user/delete_user/<?php echo $data['user_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i> 刪除</a>
      </td>
    </tr>
  <?php endforeach ?>
  <?php else: ?>
    <!-- <tr>
      <td colspan="15"><center>對不起, 沒有資料 !</center></td>
    </tr> -->
  <?php endif; ?>
</table>
<?php echo form_close() ?>

<script>
$(document).ready(function() {
  $("#checkAll").click(function(){
    $('#data-table input:checkbox').not(this).prop('checked', this.checked);
  });
});
</script>

<!-- <script>
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
</script> -->