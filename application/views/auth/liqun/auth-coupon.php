<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">COUPON<span class="memberTitleLogin">&nbsp;INFORMATION</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <div v-if="!coupon" class="noneOrder">
                    <span class="">目前無任何折扣券資料</span>
                </div>
                <!-- Display for screens larger than or equal to 767px -->
                <div v-if="coupon" class="d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-7 align-self-center text-center">優惠券名稱</ol>
                        <ol class="col-2 align-self-center text-center">可用次數</ol>
                        <ol class="col-3 align-self-center text-center">到期日</ol>
                    </li>
                    <a v-for="self in coupon.slice(pageStart, pageEnd)" class="orderInformation">
                        <li class="row">
                            <ol class="col-7 align-self-center text-center">
                                <span><i class="fa fa-search-plus"></i>&nbsp;{{ self.name }}</span>
                            </ol>
                            <ol class="col-2 align-self-center text-center">{{ (self.use_limit_enable == '1') ? self.use_limit_number : '無限制' }}</ol>
                            <ol class="col-3 align-self-center text-center">{{ self.discontinued_at }}</ol>
                        </li>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>