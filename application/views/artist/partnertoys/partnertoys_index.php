<div v-cloak id="artistApp" role="main" class="main pt-signinfo">
    <section class="sectionRejust">
        <?php require('artist-menu.php'); ?>
        <div class="contentMarginBottom section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div v-if="selectedCategoryId == 1 && selectedSubCategoryId == null">
                <div class="container">
                    <img src="/assets//uploads/Editor/images/20200710164258.jpg" style="width: 100%;">
                </div>
                <div class="row">
                    <div v-for="self in artist_son_category" class="intro col-lg-3 col-md-6 col-6 list wow fadeIn">
                        <a class="cursorPoint" @click="filterBySubCategory(self.id)">
                            <img :src="'/assets/uploads/' + self.code" style="width: 100%;">
                            <p class="introText">{{ self.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div v-if="selectedCategoryId == 2 && selectedSubCategoryId == null">
                <div class="container">
                    <img src="/assets//uploads/Editor/images/20200710164301.jpg" style="width: 100%;">
                </div>
                <div class="row">
                    <div v-for="self in artist_son_category" class="intro col-lg-3 col-md-6 col-6 list wow fadeIn">
                        <a class="cursorPoint" @click="filterBySubCategory(self.id)">
                            <img :src="'/assets/uploads/' + self.code" style="width: 100%;">
                            <p class="introText">{{ self.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div v-if="selectedSubCategoryId != null" class="container">
                <div v-for="self in artist_son_category" class="row">
                    <div v-if="selectedSubCategoryId == self.id" v-html="self.description" class="col-12 center-content"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const artistApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                selectedCategoryId: null, // 目前顯示頁面主題
                selectedSubCategoryId: null,
                artist_category: <?php echo json_encode(!empty($artist_category) ? $artist_category : ''); ?>,
                artist_son_category: null,
                pageTitle: '', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                isExpanded: [],
            }
        },
        mounted() {
            // init btn state
            if (this.artist_category && this.artist_category.length > 0) {
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    this.toggleCategory(this.artist_category[parseInt(this.getID) - 1].id);
                    const tmpSet = this.artist_category.find(self => self.sort === this.getID);
                    this.pageTitle = tmpSet.name;
                } else {
                    this.selectedCategoryId = this.artist_category[0].sort;
                    this.pageTitle = this.artist_category[0].name;
                    this.toggleCategory(this.artist_category[0].id);
                }
            }
        },
        methods: {
            // 篩選清單呼叫
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
            filterBySubCategory(subId) {
                this.scrollToTop();
                this.selectedSubCategoryId = subId;
                const tmp = this.artist_son_category.find(self => self.id === subId);
                this.pageTitle = tmp.name;
            },
            // 获取关联的子项
            toggleCategory(categoryId) {
                this.scrollToTop();
                $.ajax({
                    url: '/artist/selected_son/' + categoryId,
                    method: 'post',
                    success: (response) => {
                        this.artist_son_category = response;
                        // 確定上一個選擇類別決定開關狀態
                        this.isExpanded = this.artist_category.find(self => self.id === categoryId);
                        if (this.isExpanded.sort != this.selectedCategoryId || this.selectedSubCategoryId !== null) {
                            this.isExpanded.switch = true;
                        } else {
                            this.isExpanded.switch = !this.isExpanded.switch;
                        }
                        this.selectedSubCategoryId = null;
                        // 更新選擇類別
                        this.selectedCategoryId = this.isExpanded.sort;
                        this.pageTitle = this.isExpanded.name;
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
    artistApp.mount('#artistApp');
</script>