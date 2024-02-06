<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">PARTNERT<span class="memberTitleLogin">&nbsp;MAIL</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <div v-if="!mail" class="noneOrder">
                    <span class="">目前無任何郵件資料</span>
                </div>
                <!-- Display for screens larger than or equal to 767px -->
                <div v-if="mail" class="d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-6 align-self-center text-center"><i class="fa fa-envelope-open" aria-hidden="true"></i>&nbsp;信件內容</ol>
                        <ol class="col-3 align-self-center text-center"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;傳送時間</ol>
                        <ol class="col-3 align-self-center text-center"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;回復時間</ol>
                    </li>
                    <a v-for="self in mail" class="orderInformation" @click="showMailDetail(self)">
                        <li class="row">
                            <ol class="col-6 align-self-center text-center mailDescription">{{ self.desc1 }}</ol>
                            <ol class="col-3 align-self-center text-center">{{ self.datetime.substr(0,10) }}</ol>
                            <ol class="col-3 align-self-center text-center redContent">{{ (self.datetime2 != null) ? self.datetime2.substr(0,10) : '尚未回覆' }}</ol>
                        </li>
                    </a>
                </div>
                <!-- Your alternative display for small screens goes here -->
                <div v-if="mail" class="d-md-none">
                    <li id="orderListHeader" class="row">
                        <ol class="col-7 align-self-center text-center"><i class="fa fa-envelope-open" aria-hidden="true"></i>&nbsp;信件內容</ol>
                        <ol class="col-5 align-self-center text-center"><i class="fa fa-clock" aria-hidden="true"></i>&nbsp;回復時間</ol>
                    </li>
                    <a v-for="self in mail" class="orderInformation" @click="showMailDetail(self)">
                        <li class="row">
                            <ol class="col-7 align-self-center text-center mailDescription">{{ self.desc1 }}</ol>
                            <ol class="col-5 text-center">{{ (self.datetime2 != null) ? self.datetime2 : '尚未回覆' }}</ol>
                        </li>
                    </a>
                </div>
                <?php require('pagination.php'); ?>
            </div>
        </div>
    </div>
</div>