<style>
    .product_description img {
        width: 100%;
        max-width: 900px;
        height: 100%;
    }

    .qty {
        width: 40px;
        height: 35px;
        text-align: center;
        border: 0;
        border-top: 1px solid #aaa;
        border-bottom: 1px solid #aaa;
    }

    input.qtyplus {
        width: 25px;
        height: 35px;
        border: 1px solid #aaa;
        background: #f8f8f8;
    }

    input.qtyminus {
        width: 25px;
        height: 35px;
        border: 1px solid #aaa;
        background: #f8f8f8;
    }

    .button_border_style_l {
        border: 1px solid #B5ACA5;
        padding: 0px 5px 0px 5px;
        border-radius: 5px 0px 0px 5px;
        color: #524535;
        background: #fff;
    }

    .button_border_style_r {
        border: 1px solid #B5ACA5;
        padding: 0px 5px 0px 5px;
        border-radius: 0px 5px 5px 0px;
        color: #C52B29;
        background: #fff;
    }

    .input_border_style {
        background-color: #fff !important;
        border-top: 1px solid #B5ACA5;
        border-bottom: 1px solid #B5ACA5;
        padding: 0px;
        height: 26px;
        text-align: center;
    }

    .add_product {
        <? if ($this->is_td_stuff) { ?>background-color: #68396D;
        color: #fff !important;
        <? } ?><? if ($this->is_liqun_food) { ?>background-color: #f6d523;
        color: #000 !important;
        <? } ?><? if ($this->is_partnertoys) { ?>background-color: rgba(239, 132, 104, 1.0);
        color: #fff !important;
        <? } ?>width: 100%;
        line-height: 1.8;
        padding: 0;
    }

    #zoomA {
        transition: transform ease-in-out 0s;
    }

    #zoomA:hover {
        transform: scale(1.05);
    }

    .product_view_img_style {
        border-radius: 15px;
        max-width: 300px;
        max-height: 300px;
        width: 100%;
    }
</style>

<div id="app" role="main" class="main product-view">
    <section class="form-section content_auto_h">
        <div class="container-fluid">
            <div v-if="!isEmpty(product)" class="row justify-content-center">
                <div class="col-md-8 text-center product_description" style="margin-bottom: 35px;">
                    <img v-if="product.is_td_stuff" src="/assets/uploads/Banner/page_banner_free_shipping_1000-1.jpg">
                </div>
                <div class="col-md-8 text-center product_description">
                    <p class="m-0" style="font-size: 28px;">{{ product.product_name }}</p>
                    <div v-if="!isEmpty(product.product_description)">{{ product.product_description }}</div>
                    <div v-else>
                        <h3>暫無商品描述</h3>
                    </div>
                </div>
                <div class="col-md-8 text-center product_description">
                    <p class="m-0" style="font-size: 28px;">{{ product.product_note }}</p>
                </div>
                <!-- <div class="col-md-8 text-center product_description" style="margin-bottom: 35px;">
                    <p v-if="isTdStuff"><img src="/assets/uploads/Banner/page_banner_free_shipping_1000-1.jpg"></p>
                </div>
                <div class="col-md-12 text-center">
                    <p class="m-0" style="font-size: 28px;">方案選擇</p>
                </div> -->
                <!-- <div v-if="!isEmpty(productCombine)" class="col-md-8 py-3">
                    <div class="row justify-content-center">
                        <div v-for="combine in productCombine" :key="combine.id" class="col-md-4 py-2 mb-5 text-center">
                            <img :src="'/assets/uploads/' + (combine.picture || 'Product/img-600x600.png')" class="product_view_img_style" @mouseover="zoomIn(combine.id)" @mouseleave="resetZoom(combine.id)">
                            <div class="pt-2" style="font-size: 16px;">{{ combine.name }}</div>
                            <div v-if="combine.description" class="py-2" style="font-size: 12px;">{{ combine.description }}</div>
                            <div>
                                <span v-if="combine.price != combine.current_price && combine.price != 0" style="color: gray; font-size: 14px; font-style: oblique; text-decoration: line-through;">
                                    原價 <span style="color: gray; font-size: 14px; font-style: oblique;">$ {{ combine.price }}</span>
                                </span>
                                <br>
                                <span style="color: #BE2633; font-size: 16px; font-weight: bold; font-style: oblique;">
                                    方案價 <span style="color: #BE2633; font-size: 16px; font-weight: bold; font-style: oblique;">$ {{ combine.current_price }}</span>
                                </span>
                            </div>
                            <div class="text-center" style="padding-left: 25%; padding-right: 25%;">
                                <div class="input-group my-3">
                                    <button type="button" class="btn btn-number button_border_style_l" @click="decrementQty(combine.id)">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="text" :id="'qty_' + combine.id" class="form-control input-number input_border_style" :value="combine.qty" :disabled="combine.type === 1" />
                                    <button type="button" class="btn btn-number button_border_style_r" @click="incrementQty(combine.id)">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                                <div v-if="combine.type === 1">
                                    <button v-if="canAddToCart(combine)" @click="selectSpecification(combine)" class="btn add_product">
                                        <i class="fa-solid fa-cart-shopping"></i> 選擇規格
                                    </button>
                                    <span v-else class="btn add_product" style="background: #817F82; cursor: auto;">
                                        <i class="fa-solid fa-cart-shopping" disabled></i> 售完
                                    </span>
                                </div>
                                <button v-else @click="addToCart(combine)" class="btn add_product" :style="{ background: combine.type === 2 ? '#A60747' : '' }">
                                    <i class="fa-solid fa-cart-shopping"></i> {{ combine.type === 2 && combine.inventory < combine.qty ? '預購' : (combine.type === 2 ? '選購' : '預購') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
</div>

<script>
    const app = Vue.createApp({
        data() {
            return {
                product: <?php echo json_encode($products); ?>,
                productCombine: <?php echo json_encode($products); ?>,
                combineId: null,
                qty: 1,
            };
        },
        methods: {
            isEmpty(obj) {
                return obj && Object.keys(obj).length === 0;
            },
        },
    })
    app.mount('#app'); // Replace 'app' with the ID of the element where your Vue app is mounted
</script>