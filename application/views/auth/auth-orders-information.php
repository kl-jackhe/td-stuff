<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="row memberOrderContent">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">ORDER<span class="memberTitleLogin">&nbsp;CONTENT</span></span>
                </div>
                <div class="col-12 memberTitleChinese text-center">訂單內容</div>
                <div class="col-12 selectedOrderHeaderBox">
                    <span class="selectedOrderHeader"> 訂單編號：<span class="orderNumber">{{ selectedOrder.order_number }}</span></span>
                    <span class="selectedOrderHeader"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ selectedOrder.created_at }}</span>
                </div>
                <div class="col-12 orderContentHeader" bis_skin_checked="1"><i class="far fa-list-alt"></i>一般商品</div>
                <div class="col-12 M_order d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-5 align-self-center text-center">訂單資訊</ol>
                        <ol class="col-2 align-self-center text-center">訂單金額</ol>
                        <ol class="col-2 align-self-center text-center">付款狀態</ol>
                        <ol class="col-3 align-self-center text-center">出貨狀態</ol>
                    </li>
                </div>
                <div class="col-12 d-md-none">

                </div>
            </div>
        </div>
    </div>
</div>