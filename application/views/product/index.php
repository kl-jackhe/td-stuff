<style>
    #product_index {
        font-size: 18px;
        line-height: 20px;
        align-items: end;
    }

    #product_index a {
        text-decoration: none;
        color: black;
        transition: 500ms ease 0s;
    }

    #product_index a:hover {
        <? if ($this->is_td_stuff) { ?>color: #68396D;
        <? } ?><? if ($this->is_liqun_food) { ?>color: #f6d523;
        <? } ?><? if ($this->is_partnertoys) { ?>color: rgba(239, 132, 104, 1.0);
        <? } ?>
    }

    #product_index .product_name {
        padding-bottom: 10px;
    }

    #product_index .product_price {
        line-height: 35px;
    }

    #zoomA {
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    #zoomA:hover {
        transform: scale(1.05);
    }

    .select_product {
        <? if ($this->is_td_stuff) { ?>background-color: #68396D;
        color: #fff !important;
        <? } ?><? if ($this->is_liqun_food) { ?>background-color: #f6d523;
        color: #000 !important;
        <? } ?><? if ($this->is_partnertoys) { ?>background-color: rgba(239, 132, 104, 1.0);
        color: #fff !important;
        <? } ?>width: 50%;
        line-height: 1.8;
        padding: 0;
    }

    .product_img_style {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product_box {
        padding: 0px 25px 0px 25px;
    }

    .page-header {
        padding-left: 30px;
        padding-right: 30px;
    }

    .products_category {
        <? if ($this->is_td_stuff) { ?>border: 1px solid #68396D;
        <? } ?><? if ($this->is_liqun_food) { ?>border: 1px solid #f6d523;
        <? } ?><? if ($this->is_partnertoys) { ?>border: 1px solid rgba(239, 132, 104, 1.0);
        <? } ?>padding: 5px 15px 5px 15px;
        border-radius: 10px;
        width: 100%;
    }

    .m_padding {
        padding-bottom: 0px !important;
    }

    @media (max-width: 767px) {
        .product_box {
            padding: 0px;
        }

        .page-header {
            padding-left: 0px;
            padding-right: 0px;
        }

        .products_category {
            margin: 10px 0px 10px 0px;
            padding: 6px 2px 6px 2px;
            font-size: 14px;
        }

        #product_index {
            padding: 0px 30px 0px 30px;
        }
    }
</style>

<script src="https://unpkg.com/vue@next"></script>

<div id="app" role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="container">
            <div class="product_breadcrumb">
                <input type="text" id="product_search" placeholder="搜尋欄" v-model="searchText">
                <span v-if="searchText !== ''" @click="clearSearch" class="clear-search"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
            <div v-if="searchText === ''" class="crumb">
                <ul class="product_breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li v-for="category in categories" :key="category.products_category_id">
                        <input type="button" :value="category.products_category_name" @click="filterByCategory(category.products_category_id)" :class="{ category_btn: true, active: selectedCategoryId === category.products_category_id}">
                    </li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row product_box">
                <div class="col-12">
                    <div class="row justify-content-center text-center">
                        <? if (!empty($products_category)) {
                            foreach ($products_category as $row) { ?>
                                <div class="col-3 col-md-2">
                                    <span class="products_category btn" id="<? echo 'products_category_id_' . $row['products_category_id'] ?>" onClick="searchFilter(<? echo $row['products_category_id']; ?>)"><? echo $row['products_category_name']; ?></span>
                                </div>
                        <? }
                        } ?>
                    </div>
                    <hr class="py-2" style="border-top: 1px solid #988B7A;">
                </div>
                <div id="data" class="col-12">
                    <div class="col-md-12 text-center">
                        <div class="row justify-content-center" id="product_index">
                            <? if (!empty($products)) :
                                foreach ($products as $product) :
                                    // 檢查上架時間是否已經到達
                                    $now = new DateTime();
                                    $distributeAt = new DateTime($product['distribute_at']);
                                    $discontinued_at = new DateTime($product['discontinued_at']);
                                    $not_discontinue = new DateTime('0000-00-00 00:00:00');
                                    if ($now >= $distributeAt && ($now < $discontinued_at || $discontinued_at == $not_discontinue)) : ?>
                                        <div class="col-md-4 pb-5">
                                            <a href="/product/view/<?= $product['product_id'] ?>">
                                                <? if (!empty($product['product_image'])) { ?>
                                                    <img id="zoomA" class="img-fluid" src="/assets/uploads/<?= $product['product_image']; ?>">
                                                <? } else { ?>
                                                    <img id="zoomA" class="img-fluid" src="/assets/uploads/Product/img-600x600.png">
                                                <? } ?>
                                                <div class="product_name">
                                                    <span><?= $product['product_name']; ?></span>
                                                </div>
                                            </a>
                                            <a href="/product/view/<?= $product['product_id'] ?>">
                                                <? if ($product['sales_status'] == 0) { ?>
                                                    <div class="btn select_product">
                                                        <span>現貨</span>
                                                    </div>
                                                <? } ?>
                                                <? if ($product['sales_status'] == 1) { ?>
                                                    <div class="btn select_product" style="background: #817F82;">
                                                        <span>售完</span>
                                                    </div>
                                                <? } ?>
                                                <? if ($product['sales_status'] == 2) { ?>
                                                    <div class="btn select_product" style="background: #A60747;">
                                                        <span>預購</span>
                                                    </div>
                                                <? } ?>
                                            </a>
                                        </div>
                                    <? endif; ?>
                                <? endforeach; ?>
                            <? else : ?>
                                <div class="col-12 text-center" style="height: 500px;">
                                    <p>搜尋不到對應的商品！</p>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    const app = Vue.createApp({
        data() {
            return {
                categories: <?php echo json_encode($products_category); ?>, // products_category資料庫所有類及項目
                selectedCategoryId: 1, // 目前顯示頁面主題, 1為最新消息
                products: <?php echo json_encode($products); ?>, // products資料庫所有類及項目
                pageTitle: "最新消息", // 目前標籤
                perpage: 5, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
            };
        },
        mounted() {
            // 在 mounted 鉤子中設定 selectedCategoryId 的值
            if (this.categories.length > 0) {
                this.selectedCategoryId = this.categories[0].post_category_id;
            }
        },
        computed: {
            filteredproducts() {
                if (this.searchText.trim() !== '') {
                    this.pageTitle = "搜尋結果"
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
                return Math.ceil(this.filteredproducts.length / this.perpage);
            },
            pageStart() {
                return (this.currentPage - 1) * this.perpage
                //取得該頁第一個值的index
            },
            pageEnd() {
                const end = this.currentPage * this.perpage;
                return Math.min(end, this.filteredproducts.length);
                //取得該頁最後一個值的index
            }
        },
        methods: {
            filterproductsBySearch() {
                return this.products.filter(post => {
                    const titleMatch = post.post_title.toLowerCase().includes(this.searchText.toLowerCase());
                    const contentMatch = post.post_content.toLowerCase().includes(this.searchText.toLowerCase());
                    return titleMatch || contentMatch;
                });
            },
            filterproductsByCategory() {
                if (this.selectedCategoryId == 1) {
                    return this.products;
                } else {
                    return this.products.filter(post => post.post_category === this.selectedCategoryId);
                }
            },
            filterByCategory(categoryId) {
                // console.log('Before:', this.selectedCategoryId);
                this.selectedCategoryId = categoryId;
                this.currentPage = 1; // 將頁碼設置為1
                // console.log('After:', this.selectedCategoryId);
                // this.selectedCategoryId = categoryId;
                // 檢查過濾後的文章
                // console.log('Selected Category ID:', categoryId);
                // console.log('Filtered products:', this.filteredproducts);
                const selectedCategory = this.categories.find(category => category.post_category_id === categoryId);
                this.pageTitle = selectedCategory ? selectedCategory.post_category_name : "最新訊息";
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
                this.currentPage = page;

                // 將頁面滾動到頂部
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // 若要有平滑的滾動效果
                });
            },
            clearSearch() {
                this.searchText = '';
                this.filterByCategory(this.categories[0].post_category_id); // 在清除搜尋欄後自動執行第一個篩選
            },
        },
    });
    app.mount('#app');
</script>