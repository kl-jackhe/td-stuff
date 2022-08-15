<style>
    .front_title {
        font-size: 18px;
    }
    .money_size {
        color: #dd0606;
        font-weight: bold;
        font-size: 24px;
    }
    tr:last-child td:last-child {
        border-bottom-right-radius: 0px;
    }
    tr:first-child td:last-child {
    border-top-right-radius: 0px;
    }
    tr:last-child td:first-child {
    border-bottom-left-radius: 0px;
    }
    tr:first-child td:first-child {
        border-top-left-radius: 0px;
    }
</style>
<div class="checkout-list" style="border: none; box-shadow: none; margin-bottom: 0px;">
    <div class="row">
        <div class="col-md-12">
            <h3 class="m-0 pb-2">訂單編號：<?php echo $order['order_number'] ?></h3>
            <h3 class="m-0 pb-2">下單時間：<?php echo $order['created_at'] ?></h3>
            <h3 class="m-0 pb-2">訂單狀態：<?php echo get_order_step($order['order_step']) ?></h3>
            <h3 class="m-0 pb-2">訂單內容</h3>
            <table class="table table-hover m_table_none m-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col" class="text-nowrap" style="width: 75px;">圖片</th>
                        <th scope="col" class="text-nowrap">商品</th>
                    </tr>
                </thead>
                <?php 
                $count = 1;
                $total = 0;
                 if (!empty($order_item)) {
                	foreach ($order_item as $item) {
                		if ($item['product_id'] == 0) {?>
                <tbody>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><?php $this->db->select('*');
                			$this->db->from('product_combine');
                			$this->db->where('id', $item['product_combine_id']);
                			$query = $this->db->get();
                			foreach ($query->result_array() as $row) {
                				echo get_front_image($row['picture']);
                			}?>
                        </td>
                        <td>
                            <div>
                            <?php $i = 0;
                			$this->db->select('*');
                			$this->db->from('product_combine');
                			$this->db->join('product_combine_item', 'product_combine.id = product_combine_item.product_combine_id', 'right');
                			$this->db->where('product_combine.id', $item['product_combine_id']);
                			$query = $this->db->get();
                			foreach ($query->result_array() as $row) {
                				// echo $row['id'] . ' ' . $row['product_specification'] . ' ' . $row['product_id'] . '<br>';
                				if ($i < 1) {
                					echo get_product_name($row['product_id']) . ' - ' . get_product_combine_name($row['product_combine_id']);
                				}?>
                                <ul class="pl-3 m-0" style="color: gray;">
                                    <li style="list-style-type: circle;">
                                    <?echo $row['qty'] . ' ' . $row['product_unit'];
                                    if (!empty($row['product_specification'])) {
                                        echo ' - ' . $row['product_specification'];
                                    }?>
                                    </li>
                                </ul>
                				<?$i++;}?>
                            </div>
                            <div>金額：$<?php echo number_format($item['order_item_price']) ?></div>
                            <div>數量：<?php echo $item['order_item_qty'] ?></div>
                            <div>小計：<span style="color:#dd0606;">$<?php echo number_format($item['order_item_qty'] * $item['order_item_price']) ?></span></div>
                        </td>
                    </tr>
                </tbody>
                <?php $count++;?>
                <?php $total += $item['order_item_qty'] * $item['order_item_price'];?>
                <?php }}}?>
            </table>
            <hr>
            <span class="front_title">小計：<span class="money_size">$<?php echo number_format($total) ?> </span></span>
            <hr>
            <h3>配送 / 取貨方式：<?php echo get_delivery($order['order_delivery']) ?></h3>
            <h3>配送 / 取貨地點：
                <?php if (!empty($order['order_store_address'])) {
                	echo $order['order_store_name'] . ' ' . $order['order_store_address'];
                } else {
                	echo $order['order_delivery_address'];
                }?>
            </h3>
            <span class="front_title">運費：<span class="money_size"> $<?php echo format_number($order['order_delivery_cost']) ?></span></span>
            <hr>
            <span class="front_title">總計：<span class="money_size"> $<?php echo format_number($order['order_discount_total']) ?></span></span>
            <hr>
            <h3>付款方式：<?php echo get_payment($order['order_payment']) ?></h3>
            <!-- <h3>付款狀態：已付款</h3> -->
            <?php if ($order['order_payment'] == 'bank_transfer') {?>
            <!-- <h4 class="fs-16 color-595757 bold">ATM付款資訊</h4> -->
            <table class="table table-bordered">
                <tr>
                    <th style="width: 30%;">
                        <span class="fs-13">銀行代碼</span>
                    </th>
                    <td>
                        <span class="fs-16 color-595757"><?php echo get_setting_general('atm_bank_code') ?></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span class="fs-13">銀行帳號</span>
                    </th>
                    <td>
                        <span class="fs-16 color-595757"><?php echo get_setting_general('atm_bank_account') ?></span>
                    </td>
                </tr>
            </table>
            <p>完成付款後，記得聯繫客服，確認付款完成！</p>
            <?php }?>
            <hr>
            <h3>訂購人資訊</h3>
            <p>姓名：<?php echo $order['customer_name'] ?></p>
            <p>聯絡電話：<?php echo $order['customer_phone'] ?></p>
            <p>E-mail：<?php echo $order['customer_email'] ?></p>
            <p>地址：<?php echo $order['order_delivery_address'] ?></p>
            <hr>
            <h3>訂單備註</h3>
            <p style="border: 1px solid gray;border-radius: 5px;margin: 0px;padding: 10px;">
                <?php if (!empty($order['order_remark'])) {
                    echo $order['order_remark'];
                } else {
                    echo '無填寫訂單備註。';
                }?>
            </p>
        </div>
    </div>
</div>