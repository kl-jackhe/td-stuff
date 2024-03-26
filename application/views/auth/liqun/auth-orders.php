<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">ORDER<span class="memberTitleLogin">&nbsp;INFORMATION</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <div v-if="!order" class="noneOrder">
                    <span class="">目前無任何訂單資料</span>
                </div>
                <!-- Display for screens larger than or equal to 767px -->
                <div v-if="order" class="d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-5 align-self-center text-center">訂單資訊</ol>
                        <ol class="col-2 align-self-center text-center">訂單金額</ol>
                        <ol class="col-2 align-self-center text-center">付款狀態</ol>
                        <ol class="col-3 align-self-center text-center">出貨狀態</ol>
                    </li>
                    <a v-for="self in order.slice(pageStart, pageEnd)" class="orderInformation" @click="showOrderDetails(self)">
                        <li class="row">
                            <ol class="col-5 align-self-center text-center">
                                <span class="orderNumber"><i class="fa fa-search-plus"></i>&nbsp;{{ self.order_number }}</span>
                                <span><br></span>
                                <span><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ self.created_at }}</span>
                            </ol>
                            <ol class="col-2 align-self-center text-center">{{ self.order_discount_total }}</ol>

                            <!-- 訂單確認 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'confirm' && self.order_pay_status == 'not_paid'">未付款</ol>
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'confirm' && self.order_pay_status == 'paid'">審核中</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'confirm'">待出貨</ol>
                            <!-- 已收款 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'pay_ok'">已付款</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'pay_ok'">待出貨</ol>
                            <!-- 待出貨 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'process'">已付款</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'process'">待出貨</ol>
                            <!-- 調貨中 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'preparation'">已付款</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'preparation'">調貨中</ol>
                            <!-- 已出貨 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'shipping'">已付款</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'shipping'">已出貨</ol>
                            <!-- 已完成 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'complete'">已付款</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'complete'">已出貨</ol>
                            <!-- 訂單取消 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'order_cancel'">訂單取消</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'order_cancel'">訂單取消</ol>
                            <!-- 訂單不成立 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'invalid'">訂單不成立</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'invalid'">訂單不成立</ol>
                            <!-- 退貨處理中 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'returning'">退貨處理中</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'returning'">退貨處理中</ol>
                            <!-- 訂單已退貨 -->
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'return_complete'">訂單已退貨</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'return_complete'">訂單已退貨</ol>
                        </li>
                    </a>
                </div>
                <!-- Your alternative display for small screens goes here -->
                <div v-if="order" class="d-md-none">
                    <li id="orderListHeader" class="row">
                        <ol class="col-12 text-center">訂單資訊</ol>
                    </li>
                    <a v-for="self in order.slice(pageStart, pageEnd)" class="orderInformation" @click="showOrderDetails(self)">
                        <li class="row">
                            <ol class="col-12 text-center">
                                <span class="orderNumber"><i class="fa fa-search-plus"></i>&nbsp;{{ self.order_number }}</span>
                                <span><br></span>
                                <span><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ self.created_at }}</span>
                            </ol>
                        </li>
                    </a>
                </div>
                <?php require('pagination.php'); ?>
            </div>
        </div>
    </div>
</div>