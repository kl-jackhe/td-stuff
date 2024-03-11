<?php
$count = 0;
$storeSelete = isset($_GET['logisticsSubType']) ? $_GET['logisticsSubType'] : '';
foreach ($this->cart->contents() as $items) {
    $count++;
} ?>
<style>
    #footer {
        margin-top: 0px;
    }

    #zoomA {
        transition: transform ease-in-out 0s;
    }

    #zoomA:hover {
        transform: scale(1.1);
    }

    .m_padding {
        padding-bottom: 0 !important;
    }

    select.county {
        width: 48% !important;
        float: left;
    }

    select.district {
        width: 48% !important;
        float: left;
        margin-left: 4%;
    }

    input.zipcode {
        width: 33%;
        display: none;
    }

    p {
        margin: 0px;
    }

    .fixed-bottom {
        display: none;
    }

    .wizard>.content {
        /* overflow-y: auto; */
        background: #fff !important;
    }

    .wizard>.actions {
        margin: 70px 0 50px 0;
        text-align: center;
    }

    .wizard>.content>.body {
        width: 100%;
        height: 100%;
    }

    .wizard>.steps .number {
        font-size: 32px;
    }

    .wizard ul,
    .tabcontrol ul {
        text-align: center;
    }

    .wizard>.steps a,
    .wizard>.steps a:hover,
    .wizard>.steps a:active {
        padding: 10px 10px;
        font-size: 20px;
    }

    .wizard>.steps .current a,
    .wizard>.steps .current a:hover,
    .wizard>.steps .current a:active {
        background: none;
        color: #fff;
        cursor: auto;
    }

    .wizard>.steps .disabled a,
    .wizard>.steps .disabled a:hover,
    .wizard>.steps .disabled a:active {
        background: none;
        color: #fff;
        cursor: auto;
    }

    .wizard>.steps .done a,
    .wizard>.steps .done a:hover,
    .wizard>.steps .done a:active {
        background: none;
        color: #fff;
    }

    .wizard>.actions a,
    .wizard>.actions a:hover,
    .wizard>.actions a:active {
        background: rgba(239, 132, 104, 1.0);
        color: #000;
    }

    .wizard>.steps .disabled p {
        background: #cfcdcd;
        color: #807e7e;
    }

    .wizard>.steps .current p {
        background: rgba(239, 132, 104, 1.0);
        color: #252020;
    }

    .wizard>.steps .done p {
        background: rgba(239, 132, 104, 1.0);
        color: #252020;
    }

    .wizard a {
        outline: none;
    }

    .wizard ul li a div p {
        background: #420452;
        border-radius: 50%;
        width: 45px;
    }

    .wizard .steps .row {
        position: relative;
        justify-content: center;
        margin: 0px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .wizard_section_title {
        color: #524431;
    }

    .wizard>.steps>ul>li {
        width: 33.3% !important;
    }

    #wizard {
        margin-bottom: 20px;
    }

    .progress_box {
        background-color: rgba(239, 132, 104, 1.0);
        height: 1.5px;
    }

    .progress_box_bar {
        width: 0%;
        background: rgba(239, 132, 104, 1.0);
    }
</style>
<div role="main" class="main">
    <section class="form-section content_auto_h">
        <?php $attributes = array('id' => 'checkout_form'); ?>
        <?php echo form_open('checkout/save_order', $attributes); ?>
        <div class="container">
            <div class="row justify-content-center" style="padding-left: 25px; padding-right: 25px;position: relative;">
                <div class="stpes" style="width: 60%;position: absolute;top: 52px;">
                    <div class="progress progress_box">
                        <div class="progress-bar progress_box_bar">
                        </div>
                    </div>
                </div>
                <div id="wizard" class="wizard">
                    <h3>購物清單</h3>
                    <section>
                        <h3 style="margin-top: 0px;">您共選擇 (<?= $count ?> 個項目)</h3>
                        <table class="table table-hover m_table_none">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-nowrap" style="width: 100px;">圖片</th>
                                    <th scope="col" class="text-nowrap">商品</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $product_list = array();
                                foreach ($this->cart->contents() as $items) :
                                    $this->db->select('product_category_id');
                                    $this->db->where('product_id', $items['product_id']);
                                    $this->db->limit(1);
                                    $p_row = $this->db->get('product')->row_array();
                                    if (!empty($p_row)) {
                                        $product_list[] = array(
                                            'product_category_id' => $p_row['product_category_id'],
                                            'product_id' => $items['product_id'],
                                            'product_combine_id' => $items['id'],
                                        );
                                    }
                                    $add_disabled = '';
                                    if (!empty($this->product_model->getProductCombine($items["id"]))) {
                                        $self = $this->product_model->getProductCombine($items["id"]);
                                        $is_lottery = $this->mysql_model->_select('lottery', 'product_id', $self['product_id'], 'row');
                                        if (!empty($is_lottery)) {
                                            $add_disabled = 'disabled';
                                        }
                                        $max_qty = ($self['limit_enable'] == 'YES') ? $self['limit_qty'] : '100';
                                    }
                                ?>
                                    <tr style="border-top:1px solid dimgray;">
                                        <td><?= $i ?></td>
                                        <td>
                                            <? if ($agentID == '') { ?>
                                                <a href="product/view/<?= $items['product_id'] ?>">
                                                    <?php $image = get_product_combine($items['id'], 'picture'); ?>
                                                    <?php if ($image != '') { ?>
                                                        <img id="zoomA" style="width: 100%;" src="/assets/uploads/<?php echo $image; ?>" alt="<?php echo $items['name']; ?>">
                                                    <?php } ?>
                                                </a>
                                            <? } else { ?>
                                                <?php $image = get_product_combine($items['id'], 'picture'); ?>
                                                <?php if ($image != '') { ?>
                                                    <img id="zoomA" style="width: 100%;" src="/assets/uploads/<?php echo $image; ?>" alt="<?php echo $items['name']; ?>">
                                                <?php } ?>
                                            <? } ?>
                                        </td>
                                        <td>
                                            <p><?php echo $items['name']; ?></p>
                                            <?php
                                            $this->db->where('product_combine_id', $items['id']);
                                            $query = $this->db->get('product_combine_item');
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result_array() as $item) { ?>
                                                    <p><? echo $item['qty'] . ' ' . $item['product_unit'];
                                                        if (!empty($item['product_specification'])) {
                                                            echo ' - ' . $item['product_specification'];
                                                        }
                                                        if (!empty($items['specification']['specification_id'])) {
                                                            $y = 0;
                                                            $x = 0;
                                                            // $total_qty = $item['qty']*$items['qty'];
                                                            // echo ' - 共：' . $total_qty . ' ' . $item['product_unit'];
                                                            foreach ($items['specification']['specification_qty'] as $row) {
                                                                // if ($items['qty'] > 1) {
                                                                //     $specification_qty[$y] = $row*$items['qty'];
                                                                // } else {
                                                                //     $specification_qty[$y] = $row;
                                                                // }
                                                                $specification_qty[$y] = $row;
                                                                $y++;
                                                            }
                                                            foreach ($items['specification']['specification_name'] as $specification_name) {
                                                                echo '<br>' . '✓ ' . $specification_name . ' x ' . $specification_qty[$x];
                                                                $x++;
                                                            }
                                                        } ?>
                                                    </p><? }
                                                }
                                                        ?>
                                            <p>金額：$ <?php echo $items['price']; ?></p>
                                            <p>
                                                數量：
                                                <span class="input-group-btn inlineBlock">
                                                    <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[<?php echo $items["rowid"] ?>]" data-reword-id="<?php echo $items["rowid"] ?>">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" <?php echo $items["rowid"] ?> name="quant[<?php echo $items["rowid"] ?>]" class="input_border_style inlineBlock qtyInputBox" value="<?php echo $items['qty']; ?>" data-reword-id="<?php echo $items["rowid"] ?>" min='1' max='100' <?= $add_disabled ?>>
                                                <span class="input-group-btn inlineBlock">
                                                    <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-weight="<?= !empty($items['options']['weight']) ? $items['options']['weight'] : 0; ?>" data-field="quant[<?php echo $items["rowid"] ?>]" data-reword-id="<?php echo $items["rowid"] ?>" <?= $add_disabled ?>>
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </span>
                                            </p>
                                            <p>小計：<span style="color: #dd0606">$ <?php echo $items['subtotal']; ?></span></p>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <span style="text-align:right;">購物車小計：
                            <span style="color: #dd0606;font-weight: bold;"> $<?php echo  $this->cart->total() ?></span>
                        </span>
                        <br>
                        <br>
                        <br>
                    </section>
                    <h3>購物資訊</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="form-group row p-3 justify-content-center" style="padding-bottom:50px !important;">
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">姓名</span>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $user_data['name'] ?>" placeholder="範例：王小明" onchange="set_user_data()" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">電話</span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $user_data['phone'] ?>" placeholder="範例：0987654321" onchange="set_user_data()" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Email</span>
                                    </div>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $user_data['email'] ?>" placeholder="範例：test@test.com.tw" onchange="set_user_data()" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">國家</span>
                                    </div>
                                    <select class="form-control" name="Country" id="Country">
                                        <option value="請選擇國家" selected>請選擇國家</option>
                                        <option value="臺灣" <?= ($user_data['Country'] == '臺灣') ? 'selected' : ''; ?>>臺灣</option>
                                        <option value="中國" <?= ($user_data['Country'] == '中國') ? 'selected' : ''; ?>>中國</option>
                                        <option value="香港" <?= ($user_data['Country'] == '香港') ? 'selected' : ''; ?>>香港</option>
                                        <option value="澳門" <?= ($user_data['Country'] == '澳門') ? 'selected' : ''; ?>>澳門</option>
                                        <option value="其它" <?= ($user_data['Country'] == '其它') ? 'selected' : ''; ?>>其它</option>
                                    </select>
                                </div>
                                <!-- zip of taiwan -->
                                <div id="twzipcode" class="input-group mb-3 col-12 col-sm-8 row" style="display: none;">
                                    <div class="mb-2 col-md-4 col-12" data-role="county" data-value="<?= $user_data['county'] ?>"></div>
                                    <div class="mb-2 col-md-4 col-12" data-role="district" data-value="<?= $user_data['district'] ?>"></div>
                                    <div class="mb-2 col-md-4 col-12" data-role="zipcode" data-value="<?= $user_data['zipcode'] ?>"></div>
                                </div>
                                <!-- zip of china -->
                                <div id="cnzipcode" class="input-group mb-3 col-12 col-sm-8 row" style="display: none;">
                                    <div class="mb-2 col-lg-3 col-md-6 col-12" data-role="province"></div>
                                    <div class="mb-2 col-lg-3 col-md-6 col-12" data-role="county"></div>
                                    <div class="mb-2 col-lg-3 col-md-6 col-12" data-role="district"></div>
                                    <div class="mb-2 col-lg-3 col-md-6 col-12" data-role="zipcode"></div>
                                </div>
                                <!-- 指定地點運送地址 -->
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">詳細地址</span>
                                    </div>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="請輸入詳細地址" value="<?php echo $user_data['address'] ?>">
                                </div>
                                <!-- 備註 -->
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">訂單備註</span>
                                    </div>
                                    <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                                </div>
                                <div class="input-group col-12 col-sm-8 mb-3" style="display: <?= ($this->session->userdata('member_join_status') == 'IsJoin' ? 'none' : 'show') ?>;">
                                    <div class="input-group-prepend become_member_quickly" onclick="changeBecomeMemberQuickly()" style="cursor: pointer;">
                                        <span class="input-group-text">
                                            <i class="fa-regular fa-square"></i>
                                            <i class="fa-regular fa-square-check" style="display:none;"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" value="快速成為會員" disabled>
                                </div>
                                <div class="input-group col-12 col-sm-8 mb-3 joinMember" style="display:none;">
                                    <input type="hidden" value="" id="become_member_quickly" name="become_member_quickly">
                                    <div class="input-group pb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">帳號</span>
                                        </div>
                                        <input type="text" class="form-control" id="account" name="account" value="" readonly>
                                    </div>
                                    <div>
                                        <span style="font-size: 16px;color: red;">※密碼請輸入 8 位(含)以上的數字或英文</span>
                                    </div>
                                    <div class="input-group pb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">密碼</span>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="請輸入密碼">
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
                                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="" placeholder="請輸入密碼確認">
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="passwordShowOrHide('password_confirm')">
                                                <i class="fa-solid fa-eye" id="password_confirm_eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid py-3">
                            <div class="row">
                                <div class="col-12">
                                    <!-- <h3 style="margin: 0px;">購物車小計：<span style="font-size:24px;color: #dd0606;">$ <?php echo  $this->cart->total() ?></span></h3> -->
                                    <h3 class="mt-0">總計：<span id="cart_total_view" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <input type="hidden" id="cart_total" name="cart_total" value="<?php echo '$' . $this->cart->total() ?>">
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3 class="mt-0">購物須知</h3>
                                    <textarea class="form-control" cols="30" rows="3" disabled><?= get_setting_general('shopping_notes') ?></textarea>
                                    <!-- <p>1. 目前訂單量較多，預計3-5個工作天內出貨(不含假日)。</p>
                                    <p style="color:#dd0606;">2. 超商取貨者，請務必確認手機號碼是否正確。</p> -->
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3 class="mt-0">運送方式</h3>
                                    <?
                                    $deliveryList = array();
                                    if (!empty($product_list)) {
                                        foreach ($product_list as $pl_row) {
                                            if ($pl_row['product_category_id'] > 0) {
                                                $this->db->select('delivery_id,source,source_id');
                                                $this->db->where('source', 'ProductCategory');
                                                $this->db->where('source_id', $pl_row['product_category_id']);
                                                $drl_query = $this->db->get('delivery_range_list')->result_array();
                                                if (!empty($drl_query)) {
                                                    foreach ($drl_query as $drl_row) {
                                                        $deliveryList[$drl_row['delivery_id']] = 'ProductCategory';
                                                    }
                                                }
                                            }
                                            if ($pl_row['product_id'] > 0) {
                                                $this->db->select('delivery_id,source,source_id');
                                                $this->db->where('source', 'Product');
                                                $this->db->where('source_id', $pl_row['product_id']);
                                                $drl_query = $this->db->get('delivery_range_list')->result_array();
                                                if (!empty($drl_query)) {
                                                    foreach ($drl_query as $drl_row) {
                                                        $deliveryList[$drl_row['delivery_id']] = 'Product';
                                                    }
                                                }
                                            }
                                            if ($pl_row['product_combine_id'] > 0) {
                                                $this->db->select('delivery_id,source,source_id');
                                                $this->db->where('source', 'ProductCombine');
                                                $this->db->where('source_id', $pl_row['product_combine_id']);
                                                $drl_query = $this->db->get('delivery_range_list')->result_array();
                                                if (!empty($drl_query)) {
                                                    foreach ($drl_query as $drl_row) {
                                                        $deliveryList[$drl_row['delivery_id']] = 'ProductCombine';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    // 抓資料庫的物流方式
                                    $this->db->select('delivery_name_code, delivery_name, delivery_info, delivery_type, shipping_cost');
                                    // 暫時先註解code有點意義不明
                                    // if (!empty($deliveryList)) {
                                    //     $deliveryIdList = array();
                                    //     foreach ($deliveryList as $key => $value) {
                                    //         $deliveryIdList[] = $key;
                                    //     }
                                    //     $this->db->where_in('id', $deliveryIdList);
                                    // }

                                    // 開放使用的物流方式
                                    $this->db->where('delivery_status', 1);
                                    $d_query = $this->db->get('delivery')->result_array();

                                    $delivery_count = 0; ?>
                                    <?php if (!empty($d_query)) : ?>
                                        <div id="taiwanDeliveryOptions">
                                            <?php foreach ($d_query as $d_row) : ?>
                                                <?php if ($d_row['delivery_type'] != 3) : ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="checkout_delivery" id="checkout_delivery<?= $delivery_count ?>" data-shipping-fee="<?= $d_row['shipping_cost'] ?>" value="<?= $d_row['delivery_name_code']; ?>">
                                                        <label class="form-check-label" for="checkout_delivery<?= $d_row['delivery_name_code']; ?>">
                                                            <?= $d_row['delivery_name'] ?>
                                                        </label>
                                                        <? if (!empty($d_row['delivery_info'])) { ?>
                                                            <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $d_row['delivery_info']; ?></p>
                                                        <? } ?>
                                                    </div>
                                                    <br>
                                                <?php endif; ?>
                                                <?php $delivery_count++; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div id="othersDeliveryOptions">
                                            <?php foreach ($d_query as $d_row) : ?>
                                                <?php if ($d_row['delivery_type'] == 3) : ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="checkout_delivery" id="checkout_delivery<?= $delivery_count ?>" data-shipping-fee="<?= $d_row['shipping_cost'] ?>" value="<?= $d_row['delivery_name_code']; ?>">
                                                        <label class="form-check-label" for="checkout_delivery<?= $d_row['delivery_name_code']; ?>">
                                                            <?= $d_row['delivery_name'] ?>
                                                        </label>
                                                        <? if (!empty($d_row['delivery_info'])) { ?>
                                                            <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $d_row['delivery_info']; ?></p>
                                                        <? } ?>
                                                    </div>
                                                    <br>
                                                <?php endif; ?>
                                                <?php $delivery_count++; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3 class="mt-0">付款方式</h3>
                                    <?php $payment_count = 0; ?>
                                    <?php if (!empty($ECPay_status) && !empty($close_count)) : ?>
                                        <div id="paymentSelected">
                                            <?php foreach ($payment as $row) : ?>
                                                <?php if ($row['payment_status'] == 0) : ?>
                                                    <?php $payment_count++; ?>
                                                <?php endif; ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="checkout_payment" id="checkout_payment<?= $payment_count ?>" value="<?= $row['payment_code']; ?>">
                                                    <label class="form-check-label" for="checkout_payment<?= $row['payment_code']; ?>">
                                                        <?= $row['payment_name'] ?>
                                                    </label>
                                                    <? if (!empty($row['payment_info'])) { ?>
                                                        <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $row['payment_info']; ?></p>
                                                    <? } ?>
                                                </div>
                                                <?php $payment_count++; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php elseif (empty($ECPay_status) || empty($close_count)) : ?>
                                        <span style="color:#dd0606;">尚無付款方式。請聯繫客服。</span>
                                    <?php endif; ?>
                                </div>
                                <div class="row col-12 supermarket">
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <h3 class="mt-0 col-12">超商門市選擇</h3>
                                    <!-- 超商取貨地址 -->
                                    <div class="input-group mb-3 col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">門市編號</span>
                                        </div>
                                        <input type="text" class="form-control" name="storeid" id="storeid" value="<?php echo $this->input->get('storeid') ?>" placeholder="門市編號" readonly>
                                    </div>
                                    <div class="input-group mb-3 col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">取貨門市</span>
                                        </div>
                                        <input type="text" class="form-control" name="storename" id="storename" value="<?php echo $this->input->get('storename') ?>" placeholder="門市名稱" readonly>
                                    </div>
                                    <div class="input-group mb-3 col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">門市地址</span>
                                        </div>
                                        <input type="text" class="form-control" name="storeaddress" id="storeaddress" value="<?php echo $this->input->get('storeaddress') ?>" placeholder="門市地址" readonly>
                                    </div>
                                    <div class="input-group mb-3 col-sm-12 col-md-12 col-lg-6">
                                        <div style="width: 100%;">
                                            <span class="btn btn-primary" onclick="locationToCvsMap();">選擇門市</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3 class="mt-0">運費：<span id="shipping_fee" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <h3 class="mt-0">總計：<span id="total_amount_view" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <!-- <h3 class="mt-0">總計：<span style="font-size:24px;color: #dd0606;">$ <?php echo  $this->cart->total() ?></span></h3> -->
                                    <input type="hidden" id="shipping_amount" name="shipping_amount" value="">
                                    <input type="hidden" id="total_amount" name="total_amount" value="">
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>送出訂單</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="row p-3 justify-content-center">
                                <div class="col-12">
                                    <span class="confirm_info" style="font-size: 18px;"></span>
                                </div>
                                <div class="col-12 py-3" id="NotesOnBankRemittance">
                                    <p>＊銀行匯款＊<br>注意事項：完成付款後，記得聯繫客服，確認付款完成！</p>
                                    <? if (get_setting_general('official_line_1') != '') { ?>
                                        Line客服連結：
                                        <a href="<?= get_setting_general('official_line_1') ?>" target="_blank" style="text-decoration-line: underline;">
                                            <?= get_setting_general('official_line_1') ?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
                                        </a>
                                    <? } ?>
                                </div>
                                <!-- <div class="col-12 py-5">
                                    <p>服務條款： 按一下按鈕送出訂單，即表示您確認已詳閱隱私政策，並且同意 龍寶嚴選 的<a href="./PrivacyPolicy.html" target="_blank">使用條款</a>。</p>
                                </div> -->
                                <div class="col-6 my-5">
                                    <span onclick="form_check()" class="btn btn-primary w-100">下單購買</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <? if ($this->session->userdata('single_sales_url') != '') { ?>
                    <div class="mb-4">
                        <a href="<?= $this->session->userdata('single_sales_url') ?>" class="btn btn-info">繼續購物</a>
                    </div>
                <? } ?>
            </div>
        </div>
        <?php echo form_close() ?>
    </section>
</div>
<!-- purchase-steps -->
<script src="/assets/jquery.steps-1.1.0/jquery.steps.min.js"></script>
<!-- 手填購物車 -->
<script>
    $(document).ready(function() {
        // 监听输入框的 input 事件
        $(".qtyInputBox").on("change", function() {
            // 获取输入框的值
            var qty = $(this).val();

            // 检查输入值是否为数字
            if ($.isNumeric(qty)) {
                // 获取数据重奖的 ID
                var rewordId = $(this).data("reword-id");

                // 发送 AJAX 请求来更新数量
                $.ajax({
                    url: "/cart/update_qty",
                    method: "POST",
                    data: {
                        rowid: rewordId,
                        qty: qty
                    },
                    success: function(response) {
                        // 更新小计显示
                        // var subtotal = parseInt(response); // 假设服务器返回的是正确的小计值
                        // $('#subtotal_' + rewordId).text('$ ' + subtotal);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // 在错误时执行的操作
                        console.error("Error updating quantity: " + error);
                    }
                });
            } else {
                // 如果输入值不是数字，则执行相应的操作（可根据需求处理）
                console.log("Invalid quantity value");
            }
        });
    });
</script>
<!-- 增減購物車 -->
<script>
    $(document).ready(function() {
        $('.btn-number').click(function(e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            reword_id = $(this).attr('data-reword-id');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            // console.log(currentVal);
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    } else if (parseInt(input.val()) == input.attr('min')) {
                        const delect = confirm("貼心提醒，是否指定商品將從購物車清除。");
                        if (delect) {
                            var rowid = reword_id;
                            $.ajax({
                                url: "/cart/remove",
                                method: "POST",
                                data: {
                                    rowid: rowid
                                },
                                success: function(response) {
                                    // 更新小计显示
                                    // var subtotal = parseInt(response); // 假设服务器返回的是正确的小计值
                                    // $('#subtotal_' + rowid).text('$ ' + subtotal);
                                    location.reload();
                                }
                            });
                        } else {
                            return;
                        }
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    } else if (parseInt(input.val()) == input.attr('max')) {
                        alert('已達商品限制最大數量，敬請見諒。');
                        $(this).attr('disabled', true);
                    }
                }
                var rowid = reword_id;
                $.ajax({
                    url: "/cart/update_qty",
                    method: "POST",
                    data: {
                        rowid: rowid,
                        qty: input.val()
                    },
                    success: function(response) {
                        // 更新小计显示
                        // var subtotal = parseInt(response); // 假设服务器返回的是正确的小计值
                        // $('#subtotal_' + rowid).text('$ ' + subtotal);
                        location.reload();
                    }
                });
            } else {
                input.val(0);
            }
        });
    });
</script>
<!-- compute cart -->
<script>
    $(document).ready(function() {
        // 初始化購物車總計
        var cart_amount = 0;
        var shipping_amount = 0;
        var initialCartTotal = parseFloat(<?php echo $this->cart->total() ?>);
        cart_amount = parseInt(initialCartTotal);
        $('#cart_total').val(cart_amount)
        $('#cart_total_view').text(' $' + cart_amount)

        // 初始化選所選運送方式
        var initialShippingFee = 0;
        shipping_amount = parseInt(initialShippingFee);
        $('#shipping_fee').text(' $' + shipping_amount);
        $('#shipping_amount').val(initialShippingFee)
        $('#total_amount').val(cart_amount + shipping_amount)
        $('#total_amount_view').text(' $' + (cart_amount + shipping_amount));

        // 更改運送方式
        $('input[name="checkout_delivery"]').change(function() {
            var shippingFee = $(this).data('shipping-fee');

            // 当选择框改变时的逻辑
            $('#shipping_fee').text(' $' + shippingFee);
            shipping_amount = parseInt(shippingFee);
            $('#shipping_amount').val(shipping_amount);
            $('#total_amount').val(cart_amount + shipping_amount)
            $('#total_amount_view').text(' $' + (cart_amount + shipping_amount));
        });
    });
</script>
<script>
    $(document).on('change', '#Country', function() {
        var selectedCountry = $(this).val();
        var taiwanDeliveryOptions = $('#taiwanDeliveryOptions');
        var othersDeliveryOptions = $('#othersDeliveryOptions');
        var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
        var initialShippingFee = 0;
        $('#shipping_fee').text(' $' + initialShippingFee);
        $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
        $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));

        if (selectedCountry === '臺灣') {
            taiwanDeliveryOptions.show();
            othersDeliveryOptions.hide();
        } else {
            taiwanDeliveryOptions.hide();
            othersDeliveryOptions.show();
        }
    });
    $(document).ready(function() {
        // 監聽 #Country 元素的變化事件
        $('#Country', '#checkout_form').on('change', function() {
            handleDynamicChanges();
        });

        // 監聽 delivery 元素的變化事件
        $('input[name=checkout_delivery]', '#checkout_form').on('change', function() {
            handleDynamicChanges();
        });

        // 初始處理
        handleDynamicChanges();

        // 定義處理動態變化的函數
        function handleDynamicChanges() {
            var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val();
            var County = $('#Country', '#checkout_form').val();
            // console.log("Country:", County);
            // console.log("Delivery:", delivery);

            // 根據新的 #Country 和 delivery 值執行相應的邏輯
            if (County == '臺灣' && (delivery == '711_pickup' || delivery == 'family_pickup')) {
                $('.supermarket').show();
            } else {
                $('.supermarket').hide();
                // $('#storeid').val(''); // 清空 storeid 的值
                // $('#storename').val(''); // 清空 storename 的值
                // $('#storeaddress').val(''); // 清空 storeaddress 的值
            }
        }
    });

    $("#wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        // enableFinishButton: false,
        saveState: true,
        <?php if ($this->input->get('step') != '') {
            echo 'startIndex: ' . $this->input->get('step') . ',';
        } ?>
        onStepChanged: function(event, currentIndex, priorIndex) {
            if (currentIndex == 0) {
                $('.progress_box_bar').css('width', '0%');
            }
            if (currentIndex == 1) {
                $('.progress_box_bar').css('width', '50%');
            }
            if (currentIndex == 2) {
                $('.progress_box_bar').css('width', '100%');
            }
        },
        titleTemplate: '<div class="number row"><i></i><p>#index#</p></div><span class="wizard_section_title">#title#</span>',
        labels: {
            cancel: "取消",
            current: "current step:",
            pagination: "Pagination",
            finish: "下單購買",
            next: "下一步",
            previous: "上一步",
            loading: "載入中..."
        },
        // autoFocus: true
        onStepChanging: function(event, currentIndex, newIndex) {
            $('#phone').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                inputValue = inputValue.slice(0, 10);
                $(this).val(inputValue);
            });
            var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val();
            var payment = $('input[name=checkout_payment]:checked', '#checkout_form').val();
            // console.log(currentIndex)
            // console.log(event)
            // console.log(newIndex)
            // console.log(delivery);



            // step 2.
            if (newIndex === 2) {
                // var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val();
                // var payment = $('input[name=checkout_payment]:checked', '#checkout_form').val();
                if ($('#name').val() == '') {
                    alert('請輸入收件姓名');
                    return false;
                }
                if ($('#phone').val().length < 10) {
                    alert('請輸入完整的收件電話');
                    return false;
                }
                if ($('#email').val() == '') {
                    alert('請輸入完整的電子郵件');
                    return false;
                }
                if ($('#Country').val() == '請選擇國家') {
                    alert('請選擇所在國家');
                    return false;
                } else if ($('#Country').val() == '臺灣') {
                    var countySelect = $("#twzipcode select[name='tw_county']").val();
                    var districtSelect = $("#twzipcode select[name='tw_district']").val();

                    // 檢查所在縣市
                    if (countySelect == '') {
                        alert('請選擇所在縣市');
                        return false;
                    }

                    // 檢查所在鄉鎮市區
                    if (districtSelect == '') {
                        alert('請選擇所在鄉鎮市區');
                        return false;
                    }
                } else if ($('#Country').val() == '中國') {
                    var provinceSelect = $("#cnzipcode select[name='cn_province']").val();
                    var countySelect = $("#cnzipcode select[name='cn_county']").val();
                    var districtSelect = $("#cnzipcode select[name='cn_district']").val();

                    // 檢查所在省份
                    if (provinceSelect == '') {
                        alert('請選擇所在省份');
                        return false;
                    }

                    // 檢查所在縣市
                    if (countySelect == '') {
                        alert('請選擇所在縣市');
                        return false;
                    }

                    // 檢查所在鄉鎮市區
                    if (districtSelect == '') {
                        alert('請選擇所在鄉鎮市區');
                        return false;
                    }
                }
                if ($('#address').val() == '') {
                    alert('請輸入詳細地址');
                    return false;
                }
                if (payment != 'bank_transfer') {
                    $('#NotesOnBankRemittance').hide();
                } else {
                    $('#NotesOnBankRemittance').show();
                }
                if ($('#become_member_quickly').val() == 'yes') {
                    if ($('#password').val() == '') {
                        alert('請輸入密碼！');
                        return false;
                    }
                    if ($('#password_confirm').val() == '') {
                        alert('請輸入密碼確認！');
                        return false;
                    }
                    if ($('#password').val().length < 8) {
                        alert('密碼請輸入 8 位(含)以上的數字或英文！');
                        return false;
                    }
                    if ($('#password_confirm').val().length < 8) {
                        alert('密碼確認請輸入 8 位(含)以上的數字或英文！');
                        return false;
                    }
                    if ($('#password').val() != $('#password_confirm').val()) {
                        alert('密碼不匹配！請在確認輸入的密碼。');
                        return false;
                    }
                }
                if (delivery == '' || delivery == null || ($('#Country').val() == '臺灣' && delivery == 'sf_express_delivery') || (($('#Country').val() != '臺灣') && delivery != 'sf_express_delivery')) {
                    alert('請選擇運送方式');
                    return false;
                }
                if (payment == '' || payment == null) {
                    alert('請選擇付款方式');
                    return false;
                }
                if ($('#Country').val() == '臺灣' && (delivery == '711_pickup' || delivery == 'family_pickup')) {
                    if ($('#storeid').val() == '' || $('#storename').val() == '' || $('#storeaddress').val() == '') {
                        alert('請選擇取貨門市');
                        return false;
                    }
                }
            }
            checkConfirmInfo();
            return true;
        },
        onFinishing: function(event, currentIndex) {
            form_check();
            return true;
        }
    });

    function checkConfirmInfo() {
        var selectedCheckoutDelivery = $('input[name="checkout_delivery"]:checked').val();
        var checkoutDeliveryLabel = $('label[for="checkout_delivery' + selectedCheckoutDelivery + '"]').text();
        var selectedCheckoutPayment = $('input[name="checkout_payment"]:checked').val();
        var checkoutPaymentLabel = $('label[for="checkout_payment' + selectedCheckoutPayment + '"]').text();
        var data = '';
        data += '<table class="table table-bordered table-striped"><tbody>';
        data += '<tr><td class="text-center" colspan="3"><h2 class="m-0">訂購資訊確認</h2></td></tr>';
        if ($('#name').val() != '') {
            data += '<tr><td>姓名</td><td>' + $('#name').val() + '</td></tr>';
        }
        if ($('#phone').val() != '') {
            data += '<tr><td>電話</td><td>' + $('#phone').val() + '</td></tr>';
        }
        if ($('#email').val() != '') {
            data += '<tr><td>信箱</td><td>' + $('#email').val() + '</td></tr>';
        }
        if (selectedCheckoutDelivery != '711_pickup' && selectedCheckoutDelivery != 'family_pickup') {
            if ($('#Country').val() != '') {
                data += '<tr><td>國家</td><td>' + $('#Country').val() + '</td></tr>';
            }
            if ($('#Country').val() == '臺灣') {
                if ($("#twzipcode select[name='tw_county']").val() != '') {
                    data += '<tr><td>縣市</td><td>' + $("#twzipcode select[name='tw_county']").val() + '</td></tr>';
                }
                if ($("#twzipcode select[name='tw_district']").val() != '') {
                    data += '<tr><td>鄉鎮市區</td><td>' + $("#twzipcode select[name='tw_district']").val() + '</td></tr>';
                }
                if ($("#twzipcode input[name='tw_zipcode']").val() != '') {
                    data += '<tr><td>郵遞區號</td><td>' + $("#twzipcode input[name='tw_zipcode']").val() + '</td></tr>';
                }
            } else if ($('#Country').val() == '中國') {
                if ($("#cnzipcode select[name='cn_province']").val() != '') {
                    data += '<tr><td>省分</td><td>' + $("#cnzipcode select[name='cn_province']").val() + '</td></tr>';
                }
                if ($("#cnzipcode select[name='cn_county']").val() != '') {
                    data += '<tr><td>縣市</td><td>' + $("#cnzipcode select[name='cn_county']").val() + '</td></tr>';
                }
                if ($("#cnzipcode select[name='cn_district']").val() != '') {
                    data += '<tr><td>鄉鎮市區</td><td>' + $("#cnzipcode select[name='cn_district']").val() + '</td></tr>';
                }
                if ($("#cnzipcode input[name='cn_zipcode']").val() != '') {
                    data += '<tr><td>郵遞區號</td><td>' + $("#cnzipcode input[name='cn_zipcode']").val() + '</td></tr>';
                }
            }

            if ($('#address').val() != '') {
                data += '<tr><td>詳細地址</td><td>' + $('#address').val() + '</td></tr>';
            }
        }
        if (selectedCheckoutDelivery == '711_pickup' || selectedCheckoutDelivery == 'family_pickup') {
            if ($('#storeid').val() != '') {
                data += '<tr><td>門市編號</td><td>' + $('#storeid').val() + '</td></tr>';
            }
            if ($('#storename').val() != '') {
                data += '<tr><td>取件門市</td><td>' + $('#storename').val() + '</td></tr>';
            }
            if ($('#storeaddress').val() != '') {
                data += '<tr><td>取件地址</td><td>' + $('#storeaddress').val() + '</td></tr>';
            }
        }
        data += '<tr><td>訂單備註</td><td>' + $('#remark').val() + '</td></tr>';
        data += '<tr><td>運送方式</td><td>' + checkoutDeliveryLabel + '</td></tr>';
        data += '<tr><td>付款方式</td><td>' + checkoutPaymentLabel + '</td></tr>';
        // if ($('#xxxxx').val() != '') {
        //     data += '<tr><td>運費</td><td>'+$('#xxxxx').val()+'</td></tr>';
        // }
        if ($('#cart_total').val() != '') {
            data += '<tr><td>購物車小計</td><td>$' + $('#cart_total').val() + '</td></tr>';
        }
        if ($('#shipping_amount').val() != '') {
            data += '<tr><td>運費</td><td>$' + $('#shipping_amount').val() + '</td></tr>';
        }
        if ($('#total_amount').val() != '') {
            data += '<tr><td>總計</td><td style="color:red;font-size:20px">$' + $('#total_amount').val() + '</td></tr>';
        }
        data += "</tbody></table>";
        $(".confirm_info").html(data);
    }
</script>
<!-- purchase-steps -->
<script src="/assets/twzipcode/jquery.twzipcode.min.js"></script>
<script src="/assets/jQuery-cn-zipcode-master/jquery-cn-zipcode.min.js"></script>
<script>
    // twzipcode
    $(document).ready(function() {
        // 初始化 twzipcode
        $("#twzipcode").twzipcode();
        if ($("#Country").val() === '臺灣') {
            $("#twzipcode").show();
            var taiwanDeliveryOptions = $('#taiwanDeliveryOptions');
            var othersDeliveryOptions = $('#othersDeliveryOptions');
            var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
            var initialShippingFee = 0;
            $('#shipping_fee').text(' $' + initialShippingFee);
            $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
            $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));

            taiwanDeliveryOptions.show();
            othersDeliveryOptions.hide();
        }

        $("#Country").change(function() {
            if ($(this).val() === '臺灣') {
                $("#twzipcode").show();
            } else {
                $("#twzipcode").hide();
            }
        });

        // 禁用郵遞區號的輸入框
        $("[name='tw_zipcode']").prop('readonly', true);

        // 選擇縣市、鄉鎮市區下拉選單
        var countySelect = $("select[name='tw_county']");
        var districtSelect = $("select[name='tw_district']");
        var zipcodeInput = $("input[name='tw_zipcode']");

        if (countySelect.length > 0) {
            countySelect.addClass('form-control');
        }

        if (districtSelect.length > 0) {
            districtSelect.addClass('form-control');
        }

        if (zipcodeInput.length > 0) {
            zipcodeInput.addClass('form-control');
        }
    });
    // cnzipcode
    $(document).ready(function() {
        // 初始化 cnzipcode
        $("#cnzipcode").cnzipcode({
            provinceDefault: '<?= $user_data['province'] ?>',
            countyDefault: '<?= $user_data['county'] ?>',
            districtDefault: '<?= $user_data['district'] ?>',
            zipcodeDefault: '<?= $user_data['zipcode'] ?>'
        });
        if ($("#Country").val() === '中國') {
            $("#cnzipcode").show();
            var taiwanDeliveryOptions = $('#taiwanDeliveryOptions');
            var othersDeliveryOptions = $('#othersDeliveryOptions');
            var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
            var initialShippingFee = 0;
            $('#shipping_fee').text(' $' + initialShippingFee);
            $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
            $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));

            taiwanDeliveryOptions.hide();
            othersDeliveryOptions.show();
        }

        $("#Country").change(function() {
            if ($(this).val() === '中國') {
                $("#cnzipcode").show();

            } else {
                $("#cnzipcode").hide();
            }
        });

        // 禁用郵遞區號的輸入框
        $("[name='cn_zipcode']").prop('readonly', true);

        // 選擇縣市、鄉鎮市區下拉選單
        var provinceSelect = $("select[name='cn_province']");
        var countySelect = $("select[name='cn_county']");
        var districtSelect = $("select[name='cn_district']");
        var zipcodeInput = $("input[name='cn_zipcode']");

        if (provinceSelect.length > 0) {
            provinceSelect.addClass('form-control');
        }

        if (countySelect.length > 0) {
            countySelect.addClass('form-control');
        }

        if (districtSelect.length > 0) {
            districtSelect.addClass('form-control');
        }

        if (zipcodeInput.length > 0) {
            zipcodeInput.addClass('form-control');
            // 設定 input 的 placeholder
            zipcodeInput.attr('placeholder', '邮政编码');
        }
    });
</script>
<!-- gomi rejust -->
<script>
    $(document).ready(function() {
        $('#account').val('');
        $('#password').val('');
        $('#password_confirm').val('');
        $(".confirm_info").html('');
        $('#phone').on('input', function() {
            var inputValue = $(this).val();
            inputValue = inputValue.replace(/\D/g, '');
            inputValue = inputValue.slice(0, 10);
            $(this).val(inputValue);
        });
        document.getElementById("phone").onchange = function() {
            $('#account').val($('#phone').val());
        };
        $(function() {
            var h = $(window).height();
            var header_h = $("#header").height();
            var footer_h = $("#footer").height();
            var content_auto_h = $(".content_auto_h").height();
            // alert(content_auto_h);
            // alert(h);
            var main_h = $(".main").height();
            var h_sum = h - header_h - footer_h;
            var h_checkout = h_sum * 1.6;
            if (h_sum >= content_auto_h) {
                $(".content_auto_h").css('height', h_sum * 1.2);
            } else {
                $(".content_auto_h").css('height', '100%');
            }
            // $(".wizard > .content").css('min-height', 'vh');
        });
        // 計算並設置最小高度
        function setMinHeight() {
            var windowHeight = $(window).height(); // 瀏覽器窗口的高度
            var contentHeight = $(".wizard > .content").outerHeight(); // 內容的實際高度，包括padding和邊框

            // 如果內容高度小於窗口高度，將最小高度設置為窗口高度
            // 否則，將最小高度設置為內容高度
            var minHeight = contentHeight < windowHeight ? windowHeight : contentHeight;

            // 將最小高度應用到 .wizard > .content 上
            $(".wizard > .content").css('min-height', minHeight + 'px');
        }

        // 窗口大小變化時重新計算最小高度
        $(window).resize(function() {
            setMinHeight();
        });

        // 初始化時設置最小高度
        setMinHeight();
    });

    // 地圖
    function locationToCvsMap() {
        set_user_data();
        // checked radio val
        var selectedDelivery = $("input[name='checkout_delivery']:checked").val();
        // 手機版cookie存取checked radio val
        document.cookie = "selectedDelivery=" + selectedDelivery;
        // 是否為手機
        var isMobile = <?php echo json_encode(wp_is_mobile()) ?>;
        // 串至綠界地圖
        var route = '<?php echo base_url(); ?>checkout/cvsmap?checkout=' + selectedDelivery + '';
        if (isMobile) {
            // 導入串綠界地圖並給cvsmap判斷是否為mobile
            window.open(route, "選擇門市");
            // window.location.href = (route + '&device=mobile');
        } else {
            // 開新視窗串綠界地圖cvsmap
            window.open(route, "選擇門市", "width=1024,height=768");
        }
    }

    // 解析 URL 中的參數
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    // // 獲取 checkout_delivery 的值
    // var selectedDeliveryValue = getParameterByName('checkout');

    // // 如果值為 'family_pickup'，則設定相應的 radio 按鈕為選中狀態
    // if (selectedDeliveryValue == '711_pickup' || selectedDeliveryValue == 'family_pickup') {
    //     $('.supermarket').show();
    // } else {
    //     $('.supermarket').hide();
    // }
    // if (selectedDeliveryValue === '711_pickup') {
    //     $("input[name='checkout_delivery'][value='711_pickup']").prop('checked', true);
    // } else if (selectedDeliveryValue === 'family_pickup') {
    //     $("input[name='checkout_delivery'][value='family_pickup']").prop('checked', true);
    // }

    function set_store_info(storeid = '', storename = '', storeaddress = '') {
        $("#storeid").val(storeid);
        $("#storename").val(storename);
        $("#storeaddress").val(storeaddress);
    }

    function set_user_data() {
        $.ajax({
            url: "/checkout/set_user_data",
            method: "POST",
            data: {
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val()
            },
            success: function(data) {
                //
            }
        });
    }

    function form_check() {
        var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val();
        if ($('#name').val() == '') {
            alert('請輸入收件姓名');
            return false;
        }
        if ($('#phone').val().length < 10) {
            alert('請輸入完整的收件電話');
            return false;
        }
        if ($('#email').val() == '') {
            alert('請輸入完整的電子郵件');
            return false;
        }
        if (delivery == '711_pickup_frozen') {
            if ($('#storename').val() == '' || $('#storeaddress').val() == '') {
                alert('請選擇取貨門市');
                return false;
            }
        }
        $('#checkout_form').submit();
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

    function changeBecomeMemberQuickly() {
        if ($('#phone').val().length < 10) {
            if ($('#become_member_quickly').val() == 'yes') {
                $('#become_member_quickly').val('');
                $('.become_member_quickly .fa-square-check').hide();
                $('.become_member_quickly .fa-square').show();
                $('.joinMember').css('display', 'none');
                $('#account').val('');
                $('#password').val('');
                $('#password_confirm').val('');
                return false;
            }
            alert('請輸入完整的收件電話');
            return false;
        }
        if ($('#become_member_quickly').val() == 'yes') {
            $('#become_member_quickly').val('');
            $('.become_member_quickly .fa-square-check').hide();
            $('.become_member_quickly .fa-square').show();
        } else {
            $('#become_member_quickly').val('yes');
            $('.become_member_quickly .fa-square-check').show();
            $('.become_member_quickly .fa-square').hide();
        }
        if ($('#become_member_quickly').val() == 'yes') {
            $('#account').val($('#phone').val());
            $('.joinMember').css('display', 'block');
        } else {
            $('.joinMember').css('display', 'none');
            $('#account').val('');
            $('#password').val('');
            $('#password_confirm').val('');
        }
    }
</script>