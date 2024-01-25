<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">TRACKING<span class="memberTitleLogin">&nbsp;LIST</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <div v-if="!followData || (followData && !followData.some(container => Object.keys(container).length > 0))" class="noneOrder">
                    <span class="">目前無任何追蹤資料</span>
                </div>
                <!-- Display for screens larger than or equal to 767px -->
                <div v-else class="M_order d-none d-md-block">
                    <li id="orderListHeader" class="row">
                        <ol class="col-8 align-self-center text-center">商品名稱</ol>
                        <ol class="col-2 align-self-center text-center">刪除</ol>
                        <ol class="col-2 align-self-center text-center">購買</ol>
                    </li>
                    <a v-for="self in followData" class="Information">
                        <li v-if="self" class="row">
                            <ol class="col-2 align-self-center text-center">
                                <img :src="'/assets/uploads/' + self.product_image" style="width: 100%;">
                            </ol>
                            <ol class="col-6 align-self-center">
                                <span>{{ self.product_name }}</span>
                            </ol>
                            <ol class="col-2 align-self-center text-center">
                                <span class="trackingButton" @click="delect_follow(self.product_id)"><i class="fa fa-trash" aria-hidden="true"></i></span>
                            </ol>
                            <ol class="col-2 align-self-center text-center">
                                <span class="trackingButton" @click="href_product(self.product_id)"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                            </ol>
                        </li>
                    </a>
                </div>
                <!-- Your alternative display for small screens goes here -->
                <div v-if="order" class="d-md-none">

                </div>
                <?php // require('pagination.php'); 
                ?>
            </div>
        </div>
    </div>
</div>