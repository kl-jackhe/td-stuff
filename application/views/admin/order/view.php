<div class="row">
    <?php // $attributes = array('class' => 'download', 'id' => 'download');?>
    <?php // echo form_open('admin/order/update/' . $order['order_id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
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
                    </div>
                    <p>客戶名稱：<?php echo $order['customer_name'] ?></p>
                    <p>客戶電話：<?php echo $order['customer_phone'] ?></p>
                    <p>客戶信箱：<?php echo $order['customer_email'] ?></p>
                    <p>訂單編號：<?php echo $order['order_number'] ?></p>
                    <p>訂單日期：<?php echo $order['order_date'] ?></p>

                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>商品</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $count = 1;
                                    $total = 0;
                                    ?>
                                    <?php if (!empty($order_item)) {foreach ($order_item as $item) {?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $count ?></td>
                                            <td>
                                                <div>
                                                    <?php
                                                    if($item['product_id']==0){
                                                        echo get_product_combine_name($item['product_combine_id']);
                                                    }
                                                    if($item['product_id']!=0){
                                                        echo get_product_name($item['product_id']);
                                                    }
                                                    ?>
                                                </div>
                                                <div>金額：$<?php echo number_format($item['order_item_price']) ?></div>
                                                <div>數量：<?php echo $item['order_item_qty'] ?></div>
                                                <div>小計：$<?php echo number_format($item['order_item_qty'] * $item['order_item_price']) ?></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php $count++; ?>
                                    <?php $total += $item['order_item_qty'] * $item['order_item_price']; ?>
                                    <?php }} ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>配送方式：</p>
                                <p><?php echo get_delivery($order['order_delivery']) ?></p>
                                <p>
                                <?php if(!empty($order['order_store_address'])){
                                    echo $order['order_store_name'].' '.$order['order_store_address'];
                                } else {
                                    echo $order['order_delivery_address'];
                                } ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>付款方式：</p>
                                <p><?php echo get_payment($order['order_payment']) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>備註：</p>
                                <p>
                                    <?php echo $order['order_remark']; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>小計：</p>
                                <p>
                                    <?php echo number_format($total); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>運費：</p>
                                <p>
                                    <?php echo number_format($order['order_delivery_cost']); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>總計：</p>
                                <p>
                                    <?php echo number_format($order['order_discount_total']) ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php // echo form_close(); ?>
</div>