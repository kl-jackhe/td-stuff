<?php echo $this->ajax_pagination_admin->create_links(); ?>
<?php $attributes = array('class' => 'store_order_time_area', 'id' => 'store_order_time_area'); ?>
<?php echo form_open('admin/store_order_time_area/multiple_action' , $attributes); ?>
<div class="form-group">
  <div class="form-inline">
    <label><input type="checkbox" id="checkAll"> 全選</label>
    <select name="action" id="action" class="form-control">
      <option value="0">--動作--</option>
      <option value="delete">刪除</option>
    </select>
    <button type="subit" class="btn btn-primary">操作</button>
  </div>
</div>

<table class="table table-striped table-bordered table-hover" id="data-table">
  <thead>
    <tr class="info">
      <th></th>
      <th>店家</th>
      <th>取餐區</th>
      <th>可訂購日</th>
      <th>結單時間</th>
      <th>操作</th>
    </tr>
  </thead>
  <?php if(!empty($store_order_time_area)): foreach($store_order_time_area as $data): ?>
    <tr id="tr-<?php echo $data['store_order_time_area_id'] ?>">
      <td class="text-center"><input type="checkbox" name="store_order_time_area_id[]" value="<?php echo $data['store_order_time_area_id'] ?>"></td>
      <td><?php echo get_store_name($data['store_id']) ?></td>
      <td><?php echo $data['delivery_county'] ?><?php echo $data['delivery_district'] ?></td>
      <td><?php echo $data['store_order_time_area'] ?></td>
      <td><?php echo $data['store_close_time'] ?></td>
      <td>
        <?php // if(date('Y-m-d')<=substr($data['store_order_time_area'], -10, 10)){ ?>
          <a href="/admin/store_order_time_area/edit/<?php echo $data['store_order_time_area_id'] ?>" class="btn btn-info btn-sm modal-btn"><i class="fa fa-edit"></i> 編輯</a>
        <?php // } ?>
          <!-- <a href="/admin/store_order_time_area/delete/<?php echo $data['store_order_time_area_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i> 刪除</a> -->
          <span class="btn btn-danger btn-sm" onclick="javascript:return del('<?php echo $data['store_order_time_area_id'] ?>')"><i class="fa fa-trash-o"></i> 刪除</span>
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
  $('.modal-btn').on('click', function(e){
    e.preventDefault();
    //$('#use-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
    $('#use-Modal').modal('show').find('.modal-body').load(this.href);
  });
});

function del(id) {
  var msg = "您確定要刪除嗎?";
  if (confirm(msg)==true){
    // return true;
    $.ajax({
      type: "GET",
      url: "/admin/store_order_time_area/ajax_delete/"+id,
      data: { },
      // dataType: "json",
      beforeSend: function () {
        //
      },
      success: function(data) {
        if (data == 'ok') {
          $('#tr-'+id).remove();
        }
      }
    });
  }else{
    return false;
  }
}
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