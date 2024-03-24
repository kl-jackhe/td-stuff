<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberOrderContent" id="row">
                <div class="orderDetailButton">
                    <span class="orderBtn" @click="clearSelectedOrder()"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回列表</span>
                    <!-- <span class="orderBtn" @click="redirectToCargo()"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;再買一次</span> -->
                </div>
                <div class="col-12 text-center">
                    <span class="memberTitleMember">ORDER<span class="memberTitleLogin">&nbsp;CONTENT</span></span>
                </div>
                <div class="col-12 memberTitleChinese text-center">訂單內容</div>
                <div class="col-12 selectedOrderHeaderBox d-none d-md-block">
                    <span class="selectedOrderHeader"> 訂單編號：<span class="orderNumber">{{ selectedOrder.order_number }}</span></span>
                    <span class="selectedOrderHeader"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ selectedOrder.created_at }}</span>
                </div>
                <div class="col-12 selectedOrderHeaderBox d-md-none">
                    <span class="selectedOrderHeader"> 訂單編號：<span class="orderNumber">{{ selectedOrder.order_number }}</span></span>
                    <br>
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
                        <ol class="col-3 align-self-center text-center">
                            <a href="javascript:void(0)" @click="href_product(self.product_id)">{{ self.product_name }}</a>
                        </ol>
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
                        <ol class="col-3 align-self-center text-center">
                            <a :href="'/product/product_detail/' + self.product_id">{{ self.product_name }}</a>
                        </ol>
                        <ol class="col-3 align-self-center text-center">{{ self.product_combine_name }}</ol>
                        <ol class="col-3 align-self-center text-center">$&nbsp;{{ self.order_item_price }}</ol>
                        <ol class="col-3 align-self-center text-center itemPrice">$&nbsp;{{ self.order_item_price*self.order_item_qty }}</ol>
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
                            <tr class="partitionLine">
                                <th class="col-lg-10 col-sm-9 col-xs-7">運費</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
                                    <span class="price">{{ selectedOrder.order_delivery_cost }}</span>&nbsp;元
                                </td>
                            </tr>
                            <tr>
                                <th class="col-lg-10 col-sm-9 col-xs-7">商品金額總計</th>
                                <td class="col-lg-2 col-sm-3 col-xs-5">
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
                            <div class="col-4 text-right">付款方式：</div>
                            <div v-show="selectedOrder.order_payment" class="col-8">{{ getPayName(selectedOrder.order_payment) }}</div>
                            <div class="col-4 text-right">聯絡電話：</div>
                            <div class="col-8">{{ selectedOrder.customer_phone }}</div>
                            <div class="col-4 text-right">聯絡郵箱：</div>
                            <div class="col-8">{{ selectedOrder.customer_email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 orderMarginBottom separator">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h2>收件資訊</h2>
                            </div>
                            <div class="col-4 text-right">收件人：</div>
                            <div class="col-8">{{ selectedOrder.customer_name }}</div>
                            <div class="col-4 text-right">聯絡電話：</div>
                            <div class="col-8">{{ selectedOrder.customer_phone }}</div>
                            <div class="col-4 text-right">收件地址：</div>
                            <div v-if="selectedOrder.order_delivery == '711_pickup' || selectedOrder.order_delivery == 'family_pickup'" class="col-8">超商取貨</div>
                            <div v-else class="col-8">{{ selectedOrder.order_delivery_address }}</div>
                        </div>
                    </div>
                </div>
                <!-- 待修改 -->
                <div class="orderInfoHeader">
                    <div class="form-group">
                        <div class="shippingInformation"></div>
                    </div>
                    <div v-if="selectedOrder.order_step == 'order_cancel'" class="noneOrder">
                        <span>訂單已取消</span>
                    </div>
                    <div v-else-if="selectedOrder.order_step == 'invalid'" class="noneOrder">
                        <span>訂單不成立</span>
                    </div>
                    <div v-else-if="selectedOrder.order_step == 'returning'" class="noneOrder">
                        <span>退貨處理中</span>
                    </div>
                    <div v-else-if="selectedOrder.order_step == 'return_complete'" class="noneOrder">
                        <span>訂單已退貨</span>
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
                                <div class="col-4 text-right">寄貨編號：</div>
                                <div class="col-8">{{ selectedOrder.SelfLogistics }}</div>
                            </div>
                            <div v-else class="row">
                                <div class="col-12 text-center">
                                    <h2>物流資訊</h2>
                                </div>
                                <div class="col-4 text-right">物流交易編號：</div>
                                <div class="col-8">暫無</div>
                            </div>
                            <div v-if="selectedOrder.InvoiceNumber != ''" class="row">
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
                        <div class="col-md-6 orderMarginBottom separator">
                            <div v-if="selectedOrder.order_delivery == '711_pickup' || selectedOrder.order_delivery == 'family_pickup'" class="row">
                                <div class="col-12 text-center">
                                    <h2>送貨及備註資訊</h2>
                                </div>
                                <div class="col-4 text-right">取貨方式：</div>
                                <div class="col-8">超商取貨</div>
                                <div v-show='selectedOrder.store_id' class="col-4 text-right">超商編號：</div>
                                <div v-show='selectedOrder.store_id' class="col-8">{{ selectedOrder.store_id }}</div>
                                <div v-show='selectedOrder.order_store_name' class="col-4 text-right">超商名稱：</div>
                                <div v-show='selectedOrder.order_store_name' class="col-8">{{ selectedOrder.order_store_name }}</div>
                                <div v-show='selectedOrder.order_store_address' class="col-4 text-right">超商地址：</div>
                                <div v-show='selectedOrder.order_store_address' class="col-8">{{ selectedOrder.order_store_address }}</div>
                                <div class="col-4 text-right">訂單備註：</div>
                                <div class="col-8">{{ (selectedOrder.order_remark == '') ? '無備註資訊' : selectedOrder.order_remark }}</div>
                            </div>
                            <div v-else class="row">
                                <div class="col-12 text-center">
                                    <h2>送貨及備註資訊</h2>
                                </div>
                                <div class="col-4 text-right">取貨方式：</div>
                                <div class="col-8">宅配到府</div>
                                <div class="col-4 text-right">到貨地址：</div>
                                <div class="col-8">{{ selectedOrder.order_delivery_address }}</div>
                                <div class="col-4 text-right">訂單備註：</div>
                                <div class="col-8">{{ (selectedOrder.order_remark == '') ? '無備註資訊' : selectedOrder.order_remark }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="orderInfoHeader">
                    <div class="form-group">
                        <div class="shippingInformation">訂單留言</div>
                    </div>
                    <div class="leave_msg">
                        <a @click="toggleMessagePopup" title="我要留言" class="btn btn-warning popup-link-message">我要留言</a>
                    </div>
                    <table v-if="selectedOrderMessage.length > 0" id="orderMessageTable" class="table table-striped table-inquiry">
                        <tbody class="messagePC">
                            <tr>
                                <th style="width: 30%;">留言時間</th>
                                <th style="width: 70%;">留言內容</th>
                            </tr>
                            <tr v-for="self in selectedOrderMessage">
                                <td>
                                    <p><span>{{ self.created_at }}</span></p>
                                </td>
                                <td>
                                    <p v-if=" self.user_id==0" class="redContent">
                                        <span class="redContent">
                                            <b>管理者留言：</b>
                                        </span>
                                        <span><br></span>
                                        <span>{{ self.content }}</span>
                                    </p>
                                    <p v-if="self.user_id != 0">
                                        <span>
                                            <b>您的留言：</b>
                                        </span>
                                        <span><br></span>
                                        <span>{{ self.content }}</span>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="messageMobile">
                            <tr>
                                <th style="width: 100%;">留言內容</th>
                            </tr>
                            <tr v-for="self in selectedOrderMessage">
                                <td style="width: 100%;">
                                    <span>{{ self.created_at }}</span>
                                    <div>
                                        <p v-if="self.user_id == 0" class="redContent">
                                            <span><b>管理者留言：</b></span>
                                            <span>{{ self.content }}</span>
                                        </p>
                                        <p v-if="self.user_id != 0">
                                            <span><b>您的留言：</b></span>
                                            <span>{{ self.content }}</span>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="selectedOrderMessage.length == 0" class="noneOrder">
                        <span>目前無任何留言資料</span>
                    </div>
                </div>
                <!-- <div class="row orderDetailButton d-flex justify-content-center" v-if="selectedOrder.order_step == 'confirm' && selectedOrder.order_pay_status == 'not_paid' && selectedOrder.order_payment == 'ecpay_credit'"> -->
                <div class="row orderDetailButton d-flex justify-content-center" v-if="selectedOrder.order_step == 'confirm' && selectedOrder.order_pay_status == 'not_paid' && selectedOrder.order_payment == 'ecpay_credit'">
                    <div class="operateBtn col-6">
                        <a id="completePay" @click="completePay('ecp_repay_order', selectedOrder.order_id)">繼續付款</a>
                    </div>
                    <div class="operateBtn col-6">
                        <a id="cancelOrder" @click="cancelOrder(selectedOrder.order_id)">取消訂單</a>
                    </div>
                </div>
                <!-- <div class="row orderDetailButton d-flex justify-content-center" v-if="selectedOrder.order_step == 'confirm' && selectedOrder.order_pay_status == 'not_paid' && (selectedOrder.order_payment == 'ecpay_ATM' || selectedOrder.order_payment == 'ecpay_CVS')">
                    <div class="operateBtn col-12">
                        <a id="cancelOrder" @click="cancelOrder(selectedOrder.order_id)">取消訂單</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- mfp -->
<div id="termsPopupWrapper">
    <div id="termsOfMessage" class="mfp-hide">
        <div class="col-12 text-center">
            <span class="memberTitleMember">LEAVE<span class="memberTitleLogin">&nbsp;MESSAGE</span></span>
        </div>
        <div class="memberTitleChinese col-12 text-center">我要留言</div>
        <div class="membershipLine"></div>
        <div class="membershipContent">
            <div class="row form-group">
                <label class="col-sm-3 control-label" for="message_content">留言內容</label>
                <div class="col-sm-9">
                    <textarea name="message_content" id="message_content" class="form-control" required></textarea>
                </div>
            </div>
            <div class="row form-group mt-5">
                <div class="col-sm-12 sendMessageButtonGroup">
                    <input type="hidden" name="order_id" id="order_id" :value="selectedOrder.order_id">
                    <button type="reset" class="btnDef black"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;清除</button>
                    <button type="button" class="btnDef red" @click="sendMessage"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;送出</button>
                </div>
            </div>
        </div>
    </div>
</div>