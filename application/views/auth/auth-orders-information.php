<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberOrderContent" id="row">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">ORDER<span class="memberTitleLogin">&nbsp;CONTENT</span></span>
                </div>
                <div class="col-12 memberTitleChinese text-center">訂單內容</div>
                <div class="col-12 selectedOrderHeaderBox">
                    <span class="selectedOrderHeader"> 訂單編號：<span class="orderNumber">{{ selectedOrder.order_number }}</span></span>
                    <span class="selectedOrderHeader"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ selectedOrder.created_at }}</span>
                </div>
                <div class="col-12 orderContentHeader">
                    <i class="far fa-list-alt"></i>&nbsp;一般商品
                </div>
                <div class="col-12 M_order d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-3 align-self-center text-center">商品名稱</ol>
                        <ol class="col-3 align-self-center text-center">商品規格</ol>
                        <ol class="col-2 align-self-center text-center">金額</ol>
                        <ol class="col-2 align-self-center text-center">數量</ol>
                        <ol class="col-2 align-self-center text-center">小計</ol>
                    </li>
                    <li v-for="self in selectedOrderItem" class="selectedOrderList row">
                        <ol class="col-3 align-self-center text-center">{{ self.product_name }}</ol>
                        <ol class="col-3 align-self-center text-center">{{ self.product_combine_name }}</ol>
                        <ol class="col-2 align-self-center text-center">$&nbsp;{{ self.order_item_price }}</ol>
                        <ol class="col-2 align-self-center text-center">{{ self.order_item_qty }}</ol>
                        <ol class="col-2 align-self-center text-center price">$&nbsp;{{ self.order_item_price*self.order_item_qty }}</ol>
                    </li>
                </div>
                <div class="col-12 d-md-none">

                </div>
                <div class="computeTable">
                    <table class="tableOut">
                        <tbody>
                            <tr>
                                <th class="col-lg-10 col-sm-9 col-xs-7">金額小計</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">{{ selectedOrder.order_total }}</span>&nbsp;元
                                </td>
                            </tr>
                            <tr class="partitionLine">
                                <th class="col-lg-10 col-sm-9 col-xs-7">運費</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">0.00</span>&nbsp;元
                                </td>
                            </tr>
                            <tr>
                                <th nowrap="nowrap" class="col-lg-10 col-sm-9 col-xs-7">商品金額總計</th>
                                <td nowrap="nowrap" class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">NT$&nbsp;{{ selectedOrder.order_total }}</span>&nbsp;元
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="row">
                    <div class="col-md-6 row">
                        <div class="col-12 text-center">訂購人資訊</div>
                        <div class="col-4">訂購人：</div>
                        <div class="col-8">{{ selectedOrder.customer_name }}</div>
                        <div class="col-4">聯絡電話：</div>
                        <div class="col-8">{{ selectedOrder.customer_phone }}</div>
                        <div class="col-4">聯絡郵箱：</div>
                        <div class="col-8">{{ selectedOrder.customer_email }}</div>
                    </div>
                    <div class="col-md-6 row">
                        <div class="col-12 text-center">送貨及備註資訊</div>
                        <div class="col-4">取貨方式：</div>
                        <div class="col-8">{{ (selectedOrder.order_delivery == '711_pickup' || selectedOrder.order_delivery == 'family_pickup') ? '超商取貨' : '宅配到府' }}</div>
                        <div class="col-4">超商編號：</div>
                        <div class="col-8">{{ selectedOrder.store_id }}</div>
                        <div class="col-4">超商名稱：</div>
                        <div class="col-8">{{ selectedOrder.order_store_name }}</div>
                        <div class="col-4">超商地址：</div>
                        <div class="col-8">{{ selectedOrder.order_store_address }}</div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>