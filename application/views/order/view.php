<div class="checkout-list" style="border: none; box-shadow: none; margin-bottom: 0px;">
    <div class="row">
        <div class="col-md-12">
            <h3 class="m-0">下單日期：2022-07-06 16:24:32</h3>
            <h3 class="m-0 py-2">訂單狀態：已寄貨</h3>
            <h3 class="m-0 pb-2">訂單內容</h3>
            <table class="table table-hover m_table_none">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-nowrap" style="width: 100px;">圖片</th>
                        <th scope="col" class="text-nowrap">商品</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-top:1px solid dimgray;">
                        <td>1</td>
                        <td>
                            <a href="#">
                                <img style="width: 100%;">
                            </a>
                        </td>
                        <td>
                            <p>保溫杯</p>
                            <p>金額：$150</p>
                            <p>數量：1</p>
                            <p>小計：$150</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <span>購物車小計：<span style="color: #dd0606;font-weight: bold;"> $150</span></span>
            <hr>
            <h3>配送 / 取貨方式：7-11超商取貨</h3>
            <p>配送 / 取貨地點：東英門市</p>
            <span>運費：<span style="color: #dd0606;font-weight: bold;"> $0</span></span>
            <hr>
            <span>總計：<span style="color: #dd0606;font-weight: bold;"> $150</span></span>
            <hr>
            <h3>付款方式：銀行匯款</h3>
            <p>付款狀態：已付款</p>
            <hr>
            <h3>訂購人資訊</h3>
            <p>姓名：</p>
            <p>聯絡電話：</p>
            <p>E-mail：</p>
            <p>地址：</p>
            <hr>
            <h3>訂單備註</h3>
            <p>fsdafsadfasdf</p>
            <!-- <?php if ($order['order_payment'] == 'atm') {?>
            <h4 class="fs-16 color-595757 bold">ATM付款資訊</h4>
            <table class="table table-bordered">
                <tr>
                    <th style="width:50%; background: #FFB718;">
                        <span class="fs-13" style="color: #fefefe">銀行代碼</span>
                    </th>
                    <td>
                        <span class="fs-16 color-595757"><?php echo get_setting_general('atm_bank_code') ?></span>
                    </td>
                </tr>
                <tr>
                    <th style="width:50%; background: #FFB718;">
                        <span class="fs-13" style="color: #fefefe">付款帳號</span>
                    </th>
                    <td>
                        <span class="fs-16 color-595757"><?php echo get_setting_general('atm_bank_account') ?></span>
                    </td>
                </tr>
                <tr>
                    <th style="width:50%; background: #FFB718;">
                        <span class="fs-13" style="color: #fefefe">付款截止時間</span>
                    </th>
                    <td>
                        <span class="fs-16 color-595757">2018-09-15 23:59</span>
                    </td>
                </tr>
            </table>
            <?php }?> -->
            <!-- <table class="table table-bordered">
                <tr>
                    <td>
                        <div class="col-md-12">
                            <h4 class="fs-16 color-595757 bold">付款方式</h4>
                            <h5 class="fs-13 color-595757"><?php echo get_payment($order['order_payment']) ?></h5>
                            <?php if ($order['order_void'] == 0 && $order['order_step'] == 'accept' && $order['order_pay_status'] == 'not_paid') {?>
                                <a class="btn btn-danger" href="/order/cancel/<?php echo $order['order_id'] ?>" onClick="return confirm('您確定要取消嗎?')">取消訂單</a>
                            <?php }?>

                            <?php if ($order['order_void'] == 0 && $order['order_payment'] == 'credit' && $order['order_pay_status'] == 'not_paid') {?>
                                <a class="btn btn-success" href="/store/credit_pay/<?php echo $order['order_id'] ?>">前往付款</a>
                            <?php }?>

                            <?php if ($order['order_void'] == 0 && $order['order_payment'] == 'line_pay' && $order['order_pay_status'] == 'not_paid') {?>
                                <a class="btn btn-success" href="/store/line_pay/<?php echo $order['order_id'] ?>">前往付款</a>
                            <?php }?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <ul id="orderlist" style="margin-bottom: 0px; border: none;">
                            <?php $total = 0;?>
                            <?php if (!empty($order_item)) {foreach ($order_item as $data) {?>
                            <li>
                                <div class="col-md-4">
                                    <p class="pull-left fs-13 color-595757"><?php echo get_product_name($data['product_id']) ?></p>
                                </div>
                                <div class="col-md-4 text-center">╳ <?php echo $data['order_item_qty'] ?></div>
                                <div class="col-md-4">
                                    <p class="pull-right fs-13 color-595757">NT$ <?php echo number_format($data['order_item_qty'] * $data['order_item_price']) ?></p>
                                </div>
                            </li>
                            <?php $total += $data['order_item_qty'] * $data['order_item_price'];?>
                            <?php }}?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <h4 class="fs-13 bold color-221814">使用優惠券</h4>
                            <h5 class="fs-13"><?php echo get_coupon_name($order['order_coupon']) ?></h5>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <h4 class="fs-13 bold color-221814">取餐地點</h4>
                            <h5 class="fs-13">
                                <?php if (!empty($order['order_delivery_address'])) {
	echo $order['order_delivery_address'];
} else {
	echo get_delivery_place_name($order['order_delivery_place']);
}?>
                            </h5>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <h4 class="fs-13 bold color-221814">取餐時間</h4>
                            <h5 class="fs-13">
                                <?php if (!empty($order['order_delivery_time'])) {
	echo $order['order_delivery_time'];
} else {
	echo $order['order_delivery_time'];
}?>
                            </h5>
                        </div>
                    </td>
                </tr>
            </table> -->
            <!-- <ul id="orderlist2" style="border: none;">
                <li>
                    <div class="col-md-6">
                        <p class="pull-left fs-13 color-595757">小計：</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right fs-13 color-595757">NT$ <?php echo number_format($total); ?></p>
                    </div>
                </li>
                <li>
                    <div class="col-md-6">
                        <p class="pull-left fs-13 color-595757">運費：</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right fs-13 color-595757">NT$ <?php echo number_format($order['order_delivery_cost']) ?></p>
                    </div>
                </li>
                <li style="display: none;">
                    <div class="col-md-6">
                        <p class="pull-left fs-13 color-595757">服務費：</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right fs-13 color-595757">NT$ <?php echo number_format($total * 0.1); ?></p>
                    </div>
                </li>
                <li>
                    <div class="col-md-6">
                        <p class="pull-left fs-13 color-595757">優惠券折抵：</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right fs-13 color-595757">NT$ -<?php echo number_format($order['order_discount_price']) ?></p>
                    </div>
                </li>
                <li>
                    <hr style="background: #3bccde; color: #3bccde; height: 3px">
                </li>
                <li>
                    <div class="col-md-6">
                        <p class="pull-left fs-16 color-595757 bold" style="font-size: 16pt">總計</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right fs-16 color-595757 bold">NT$ <?php echo number_format($order['order_discount_total']) ?></p>
                    </div>
                </li>
                <li>
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-info btn-block" data-dismiss="modal">確認</button>
                    </div>
                    <a href="" id="sendModify" class="btn btn-block mt-md" style="border: 1px solid #00BFD5; color: #00BFD5;">修改訂單</a>
                </li>
            </ul> -->
        </div>
    </div>
</div>