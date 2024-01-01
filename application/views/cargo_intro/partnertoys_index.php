<div id="cargoApp" role="main" class="main pt-signinfo">
    <section class="sectionRejust">
        <?php require('cargo-menu.php'); ?>
        <div class="contentMarginBottom section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div class="container">
                <img src="/assets/uploads/Editor/images/creator/20230208153251.jpg" style="width: 100%;">
            </div>
        </div>
    </section>
</div>

<script>
    const cargoApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                selectedCategoryId: null, // 目前顯示頁面主題
                cargo_category: <?php echo json_encode(!empty($cargo_category) ? $cargo_category : ''); ?>,
                cargo_son_category: <?php echo json_encode(!empty($cargo_son_category) ? $cargo_son_category : ''); ?>,
                pageTitle: '', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            }
        },
        computed: {
            nestedCargoCategories() {
                return this.cargo_category.map(category => {
                    return {
                        ...category,
                        isExpanded: false, // 初始状态为折叠
                    };
                });
            },
        },
        mounted() {
            // init btn state
            if (this.cargo_category && this.cargo_category.length > 0) {
                this.selectedCategoryId = this.cargo_category[0].sort;
                this.pageTitle = this.cargo_category[0].name;
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    const tmpSet = this.cargo_category.find(self => self.sort === this.getID);
                    this.pageTitle = tmpSet.name;
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
                window.location.href = <?= json_encode(base_url()) ?> + 'cargo_intro/index' + (categoryId != null ? '?id=' + categoryId : '');
            },
            // 获取关联的子项
            getSubCategories(parentSort) {
                return this.cargo_son_category.filter(subCategory => subCategory.parent_id === parentSort);
            },
            toggleCategory(categorySort) {
                const category = this.nestedCargoCategories.find(cat => cat.id === categorySort);
                category.isExpanded = !category.isExpanded;
            },
        },
    });
    cargoApp.mount('#cargoApp');
</script>