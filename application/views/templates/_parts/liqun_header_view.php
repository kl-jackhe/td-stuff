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
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
</head>
<style>
    body {
        font-family: Open Sans, "Microsoft JhengHei";
    }
    #cart-qty {
        color: #BE2633;
        position: absolute;
        top: -10px;
        right: 20px;
        background: #D1D1D1;
        border-radius: 50px;
        width: 23px;
        height: 23px;
        text-align: center;
    }
    #header {
        background-color: #eecfb9;
        color: #161313;
    }
    .top_logo_style {
        max-width: <?=(get_setting_general('logo_max_width') != '' ? get_setting_general('logo_max_width') .'px' : '130px')?>;
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 40%;
    }
    .nav_user_style {
        position:absolute;
        right: 35px;
    }
    .nav_user_style li {
        padding: 5px;
    }
    .nav_user_login_edit {
        border: 1px solid #f6d523;
        color: #000 !important;
        padding: 2px 12px 2px 12px !important;
        outline: none;
    }
    .nav_user_register_logout {
        background: #f6d523;
        color: #000 !important;
        padding: 2px 12px 2px 12px !important;
        outline: none;
    }
    .fixed_icon_style {
        max-width: 50px;
    }
    .header_fixed_icon {
        left: auto;
        right: 25px;
        bottom: 60px;
    }
    .icon_pointer {
        cursor: pointer;
    }
    #footer {
        background-color: #e3dfd9;
    }
    .footer-company-logo {
        padding-bottom: 35px;
        padding-top: 35px;
    }
    .footer-company-info {
        padding-bottom: 20px;
    }
    .footer-company-info a {
        color: #323232;
        position: relative;
        text-decoration: none;
    }
    .footer-company-info a::before {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 100%;
        height: 1.5px; /* 底线高度 */
        background-color: #323232; /* 底线颜色 */
        transition: right 0.3s ease; /* 过渡效果，使底线动画显示 */
    }
    .footer-company-info a:hover::before {
        right: 0;
    }
    .footer-copyright {
        padding-bottom: 20px;
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
    }
    @media (max-width: 767px) {
    }
</style>

<body>
    <div class="body h-100">
        <header id="header">
            <div class="container-fluid">
                <div class="row py-2 justify-content-center header_fixed_top">
                    <div class="col-md-6 col-lg-7 d-none d-md-none d-lg-block d-xl-block" style="align-self: center;">
                        <div class="row justify-content-end">
                            <!-- 回首頁 | 登入 | 註冊 | 會員中心 | 查詢訂單 | 追蹤清單 | 購物車 ( 0 ) -->
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
                                <!-- <img src="/assets/images/559mall_official/icon/web%20icon_menu.png" style="width:30px;"> -->
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </header>