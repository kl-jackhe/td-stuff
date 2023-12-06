<style>
    .active {
        background-color: #d35448;
        font-weight: bold;
    }

    .post_breadcrumb {
        display: flex;
        justify-content: center;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        list-style: none;
        border-radius: 0.25rem;
        position: relative;
    }

    .post_breadcrumb li {
        margin: 0 10px;
    }

    .post_breadcrumb #post_search {
        color: rgba(211, 84, 72, 0.5);
        margin: 0 10px;
        width: 100%;
        height: 40px;
        padding-left: 20px;
        border-color: rgba(211, 84, 72, 0.5);
        border-radius: 5px;
        box-sizing: border-box;
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    .post_breadcrumb #post_search:focus {
        outline: none;
        box-shadow: rgba(211, 84, 72, 0.5) 0px 3px 8px;
        border-color: rgba(211, 84, 72, 1);
    }

    .post_breadcrumb #post_search::placeholder {
        color: rgba(211, 84, 72, 0.5);
    }

    .clear-search {
        position: absolute;
        right: 45px;
        top: 20px;
        cursor: pointer;
        color: rgba(211, 84, 72, 0.5);
    }

    .clear-search:hover {
        color: rgba(211, 84, 72, 1);
    }

    .touch_effect {
        border: 1px solid #eaeaea;
        padding: 30px 15px;
        background: #fff;
        border-radius: 15px;
        margin-top: 30px;
        position: relative;
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    .touch_effect:hover {
        -webkit-box-shadow: 0 10px 50px 0 rgba(84, 110, 122, .35);
        box-shadow: 0 10px 50px 0 rgba(84, 110, 122, .35)
    }

    .font_color {
        font-size: .9375rem;
        line-height: 20px;
        color: black;
    }

    .font_color:hover {
        color: #e07f55;
        text-decoration: none;
    }

    #postsDate {
        margin-bottom: 3px;
    }

    #post_rejust {
        padding-top: 25px;
        padding-bottom: 25px;
        margin-top: 70px;
    }

    .section-contents h1 span,
    .section-contents-one h1 span {
        display: inline-block;
        height: 40px;
        color: #d35448;
        border-bottom: 2px solid #d35448;
        padding: 0 15px;
    }

    .section-contents h1,
    .section-contents-one h1 {
        height: 40px;
        font-size: 22px;
        line-height: 40px;
        border-bottom: 2px solid #ddd;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .selectWebList {
        padding: 0 0 0 30px;
    }

    .selectWebList a:hover {
        color: #e07f55;
        text-decoration: none;
    }

    .category_btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid #d35448;
        color: #d35448;
        border-radius: 5px;
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    .category_btn.active,
    .category_btn:hover,
    .category_btn:checked {
        background-color: #d35448;
        box-shadow: rgba(211, 84, 72, 0.5) 0px 3px 8px;
        color: #fff;
    }

    .post_page_link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #d35448;
        background-color: #fff;
        border: 1px solid #dee2e6;
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    .post_page_link:hover {
        z-index: 2;
        color: #fff;
        text-decoration: none;
        background-color: #d35448;
        border-color: #dee2e6;
    }

    .post_page_link:focus {
        z-index: 2;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(211, 84, 30, .25);
    }

    .page-item.disabled .post_page_link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6;
    }

    .page-item:first-child .post_page_link {
        margin-left: 0;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .page-item:last-child .post_page_link {
        margin-left: 0;
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .post_pagination {
        margin-top: 30px;
        text-align: center;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem rem;
    }

    .post_pagination li {
        display: inline-block;
        margin-right: 5px;
        /* 設定按鈕之間的間距，可根據需求調整 */
    }
</style>

<script src="https://unpkg.com/vue@next"></script>

<div id="app" role="main" class="main pt-signinfo">
    <section id="post_rejust">
        <div class="container">
            <div class="post_breadcrumb">
                <input type="text" id="post_search" placeholder="搜尋欄" v-model="searchText">
                <span v-if="searchText !== ''" @click="clearSearch" class="clear-search"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
            <div v-if="searchText === ''" class="crumb">
                <ul class="post_breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li v-for="category in categories" :key="category.post_category_id">
                        <input type="button" :value="category.post_category_name" @click="filterByCategory(category.post_category_id)" :class="{ category_btn: true, active: selectedCategoryId === category.post_category_id}">
                    </li>
                </ul>
            </div>
        </div>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div class="container">
                <!-- Pagination -->
                <ul v-if="totalPages !== 0" class="post_pagination">
                    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(currentPage-1)">
                        <a class="post_page_link" href="" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li v-for="n in limitedPages" :key="n" :class="{'active': (currentPage === n)}" @click.prevent="setPage(n)">
                        <a class="post_page_link" href="">{{ n }}</a>
                    </li>
                    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(currentPage+1)">
                        <a class="post_page_link" href="" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>

                <!-- Post Start -->
                <div v-for="self in filteredPosts.slice(pageStart, pageEnd)" :key="self.post_id">
                    <a class="font_color" :href="'/posts/view/' + self.post_id">
                        <div class="row touch_effect">
                            <div class="col-md-3 offset-md-1 text-center">
                                <img :src="'/assets/uploads/' + self.post_image" class="img-fluid" :alt="self.post_title">
                            </div>
                            <div class="col-md-7">
                                <p id="postsDate">{{ self.created_at.substr(0, 10) }}</p>
                                <h3 class="font-weight-bold">{{ self.post_title }}</h3>
                                <p>{{ customExcerpt(self.post_content, 110) }}</p>
                                <p class="text-right">more+</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Post End -->

                <!-- Pagination -->
                <ul v-if="totalPages !== 0" class="post_pagination">
                    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(currentPage-1)">
                        <a class="post_page_link" href="" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li v-for="n in limitedPages" :key="n" :class="{'active': (currentPage === n)}" @click.prevent="setPage(n)">
                        <a class="post_page_link" href="">{{ n }}</a>
                    </li>
                    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(currentPage+1)">
                        <a class="post_page_link" href="" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</div>

<script>
    const app = Vue.createApp({
        data() {
            return {
                categories: <?php echo json_encode($posts_category); ?>, // posts_category資料庫所有類及項目
                selectedCategoryId: 1, // 目前顯示頁面主題, 1為最新消息
                posts: <?php echo json_encode($posts); ?>, // posts資料庫所有類及項目
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
            filteredPosts() {
                if (this.searchText.trim() !== '') {
                    this.pageTitle = "搜尋結果"
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