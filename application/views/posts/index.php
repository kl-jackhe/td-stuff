<div id="postApp" role="main" class="main pt-signinfo">
    <section id="post_rejust">
        <div class="searchContainer container">
            <!-- 篩選清單呼叫鈕 -->
            <div class="left-content">
                <span v-if="!isNavOpen" id="menu-btn" @click="toggleNav">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </span>
                <span v-else id="menu-btn" :class="{ 'active': isBtnActive }" @click="toggleNav">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
            </div>
            <!-- 篩選清單呼叫鈕 -->

            <!-- 搜尋攔 -->
            <div class="right-content breadcrumb">
                <input type="text" class="search" placeholder="搜尋欄" v-model="searchText">
                <span v-if="searchText !== ''" @click="clearSearch" class="clear-search"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
            <!-- 搜尋攔 -->
        </div>
        <div :class="{ 'section-sidemenu': true, 'nav-open': isNavOpen }">
            <h1 class=""><span>最新消息</span></h1>
            <!-- 篩選清單 -->
            <ul v-if="searchText === ''" class="menu-main">
                <li v-for="category in posts_categorys" :key="category.post_category_id">
                    <input type="button" :value="'>&nbsp;' + category.post_category_name" @click="filterByCategory(category.post_category_id)" :class="{ category_btn: true, active: selectedCategoryId === category.post_category_id}">
                </li>
            </ul>
            <ul v-else class="menu-main">
                <li>
                    <input type="button" value=">&nbsp;搜尋結果" :class="{ category_btn: true, active: true}">
                </li>
            </ul>
            <!-- 篩選清單 -->
        </div>
        <span class="cargoClick explainBtn magnific-popup-trigger"><i class="fas fa-truck"></i>運費說明</span>
        <div id="shipping-popup" class="mfp-hide">
            <!-- Your shipping information goes here -->
            <p>Shipping details...</p>
        </div>
    </section>
</div>

<script>
    // 調用 Magnific Popup，這裡僅供參考，具體應根據你的需求調整
    const postApp = Vue.createApp({
        mounted() {
            $('.magnific-popup-trigger').magnificPopup({
                type: 'inline',
                midClick: true, // Allow opening popup on middle mouse click
                items: {
                    src: '#shipping-popup', // ID of the popup content
                    type: 'inline'
                },
                mainClass: 'mfp-zoom-in', // Add a zoom-in effect if you like
            });
        },
    });
    postApp.mount('#postApp');

    // $(document).ready(function() {
    //     $('.testGraph').magnificPopup({
    //         type: 'image'
    //     });
    // });
</script>