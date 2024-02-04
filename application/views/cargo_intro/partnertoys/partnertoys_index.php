<div v-cloak id="cargoApp" role="main" class="main pt-signinfo">
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
                        <a class="cursorPoint" @click="toggleSubCategory(self.id)">
                            <img :src="'/assets/uploads/Editor/images/collaboration/' + self.code" style="width: 100%;">
                            <p class="introText">{{ self.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div v-if="selectedSubCategoryId != null && selectedSubSubCategoryId == null" class="row">
                <div v-for="self in cargo_sub_son_category" class="col-lg-3 col-md-12 subCategoryGraph">
                    <a class="cursorPoint" @click="filterBySubSubCategory(self.id)">
                        <img :src="'/assets/uploads/Editor/images/products%20links/' + self.code">
                    </a>
                </div>
            </div>
            <div v-if="selectedSubSubCategoryId != null">
                <div v-for="self in cargo_sub_son_category" class="row">
                    <div v-if="selectedSubSubCategoryId == self.id" v-html="self.description" class="col-12 center-content"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const cargoApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode((!empty($this->input->get('id', TRUE)) ? $this->input->get('id', TRUE) : '')); ?>, // 若透過header或footer篩選
                getYear: <?php echo json_encode((!empty($this->input->get('year', TRUE)) ? $this->input->get('year', TRUE) : '')); ?>, // 若透過合作指引
                getCargoName: <?php echo json_encode((!empty($this->input->get('name', TRUE)) ? $this->input->get('name', TRUE) : '')); ?>, // 若透過合作指引
                selectedCategoryId: null, // 目前顯示頁面主題
                selectedSubCategoryId: null,
                selectedSubSubCategoryId: null,
                cargo_category: <?php echo json_encode(!empty($cargo_category) ? $cargo_category : ''); ?>,
                cargo_son_category: [],
                cargo_sub_son_category: [],
                pageTitle: '', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                isExpanded: [],
                isSubExpanded: [],
            }
        },
        mounted() {
            // init btn state
            if (this.cargo_category && this.cargo_category.length > 0) {
                if (this.getID.length > 0) {
                    if (this.getYear.length > 0 && this.getCargoName.length > 0) {
                        // artist href
                        // console.log('ID:' + this.getID);
                        // console.log('Year:' + this.getYear);
                        // console.log('Name:' + this.getCargoName);
                        this.hrefToggleCategory(this.cargo_category[parseInt(this.getID) - 1].id)
                    } else {
                        // header category
                        // console.log('ID:' + this.getID);
                        this.selectedCategoryId = this.getID;
                        this.toggleCategory(this.cargo_category[parseInt(this.getID) - 1].id);
                    }
                } else {
                    this.selectedCategoryId = this.cargo_category[0].sort;
                    this.toggleCategory(this.cargo_category[0].id);
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
                const tmp = this.cargo_sub_son_category.find(self => self.id === subsubId);
                this.pageTitle = tmp.name;
            },
            // 获取关联的子项
            toggleCategory(categoryId) {
                this.scrollToTop();
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
                    url: '/cargo_intro/selected_sub_son/' + categoryId,
                    method: 'post',
                    success: (response) => {
                        this.cargo_sub_son_category = response;
                        // 確定上一個選擇類別決定開關狀態
                        this.isSubExpanded = this.cargo_son_category.find(self => self.id === categoryId);
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
            hrefToggleCategory(categoryId) {
                this.selectedCategoryId = this.getID;
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
                        // 當點回最上層將其他層關閉
                        this.selectedSubCategoryId = null;
                        this.selectedSubSubCategoryId = null;
                        this.isSubExpanded = [];
                        // 更新選擇類別
                        this.selectedCategoryId = this.isExpanded.sort;
                        this.pageTitle = this.isExpanded.name;

                        // 找指定年
                        const tmp_year = this.cargo_son_category.find(self => self.name == this.getYear);
                        $.ajax({
                            url: '/cargo_intro/selected_sub_son/' + tmp_year.id,
                            method: 'post',
                            success: (response) => {
                                this.cargo_sub_son_category = response;
                                // 確定上一個選擇類別決定開關狀態
                                this.isSubExpanded = this.cargo_son_category.find(self => self.id === tmp_year.id);
                                if (this.isSubExpanded.sort != this.selectedSubCategoryId || this.selectedSubSubCategoryId !== null) {
                                    this.isSubExpanded.switch = true;
                                } else {
                                    this.isSubExpanded.switch = !this.isSubExpanded.switch;
                                }
                                this.selectedSubSubCategoryId = null;
                                // 更新選擇類別
                                this.selectedSubCategoryId = this.isSubExpanded.sort;
                                this.pageTitle = this.isSubExpanded.name;

                                // 找指定名稱
                                const tmp_name = this.cargo_sub_son_category.find(self => self.name == this.getCargoName);
                                this.filterBySubSubCategory(tmp_name.id);
                            }
                        })
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
    cargoApp.mount('#cargoApp');
</script>