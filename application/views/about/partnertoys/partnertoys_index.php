<div v-cloak id="aboutApp" role="main" class="main pt-signinfo">
    <section class="container sectionRejust">
        <?php require('about-menu.php'); ?>
        <div class="contentMarginBottom section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <!--M_contents-->
            <div id="M_contents" class="animated fadeIn">
                <!--內文區塊↓-->
                <div class="edit">
                    <p style="text-align: center;">
                        <span style="font-size: 14pt; font-family: 微軟正黑體, 'Microsoft JhengHei';">
                            <strong>品牌介紹</strong>
                        </span>
                    </p>
                    <p style="text-align: center;">
                        <span style="font-size: 14pt; font-family: 微軟正黑體, 'Microsoft JhengHei';">
                            <strong>About PartnerToys</strong>
                        </span>
                    </p>
                    <p style="text-align: center;">
                        <span style="font-size: 12pt;">夥伴，讓蒐藏變成一種情感，<br>玩具，讓壓力變成一種療癒。</span>
                    </p>
                    <p style="text-align: center;">
                        <img id="aboutImg" src="/assets/uploads/aboutContent.jpg" alt="">
                    </p>
                </div>
                <!--內文區塊↑-->
            </div>
    </section>
</div>

<script>
    const aboutApp = Vue.createApp({
        data() {
            return {
                getCategory: <?php echo json_encode($category); ?>, // 若透過header或footer篩選
                selectedCategoryId: null, // 目前顯示頁面主題
                about_category: <?php echo json_encode(!empty($about_category) ? $about_category : ''); ?>,
                pageTitle: '', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            }
        },
        mounted() {
            // init btn state
            if (this.about_category && this.about_category.length > 0) {
                if (this.getCategory && this.getCategory.length > 0) {
                    this.selectedCategoryId = this.getCategory;
                    const tmpSet = this.about_category.find(self => self.sort === this.getCategory);
                    this.pageTitle = tmpSet.name;
                } else {
                    this.selectedCategoryId = this.about_category[0].sort;
                    this.pageTitle = this.about_category[0].name;
                }
            }
        },
        methods: {
            // 篩選清單呼叫
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
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
                                    window.location.href = <?= json_encode(base_url()) ?> + 'about/?' + response.src;
                                } else {
                                    console.log('error.');
                                }
                            } else {
                                console.log(response);
                            }
                        },
                    });
                } else {
                    window.location.href = <?= json_encode(base_url()) ?> + 'about/index' + (categoryId != null ? '?id=' + categoryId : '');
                }
            },
        },
    });
    aboutApp.mount('#aboutApp');
</script>