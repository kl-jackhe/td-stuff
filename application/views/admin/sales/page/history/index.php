<style>
.pay_ok_color {
    background-color: #C4E1FF !important;
}
.order_cancel_color {
    background-color: #FFB5B5 !important;
}
.shipping_color {
    background-color: #DAB1D5 !important;
}
.complete_color {
    background-color: #CEFFCE !important;
}
.process_color {
    background-color: #FFFFCE !important;
}
.invalid_color {
    background-color: #B3D9D9 !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover" id="history-data-table">
            <thead class="pc_control">
                <tr class="info">
                    <th>訂單編號</th>
                    <th>訂單日期</th>
                    <th>客戶名稱</th>
                    <th>配送地址</th>
                    <th>配送方式</th>
                    <th>商品數量</th>
                    <th>金額/付款方式</th>
                    <th>訂單狀態</th>
                    <th>代言人</th>
                </tr>
            </thead>
            <?if (!empty($orders)) {
          foreach ($orders as $order) {
          $agentName = $this->agent_model->getAgentName($order['agent_id']);?>
            <tbody class="pc_control">
                <tr class="<?=($order['order_step'] == 'pay_ok'? 'pay_ok_color' : '')?> <?=($order['order_step'] == 'order_cancel'? 'order_cancel_color' : '')?> <?=($order['order_step'] == 'shipping'? 'shipping_color' : '')?> <?=($order['order_step'] == 'complete'? 'complete_color' : '')?> <?=($order['order_step'] == 'process'? 'process_color' : '')?> <?=($order['order_step'] == 'invalid'? 'invalid_color' : '')?>">
                    <td style="<?=($order['order_step'] == 'order_cancel'? 'text-decoration: line-through;' : '')?>">
                        <a href="/admin/order/view/<?=$order['order_id'] ?>" target="_blank">
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
                    <td><?=$this->order_model->getSingleOrderProductQTY($order['order_id']);?></td>
                    <td>
                        <?php
                      echo '$' . format_number($order['order_discount_total']) . '<br>' . get_payment($order['order_payment']);
                      if ($order['order_payment']=='ecpay'){
                          echo '<br>'.get_pay_status($order['order_pay_status']);
                      }?>
                    </td>
                    <td>
                        <?
                    $step_array = array(
                      'confirm' => '訂單確認',
                      'pay_ok' => '已收款',
                      'process' => '待出貨',
                      'shipping' => '已出貨',
                      'complete' => '完成',
                      'order_cancel' => '訂單取消',
                      'invalid' => '訂單不成立',
                    );
                    foreach ($step_array as $key => $value) {
                      if ($key == $order['order_step']) {
                        echo $value;
                      }
                    }?>
                    </td>
                    <td>
                        <a href="/admin/agent/editAgent<?=$order['agent_id']?>" target="_blank">
                            <?=$agentName?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <?}
      } else {?>
            <tr>
                <td colspan="15">
                    <center>對不起, 沒有資料 !</center>
                </td>
            </tr>
            <?}?>
        </table>
    </div>
</div>