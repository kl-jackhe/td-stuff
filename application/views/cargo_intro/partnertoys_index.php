<div id="cargoApp" role="main" class="main pt-signinfo">
    <section class="sectionRejust">
        <?php require('cargo-menu.php'); ?>
        <div class="contentMarginBottom section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div v-if="selectedCategoryId == 1 && selectedSubCategoryId == null">
                <div class="container">
                    <img src="/assets/uploads/Editor/images/creator/20230208153251.jpg" style="width: 100%;">
                </div>
                <div class="row">
                    <div v-for="self in cargo_son_category" class="intro col-lg-3 col-md-6 col-6 list wow fadeIn">
                        <a class="cursorPoint" @click="filterBySubCategory(self.id)">
                            <img :src="'/assets/uploads/Editor/images/collaboration/' + self.code" style="width: 100%;">
                            <p class="introText">{{ self.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const cargoApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                getSubID: <?php echo json_encode($this->input->get('subid', TRUE)); ?>, // 若透過header或footer篩選
                selectedCategoryId: null, // 目前顯示頁面主題
                selectedSubCategoryId: null,
                cargo_category: <?php echo json_encode(!empty($cargo_category) ? $cargo_category : ''); ?>,
                cargo_son_category: null,
                pageTitle: '', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                isExpanded: [],
            }
        },
        mounted() {
            // init btn state
            if (this.cargo_category && this.cargo_category.length > 0) {
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    this.toggleCategory(this.cargo_category[parseInt(this.getID) - 1].id);
                    const tmpSet = this.cargo_category.find(self => self.sort === this.getID);
                    this.pageTitle = tmpSet.name;
                } else {
                    this.selectedCategoryId = this.cargo_category[0].sort;
                    this.toggleCategory(this.cargo_category[0].id);
                    this.pageTitle = this.cargo_category[0].name;
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
                this.selectedSubCategoryId = subId;
            },
            // 获取关联的子项
            toggleCategory(categoryId) {
                $.ajax({
                    url: '/cargo_intro/selected_son/' + categoryId,
                    method: 'post',
                    success: (response) => {
                        this.cargo_son_category = response;
                        // 確定上一個選擇類別決定開關狀態
                        this.isExpanded = this.cargo_category.find(self => self.id === categoryId);
                        if (this.isExpanded.sort != this.selectedCategoryId || this.selectedSubCategoryId !== null) {
                            this.isExpanded.switch = true;
                        } else {
                            this.isExpanded.switch = !this.isExpanded.switch;
                        }
                        this.selectedSubCategoryId = null;
                        // 更新選擇類別
                        this.selectedCategoryId = this.isExpanded.sort;
                    }
                })
            },
        },
    });
    cargoApp.mount('#cargoApp');
</script>