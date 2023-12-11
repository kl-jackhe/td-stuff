<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-striped" id="sales_order_history_table">
			<thead>
				<tr class="info">
					<th>訂單編號</th>
		            <th>訂單日期</th>
		            <th>客戶名稱</th>
		            <th>配送地址</th>
		            <th>配送方式</th>
		            <th>金額/付款方式</th>
		            <th>訂單狀態</th>
		            <th>銷售頁面</th>
				</tr>
			</thead>
			<tbody>
				<?if (!empty($sales_order_list)) {
		            foreach ($sales_order_list as $order) {?>
			            <tr class="<?=($order['order_step'] == 'pay_ok'? 'pay_ok_color' : '')?> <?=($order['order_step'] == 'order_cancel'? 'order_cancel_color' : '')?> <?=($order['order_step'] == 'shipping'? 'shipping_color' : '')?> <?=($order['order_step'] == 'complete'? 'complete_color' : '')?> <?=($order['order_step'] == 'process'? 'process_color' : '')?> <?=($order['order_step'] == 'invalid'? 'invalid_color' : '')?>">
			                <td style="<?=($order['order_step'] == 'order_cancel'? 'text-decoration: line-through;' : '')?>">
			                    <a href="/admin/order/view/<?php echo $order['order_id'] ?>" target="_blank">
			                    <?php echo $order['order_number'] ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
			                    </a>
			                </td>
			                <td>
			                    <?php echo $order['order_date'] ?>
			                </td>
			                <td>
			                    <?php echo $order['customer_name'] ?>
			                </td>
			                <td>
			                    <?=(!empty($order['order_store_address'])? $order['order_store_name'] . '<br>' . $order['order_store_address'] : $order['order_delivery_address'])?>
			                </td>
			                <td>
			                    <?=get_delivery($order['order_delivery']) ?>
			                </td>
			                <td>
			                    <?php
			                    echo '$' . format_number($order['order_discount_total']) . '<br>' . get_payment($order['order_payment']);
			                    if ($order['order_payment']=='ecpay'){
			                        echo '<br>'.get_pay_status($order['order_pay_status']);
			                    }?>
			                </td>
			                <td>
			                	<?foreach ($step_list as $key => $value) {
			                        if ($key == $order['order_step']) {
			                        	echo $value;
			                        }
			                    }?>
			                </td>
			                <td>
			                    <?if ($order['single_sales_id'] != '') {?>
			                        <a href="/admin/sales/editSingleSales/<?=$order['single_sales_id'] ?>" target="_blank">
			                            <?=$order['single_sales_id']?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
			                        </a>
			                    <?}?>
			                </td>
			            </tr>
		        	<?}
		        } else {?>
			        <tr>
			            <td colspan="15">
			                <center>對不起, 沒有資料 !</center>
			            </td>
			        </tr>
		        <?}?>
			</tbody>
		</table>
	</div>
</div>