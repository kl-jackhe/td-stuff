<style>
    img {
        width: 100%;
    }
    .front_title {
        font-size: 18px;
    }
    .money_size {
        color: #dd0606;
        font-weight: bold;
        font-size: 24px;
    }
</style>
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
                    <p class="front_title">客戶名稱：<?php echo $order['customer_name'] ?></p>
                    <p class="front_title">客戶電話：<?php echo $order['customer_phone'] ?></p>
                    <p class="front_title">客戶信箱：<?php echo $order['customer_email'] ?></p>
                    <p class="front_title">訂單編號：<?php echo $order['order_number'] ?></p>
                    <p class="front_title">訂單日期：<?php echo $order['order_date'] ?></p>

                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col" class="text-nowrap" style="width: 75px;">圖片</th>
                                            <th scope="col" class="text-nowrap">商品</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    $count = 1;
                                    $total = 0;
                                     if (!empty($order_item)) {
                                        foreach ($order_item as $item) {
                                            if ($item['product_id'] == 0) {?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $count ?></td>
                                            <td><?php $this->db->select('*');
                                                $this->db->from('product_combine');
                                                $this->db->where('id', $item['product_combine_id']);
                                                $query = $this->db->get();
                                                foreach ($query->result_array() as $row) {
                                                    echo get_front_image($row['picture']);
                                                }?>
                                            </td>
                                            <td>
                                                <div>
                                                <?php $i = 0;
                                                $this->db->select('*');
                                                $this->db->from('product_combine');
                                                $this->db->join('product_combine_item', 'product_combine.id = product_combine_item.product_combine_id', 'right');
                                                $this->db->where('product_combine.id', $item['product_combine_id']);
                                                $query = $this->db->get();
                                                foreach ($query->result_array() as $row) {
                                                    // echo $row['id'] . ' ' . $row['product_specification'] . ' ' . $row['product_id'] . '<br>';
                                                    if ($i < 1) {
                                                        echo get_product_name($row['product_id']) . ' - ' . get_product_combine_name($row['product_combine_id']);
                                                    }?>
                                                    <ul class="pl-3 m-0" style="color: gray;">
                                                        <li style="list-style-type: circle;">
                                                        <?echo $row['qty'] . ' ' . $row['product_unit'];
                                                        if (!empty($row['product_specification'])) {
                                                            echo ' - ' . $row['product_specification'];
                                                        }?>
                                                        </li>
                                                    </ul>
                                                    <?$i++;}?>
                                                </div>
                                                <div>金額：$<?php echo number_format($item['order_item_price']) ?></div>
                                                <div>數量：<?php echo $item['order_item_qty'] ?></div>
                                                <div>小計：<span style="color:#dd0606;">$<?php echo number_format($item['order_item_qty'] * $item['order_item_price']) ?></span></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php $count++;?>
                                    <?php $total += $item['order_item_qty'] * $item['order_item_price'];?>
                                    <?php }}}?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">配送方式：</p>
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
                                <p class="front_title">付款方式：</p>
                                <p><?php echo get_payment($order['order_payment']) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">備註：</p>
                                <p>
                                    <?php echo $order['order_remark']; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="front_title">小計：<span class="money_size">$<?php echo number_format($total) ?> </span></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="front_title">運費：<span class="money_size">$<?php echo number_format($order['order_delivery_cost']) ?> </span></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="front_title">總計：<span class="money_size">$<?php echo number_format($order['order_discount_total']) ?></span></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php // echo form_close(); ?>
</div>