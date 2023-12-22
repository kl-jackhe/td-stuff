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

    .carousel-fade .carousel-item {
        opacity: 0;
        transition-duration: 2s;
        transition-property: opacity;
    }

    .carousel-fade .carousel-item.active,
    .carousel-fade .carousel-item-next.carousel-item-left,
    .carousel-fade .carousel-item-prev.carousel-item-right {
        opacity: 1;
    }

    .carousel-fade .active.carousel-item-left,
    .carousel-fade .active.carousel-item-right {
        opacity: 0;
    }

    .carousel-fade .carousel-item-next,
    .carousel-fade .carousel-item-prev,
    .carousel-fade .carousel-item.active,
    .carousel-fade .active.carousel-item-left,
    .carousel-fade .active.carousel-item-prev {
        transform: translateX(0);
        transform: translate3d(0, 0, 0);
    }

    #home_product {
        align-items: baseline;
        font-size: 18px;
        line-height: 20px;
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

    #home_product span {
        display: block;
        /* 讓 <span> 變成區塊元素，以便使用寬度屬性 */
        width: 100%;
        /* 設定 <span> 的寬度 */
        white-space: nowrap;
        /* 防止文字換行 */
        overflow: hidden;
        /* 隱藏超出寬度的內容 */
        text-overflow: ellipsis;
        /* 顯示省略號 */
    }

    #zoomA {
        transition: transform ease-in-out 0s;
    }

    #zoomA:hover {
        transform: scale(1.05);
    }

    .select_product {
        background-color: #68396D;
        color: #fff !important;
        width: 50%;
        line-height: 1.8;
        padding: 0;
    }

    .product_img_style {
        border-radius: 15px;
        max-width: 900px;
        max-height: 900px;
        width: 100%;
        margin-bottom: 15px;
    }

    .product_box {
        padding: 25px;
    }

    .carousel_box {
        padding: 0px 25px 0px 25px;
    }

    .page-header {
        padding-left: 30px;
        padding-right: 30px;
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .ipad_w {
            max-width: 50%;
            flex: 0 0 50%;
        }
    }

    @media (max-width: 767px) {
        #home_product .product_name {
            line-height: 20px;
        }

        .product_box_list {
            padding: 0px 30px 0px 30px;
        }

        .product_box {
            padding: 30px 0px 0px 0px;
            ;
        }

        .carousel_box {
            padding: 0px;
        }

        .page-header {
            padding-left: 0px;
            padding-right: 0px;
        }
    }
</style>
<div role="main" class="main">
    <section class="page-header no-padding sm-slide-fix content_auto_h">
        <? if (!empty($banner)) { ?>
            <div class="container">
                <div class="carousel_box">
                    <div id="home-carousel" class="carousel slide carousel-fade" data-touch="false" data-interval="false">
                        <ol class="carousel-indicators" style="bottom: -20px;">
                            <? for ($i = 0; $i < count($banner); $i++) { ?>
                                <li data-target="#home-carousel" data-slide-to="<?= $i ?>" <?= ($i == 0 ? 'class="active"' : '') ?>></li>
                            <? } ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php $count = 0;
                            foreach ($banner as $data) { ?>
                                <div class="carousel-item <?= ($count == 0 ? 'active' : '') ?>">
                                    <a href="<?= $data['banner_link'] ?>" target="<?= ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                                        <img class="d-block w-100" style="width: 100%;" src="/assets/uploads/<?= $data['banner_image'] ?>">
                                    </a>
                                </div>
                            <?php $count++;
                            } ?>
                        </div>
                        <a class="carousel-control-prev" href="#home-carousel" role="button" data-slide="prev" style="font-size: 24px;">
                            <i class="fa-solid fa-circle-chevron-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#home-carousel" role="button" data-slide="next" style="font-size: 24px;">
                            <i class="fa-solid fa-circle-chevron-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        <? } ?>
        <div class="container">
            <div class="row product_box">
                <div class="col-md-12">
                    <span style="font-size:24px;">最新商品</span>
                    <hr style="border-top: 1px solid #988B7A;margin: 10px 0px 25px 0px;">
                </div>
                <div class="col-md-12 text-center">
                    <div class="row justify-content-center product_box_list" id="home_product">
                        <? if (!empty($products)) {
                            $count = 0;
                            foreach ($products as $product) {
                                if ($count < 12) { ?>
                                    <div class="col-md-4 pb-5 ipad_w">
                                        <a href="/product/view/<?= $product['product_id'] ?>">
                                            <? if (!empty($product['product_image'])) { ?>
                                                <img id="zoomA" class="product_img_style" src="/assets/uploads/<?= $product['product_image']; ?>">
                                            <? } else { ?>
                                                <img id="zoomA" class="product_img_style" src="/assets/uploads/Product/img-600x600.png">
                                            <? } ?>
                                            <div class="product_name">
                                                <span>
                                                    <?= $product['product_name']; ?></span>
                                            </div>
                                        </a>
                                        <!-- <div class="product_price">
                                        $<span style="color:#68396D">
                                            <?= $product['product_price']; ?></span>
                                    </div> -->
                                        <? if ($product['sales_status'] == 0) { ?>
                                            <a class="btn select_product my-2" href="/product/view/<?= $product['product_id'] ?>">
                                                <span>現貨</span>
                                            </a>
                                        <? } ?>
                                        <? if ($product['sales_status'] == 1) { ?>
                                            <a class="btn select_product my-2" style="background: #817F82;" href="/product/view/<?= $product['product_id'] ?>">
                                                <span>售完</span>
                                            </a>
                                        <? } ?>
                                        <? if ($product['sales_status'] == 2) { ?>
                                            <a class="btn select_product my-2" style="background: #A60747;" href="/product/view/<?= $product['product_id'] ?>">
                                                <span>預購</span>
                                            </a>
                                        <? } ?>
                                    </div>
                        <? }
                                $count++;
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>