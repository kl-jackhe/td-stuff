<?php echo $this->ajax_pagination_admin->create_links(); ?>
<style>
p {
    margin: 0px;
}
.mb_control {
    display: none;
}
.input-group {
    width: 65%;
}
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
@media screen and (max-width:767px) {
  .input-group {
    width: 65%;
  }
  .pc_control {
      display: none;
  }
  .mb_control {
      display: block;
  }
}
</style>
<table class="table table-striped table-bordered table-hover" id="data-table">
    <thead class="pc_control">
        <tr class="info">
            <th>
                <?$order_step_list = array(
                    'confirm' => '訂單確認',
                    'pay_ok' => '已收款',
                    'process' => '待出貨',
                    'shipping' => '已出貨',
                    'complete' => '完成',
                    'invalid' => '訂單不成立',);?>
                <select class="form-control" >
                    <option value="">選擇狀態</option>
                    <?foreach ($order_step_list as $key => $value) {?>
                        <option value="<?=$key?>"><?=$value?></option>
                    <?}?>
                </select>
                <div class="input-group">
                    <span class="input-group-addon">全選</span>
                    <span class="input-group-addon">
                        <input type="checkbox" id="selectAll" style="width: 30px;">
                    </span>
                </div>
            </th>
            <th>訂單編號</th>
            <th>訂單日期</th>
            <th>客戶名稱</th>
            <th>配送地址</th>
            <th class="text-center text-nowrap">配送方式</th>
            <th class="text-center text-nowrap">金額/付款方式</th>
            <th>匯款後五碼</th>
            <th>訂單狀態</th>
            <th>銷售頁面</th>
            <th>代言人</th>
        </tr>
    </thead>
    <?if (!empty($orders)) {
        foreach ($orders as $order) {
        $agentName = $this->agent_model->getAgentName($order['agent_id']);?>
        <tbody class="pc_control">
            <tr class="<?=($order['order_step'] == 'pay_ok'? 'pay_ok_color' : '')?> <?=($order['order_step'] == 'order_cancel'? 'order_cancel_color' : '')?> <?=($order['order_step'] == 'shipping'? 'shipping_color' : '')?> <?=($order['order_step'] == 'complete'? 'complete_color' : '')?> <?=($order['order_step'] == 'process'? 'process_color' : '')?> <?=($order['order_step'] == 'invalid'? 'invalid_color' : '')?>">
                <td class="text-center">
                    <input type="checkbox" class="form-control" name="" style="width: 25px;display: inline-block;" value="<?=$order['order_id']?>">
                </td>
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
                    <div class="input-group">
                        <span class="input-group-btn">
                            <?$attributes = array('class' => 'form-inline');
                            echo form_open('admin/order/update_remittance_account/' . $order['order_id'], $attributes);?>
                            <input type="text" class="form-control" name="remittance_account" value="<?=$order['remittance_account']?>">
                            <button type="submit" class="btn btn-primary btn-sm">更新</button>
                            <?echo form_close() ?>
                        </span>
                    </div>
                </td>
                <td>
                    <select id="order_step_<?=$order['order_id']?>pc" onchange="changeStep('<?=$order['order_id']?>','pc')" class="form-control">
                        <?foreach ($step_list as $key => $value) {
                            if ($key != '' && $key != 'order_cancel') {?>
                                <option value="<?=$key?>" <?=($key == $order['order_step']?'selected':'')?>><?=$value?></option>
                            <?}
                        }?>
                    </select>
                </td>
                <td>
                    <?if ($order['single_sales_id'] != '') {?>
                        <a href="/admin/sales/editSingleSales/<?php echo $order['single_sales_id'] ?>" target="_blank">
                            <?=$order['single_sales_id']?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
                        </a>
                    <?}?>
                </td>
                <td>
                    <?=$agentName?>
                </td>
            </tr>
        </tbody>
        <tbody class="mb_control">
            <tr class="<?=($order['order_step'] == 'pay_ok'? 'pay_ok_color' : '')?> <?=($order['order_step'] == 'order_cancel'? 'order_cancel_color' : '')?> <?=($order['order_step'] == 'shipping'? 'shipping_color' : '')?> <?=($order['order_step'] == 'complete'? 'complete_color' : '')?> <?=($order['order_step'] == 'process'? 'process_color' : '')?> <?=($order['order_step'] == 'invalid'? 'invalid_color' : '')?>">
                <td>
                    <?if ($order['order_step'] == 'order_cancel'){ ?>
                    <p>訂單編號：<span style="text-decoration: line-through;">
                        <?php echo $order['order_number'] ?></span></p>
                    <?}else{?>
                    <p>訂單編號：
                        <?php echo $order['order_number'] ?>
                    </p>
                    <?}?>
                    <p>訂單日期：
                        <?php echo $order['order_date'] ?>
                    </p>
                    <p>客戶名稱：
                        <?php echo $order['customer_name'] ?>
                    </p>
                    <p>配送方式：
                        <?php echo get_delivery($order['order_delivery']) ?>
                    </p>
                    <p>付款方式：
                        <?php echo get_payment($order['order_payment']) ?>
                    </p>
                    <p>訂單金額：<span style="color:red;font-weight: bold;">
                        <?php echo format_number($order['order_discount_total']) ?></span></p>
                </td>
                <td>
                    <p>寄送/取貨地址：</p>
                    <p>
                        <?if (!empty($order['order_store_address'])) {
                          echo $order['order_store_name'] . '<br>';
                          echo $order['order_store_address'];
                        } else {
                          echo $order['order_delivery_address'];
                        }?>
                    </p>
                </td>
            </tr>
            <tr class="<?=($order['order_step'] == 'pay_ok'? 'pay_ok_color' : '')?> <?=($order['order_step'] == 'order_cancel'? 'order_cancel_color' : '')?> <?=($order['order_step'] == 'shipping'? 'shipping_color' : '')?> <?=($order['order_step'] == 'complete'? 'complete_color' : '')?> <?=($order['order_step'] == 'process'? 'process_color' : '')?> <?=($order['order_step'] == 'invalid'? 'invalid_color' : '')?>">
                <td>
                    <p>匯款後五碼</p>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <?$attributes = array('class' => 'form-inline');
                            echo form_open('admin/order/update_remittance_account/' . $order['order_id'], $attributes);?>
                            <input type="text" class="form-control" name="remittance_account" value="<?=$order['remittance_account']?>">
                            <button type="submit" class="btn btn-primary btn-sm">更新</button>
                            <?echo form_close() ?>
                        </span>
                    </div>
                </td>
                <td>
                    <p>訂單狀態</p>
                    <select id="order_step_<?=$order['order_id']?>mb" onchange="changeStep('<?=$order['order_id']?>','mb')" class="form-control">
                        <?foreach ($step_list as $key => $value) {
                            if ($key != '' && $key != 'order_cancel') {?>
                                <option value="<?=$key?>" <?=($key == $order['order_step']?'selected':'')?>><?=$value?></option>
                            <?}
                        }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">查看訂單</span>
                        <a href="/admin/order/view/<?php echo $order['order_id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
                    </div>
                </td>
                <td>
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