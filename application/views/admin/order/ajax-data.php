<?php echo $this->ajax_pagination_admin->create_links(); ?>
<?php // $attributes = array('class' => 'order', 'id' => 'order', 'target' => "_self"); ?>
<?php // echo form_open('admin/order/multiple_action' , $attributes); ?>
<div class="form-group hide">
  <div class="form-inline">
    <label><input type="checkbox" id="checkAll"> 全選</label>
    <select name="action" id="action" class="form-control">
      <option value="0">--動作--</option>
      <!-- <option value="accept">接收訂單</option> -->
      <!-- <option value="prepare">餐點準備中</option> -->
      <!-- <option value="shipping">餐點運送中</option> -->
      <!-- <option value="arrive">司機抵達</option> -->
      <option value="picked">已取餐</option>
      <!-- <option value="cancel">取消訂單</option> -->
      <!-- <option value="void">已退單</option> -->
      <!-- <option value="pdf">PDF</option> -->
    </select>
    <button type="subit" class="btn btn-primary">操作</button>
  </div>
</div>

<table class="table table-striped table-bordered table-hover" id="data-table">
  <thead>
    <tr class="info">
      <!-- <th></th> -->
      <th>訂單編號</th>
      <th>訂單日期</th>
      <th>取餐日期</th>
      <th>取餐時段</th>
      <th>訂購人</th>
      <th>取餐地址</th>
      <th class="text-center">付款方式</th>
      <th class="text-center">付款狀態</th>
      <!-- <th class="text-center">訂單狀態</th> -->
      <th>訂單確認</th>
      <th>操作</th>
    </tr>
  </thead>
  <?php if(!empty($orders)): foreach($orders as $order): ?>
    <tr>
      <!-- <td><input type="checkbox" name="order_id[]" value="<?php echo $order['order_id'] ?>"></td> -->
      <td><?php echo $order['order_number'] ?></td>
      <td><?php echo substr($order['created_at'], 0, 10) ?></td>
      <td><?php echo $order['order_date'] ?></td>
      <td><?php echo $order['order_delivery_time'] ?></td>
      <!-- <td><?php echo $order['customer_name'] ?></td> -->
      <td><?php echo get_user_full_name($order['customer_id']) ?></td>
      <td>
        <?php if(!empty($order['order_delivery_address'])){
            echo $order['order_delivery_address'];
        } else {
            echo get_delivery_place_name($order['order_delivery_place']);
        } ?>
      </td>
      <td class="text-right"><?php echo get_payment($order['order_payment']) ?></td>
      <td class="text-right"><?php echo get_pay_status($order['order_pay_status']) ?></td>
      <!-- <td class="text-right"><?php echo get_order_step($order['order_step']) ?></td> -->
      <td>
        <?php $attributes = array('class' => 'form-inline'); ?>
        <?php echo form_open('admin/order/update_step/'.$order['order_id'] , $attributes); ?>
          <?php $att = 'class="form-control"';
          $data = array(
            'accept'   => '接收訂單',
            'prepare'  => '餐點準備中',
            'shipping' => '餐點運送中',
            'arrive'   => '司機抵達',
            'picked'   => '已取餐',
            'cancel'   => '取消訂單',
            'void'     => '退單',
          );
          echo form_dropdown('order_step', $data, $order['order_step'], $att); ?>
          <button type="submit" class="btn btn-primary btn-sm">修改</button>
        <?php echo form_close() ?>
        <!-- <?php if($order['order_void']==0 && $order['order_step']=='accept'){ ?>
          <?php if($order['order_payment']!='cash_on_delivery' && $order['order_pay_status']=='paid') { ?>
            <a class="btn btn-primary btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/prepare">準備中</a>
          <?php } ?>
          <?php if($order['order_payment']=='cash_on_delivery') { ?>
            <a class="btn btn-primary btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/prepare">準備中</a>
          <?php } ?>
        <?php } ?>
        <?php if($order['order_void']==0 && $order['order_step']=='prepare'){ ?>
            <a class="btn btn-primary btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/shipping">運送中</a>
        <?php } ?>
        <?php if($order['order_void']==0 && $order['order_step']=='shipping'){ ?>
            <a class="btn btn-primary btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/arrive">已抵達</a>
        <?php } ?>
        <?php if($order['order_void']==0 && $order['order_step']=='arrive'){ ?>
            <a class="btn btn-primary btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/picked">已取餐</a>
        <?php } ?>
        <?php if($order['order_void']==0 && $order['order_pay_status']=='not_paid' && $order['order_step']=='accept' ){ ?>
            <a class="btn btn-danger btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/cancel" onClick="return confirm('您確定要取消嗎?')">取消訂單</a>
        <?php } ?>
        <?php if($order['order_void']==0 && $order['order_pay_status']=='paid' && $order['order_step']=='accept'){ ?>
            <a class="btn btn-danger btn-sm" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/void" onClick="return confirm('您確定要退單嗎?')">退單</a></a>
        <?php } ?> -->
      </td>
      <td>
        <a href="/admin/order/view/<?php echo $order['order_id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i> </a>
        <a href="/admin/order/dompdf/<?php echo $order['order_id'] ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i> </a>
        <a href="/admin/order/dompdf_download/<?php echo $order['order_id'] ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i><i class="fa fa-arrow-down"></i></a>
      </td>
    </tr>
  <?php endforeach ?>
  <?php else: ?>
    <!-- <tr>
      <td colspan="15"><center>對不起, 沒有資料 !</center></td>
    </tr> -->
  <?php endif; ?>
</table>
<?php // echo form_close() ?>

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

<script>
  $("#checkAll").click(function(){
    $('#data-table input:checkbox').not(this).prop('checked', this.checked);
  });
</script>