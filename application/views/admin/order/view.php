<div class="row">
    <?php // $attributes = array('class' => 'download', 'id' => 'download');?>
    <?php // echo form_open('admin/order/update/' . $order['order_id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <a href="/admin/order/dompdf/<?php echo $order['order_id'] ?>" target="_blank" class="btn btn-danger hidden-print">查看PDF</a>
            <a href="/admin/order/dompdf_download/<?php echo $order['order_id'] ?>" target="_blank" class="btn btn-danger hidden-print">下載PDF</a>
            <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
        </div>
        <div class="content-box-large">
            <div class="row">
                <div class="col-md-6">
                    <?php if($order['order_status']==2){ ?>
                        <div class="form-group">
                            <h4 style="color: red;">訂單已取消單</h4>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <h4>訂單狀態：<?php echo get_order_step($order['order_step']) ?></h4>
                        <hr>
                        <?php if($order['order_void']==0 && $order['order_step']=='accept'){ ?>
                            <?php if($order['order_payment']=='credit' && $order['order_pay_status']=='paid') { ?>
                                <a class="btn btn-primary" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/prepare">準備中</a>
                            <?php } ?>
                            <?php if($order['order_payment']=='cash_on_delivery') { ?>
                                <a class="btn btn-primary" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/prepare">準備中</a>
                            <?php } ?>
                        <?php } ?>
                        <?php if($order['order_void']==0 && $order['order_step']=='prepare'){ ?>
                            <a class="btn btn-primary" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/shipping">運送中</a>
                        <?php } ?>
                        <?php if($order['order_void']==0 && $order['order_step']=='shipping'){ ?>
                            <a class="btn btn-primary" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/arrive">已抵達</a>
                        <?php } ?>
                        <?php if($order['order_void']==0 && $order['order_step']=='arrive'){ ?>
                            <a class="btn btn-primary" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/picked">已取餐</a>
                        <?php } ?>
                        <?php if($order['order_void']==0 && $order['order_step']=='accept' && $order['order_pay_status']=='not_paid'){ ?>
                            <a class="btn btn-danger" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/cancel" onClick="return confirm('您確定要取消嗎?')">取消訂單</a>
                        <?php } ?>
                        <?php if($order['order_void']==0 && $order['order_pay_status']=='paid' && $order['order_step']=='accept'){ ?>
                            <a class="btn btn-danger" href="/admin/order/update_step/<?php echo $order['order_id'] ?>/void" onClick="return confirm('您確定要退單嗎?')">退單</a></a>
                        <?php } ?>
                    </div>
                    <!-- <p>客戶名稱：<?php //echo $order['customer_name'] ?></p> -->
                    <p>客戶名稱：<?php echo get_user_full_name($order['customer_id']) ?></p>
                    <p>客戶電話：<?php echo $order['customer_phone'] ?></p>
                    <p>客戶信箱：<?php echo $order['customer_email'] ?></p>
                    <p>店家名稱：<?php echo get_store_name($order['store_id']) ?></p>
                    <p>訂單編號：<?php echo $order['order_number'] ?></p>
                    <p>訂單日期：<?php echo substr($order['created_at'], 0, 10) ?></p>
                    <p>取餐日期：<?php echo $order['order_date'] ?></p>
                    <p>取餐時段：<?php echo $order['order_delivery_time'] ?></p>
                    <p>取餐地點：<?php echo $order['order_delivery_address'] ?></p>

                    <!-- <p>
                        取餐地點：
                        <?php if(!empty($order['order_delivery_address'])){
                            echo $order['order_delivery_address'];
                        } else {
                            echo get_delivery_place_name($order['order_delivery_place']);
                        } ?>
                    </p> -->
                    <p>付款狀態：<?php echo get_pay_status($order['order_pay_status']) ?></p>
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <ul style="padding-left: 0px; margin-bottom: 0px; border: none; list-style: none">
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
                                <p>付款方式</p>
                                <p><?php echo get_payment($order['order_payment']) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>使用優惠券</p>
                                <p><?php echo get_coupon_name($order['order_coupon']) ?></p>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <p>取餐地點</p>
                                <p>
                                    <?php if(!empty($order['order_delivery_address'])){
                                        echo $order['order_delivery_address'];
                                    } else {
                                        echo get_delivery_place_name($order['order_delivery_place']);
                                    } ?>
                                </p>
                            </td>
                        </tr> -->
                        <tr>
                            <td>
                                <p>備註</p>
                                <p>
                                    <?php echo $order['order_remark']; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <ul style="list-style: none; padding-left: 0px;">
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
    <?php // echo form_close(); ?>
</div>