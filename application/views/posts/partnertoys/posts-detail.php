<div v-cloak id="postApp" role="main" class="main pt-signinfo">
    <section class="container sectionRejust">
        <!-- Menu -->
        <?php require('posts-menu.php'); ?>
        <div class="section-contents">
            <?php if (!empty($post_category_name)) : ?>
                <div class="container">
                    <h1><span><?= $post_category_name; ?></span></h1>
                </div>
            <?php endif; ?>
            <!-- 消息詳情 -->
            <div id="postsDetailStyle" class="postsDetailStyle">
                <div class="container">
                    <!-- Post Start -->
                    <div class="row newsText">
                        <div class="col-md-12 head">
                            <span class="font-weight-bold text-center title">{{ posts.post_title }}</span>
                            <div class="date">
                                <span class="day">{{ formatDate(posts.created_at).day }}</span>
                                <span class="month">{{ formatDate(posts.created_at).month }}</span>
                                <span class="year">{{ formatDate(posts.created_at).year }}</span>
                            </div>
                            <div class="date_480">{{ formatDate(posts.created_at).day + '-' + formatDate(posts.created_at).month + '-' + formatDate(posts.created_at).year }}</div>
                            <!-- 社群分享 -->
                            <div class="postShare postSharePC col-md-12">
                                <span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                                <ul class="reset">
                                    <li>
                                        <a href="https://www.facebook.com/share.php?u=<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" title="分享至Facebook" target="_blank" class="fb"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="http://line.naver.jp/R/msg/text/?<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" target="_blank" title="分享至LINE" class="line"><i class="fa-brands fa-line"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/share" data-text="<?= $post['post_title'] ?>" data-lang="zh-tw" target="_blank" title="分享至Twitter" class="twitter"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://plus.google.com/share?url=<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" target="_blank" title="分享至google-plus" class="google"><i class="fab fa-google-plus-g"></i></a>
                                    </li>
                                    <li>
                                        <a href="mailto:?subject=<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" target="_blank" title="分享至E-mail" class="email"><i class="fas fa-envelope"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="postShareMB col-12">
                            <span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                            <ul class="reset">
                                <li>
                                    <a href="https://www.facebook.com/share.php?u=<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" title="分享至Facebook" target="_blank" class="fb"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="http://line.naver.jp/R/msg/text/?<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" target="_blank" title="分享至LINE" class="line"><i class="fa-brands fa-line"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/share" data-text="<?= $post['post_title'] ?>" data-lang="zh-tw" target="_blank" title="分享至Twitter" class="twitter"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://plus.google.com/share?url=<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" target="_blank" title="分享至google-plus" class="google"><i class="fab fa-google-plus-g"></i></a>
                                </li>
                                <li>
                                    <a href="mailto:?subject=<?= base_url() . 'posts/posts_detail/' . $post['post_id'] ?>" target="_blank" title="分享至E-mail" class="email"><i class="fas fa-envelope"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="postContentStyle col-bg-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <p class="text-center" v-html="posts.post_content"></p>
                            </div>
                        </div>
                    </div>
                    <!-- Post End -->
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const postApp = Vue.createApp({
        data() {
            return {
                getCategory: <?php echo json_encode($post_category_sort); ?>, // 若透過header或footer篩選
                selectedCategoryId: null, // 目前顯示頁面主題
                posts: <?php echo json_encode($post); ?>, // posts資料庫所有類及項目
                posts_categorys: <?php echo json_encode($posts_category); ?>, // posts_category資料庫所有類及項目
                pageTitle: '', // 目前標籤
                perpage: 12, // 一頁的資料數
                currentPage: 1, // 目前page
                searchText: '', // debug
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            };
        },
        mounted() {
            // 在 mounted 鉤子中設定 selectedCategoryId 的值
            if (this.posts_categorys && this.posts_categorys.length > 0) {
                // category init
                if (this.getCategory && this.getCategory > 0) {
                    this.selectedCategoryId = this.getCategory;
                    const tmpSet = this.posts_categorys.find(self => self.sort === this.getCategory);
                    this.pageTitle = tmpSet.name;
                } else {
                    this.currentPage = parseInt(<? echo json_encode(!empty($current_page) ? $current_page : ''); ?>); // 目前page
                    this.selectedCategoryId = 0;
                    this.pageTitle = '全部消息';
                }
            }
        },
        computed: {
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
            formatDate(dateString) {
                var date = new Date(dateString);
                var day = date.getDate();
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];
                var month = monthNames[date.getMonth()];
                var year = date.getFullYear();

                return {
                    day: day,
                    month: month,
                    year: year
                };
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
                                    window.location.href = <?= json_encode(base_url()) ?> + 'posts/index/' + this.currentPage + '/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                } else {
                    window.location.href = <?= json_encode(base_url()) ?> + 'posts/index/' + this.currentPage;
                }
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
    postApp.mount('#postApp');
</script>