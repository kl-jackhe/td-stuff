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
                <div v-if="order" class="M_order d-none d-md-block">
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
                            <ol class="col-2 align-self-center text-center">{{ self.order_total }}</ol>

                            <ol class="col-2 align-self-center text-center" v-if="self.order_step == 'confirm'">{{ (self.order_pay_status == 'paid') ? '已付款' : '未付款' }}</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step == 'confirm'">{{ (self.SelfLogistics || self.AllPayLogisticsID || self.CVSPaymentNo) ? "已開設貨運單" : "未出貨" }}</ol>
                            <ol class="col-2 align-self-center text-center" v-if="self.order_step != 'confirm'">訂單已取消</ol>
                            <ol class="col-3 align-self-center text-center" v-if="self.order_step != 'confirm'">訂單已取消</ol>
                        </li>
                    </a>
                </div>
                <!-- Your alternative display for small screens goes here -->
                <div v-if="order" class="d-md-none">
                    <li id="orderListHeader" class="row">
                        <ol class="col-12 text-center">訂單資訊</ol>
                    </li>
                    <a v-for="self in order" class="orderInformation" @click="showOrderDetails(self)">
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