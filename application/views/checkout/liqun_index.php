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
        p {
            font-size: 12px;
        }

        .wizard>.content {
            overflow-y: auto;
            min-height: 600px !important;
        }
    }
</style>
<div role="main" class="main" id="liqun_checkout">
    <section class="form-section content_auto_h">
        <?php $attributes = array('id' => 'checkout_form'); ?>
        <?= form_open('checkout/save_order', $attributes); ?>
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
                    <section id="confirm_order">
                        <div class="mb-5" style="position:relative;">
                            <h3 class="mt-0">您共選擇 (<?= $count ?> 個項目)</h3>
                            <? if (empty($this->session->userdata('user_id'))) : ?>
                                <div class="checkoutHintJoinMember">
                                    <a href="javascript:void(0)" onclick="goToRegister()" class="btn btn-primary">加入會員</a>
                                </div>
                            <? endif; ?>
                        </div>
                        <input type="hidden" name="checking_cargos_value" id="checking_cargos_value" value="<?= $count ?>">
                        <table class="table table-hover m_table_none">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-nowrap" style="width: 100px;">圖片</th>
                                    <th scope="col" class="text-nowrap">商品</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $i = 1;
                                $product_list = array();
                                foreach ($this->cart->contents() as $items) :
                                    $tmp_tag_content = $this->mysql_model->_select('product_tag_content', 'product_id', $items['product_id']);
                                    if (!empty($tmp_tag_content)) {
                                        foreach ($tmp_tag_content as $self_tag) {
                                            $tmp_tag = $this->mysql_model->_select('product_tag', 'id', $self_tag['product_tag_id'], 'row');
                                            if ($tmp_tag['code'] == 'frozen') {
                                                $is_frozen = true;
                                            }
                                        }
                                    }

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
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <? if ($agentID == '') { ?>
                                                <a href="product/view/<?= $items['product_id'] ?>">
                                                    <?php $image = get_product_combine($items['id'], 'picture'); ?>
                                                    <?php if ($image != '') { ?>
                                                        <img id="zoomA" style="width: 100%;" src="/assets/uploads/<?= $image; ?>" alt="<?= $items['name']; ?>">
                                                    <?php } ?>
                                                </a>
                                            <? } else { ?>
                                                <?php $image = get_product_combine($items['id'], 'picture'); ?>
                                                <?php if ($image != '') { ?>
                                                    <img id="zoomA" style="width: 100%;" src="/assets/uploads/<?= $image; ?>" alt="<?= $items['name']; ?>">
                                                <?php } ?>
                                            <? } ?>
                                        </td>
                                        <td>
                                            <p><?= $items['name']; ?></p>
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
                                            <p>金額：$ <?= $items['price']; ?></p>
                                            <p>
                                                數量：
                                                <span class="input-group-btn inlineBlock">
                                                    <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[<?= $items["rowid"] ?>]" data-reword-id="<?= $items["rowid"] ?>">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" <?= $items["rowid"] ?> name="quant[<?= $items["rowid"] ?>]" class="input_border_style inlineBlock qtyInputBox" value="<?= $items['qty']; ?>" data-reword-id="<?= $items["rowid"] ?>" min='1' max='100'>
                                                <span class="input-group-btn inlineBlock">
                                                    <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-weight="<?= !empty($items['options']['weight']) ? $items['options']['weight'] : 0; ?>" data-field="quant[<?= $items["rowid"] ?>]" data-reword-id="<?= $items["rowid"] ?>">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </span>
                                            </p>
                                            <p>小計：<span id="subtotal_<?= $items["rowid"] ?>" style="color: #dd0606">$ <?= $items['subtotal']; ?></span></p>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <?php if (!empty($coupon)) : ?>
                            <div class="col-12 row">
                                <h4 class="col-12 promotion-title">可使用之優惠券<span style="color: red;">(點選後反白即已選用)</span></h4>
                                <?php foreach ($coupon as $self) : ?>
                                    <?php $now = date('Y-m-d H:i:s'); ?>
                                    <?php if ($self['distribute_at'] < $now && $self['discontinued_at'] > $now) : ?>
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
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <input type="hidden" name="used_coupon" id="used_coupon" value="">
                            </div>
                            <br>
                            <hr>
                        <?php endif; ?>
                        <? if (empty($this->session->userdata('user_id'))) : ?>
                            <span class="redContent">✳︎&nbsp;現在加入會員即可獲得一張100元優惠券，單筆訂單滿399即可使用！</span>
                            <br>
                            <br>
                            <br>
                        <? endif; ?>
                        <span style="text-align:right;">購物車小計：
                            <span class="cart_total_display" style="color: #dd0606;font-weight: bold;"> $0.00</span>
                        </span>
                        <br>
                        <span style="text-align:right;">計重：
                            <span class="cart_weight_display" style="color: #dd0606;font-weight: bold;"> 0.00</span>
                        </span>
                        <br>
                        <br>
                        <br>
                    </section>
                    <h3>付款方式</h3>
                    <section id="payment_type">
                        <div class="container-fluid py-3">
                            <div class="col-12 row">
                                <div class="col-12">
                                    <h3 style="margin: 0px;">購物車小計：<span class="cart_total_display" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <!-- <h3 style="margin: 0px;">購物車小計：<span style="font-size:24px;color: #dd0606;">$ <?= $this->cart->total() ?></span></h3> -->
                                    <input type="hidden" id="cart_total" name="cart_total" value="">
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3 class="mt-0">購物須知</h3>
                                    <textarea class="form-control redContent" cols="30" rows="3" disabled><?= get_setting_general('shopping_notes') ?></textarea>
                                    <!-- <p>1. 目前訂單量較多，預計3-5個工作天內出貨(不含假日)。</p>
                                    <p style="color:#dd0606;">2. 超商取貨者，請務必確認手機號碼是否正確。</p> -->
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3 class="mt-0">運送方式</h3>
                                    <?
                                    $d_query = $this->delivery_model->getSortOpenDesc();

                                    foreach ($d_query as $d_row) {
                                        $frozen_limit = '';
                                        if ($is_frozen && ($d_row['delivery_name_code'] == '711_pickup' || $d_row['delivery_name_code'] == 'family_pickup' || $d_row['delivery_name_code'] == 'hi_life_pickup' || $d_row['delivery_name_code'] == 'ok_pickup' || $d_row['delivery_name_code'] == 'home_delivery')) {
                                            $frozen_limit = 'disabled';
                                        }
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkout_delivery" id="<?= $d_row['delivery_name_code']; ?>" data-free-shipping-enable="<?= $d_row['free_shipping_enable'] ?>" data-free-shipping-limit="<?= $d_row['free_shipping_limit'] ?>" data-limit-weight="<?= $d_row['limit_weight'] ?>" data-shipping-fee="<?= $d_row['shipping_cost'] ?>" value="<?= $d_row['delivery_name_code']; ?>" <?= $frozen_limit ?>>
                                            <label class="form-check-label" for="checkout_delivery<?= $d_row['delivery_name_code']; ?>">
                                                <?= $d_row['delivery_name'] ?>
                                            </label>
                                            <? if (!empty($d_row['delivery_info'])) { ?>
                                                <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $d_row['delivery_info']; ?></p>
                                            <? } ?>
                                        </div>
                                    <? } ?>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3 class="mt-0">付款方式</h3>
                                    <?php
                                    $payment_count = 0;
                                    foreach ($payment as $row) {
                                        $cash_on_delivery = '';
                                        if ($row['payment_code'] == 'cash_on_delivery') {
                                            $cash_on_delivery = 'disabled';
                                        }
                                    ?>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkout_payment" id="<?= $row['payment_code']; ?>" value="<?= $row['payment_code']; ?>" <?= ($payment_count == 0 ? 'checked' : '') ?> <?= $cash_on_delivery ?>>
                                            <label class="form-check-label" for="<?= $row['payment_code']; ?>">
                                                <?= $row['payment_name'] ?>
                                            </label>
                                            <?php if (!empty($row['payment_info'])) { ?>
                                                <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $row['payment_info']; ?></p>
                                            <?php } ?>
                                        </div>
                                    <?php $payment_count++;
                                    } ?>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3 id="exceedView" class="mt-0">超重加收：<span id="exceed_weight" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <h3 class="mt-0">運費：<span id="shipping_fee" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <h3 class="mt-0">總計：<span id="total_amount_view" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
                                    <h3 class="mt-0">計重：<span class="cart_weight_display" style="font-size:24px;color: #dd0606;"> 0.00</span></h3>
                                    <input type="hidden" id="in_free_shipping_range" name="in_free_shipping_range">
                                    <input type="hidden" id="weight_exceed_amount" name="weight_exceed_amount">
                                    <input type="hidden" id="shipping_amount" name="shipping_amount">
                                    <input type="hidden" id="total_amount" name="total_amount">
                                    <input type="hidden" id="weight_amount" name="weight_amount">
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>收件資訊</h3>
                    <section id="delivery_infomation">
                        <div class="container-fluid">
                            <div class="form-group row p-3 justify-content-center" style="padding-bottom:50px !important;">
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">收件人姓名</span>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name" value="<?= $user_data['name'] ?>" placeholder="範例：王小明" onchange="set_user_data()" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">收件人電話</span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?= $user_data['phone'] ?>" placeholder="範例：0987654321" onchange="set_user_data()" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">收件人郵箱</span>
                                    </div>
                                    <input type="text" class="form-control" name="email" id="email" value="<?= $user_data['email'] ?>" placeholder="範例：test@test.com.tw" onchange="set_user_data()" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 delivery_address">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">國家</span>
                                    </div>
                                    <select class="form-control" name="Country" id="Country">
                                        <option value="臺灣">臺灣</option>
                                    </select>
                                </div>
                                <!-- zip of taiwan -->
                                <div id="twzipcode" class="input-group mb-3 col-12 col-sm-8 row delivery_address">
                                    <div class="mb-2 col-md-4 col-12" data-role="county" data-value="<?= $user_data['county'] ?>"></div>
                                    <div class="mb-2 col-md-4 col-12" data-role="district" data-value="<?= $user_data['district'] ?>"></div>
                                    <div class="mb-2 col-md-4 col-12" data-role="zipcode" data-value="<?= $user_data['zipcode'] ?>"></div>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 delivery_address">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">詳細地址</span>
                                    </div>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="請輸入詳細地址" value="<?= $user_data['address'] ?>">
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 supermarket">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">門市編號</span>
                                    </div>
                                    <input type="text" class="form-control" name="storeid" id="storeid" value="<?= $this->input->get('storeid') ?>" placeholder="門市編號" readonly>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8 supermarket">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">取貨門市</span>
                                    </div>
                                    <input type="text" class="form-control" name="storename" id="storename" value="<?= $this->input->get('storename') ?>" placeholder="門市名稱" readonly>
                                    <input type="hidden" class="form-control" name="storeaddress" id="storeaddress" value="<?= $this->input->get('storeaddress') ?>" readonly>
                                    <input type="hidden" class="form-control" name="ReservedNo" id="ReservedNo" value="<?= $this->input->get('ReservedNo') ?>" readonly>
                                    <div style="width: 100%; margin-top: 15px;">
                                        <span class="btn btn-primary" onclick="select_cvs();">選擇門市</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">訂單備註</span>
                                    </div>
                                    <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                                </div>
                                <? if (empty($this->session->userdata('user_id'))) : ?>
                                    <? if ($this->is_liqun_food) : ?>
                                        <div style="display: block;" class="input-group mb-3 col-12 col-sm-8 text-right">
                                            <a href="javascript:void(0)" onclick="goToRegister()" class="btn btn-primary">加入會員享優惠</a>
                                        </div>
                                    <? else : ?>
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
                                            <div class="input-group pb-2">
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
                                    <? endif; ?>
                                <? endif; ?>
                            </div>
                        </div>
                    </section>
                    <h3>確認下單</h3>
                    <section id="complete_order">
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
        <?= form_close() ?>
    </section>
</div>

<!-- hint -->
<div id="hintWindow">
    <div class="text-center">
        <h1>
            <span id="processingText">訂單處理中請稍後</span>
            <span id="dots"></span>
        </h1>
    </div>
</div>

<!-- purchase-steps -->
<script src="/assets/jquery.steps-1.1.0/jquery.steps.min.js"></script>

<script>
    function goToRegister() {
        $.ajax({
            url: '/encode/getDataEncode/category',
            type: 'post',
            data: {
                category: 2,
            },
            success: (response) => {
                if (response) {
                    if (response.result == 'success') {
                        window.location.href = <?= json_encode(base_url()) ?> + 'auth/?' + response.src;
                    } else {
                        console.log('error.');
                    }
                } else {
                    console.log(response);
                }
            },
        });
    }
</script>

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
        var coupon_type = '';
        var selfnum = 0;
        var freeLimit = 0;
        var freeEnable = 0;
        var cart_amount = 0;
        var cart_weight = 0.000;
        var shipping_amount = 0;
        var initialShippingFee = 0;
        var initialCartTotal = parseInt(<?= $this->cart->total() ?>);
        var initialCartWeight = parseFloat(<?= $total_weight ?>);
        cart_amount = initialCartTotal;
        cart_weight = initialCartWeight;
        $('#exceedView').css('display', 'none');
        $('#weight_exceed_amount').val(selfnum);
        $('#in_free_shipping_range').val(0);
        $('#cart_total').val(cart_amount);
        $('#weight_amount').val(cart_weight);
        $('.cart_total_display').html(' $' + cart_amount);
        $('.cart_weight_display').html(' ' + cart_weight + ' KG');

        // 初始化整體總計
        shipping_amount = parseInt(initialShippingFee);
        $('#shipping_fee').html(' $' + shipping_amount);
        $('#shipping_amount').val(shipping_amount);
        $('#total_amount').val(cart_amount + shipping_amount + selfnum);
        $('#total_amount_view').html(' $' + (cart_amount + shipping_amount + selfnum));

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
                // 更新coupon_type
                coupon_type = '';
                cart_amount = initialCartTotal;
                // 检查哪个运送方式被选中
                // 超重計算
                var selectedDelivery = $('input[name="checkout_delivery"]:checked');
                freeLimit = selectedDelivery.data('free-shipping-limit');
                freeEnable = selectedDelivery.data('free-shipping-enable');
                var limitWeight = selectedDelivery.data('limit-weight');

                var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val()
                if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup' || delivery == 'family_limit_5_frozen_pickup' || delivery == 'family_limit_10_frozen_pickup') {
                    if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup') {
                        selfnum = Math.ceil(((cart_weight - limitWeight) / 4)) * 50;
                    } else {
                        selfnum = Math.ceil(((cart_weight - limitWeight) / 9)) * 50;
                    }
                }
                if (selectedDelivery.length > 0) { // 至少有一个运送方式被选中
                    // 获取被选中的运送方式的运费
                    var shippingFee = selectedDelivery.data('shipping-fee');
                    $('#shipping_fee').html(' $' + shippingFee);
                    $('#shipping_amount').val(shippingFee);
                } else {
                    $('#shipping_fee').html(' $' + initialShippingFee);
                    $('#shipping_amount').val(initialShippingFee);
                }
                // 更新購物車總計
                $('.cart_total_display').html('$' + initialCartTotal);
                $('#cart_total').val(initialCartTotal)

                // 更新總計
                $('#total_amount').val(cart_amount + shipping_amount + selfnum);
                $('#total_amount_view').html(' $' + (cart_amount + shipping_amount + selfnum));

                // 達到免運門檻
                if (freeEnable == 1) {
                    if (freeLimit <= cart_amount) {
                        $('#shipping_fee').html('&nbsp;<del>$' + shipping_amount + '</del>');
                        $('#shipping_amount').val(0);
                        $('#in_free_shipping_range').val(1);
                        $('#total_amount').val(cart_amount + selfnum);
                        $('#total_amount_view').html(' $' + (cart_amount + selfnum));
                    }
                }
            } else {
                // 移除所有元素的选中状态
                $('.couponTitle span').removeClass('active');
                // 添加选中状态
                $(this).addClass('active');

                // 超重計算
                var selectedDelivery = $('input[name="checkout_delivery"]:checked');
                freeLimit = selectedDelivery.data('free-shipping-limit');
                freeEnable = selectedDelivery.data('free-shipping-enable');
                var limitWeight = selectedDelivery.data('limit-weight');
                var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val()
                if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup' || delivery == 'family_limit_5_frozen_pickup' || delivery == 'family_limit_10_frozen_pickup') {
                    if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup') {
                        selfnum = Math.ceil(((cart_weight - limitWeight) / 4)) * 50;
                    } else {
                        selfnum = Math.ceil(((cart_weight - limitWeight) / 9)) * 50;
                    }
                }

                // 更新免運
                if (coupon_type == 'free_shipping') {
                    if (selectedDelivery.length > 0) { // 至少有一个运送方式被选中
                        // 获取被选中的运送方式的运费
                        var shippingFee = 0;

                        // 当选择框改变时的逻辑
                        shipping_amount = parseInt(shippingFee);
                        $('#shipping_fee').html(' $' + shipping_amount);
                        $('#shipping_amount').val(shipping_amount);
                    } else {
                        $('#shipping_fee').html(' $' + initialShippingFee);
                        $('#shipping_amount').val(initialShippingFee);
                    }
                }

                // 更新小計
                var couponDiscount = parseFloat($(this).data('coupon-discount'));
                // 计算购物车小计
                var cartTotal = parseFloat(initialCartTotal);

                if (couponDiscount < 1 && couponDiscount > 0) {
                    // 如果优惠券折扣小于1大于0，做乘法
                    cartTotal *= couponDiscount;
                } else if (couponDiscount > 1) {
                    // 如果优惠券折扣大于1，做减法
                    cartTotal -= couponDiscount;
                }

                // 更新购物车小计显示
                cart_amount = parseInt(cartTotal);
                $('.cart_total_display').html(' $' + cart_amount);
                $('#cart_total').val(cart_amount);

                // 更新總計
                $('#total_amount').val(cart_amount + shipping_amount + selfnum);
                $('#total_amount_view').html(' $' + (cart_amount + shipping_amount + selfnum));

                // 達到免運門檻
                if (freeEnable == 1) {
                    if (freeLimit <= cart_amount) {
                        $('#shipping_fee').html('&nbsp;<del>$' + shipping_amount + '</del>');
                        $('#shipping_amount').val(0);
                        $('#in_free_shipping_range').val(1);
                        $('#total_amount').val(cart_amount + selfnum);
                        $('#total_amount_view').html(' $' + (cart_amount + selfnum));
                    }
                }
            }
        });

        // 更改運送方式
        $('input[name="checkout_delivery"]').change(function() {

            if ($(this).val() == 'home_delivery' || $(this).val() == 'home_frozen_delivery') {
                $('#cash_on_delivery').attr('disabled', false);
            } else {
                if ($('#cash_on_delivery').is(':checked')) {
                    $('#cash_on_delivery').prop('checked', false);
                }
                $('#cash_on_delivery').attr('disabled', true);
            }

            var shippingFee = $(this).data('shipping-fee');
            var limitWeight = $(this).data('limit-weight');
            freeLimit = $(this).data('free-shipping-limit');
            freeEnable = $(this).data('free-shipping-enable');
            if (coupon_type == 'free_shipping') {
                var shippingFee = 0;
            }

            // 訂單超重
            if (cart_weight > limitWeight) {
                var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val()
                if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup' || delivery == 'family_limit_5_frozen_pickup' || delivery == 'family_limit_10_frozen_pickup') {
                    alert('由於訂單超重故系統將自動拆單並加收超取運費箱費用，建議將訂單改為宅配免付加購運費箱～')
                    if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup') {
                        selfnum = Math.ceil(((cart_weight - limitWeight) / 4)) * 50;
                    } else {
                        selfnum = Math.ceil(((cart_weight - limitWeight) / 9)) * 50;
                    }
                }
                $('#weight_exceed_amount').val(selfnum);
                $('#exceedView').css('display', 'block');
                $('#exceed_weight').html(' $' + selfnum);
            } else {
                selfnum = 0;
                $('#weight_exceed_amount').val(selfnum);
                $('#exceedView').css('display', 'none');
                $('#exceed_weight').html(' $' + selfnum);
            }

            // 当选择框改变时的逻辑
            shipping_amount = parseInt(shippingFee);
            $('#shipping_fee').html(' $' + shipping_amount);
            $('#shipping_amount').val(shipping_amount);
            $('#total_amount').val(cart_amount + shipping_amount + selfnum)
            $('#total_amount_view').html(' $' + (cart_amount + shipping_amount + selfnum));

            // 達到免運門檻
            if (freeEnable == 1) {
                if (freeLimit <= cart_amount) {
                    $('#shipping_fee').html('&nbsp;<del>$' + shipping_amount + '</del>');
                    $('#shipping_amount').val(0);
                    $('#in_free_shipping_range').val(1);
                    $('#total_amount').val(cart_amount + selfnum);
                    $('#total_amount_view').html(' $' + (cart_amount + selfnum));
                }
            }
        });
    });
</script>

<!-- 介面 -->
<script>
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

            if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup' || delivery == 'family_limit_5_frozen_pickup' || delivery == 'family_limit_10_frozen_pickup') {
                $('.delivery_address').hide();
                $('.supermarket').show();
            } else {
                $('.delivery_address').show();
                $('.supermarket').hide();
            }
            if (newIndex === 2) {
                if (delivery == '' || delivery == null) {
                    alert('請選擇運送方式');
                    return false;
                }
                if (payment == '' || payment == null) {
                    alert('請選擇付款方式');
                    return false;
                }
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
                if (delivery == '' || delivery == null || ($('#Country').val() == '臺灣' && delivery == 'sf_express_delivery') || (($('#Country').val() != '臺灣') && delivery != 'sf_express_delivery')) {
                    alert('請選擇運送方式');
                    return false;
                }
                if (payment == '' || payment == null) {
                    alert('請選擇付款方式');
                    return false;
                }
                if (delivery == '711_pickup' || delivery == 'family_pickup' || delivery == 'hi_life_pickup' || delivery == 'ok_pickup' || delivery == 'family_limit_5_frozen_pickup' || delivery == 'family_limit_10_frozen_pickup') {
                    if ($('#storeid').val() == '' || $('#storename').val() == '') {
                        alert('請選擇取貨門市');
                        return false;
                    }
                } else {
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

                // check reserve person
                <? if (!empty($this->session->userdata('user_id'))) : ?>
                    var tmp_name = <?= json_encode($this->session->userdata('full_name')) ?>;
                    var tmp_phone = <?= json_encode($this->session->userdata('phone')) ?>;
                    var tmp_email = <?= json_encode($this->session->userdata('email')) ?>;
                    if ($('#name').val() != tmp_name || $('#phone').val() != tmp_phone || $('#email').val() != tmp_email) {
                        if (!confirm('請問收件人資訊與帳戶持有者資訊判斷為不同人是否繼續下一步呢？')) {
                            return false;
                        }
                    }
                <? endif; ?>
            }
            checkConfirmInfo();
            return true;
        },
        onFinishing: function(event, currentIndex) {
            // dot status start
            var dotsInterval = setInterval(updateDots, 500);
            showNotification();
            // 表單送出
            form_check(function(success) {
                if (success) {
                    // 如果表单提交成功，设置标志变量为 true，并在5秒后隐藏提示视窗
                    setTimeout(function() {
                        if (hideNotificationFlag) {
                            clearInterval(dotsInterval); // 停止更新点状态
                            hideNotification(); // 隐藏提示视窗
                        }
                    }, 5000); // 5000毫秒后隐藏提示视窗
                } else {
                    // 如果表单提交失败，直接隐藏提示视窗
                    clearInterval(dotsInterval); // 停止更新点状态
                    hideNotification(); // 隐藏提示视窗
                }
            });
            return true;
        }
    });

    function checkConfirmInfo() {
        var selectedCheckoutDelivery = $('input[name="checkout_delivery"]:checked').val();
        var checkoutDeliveryLabel = $('label[for="checkout_delivery' + selectedCheckoutDelivery + '"]').text();
        var selectedCheckoutPayment = $('input[name="checkout_payment"]:checked').val();
        var checkoutPaymentLabel = $('label[for="' + selectedCheckoutPayment + '"]').text();
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
        if (selectedCheckoutDelivery != '711_pickup' && selectedCheckoutDelivery != 'family_pickup' && selectedCheckoutDelivery != 'hi_life_pickup' && selectedCheckoutDelivery != 'ok_pickup' && selectedCheckoutDelivery != 'family_limit_5_frozen_pickup' && selectedCheckoutDelivery != 'family_limit_10_frozen_pickup') {
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
        } else {
            if ($('#storeid').val() != '') {
                data += '<tr><td>門市編號</td><td>' + $('#storeid').val() + '</td></tr>';
            }
            if ($('#storename').val() != '') {
                data += '<tr><td>取件門市</td><td>' + $('#storename').val() + '</td></tr>';
            }
            if ($('#storeaddress').val() && $('#storeaddress').val() != '') {
                data += '<tr><td>取件地址</td><td>' + $('#storeaddress').val() + '</td></tr>';
            }
        }
        data += '<tr><td>訂單備註</td><td>' + $('#remark').val() + '</td></tr>';
        data += '<tr><td>運送方式</td><td>' + checkoutDeliveryLabel + '</td></tr>';
        data += '<tr><td>付款方式</td><td>' + checkoutPaymentLabel + '</td></tr>';

        var tmp_cart = <?= (int)$this->cart->total() ?>;
        var order_discount_price = parseInt(tmp_cart) - parseInt($('#cart_total').val());
        if (tmp_cart != '') {
            data += '<tr><td>購物車小計</td><td>$' + tmp_cart + '</td></tr>';
        }
        if (order_discount_price != 0) {
            data += '<tr><td>優惠折抵</td><td>$-' + order_discount_price + '</td></tr>';
        }
        if ($('#weight_exceed_amount').val() != '') {
            data += '<tr><td>超重加收</td><td>$' + $('#weight_exceed_amount').val() + '</td></tr>';
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
<script>
    // twzipcode
    $(document).ready(function() {
        // 初始化 twzipcode
        $("#twzipcode").twzipcode();

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

    // cvs map
    function select_cvs() {
        $('#storeid').val('');
        $('#storename').val('');
        $('#storeaddress').val('');
        $('#ReservedNo').val('');

        set_user_data();

        // checked radio val
        var selectedDelivery = $("input[name='checkout_delivery']:checked").val();

        // 手機版cookie存取checked radio val
        document.cookie = "selectedDelivery=" + selectedDelivery;

        // 是否為手機
        var isMobile = <?= json_encode(wp_is_mobile()) ?>;

        if (selectedDelivery === 'family_limit_10_frozen_pickup' || selectedDelivery === 'family_limit_5_frozen_pickup' || selectedDelivery === 'family_pickup') {
            // 串至全家地圖
            var route = '<?= base_url(); ?>fmtoken/fm_map';
            if (selectedDelivery === 'family_limit_5_frozen_pickup') {
                route = '<?= base_url(); ?>fmtoken/fm_map/true/S60';
            } else if (selectedDelivery === 'family_limit_10_frozen_pickup') {
                route = '<?= base_url(); ?>fmtoken/fm_map/true/S105';
            }

            if (isMobile) {
                // 導入串全家地圖並給cvsmap判斷是否為mobile
                window.open(route, "選擇門市");
            } else {
                // 開新視窗串全家地圖cvsmap
                window.open(route, "選擇門市", "width=1024,height=768");
            }
        } else {
            // 串至綠界地圖
            var route = '<?= base_url(); ?>checkout/cvsmap?checkout=' + selectedDelivery + '';

            if (isMobile) {
                // 導入串綠界地圖並給cvsmap判斷是否為mobile
                window.open(route, "選擇門市");
            } else {
                // 開新視窗串綠界地圖cvsmap
                window.open(route, "選擇門市", "width=1024,height=768");
            }
        }
    }

    function select_store_info() {
        set_user_data();
        <?php if (wp_is_mobile()) { ?>
            $(window).attr('location', 'https://emap.presco.com.tw/c2cemap.ashx?eshopid=870&&servicetype=1&url=<?= 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info_location.php' ?>');
        <?php } else { ?>
            window.open("https://emap.presco.com.tw/c2cemap.ashx?eshopid=870&&servicetype=1&url=<?= 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info.php' ?>", "選擇門市", "width=1024,height=768");
        <?php } ?>
        // $(window).attr('location','https://emap.presco.com.tw/c2cemap.ashx?eshopid=870&&servicetype=1&url=<?= 'https://' . $_SERVER['HTTP_HOST'] . '/get_store_info_location.php' ?>');
    }

    function set_store_info(storeid = '', storename = '', storeaddress = '') {
        $("#storeid").val(storeid);
        $("#storename").val(storename);
        $("#storeaddress").val(storeaddress);
    }

    function set_fm_store_info(storeid = '', storename = '', ReservedNo = '') {
        $("#storeid").val(storeid);
        $("#storename").val(storename);
        $("#ReservedNo").val(ReservedNo);
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

    // Ajaxリクエストの開始時に通知を表示
    function showNotification() {
        // 通知の表示ロジックを実装（例：ローディングスピナーやメッセージを表示）
        $('#hintWindow').css('display', 'block');
    }

    // Ajaxリクエストの完了時に通知を非表示にする
    function hideNotification() {
        // 通知の非表示ロジックを実装
        $('#hintWindow').css('display', 'none');
    }

    // ドットを更新する関数
    function updateDots() {
        var dots = $('#dots').text();
        if (dots.length >= 5) {
            $('#dots').text('.');
        } else {
            $('#dots').text(dots + '.');
        }
    }

    function form_check(callback) {
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
        callback(true);
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