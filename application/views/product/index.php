<div id="productApp" role="main" class="main pt-signinfo">
    <section id="product_rejust">
        <div class="searchContainer container">
            <div class="left-content">
                <span id="menu-btn" @click="toggleNav" :class="{ 'active': isBtnActive }"><i class="fa fa-bars" aria-hidden="true"></i></span>
            </div>
            <div class="right-content breadcrumb">
                <input type="text" class="search" placeholder="搜尋欄" v-model="searchText">
                <span v-if="searchText !== ''" @click="clearSearch" class="clear-search"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
        </div>
        <div :class="{ 'section-sidemenu': true, 'nav-open': isNavOpen }">
            <h1 class=""><span>夥伴商城</span></h1>
            <!-- menu-main為第一層選單,menu-sub為第二層選單,menu-grand為第三層選單 -->
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
        </div>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div class="container">
                <!-- Pagination -->
                <ul v-if="totalPages !== 0" class="pagination">
                    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(1)">
                        <a class="page_link" href="" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(currentPage-1)">
                        <a class="page_link" href="" aria-label="Previous">
                            <span aria-hidden="true">&lsaquo;</span>
                        </a>
                    </li>
                    <li v-for="n in limitedPages" :key="n" :class="{'active': (currentPage === n)}" @click.prevent="setPage(n)">
                        <a class="page_link" href="">{{ n }}</a>
                    </li>
                    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(currentPage+1)">
                        <a class="page_link" href="" aria-label="Next">
                            <span aria-hidden="true">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(totalPages)">
                        <a class="page_link" href="" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
                <!-- Pagination -->

                <!-- Product Start -->
                <div class="row">
                    <div id="data" class="col-12">
                        <div class="text-center">
                            <div class="row justify-content-center" id="product_index">
                                <div class="product_view_style_out col-6 col-md-4" v-for="self in filteredProducts.slice(pageStart, pageEnd)" :key="self.post_id">
                                    <a :href="'/product/view/' + self.product_id">
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
                <ul v-if="totalPages !== 0" class="pagination" id="pagination_bottom">
                    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(1)">
                        <a class="page_link" href="" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(currentPage-1)">
                        <a class="page_link" href="" aria-label="Previous">
                            <span aria-hidden="true">&lsaquo;</span>
                        </a>
                    </li>
                    <li v-for="n in limitedPages" :key="n" :class="{'active': (currentPage === n)}" @click.prevent="setPage(n)">
                        <a class="page_link" href="">{{ n }}</a>
                    </li>
                    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(currentPage+1)">
                        <a class="page_link" href="" aria-label="Next">
                            <span aria-hidden="true">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(totalPages)">
                        <a class="page_link" href="" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
                <!-- Pagination -->
            </div>
        </div>
    </section>
</div>

<script>
    const productApp = Vue.createApp({
        data() {
            return {
                selectedCategoryId: 1, // 目前顯示頁面主題, null為全部顯示
                products: <?php echo json_encode($products); ?>, // products資料庫所有類及項目
                products_categories: <?php echo json_encode($product_category); ?>, // products_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 9, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            };
        },
        mounted() {
            if (this.products_categories.length > 0) {
                this.selectedCategoryId = this.products_categories[0].product_category_id;
                this.pageTitle = this.products_categories[0].product_category_name;
            }

        },
        computed: {
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
            }
        },
        methods: {
            filterproductsBySearch() {
                return this.products.filter(product => {
                    const titleMatch = product.product_name.toLowerCase().includes(this.searchText.toLowerCase());
                    const contentMatch = product.product_description.toLowerCase().includes(this.searchText.toLowerCase());
                    return titleMatch || contentMatch;
                });
            },
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
            customExcerpt(content, maxLength) {
                // 使用 DOMParser 解析 HTML 字符串
                const doc = new DOMParser().parseFromString(content, 'text/html');

                // 從解析後的文檔中提取純文本內容
                const plainText = doc.body.textContent || "";

                // 截取文本，確保不超過指定的最大長度
                const truncatedText = plainText.length > maxLength ?
                    plainText.substring(0, maxLength) + "..." :
                    plainText;

                return truncatedText;
            },
            setPage(page) {
                if (page <= 0 || page > this.totalPages || (page === this.totalPages && this.currentPage === this.totalPages)) {
                    return;
                }
                this.isNavOpen = false;
                this.currentPage = page;

                // 將頁面滾動到頂部
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // 若要有平滑的滾動效果
                });
            },
            clearSearch() {
                this.searchText = '';
                this.filterByCategory(this.products_categories[0].product_category_id); // 在清除搜尋欄後自動執行第一個篩選
            },
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
        },
    });
    productApp.mount('#productApp');
</script>