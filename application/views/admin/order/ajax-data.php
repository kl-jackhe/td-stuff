<?php echo $this->ajax_pagination_admin->create_links(); ?>
<style>
    p {
        margin: 0px;
    }

    .spanContent {
        display: block;
        margin-bottom: 5px;
    }

    .spanContentFont {
        color: #8a6d3b;
    }

    .mb_control {
        display: none;
    }

    .inTopButton {
        position: absolute;
        right: 0;
        z-index: 500;
    }

    .input-group {
        margin: auto;
        width: 100%;
    }

    .redContent {
        color: #e30020;
    }

    .yellowContent {
        color: #e30020;
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

    .preparation_color {
        background-color: #3bd6c9 !important;
    }

    .returning_color {
        background-color: #d6823b !important;
    }

    .return_complete_color {
        background-color: #da6d6d !important;
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

    #detailOrder {
        top: 20%;
        bottom: 20%;
        font-size: 14px;
        position: fixed;
        width: 1000px;
        height: auto;
        background: #fff;
        left: 50%;
        transform: translateX(-50%);
        border: 10px solid #efefef;
        box-sizing: border-box;
        padding: 50px;
        overflow: hidden;
        /* 防止内容被滚动条遮挡 */
    }

    .detailContent {
        max-height: calc(100% - 100px);
        max-width: 100%;
        color: #333;
        line-height: 2em;
        text-align: justify;
        margin: 20px 0 10px;
        overflow-y: auto;
        box-sizing: border-box;
        padding-right: 15px;
    }

    .orderNumber {
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
    }

    .mfp-content {
        height: 50%;
    }

    .detailBtn {
        right: 0;
    }

    @media (max-width: 1100px) {

        #detailOrder {
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transform: none;
        }

        .detailContent {
            margin: 20px auto 10px;
        }
    }

    @media (max-width: 600px) {

        #detailOrder {
            padding: 50px 15px 15px 15px;
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

            <? if ($this->is_partnertoys) : ?>
                <th class="text-center">訂單編號</th>
                <th class="text-center">客戶資訊</th>
                <th class="text-center text-nowrap">配送資訊</th>
                <th class="text-center text-nowrap">付款資訊</th>
                <!-- 新增物流單 -->
                <th class="text-center">處理狀態</th>
                <th class="text-center">收款狀態</th>
                <th class="text-center">留言</th>
                <th class="text-center">編輯</th>
            <? elseif ($this->is_liqun_food) : ?>
                <th class="text-center">訂單編號</th>
                <th class="text-center">訂單日期</th>
                <th class="text-center">客戶</th>
                <th class="text-center text-nowrap">配送資訊</th>
                <th class="text-center text-nowrap">付款資訊</th>
                <th class="text-center">匯款後五碼</th>
                <th class="text-center">訂單狀態</th>
                <th class="text-center">物流單號</th>
                <th class="text-center">新增全家訂單</th>
                <th class="text-center">產生單號(全家)</th>
                <!-- <th class="text-center">銷售頁面</th>
                <th class="text-center">代言人</th> -->
            <? else : ?>
                <th class="text-center">訂單編號</th>
                <th class="text-center">訂單日期</th>
                <th class="text-center">客戶</th>
                <th class="text-center">配送地址</th>
                <th class="text-center text-nowrap">配送方式</th>
                <th class="text-center text-nowrap">金額/付款方式</th>
                <th class="text-center">匯款後五碼</th>
                <th class="text-center">訂單狀態</th>
                <th class="text-center">銷售頁面</th>
                <th class="text-center">代言人</th>
            <? endif; ?>
        </tr>
    </thead>
    <tbody class="pc_control">
        <? if (!empty($orders)) {
            foreach ($orders as $order) {
                $agentName = $this->agent_model->getAgentName($order['agent_id']); ?>
                <tr class="<?= ($order['order_step'] == 'return_complete' ? 'return_complete_color' : '') ?> <?= ($order['order_step'] == 'returning' ? 'returning_color' : '') ?> <?= ($order['order_step'] == 'preparation' ? 'preparation_color' : '') ?> <?= ($order['order_step'] == 'pay_ok' ? 'pay_ok_color' : '') ?> <?= ($order['order_step'] == 'order_cancel' ? 'order_cancel_color' : '') ?> <?= ($order['order_step'] == 'shipping' ? 'shipping_color' : '') ?> <?= ($order['order_step'] == 'complete' ? 'complete_color' : '') ?> <?= ($order['order_step'] == 'process' ? 'process_color' : '') ?> <?= ($order['order_step'] == 'invalid' ? 'invalid_color' : '') ?>">
                    <td class="text-center">
                        <input type="checkbox" name="selectCheckbox" style="width: 20px;height: 20px;cursor: pointer;" value="<?= $order['order_id'] ?>">
                    </td>
                    <!-- 訂單編號 -->
                    <td class="text-center" style="<?= ($order['order_step'] == 'order_cancel' ? 'text-decoration: line-through;' : '') ?>">
                        <a href="/admin/order/view/<?php echo $order['order_id'] ?>" target="_blank">
                            <?php echo $order['order_number'] ?>
                            <!-- <?php echo $order['order_number'] ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i> -->
                        </a>
                    </td>
                    <!-- 夥伴玩具 -->
                    <? if ($this->is_partnertoys) : ?>
                        <!-- 客戶資訊 -->
                        <td>
                            <span class="spanContent">
                                <span>訂單日期：</span>
                                <span class="spanContentFont"><?= $order['order_date'] ?></span>
                            </span>
                            <span class="spanContent">
                                <span>客戶姓名：</span>
                                <span class="spanContentFont"><?= $order['customer_name'] ?></span>
                            </span>
                            <span class="spanContent">
                                <span>客戶電話：</span>
                                <span class="spanContentFont"><?= $order['customer_phone'] ?></span>
                            </span>
                            <span class="spanContent">
                                <span>客戶Mail：</span>
                                <span class="spanContentFont"><?= $order['customer_email'] ?></span>
                            </span>
                        </td>
                        <!-- 配送資訊 -->
                        <td>
                            <span class="spanContent">
                                <span>配送方式：</span>
                                <span class="spanContentFont"><?= get_delivery($order['order_delivery']) ?></span>
                            </span>
                            <span class="spanContent">
                                <span>配送地址：</span>
                                <span class="spanContentFont"><?= (!empty($order['order_store_name']) ? $order['order_store_name'] : $order['order_delivery_address']) ?></span>
                            </span>
                        </td>
                        <!-- 訂單資訊 -->
                        <td>
                            <span class="spanContent">
                                <span>訂單金額：</span>
                                <span><?= '$' . format_number($order['order_discount_total']) ?></span>
                            </span>
                            <span class="spanContent">
                                <span>付款方式：</span>
                                <span><?= get_payment($order['order_payment']) ?></span>
                            </span>
                            <? if (substr($order['order_payment'], 0, 5) == 'ecpay') : ?>
                                <span class="spanContent">
                                    <span>付款狀態：</span>
                                    <span><?= get_pay_status($order['order_pay_status']) ?></span>
                                </span>
                            <? endif; ?>
                            <? if (!empty($order['invoid'])) : ?>
                                <span class="spanContent">
                                    <span>發票號碼：</span>
                                    <span class="spanContentFont"><?= $order['invoid'] ?></span>
                                </span>
                            <? elseif (!empty($order['InvoiceNumber'])) : ?>
                                <span class="spanContent">
                                    <span>發票號碼：</span>
                                    <span class="spanContentFont"><?= $order['InvoiceNumber'] ?></span>
                                </span>
                            <? endif; ?>
                            <a href="javascript:void(0)" onclick="toggleTermsPopup(<?= $order['order_id'] ?>)">顯示商品清單</a>
                        </td>
                    <? else : ?>
                        <!-- 訂單日期 -->
                        <td class="text-center">
                            <?php echo $order['order_date'] ?>
                        </td>
                        <!-- 客戶資訊 -->
                        <td class="text-center">
                            <?php echo $order['customer_name'] ?>
                        </td>
                        <!-- 配送資訊 -->
                        <td>
                            <span class="spanContent">
                                <span>配送方式：</span>
                                <span class="spanContentFont"><?= get_delivery($order['order_delivery']) ?></span>
                            </span>
                            <span class="spanContent">
                                <span>配送地址：</span>
                                <span class="spanContentFont"><?= (!empty($order['order_store_name']) ? $order['order_store_name'] : $order['order_delivery_address']) ?></span>
                            </span>
                        </td>
                        <!-- 訂單資訊 -->
                        <td>
                            <span class="spanContent">
                                <span>訂單金額：</span>
                                <span class="spanContentFont"><?= '$' . format_number($order['order_discount_total']) ?></span>
                            </span>
                            <span class="spanContent">
                                <span>付款方式：</span>
                                <span class="spanContentFont"><?= get_payment($order['order_payment']) ?></span>
                            </span>
                            <? if (substr($order['order_payment'], 0, 5) == 'ecpay') : ?>
                                <span class="spanContent">
                                    <span>付款狀態：</span>
                                    <span class="spanContentFont"><?= get_pay_status($order['order_pay_status']) ?></span>
                                </span>
                            <? endif; ?>
                            <a href="javascript:void(0)" onclick="toggleTermsPopup(<?= $order['order_id'] ?>)">顯示商品清單</a>
                        </td>
                    <? endif; ?>

                    <!-- 匯款 -->
                    <? if (!$this->is_partnertoys) : ?>
                        <td>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <? $attributes = array('class' => 'form-inline');
                                    echo form_open('admin/order/update_remittance_account/' . $order['order_id'], $attributes); ?>
                                    <input type="text" class="form-control" name="remittance_account" value="<?= $order['remittance_account'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm inTopButton">更新</button>
                                    <? echo form_close() ?>
                                </span>
                            </div>
                        </td>
                    <? endif; ?>

                    <? if ($this->is_partnertoys) : ?>
                        <!-- 處理狀態 -->
                        <td>
                            <select id="order_step_<?= $order['order_id'] ?>pc" onchange="changeStep('<?= $order['order_id'] ?>','pc')" class="form-control">
                                <? foreach ($step_list as $key => $value) {
                                    if ($key != '') { ?>
                                        <option value="<?= $key ?>" <?= ($key == $order['order_step'] ? 'selected' : '') ?>><?= $value ?></option>
                                <? }
                                } ?>
                            </select>
                            <!-- 新增物流單 -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <?php $attributes = array('class' => 'form-inline'); ?>
                                    <?php echo form_open('admin/order/updata_self_payment_no/' . $order['order_id'], $attributes); ?>
                                    <input type="text" class="form-control" name="self_payment_no" placeholder="請輸入貨單號" value="<?php echo $order['CVSPaymentNo'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm inTopButton">更新</button>
                                    <?php echo form_close() ?>
                                </span>
                            </div>
                        </td>
                        <!-- 收款狀態 -->
                        <td>
                            <select id="order_step_<?= $order['order_id'] ?>pc" onchange="changeStep('<?= $order['order_id'] ?>','pc')" class="form-control">
                                <? foreach ($step_list as $key => $value) {
                                    if ($key != '') { ?>
                                        <option value="<?= $key ?>" <?= ($key == $order['order_step'] ? 'selected' : '') ?>><?= $value ?></option>
                                <? }
                                } ?>
                            </select>
                        </td>
                        <!-- 留言數量 -->
                        <td class="text-center">
                            <span><?= $this->order_model->getGuestBookCount($order['order_id']) ?></span>
                        </td>
                        <!-- 編輯按鈕 -->
                        <td class="text-center">
                            <a href="/admin/order/view/<?php echo $order['order_id'] ?>" class="btn btn-default btn-xs" target="_blank">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    <? endif; ?>

                    <?php if ($this->is_liqun_food) : ?>
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
                        <?php if (!empty($order['AllPayLogisticsID'])) : ?>
                            <!-- 自動單號 -->
                            <td class="text-center">
                                <!-- 物流單列印 -->
                                <a href="/fmtoken/fm_<?= $order['fm_type'] ?>_print/<?= ($order['fm_cold'] == 1) ? 'cold' : 'normal' ?>/<?= $order['fm_ecno'] ?>" target="_blank"><?php echo $order['AllPayLogisticsID'] ?></a>
                            </td>
                        <?php else : ?>
                            <!-- 手動單號 -->
                            <td class="text-center">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <?php $attributes = array('class' => 'form-inline'); ?>
                                        <?php echo form_open('admin/order/updata_self_logistics/' . $order['order_id'], $attributes); ?>
                                        <input type="text" class="form-control" name="self_logistics" placeholder="物流單號" value="<?php echo $order['SelfLogistics'] ?>">
                                        <button type="submit" class="btn btn-primary btn-sm inTopButton">更新</button>
                                        <?php echo form_close() ?>
                                    </span>
                                </div>
                            </td>
                        <?php endif; ?>
                        <!-- 新增訂單至全家後台 -->
                        <?php if ($order['order_delivery'] == 'family_pickup' || $order['order_delivery'] == 'family_limit_5_frozen_pickup' || $order['order_delivery'] == 'family_limit_10_frozen_pickup') : ?>
                            <?php if (empty($order['AllPayLogisticsID']) && empty($order['fm_ecno'])) : ?>
                                <td class="text-center">
                                    <?php if ($order['fm_cold'] == 1) : ?>
                                        <select id="orderType" class="form-control">
                                            <option value="fm_add_b2c_order/cold">全家冷凍</option>
                                        </select>
                                        <button class="btn" onClick="fmOrderBtn(<?= $order['order_id'] ?>)">產生訂單</button>
                                    <?php else : ?>
                                        <span>常溫訂單</span>
                                    <?php endif; ?>
                                </td>
                            <?php elseif (!empty($order['fm_ecno'])) : ?>
                                <td class="text-center" style="color:#00aaff">全家冷凍</td>
                            <?php endif; ?>
                        <?php else : ?>
                            <td class="text-center">非全家訂單</td>
                        <?php endif; ?>
                        <!-- 產生單號 -->
                        <?php if (empty($order['AllPayLogisticsID']) && !empty($order['fm_ecno'])) : ?>
                            <td class="text-center">
                                <a class="btn btn-success" href="/fmtoken/fm_<?= $order['fm_type'] ?>_logistic/<?= ($order['fm_cold'] == 1) ? 'cold' : 'normal' ?>/<?= $order['fm_ecno'] ?>">產生</a>
                            </td>
                        <?php else : ?>
                            <td class="text-center"></td>
                        <?php endif; ?>
                    <?php elseif ($this->is_td_stuff) : ?>
                        <td>
                            <select id="order_step_<?= $order['order_id'] ?>pc" onchange="changeStep('<?= $order['order_id'] ?>','pc')" class="form-control">
                                <? foreach ($step_list as $key => $value) {
                                    if ($key != '') { ?>
                                        <option value="<?= $key ?>" <?= ($key == $order['order_step'] ? 'selected' : '') ?>><?= $value ?></option>
                                <? }
                                } ?>
                            </select>
                        </td>
                        <td class='text-center'>
                            <? if ($order['single_sales_id'] != '') { ?>
                                <a href="/admin/sales/editSingleSales/<?= $order['single_sales_id'] ?>" target="_blank">
                                    <?= $order['single_sales_id'] ?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            <? } ?>
                        </td>
                        <td class='text-center'>
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
                        <p>訂單金額：
                            <span style="color:red;font-weight: bold;">
                                <?php echo format_number($order['order_discount_total']) ?>
                            </span>
                        </p>
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

<!-- prodcut view -->
<div id="termsPopupWrapper">
    <div id="termsPopupWrapper">
        <div id="detailOrder" class="mfp-hide">
            <p class="orderNumber">訂單編號：EM12202403180002</p>
            <div class="detailContent">
                <table class="table table-bordered table-striped table-hover table-responsive ">
                    <tbody class="orderItems">
                        <tr>
                            <th>商品編號</th>
                            <th>商品名稱 </th>
                            <th>商品規格</th>
                            <th>數量</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>