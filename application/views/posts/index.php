<div id="postApp" role="main" class="main pt-signinfo">
    <section id="post_rejust">
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
            <h1 class=""><span>最新消息</span></h1>
            <!-- menu-main為第一層選單,menu-sub為第二層選單,menu-grand為第三層選單 -->
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

                <!-- Post Start -->
                <div class="row">
                    <div class="col-bg-12 col-md-6 col-lg-4" v-for="self in filteredPosts.slice(pageStart, pageEnd)" :key="self.post_id">
                        <div class="touch_effect">
                            <a class="font_color" :href="'/posts/view/' + self.post_id">
                                <div class="postImg text-center">
                                    <img class="post_img" :src="'/assets/uploads/' + self.post_image" :alt="self.post_title">
                                </div>
                                <div class="postText">
                                    <p class="text-right">{{ self.updated_at.substr(0, 10) }}</p>
                                    <h3 class="postTitle font-weight-bold">{{ self.post_title }}</h3>
                                    <p class="text-right" style="color:#e30020; margin:0;">more+</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div v-if="filteredPosts.length === 0" class="col-12 text-center">
                    <p style="height: 300px;">------目前暫無相關消息------</p>
                </div>
                <!-- Post End -->

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
    const postApp = Vue.createApp({
        data() {
            return {
                selectedCategoryId: 1, // 目前顯示頁面主題, 1為最新消息
                posts: <?php echo json_encode($posts); ?>, // posts資料庫所有類及項目
                posts_categorys: <?php echo json_encode($posts_category); ?>, // posts_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 6, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                sharedData: null, // 測試footer&header篩選
            };
        },
        mounted() {
            // 在 mounted 鉤子中設定 selectedCategoryId 的值
            if (this.posts_categorys.length > 0) {
                this.selectedCategoryId = this.posts_categorys[0].post_category_id;
                this.pageTitle = this.posts_categorys[0].post_category_name;
            }
        },
        // created() {
        //     eventBus.on('category-selected', (categoryId) => {
        //         // 在這裡執行相應的操作，比如更新你的數據或觸發其他方法
        //         console.log('Selected Category ID:', categoryId);
        //     });
        // },
        computed: {
            filteredPosts() {
                if (this.searchText.trim() !== '') {
                    this.pageTitle = "搜尋結果"
                    this.isNavOpen = false;
                    return this.filterPostsBySearch();
                } else {
                    if (this.pageTitle === "搜尋結果") {
                        this.clearSearch();
                    }
                    return this.filterPostsByCategory();
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
                return Math.ceil(this.filteredPosts.length / this.perpage);
            },
            pageStart() {
                return (this.currentPage - 1) * this.perpage
                //取得該頁第一個值的index
            },
            pageEnd() {
                const end = this.currentPage * this.perpage;
                return Math.min(end, this.filteredPosts.length);
                //取得該頁最後一個值的index
            }
        },
        methods: {
            filterPostsBySearch() {
                return this.posts.filter(post => {
                    const titleMatch = post.post_title.toLowerCase().includes(this.searchText.toLowerCase());
                    const contentMatch = post.post_content.toLowerCase().includes(this.searchText.toLowerCase());
                    return titleMatch || contentMatch;
                });
            },
            filterPostsByCategory() {
                if (this.selectedCategoryId == 1) {
                    return this.posts;
                } else {
                    return this.posts.filter(post => post.post_category === this.selectedCategoryId);
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
                // console.log('Filtered Posts:', this.filteredPosts);
                const selectedCategory = this.posts_categorys.find(category => category.post_category_id === categoryId);
                this.pageTitle = selectedCategory.post_category_name;
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
                this.filterByCategory(this.posts_categorys[0].post_category_id); // 在清除搜尋欄後自動執行第一個篩選
            },
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
        },
    });
    postApp.mount('#postApp');
</script>