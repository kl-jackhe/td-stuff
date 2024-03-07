<div id="productApp" role="main" class="main pt-signinfo">
    <section class="container sectionRejust">
        <!-- Menu -->
        <?php require('product-menu.php'); ?>
        <div class="section-contents">
            <?php if (!empty($product_category_name)) : ?>
                <div class="container">
                    <h1><span><?= $product_category_name; ?></span></h1>
                </div>
            <?php endif; ?>
            <!-- 商品詳情 -->
            <div id="productDetailStyle" class="productDetailStyle">
                <div class="row productDetail">
                    <?php if (!empty($product)) : ?>
                        <div class="col-bg-12 col-md-6 col-lg-6">
                            <div class="album">
                                <div class="big">
                                    <div class="big-slick">
                                        <?php foreach ($product_images as $index => $image) : ?>
                                            <div class="productPictureBox carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                                <img src="/assets/uploads/<?= $image['picture']; ?>" class="productImages">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <a href="javascript:;" title="" class="album-prev slick-arrow"></a>
                                    <a href="javascript:;" title="" class="album-next slick-arrow"></a>
                                </div>
                                <div class="small">
                                    <div class="small-slick">
                                        <?php foreach ($product_images as $index => $image) : ?>
                                            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                                <img src="/assets/uploads/<?= $image['picture']; ?>" class="img-responsive">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="share col-md-12">
                                <span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                                <ul class="reset">
                                    <li>
                                        <a href="https://www.facebook.com/share.php?u=<?= base_url() . 'product/product_detail/' . $product['product_id'] ?>" title="分享至Facebook" target="_blank" class="fb"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="http://line.naver.jp/R/msg/text/?<?= base_url() . 'product/product_detail/' . $product['product_id'] ?>" target="_blank" title="分享至LINE" class="line"><i class="fa-brands fa-line"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/share" data-text="<?= $product['product_name'] ?>" data-lang="zh-tw" target="_blank" title="分享至Twitter" class="twitter"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://plus.google.com/share?url=<?= base_url() . 'product/product_detail/' . $product['product_id'] ?>" target="_blank" title="分享至google-plus" class="google"><i class="fab fa-google-plus-g"></i></a>
                                    </li>
                                    <li>
                                        <a href="mailto:?subject=<?= base_url() . 'product/product_detail/' . $product['product_id'] ?>" target="_blank" title="分享至E-mail" class="email"><i class="fas fa-envelope"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-bg-12 col-md-6 col-lg-6">
                            <div class="row">
                                <!--商品名稱-->
                                <h2 class="cargoTitle col-sm-12 col-md-12 col-lg-12"><?= $product['product_name']; ?></h2>
                                <?php if ($product['product_category_id'] == 6) : ?>
                                    <div class="cargoText col-sm-12 col-md-12 col-lg-12">
                                        <div class="item">&nbsp;$&nbsp;<?= $product['product_price'] ?></div>
                                    </div>
                                    <div v-if="selectedDescription" v-html="selectedDescription" class="cargoDetail col-bg-12 col-md-12 col-lg-12"></div>
                                    <!--抽選-->
                                    <div class="cargoBtn col-md-12 col-lg-6">
                                        <span class="cargoClick buyBtn" @click="participation"><i class="fas fa-truck"></i>參加抽選</span>
                                    </div>
                                    <!--運費說明-->
                                    <div class="cargoBtn col-md-12 col-lg-6">
                                        <span class="cargoClick explainBtn" @click="toggleTermsPopup"><i class="fas fa-truck"></i>運費說明</span>
                                    </div>
                                <?php else : ?>
                                    <!--價格-->
                                    <?php if (!empty($productCombine)) : ?>
                                        <div class="cargoText col-sm-12 col-md-12 col-lg-12">
                                            <div v-if="selectedCombine" class="item">方案價:&nbsp;$&nbsp;{{ selectedCombine.cprice }}</div>
                                            <div v-else class="item">❌尚未選擇方案</div>
                                        </div>
                                        <!--商品簡介:多行文字欄位-->
                                        <div v-if="selectedDescription" v-html="selectedDescription" class="cargoDetail col-bg-12 col-md-12 col-lg-12"></div>
                                        <?php $count = 0; ?>
                                        <!--方案選擇-->
                                        <select @change="updateSelectedCombine($event)" id="combineSelect" class="custom-select cargoBtn col-bg-12 col-md-12 col-lg-12">
                                            <option value="請選擇方案" disabled>請選擇方案</option>
                                            <option v-for="self in combine" :key="self.id" :value="self.pname">{{ self.pname }}</option>
                                        </select>
                                        <!--商品數量-->
                                        <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }" class="row cargoBtn col-md-12 col-lg-6">
                                            <span class="col-2 cargoCountBtn" @click="decrement"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                            <input class="col-8 cargoCountText" type="text" v-model="quantity">
                                            <span class="col-2 cargoCountBtn" @click="increment"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </div>
                                        <!--運費說明-->
                                        <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }" class="cargoBtn col-md-12 col-lg-6">
                                            <span class="cargoClick explainBtn" @click="toggleTermsPopup"><i class="fas fa-truck"></i>運費說明</span>
                                        </div>
                                        <!--購買按鍵-->
                                        <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }" class="cargoBtn col-md-12 col-lg-12">
                                            <?php if ($product['sales_status'] == 0) : ?>
                                                <span class="cargoClick buyBtn" @click="add_cart('<?= base_url() . 'checkout' ?>')"><i class="fas fa-cart-plus"></i>馬上購買</span>
                                            <?php elseif ($product['sales_status'] == 2) : ?>
                                                <span class="cargoClick buyBtn" @click="add_cart('<?= base_url() . 'checkout' ?>')"><i class="fas fa-cart-plus"></i>馬上預購</span>
                                            <?php else : ?>
                                                <span class="cargoClick buyBtn"><i class="fas fa-cart-plus"></i>商品售完</span>
                                            <?php endif; ?>
                                        </div>
                                        <!--加入購物車-->
                                        <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }" class="cargoBtn col-md-12 col-lg-6">
                                            <span class="cargoClick cartBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>加入購物車</span>
                                        </div>
                                        <!--加入追蹤清單-->
                                        <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }" class="cargoBtn col-md-12 col-lg-6">
                                            <span class="cargoClick likeBtn" @click="add_like"><i class="fas fa-heart"></i>加入追蹤清單</span>
                                        </div>
                                    <?php else : ?>
                                        <div class="cargoText col-sm-12 col-md-12 col-lg-12">
                                            <div class="paddingFixTop">
                                                <div class="item text-center">⭐該商品尚未新增方案⭐</div><br>
                                                <div class="item text-center">⭐有任何疑問請洽客服⭐</div><br>
                                                <div class="item text-center">⭐我們將盡速為您服務⭐</div><br>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (empty($productCombine)) : ?>
                                        <?php require('product-contact.php'); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Cargo description -->
                        <div class="col-12 cargoDescription">
                            <ul class="tab reset">
                                <li class="current">
                                    <span>商品介紹&nbsp;<i class='fas fa-angle-down'></i></span>
                                </li>
                            </ul>
                            <?php echo $product['product_description']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- mfp -->
    <div id="termsPopupWrapper">
        <div id="termsOfMembership" class="mfp-hide">
            <div id="languageSelector"> <!-- 語言選擇器放在這裡 -->
                <select id="languageSelect">
                    <option value="zh_tw">繁體中文</option>
                    <option value="zh_cn">简体中文</option>
                    <option value="ja_jp">日本語</option>
                    <option value="en_us">English</option>
                    <!-- 其他語言選項 -->
                </select>
            </div>
            <div class="col-12 text-center">
                <span class="memberTitleMember">FREIGHT<span class="memberTitleLogin">&nbsp;DESCRIPTION</span></span>
            </div>
            <div class="memberTitleChinese col-12 text-center"><?= !empty($instructions['page_title']) ? $instructions['page_title'] : ''; ?></div>
            <div class="membershipLine"></div>
            <div class="membershipContent">
                <?php echo !empty($instructions['page_info']) ? $instructions['page_info'] : ''; ?>
            </div>
        </div>
    </div>
</div>

<script>
    /* JavaScript 初始化 Slick Carousel */
    $(document).ready(function() {
        $('.big-slick').slick({
            speed: 500,
            focusOnSelect: true,
            draggable: false,
            infinite: false,
            fade: true,
            cssEase: 'cubic-bezier(0.215, 0.610, 0.355, 1.000)',
            asNavFor: '.small-slick', // 聯繫小圖輪播
            prevArrow: $('.album-prev'), // 上一張箭頭
            nextArrow: $('.album-next'), // 下一張箭頭
            // 可以根據需要添加其他選項
        });

        // 初始化小圖輪播
        $('.small-slick').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            easing: 'easeOutQuart',
            asNavFor: '.big-slick', // 聯繫大圖輪播
            arrows: false,
            speed: 500,
            infinite: false,
            // centerMode: true,
            swipeToSlide: true,
            focusOnSelect: true,
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 5,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 5,
                    }
                },
                {
                    breakpoint: 544,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 440,
                    settings: {
                        slidesToShow: 3,
                    }

                }
            ]
            // 可以根據需要添加其他選項
        });
    });
</script>

<script>
    // 等待載入
    document.addEventListener("DOMContentLoaded", function() {
        $('.big-slick').on('init', function() {
            $('.album').css('visibility', 'visible');
            $('.share').css('visibility', 'visible');
        });
    });
</script>

<script>
    // 語言切換
    $(document).ready(function() {
        $('#languageSelect').change(function() {
            var lang = $(this).val();
            $.ajax({
                url: '/product/language_switch', // 請替換為你的後端腳本位置
                method: 'POST',
                data: {
                    lang: lang
                },
                success: function(response) {
                    // console.log(response);
                    // 更新內容
                    $('#termsOfMembership .memberTitleChinese').html(response.page_title);
                    $('#termsOfMembership .membershipContent').html(response.page_info);
                }
            });
        });
    });
</script>

<script>
    const productApp = Vue.createApp({
        data() {
            return {
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                products_categories: <?php echo json_encode(!empty($product_category) ? $product_category : ''); ?>, // products_category資料庫所有類及項目
                combine: <?php echo json_encode(!empty($combine) ? $combine : ''); ?>,
                selectedDescription: <?php echo json_encode(!empty($product) ? $product['product_note'] : ''); ?>,
                selectedCombine: null,
                selectedCategoryId: 0,
                searchText: '', // debug
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                hiddenSearch: false, // search-box
                quantity: 1, // 商品選擇數量
            };
        },
        mounted() {
            // initial option
            this.selectedCombine = this.combine[0];
            // 初始化 Magnific Popup
            this.initMagnificPopup();
            // init btn state
            if (this.products_categories && this.products_categories.length > 0) {
                this.selectedCategoryId = 0;
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                }
            }
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
            updateSelectedCombine(event) {
                // 取得所選方案的名稱
                this.selectedCombine = this.combine.find(self => self.pname === event.target.value);
                // console.log(event.target.value);
            },
            // 商品數量選擇
            increment() {
                // 當按下 "+" 按鈕時，增加數量
                this.quantity = parseInt(this.quantity, 10);
                this.quantity += 1;
            },
            decrement() {
                // 當按下 "-" 按鈕時，減少數量，但確保數量不小於 1
                this.quantity = parseInt(this.quantity, 10);
                this.quantity = Math.max(1, this.quantity - 1);
            },
            // 參加抽選
            participation() {
                // 檢查登入
                <?php if (empty($this->session->userdata('user_id'))) : ?>
                    alert('請先登入再進行抽選報名。');
                    window.location.href = "<?php echo base_url() . 'auth' ?>"; // 添加引號
                    return;
                <?php elseif (empty($this->session->userdata('email')) || empty($this->session->userdata('phone'))) : ?>
                    alert('請先設定電子郵件及手機號碼再進行抽選報名。');
                    window.location.href = "<?php echo base_url() . 'auth?=5' ?>"; // 添加引號
                    return;
                <?php endif; ?>

                $.ajax({
                    url: '/product/add_lottery/<?= $product['product_id'] ?>',
                    method: 'post',
                    data: {},
                    success: function(response) {
                        if (response == 'success') {
                            alert('恭喜您！報名成功囉！');
                        } else if (response == 'repetitive') {
                            alert('您已經報名過囉！');
                        } else if (response == 'non-exist') {
                            alert('抽選活動尚未建立！');
                        } else {
                            alert('發生不明錯誤');
                        }
                    },
                })
            },
            // 加入購物車(待修)
            add_cart(hrefTarget) {
                // 檢查登入
                <?php if (empty($this->session->userdata('user_id'))) : ?>
                    alert('請先登入再進行操作。');
                    window.location.href = "<?php echo base_url() . 'auth' ?>"; // 添加引號
                    return;
                <?php endif; ?>

                // 檢查商品數量及限制數量
                this.quantity = parseInt(this.quantity, 10);
                if (this.quantity < 1) {
                    alert('商品數量不得低於1個');
                    return;
                }
                if (this.selectedCombine.limit_enable == 'YES' && this.quantity > this.selectedCombine.limit_qty) {
                    alert('商品數量不得超過' + this.selectedCombine.limit_qty + '個');
                    return;
                }
                $.ajax({
                    url: "/cart/add_combine",
                    method: "POST",
                    data: {
                        combine_id: this.selectedCombine.id,
                        qty: this.quantity,
                        specification_name: '',
                        specification_id: '',
                        specification_qty: '',
                    },
                    success: function(data) {
                        if (data == 'contradiction_date') {
                            alert('預購商品若不同月份不得一並選購，敬請見諒。');
                        } else if (data == 'contradiction') {
                            alert('預購商品不得與其他類型商品一並選購，敬請見諒。');
                        } else if (data == 'exceed') {
                            alert('超過限制數量故無法下單，敬請見諒。');
                        } else if (data == 'updateSuccessful') {
                            if (hrefTarget != '' && hrefTarget != null) {
                                // console.log(data);
                                window.location.href = hrefTarget;
                            } else {
                                alert('成功更新購物車');
                            }
                        } else if (data == 'successful') {
                            if (hrefTarget != '' && hrefTarget != null) {
                                // console.log(data);
                                window.location.href = hrefTarget;
                            } else {
                                alert('成功加入購物車');
                            }
                        } else {
                            console.log(data);
                        }
                        get_cart_qty();
                    }
                });
            },
            add_like() {
                // 檢查登入
                <?php if (empty($this->session->userdata('user_id'))) : ?>
                    alert('請先登入再進行操作。');
                    window.location.href = "<?php echo base_url() . 'auth' ?>"; // 添加引號
                    return;
                <?php endif; ?>

                $.ajax({
                    url: "/product/add_like",
                    method: "POST",
                    data: {
                        combine_id: this.selectedCombine.id,
                    },
                    success: function(data) {
                        if (data == 'successful') {
                            alert('成功加入追蹤清單');
                        } else if (data == 'repetity') {
                            alert('該商品已在追蹤清單內');
                        } else {
                            console.log(data);
                        }
                    }
                });
            },
            filterByCategory(categoryId) {
                window.location.href = <?= json_encode(base_url()) ?> + 'product/index' + (categoryId != null ? '?id=' + categoryId : '');
            },
            // 篩選清單呼叫
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
        },
    });
    productApp.mount('#productApp');
</script>