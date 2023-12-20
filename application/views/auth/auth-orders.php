<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">ORDER<span class="memberTitleLogin">&nbsp;INFORMATION</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <!-- Display for screens larger than or equal to 767px -->
                <div class="M_order d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-5 align-self-center text-center">訂單資訊</ol>
                        <ol class="col-2 align-self-center text-center">訂單金額</ol>
                        <ol class="col-2 align-self-center text-center">付款狀態</ol>
                        <ol class="col-3 align-self-center text-center">出貨狀態</ol>
                    </li>
                    <a v-if="order" v-for="self in order" class="orderInformation" @click="showOrderDetails(self)">
                        <li class="row">
                            <ol class="col-5 align-self-center text-center">
                                <span class="orderNumber"><i class="fa fa-search-plus"></i>&nbsp;{{ self.order_number }}</span>
                                <span><br></span>
                                <span><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ self.created_at }}</span>
                            </ol>
                            <ol class="col-2 align-self-center text-center">{{ self.order_total }}</ol>
                            <ol class="col-2 align-self-center text-center">{{ (self.order_pay_status == 'paid') ? '已付款' : '未付款' }}</ol>
                            <ol class="col-3 align-self-center text-center">{{ self.CVSPaymentNo ? "已開設貨運單" : "未出貨" }}</ol>
                        </li>
                    </a>
                </div>
                <!-- Your alternative display for small screens goes here -->
                <div class="d-md-none">
                    <li id="orderListHeader" class="row">
                        <ol class="col-12 text-center">訂單資訊</ol>
                    </li>
                    <a v-if="order" v-for="self in order" class="orderInformation" @click="showOrderDetails(self)">
                        <li class="row">
                            <ol class="col-12 text-center">
                                <span class="orderNumber"><i class="fa fa-search-plus"></i>&nbsp;{{ self.order_number }}</span>
                                <span><br></span>
                                <span><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ self.created_at }}</span>
                            </ol>
                        </li>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>