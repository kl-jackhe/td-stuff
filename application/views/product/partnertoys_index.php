<div id="productApp" role="main" class="main pt-signinfo">
    <section class="sectionRejust">
        <!-- Menu -->
        <?php require('product-menu.php'); ?>

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
                                    <a class="productMagnificPopupTrigger" @click="showProductDetails(self)">
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
                <?php require('pagination.php'); ?>
            </div>
        </div>
        <!-- 商品詳情 -->
        <div ref="productDetail" id="productDetailStyle" class="productDetailStyle" v-if="selectedProduct">
            <div class="detailTitle">
                <h1>【{{ selectedProductCategoryId[0].product_category_name }}】</h1>
            </div>
            <div class="row productDetail">
                <div class="col-bg-12 col-md-6 col-lg-6">
                    <img class="product_img_style" :src="'/assets/uploads/' + selectedProduct.product_image">
                </div>
                <div class="col-bg-12 col-md-6 col-lg-6">
                    <div class="row">
                        <!--商品名稱-->
                        <h1 class="cargoTitle col-bg-12 col-md-12 col-lg-12">{{ selectedProduct.product_name }}</h1>
                        <!--商品簡介:多行文字欄位-->
                        <!-- <div class="cargoText col-bg-12 col-md-12 col-lg-12">
                            變種吉娃娃 2<br>
                            Godgwawa 2<br>
                            <br>
                            商品詳細規格：<br>
                            尺寸：每隻角色約5-7cm​<br>
                            材質：PVC塑膠<br>
                            售價：一中盒720元 / 一中盒必含基礎5款+1款隨機重複基礎款或夥伴賞。
                        </div> -->

                        <!-- 有方案顯示 -->
                        <!-- 會判斷點選的商品是否有方案 -->
                        <!--價格-->
                        <div class="cargoText col-bg-12 col-md-12 col-lg-12">
                            <div v-if="selectedProductCombine && selectedProductCombine.product_id === selectedProduct.product_id && (selectedProductCombine.current_price !== 0)">
                                <div class="item">方案價: $ {{ selectedProductCombine.current_price }}</div>
                            </div>
                            <div v-else-if="selectedCombine.length !== 0">
                                <div class="item">❌尚未選擇方案</div>
                            </div>
                            <div v-else class="paddingFixTop">
                                <div class="item text-center">⭐該商品尚未新增方案⭐</div><br>
                                <div class="item text-center">⭐有任何疑問請洽客服⭐</div><br>
                                <div class="item text-center">⭐我們將盡速為您服務⭐</div><br>
                            </div>
                        </div>
                        <!--方案選擇-->
                        <select v-if="selectedCombine.length !== 0" @change="updateSelectedCombine($event)" id="combineSelect" class="cargoBtn col-bg-12 col-md-12 col-lg-12">
                            <option value="請選擇方案" select="">請選擇方案</option>
                            <option v-for="combineItem in selectedCombine" :key="combineItem.id" :value="combineItem.name">
                                {{ combineItem.name }}
                            </option>
                        </select>
                        <!--商品數量-->
                        <div v-if="selectedCombine.length !== 0 && selectedProductCombine" class="row cargoBtn col-12">
                            <span class="col-2 cargoCountBtn" @click="decrement"><i class="fa fa-minus" aria-hidden="true"></i></span>
                            <input class="col-8 cargoCountText" type="text" v-model="quantity">
                            <span class="col-2 cargoCountBtn" @click="increment"><i class="fa fa-plus" aria-hidden="true"></i></span>
                        </div>
                        <!--購買按鍵-->
                        <div v-if="selectedCombine.length !== 0 && selectedProductCombine" class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span v-if="selectedProduct.sales_status == 0" class="cargoClick buyBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>馬上購買</span>
                            <span v-else-if="selectedProduct.sales_status == 2" class="cargoClick buyBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>馬上預購</span>
                            <span v-else class="cargoClick buyBtn"><i class="fas fa-cart-plus"></i>商品售完</span>
                        </div>
                        <!--加入購物車-->
                        <div v-if="selectedCombine.length !== 0 && selectedProductCombine" class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span v-if="selectedProduct.sales_status === 0 || selectedProduct.sale_status === 2" class="cargoClick cartBtn"><i class="fas fa-cart-plus"></i>加入購物車</span>
                            <span v-else class="cargoClick cartBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>加入購物車</span>
                        </div>
                        <!--追蹤商品-->
                        <!-- <div v-if="selectedCombine.length !== 0 && selectedProductCombine" class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span class="cargoClick likeBtn"><i class="fas fa-heart"></i>加入追蹤</span>
                        </div> -->
                        <!--運費說明-->
                        <!-- <div v-if="selectedCombine.length !== 0 && selectedProductCombine" class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                            <span class="cargoClick explainBtn"><i class="fas fa-truck"></i>運費說明</span>
                        </div> -->
                        <!-- 有方案顯示 -->

                        <!-- 無方案顯示(聯絡方式) -->
                        <?php require('product-contact.php'); ?>
                        <!-- 無方案顯示 -->
                    </div>
                </div>
                <!-- Cargo description -->
                <div class="col-12 cargoDescription">
                    <div v-html="selectedProduct.product_description"></div>
                </div>
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
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                selectedProduct: null, // 選中的商品
                selectedProductCombine: null, // 選中商品的規格
                selectedProductCategoryId: null, // 選中商品的類別
                selectedCombine: null, // 選中商品的所有規格
                selectedCombineItem: null, // 選中商品的所有單位
                selectedCategoryId: null, // 目前顯示頁面主題
                combine: <?php echo json_encode($productCombine); ?>, // 取得指定商品之combine物件
                combine_item: <?php echo json_encode($productCombineItem); ?>, // 取得指定商品之combine_item物件
                products: <?php echo json_encode($products); ?>, // products資料庫所有類及項目
                products_categories: <?php echo json_encode($product_category); ?>, // products_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 12, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                quantity: 1, // 商品選擇數量
            };
        },
        watch: {
            // Watch for changes in filteredProducts and update Magnific Popup
            filteredProducts: function() {
                this.$nextTick(function() {
                    this.initMagnificPopup();
                });
            },
        },
        mounted() {
            // Initialize Magnific Popup on mount
            this.initMagnificPopup();
            // init btn state
            if (this.products_categories && this.products_categories.length > 0) {
                this.currentPage = parseInt(<? echo json_encode($current_page); ?>); // 目前page
                this.selectedCategoryId = 0;
                this.pageTitle = '全部商品';
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    const tmpSet = this.products_categories.filter(self => self.product_category_id === this.getID);
                    this.pageTitle = tmpSet[0].product_category_name;
                }
            }
            // 商品詳細資訊
            $('.productMagnificPopupTrigger').magnificPopup({
                type: 'inline',
                midClick: true, // Allow opening popup on middle mouse click
                items: {
                    src: '#productDetailStyle', // ID of the popup content
                    type: 'inline'
                },
                mainClass: 'mfp-zoom-in', // Add a zoom-in effect if you like
            });
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
            // Initialize Magnific Popup
            initMagnificPopup() {
                $('.productMagnificPopupTrigger').magnificPopup({
                    type: 'inline',
                    midClick: true,
                    items: {
                        src: '#productDetailStyle',
                        type: 'inline',
                    },
                    mainClass: 'mfp-zoom-in',
                });
            },
            // 更新選擇方案對應的價格(selected option)
            updateSelectedCombine(event) {
                const selectedCombineName = event.target.value;
                const selectedCombineItem = this.selectedCombine.find(item => item.name === selectedCombineName);
                this.selectedProductCombine = selectedCombineItem;
            },
            // 選中獨立商品
            showProductDetails(selected) {
                // 初始化方案選項
                this.quantity = 1;

                this.selectedProductCombine = null;
                $('#combineSelect').val('請選擇方案');
                this.selectedProductCategoryId = this.products_categories.filter(category => category.product_category_id === selected.product_category_id);

                // 抓被點到的商品
                this.selectedProduct = selected;

                // 查找combine中的對應物件
                this.selectedCombine = this.combine.filter(item => item.product_id === selected.product_id) || [];

                // 查找combine_item中的對應物件
                this.selectedCombineItem = this.combine_item.filter(item => item.product_id === selected.product_id) || [];

                // 檢查bug
                // console.log(this.selectedCombine, this.selectedCombineItem);
            },
            // 商品數量選擇
            increment() {
                // 當按下 "+" 按鈕時，增加數量
                this.quantity = parseInt(this.quantity, 10);
                this.quantity += 1;
            },
            decrement() {
                // 當按下 "-" 按鈕時，減少數量，但確保數量不小於 1
                this.quantity = parseInt(this.quantity, 10);
                this.quantity = Math.max(1, this.quantity - 1);
            },
            // 加入購物車(待修)
            add_cart() {
                if (this.quantity < 1) {
                    alert('商品不能低於1個');
                    return;
                }
                $.ajax({
                    url: "/cart/add_combine",
                    method: "POST",
                    data: {
                        combine_id: this.selectedProductCombine.id,
                        qty: this.quantity,
                        specification_name: 'Testname',
                        specification_id: 'Testid',
                        specification_qty: 'Textqty',
                    },
                    success: function(data) {
                        if (data == 'contradiction') {
                            alert('預購商品不得與其他類型商品一並選購，敬請見諒。');
                        } else {
                            alert('加入成功');
                        }
                        get_cart_qty();
                    }
                });
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
                window.location.href = <?= json_encode(base_url()) ?> + 'product/index' + (categoryId != null ? '?id=' + categoryId : '');
            },
            // 頁碼
            setPage(page) {
                console.log(page);
                if (page <= 0 || page > this.totalPages || (page > this.totalPages && this.currentPage === this.totalPages) || (page === this.totalPages && this.currentPage === this.totalPages)) {
                    return;
                }
                this.isNavOpen = false;
                this.currentPage = page;

                window.location.href = <?= json_encode(base_url()) ?> + 'product/index/' + this.currentPage + (this.selectedCategoryId != 0 ? '?id=' + this.selectedCategoryId : '');
            },
            // 清除搜尋攔
            clearSearch() {
                this.searchText = '';
                this.filterByCategory(0); // 在清除搜尋欄後自動執行篩選全部商品
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