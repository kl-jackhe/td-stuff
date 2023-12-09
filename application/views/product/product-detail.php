<div v-if="selectedProduct" class="productDetailStyle">
    <div class="returnBtnStyle text-right">
        <span class="returnBtn" @click="hideProductDetails">
            <i class="fa fa-times" aria-hidden="true"></i>
        </span>
    </div>
    <hr>
    <div class="row productDetail">
        <div class="col-bg-12 col-md-6 col-lg-6">
            <img class="product_img_style" :src="'/assets/uploads/' + selectedProduct.product_image">
        </div>
        <div class="col-bg-12 col-md-6 col-lg-6">
            <!--商品名稱-->
            <h2 class="name">{{ selectedProduct.product_name }}</h2>
            <!--價格-->
            <div class="price">
                <!--一律顯示原售價-->
                <div class="clearfix">
                    <div class="item">售價</div>
                    <div class="info">$ {{ selectedProduct.product_price }}</div>
                </div>
            </div>
            <!--商品簡介:多行文字欄位-->
            <div class="summary">
                變種吉娃娃 2<br>
                Godgwawa 2<br>
                <br>
                商品詳細規格：<br>
                尺寸：每隻角色約5-7cm​<br>
                材質：PVC塑膠<br>
                售價：一中盒720元 / 一中盒必含基礎5款+1款隨機重複基礎款或夥伴賞。
            </div>
            <select name="pdid" class="size-select" id="pdid_sele" onchange="search_stock()" required="" oninvalid="setCustomValidity('請選取一個清單中的項目')" oninput="setCustomValidity('')">
                <option value="">請選擇規格</option>
                <option value="418" selected="">變種吉娃娃2 一中盒(內含6小盒)</option>
            </select>
            <div class="newQty m20">
                <div class="input-group bootstrap-touchspin">
                    <div id="myData_stock">
                        <div class="" style="border-bottom:0px;">
                            <div style="float:left;max-width:150px;">
                                <div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input id="ccnum" class="btn_num border-0 form-control" type="text" value="" name="demo" style="text-align: center; display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>
                            </div> <input type="hidden" id="num_st" name="num_st" value="9832"> <input type="hidden" id="num_st418" name="num_st418" value="9832">
                        </div>
                    </div>
                </div>
                <a href="#termsBox" title="運費說明" class="linkLine"><i class="fas fa-truck"></i>運費說明</a>
            </div>
            <div class="btn-box">
                <div class="col-sm-12 col-md-12" style="padding: 0px;margin-bottom: 20px;">
                    <span id="buy_now" title="馬上購買" class="btn btn-primary" style="font-size: 16px;border-radius: 0px;width: 100%;"><i class="fas fa-cart-plus"></i>馬上購買</span>
                </div>
                <div class="col-sm-12 col-md-6" style="padding: 0px;">
                    <button type="submit" title="加入購物車" class="cart" id="but_add1"><i class="fas fa-cart-plus"></i>加入購物車</button>
                </div>
                <div class="col-sm-12 col-md-6 text-right" style="padding: 0px;">
                    <a href="../member/login.php?msg=lo11" title="請先登入會員" class="wish" disabled=""><i class="fas fa-heart"></i>加入追蹤清單</a>
                </div>
            </div>
        </div>
        <!-- Cargo description -->
        <div>{{ selectedProduct.product_description }}</div>
        <!-- Add a button for scrolling to the top -->
        <span @click="scrollToProductDetailTop" class="scrollToProductDetailTop" :class="{ 'hidden': isScrollAtTop }">Top</span>
    </div>
</div>