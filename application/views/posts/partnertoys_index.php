<div id="postApp" role="main" class="main pt-signinfo">
    <section id="post_rejust">
        <?php require('posts-menu.php'); ?>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div class="container">
                <!-- Post Start -->
                <div class="row">
                    <div class="col-bg-12 col-md-6 col-lg-4" v-for="self in filteredPosts.slice(pageStart, pageEnd)" :key="self.post_id">
                        <div class="touch_effect">
                            <a class="postMagnificPopupTrigger font_color" @click="showPostDetails(self)">
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
                <?php require('pagination.php'); ?>
            </div>
        </div>
        <div ref="postDetail" id="postDetailStyle" class="postDetailStyle" v-if="selectedPost">
            <div class="container">
                <!-- Post Start -->
                <div class="detailTitle newsTitle">
                    <h1 class="text-center">{{ selectedPostCategoryId[0].post_category_name }}</h1>
                </div>
                <div class="row newsText">
                    <div class="postContentStyle col-bg-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <p>{{ selectedPost.created_at.substr(0, 10) }}</p>
                            <h1 class="font-weight-bold text-center">{{ selectedPost.post_title }}</h1>
                        </div>
                    </div>
                    <div class="postContentStyle col-bg-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <img :src="'/assets/uploads/' + selectedPost.post_image" class="img-fluid">
                        </div>
                    </div>
                    <div class="postContentStyle col-bg-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <p v-html="selectedPost.post_content"></p>
                        </div>
                    </div>
                </div>
                <!-- Post End -->
            </div>
            <!-- Add a button for scrolling to the top -->
            <span @click="scrollToDetailTop" class="scrollToDetailTop"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
        </div>
    </section>
</div>

<script>
    const postApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id')); ?>, // 若透過header或footer篩選
                selectedPost: null, // 選中的消息
                selectedPostCategoryId: null, // 選中的消息
                selectedCategoryId: null, // 目前顯示頁面主題, 1為最新消息
                posts: <?php echo json_encode($posts); ?>, // posts資料庫所有類及項目
                posts_categorys: <?php echo json_encode($posts_category); ?>, // posts_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 6, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            };
        },
        watch: {
            // Watch for changes in filteredPosts and update Magnific Popup
            filteredPosts: function() {
                this.$nextTick(function() {
                    this.initMagnificPopup();
                });
            },
        },
        mounted() {
            // 在 mounted 鉤子中設定 selectedCategoryId 的值
            if (this.posts_categorys.length > 0) {
                this.selectedCategoryId = this.posts_categorys[0].post_category_id;
                this.pageTitle = this.posts_categorys[0].post_category_name;
                if (this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    const tmpSet = this.posts_categorys.filter(self => self.post_category_id === this.getID);
                    this.pageTitle = tmpSet[0].post_category_name;
                }
            }
            // 最新資訊
            $('.postMagnificPopupTrigger').magnificPopup({
                type: 'inline',
                midClick: true, // Allow opening popup on middle mouse click
                items: {
                    src: '#postDetailStyle', // ID of the popup content
                    type: 'inline'
                },
                mainClass: 'mfp-zoom-in', // Add a zoom-in effect if you like
            });
        },
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
            // Initialize Magnific Popup
            initMagnificPopup() {
                $('.postMagnificPopupTrigger').magnificPopup({
                    type: 'inline',
                    midClick: true,
                    items: {
                        src: '#postDetailStyle',
                        type: 'inline',
                    },
                    mainClass: 'mfp-zoom-in',
                });
            },
            // 選中獨立商品
            showPostDetails(post) {
                this.selectedPost = post;
                this.selectedPostCategoryId = this.posts_categorys.filter(category => category.post_category_id === post.post_category);

            },
            // 搜尋攔篩選
            filterPostsBySearch() {
                return this.posts.filter(post => {
                    const titleMatch = post.post_title.toLowerCase().includes(this.searchText.toLowerCase());
                    const contentMatch = post.post_content.toLowerCase().includes(this.searchText.toLowerCase());
                    return titleMatch || contentMatch;
                });
            },
            // 按鈕篩選
            filterPostsByCategory() {
                if (this.selectedCategoryId == 0) {
                    return this.posts;
                } else {
                    return this.posts.filter(post => post.post_category === this.selectedCategoryId);
                }
            },
            filterByCategory(categoryId) {
                this.currentPage = 1; // 將頁碼設置為1
                this.selectedCategoryId = categoryId;
                const selectedCategory = this.posts_categorys.find(category => category.post_category_id === categoryId);
                this.pageTitle = selectedCategory.post_category_name;
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
                this.filterByCategory(this.posts_categorys[0].post_category_id); // 在清除搜尋欄後自動執行第一個篩選
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
            // Method to scroll to the top of the postDetailStyle box
            scrollToDetailTop() {
                // Get the postDetailStyle element
                const postDetailStyle = this.$refs.postDetail;

                // Scroll to the top of the postDetailStyle element
                if (postDetailStyle) {
                    postDetailStyle.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        },
    });
    postApp.mount('#postApp');
</script>