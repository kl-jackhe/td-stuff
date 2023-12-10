<div id="productApp" role="main" class="main pt-signinfo">
    <section id="product_rejust">
        <div>
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
                <h1 class=""><span>夥伴商城</span></h1>
                <!-- 篩選清單 -->
                <ul v-if="searchText === ''" class="menu-main">
                    <li v-for="category in products_categories" :key="category.product_category_id">
                        <input type="button" :value="'>&nbsp;' + category.product_category_name" @click="filterByCategory(category.product_category_id)" :class="{ category_btn: true, active: selectedCategoryId === category.product_category_id}">
                    </li>
                </ul>
                <ul v-else class="menu-main">
                    <li>
                        <input type="button" value=">&nbsp;搜尋結果" :class="{ category_btn: true, active: true}">
                    </li>
                </ul>
                <!-- 篩選清單 -->
            </div>
            <div class="section-contents">
                <div class="container">
                    <h1><span>{{ pageTitle }}</span></h1>
                </div>

                <!-- 全部商品 -->
                <div class="container">
                    <!-- Product Start -->
                    <div class="row">
                        <div id="data" class="col-12">
                            <div class="text-center">
                                <div class="row" id="product_index">
                                    <div class="product_view_style_out col-6 col-md-4" v-for="self in filteredProducts.slice(pageStart, pageEnd)" :key="self.post_id">
                                        <a @click="showProductDetails(self)">
                                            <div class="product_view_style_in">
                                                <img class="product_img_style" :src="'/assets/uploads/' + self.product_image">
                                                <div class="product_name">
                                                    <span>{{ self.product_name }}</span>
                                                    <p class="price" v-if="self.sales_status === '0'">【現貨】 $ {{ self.product_price }}</p>
                                                    <p class="price" v-else-if="self.sales_status === '1'">【售完】 $ {{ self.product_price }}</p>
                                                    <p class="price" v-else-if="self.sales_status === '2'">【預購】 $ {{ self.product_price }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="filteredProducts.length === 0" class="col-12 text-center">
                        <p style="height: 300px;">------目前暫無對應商品------</p>
                    </div>
                    <!-- Product End -->

                    <!-- Pagination -->
                    <?php require('ajax-data.php'); ?>
                </div>
            </div>
        </div>
        <!-- 商品詳情 -->
        <div ref="productDetail" v-if="selectedProduct" class="productDetailStyle">
            <!-- 關閉商品詳情 -->
            <span class="returnBtn" @click="hideProductDetails">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
            <div class="productDetailTitle">
                <h1>商品詳情</h1>
            </div>
            <div class="row productDetail">
                <div class="col-bg-12 col-md-6 col-lg-6">
                    <img class="product_img_style" :src="'/assets/uploads/' + selectedProduct.product_image">
                </div>
                <div class="col-bg-12 col-md-6 col-lg-6">
                    <div class="row">
                        <!--商品名稱-->
                        <h2 class="cargoText col-bg-12 col-md-12 col-lg-12">{{ selectedProduct.product_name }}</h2>
                        <!--價格-->
                        <div class="cargoText col-bg-12 col-md-12 col-lg-12">
                            <!--一律顯示原售價-->
                            <div class="clearfix">
                                <div class="item">售價</div>
                                <div class="info">$ {{ selectedProduct.product_price }}</div>
                            </div>
                        </div>
                        <!--商品簡介:多行文字欄位-->
                        <div class="cargoText col-bg-12 col-md-12 col-lg-12">
                            變種吉娃娃 2<br>
                            Godgwawa 2<br>
                            <br>
                            商品詳細規格：<br>
                            尺寸：每隻角色約5-7cm​<br>
                            材質：PVC塑膠<br>
                            售價：一中盒720元 / 一中盒必含基礎5款+1款隨機重複基礎款或夥伴賞。
                        </div>
                        <select class="cargoBtn col-bg-12 col-md-12 col-lg-12">
                            <option value="">請選擇規格</option>
                            <option selected="">變種吉娃娃2 一中盒(內含6小盒)</option>
                        </select>
                        <div class="row cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span class="col-2 cargoCountBtn" @click="decrement"><i class="fa fa-minus" aria-hidden="true"></i></span>
                            <input class="col-8 cargoCountText" type="text" v-model="quantity">
                            <span class="col-2 cargoCountBtn" @click="increment"><i class="fa fa-plus" aria-hidden="true"></i></span>
                        </div>
                        <div class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span class="cargoClick explainBtn"><i class="fas fa-truck"></i>運費說明</span>
                        </div>
                        <div class="cargoBtn col-bg-12 col-md-12 col-lg-12">
                            <span class="cargoClick buyBtn"><i class="fas fa-cart-plus"></i>馬上購買</span>
                        </div>
                        <div class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span class="cargoClick cartBtn"><i class="fas fa-cart-plus"></i>加入購物車</span>
                        </div>
                        <div class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span class="cargoClick likeBtn"><i class="fas fa-heart"></i>加入追蹤</span>
                        </div>
                    </div>
                </div>
                <!-- Cargo description -->
                <div class="col-12 cargoDescription">
                    <div v-html="selectedProduct.product_description"></div>
                </div>
                <!-- Add a button for scrolling to the top -->
                <span @click="scrollToProductDetailTop" class="scrollToProductDetailTop"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
            </div>
        </div>
        <?php // require('product-detail.php'); 
        ?>
    </section>
</div>

<script>
    const productApp = Vue.createApp({
        data() {
            return {
                selectedProduct: null, // 選中的商品
                selectedCategoryId: 1, // 目前顯示頁面主題, null為全部顯示
                products: <?php echo json_encode($products); ?>, // products資料庫所有類及項目
                products_categories: <?php echo json_encode($product_category); ?>, // products_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 9, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                showProductDetailsBox: false, // 商品詳情BOX
                isScrollAtTop: true, // Flag to determine if scroll is at the top
                quantity: 1, // 商品選擇數量
            };
        },
        mounted() {
            if (this.products_categories.length > 0) {
                this.selectedCategoryId = this.products_categories[0].product_category_id;
                this.pageTitle = this.products_categories[0].product_category_name;
            }
            // Add a scroll event listener to check scroll position
        },
        computed: {
            // 篩選&搜尋
            filteredProducts() {
                if (this.searchText.trim() !== '') {
                    this.pageTitle = "搜尋結果"
                    this.isNavOpen = false;
                    return this.filterproductsBySearch();
                } else {
                    if (this.pageTitle === "搜尋結果") {
                        this.clearSearch();
                    }
                    return this.filterproductsByCategory();
                }
            },
            // 頁碼
            limitedPages() {
                const maxPages = 5;
                const middlePage = Math.ceil(maxPages / 2);

                if (this.totalPages <= maxPages) {
                    return Array.from({
                        length: this.totalPages
                    }, (_, i) => i + 1);
                } else if (this.currentPage <= middlePage) {
                    return Array.from({
                        length: maxPages
                    }, (_, i) => i + 1);
                } else if (this.currentPage > this.totalPages - middlePage) {
                    return Array.from({
                        length: maxPages
                    }, (_, i) => this.totalPages - maxPages + i + 1);
                } else {
                    return Array.from({
                        length: maxPages
                    }, (_, i) => this.currentPage - middlePage + i + 1);
                }
            },
            totalPages() {
                return Math.ceil(this.filteredProducts.length / this.perpage);
            },
            pageStart() {
                return (this.currentPage - 1) * this.perpage
                //取得該頁第一個值的index
            },
            pageEnd() {
                const end = this.currentPage * this.perpage;
                return Math.min(end, this.filteredProducts.length);
                //取得該頁最後一個值的index
            },
        },
        methods: {
            // 選中獨立商品
            showProductDetails(product) {
                this.selectedProduct = product;
                this.isDetailContentVisible = true; // 詳細內容視窗可見
            },
            hideProductDetails() {
                this.selectedProduct = null;
                this.isDetailContentVisible = false; // 詳細內容視窗不可見
            },
            // 商品數量選擇
            increment() {
                // 當按下 "+" 按鈕時，增加數量
                this.quantity += 1;
            },
            decrement() {
                // 當按下 "-" 按鈕時，減少數量，但確保數量不小於 1
                this.quantity = Math.max(1, this.quantity - 1);
            },
            // 搜尋攔篩選
            filterproductsBySearch() {
                return this.products.filter(product => {
                    const titleMatch = product.product_name.toLowerCase().includes(this.searchText.toLowerCase());
                    const contentMatch = product.product_description.toLowerCase().includes(this.searchText.toLowerCase());
                    return titleMatch || contentMatch;
                });
            },
            // 按鈕篩選
            filterproductsByCategory() {
                if (this.selectedCategoryId == 1) {
                    return this.products;
                } else {
                    return this.products.filter(product => product.product_category_id === this.selectedCategoryId);
                }
            },
            filterByCategory(categoryId) {
                this.selectedCategoryId = categoryId;
                this.currentPage = 1; // 將頁碼設置為1
                const selectedCategory = this.products_categories.find(category => category.product_category_id === categoryId);
                this.pageTitle = selectedCategory.product_category_name;
            },
            // 頁碼
            setPage(page) {
                if (page <= 0 || page > this.totalPages || (page === this.totalPages && this.currentPage === this.totalPages)) {
                    return;
                }
                this.isNavOpen = false;
                this.currentPage = page;
                this.scrollToTop();
            },
            // 清除搜尋攔
            clearSearch() {
                this.searchText = '';
                this.filterByCategory(this.products_categories[0].product_category_id); // 在清除搜尋欄後自動執行第一個篩選
            },
            // 篩選清單呼叫
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
            // 將頁面滾動到頂部
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // 若要有平滑的滾動效果
                });
            },
            // Method to scroll to the top of the productDetailStyle box
            scrollToProductDetailTop() {
                // Get the productDetailStyle element
                const productDetailStyle = this.$refs.productDetail;

                // Scroll to the top of the productDetailStyle element
                if (productDetailStyle) {
                    productDetailStyle.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        },
    });
    productApp.mount('#productApp');
</script>