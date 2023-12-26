<div id="productApp" role="main" class="main pt-signinfo">
    <section class="sectionRejust">
        <!-- Menu -->
        <?php require('product-menu.php'); ?>
        <div class="section-contents">
            <?php if (!empty($productCategory)) : ?>
                <div class="container">
                    <h1><span><?= $productCategory['product_category_name']; ?></span></h1>
                </div>
            <?php endif; ?>
            <!-- 商品詳情 -->
            <div id="productDetailStyle" class="productDetailStyle">
                <div class="row productDetail">
                    <?php if (!empty($product)) : ?>
                        <div class="col-bg-12 col-md-6 col-lg-6">
                            <img class="product_img_style" src="/assets/uploads/<?= $product['product_image']; ?>">
                        </div>
                        <div class="col-bg-12 col-md-6 col-lg-6">
                            <div class="row">
                                <!--商品名稱-->
                                <h2 class="cargoTitle col-bg-12 col-md-12 col-lg-12"><?= $product['product_name']; ?></h2>
                                <!--商品簡介:多行文字欄位-->
                                <!-- <div class="cargoText col-bg-12 col-md-12 col-lg-12">待新增</div> -->
                                <!--價格-->
                                <div class="cargoText col-bg-12 col-md-12 col-lg-12">
                                    <?php if (!empty($productCombine)) : ?>
                                        <div v-if="selectedCombineName != '請選擇方案'" class="item">方案價:&nbsp;$&nbsp;{{ selectedCombine.current_price }}</div>
                                        <div v-if="selectedCombineName == '請選擇方案'" class="item">❌尚未選擇方案</div>
                                    <?php else : ?>
                                        <div class="paddingFixTop">
                                            <div class="item text-center">⭐該商品尚未新增方案⭐</div><br>
                                            <div class="item text-center">⭐有任何疑問請洽客服⭐</div><br>
                                            <div class="item text-center">⭐我們將盡速為您服務⭐</div><br>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($productCombine)) : ?>
                                    <!--方案選擇-->
                                    <select @change="updateSelectedCombine($event)" v-model="selectedCombineName" id="combineSelect" class="cargoBtn col-bg-12 col-md-12 col-lg-12">
                                        <option value="請選擇方案" selected disabled>請選擇方案</option>
                                        <?php foreach ($productCombine as $self) : ?>
                                            <option value="<?php echo $self['name']; ?>">
                                                <?php echo $self['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!--商品數量-->
                                    <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }"  class="row cargoBtn col-12">
                                        <span class="col-2 cargoCountBtn" @click="decrement"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                        <input class="col-8 cargoCountText" type="text" v-model="quantity">
                                        <span class="col-2 cargoCountBtn" @click="increment"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                    </div>
                                    <!--購買按鍵-->
                                    <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }"  class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                                        <?php if ($product['sales_status'] == 0) : ?>
                                            <span class="cargoClick buyBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>馬上購買</span>
                                        <?php elseif ($product['sales_status'] == 2) : ?>
                                            <span class="cargoClick buyBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>馬上預購</span>
                                        <?php else : ?>
                                            <span class="cargoClick buyBtn"><i class="fas fa-cart-plus"></i>商品售完</span>
                                        <?php endif; ?>
                                    </div>
                                    <!--加入購物車-->
                                    <div v-bind:style="{ visibility: selectedCombine ? 'visible' : 'hidden' }"  class="cargoBtn col-bg-12 col-md-12 col-lg-6">
                                        <span class="cargoClick cartBtn" @click="add_cart()"><i class="fas fa-cart-plus"></i>加入購物車</span>
                                    </div>
                                <?php endif; ?>

                                <?php if (empty($productCombine)) : ?>
                                    <?php require('product-contact.php'); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Cargo description -->
                        <div class="col-12 cargoDescription">
                            <ul class="tab reset">
                                <li class="current">
                                    <span>商品介紹</span>
                                </li>
                            </ul>
                            <?php echo $product['product_description']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const productApp = Vue.createApp({
        data() {
            return {
                hiddenSearch: true,
                getID: <?php echo json_encode($this->input->get('id', TRUE)); ?>, // 若透過header或footer篩選
                products_categories: <?php echo json_encode($product_category); ?>, // products_category資料庫所有類及項目
                combineName: <?php echo json_encode($combineName); ?>,
                selectedCombine: null,
                selectedCombineName: '請選擇方案',
                selectedCategoryId: 0,
                searchText: '', // debug
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
                quantity: 1, // 商品選擇數量
            };
        },
        mounted() {
            // init btn state
            if (this.products_categories && this.products_categories.length > 0) {
                this.selectedCategoryId = 0;
                if (this.getID && this.getID.length > 0) {
                    this.selectedCategoryId = this.getID;
                }
            }
        },
        methods: {
            updateSelectedCombine(event) {
                // 取得所選方案的名稱
                this.selectedCombineName = event.target.value;
                this.selectedCombine = this.combineName.find(self => self.name === this.selectedCombineName);
                // console.log(this.selectedCombineName);
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
            // 加入購物車(待修)
            add_cart() {
                if (this.quantity < 1) {
                    alert('商品不能低於1個');
                    return;
                }
                $.ajax({
                    url: "/cart/add_combine",
                    method: "POST",
                    data: {
                        combine_id: this.selectedCombine.id,
                        qty: this.quantity,
                        specification_name: 'Testname',
                        specification_id: 'Testid',
                        specification_qty: 'Textqty',
                    },
                    success: function(data) {
                        if (data == 'contradiction') {
                            alert('預購商品不得與其他類型商品一並選購，敬請見諒。');
                        } else {
                            alert('加入成功');
                        }
                        get_cart_qty();
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