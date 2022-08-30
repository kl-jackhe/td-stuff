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
            <th class="text-center text-nowrap">訂單編號</th>
            <th class="text-center text-nowrap">訂單日期</th>
            <th class="text-center text-nowrap">金額</th>
            <th class="text-nowrap">客戶名稱</th>
            <th class="text-nowrap">配送地址</th>
            <th class="text-center text-nowrap">配送方式</th>
            <th class="text-center text-nowrap">付款方式</th>
            <!-- <th class="text-center text-nowrap">付款狀態</th> -->
            <!-- <th class="text-center text-nowrap">訂單狀態</th> -->
            <th class="text-center text-nowrap">匯款後五碼</th>
            <th class="text-center text-nowrap">訂單狀態</th>
            <th class="text-center text-nowrap">操作</th>
        </tr>
    </thead>
    <? if (!empty($orders)): foreach ($orders as $order): ?>
    <tbody class="pc_control">
        <?if ($order['order_step'] == 'pay_ok'){ ?>
        <tr style="background-color: #0080FF;">
        <?}if ($order['order_step'] == 'order_cancel'){ ?>
        <tr style="background-color: #FF2D2D;">
        <?}if ($order['order_step'] == 'shipping'){ ?>
        <tr style="background-color: #FF8040;">
        <?}if ($order['order_step'] == 'complete'){ ?>
        <tr style="background-color: #53FF53;">
        <?}if ($order['order_step'] == 'process'){ ?>
        <tr style="background-color: #FFFF6F;">
        <?}if ($order['order_step'] == 'confirm'){ ?>
        <tr>
        <?}?>
            <?if ($order['order_step'] == 'order_cancel'){ ?>
            <td style="text-decoration: line-through;">
                <?php echo $order['order_number'] ?>
            </td>
            <?}else{?>
            <td>
                <?php echo $order['order_number'] ?>
            </td>
            <?}?>
            <td>
                <?php echo $order['order_date'] ?>
            </td>
            <td class="text-right">
                <?php echo format_number($order['order_discount_total']) ?>
            </td>
            <td>
                <?php echo $order['customer_name'] ?>
            </td>
            <td>
                <?if (!empty($order['order_store_address'])) {
                  echo $order['order_store_name'] . '<br>';
                  echo $order['order_store_address'];
                } else {
                  echo $order['order_delivery_address'];
                }?>
            </td>
            <td class="text-center">
                <?php echo get_delivery($order['order_delivery']) ?>
            </td>
            <td class="text-center">
                <?php echo get_payment($order['order_payment']) ?>
            </td>
            <!-- <td class="text-right"><?php echo get_pay_status($order['order_pay_status']) ?></td> -->
            <!-- <td class="text-right"><?php echo get_order_step($order['order_step']) ?></td> -->
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
                <div class="input-group">
                    <span class="input-group-btn">
                        <?php $attributes = array('class' => 'form-inline');?>
                        <?php echo form_open('admin/order/update_step/' . $order['order_id'], $attributes); ?>
                        <?$att = 'class="form-control dropdown-toggle"';
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
                    </span>
                </div>
            </td>
            <td>
                <a href="/admin/order/view/<?php echo $order['order_id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i> </a>
            </td>
        </tr>
    </tbody>
    <tbody class="mb_control">
        <?if ($order['order_step'] == 'pay_ok'){ ?>
        <tr style="background-color: #0080FF;">
        <?}if ($order['order_step'] == 'order_cancel'){ ?>
        <tr style="background-color: #FF2D2D;">
        <?}if ($order['order_step'] == 'shipping'){ ?>
        <tr style="background-color: #FF8040;">
        <?}if ($order['order_step'] == 'complete'){ ?>
        <tr style="background-color: #53FF53;">
        <?}if ($order['order_step'] == 'process'){ ?>
        <tr style="background-color: #FFFF6F;">
        <?}if ($order['order_step'] == 'confirm'){ ?>
        <tr>
        <?}?>
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
        <?if ($order['order_step'] == 'pay_ok'){ ?>
        <tr style="background-color: #0080FF;">
        <?}if ($order['order_step'] == 'order_cancel'){ ?>
        <tr style="background-color: #FF2D2D;">
        <?}if ($order['order_step'] == 'shipping'){ ?>
        <tr style="background-color: #FF8040;">
        <?}if ($order['order_step'] == 'complete'){ ?>
        <tr style="background-color: #53FF53;">
        <?}if ($order['order_step'] == 'process'){ ?>
        <tr style="background-color: #FFFF6F;">
        <?}if ($order['order_step'] == 'confirm'){ ?>
        <tr>
        <?}?>
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
                <div class="input-group">
                    <span class="input-group-btn">
                        <?php $attributes = array('class' => 'form-inline');?> -->
                        <?php echo form_open('admin/order/update_step/' . $order['order_id'], $attributes); ?>
                        <?$att = 'class="form-control dropdown-toggle"';
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
                    </span>
                </div>
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
    <?php endforeach?>
    <?php else: ?>
    <tr>
        <td colspan="15">
            <center>對不起, 沒有資料 !</center>
        </td>
    </tr>
    <?php endif;?>
</table>