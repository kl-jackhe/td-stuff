<!-- <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script> -->
<style>
    p {
        margin: 0px;
    }
    img {
        width: 100%;
    }
    .front_title {
        font-size: 14px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .money_size {
        color: #dd0606;
        font-weight: bold;
        font-size: 18px;
    }
    .table_img_tilte {
        width: 75px;
    }
    .border_style {
        border: 1px solid gray;
    }
    .content-box-large {
        border: none;
        box-shadow: none;
    }
    .border_product {
        padding-top: 10px;
        padding-bottom: 10px;
        border-right: 1px solid gray;
        border-top: 1px solid gray;
        border-left: 1px solid gray;
    }
    .mb_control {
        display: none;
    }
    @media screen and (max-width:767px) {
        .pc_control {
            display: none;
        }
        .mb_control {
            display: block;
        }
    }
    @media print {
        * {
        -webkit-print-color-adjust: exact !important;
        }
        .table_img_tilte {
            width: 30%;
        }
    }
</style>
<div class="row">
    <?php // $attributes = array('class' => 'download', 'id' => 'download');?>
    <?php // echo form_open('admin/order/update/' . $order['order_id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group hidden-print">
            <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info">返回上一頁</a>
            <button class="btn btn-success" type="button" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> 列印</button>       
        </div>
        <div class="content-box-large pc_control">
            <div class="row" style="padding-left: 5px;padding-right: 5px;">
                <div class="col-md-12">
                    <!-- <?php if($order['order_status']==2){ ?>
                        <div class="form-group">
                            <h4 style="color: red;">訂單已取消單</h4>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <h4>訂單狀態：<?php echo get_order_step($order['order_step']) ?></h4>
                    </div> -->
                    <div class="row front_title border_style">
                        <div class="col-md-4">訂單編號：<?php echo $order['order_number'] ?></div>
                        <div class="col-md-4 text-center">訂單日期：<?php echo $order['order_date'] ?></div>
                        <div class="col-md-4 text-right">訂單狀態：<?php echo get_order_step($order['order_step']) ?></div>
                        <div class="col-md-12" style="padding:5px;"></div>
                        <div class="col-md-3">客戶名稱：<?php echo $order['customer_name'] ?></div>
                        <div class="col-md-4 text-center">客戶電話：<?php echo $order['customer_phone'] ?></div>
                        <div class="col-md-5 text-right">客戶信箱：<?php echo $order['customer_email'] ?></div>
                    </div>
                    <div class="row front_title border_style" style="background-color: #F0F0F0;">
                        <div class="col-md-1 text-center">項目</div>
                        <div class="col-md-2">商品圖片</div>
                        <div class="col-md-4">商品名稱</div>
                        <div class="col-md-2 text-center">金額</div>
                        <div class="col-md-1 text-center">數量</div>
                        <div class="col-md-2 text-right">小計</div>
                    </div>
                    <?$count = 1;
                    $total = 0;
                    if (!empty($order_item)) {
                        foreach ($order_item as $item) {
                            if ($item['product_id'] == 0) {?>
                            <div class="row border_product">
                                <div class="col-md-1 text-center"><?php echo $count ?></div>
                                <div class="col-md-2">
                                    <?$this->db->select('*');
                                    $this->db->from('product_combine');
                                    $this->db->where('id', $item['product_combine_id']);
                                    $query = $this->db->get();
                                    foreach ($query->result_array() as $row) {
                                        echo get_front_image($row['picture']);
                                    }?>        
                                </div>
                                <div class="col-md-4">
                                    <?$i = 0;
                                    $this->db->select('*');
                                    $this->db->from('product_combine');
                                    $this->db->join('product_combine_item', 'product_combine.id = product_combine_item.product_combine_id', 'right');
                                    $this->db->where('product_combine.id', $item['product_combine_id']);
                                    $query = $this->db->get();
                                    foreach ($query->result_array() as $row) {
                                        if ($i < 1) {
                                            echo get_product_name($row['product_id']) . ' - ' . get_product_combine_name($row['product_combine_id']);
                                        }?>
                                        <ul class="pl-3 m-0" style="color: gray;">
                                            <li style="list-style-type: circle;">
                                            <?echo $row['qty'] . ' ' . $row['product_unit'];
                                            if (!empty($row['product_specification'])) {
                                                echo ' - ' . $row['product_specification'];
                                            }
                                            foreach ($order_item as $specification_item) {
                                                if ($specification_item['specification_id'] != 0 && $specification_item['order_item_qty'] == 0 && $item['product_combine_id'] == $specification_item['product_combine_id']) {
                                                    $this->db->select('*');
                                                    $this->db->from('product_specification');
                                                    $this->db->where('id', $specification_item['specification_id']);
                                                    $query_specification = $this->db->get();
                                                    foreach ($query_specification->result_array() as $row_specification) {
                                                        echo '<br>' . '✓ ' . $row_specification['specification'] . ' x ' . $specification_item['specification_qty'];
                                                    }
                                                }
                                            }?>
                                            </li>
                                        </ul>
                                        <?$i++;}?>
                                </div>
                                <div class="col-md-2 text-center"><?php echo number_format($item['order_item_price']) ?></div>
                                <div class="col-md-1 text-center"><?php echo $item['order_item_qty'] ?></div>
                                <div class="col-md-2 text-right"><?php echo number_format($item['order_item_qty'] * $item['order_item_price']) ?></div>
                            </div>
                            <?php $count++;?>
                        <?php $total += $item['order_item_qty'] * $item['order_item_price'];?>
                    <?php }}}?>
                    <div class="row front_title border_style">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">付款方式：<?php echo get_payment($order['order_payment']) ?></div>
                                <div class="col-md-12">配送方式：<?php echo get_delivery($order['order_delivery']) ?></div>
                                <div class="col-md-12">寄送/取貨地址：
                                    <?if(!empty($order['order_store_address'])){
                                        echo $order['order_store_name'].' '.$order['order_store_address'];
                                    } else {
                                        echo $order['order_delivery_address'];
                                    } ?>
                                </div>
                                <div class="col-md-12">訂單備註：<?php echo $order['order_remark']; ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row text-right">
                                <div class="col-md-6">小計：</div>
                                <div class="col-md-6"><?php echo number_format($total) ?></div>
                                <div class="col-md-6">運費：</div>
                                <div class="col-md-6"><?php echo number_format($order['order_delivery_cost']) ?></div>
                                <div class="col-md-6">總計：</div>
                                <div class="col-md-6"><?php echo number_format($order['order_discount_total']) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-box-large mb_control">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <p class="front_title">訂單編號：<?php echo $order['order_number'] ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">訂單日期：<?php echo $order['order_date'] ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">訂單狀態：<?php echo get_order_step($order['order_step']) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">客戶名稱：<?php echo $order['customer_name'] ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">客戶電話：<?php echo $order['customer_phone'] ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="front_title">客戶信箱：<?php echo $order['customer_email'] ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" class="text-nowrap table_img_tilte">圖片</th>
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
                                            <td><span id="picture"><?php $this->db->select('*');
                                                $this->db->from('product_combine');
                                                $this->db->where('id', $item['product_combine_id']);
                                                $query = $this->db->get();
                                                foreach ($query->result_array() as $row) {
                                                    echo get_front_image($row['picture']);
                                                }?></span>
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