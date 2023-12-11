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
    <link href="/assets/bootstrap-4.2.1-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="/assets/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/solid.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/jquery.steps.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/main.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/normalize.css" rel="stylesheet">
    <?php if ($this->is_partnertoys) : ?>
        <link href="/assets/css/mostPage.css" rel="stylesheet">
        <link href="/assets/magnific-popup/magnific-popup.css" rel="stylesheet">
        <script src="/assets/magnific-popup/jquery.magnific-popup.min.js"></script>
    <?php endif; ?>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://unpkg.com/vue-router@4"></script>
</head>
<style>
    .top_logo_style {
        max-width: <?= (get_setting_general('logo_max_width') != '' ? get_setting_general('logo_max_width') . 'px' : '130px') ?>;
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 40%;
    }
</style>

<body>
    <div class="body h-100">
        <header id="header">
            <div class="container-fluid">
                <div class="row py-2 justify-content-center header_fixed_top">
                    <div class="col-5 col-md-3 col-lg-2" style="align-self: center;">
                        <a href="<?php echo base_url() ?>">
                            <img class="header_logo" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-7 d-none d-md-none d-lg-block d-xl-block" style="align-self: center;">
                        <div class="row justify-content-end">
                            <div class="col-12 text-right ">
                                <a href="/product" class="nav_item_style">夥伴商城</a>
                                <a href="/about" class="nav_item_style">關於夥伴</a>
                                <a href="/posts" class="nav_item_style">最新訊息</a>
                                <a href="#" class="nav_item_style">合作介紹</a>
                                <a href="#" class="nav_item_style">經銷通路</a>
                                <a href="#" class="nav_item_style">會員專區</a>
                                <a href="#" class="nav_item_style" style="border: 2px solid #615d56;border-radius: 30px;padding: 1px 15px 1px 15px; background-color: transparent;">登入</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-7 d-block d-md-block d-lg-none d-xl-none p-0" style="align-self: center;">
                        <nav class="navbar navbar-expand-lg navbar-light" style="float: right;">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                                <img src="/assets/images/559mall_official/icon/web%20icon_menu.png" style="width:30px;">
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <div class="row" style="position: relative;z-index: 99;">
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav">
                    <li class="nav_item_mb_style">
                        <a href="/product" class="nav_item_style">夥伴商城</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="/about" class="nav_item_style">關於夥伴</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="/posts" class="nav_item_style">最新訊息</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">合作介紹</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">經銷通路</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">會員專區</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style" style="color: #000;text-decoration:none;border: 2px solid #615d56;border-radius: 30px; background-color: transparent;padding: 1px 15px 1px 15px;">登入</a>
                    </li>
                </ul>
            </div>
        </div>