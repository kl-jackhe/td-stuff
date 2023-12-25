<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberOrderContent" id="row">
                <div class="orderDetailButton"><span id="goBack" @click="clearSelectedOrder()"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回列表</span></div>
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
                        <ol class="col-2 align-self-center text-center">單品金額</ol>
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
                    <li id="orderListHeader" class="row">
                        <ol class="col-3 align-self-center text-center">商品名稱</ol>
                        <ol class="col-3 align-self-center text-center">商品規格</ol>
                        <ol class="col-3 align-self-center text-center">數量</ol>
                        <ol class="col-3 align-self-center text-center">小計</ol>
                    </li>
                    <li v-for="self in selectedOrderItem" class="selectedOrderList row">
                        <ol class="col-3 align-self-center text-center">{{ self.product_name }}</ol>
                        <ol class="col-3 align-self-center text-center">{{ self.product_combine_name }}</ol>
                        <ol class="col-3 align-self-center text-center">$&nbsp;{{ self.order_item_price }}</ol>
                        <ol class="col-3 align-self-center text-center price">$&nbsp;{{ self.order_item_price*self.order_item_qty }}</ol>
                    </li>
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
                <div class="row" id="separatorBottom">
                    <div class="col-md-6 orderMarginBottom">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h2>訂購人資訊</h2>
                            </div>
                            <div class="col-4 text-right">訂購人：</div>
                            <div class="col-8">{{ selectedOrder.customer_name }}</div>
                            <div class="col-4 text-right">聯絡電話：</div>
                            <div class="col-8">{{ selectedOrder.customer_phone }}</div>
                            <div class="col-4 text-right">聯絡郵箱：</div>
                            <div class="col-8">{{ selectedOrder.customer_email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 orderMarginBottom separator">
                        <div v-if="selectedOrder.order_delivery == '711_pickup' || selectedOrder.order_delivery == 'family_pickup'" class="row">
                            <div class="col-12 text-center">
                                <h2>送貨及備註資訊</h2>
                            </div>
                            <div class="col-4 text-right">取貨方式：</div>
                            <div class="col-8">超商取貨</div>
                            <div class="col-4 text-right">超商編號：</div>
                            <div class="col-8">{{ selectedOrder.store_id }}</div>
                            <div class="col-4 text-right">超商名稱：</div>
                            <div class="col-8">{{ selectedOrder.order_store_name }}</div>
                            <div class="col-4 text-right">超商地址：</div>
                            <div class="col-8">{{ selectedOrder.order_store_address }}</div>
                        </div>
                        <div v-else class="row">
                            <div class="col-12 text-center">
                                <h2>送貨及備註資訊</h2>
                            </div>
                            <div class="col-4 text-right">取貨方式：</div>
                            <div class="col-8">宅配到府</div>
                            <div class="col-4 text-right">到貨地址：</div>
                            <div class="col-8">待新增</div>
                        </div>
                    </div>
                </div>
                <div class="row orderDetailButton d-flex justify-content-center" v-if="selectedOrder.order_step == 'confirm' && selectedOrder.order_pay_status == 'not_paid' && selectedOrder.order_payment == 'ecpay'">
                    <div class="operateBtn col-6">
                        <a id="completePay" @click="completePay(selectedOrder.order_id)" >完成付款</a>
                    </div>
                    <div class="operateBtn col-6">
                        <a id="cancelOrder" @click="cancelOrder(selectedOrder.order_id)" >取消訂單</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>