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
                    <th class="text-center text-nowrap">配送方式</th>
                    <th class="text-center text-nowrap">金額/付款方式</th>
                    <th>訂單狀態</th>
                    <th>代言人</th>
                </tr>
            </thead>
            <?if (!empty($orders)) {
          foreach ($orders as $order) {
          $agentName = $this->agent_model->getAgentName($order['agent_id']);?>
            <tbody class="pc_control">
                <?if ($order['order_step'] == 'pay_ok'){ ?>
                <tr class="pay_ok_color">
                    <?}if ($order['order_step'] == 'order_cancel'){ ?>
                <tr class="order_cancel_color">
                    <?}if ($order['order_step'] == 'shipping'){ ?>
                <tr class="shipping_color">
                    <?}if ($order['order_step'] == 'complete'){ ?>
                <tr class="complete_color">
                    <?}if ($order['order_step'] == 'process'){ ?>
                <tr class="process_color">
                    <?}if ($order['order_step'] == 'confirm'){ ?>
                <tr>
                    <?}?>
                    <td style="<?=($order['order_step'] == 'order_cancel'? 'text-decoration: line-through;' : '')?>">
                        <a href="/admin/order/view/<?php echo $order['order_id'] ?>" target="_blank">
                            <?php echo $order['order_number'] ?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
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
                    <td class="text-center">
                        <?=get_delivery($order['order_delivery']) ?>
                    </td>
                    <td class="text-center">
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
                    );
                    foreach ($step_array as $key => $value) {
                      if ($key == $order['order_step']) {
                        echo $value;
                      }
                    }?>
                    </td>
                    <td>
                        <?=$agentName?>
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