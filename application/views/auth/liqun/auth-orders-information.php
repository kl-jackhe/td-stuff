<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberOrderContent" id="row">
                <div class="orderDetailButton">
                    <span class="orderBtn" @click="clearSelectedOrder()"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回列表</span>
                    <span class="orderBtn" @click="redirectToCargo()"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;再買一次</span>
                </div>
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
                        <ol class="col-2 align-self-center text-center itemPrice">$&nbsp;{{ self.order_item_price*self.order_item_qty }}</ol>
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
                        <ol class="col-3 align-self-center text-center itemPrice">$&nbsp;{{ self.order_item_price*self.order_item_qty }}</ol>
                    </li>
                </div>
                <div v-if="selectedOrder.used_coupon_name != ''" class="col-12 orderContentHeader">
                    <i class="fa fa-tags" aria-hidden="true"></i>&nbsp;優惠券使用
                </div>
                <div v-if="selectedOrder.used_coupon_name != ''" class="col-12 M_order">
                    <li id="orderListHeader" class="row">
                        <ol class="col-8 align-self-center text-center">優惠券名稱</ol>
                        <ol class="col-4 align-self-center text-center">折抵金額</ol>
                    </li>
                    <li class="selectedOrderList row">
                        <ol class="col-8 align-self-center text-center">{{ selectedOrder.used_coupon_name }}</ol>
                        <ol class="col-4 align-self-center text-center itemPrice">{{ (selectedOrder.order_discount_price != 0) ? ('$ ' + parseInt(selectedOrder.order_discount_price)) : 'delivery fee' }}</ol>
                    </li>
                </div>
                <div class="computeTable">
                    <table class="tableOut">
                        <tbody>
                            <tr>
                                <th class="col-lg-10 col-sm-9 col-xs-7">金額小計</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">{{ (selectedOrder.order_total - selectedOrder.order_delivery_cost).toFixed(2) }}</span>&nbsp;元
                                </td>
                            </tr>
                            <tr>
                                <th class="col-lg-10 col-sm-9 col-xs-7">運費</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">{{ selectedOrder.order_delivery_cost }}</span>&nbsp;元
                                </td>
                            </tr>
                            <tr v-if="selectedOrder.order_discount_price > 0">
                                <th class="col-lg-10 col-sm-9 col-xs-7">優惠券折抵</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">-{{ selectedOrder.order_discount_price }}</span>&nbsp;元
                                </td>
                            </tr>
                            <tr class="partitionLine">
                                <th nowrap="nowrap" class="col-lg-10 col-sm-9 col-xs-7">商品金額總計</th>
                                <td nowrap="nowrap" class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">NT$&nbsp;{{ selectedOrder.order_discount_total }}</span>&nbsp;元
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
                            <div class="col-4 text-right">付款方式：</div>
                            <div class="col-8">{{ (selectedOrder.order_payment == 'ecpay') ? '綠界金流' : '貨到付款' }}</div>
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
                            <div class="col-8">{{ selectedOrder.order_delivery_address }}</div>
                        </div>
                    </div>
                </div>
                <div style="padding-top: 20px;">
                    <div class="form-group">
                        <div class="shippingInformation">出貨資訊</div>
                    </div>
                    <div v-if="selectedOrder.order_step != 'confirm'" class="noneOrder">
                        <span>訂單已取消</span>
                    </div>
                    <div v-else-if="!selectedOrder.SelfLogistics && !selectedOrder.AllPayLogisticsID && !selectedOrder.CVSPaymentNo" class="noneOrder">
                        <span>尚未出貨</span>
                    </div>
                    <div v-else class="row" id="separatorBottom">
                        <div class="col-md-6 orderMarginBottom">
                            <div v-if="selectedOrder.AllPayLogisticsID && selectedOrder.CVSPaymentNo" class="row">
                                <div class="col-12 text-center">
                                    <h2>物流資訊</h2>
                                </div>
                                <div class="col-4 text-right">物流交易編號：</div>
                                <div class="col-8">{{ selectedOrder.AllPayLogisticsID }}</div>
                                <div class="col-4 text-right">寄貨編號：</div>
                                <div class="col-8">{{ selectedOrder.CVSPaymentNo }}</div>
                            </div>
                            <div v-else-if="selectedOrder.SelfLogistics" class="row">
                                <div class="col-12 text-center">
                                    <h2>物流資訊</h2>
                                </div>
                                <div class="col-4 text-right">物流交易編號：</div>
                                <div class="col-8">{{ selectedOrder.SelfLogistics }}</div>
                            </div>
                            <div v-else class="row">
                                <div class="col-12 text-center">
                                    <h2>物流資訊</h2>
                                </div>
                                <div class="col-4 text-right">物流交易編號：</div>
                                <div class="col-8">暫無</div>
                            </div>
                        </div>
                        <div class="col-md-6 orderMarginBottom separator">
                            <div v-if="selectedOrder.order_delivery == '711_pickup' || selectedOrder.order_delivery == 'family_pickup'" class="row">
                                <div class="col-12 text-center">
                                    <h2>發票資訊</h2>
                                </div>
                                <div class="col-4 text-right">發票類型：</div>
                                <div class="col-8">電子發票</div>
                                <div class="col-4 text-right">發票號碼：</div>
                                <div class="col-8">{{ selectedOrder.InvoiceNumber }}</div>
                            </div>
                            <div v-else class="row">
                                <div class="col-12 text-center">
                                    <h2>發票資訊</h2>
                                </div>
                                <div class="col-4 text-right">發票類型：</div>
                                <div class="col-8">暫無</div>
                                <div class="col-4 text-right">發票號碼：</div>
                                <div class="col-8">暫無</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row orderDetailButton d-flex justify-content-center" v-if="selectedOrder.order_step == 'confirm' && selectedOrder.order_pay_status == 'not_paid' && selectedOrder.order_payment == 'ecpay'">
                    <div class="operateBtn col-6">
                        <a id="completePay" @click="completePay(selectedOrder.order_id)">完成付款</a>
                    </div>
                    <div class="operateBtn col-6">
                        <a id="cancelOrder" @click="cancelOrder(selectedOrder.order_id)">取消訂單</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>