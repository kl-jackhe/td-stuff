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
    }
</style>
<div role="main" class="main">
    <section class="no-padding sm-slide-fix bannerAbsolute">
        <!-- <section class="no-padding sm-slide-fix content_auto_h"> -->
        <!-- First Presentation -->
        <? if (!empty($banner)) : ?>
            <!-- <div class="container"> -->
            <div id="home-carousel" class="carousel slide carousel-fade" data-touch="false" data-interval="false">
                <ol class="carousel-indicators">
                    <? for ($i = 0; $i < (int)(!empty($banner) ? count($banner) : 0); $i++) : ?>
                        <li data-target="#home-carousel" data-slide-to="<?= $i ?>" <?= ($i == 0 ? 'class="active"' : '') ?>></li>
                    <? endfor; ?>
                </ol>
                <div class="carousel-inner">
                    <?php $count = 0; ?>
                    <?php foreach ($banner as $data) : ?>
                        <div class="carousel-item <?= ($count == 0 ? 'active' : '') ?>">
                            <a href="<?= $data['banner_link'] ?>" target="<?= ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                                <!-- pc view -->
                                <img class="d-none d-md-none d-lg-block d-xl-block w-100" src="/assets/uploads/<?= $data['banner_image'] ?>">
                                <!-- mobile view -->
                                <img class="d-block d-md-block d-lg-none d-xl-none w-100" src="/assets/uploads/<?= $data['banner_image_mobile'] ?>">
                            </a>
                        </div>
                        <?php $count++; ?>
                    <?php endforeach; ?>
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
            <!-- </div> -->
        <? endif; ?>

        <!-- Second Presentation -->
        <div class="header-second-container">
            <div class="container">
                <div class="homeAppear">
                    <p class="mainText">Products</p>
                    <div class="yukaline"></div>
                    <p class="subText">CARGOS / INFORMATION</p>
                </div>
            </div>
            <div class="product-container">
                <div class="product-row-container">
                    <div class="product-row">
                        <!-- 商品展示區域 -->
                        <?php if (!empty($products)) : ?>
                            <?php $count = 0; ?>
                            <?php foreach ($products as $self) : ?>
                                <?php if ($count < 12) : ?>
                                    <div class="homeProductPreview">
                                        <a href="/product/product-detail/<?= $self['product_id'] ?>" title="">
                                            <div class="homepic">
                                                <img src="/assets/uploads/<?= $self['product_image'] ?>">
                                            </div>
                                            <div class="hometxt">
                                                <span><?= $self['product_name'] ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- 左右按鈕 -->
                <div class="nav-btn prev-btn" onclick="changeProduct(-1)">
                    <span>&lt;</span>
                </div>
                <div class="nav-btn next-btn" onclick="changeProduct(1)">
                    <span>&gt;</span>
                </div>
            </div>

            <div class="container">
                <div class="homeMoreAppear">
                    <a href="/product" class="link sd appear">
                        <p class="text sd appear">❯ More Products</p>
                    </a>
                </div>
            </div>
        </div>
        <!-- Third Presentation -->
        <!-- <div class="header-third-container">
            <div class="container">
                <div class="homeAppear">
                    <p class="mainText">News</p>
                    <div class="yukaline"></div>
                    <p class="subText">TOPICS / INFORMATION</p>
                </div>
            </div>
            <div class="container">
                <?php if (!empty($posts)) : ?>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/assets/uploads/<?= $posts[0]['post_image'] ?>" style="max-width:100%; heigth:auto;">
                        </div>
                        <div class="col-md-8">
                            <?php $count = 0; ?>
                            <?php foreach ($posts as $key => $self) : ?>
                                <?php if ($count < 3) : ?>
                                    <div>
                                        <span><?= substr($self['updated_at'], 0, 10) ?></span>
                                        <span><?= $self['post_title'] ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="container">
                <div class="homeMoreAppear">
                    <a href="/posts" class="link sd appear">
                        <p class="text sd appear">❯ More News</p>
                    </a>
                </div>
            </div>
        </div> -->
    </section>
</div>