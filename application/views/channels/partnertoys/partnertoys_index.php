<div v-cloak id="channelsApp" role="main" class="main pt-signinfo">
    <section class="container sectionRejust">
        <?php require('channels-menu.php'); ?>
        <div class="contentMarginBottom section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div v-if="selectedCategoryId == 1 && selectedSubCategoryId == null && selectedSubSubCategoryId == null">
                <div class="container">
                    <img src="/assets/uploads/Editor/images/creator/20230208153251.jpg" style="width: 100%;">
                </div>
                <div class="row resetRowMargin">
                    <div v-for="self in channels_son_category" class="intro col-lg-3 col-md-6 col-6 list wow fadeIn">
                        <a class="cursorPoint" @click="toggleSubCategory(self.id)">
                            <img :src="'/assets/uploads/' + self.code" style="width: 100%;">
                            <p class="introText">{{ self.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div v-if="selectedSubCategoryId != null && selectedSubSubCategoryId == null" class="container">
                <div v-for="self in channels_son_category" class="row">
                    <div v-if="selectedSubCategoryId == self.sort" v-html="self.description" class="col-12"></div>
                </div>
                <div class="row resetRowMargin">
                    <div v-for="sons in channels_sub_son_category" class="subSubCategoryContent col-3">
                        <div class="sonsPreview">
                            <span @click="filterBySubSubCategory(sons.id)">{{ sons.name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="selectedSubSubCategoryId != null" class="container">
                <div v-for="self in channels_sub_son_category" class="row subSubCategoryContent">
                    <div v-if="selectedSubSubCategoryId == self.id" v-html="self.description" class="col-12"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const channelsApp = Vue.createApp({
        data() {
            return {
                getCategory: <?php echo json_encode($category); ?>, // 若透過header或footer篩選
                selectedCategoryId: null, // 選中項目類別
                selectedSubCategoryId: null, // 選中子項目類別
                selectedSubSubCategoryId: null, // 選中子子項目類別
                channels_category: <?php echo json_encode(!empty($channels_category) ? $channels_category : ''); ?>, // 項目類別
                channels_son_category: null, // 子項目類別
                channels_sub_son_category: null, // 子子項目類別
                pageTitle: '', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                isExpanded: [], // 打開子項目
                isSubExpanded: [], // 打開子子項目
            }
        },
        mounted() {
            if (this.channels_category && this.channels_category.length > 0) {
                // category init
                if (this.getCategory && this.getCategory > 0) {
                    this.selectedCategoryId = this.getCategory;
                    this.toggleCategory(this.channels_category[parseInt(this.getCategory) - 1].id);
                    const tmpSet = this.channels_category.find(self => self.sort === this.getCategory);
                    this.pageTitle = tmpSet.name;
                } else {
                    this.selectedCategoryId = this.channels_category[0].sort;
                    this.toggleCategory(this.channels_category[0].id);
                    this.pageTitle = this.channels_category[0].name;
                }
            }
        },
        methods: {
            // 篩選清單呼叫
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
            filterBySubSubCategory(subsubId) {
                this.scrollToTop();
                this.selectedSubSubCategoryId = subsubId;
                const tmp = this.channels_sub_son_category.find(self => self.id === subsubId);
                this.pageTitle = tmp.name;
            },
            // 获取关联的子项
            toggleCategory(categoryId) {
                this.scrollToTop();
                $.ajax({
                    url: '/channels/selected_son/' + categoryId,
                    method: 'post',
                    success: (response) => {
                        this.channels_son_category = response;
                        // 確定上一個選擇類別決定開關狀態
                        this.isExpanded = this.channels_category.find(self => self.id === categoryId);
                        if (this.isExpanded.sort != this.selectedCategoryId || this.selectedSubCategoryId !== null) {
                            this.isExpanded.switch = true;
                        } else {
                            this.isExpanded.switch = !this.isExpanded.switch;
                        }
                        // 當點回最上層將其他層關閉
                        this.selectedSubCategoryId = null;
                        this.selectedSubSubCategoryId = null;
                        this.isSubExpanded = [];
                        // 更新選擇類別
                        this.selectedCategoryId = this.isExpanded.sort;
                        this.pageTitle = this.isExpanded.name;
                    }
                })
            },
            // 获取关联的子子项
            toggleSubCategory(categoryId) {
                this.scrollToTop();
                $.ajax({
                    url: '/channels/selected_sub_son/' + categoryId,
                    method: 'post',
                    success: (response) => {
                        this.channels_sub_son_category = response;
                        // 確定上一個選擇類別決定開關狀態
                        this.isSubExpanded = this.channels_son_category.find(self => self.id === categoryId);
                        if (this.isSubExpanded.sort != this.selectedSubCategoryId || this.selectedSubSubCategoryId !== null) {
                            this.isSubExpanded.switch = true;
                        } else {
                            this.isSubExpanded.switch = !this.isSubExpanded.switch;
                        }
                        this.selectedSubSubCategoryId = null;
                        // 更新選擇類別
                        this.selectedSubCategoryId = this.isSubExpanded.sort;
                        this.pageTitle = this.isSubExpanded.name;
                    }
                })
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
    channelsApp.mount('#channelsApp');
</script>