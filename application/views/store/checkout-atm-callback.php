<div role="main" class="main pt-signinfo">
    <section class="form-section">
        <div class="container">
            <div class="box mt-md">
                <div class="col-md-12">
                    <h3 class="fs-18 color-595757">Hi <?php echo $this->ion_auth->user()->row()->full_name ?></h3>
                </div>
                <div class="col-md-7">
                    <div class="form-content atmarea">
                        <h2 id="re" class="fs-16 color-white">
                            ATM付款資訊
                        </h2>
                        <div class="payinfo">
                            <h4 class="fs-16 color-595757">收件人資訊</h4>
                            <div id="atmpayinfo" class="atmpay">
                                <table class="table table-bordered fs-13 color-595757">
                                    <tr>
                                        <th style="width:50%;">訂單編號</th>
                                        <td><?php echo $order_number ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">收件人姓名</th>
                                        <td><?php echo $user_name ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">收件人電話</span></th>
                                        <td><span><?php echo $user_phone ?></span></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">備註</th>
                                        <td><?php echo $remark ?></td>
                                    </tr>
                                </table>
                            </div>
                            <h4 class="fs-16 color-595757">ATM付款資訊</h4>
                            <div id="atmpayinfo" class="atmpay">
                                <table class="table table-bordered fs-13 color-595757">
                                    <tr>
                                        <th style="width:50%;">銀行代碼</th>
                                        <td><?php echo get_setting_general('atm_bank_code') ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">付款帳號</th>
                                        <td><span><?php echo get_setting_general('atm_bank_account') ?></span></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">付款截止時間</th>
                                        <td><?php echo date('Y-m-d') ?> 23:59</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <h4 class="fs-15" style="color: #CB141C;">*取餐時間以送餐當日的簡訊通知為主</h4>
                            </div>
                            <div class="row mt-lg">
                                <div class="col-md-6 col-md-offset-6">
                                    <br>
                                    <a href="/"class="btn btn-info btn-block">完成</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="checkout-list" style="box-shadow: none; border: none;">
                        <div class="row">
                            <div class="col-md-12" style="box-shadow: 3px 3px 10px 0px grey; padding: 30px; border-left: none;">
                                <h4 class="fs-13 color-595757">訂單編號 <?php echo $order_number ?></h4>
                                <div style="padding: 10px 15px; background: #03B4C6; color: white;">
                                    <h4 class="fs-20 color-white bold nopadding">預估取餐時間</h4>
                                    <h4 class="fs-13 color-white bold nopadding"><?php echo $this->session->userdata('delivery_date') ?>　<?php echo $this->session->userdata('delivery_time') ?></h4>
                                </div>
                                <table class="table table-bordered">
                                    <tbody id="cart_details">

                                    </tbody>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">使用優惠券</h4>
                                                <h5 class="fs-13"><?php echo get_coupon_name($this->session->userdata('coupon_id')) ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">取餐地點</h4>
                                                <h5 class="fs-13"><?php echo get_delivery_place_name($this->session->userdata('delivery_place')) ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="col-md-12">
                                                <h4 class="fs-13 bold color-221814">取餐時間</h4>
                                                <h5 class="fs-13"><?php echo $this->session->userdata('delivery_time') ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <ul id="load_cart_price" style="border: none;">
                                    
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
        $('#cart_details').load("<?php echo base_url(); ?>store/load_cart_no_remove");
        $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
        $('#done-Modal').modal('show');
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