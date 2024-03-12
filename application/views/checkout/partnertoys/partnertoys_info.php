<section>
    <div class="form-group">
        <div class="formTi">訂購資訊</div>
    </div>
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
            <!-- <div class="input-group mb-3 col-12 col-sm-8">
                <div class="input-group-prepend">
                    <span class="input-group-text">訂單備註</span>
                </div>
                <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
            </div> -->
        </div>
    </div>
    <div class="form-group">
        <div class="formTi">取貨方式</div>
    </div>
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-md-6">
                <? $delivery_count = 0; ?>
                <?php if (!empty($delivery)) : ?>
                    <div id="taiwanDeliveryOptions">
                        <?php foreach ($delivery as $d_row) : ?>
                            <?php if ($d_row['delivery_type'] != 3) : ?>
                                <div class="checkoutRadioType">
                                    <input type="radio" name="checkout_delivery" id="checkout_delivery_<?= $d_row['delivery_name_code']; ?>" data-shipping-fee="<?= $d_row['shipping_cost'] ?>" value="<?= $d_row['delivery_name_code']; ?>">
                                    <label for="checkout_delivery_<?= $d_row['delivery_name_code']; ?>">
                                        <?= $d_row['delivery_name'] ?>
                                    </label>
                                    <? if (!empty($d_row['delivery_info'])) { ?>
                                        <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $d_row['delivery_info']; ?></p>
                                    <? } ?>
                                </div>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6">
                <?php if (!empty($delivery)) : ?>
                    <div id="othersDeliveryOptions">
                        <?php foreach ($delivery as $d_row) : ?>
                            <?php if ($d_row['delivery_type'] == 3) : ?>
                                <div class="checkoutRadioType">
                                    <input type="radio" name="checkout_delivery" id="checkout_delivery_<?= $d_row['delivery_name_code']; ?>" data-shipping-fee="<?= $d_row['shipping_cost'] ?>" value="<?= $d_row['delivery_name_code']; ?>">
                                    <label for="checkout_delivery_<?= $d_row['delivery_name_code']; ?>">
                                        <?= $d_row['delivery_name'] ?>
                                    </label>
                                    <? if (!empty($d_row['delivery_info'])) { ?>
                                        <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $d_row['delivery_info']; ?></p>
                                    <? } ?>
                                </div>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- 付款方式 -->
    <div class="form-group">
        <div class="formTi">付款方式</div>
    </div>
    <div class="container-fluid py-3">
        <div class="col-12 col-md-6">
            <?php $payment_count = 0; ?>
            <?php if (!empty($ECPay_status) && !empty($close_count)) : ?>
                <?php foreach ($payment as $row) : ?>
                    <?php if ($row['payment_status'] == 0) : ?>
                        <?php $payment_count++; ?>
                    <?php endif; ?>
                    <div class="checkoutRadioType">
                        <input type="radio" name="checkout_payment" id="checkout_payment_<?= $row['payment_code']; ?>" value="<?= $row['payment_code']; ?>">
                        <label for="checkout_payment_<?= $row['payment_code']; ?>">
                            <?= $row['payment_name'] ?>
                        </label>
                        <? if (!empty($row['payment_info'])) { ?>
                            <p style="font-size:12px;color: gray;white-space: pre-wrap;"><?= $row['payment_info']; ?></p>
                        <? } ?>
                    </div>
                    <br>
                    <?php $payment_count++; ?>
                <?php endforeach; ?>
            <?php elseif (empty($ECPay_status) || empty($close_count)) : ?>
                <span style="color:#dd0606;">尚無付款方式。請聯繫客服。</span>
            <?php endif; ?>
        </div>
    </div>
    <!-- 門市選擇 -->
    <div class="form-group supermarket">
        <div class="formTi">門市選擇</div>
    </div>
    <div class="container-fluid py-3 supermarket">
        <div class="row col-12">
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
    </div>
    <!-- 其他資訊 -->
    <div class="form-group">
        <div class="formTi">其他資訊</div>
    </div>
    <div class="container-fluid row py-3">
        <div class="remakBox form-group row col-12">
            <label for="order_cpname" class="col-md-2 control-label">發票抬頭</label>
            <div class="col-md-4 col-sm-12">
                <input type="text" class="form-control" id="order_cpname" name="order_cpname" value="" placeholder="發票抬頭">
            </div>
            <label for="order_cpno" class="col-md-2 control-label">統一編號</label>
            <div class="col-md-4 col-sm-12">
                <input type="text" class="form-control" id="order_cpno" name="order_cpno" value="" placeholder="統一編號">
            </div>
        </div>
        <div class="remakBox form-group row col-12">
            <label for="remark" class="col-md-2 col-sm-12 control-label">備註事項</label>
            <div class="col-md-10 col-sm-12">
                <textarea class="form-control" id="remark" name="remark" rows="5" placeholder="如有特別注意事項請於備註欄填寫。"></textarea>
            </div>
        </div>
    </div>
    <div class="container-fluid py-3">
        <div class="col-12">
            <h3 class="mt-0">運費：<span id="shipping_fee" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
            <h3 class="mt-0">總計：<span id="total_amount_view" style="font-size:24px;color: #dd0606;"> $0.00</span></h3>
            <input type="hidden" id="shipping_amount" name="shipping_amount" value="">
            <input type="hidden" id="total_amount" name="total_amount" value="">
            <input type="hidden" id="cart_total" name="cart_total" value="<?php echo '$' . $this->cart->total() ?>">
        </div>
    </div>
</section>