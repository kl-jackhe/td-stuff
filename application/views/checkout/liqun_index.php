<?php
$count = 0;
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
        overflow-y: auto;
        min-height: 650px !important;
    }

    .wizard>.actions {
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
        <? if ($this->is_td_stuff) { ?>background: #420452;
        <? } ?><? if ($this->is_liqun_food) { ?>background: #f6d523;
        color: #000;
        <? } ?>
    }

    .wizard>.steps .disabled p {
        <? if ($this->is_td_stuff) { ?>background: #B5ABB6;
        <? } ?><? if ($this->is_liqun_food) { ?>background: #cfcdcd;
        color: #807e7e;
        <? } ?>
    }

    .wizard>.steps .current p {
        <? if ($this->is_td_stuff) { ?>background: #420452;
        <? } ?><? if ($this->is_liqun_food) { ?>background: #f6d523;
        color: #252020;
        <? } ?>
    }

    .wizard>.steps .done p {
        <? if ($this->is_td_stuff) { ?>background: #420452;
        <? } ?><? if ($this->is_liqun_food) { ?>background: #f6d523;
        color: #252020;
        <? } ?>
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

    #wizard {
        margin-bottom: 20px;
    }

    .progress_box {
        <? if ($this->is_td_stuff) { ?>background-color: #B5ABB6;
        <? } ?><? if ($this->is_liqun_food) { ?>background-color: #cfcdcd;
        <? } ?>height: 1.5px;
    }

    .progress_box_bar {
        width: 0%;
        <? if ($this->is_td_stuff) { ?>background: #420452;
        <? } ?><? if ($this->is_liqun_food) { ?>background: #f6d523;
        <? } ?>
    }

    @media (max-width: 767.98px) {
        .wizard>.content {
            overflow-y: auto;
            min-height: 600px !important;
        }
    }
</style>
<div role="main" class="main">
    <section class="form-section content_auto_h">
        <?php $attributes = array('id' => 'checkout_form'); ?>
        <?php echo form_open('checkout/save_order', $attributes); ?>
        <div class="container">
            <div class="row justify-content-center" style="padding-left: 25px; padding-right: 25px;position: relative;">
                <div class="stpes" style="width: 70%;position: absolute;top: 52px;">
                    <div class="progress progress_box">
                        <div class="progress-bar progress_box_bar">
                        </div>
                    </div>
                </div>
                <div id="wizard" class="wizard">
                    <h3>確認訂單</h3>
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
                                            <p>數量：<?php echo $items['qty']; ?></p>
                                            <p>小計：<span style="color: #dd0606">$ <?php echo $items['subtotal']; ?></span></p>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <?php if (!empty($coupon)) : ?>
                            <div class="col-12 row">
                                <h4 class="col-12 promotion-title">可使用之優惠券<span style="color: red;">(點選後反白即已選用)</span></h4>
                                <?php foreach ($coupon as $self) : ?>
                                    <?php if (($self['use_limit_enable'] == 1 && (int)$self['use_limit_number'] > 0) || $self['use_limit_enable'] == 0) : ?>
                                        <?php if ($self['type'] == 'free_shipping') : ?>
                                            <!-- 免運費 -->
                                            <?php if (empty($self['use_type_name']) || (($self['use_type_name'] == 'qty' || $self['use_type_name'] == 'price') && $this->cart->total() >= $self['use_type_number'])) : ?>
                                                <div class="col-12 row couponContent">
                                                    <div class="col-md-12 col-lg-3 couponTitle">
                                                        <span class="coupon_shipping transitionAnimation" data-coupon-id="<?= $self['id'] ?>" data-coupon-type="<?= $self['type'] ?>" data-coupon-discount="<?= $self['discount_amount'] ?>">免運費</span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-9 couponDescription">
                                                        <!-- 普通的点击事件，通过 JavaScript 更新隐藏的表单字段的值 -->
                                                        <span class="couponName"><?= $self['name'] ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($self['type'] == 'cash' || $self['type'] == 'percent') : ?>
                                            <!-- 全商品折扣 -->
                                            <?php if (empty($self['use_type_name']) || (($self['use_type_name'] == 'qty' || $self['use_type_name'] == 'price') && $this->cart->total() >= $self['use_type_number'])) : ?>
                                                <div class="col-12 row couponContent">
                                                    <div class="col-md-12 col-lg-3 couponTitle">
                                                        <span class="coupon_money transitionAnimation" data-coupon-id="<?= $self['id'] ?>" data-coupon-type="<?= $self['type'] ?>" data-coupon-discount="<?= $self['discount_amount'] ?>">折扣優惠</span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-9 couponDescription">
                                                        <span class="couponName"><?= $self['name'] ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <input type="hidden" name="used_coupon" id="used_coupon" value="">
                            </div>
                            <br>
                            <hr>
                        <?php endif; ?>
                        <span style="text-align:right;">購物車小計：
                            <span class="cart_total_display" style="color: #dd0606;font-weight: bold;"> $0.00</span>
                        </span>
                        <br>
                        <br>
                        <br>
                    </section>
                    <h3>付款方式</h3>
                    <section>
                        <div class="container-fluid py-3">
                            <div class="col-12 row">
                                <div class="col-12">
                                    <h3 style="margin: 0px;">購物車小計：<span class="cart_total_display" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <!-- <h3 style="margin: 0px;">購物車小計：<span style="font-size:24px;color: #dd0606;">$ <?php echo  $this->cart->total() ?></span></h3> -->
                                    <input type="hidden" id="cart_total" name="cart_total" value="">
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
                                    $this->db->select('delivery_name_code,delivery_name,delivery_info, shipping_cost');
                                    if (!empty($deliveryList)) {
                                        $deliveryIdList = array();
                                        foreach ($deliveryList as $key => $value) {
                                            $deliveryIdList[] = $key;
                                        }
                                        $this->db->where_in('id', $deliveryIdList);
                                    }
                                    $this->db->where('delivery_status', 1);
                                    $d_query = $this->db->get('delivery')->result_array();


                                    $delivery_count = 0;
                                    foreach ($d_query as $d_row) { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkout_delivery" id="checkout_delivery<?= $delivery_count ?>" data-shipping-fee="<?= $d_row['shipping_cost'] ?>" value="<?= $d_row['delivery_name_code']; ?>" <?php echo ($delivery_count == 0 ? 'checked' : '') ?>>
                                            <label class="form-check-label" for="checkout_delivery<?= $d_row['delivery_name_code']; ?>">
                                                <?= $d_row['delivery_name'] ?>
                                            </label>
                                            <? if (!empty($d_row['delivery_info'])) { ?>
                                                <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $d_row['delivery_info']; ?></p>
                                            <? } ?>
                                        </div>
                                    <?
                                        $delivery_count++;
                                    } ?>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3 class="mt-0">付款方式</h3>
                                    <? $payment_count = 0;
                                    foreach ($payment as $row) { ?>
                                        <div class="form-check <?php // echo ($row['payment_code']=='ecpay'?'d-none':'') 
                                                                ?>">
                                            <input class="form-check-input" type="radio" name="checkout_payment" id="checkout_payment<?= $payment_count ?>" value="<?= $row['payment_code']; ?>" <?php echo ($payment_count == 0 ? 'checked' : '') ?>>
                                            <label class="form-check-label" for="checkout_payment<?= $row['payment_code']; ?>">
                                                <?= $row['payment_name'] ?>
                                            </label>
                                            <? if (!empty($row['payment_info'])) { ?>
                                                <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $row['payment_info']; ?></p>
                                            <? } ?>
                                        </div>
                                    <? $payment_count++;
                                    } ?>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3 class="mt-0">運費：<span id="shipping_fee" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <h3 class="mt-0">總計：<span id="total_amount_view" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <input type="hidden" id="shipping_amount" name="shipping_amount" value="">
                                    <input type="hidden" id="total_amount" name="total_amount" value="">
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>收件資訊</h3>
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
                                <div class="input-group mb-3 col-12 col-sm-8 d-none">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">縣/市</label>
                                    </div>
                                    <div style="width: 89.9%;">
                                        <div id="twzipcode"></div>
                                    </div>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 delivery_address">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">地址</span>
                                    </div>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="請輸入詳細地址">
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 supermarket">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">取貨門市</span>
                                    </div>
                                    <input type="text" class="form-control" name="storename" id="storename" value="<?php echo $this->input->get('storename') ?>" placeholder="門市名稱" readonly>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 supermarket">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">門市地址</span>
                                    </div>
                                    <input type="text" class="form-control" name="storeaddress" id="storeaddress" value="<?php echo $this->input->get('storeaddress') ?>" placeholder="門市地址" readonly>
                                    <div style="width: 100%; margin-top: 15px;">
                                        <span class="btn btn-primary" onclick="select_store_info();">選擇門市</span>
                                    </div>
                                </div>
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
                    </section>
                    <h3>確認下單</h3>
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
                                <!-- <div class="col-6 my-5">
                                    <span onclick="form_check()" class="btn btn-primary w-100">下單購買</span>
                                </div> -->
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
<script>
    $(document).ready(function() {
        // 初始化購物車總計
        var coupon_type = '';
        var cart_amount = 0;
        var shipping_amount = 0;
        var initialCartTotal = parseFloat(<?php echo $this->cart->total() ?>);
        $('.cart_total_display').text(' $' + initialCartTotal.toFixed(0));
        $('#cart_total').val(initialCartTotal.toFixed(0))
        cart_amount = initialCartTotal.toFixed(0);

        $('.couponTitle span').click(function() {
            // 已選COUPON
            var couponId = $(this).data('coupon-id');
            coupon_type = $(this).data('coupon-type');
            var usedCouponInput = $('#used_coupon');
            var currentValue = usedCouponInput.val();

            // 如果当前值等于点击的couponId，清空；否则，更新为点击的couponId
            usedCouponInput.val((currentValue === couponId.toString()) ? '' : couponId);
            // console.log($('#used_coupon').val());

            // 判断是否已经有 active 类，如果有，则移除；如果没有，则添加
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                // 更新購物車總計
                $('.cart_total_display').text('$' + initialCartTotal.toFixed(0));
                $('#cart_total').val(initialCartTotal.toFixed(0))
            } else {
                // 移除所有元素的选中状态
                $('.couponTitle span').removeClass('active');
                // 添加选中状态
                $(this).addClass('active');
                // 更新小計
                var couponDiscount = parseFloat($(this).data('coupon-discount'));
                // 计算购物车小计
                var cartTotal = parseFloat(<?php echo $this->cart->total() ?>);

                if (couponDiscount < 1 && couponDiscount > 0) {
                    // 如果优惠券折扣小于1大于0，做乘法
                    cartTotal *= couponDiscount;
                } else if (couponDiscount > 1) {
                    // 如果优惠券折扣大于1，做减法
                    cartTotal -= couponDiscount;
                }

                // 更新购物车小计显示
                $('.cart_total_display').text(' $' + cartTotal.toFixed(0));
                $('#cart_total').val(cartTotal.toFixed(0))
                cart_amount = cartTotal.toFixed(0);
            }
        });

        // 初始化選所選運送方式
        var initialShippingFee = $('input[name="checkout_delivery"]').data('shipping-fee');
        if (coupon_type == 'free_shipping') {
            var initialShippingFee = 0;
        }
        $('#shipping_fee').text(' $' + initialShippingFee.toFixed(0));
        shipping_amount = initialShippingFee.toFixed(0);
        $('#shipping_amount').val(shipping_amount);
        $('#total_amount').val(parseInt(cart_amount) + parseInt(shipping_amount))
        $('#total_amount_view').text(' $' + ((parseInt(cart_amount) + parseInt(shipping_amount))));

        // 更改運送方式
        $('input[name="checkout_delivery"]').change(function() {
            var shippingFee = $(this).data('shipping-fee');
            if (coupon_type == 'free_shipping') {
                var shippingFee = 0;
            }

            // 当选择框改变时的逻辑
            $('#shipping_fee').text(' $' + shippingFee.toFixed(0));
            shipping_amount = shippingFee.toFixed(0);
            $('#shipping_amount').val(shipping_amount);
            $('#total_amount').val(parseInt(cart_amount) + parseInt(shipping_amount))
            $('#total_amount_view').text(' $' + (parseInt(cart_amount) + parseInt(shipping_amount)));
        });
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
                $('.progress_box_bar').css('width', '33.5%');
            }
            if (currentIndex == 2) {
                $('.progress_box_bar').css('width', '67%');
            }
            if (currentIndex == 3) {
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

            if (delivery == '711_pickup') {
                $('.delivery_address').hide();
                $('.supermarket').show();
            }
            if (delivery == 'home_delivery') {
                $('.delivery_address').show();
                $('.supermarket').hide();
            }
            if (newIndex === 3) {
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
                if (delivery == '711_pickup') {
                    if ($('#storename').val() == '' || $('#storeaddress').val() == '') {
                        alert('請選擇取貨門市');
                        return false;
                    }
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
        if ($('#address').val() != '') {
            data += '<tr><td>地址</td><td>' + $('#address').val() + '</td></tr>';
        }
        if ($('#storename').val() != '') {
            data += '<tr><td>取件門市</td><td>' + $('#storename').val() + '</td></tr>';
        }
        if ($('#storeaddress').val() != '') {
            data += '<tr><td>取件地址</td><td>' + $('#storeaddress').val() + '</td></tr>';
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
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        zipcodeIntoDistrict: true, // 郵遞區號自動顯示在地區
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
        // 'countySel': '<?php // echo $user->county 
                            ?>',
        // 'districtSel': '<?php // echo $user->district 
                            ?>'
    });
</script>
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
            var h_checkout = h_sum * 0.7;
            if (h_sum >= content_auto_h) {
                $(".content_auto_h").css('height', h_sum * 0.9);
            } else {
                $(".content_auto_h").css('height', '100%');
            }
            $(".wizard > .content").css('min-height', h_checkout);
        });
    });

    function select_store_info() {
        set_user_data();
        <?php if (wp_is_mobile()) { ?>
            $(window).attr('location', 'https://emap.presco.com.tw/c2cemap.ashx?eshopid=870&&servicetype=1&url=<?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info_location.php' ?>');
        <?php } else { ?>
            window.open("https://emap.presco.com.tw/c2cemap.ashx?eshopid=870&&servicetype=1&url=<?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info.php' ?>", "選擇門市", "width=1024,height=768");
        <?php } ?>
        // $(window).attr('location','https://emap.presco.com.tw/c2cemap.ashx?eshopid=870&&servicetype=1&url=<?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info_location.php' ?>');
    }

    function set_store_info(storename = '', storeaddress = '') {
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