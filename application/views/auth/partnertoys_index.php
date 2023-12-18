<div id="authApp">
    <section class="sectionRejust">
        <?php require('auth-menu.php'); ?>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <div v-if="selectedCategoryId == 1">
                <?php
                if (empty($this->session->userdata('user_id'))) :
                    require('partnertoys_login.php');
                endif;
                ?>
            </div>
            <div v-else-if="selectedCategoryId == 2">
                <?php
                if (empty($this->session->userdata('user_id'))) :
                    require('partnertoys_register.php');
                endif;
                ?>
            </div>
            <div v-else-if="selectedCategoryId == 3">
                <?php
                if (empty($this->session->userdata('user_id'))) :
                    require('partnertoys_forgot_password.php');
                endif;
                ?>
            </div>
        </div>
    </section>
</div>

<script>
    const authApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id')); ?>, // 若透過header或footer篩選
                pageTitle: null, // 目前標籤
                authCategory: <?php echo json_encode($auth_category); ?>,
                selectedCategoryId: null, // 目前顯示頁面主題
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            }
        },
        mounted() {
            if (this.authCategory.length > 0) {
                this.selectedCategoryId = this.authCategory[0].auth_category_id;
                this.pageTitle = this.authCategory[0].auth_category_name;
                if (this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    const tmpSet = this.authCategory.filter(self => self.auth_category_id === this.getID);
                    this.pageTitle = tmpSet[0].auth_category_name;
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
                this.selectedCategoryId = categoryId;
                const selectedCategory = this.authCategory.find(category => category.auth_category_id === categoryId);
                this.pageTitle = selectedCategory.auth_category_name;
            },
        },
    }).mount('#authApp');
</script>