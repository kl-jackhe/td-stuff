<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">ORDER<span class="memberTitleLogin">&nbsp;INFORMATION</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <div class="M_order">
                    <li id="orderListHeader" class="row">
                        <ol class="col-2">訂單資訊</ol>
                        <ol class="col-2">訂單金額</ol>
                        <ol class="col-2">訂單狀態</ol>
                        <ol class="col-2">付款狀態</ol>
                        <ol class="col-2">出貨狀態</ol>
                        <ol class="col-2">操作訂單</ol>
                    </li>
                    <li v-if="orders" v-for="self in orders" class="row">
                        <ol class="col-2">{{ self.order_number }}</ol>
                        <ol class="col-2">{{ self.order_total }}</ol>
                        <ol class="col-2">{{ self.order_status }}</ol>
                        <ol class="col-2">{{ self.order_pay_status }}</ol>
                        <ol class="col-2">{{ self.CVSPaymentNo ? self.CVSPaymentNo : "NONE" }}</ol>
                        <ol class="col-2">訂單內容</ol>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>