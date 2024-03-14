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

    .header_fixed_icon {
        display: none;
    }
</style>

<?php if (empty($order)) : ?>
    <div class="container none-order">
        <p class="text-center">為保護個人資料故無法從此頁面查看或重複確認訂單，若有需求請至會員專區部分查詢敬請見諒。</p>
    </div>
<?php else : ?>
    <div role="main" class="main">
        <section class="form-section content_auto_h">
            <div class="container">
                <div class="checkout-list" style="border: none; box-shadow: none; margin-bottom: 0px;">
                    <div class="row text-center">
                        <div class="col-12">
                            <h1 style="color: red;font-weight: bold;">下單完成！</h1>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                            <h3 class="m-0 pb-2">訂單編號：
                                <?php echo $order['order_number'] ?>
                            </h3>
                            <h3 class="m-0 pb-2">下單時間：
                                <?php echo $order['created_at'] ?>
                            </h3>
                            <h3 class="m-0 pb-2">訂單狀態：
                                <?php echo get_order_step($order['order_step']) ?>
                            </h3>
                            <h3 class="m-0 pb-2">訂單內容</h3>
                            <table class="table table-hover m_table_none m-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col" class="text-nowrap" style="width: 75px;">圖片</th>
                                        <th scope="col" class="text-nowrap">商品</th>
                                    </tr>
                                </thead>
                                <?php $count = 1;
                                $total = 0;
                                if (!empty($order_item)) {
                                    foreach ($order_item as $item) {
                                        if ($item['product_id'] != 0) { ?>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <?php echo $count ?>
                                                    </td>
                                                    <td>
                                                        <? $this->db->select('*');
                                                        $this->db->from('product_combine');
                                                        $this->db->where('id', $item['product_combine_id']);
                                                        $query = $this->db->get();
                                                        foreach ($query->result_array() as $row) {
                                                            echo get_front_image($row['picture']);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <? $i = 0;
                                                            $this->db->select('*');
                                                            $this->db->from('product_combine');
                                                            $this->db->join('product_combine_item', 'product_combine.id = product_combine_item.product_combine_id', 'right');
                                                            $this->db->where('product_combine.id', $item['product_combine_id']);
                                                            $query = $this->db->get();
                                                            foreach ($query->result_array() as $row) {
                                                                // echo $row['id'] . ' ' . $row['product_specification'] . ' ' . $row['product_id'] . '<br>';
                                                                if ($i < 1) {
                                                                    echo get_product_name($row['product_id']) . ' - ' . get_product_combine_name($row['product_combine_id']);
                                                                } ?>
                                                                <ul class="pl-3 m-0" style="color: gray;">
                                                                    <li style="list-style-type: circle;">
                                                                        <? echo $row['qty'] . ' ' . $row['product_unit'];
                                                                        // $total_qty = $row['qty']*$item['order_item_qty'];
                                                                        // echo ' - 共：' . $total_qty . ' ' . $row['product_unit'];
                                                                        if (!empty($row['product_specification'])) {
                                                                            echo ' - ' . $row['product_specification'];
                                                                        }
                                                                        foreach ($order_item as $specification_item) {
                                                                            if ($specification_item['specification_id'] != 0 && $specification_item['order_item_qty'] == 0 && $item['product_combine_id'] == $specification_item['product_combine_id']) {
                                                                                $this->db->select('*');
                                                                                $this->db->from('product_specification');
                                                                                $this->db->where('id', $specification_item['specification_id']);
                                                                                $query_specification = $this->db->get();
                                                                                foreach ($query_specification->result_array() as $row_specification) {
                                                                                    echo '<br>' . '✓ ' . $row_specification['specification'] . ' x ' . $specification_item['specification_qty'];
                                                                                }
                                                                            }
                                                                        } ?>
                                                                    </li>
                                                                </ul>
                                                            <? $i++;
                                                            } ?>
                                                        </div>
                                                        <div>金額：$
                                                            <?php echo number_format($item['order_item_price']) ?>
                                                        </div>
                                                        <div>數量：
                                                            <?php echo $item['order_item_qty'] ?>
                                                        </div>
                                                        <div>小計：<span style="color:#dd0606;">$
                                                                <?php echo number_format($item['order_item_qty'] * $item['order_item_price']) ?></span></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php $count++; ?>
                                            <?php $total += $item['order_item_qty'] * $item['order_item_price']; ?>
                                <?php  }
                                    }
                                } ?>
                            </table>
                            <hr>
                            <?php if ($order['order_discount_price'] != 0) : ?>
                                <span class="front_title">折扣金額：
                                    <span class="money_size">$
                                        <?php echo (int)$order['order_discount_price']; ?>
                                    </span>
                                </span>
                                <hr>
                            <?php endif; ?>
                            <span class="front_title">小計：
                                <span class="money_size">$
                                    <?php echo ((int)$order['order_discount_total'] - (int)$order['order_delivery_cost']); ?>
                                </span>
                            </span>
                            <hr>
                            <?php if (!empty($order['order_delivery'])) : ?>
                                <?php if ($order['order_delivery'] == '711_pickup' || $order['order_delivery'] == 'family_pickup' || $order['order_delivery'] == 'family_limit_5_frozen_pickup' || $order['order_delivery'] == 'family_limit_10_frozen_pickup') : ?>
                                    <h3>取貨方式：
                                        <?php echo get_delivery($order['order_delivery']) ?>
                                    </h3>
                                    <h3>取貨門市：
                                        <?php echo $order['order_store_name']; ?>
                                    </h3>
                                    <?php if ($this->is_partnertoys) : ?>
                                        <h3>取貨地點：
                                            <?php echo $order['order_store_address']; ?>
                                        </h3>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <h3>配送方式：
                                        <?php echo get_delivery($order['order_delivery']) ?>
                                    </h3>
                                    <h3>配送地點：
                                        <?php echo $order['order_delivery_address']; ?>
                                    </h3>
                                <?php endif; ?>
                            <?php endif; ?>
                            <span class="front_title">運費：<span class="money_size"> $
                                    <?php echo format_number($order['order_delivery_cost']) ?></span></span>
                            <hr>
                            <span class="front_title">總計：<span class="money_size" style="color: #F75000;font-size: 28px;"> $
                                    <?php echo format_number($order['order_discount_total']) ?></span></span>
                            <hr>
                            <h3>付款方式：
                                <?php echo get_payment($order['order_payment']) ?>
                            </h3>
                            <!-- <h3>付款狀態：已付款</h3> -->
                            <?php if ($order['order_payment'] == 'bank_transfer') { ?>
                                <!-- <h4 class="fs-16 color-595757 bold">ATM付款資訊</h4> -->
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%;">
                                            <span class="fs-13">銀行代碼</span>
                                        </th>
                                        <td>
                                            <span class="fs-16 color-595757">
                                                <?php echo get_setting_general('atm_bank_code') ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="fs-13">銀行分行</span>
                                        </th>
                                        <td>
                                            <span class="fs-16 color-595757">
                                                <?php echo get_setting_general('atm_bank_branch') ?></span>
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
                                <p style="font-size:18px;">完成付款後，記得聯繫客服，確認付款完成！</p>
                            <?php } ?>
                            <hr>
                            <h3>訂購人資訊</h3>
                            <p>姓名：
                                <?php echo $order['customer_name'] ?>
                            </p>
                            <p>聯絡電話：
                                <?php echo $order['customer_phone'] ?>
                            </p>
                            <p>E-mail：
                                <?php echo $order['customer_email'] ?>
                            </p>
                            <p>地址：
                                <?php echo $order['order_delivery_address'] ?>
                            </p>
                            <hr>
                            <h3>訂單備註</h3>
                            <p style="border: 1px solid gray;border-radius: 5px;margin: 0px;padding: 10px;">
                                <?php if (!empty($order['order_remark'])) {
                                    echo $order['order_remark'];
                                } else {
                                    echo '無填寫訂單備註。';
                                } ?>
                            </p>
                        </div>
                    </div>
                    <div class="row justify-content-center py-5">
                        <div class="col-12 col-md-6 text-center">
                            <div class="row">
                                <? if ($agentID == '') { ?>
                                    <div class="col-12 col-md-6 py-2">
                                        <a href="/auth" class="btn btn-secondary btn-block">查看歷史訂單</a>
                                    </div>
                                <? } ?>
                                <div <?= ($agentID == '' ? 'class="col-12 col-md-6 py-2"' : 'class="col-12 col-md-12 py-2"') ?>>
                                    <a href="<?= get_setting_general('official_line_1') ?>" class="btn btn-info btn-block" target="_blank">聯繫客服 <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                </div>
                                <? if ($this->is_td_stuff) {
                                    if (!empty($users)) {
                                        if ($users['join_status'] == '' || $users['join_status'] == 'NotJoin') { ?>
                                            <div class="col-12 py-2">
                                                <span class="btn btn-success btn-block" data-toggle="modal" data-target="#joinNowMemberModal">一鍵成為會員</span>
                                                <span style="color:red;font-size: 14px;"><?= get_setting_general('join_member_info') ?></span>
                                            </div>
                                <? }
                                    }
                                } ?>
                                <? if ($agentID == '') { ?>
                                    <div class="col-12 py-2">
                                        <a href="/" class="btn btn-primary btn-block">回首頁</a>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="joinNowMemberModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="mb-1 mt-0">快速加入會員</h2>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group pb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">帳號</span>
                                </div>
                                <input type="text" class="form-control" id="account" value="<?= $order['customer_phone'] ?>" readonly>
                            </div>
                            <div>
                                <span style="font-size: 16px;color: red;">※密碼請輸入 8 位(含)以上的數字或英文</span>
                            </div>
                            <div class="input-group pb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">密碼</span>
                                </div>
                                <input type="password" class="form-control" id="password" value="" placeholder="請輸入密碼">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="passwordShowOrHide('password')">
                                        <i class="fa-solid fa-eye" id="password_eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">密碼確認</span>
                                </div>
                                <input type="password" class="form-control" id="password_confirm" value="" placeholder="請輸入密碼確認">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="passwordShowOrHide('password_confirm')">
                                        <i class="fa-solid fa-eye" id="password_confirm_eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-primary" onclick="joinNowMember('<?= encode($order['order_id']) ?>')">註冊</span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    function get_order() {
        var order_status = $('#order_status').val();
        if (order_status == 'not_paid') {
            $("table.paid").fadeOut('fast');
            $("table.picked").fadeOut('fast');
            $("table.not_paid").fadeIn('fast');
        } else if (order_status == 'paid') {
            $("table.not_paid").fadeOut('fast');
            $("table.picked").fadeOut('fast');
            $("table.paid").fadeIn('fast');
        } else if (order_status == 'picked') {
            $("table.not_paid").fadeOut('fast');
            $("table.paid").fadeOut('fast');
            $("table.picked").fadeIn('fast');
        } else {
            $("table.not_paid").fadeIn('fast');
            $("table.paid").fadeIn('fast');
            $("table.picked").fadeIn('fast');
        }
    }

    function passwordShowOrHide(source) {
        if ($('#' + source).attr("type") === "password") {
            $('#' + source).attr("type", "text");
            $('#' + source + '_eye').removeClass("fa-eye");
            $('#' + source + '_eye').addClass("fa-eye-slash");
        } else {
            $('#' + source).attr("type", "password");
            $('#' + source + '_eye').removeClass("fa-eye-slash");
            $('#' + source + '_eye').addClass("fa-eye");
        }
    }

    function joinNowMember(order_id) {
        if ($('#password').val() == '') {
            alert('請輸入密碼！');
            return;
        }
        if ($('#password_confirm').val() == '') {
            alert('請輸入密碼確認！');
            return;
        }
        if ($('#password').val().length < 8) {
            alert('密碼請輸入 8 位(含)以上的數字或英文！');
            return;
        }
        if ($('#password_confirm').val().length < 8) {
            alert('密碼確認請輸入 8 位(含)以上的數字或英文！');
            return;
        }
        if ($('#password').val() != $('#password_confirm').val()) {
            alert('密碼不匹配！請在確認輸入的密碼。');
            return;
        }
        $.ajax({
            url: '/auth/join_user/',
            type: 'POST',
            data: {
                order_id: order_id,
                password: $('#password').val(),
                password_confirm: $('#password_confirm').val(),
            },
            success: function(data) {
                if (data == 'yes') {
                    alert('已註冊完成');
                    location.reload();
                } else {
                    alert('註冊失敗，請聯繫客服。');
                    location.reload();
                }
            }
        });
    }
</script>