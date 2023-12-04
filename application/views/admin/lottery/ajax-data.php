<?php echo $this->ajax_pagination_admin->create_links(); ?>
<table class="table table-striped table-bordered table-hover" id="data-table">
    <thead>
        <tr class="info">
            <th>ID</th>
            <th>抽選名稱</th>
            <th>抽選商品</th>
            <th>抽選名額</th>
            <th>已報名人數</th>
            <th>有效期限</th>
            <th>開獎時間</th>
            <th>抽選狀態</th>
        </tr>
    </thead>
    <?if(!empty($lottery)) {
        foreach($lottery as $data) {?>
            <tr>
                <td nowrap="nowrap"><?=$data['id']?></td>
                <td class="remarks">
                    <a href="/admin/lottery/edit/<?=$data['id']?>" style="font-weight: bold;text-decoration:underline;" target="_blank">
                        <?=$data["name"]?> <i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                </td>
                <td class="remarks">
                    <a href="/admin/product/edit/<?=$data['product_id']?>" style="font-weight: bold;text-decoration:underline;" target="_blank">
                        <?=get_product_name($data['product_id'])?> <i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                </td>
                <td nowrap="nowrap"><?=$data["number_limit"]?></td>
                <td nowrap="nowrap">0</td>
                <td nowrap="nowrap"><?=$data["star_time"] . ' ~ ' . $data["end_time"]?></td>
                <td nowrap="nowrap"><?=$data["draw_date"]?></td>
                <td nowrap="nowrap">
                    <?if ($data["draw_over"] == 1 && $data["lottery_end"] == 0) {
                        echo "已開獎";
                    } if ($data["draw_over"] == 1 && $data["lottery_end"] == 1) {
                        echo "結束";
                    } if ($data["draw_over"] == 0 && $data["lottery_end"] == 0) {
                        echo "/";
                    }?>
                </td>
                <!-- <td> -->
                    <!-- <button type="button" onClick="location='lottery_table.php?tree=6&act=mdy&id=<?=$data[" id"]?>'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button>
                    <button type="button" onClick="JavaScript:chkdel('lottery_submit.php?act=del&id=<?=$data[" id"]?>')" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></button> -->
                <!-- </td> -->
            </tr>
        <?}
    } else {?>
        <tr>
            <td colspan="15">
                <center>對不起, 沒有資料 !</center>
            </td>
        </tr>
    <?}?>
</table>
<!-- <script>
$(document).ready(function() {
  $('#data-table').DataTable( {
    "order": [[ 0, "desc" ]],
    stateSave: true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
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