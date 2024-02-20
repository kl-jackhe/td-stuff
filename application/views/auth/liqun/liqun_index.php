<?php require('auth-captcha.php'); ?>
<!-- 引入 Facebook JavaScript SDK -->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

<div id="authApp">
    <section class="sectionRejust">
        <?php require('auth-menu.php'); ?>
        <div class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
                <?php
                // echo '<pre>';
                // print_r($this->session->userdata());
                // echo '</pre>';
                // $server_ip = $_SERVER['SERVER_ADDR'];
                // echo "Server IP Address: " . $server_ip;
                ?>
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
            <?php else : ?>
                <!-- 登入狀態 -->
                <div v-if="selectedCategoryId == 1">
                    <!-- 訂單查詢 -->
                    <div v-if='!selectedOrder'><?php require('auth-orders.php'); ?></div>
                    <div v-else><?php require('auth-orders-information.php'); ?></div>
                </div>
                <div v-else-if="selectedCategoryId == 2">
                    <!-- 更改個資 -->
                    <?php require('auth-coupon.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 3">
                    <!-- 更改個資 -->
                    <?php require('auth-edit.php'); ?>
                </div>
                <div v-else-if="selectedCategoryId == 4">
                    <!-- 更改密碼 -->
                    <?php require('auth-changepd.php'); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
    const authApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                pageTitle: null, // 目前標籤
                order: <?php echo (!empty($this->session->userdata('user_id')) && !empty($order)) ? json_encode($order) : json_encode(''); ?>, // 指定會員訂單
                order_item: <?php echo (!empty($this->session->userdata('user_id')) && !empty($order_item)) ? json_encode($order_item) : json_encode(''); ?>, // 指定會員訂單的詳細物品
                coupon: <?php echo (!empty($this->session->userdata('user_id')) && !empty($coupon)) ? json_encode($coupon) : json_encode(''); ?>, // 指定會員優惠券
                followData: null,
                selectedOrder: null, // 該會員被選中的訂單
                selectedOrderItem: null, // 該會員被選中的訂單內容物
                authCategory: <?php echo json_encode(!empty($auth_category) ? $auth_category : ''); ?>, // 篩選標籤
                selectedCategoryId: null, // 目前顯示頁面主題
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                perpage: 5, // 一頁的資料數
                currentPage: 1, // 目前page
                // imageBase64: '', // check code graph
            }
        },
        mounted() {
            // 初始化 Magnific Popup
            // this.initMagnificPopup();
            // init imageBase64
            // this.getCaptcha();
            // 初始化篩選標籤
            if (this.authCategory && this.authCategory.length > 0) {
                this.selectedCategoryId = this.authCategory[0].auth_category_id;
                this.pageTitle = this.authCategory[0].auth_category_name;
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                    const tmpSet = this.authCategory.find(self => self.auth_category_id === this.getID);
                    this.pageTitle = tmpSet.auth_category_name;
                }
            }
        },
        computed: {
            // 頁碼
            limitedPages() {
                const maxPages = 2;
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
                return Math.ceil(this.order.length / this.perpage);
            },
            pageStart() {
                return (this.currentPage - 1) * this.perpage
                //取得該頁第一個值的index
            },
            pageEnd() {
                const end = this.currentPage * this.perpage;
                return Math.min(end, this.order.length);
                //取得該頁最後一個值的index
            },
        },
        methods: {
            // 初始化 Magnific Popup
            initMagnificPopup() {
                // 使用 Magnific Popup 的初始化逻辑，例如：
                $('.popup-link').magnificPopup({
                    type: 'inline',
                    midClick: true // 允许使用中键点击
                    // 更多配置项可以根据需求添加
                });
            },
            toggleTermsPopup() {
                // 获取 Magnific Popup 插件实例
                const magnificPopup = $.magnificPopup.instance;

                // 切换弹窗的显示状态
                if (magnificPopup.isOpen) {
                    magnificPopup.close();
                } else {
                    magnificPopup.open({
                        items: {
                            src: '#termsOfMembership'
                        },
                        type: 'inline'
                        // 更多 Magnific Popup 配置项可根据需要添加
                    });
                }
            },
            // getCaptcha() {
            //     $.ajax({
            //         type: 'post',
            //         url: '/auth/get_captcha',
            //         contentType: 'application/json',
            //         success: (data) => {
            //             this.imageBase64 = data;
            //         },
            //     })
            // },
            // 獲取追蹤清單
            getFollow() {
                $.ajax({
                    type: 'post',
                    url: '/product/get_like',
                    contentType: 'application/json',
                    success: (data) => {
                        this.followData = data;
                    },
                })
            },
            // 刪除指定追蹤商品
            delect_follow(id) {
                $.ajax({
                    type: 'post',
                    url: '/product/delect_like/' + id,
                    contentType: 'application/json',
                    success: function(data) {
                        if (data == 'successful') {
                            alert('刪除成功');
                            window.location.href = <?php echo json_encode(base_url()); ?> + "auth?id=2";
                        } else {
                            console.log(data);
                        }
                    },
                })
            },
            // 指向指定商品
            href_product(id) {
                window.location.href = <?php echo json_encode(base_url()); ?> + "product/product_detail/" + id;
            },
            // 完成付款
            completePay(id) {
                window.location.href = <?php echo json_encode(base_url()); ?> + "checkout/repay_order/" + id;
            },
            // 取消訂單
            cancelOrder(id) {
                var self = this;

                var userConfirmed = confirm('確定要取消訂單嗎？');

                if (userConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/auth/cancel_order/' + id,
                        contentType: 'application/json',
                        success: function(data) {
                            if (data == 'successful') {
                                this.clearSelectedOrder();
                                location.reload();
                            }
                            console.log(data);
                        },
                    });
                }
            },
            randomCheckcode() {
                // 获取当前页面的 URL
                var currentPageUrl = window.location.href

                // 检查是否在特定页面
                if ((currentPageUrl.indexOf(<?= json_encode(base_url()) ?> + 'auth/index?id=2') !== -1)) {
                    window.location.reload();
                } else {
                    window.location.href = <?= json_encode(base_url()) ?> + 'auth/index?id=2';
                }
                // this.getCaptcha();
                // console.log(<?= json_encode($this->session->flashdata('captcha')); ?>);
            },
            randomCheckcodeContact() {
                // 获取当前页面的 URL
                var currentPageUrl = window.location.href
                // 检查是否在特定页面
                <?php if (empty($this->session->userdata('user_id'))) : ?>
                    if ((currentPageUrl.indexOf(<?= json_encode(base_url()) ?> + 'auth/index?id=4') !== -1)) {
                        window.location.reload();
                    } else {
                        window.location.href = <?= json_encode(base_url()) ?> + 'auth/index?id=4';
                    }
                <?php else : ?>
                    if ((currentPageUrl.indexOf(<?= json_encode(base_url()) ?> + 'auth/index?id=7') !== -1)) {
                        window.location.reload();
                    } else {
                        window.location.href = <?= json_encode(base_url()) ?> + 'auth/index?id=7';
                    }
                <?php endif; ?>
            },
            // 篩選清單呼叫(手機版)
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
            filterByCategory(categoryId) {
                this.scrollToTop();
                this.currentPage = 1; // 將頁碼設置為1
                this.selectedOrder = null;
                this.selectedOrderItem = null;
                this.selectedCategoryId = categoryId;
                const selectedCategory = this.authCategory.find(category => category.auth_category_id === categoryId);
                this.pageTitle = selectedCategory.auth_category_name;
            },
            // 選中獨立訂單
            showOrderDetails(selected) {
                // 抓被點到的訂單
                this.scrollToTop();
                this.selectedOrder = selected;
                this.selectedOrderItem = this.order_item.filter(self => self.order_id === selected.order_id);
            },
            clearSelectedOrder() {
                this.selectedOrder = null;
                this.selectedOrderItem = null;
            },
            redirectToCargo() {
                console.log(this.selectedOrderItem);
                this.add_cart();
            },
            add_cart() {
                // 檢查登入
                <?php if (empty($this->session->userdata('user_id'))) : ?>
                    alert('請先登入再進行操作。');
                    window.location.href = "<?php echo base_url() . 'auth' ?>"; // 添加引號
                    return;
                <?php endif; ?>

                Promise.all(this.selectedOrderItem.map(async (element) => {
                        try {
                            let data = await $.ajax({
                                url: "/cart/add_combine",
                                method: "POST",
                                data: {
                                    combine_id: element.product_combine_id,
                                    qty: element.order_item_qty,
                                    specification_name: '',
                                    specification_id: '',
                                    specification_qty: '',
                                }
                            });

                            if (data == 'exceed') {
                                alert('超過限制數量故無法下單，敬請見諒');
                            } else if (data == 'updateSuccessful') {
                                console.log(data);
                            } else if (data == 'successful') {
                                console.log(data);
                            } else {
                                console.log(data);
                            }
                            get_cart_qty();
                        } catch (error) {
                            console.error('Error in AJAX request:', error);
                        }
                    }))
                    .then(() => {
                        // 等待3秒後執行跳轉
                        setTimeout(() => {
                            window.location.href = <?= json_encode(base_url() . 'checkout') ?>;
                        }, 300);
                    });
            },
            // 頁碼
            setPage(page) {
                if (page <= 0 || page > this.totalPages || (page === this.totalPages && this.currentPage === this.totalPages)) {
                    return;
                }
                this.isNavOpen = false;
                this.currentPage = page;
                this.scrollToTop();
            },
            // 將頁面滾動到頂部
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // 若要有平滑的滾動效果
                });
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
        var identity = $('#identity').val();
        var name = $('#name').val();
        var sexSelect = document.getElementById('sex');
        var email = $('#email').val();
        var password = $('#password').val();
        var password_confirm = $('#password_confirm').val();
        var check_code = $('#checkcode').val();
        var agreeCheckbox = document.getElementById('agree');
        var email_ok = $('#email_ok').val();

        if (identity == '') {
            $('#error_text').html('尚未填寫行動電話');
            return;
        }

        if (name == '') {
            $('#error_text').html('尚未填寫姓名');
            return;
        }

        if (sexSelect.value === '') {
            $('#error_text').html('尚未選擇性別');
            return;
        }

        if (email == '') {
            $('#error_text').html('尚未填寫E-MAIL');
            return;
        }

        if (password == '') {
            $('#error_text').html('尚未填寫密碼');
            return;
        }

        if (password_confirm == '') {
            $('#error_text').html('尚未填寫確認密碼');
            return;
        }

        if (check_code != <?= json_encode($this->session->flashdata('captcha')) ?>) {
            $('#error_text').html('驗證碼錯誤請重新確認');
            return;
        }

        if (!agreeCheckbox.checked) {
            $('#error_text').html('請勾選同意網站服務條款');
            return;
        }

        // 待修正
        if (password == password_confirm) {
            if (email_ok == 1) {} else {
                $('#error_text').html('電子郵件不正確。');
                return;
            }
            document.getElementById("register").submit();
        } else {
            $('#error_text').html('密碼與確認密碼不符。');
            return;
        }
    }

    function contact_check() {
        var number = $('#number').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var content = $('#content').val();
        var check_code = $('#checkcode').val();

        if (number == '') {
            $('#error_text').html('尚未填寫聯絡方式');
            return;
        }

        if (name == '') {
            $('#error_text').html('尚未填寫姓名');
            return;
        }
        if (email == '') {
            $('#error_text').html('尚未填寫E-MAIL');
            return;
        }
        if (content == '') {
            $('#error_text').html('尚未填寫內容');
            return;
        }

        if (check_code != <?= json_encode($this->session->flashdata('captcha')) ?>) {
            $('#error_text').html('驗證碼錯誤請重新填寫');
            return;
        }

        document.getElementById("cantact_us").submit();
    }

    // 初始化 Facebook SDK
    window.fbAsyncInit = function() {
        FB.init({
            appId: '375467955018014',
            cookie: true,
            xfbml: true,
            version: 'v18.0'
        });
        FB.AppEvents.logPageView();
        // 在這裡檢查登入狀態
        checkLoginState();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    function customFacebookLogin() {
        // 使用 Facebook JavaScript SDK 的 FB.login 函數
        FB.login(function(response) {
            // 處理登入後的回應
            statusChangeCallback(response);
        }, {
            scope: 'public_profile,email'
        }); // 指定權限
    }

    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            const accessToken = response.authResponse.accessToken;

            // 調用 FB.logout 將用戶登出
            FB.logout();

            // 使用 Facebook Graph API 取得使用者資訊
            FB.api('/me', {
                fields: 'email,name',
                access_token: accessToken
            }, function(graphResponse) {
                const userData = {
                    accessToken: accessToken,
                    userID: response.authResponse.userID,
                    email: graphResponse.email,
                    name: graphResponse.name
                };

                // 使用 AJAX 發送 POST 請求到後端
                $.ajax({
                    type: 'POST',
                    url: 'auth/FB_login',
                    contentType: 'application/json',
                    data: JSON.stringify(userData),
                    success: function(data) {
                        // 在這裡處理後端的回應
                        if (data == 'unsuccessful') {
                            alert('登入失敗，請嘗試其他方式登入。');
                            window.location.href = '/auth';
                        } else if (data !== null) {
                            window.location.href = '/';
                        }
                        console.log(data);
                    },
                    error: function(error) {
                        if (data !== null) {
                            alert('登入失敗');
                            window.location.href = '/auth';
                        }
                        console.error('Error:', error);
                    }
                });
            });
        }
    }
</script>