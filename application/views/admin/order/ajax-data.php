<?php echo $this->ajax_pagination_admin->create_links(); ?>

<table class="table table-striped table-bordered table-hover" id="data-table">
  <thead>
    <tr class="info">
      <th>訂單編號</th>
      <th>訂單日期</th>
      <th class="text-center">訂單金額</th>
      <th>客戶名稱</th>
      <th>配送地址</th>
      <th class="text-center">配送方式</th>
      <th class="text-center">付款方式</th>
      <!-- <th class="text-center">付款狀態</th> -->
      <!-- <th class="text-center">訂單狀態</th> -->
      <th>訂單狀態</th>
      <th>操作</th>
    </tr>
  </thead>
  <? if (!empty($orders)): foreach ($orders as $order): ?>
    <tr>
      <td><?php echo $order['order_number'] ?></td>
      <td><?php echo $order['order_date'] ?></td>
      <td class="text-right"><?php echo format_number($order['order_discount_total']) ?></td>
      <td><?php echo $order['customer_name'] ?></td>
      <td>
        <?php if (!empty($order['order_store_address'])) {
		echo $order['order_store_name'] . '<br>';
		echo $order['order_store_address'];
	} else {
		echo $order['order_delivery_address'];
	}?>
	      </td>
	      <td class="text-center"><?php echo get_delivery($order['order_delivery']) ?></td>
	      <td class="text-center"><?php echo get_payment($order['order_payment']) ?></td>
	      <!-- <td class="text-right"><?php echo get_pay_status($order['order_pay_status']) ?></td> -->
	      <!-- <td class="text-right"><?php echo get_order_step($order['order_step']) ?></td> -->
	      <td>
	        <?php $attributes = array('class' => 'form-inline');?>
	        <?php echo form_open('admin/order/update_step/' . $order['order_id'], $attributes); ?>
	          <? $att = 'class="form-control"';
        	$options = array(
        		'confirm' => '訂單確認',
        		'pay_ok' => '已收款',
            'process' => '待出貨',
        		'shipping' => '已出貨',
        		'complete' => '完成',
            'order_cancel' => '訂單取消',
        	);
        	echo form_dropdown('order_step', $options, $order['order_step'], $att);?>
	          <button type="submit" class="btn btn-primary btn-sm">修改</button>
	        <?php echo form_close() ?>
	      </td>
			      <td>
			        <a href="/admin/order/view/<?php echo $order['order_id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i> </a>
			      </td>
			    </tr>
			  <?php endforeach?>
  <?php else: ?>
    <tr>
      <td colspan="15"><center>對不起, 沒有資料 !</center></td>
    </tr>
  <?php endif;?>
</table>