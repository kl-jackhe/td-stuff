<div id="authApp">
    <section class="sectionRejust">
        <?php require('auth-menu.php'); ?>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <?php if (empty($this->session->userdata('user_id'))) : ?>
                <!-- 尚未登入 -->
                <div v-if="selectedCategoryId == 1">
                    <!-- 帳號登入 -->
                    <?php require('auth-login.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 2">
                    <!-- 帳號註冊 -->
                    <?php require('auth-register.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 3">
                    <!-- 忘記帳密 -->
                    <?php require('auth-forgot.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 4">
                    <!-- 聯絡我們 -->
                    <?php require('auth-contact.php'); ?>
                </div>
            <?php else : ?>
                <!-- 登入狀態 -->
                <div v-if="selectedCategoryId == 1">
                    <div v-if='!selectedOrder'><?php require('auth-orders.php'); ?></div>
                    <div v-else><?php require('auth-orders-information.php'); ?></div>
                </div>
                <div v-else-if="selectedCategoryId == 2">
                </div>
                <div v-else-if="selectedCategoryId == 3">
                </div>
                <div v-else-if="selectedCategoryId == 4">
                </div>
                <div v-else-if="selectedCategoryId == 5">
                    <!-- 更改個資 -->
                    <?php require('auth-edit.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 6">
                    <!-- 更改密碼 -->
                    <?php require('auth-changepd.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 7">
                    <!-- 聯絡我們 -->
                    <?php require('auth-contact.php'); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
    const authApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id')); ?>, // 若透過header或footer篩選
                pageTitle: null, // 目前標籤
                order: <?php echo !(empty($this->session->userdata('user_id'))) ? json_encode($order) : json_encode(''); ?>, // 指定會員訂單
                order_item: <?php echo !(empty($this->session->userdata('user_id'))) ? json_encode($order_item) : json_encode(''); ?>, // 指定會員訂單的詳細物品
                product: <? echo json_encode($product); ?>,
                selectedOrder: null, // 該會員被選中的訂單
                selectedOrderItem: null, // 該會員被選中的訂單內容物
                authCategory: <?php echo json_encode($auth_category); ?>, // 篩選標籤
                selectedCategoryId: null, // 目前顯示頁面主題
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            }
        },
        mounted() {
            if (this.authCategory && this.authCategory.length > 0) {
                this.selectedCategoryId = this.authCategory[0].auth_category_id;
                this.pageTitle = this.authCategory[0].auth_category_name;
                if (this.getID && this.getID.length > 0) {
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
                this.selectedOrder = null;
                this.selectedCategoryId = categoryId;
                const selectedCategory = this.authCategory.find(category => category.auth_category_id === categoryId);
                this.pageTitle = selectedCategory.auth_category_name;
            },
            // 選中獨立訂單
            showOrderDetails(selected) {
                // 抓被點到的訂單
                this.selectedOrder = selected;
                this.selectedOrderItem = this.order_item.filter(self => self.order_id === selected.order_id);
                // console.log(this.selectedOrder, this.order_item);
            },
        },
    }).mount('#authApp');

    function check_email() {
        var email = document.getElementById("email").value;
        $.ajax({
            url: "/auth/email_check",
            method: "get",
            data: {
                email: email
            },
            success: function(data) {
                if (data == 0) {
                    // alert('可以使用');
                    $('#email_text').html('可以使用');
                    $('#email_ok').val('1');
                } else {
                    // alert('此電子郵件已經被註冊過了');
                    $('#email_text').html('此電子郵件已經被註冊過了');
                    $('#email_ok').val('0');
                }
            }
        });
    }

    function form_check() {
        var email_ok = $('#email_ok').val();
        var password = $('#password').val();
        var password_confirm = $('#password_confirm').val();
        // var agree = $('#agree:checkbox:checked').length;
        if (password == password_confirm) {
            // if(agree>0){
            // } else {
            //   $('#error_text').html('請勾選');
            //   return false;
            // }
            if (email_ok == 1) {} else {
                $('#error_text').html('電子郵件不正確。');
                return false;
            }
            // if(email_ok==1 && agree>0){
            // alert('Submit');
            document.getElementById("register").submit();
            // }
        } else {
            $('#error_text').html('密碼與確認密碼不符。');
        }
    }
</script>