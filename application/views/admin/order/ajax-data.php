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
                <p class="btn btn-primary btn-sm" style="margin-bottom: 10px;" data-toggle="modal" data-target="#operateModal">操作 <i class="fa-solid fa-arrow-up-right-from-square"></i></p>
                <br>
                <input type="hidden" id="selectAll" value="0">
                <p class="btn btn-success btn-sm" onclick="selectAll()">全選 <i class="fa-regular fa-square selectAll"></i></p>
            </th>
            <th class="text-center">訂單編號</th>
            <th class="text-center">訂單日期</th>
            <th class="text-center">客戶</th>
            <th class="text-center">配送地址</th>
            <th class="text-center text-nowrap">配送方式</th>
            <th class="text-center text-nowrap">金額/付款方式</th>
            <th class="text-center">匯款後五碼</th>
            <th class="text-center">訂單狀態</th>

            <?php if ($this->is_partnertoys) : ?>
                <!-- 新增物流單 -->
                <th class="text-center">物流交易編號</th>
                <th class="text-center">寄貨編號</th>
            <?php else : ?>
                <th class="text-center">銷售頁面</th>
                <th class="text-center">代言人</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody class="pc_control">
        <? if (!empty($orders)) {
            foreach ($orders as $order) {
                $agentName = $this->agent_model->getAgentName($order['agent_id']); ?>
                <tr class="<?= ($order['order_step'] == 'pay_ok' ? 'pay_ok_color' : '') ?> <?= ($order['order_step'] == 'order_cancel' ? 'order_cancel_color' : '') ?> <?= ($order['order_step'] == 'shipping' ? 'shipping_color' : '') ?> <?= ($order['order_step'] == 'complete' ? 'complete_color' : '') ?> <?= ($order['order_step'] == 'process' ? 'process_color' : '') ?> <?= ($order['order_step'] == 'invalid' ? 'invalid_color' : '') ?>">
                    <td class="text-center">
                        <input type="checkbox" name="selectCheckbox" style="width: 20px;height: 20px;cursor: pointer;" value="<?= $order['order_id'] ?>">
                    </td>
                    <td style="<?= ($order['order_step'] == 'order_cancel' ? 'text-decoration: line-through;' : '') ?>">
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
                        <?= (!empty($order['order_store_address']) ? $order['order_store_name'] . '<br>' . $order['order_store_address'] : $order['order_delivery_address']) ?>
                    </td>
                    <td class="text-center">
                        <?= get_delivery($order['order_delivery']) ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if (substr($order['order_payment'], 0, 5) == 'ecpay') {
                            $order['order_payment'] = substr($order['order_payment'], 0, 5);
                        }
                        echo '$' . format_number($order['order_discount_total']) . '<br>' . get_payment($order['order_payment']);
                        if ($order['order_payment'] == 'ecpay') {
                            echo '<br>' . get_pay_status($order['order_pay_status']);
                        } ?>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <? $attributes = array('class' => 'form-inline');
                                echo form_open('admin/order/update_remittance_account/' . $order['order_id'], $attributes); ?>
                                <input type="text" class="form-control" name="remittance_account" value="<?= $order['remittance_account'] ?>">
                                <button type="submit" class="btn btn-primary btn-sm">更新</button>
                                <? echo form_close() ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <select id="order_step_<?= $order['order_id'] ?>pc" onchange="changeStep('<?= $order['order_id'] ?>','pc')" class="form-control">
                            <? foreach ($step_list as $key => $value) {
                                if ($key != '') { ?>
                                    <option value="<?= $key ?>" <?= ($key == $order['order_step'] ? 'selected' : '') ?>><?= $value ?></option>
                            <? }
                            } ?>
                        </select>
                    </td>
                    <!-- 新增物流單 -->
                    <?php if ($this->is_partnertoys) : ?>
                        <?php if (!empty($order['AllPayLogisticsID']) && !empty($order['CVSPaymentNo'])) : ?>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <input type="text" class="form-control" value="<?php echo $order['AllPayLogisticsID'] ?>" readonly>
                                        <button type="submit" class="btn btn-primary btn-sm" disabled>更新</button>
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php echo $order['CVSPaymentNo'] ?>
                            </td>
                        <?php else : ?>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <?php $attributes = array('class' => 'form-inline'); ?>
                                        <?php echo form_open('admin/order/updata_self_logistics/' . $order['order_id'], $attributes); ?>
                                        <input type="text" class="form-control" name="self_logistics" value="<?php echo $order['SelfLogistics'] ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">更新</button>
                                        <?php echo form_close() ?>
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                NONE
                            </td>
                        <?php endif; ?>
                    <?php else : ?>
                        <td>
                            <? if ($order['single_sales_id'] != '') { ?>
                                <a href="/admin/sales/editSingleSales/<?= $order['single_sales_id'] ?>" target="_blank">
                                    <?= $order['single_sales_id'] ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            <? } ?>
                        </td>
                        <td>
                            <? if ($agentName != '') { ?>
                                <a href="/admin/agent/editAgent<?= $order['agent_id'] ?>" target="_blank">
                                    <?= $agentName ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            <? } ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <? }
        } else { ?>
            <tr>
                <td colspan="15">
                    <center>對不起, 沒有資料 !</center>
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tbody class="mb_control">
        <? if (!empty($orders)) {
            foreach ($orders as $order) {
                $agentName = $this->agent_model->getAgentName($order['agent_id']); ?>
                <tr class="<?= ($order['order_step'] == 'pay_ok' ? 'pay_ok_color' : '') ?> <?= ($order['order_step'] == 'order_cancel' ? 'order_cancel_color' : '') ?> <?= ($order['order_step'] == 'shipping' ? 'shipping_color' : '') ?> <?= ($order['order_step'] == 'complete' ? 'complete_color' : '') ?> <?= ($order['order_step'] == 'process' ? 'process_color' : '') ?> <?= ($order['order_step'] == 'invalid' ? 'invalid_color' : '') ?>">
                    <td>
                        <p>訂單編號：
                            <a href="/admin/order/view/<?php echo $order['order_id'] ?>" target="_blank" <?= ($order['order_step'] == 'order_cancel' ? 'style="text-decoration: line-through;"' : '') ?>>
                                <?php echo $order['order_number'] ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                            </a>
                        </p>
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
                            <? if (!empty($order['order_store_address'])) {
                                echo $order['order_store_name'] . '<br>';
                                echo $order['order_store_address'];
                            } else {
                                echo $order['order_delivery_address'];
                            } ?>
                        </p>
                    </td>
                </tr>
                <tr class="<?= ($order['order_step'] == 'pay_ok' ? 'pay_ok_color' : '') ?> <?= ($order['order_step'] == 'order_cancel' ? 'order_cancel_color' : '') ?> <?= ($order['order_step'] == 'shipping' ? 'shipping_color' : '') ?> <?= ($order['order_step'] == 'complete' ? 'complete_color' : '') ?> <?= ($order['order_step'] == 'process' ? 'process_color' : '') ?> <?= ($order['order_step'] == 'invalid' ? 'invalid_color' : '') ?>">
                    <td>
                        <p>匯款後五碼</p>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <? $attributes = array('class' => 'form-inline');
                                echo form_open('admin/order/update_remittance_account/' . $order['order_id'], $attributes); ?>
                                <input type="text" class="form-control" name="remittance_account" value="<?= $order['remittance_account'] ?>">
                                <button type="submit" class="btn btn-primary btn-sm">更新</button>
                                <? echo form_close() ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <p>訂單狀態</p>
                        <select id="order_step_<?= $order['order_id'] ?>mb" onchange="changeStep('<?= $order['order_id'] ?>','mb')" class="form-control">
                            <? foreach ($step_list as $key => $value) {
                                if ($key != '') { ?>
                                    <option value="<?= $key ?>" <?= ($key == $order['order_step'] ? 'selected' : '') ?>><?= $value ?></option>
                            <? }
                            } ?>
                        </select>
                    </td>
                </tr>
                <? if ($order['single_sales_id'] != '' || $agentName != '') { ?>
                    <tr class="<?= ($order['order_step'] == 'pay_ok' ? 'pay_ok_color' : '') ?> <?= ($order['order_step'] == 'order_cancel' ? 'order_cancel_color' : '') ?> <?= ($order['order_step'] == 'shipping' ? 'shipping_color' : '') ?> <?= ($order['order_step'] == 'complete' ? 'complete_color' : '') ?> <?= ($order['order_step'] == 'process' ? 'process_color' : '') ?> <?= ($order['order_step'] == 'invalid' ? 'invalid_color' : '') ?>">
                        <td>
                            <? if ($order['single_sales_id'] != '') { ?>
                                <a href="/admin/sales/editSingleSales/<?= $order['single_sales_id'] ?>" target="_blank">
                                    <?= $order['single_sales_id'] ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            <? } ?>
                        </td>
                        <td>
                            <? if ($agentName != '') { ?>
                                <a href="/admin/agent/editAgent<?= $order['agent_id'] ?>" target="_blank">
                                    <?= $agentName ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            <? } ?>
                        </td>
                    </tr>
            <? }
            }
        } else { ?>
            <tr>
                <td colspan="15">
                    <center>對不起, 沒有資料 !</center>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>