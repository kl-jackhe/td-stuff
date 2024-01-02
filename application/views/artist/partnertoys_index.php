<div id="artistApp" role="main" class="main pt-signinfo">
    <section class="sectionRejust">
        <?php require('artist-menu.php'); ?>
        <div class="contentMarginBottom section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div v-if="selectedCategoryId == 1">
                <div class="container">
                    <img src="/assets//uploads/Editor/images/20200710164258.jpg" style="width: 100%;">
                </div>
                <div class="row">
                    <div v-for="self in artist_son_category" class="cargoIntro col-lg-3 col-md-6 col-6 list wow fadeIn">
                        <a @click="filterBySubCategory(1, self.id)">
                            <img :src="'/assets/uploads/Editor/images/creator/' + self.code" style="width: 100%;">
                            <p class="cargoIntroText">{{ self.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div v-if="selectedCategoryId == 2">
                <div class="container">
                    <img src="/assets//uploads/Editor/images/20200710164301.jpg" style="width: 100%;">
                </div>
                <div class="row">
                    <div v-for="self in artist_son_category" class="cargoIntro col-lg-3 col-md-6 col-6 list wow fadeIn">
                        <a @click="filterBySubCategory(1, self.id)">
                            <img :src="'/assets/uploads/Editor/images/creator/' + self.code" style="width: 100%;">
                            <p class="cargoIntroText">{{ self.name }}</p>
                        </a>
                    </div>
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
                getSubID: <?php echo json_encode($this->input->get('subid', TRUE)); ?>, // 若透過header或footer篩選
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
            filterBySubCategory(Id, subId) {
                this.selectedSubCategoryId = subId;
            },
            // 获取关联的子项
            toggleCategory(categoryId) {
                $.ajax({
                    url: '/artist/selected_son/' + categoryId,
                    method: 'post',
                    success: (response) => {
                        this.artist_son_category = response;
                        // 確定上一個選擇類別決定開關狀態
                        this.isExpanded = this.artist_category.find(self => self.id === categoryId);
                        this.selectedSubCategoryId = null;
                        if (this.isExpanded.sort != this.selectedCategoryId) {
                            this.isExpanded.switch = true;
                        } else {
                            this.isExpanded.switch = !this.isExpanded.switch;
                        }
                        // 更新選擇類別
                        this.selectedCategoryId = this.isExpanded.sort;
                    }
                })
            },
        },
    });
    artistApp.mount('#artistApp');
</script>