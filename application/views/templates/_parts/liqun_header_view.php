<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo get_setting_general('meta_description') ?>" />
    <meta name="keywords" content="<?php echo get_setting_general('meta_keywords') ?>" />
    <meta property="og:locale" content="zh_TW" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $page_title; ?> | <?php echo get_setting_general('name') ?>" />
    <meta property="og:url" content="<?php echo base_url() ?>" />
    <meta property="og:site_name" content="<?php echo get_setting_general('name') ?>" />
    <meta property="og:image" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:card" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:title" content="<?php echo $page_title; ?> | <?php echo get_setting_general('name') ?>" />
    <title><?php echo $page_title; ?> | <?php echo get_setting_general('name') ?></title>
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap-4.2.1-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-O3V5tIx58a39zzbFB7F9SCp5aS58D+XlALL0s3Oj2IXdpgtmC8QFBgC6NXhYQnhK" crossorigin="anonymous">
    <link href="/assets/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/solid.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/jquery.steps.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/main.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/normalize.css" rel="stylesheet">
    <link href="/assets/css/liqunPage.css?v=1.5" rel="stylesheet">
    <link href="/assets/magnific-popup/magnific-popup.css" rel="stylesheet">
    <!-- jquery一定要在最上面 -->
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/assets/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <!-- <script src="https://unpkg.com/vue@next"></script> -->
    <script src="https://unpkg.com/vue-router@4"></script>
</head>

<body>
    <div class="body h-100">
        <header id="header">
            <div class="container">
                <div class="row py-2 justify-content-center header_fixed_top">
                    <div class="col-md-12 col-lg-12 d-none d-md-block d-lg-block d-xl-block" style="align-self: center;">
                        <div class="row justify-content-end">
                            <div class="col-12 text-right nav_item_style">
                                <a href="/">回首頁</a>
                                <span> ｜ </span>
                                <a href="/product">全品項</a>
                                <span> ｜ </span>
                                <?php if (empty($this->session->userdata('user_id'))) { ?>
                                    <a href="/auth">會員中心</a>
                                <? } else { ?>
                                    <a href="javascript:void(0)" onclick="linkToCoupon()">優惠券（<span><?= get_customer_coupon_count($this->session->userdata('user_id')) ?></span>）</a>
                                    <span> ｜ </span>
                                    <a href="/auth">會員中心</a>
                                    <span> ｜ </span>
                                    <a href="/logout">登出</a>
                                <? } ?>
                                <span> ｜ </span>
                                <a href="#" data-toggle="modal" style="position: relative;" data-target="#my_cart" onclick="get_mini_cart();">
                                    <span id="cart-qty">購物車（<span>0</span>）</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-block d-md-none d-lg-none d-xl-none p-0" style="align-self: center;">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-3">
                                <nav class="navbar navbar-expand-lg navbar-light">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                </nav>
                            </div>
                            <div class="col-3 text-center">
                                <a href="#" data-toggle="modal" style="position: relative;" data-target="#my_cart" onclick="get_mini_cart();">
                                    <div id="cart-qty"><span>0</span></div>
                                    <i class="fa-solid fa-cart-shopping fixed_icon_style" style="font-size: 28px;color: #fff;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="row" style="position: relative;z-index: 99;">
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav nav_item_mb_style nav_item_style" style="width: 120px;">
                    <li>
                        <a href="/">回首頁</a>
                    </li>
                    <li>
                        <a href="/product">全品項</a>
                    </li>
                    <?php if (!$this->ion_auth->logged_in()) { ?>
                        <li>
                            <a href="/login">登入 <i class="fa-solid fa-right-to-bracket"></i></a>
                        </li>
                    <? } else { ?>
                        <li>
                            <a href="/auth">會員中心</a>
                        </li>
                        <li>
                            <a href="/logout">登出 <i class="fa-solid fa-right-from-bracket"></i></a>
                        </li>
                    <? } ?>
                    <li>
                        <hr>
                    </li>
                    <li>
                        冰箱裡有什麼？
                    </li>
                    <?php if (!empty($header_product_tag)) : ?>
                        <?php foreach ($header_product_tag as $self) : ?>
                            <li>
                                <a href="/product_tag/index/<?= $self['id']; ?>"><i class="fa-solid fa-chevron-right"></i> <?= $self['name']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>