<style>
.owl-theme .owl-nav [class*='owl-']:hover {
    background: transparent;
}

.owl-prev {
    color: #DCDEDD !important;
}

.owl-prev:hover {
    color: #585755 !important;
}

.owl-prev:focus {
    border: none !important;
    outline: none !important;
}

.owl-next {
    color: #DCDEDD !important;
}

.owl-next:hover {
    color: #585755 !important;
}

.owl-next:focus {
    border: none !important;
    outline: none !important;
}

.owl-dots {
    width: 100%;
}

#home_product {
    font-size: 18px;
    line-height: 20px;
    align-items: end;
}

#home_product a {
    text-decoration: none;
    color: black;
    transition: 600ms ease 0s;
}

#home_product a:hover {
    color: blue;
}

#home_product .product_name {
    line-height: 35px;
}

#home_product .product_price {
    color: red;
    line-height: 35px;
}
</style>
<div role="main" class="main">
    <section class="page-header no-padding sm-slide-fix" style="padding-left: 30px;padding-right: 30px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 owl-carousel owl-theme item-slide" data-plugin-options='{"items":1, "loop": true, "nav":true, "dots":true,"autoplay": true,"autoplayTimeout": 6000}'>
                    <?php if (!empty($banner)) {foreach ($banner as $data) {?>
                    <a href="<?php echo $data['banner_link'] ?>" target="<?php echo ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                        <img class="img-fluid" style="width: 100%;" src="/assets/uploads/<?php echo $data['banner_image'] ?>">
                    </a>
                    <?php }}?>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center py-5">
                    <h1>熱銷商品</h1>
                </div>
                <div class="col-md-12 text-center">
                    <div class="row justify-content-center" id="home_product">
                        <?
                        if (!empty($products)) {
                            foreach ($products as $product){
                        ?>
                        <div class="col-md-4 pb-5">
                            <a href="/product/view/<?=$product['product_id']?>">
                                <?if (!empty($product['product_image'])) {?>
                                <img style="border-radius: 15px;max-width: 900px;max-height: 900px;width: 100%" src="/assets/uploads/<?=$product['product_image'];?>">
                                <?}else{?>
                                <img style="border-radius: 15px;max-width: 900px;max-height: 900px;width: 100%;" src="/assets/uploads/Product/img-600x600.png">
                                <?}?>
                                <div class="product_name">
                                    <span>
                                        <?=$product['product_name'];?></span>
                                </div>
                            </a>
                            <div class="product_price">
                                <span>$
                                    <?=$product['product_price'];?></span>
                            </div>
                            <a href="/product/view/<?=$product['product_id']?>">
                                <div style="border-radius: 30px;margin-left: 15%;margin-right: 15%;padding-bottom: 10px;padding-top: 10px;border: 1px solid gray;">
                                    <span><i class="fa-solid fa-cart-shopping"></i> 立即選購</span>
                                </div>
                            </a>
                        </div>
                        <?}
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>