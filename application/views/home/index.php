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
    transition: 500ms ease 0s;
}

#home_product a:hover {
    color: #68396D;
}

#home_product .product_name {
    line-height: 35px;
}

#home_product .product_price {
    line-height: 35px;
}
#zoomA {
  /* (A) OPTIONAL DIMENSIONS */
  /*width: 600px;*/
  /*height: auto;*/
  /* (B) ANIMATE ZOOM */
  /* ease | ease-in | ease-out | linear */
  transition: transform ease-in-out 0s;
}
/* (C) ZOOM ON HOVER */
#zoomA:hover { transform: scale(1.1); }
</style>
<div role="main" class="main">
    <section class="page-header no-padding sm-slide-fix" style="padding-left: 30px;padding-right: 30px;">
        <div class="container">
            <div class="row" style="padding: 0px 25px 0px 25px;">
                <div class="col-md-12 owl-carousel owl-theme item-slide" data-plugin-options='{"items":1, "loop": true, "nav":true, "dots":true,"autoplay": true,"autoplayTimeout": 6000}'>
                    <?php if (!empty($banner)) {foreach ($banner as $data) {?>
                    <a href="<?php echo $data['banner_link'] ?>" target="<?php echo ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                        <img class="img-fluid" style="width: 100%;" src="/assets/uploads/<?php echo $data['banner_image'] ?>">
                    </a>
                    <?php }}?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" style="padding:25px">
                <div class="col-md-12 text-center">
                    <span style="font-size:24px;">熱銷商品</span>
                    <hr style="border-top: 1px solid #988B7A;margin: 10px 0px 25px 0px;">
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
                                <img id="zoomA" style="border-radius: 15px;max-width: 900px;max-height: 900px;width: 100%;margin-bottom: 15px;" src="/assets/uploads/<?=$product['product_image'];?>">
                                <?}else{?>
                                <img style="border-radius: 15px;max-width: 900px;max-height: 900px;width: 100%;margin-bottom: 15px;" src="/assets/uploads/Product/img-600x600.png">
                                <?}?>
                                <div class="product_name">
                                    <span>
                                        <?=$product['product_name'];?></span>
                                </div>
                            </a>
                            <div class="product_price">
                                $<span style="color:#68396D">
                                    <?=$product['product_price'];?></span>
                            </div>
                            <a class="btn" style="background-color: #68396D;color: #fff;width: 50%;line-height: 1.8;padding: 0;" href="/product/view/<?=$product['product_id']?>">
                                <span>選購</span>
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