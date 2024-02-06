<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberOrderContent" id="row">
                <div class="orderDetailButton">
                    <span class="orderBtn" @click="clearSelectedMail()"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回列表</span>
                </div>
                <div class="col-12 text-center">
                    <span class="memberTitleMember">MAIL<span class="memberTitleLogin">&nbsp;CONTENT</span></span>
                </div>
                <div class="col-12 memberTitleChinese text-center">郵件內容</div>
                <div class="col-12 selectedOrderHeaderBox">
                    <span class="selectedOrderHeader">&nbsp;送信時間：<i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ selectedMail.datetime }}</span>
                    <br>
                    <span class="selectedOrderHeader orderNumber">&nbsp;回復時間：<i class="fa fa-clock" aria-hidden="true"></i>&nbsp;{{ (selectedMail.datetime2 != null) ? selectedMail.datetime2 : '尚未回覆' }}</span>
                </div>
                <div class="col-12 orderContentHeader">
                    <i class="far fa-list-alt"></i>&nbsp;夥伴郵件
                </div>
                <div class="row col-12 mailContentBox">
                    <span class="col-12 mailContentTitle"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;主旨：</span>
                    <span class="col-12"><hr></span>
                    <span class="col-12 mailContent">{{ selectedMail.desc1 }}</span>
                </div>
                <div class="row col-12 mailContentBox">
                    <span class="col-12 mailContentTitle"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;回復：</span>
                    <span class="col-12"><hr></span>
                    <span class="col-12 mailContent">{{ (selectedMail.desc2 != null) ? selectedMail.desc2 : '尚未回覆' }}</span>
                </div>
                <!-- <div class="col-12 M_order d-none d-md-block">
                    <span> 主旨：{{ selectedMail.desc1 }}</span>
                </div> -->
                <!-- <div class="col-12 d-md-none">
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
                </div> -->
            </div>
        </div>
    </div>
</div>