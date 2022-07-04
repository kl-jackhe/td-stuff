<div role="main" class="main pt-signinfo">
    <section class="form-section">
        <div class="container">
            <div class="box mt-md">
                <div class="col-md-12">
                    <h3 class="fs-18 color-595757">Hi <?php echo $this->ion_auth->user()->row()->full_name ?></h3>
                </div>
                <div class="col-md-7">
                    <div class="form-content atmarea">
                        <h2 id="re" class="hidden-xs" style="background: #CD131E; border-top: 3px solid #CD131E;">
                            信用卡付款失敗 <img src="/assets/images/checkout/xx.png" style="height: 20px; margin-bottom: 5px;">
                        </h2>
                        <div class="payinfo">
                            <h4 class="fs-16 color-595757">收件人資訊</h4>
                            <div id="atmpayinfo" class="atmpay">
                                <table class="table table-bordered fs-13 color-595757">
                                    <tr>
                                        <th style="width:50%;">訂單編號</th>
                                        <td><?php echo $order['order_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">收件人姓名</th>
                                        <td><?php echo $order['full_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">收件人電話</span></th>
                                        <td><span><?php echo $order['phone'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">備註</th>
                                        <td><?php echo $order['order_remark'] ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <h4 class="fs-15" style="color: #CB141C;">*取餐時間以送餐當日的簡訊通知為主</h4>
                            </div>
                            <div class="form-group">
                                <label>付款方式</label>
                                <select class="form-control" name="paymenttype" id="payment">
                                    <option value="Credit">信用卡</option>
                                    <!-- <option value="ATM">匯款轉帳(ATM / 臨櫃繳款)</option> -->
                                </select>
                            </div>
                            <div class="row mt-lg">
                                <div class="col-md-6 col-md-offset-6">
                                    <br>
                                    <a href="/store/credit_pay/<?php echo $order['order_id'] ?>"class="btn btn-info btn-block">付款去</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="checkout-list" style="box-shadow: none; border: none;">
                        <div class="row">
                            <div class="col-md-12" style="box-shadow: 3px 3px 10px 0px grey; padding: 30px; border-left: none;">
                                <h4 class="fs-13 color-595757">訂單編號 <?php echo $order['order_number'] ?></h4>
                                <div style="padding: 10px 15px; background: #03B4C6; color: white;">
                                    <h4 class="fs-20 color-white bold nopadding">預估取餐時間</h4>
                                    <h4 class="fs-13 color-white bold nopadding"><?php echo $this->session->userdata('delivery_date') ?>　<?php echo $this->session->userdata('delivery_time') ?></h4>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">付款方式</h4>
                                                <h5><?php echo get_payment($order['order_payment']) ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul style="margin-bottom: 0px; border: none; list-style: none">
                                                <?php $total=0; ?>
                                                <?php if(!empty($order_item)) { foreach($order_item as $data) { ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p class="pull-left"><?php echo get_product_name($data['product_id']) ?></p>
                                                        </div>
                                                        <div class="col-md-4 text-center">╳ <?php echo $data['order_item_qty'] ?></div>
                                                        <div class="col-md-4">
                                                            <p class="pull-right">NT$ <?php echo number_format($data['order_item_qty']*$data['order_item_price']) ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php $total+=$data['order_item_qty']*$data['order_item_price']; ?>
                                                <?php }} ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">使用優惠券</h4>
                                                <h5><?php echo get_coupon_name($order['order_coupon']) ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">取餐地點</h4>
                                                <h5>
                                                    <?php if(!empty($order['order_delivery_address'])){
                                                        echo $order['order_delivery_address'];
                                                    } else {
                                                        echo get_delivery_place_name($order['order_delivery_place']);
                                                    } ?>
                                                </h5>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <ul style="list-style: none">
                                    <li>
                                        <div class="col-md-6">
                                            <p class="pull-left">小計：</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pull-right">NT$ <?php echo number_format($total); ?></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-6">
                                            <p class="pull-left">運費：</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pull-right">NT$ <?php echo number_format($order['order_delivery_cost']); ?></p>
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <div class="col-md-6">
                                            <p class="pull-left">服務費：</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pull-right">NT$ <?php echo number_format($total*0.1); ?></p>
                                        </div>
                                    </li> -->
                                    <li>
                                        <div class="col-md-6">
                                            <p class="pull-left">優惠券折抵：</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pull-right">NT$ -<?php echo number_format($order['order_discount_price']) ?></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-12">
                                            <hr style="background: #3bccde; color: #3bccde; height: 3px">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-6">
                                            <p class="pull-left fs-16 color-595757 bold" style="font-size: 16pt">總計</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pull-right fs-16 color-595757 bold">NT$ <?php echo number_format($order['order_discount_total']) ?></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="done-Modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="background: #717171; color: white;">
            <div class="modal-body" style="padding: 15px;">
                <div class="row">
                    <div class="col-md-12" style="padding-top: 50px; padding-bottom: 50px;">
                        <img src="/assets/images/checkout/checkout-success.png" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // $('#cart_details').load("<?php // echo base_url(); ?>store/load_cart_no_remove");
        // $('#load_cart_price').load("<?php // echo base_url(); ?>store/load_cart_price");
        // $('#done-Modal').modal('show');
        // $.ajax({
        //     url: "<?php echo base_url(); ?>cart/remove_all",
        //     method: "get",
        //     data: { },
        //     success: function(data) {
        //         // 
        //     }
        // });
    });
    // $(window).load(function() {

    // });
</script>