<div v-cloak id="postApp" role="main" class="main pt-signinfo">
    <section class="container sectionRejust">
        <?php require('posts-menu.php'); ?>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div class="container">
                <!-- Post Start -->
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4" v-for="self in filteredPosts.slice(pageStart, pageEnd)" :key="self.post_id">
                        <a class="font_color" @click="postDetailPage(self.post_id)">
                            <!-- <a class="postMagnificPopupTrigger font_color" @click="showPostDetails(self)"> -->
                            <div class="touch_effect">
                                <div class="postImg">
                                    <img class="post_img" :src="'/assets/uploads/' + self.post_image" :alt="self.post_title">
                                </div>
                                <div class="postText">
                                    <p class="text-right">{{ self.updated_at.substr(0, 10) }}</p>
                                    <h3 class="postTitle font-weight-bold">{{ self.post_title }}</h3>
                                    <p class="text-right" style="color:#e30020; margin:0;">more+</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div v-if="filteredPosts.length === 0" class="col-12 text-center">
                    <p style="height: 300px;">------目前暫無相關消息------</p>
                </div>
                <!-- Post End -->

                <!-- Pagination -->
                <div style="margin-top:50px;"></div>
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
                    <!-- <div class="postContentStyle col-bg-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <img :src="'/assets/uploads/' + selectedPost.post_image" class="img-fluid">
                        </div>
                    </div> -->
                    <div class="postContentStyle col-bg-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <p class="text-center" v-html="selectedPost.post_content"></p>
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
                getCategory: <?php echo json_encode($category); ?>, // 若透過header或footer篩選
                selectedPost: null, // 選中的消息
                selectedPostCategoryId: null, // 選中的消息類別
                selectedCategoryId: null, // 目前顯示頁面主題
                posts: <?php echo json_encode($posts); ?>, // posts資料庫所有類及項目
                posts_categorys: <?php echo json_encode($posts_category); ?>, // posts_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 12, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // 搜尋欄
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                hiddenSearch: false, // search-box
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
            if (this.posts_categorys && this.posts_categorys.length > 0) {
                this.currentPage = parseInt(<? echo json_encode(!empty($current_page) ? $current_page : ''); ?>); // 目前page

                // category init
                if (this.getCategory && this.getCategory > 0) {
                    this.selectedCategoryId = this.getCategory;
                    const tmpSet = this.posts_categorys.find(self => self.sort === this.getCategory);
                    this.pageTitle = tmpSet.name;
                } else {
                    this.selectedCategoryId = 0;
                    this.pageTitle = '全部消息';
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

            // 監聽是否有按下搜尋
            $(document).on('toggleSearch', () => {
                // 处理事件触发后的逻辑
                // 显示搜寻栏的逻辑
                this.hiddenSearch = !this.hiddenSearch;
            });
        },
        computed: {
            // 篩選&搜尋
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
            // 選中獨立消息
            showPostDetails(post) {
                this.selectedPost = post;
                this.selectedPostCategoryId = this.posts_categorys.filter(category => category.sort === post.post_category);
            },
            // 消息獨立頁面
            postDetailPage(selected) {
                if (selected != null) {
                    $.ajax({
                        url: '/encode/getDataEncode/selectedPost',
                        type: 'post',
                        data: {
                            selectedPost: selected,
                        },
                        success: (response) => {
                            if (response) {
                                if (response.result == 'success') {
                                    window.location.href = <?= json_encode(base_url()); ?> + 'posts/posts_detail/?' + response.src;
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
                                    window.location.href = <?= json_encode(base_url()) ?> + 'posts/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                } else {
                    window.location.href = <?= json_encode(base_url()) ?> + 'posts' + (categoryId != null ? '?id=' + categoryId : '');
                }
            },
            // 頁碼
            setPage(page) {
                if (page <= 0 || page > this.totalPages || (page === this.totalPages && this.currentPage === this.totalPages)) {
                    this.scrollToTop();
                    return;
                }
                this.isNavOpen = false;
                this.currentPage = page;

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
                                    window.location.href = <?= json_encode(base_url()) ?> + 'posts/' + this.currentPage + '/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                } else {
                    window.location.href = <?= json_encode(base_url()) ?> + 'posts/' + this.currentPage;
                }
            },
            // 清除搜尋攔
            clearSearch() {
                this.searchText = '';
                this.selectedCategoryId = 0;
                this.pageTitle = '全部消息';
                this.filterPostsByCategory(); // 在清除搜尋欄後自動執行第一個篩選
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