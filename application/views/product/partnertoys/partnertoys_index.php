<div v-cloak id="productApp" role="main" class="main pt-signinfo">
    <section class="container sectionRejust">
        <!-- Menu -->
        <?php if (!empty($product_category)) : ?>
            <?php require('product-menu.php'); ?>
        <?php endif; ?>
        <?php if (!empty($products)) : ?>
            <div class="section-contents">
                <div class="container">
                    <h1><span>{{ pageTitle }}</span></h1>
                </div>
                <!-- 全部商品 -->
                <div class="container">
                    <!-- Product Start -->
                    <div class="row">
                        <div class="product_view_style_out col-6 col-md-6 col-lg-4" v-for="(self, index) in filteredProducts.slice(pageStart, pageEnd)" :key="self.post_id" :class="{ 'productRightPadding': index % 2 === 0, 'productLeftPadding': index % 2 !== 0 }">
                            <a class="productTrigger" @click="showProductDetails(self.product_id)">
                                <div class="product_view_style_in">
                                    <div class="productImg">
                                        <img class="product_img_style" :src="'/assets/uploads/' + self.product_image">
                                    </div>
                                    <div class="product_name">
                                        <span>{{ self.product_name }}</span>
                                        <p class="price">$&nbsp;{{ self.product_price }}</p>
                                        <!-- <p class="price" v-if="self.sales_status === '0'">【現貨】$ {{ self.product_price }}</p>
                                        <p class="price" v-else-if="self.sales_status === '1'">【售完】$ {{ self.product_price }}</p>
                                        <p class="price" v-else-if="self.sales_status === '2'">【預購】$ {{ self.product_price }}</p> -->
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div v-if="filteredProducts.length === 0" class="col-12 text-center">
                        <p style="height: 300px;">------目前暫無對應商品------</p>
                    </div>
                    <!-- Product End -->

                    <!-- Pagination -->
                    <?php require('pagination.php'); ?>
                </div>
            </div>
    </section>
<?php endif; ?>
</div>

<script>
    const productApp = Vue.createApp({
        data() {
            return {
                getCategory: <?php echo json_encode($category); ?>, // 若透過header或footer篩選
                getSearchIcon: <?php echo json_encode($searchIcon); ?>, // 若透過搜尋按鈕進來
                selectedCategoryId: null, // 目前顯示頁面主題
                products: <?php echo json_encode(!empty($products) ? $products : ''); ?>, // products資料庫所有類及項目
                products_categories: <?php echo json_encode(!empty($product_category) ? $product_category : ''); ?>, // products_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 12, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                getSearchText: <?php echo json_encode($searchText); ?>, // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                hiddenSearch: false, // search-box
            };
        },
        mounted() {
            // init state
            if (this.products_categories && this.products_categories.length > 0) {
                this.currentPage = parseInt(<? echo json_encode(!empty($current_page) ? $current_page : ''); ?>); // 目前page
                this.selectedCategoryId = 0;
                this.pageTitle = '全部商品';

                // category init
                if (this.getCategory && this.getCategory > 0) {
                    this.selectedCategoryId = this.getCategory;
                    const tmpSet = this.products_categories.find(self => self.sort === this.getCategory);
                    this.pageTitle = tmpSet.name;
                }

                // search bar init
                if (this.getSearchIcon == 'true') {
                    this.hiddenSearch = true;
                }

                // search content init
                if (this.getSearchText && this.getSearchText.length > 0) {
                    this.hiddenSearch = true;
                    this.searchText = this.getSearchText;
                    this.filterproductsBySearch();
                }

                // 監聽是否有按下搜尋
                $(document).on('toggleSearch', () => {
                    // 处理事件触发后的逻辑
                    // 显示搜寻栏的逻辑
                    if (!this.hiddenSearch) {
                        this.scrollToTop();
                    }
                    this.hiddenSearch = !this.hiddenSearch;
                });
            }

            // console.log(this.getCategory);
            // console.log(this.getSearchIcon);
            // console.log(this.getSearchText);
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
            showProductDetails(selected) {
                if (selected != null) {
                    $.ajax({
                        url: '/encode/getDataEncode/selectedProduct',
                        type: 'post',
                        data: {
                            selectedProduct: selected,
                        },
                        success: (response) => {
                            if (response) {
                                if (response.result == 'success') {
                                    window.location.href = <?= json_encode(base_url()); ?> + 'product/product_detail/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                }
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
                if (this.selectedCategoryId == 0) {
                    return this.products;
                } else {
                    return this.products.filter(product => product.product_category_id === this.selectedCategoryId);
                }
            },
            filterByCategory(categoryId) {
                if (categoryId != null) {
                    $.ajax({
                        url: '/encode/getDataEncode/category',
                        type: 'post',
                        data: {
                            category: categoryId,
                        },
                        success: (response) => {
                            if (response) {
                                if (response.result == 'success') {
                                    window.location.href = <?= json_encode(base_url()) ?> + 'product/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                } else {
                    window.location.href = <?= json_encode(base_url()) ?> + 'product' + (categoryId != null ? '?id=' + categoryId : '');
                }
            },
            // 頁碼
            setPage(page) {
                // console.log(page);
                if (page <= 0 || page > this.totalPages || (page > this.totalPages && this.currentPage === this.totalPages) || (page === this.totalPages && this.currentPage === this.totalPages)) {
                    this.scrollToTop();
                    return;
                }
                this.isNavOpen = false;
                this.currentPage = page;

                // 触发自定义事件
                if (this.searchText != '') {
                    $.ajax({
                        url: '/encode/getDataEncode/searchText',
                        type: 'post',
                        data: {
                            searchText: this.searchText,
                        },
                        success: (response) => {
                            if (response) {
                                if (response.result == 'success') {
                                    window.location.href = <?= json_encode(base_url()) ?> + 'product/index/' + this.currentPage + '/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                } else {
                    if (this.getCategory != '') {
                        $.ajax({
                            url: '/encode/getDataEncode/category',
                            type: 'post',
                            data: {
                                category: this.getCategory,
                            },
                            success: (response) => {
                                if (response) {
                                    if (response.result == 'success') {
                                        window.location.href = <?= json_encode(base_url()) ?> + 'product/index/' + this.currentPage + '/?' + response.src;
                                    } else {
                                        console.log('error.');
                                    }
                                } else {
                                    console.log(response);
                                }
                            },
                        });
                    } else {
                        window.location.href = <?= json_encode(base_url()) ?> + 'product/index/' + this.currentPage;
                    }
                }
            },
            // 清除搜尋攔
            clearSearch() {
                this.searchText = '';
                this.currentPage = 1;
                this.selectedCategoryId = 0;
                this.pageTitle = '全部商品';
                this.filterproductsByCategory(); // 在清除搜尋欄後自動執行第一個篩選
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
        },
    });
    productApp.mount('#productApp');
</script>