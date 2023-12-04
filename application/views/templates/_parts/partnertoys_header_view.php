<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
</head>
<style>
    body {
        font-family: Open Sans, "Microsoft JhengHei";
    }
    a {
        outline: none;
        text-decoration: none;
    }
    .top_logo_style {
        max-width: <?=(get_setting_general('logo_max_width') != '' ? get_setting_general('logo_max_width') .'px' : '130px')?>;
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 40%;
    }
    .header_relative_top {
        background-color: #fff;
        position: relative;
        z-index: 999;
    }
    .header_fixed_top {
        background-color: #fff;
        position: fixed;
        box-shadow: 0 5px 30px 5px #E0E0E0;
        width: 100%;
        top: 0;
        z-index: 1030;
    }
    .header_logo {
        width: 70%;
    }
    #navbarToggler {
        position: fixed;
        top: 7%;
        z-index: 9999;
        background-color: rgb(245, 242, 236);
        height: 100%;
        min-height: 2000px;
        padding: 6% 20px 15px 20px;
    }
    .nav_item_style {
        font-weight: bold;
        align-self: center;
        margin-right: 20px;
        font-size: 18px;
        color: #000;
        padding: 10px;
    }
    .nav_item_style:hover {
        color: rgba(239,132,104,1.0) !important;
    }
    .nav_item_mb_style {
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .fixed_icon_style {
        font-size: -webkit-xxx-large;
        max-width: 40px;
    }
    .header_fixed_icon {
        left: auto;
        right: 25px;
        bottom: 60px;
    }
    #fa-instagram-square a {
        color: #DD2A7B;
    }
    #fa-instagram-square a:hover {
        color: #8134AF;
    }
    #fa-bag-shopping a {
        color: #ff5a00;
    }
    #fa-bag-shopping a:hover {
        color: #ef8468;
    }
    .icon_pointer {
        cursor: pointer;
    }
    #v-pills-tab-other a {
        color: #fff;
    }
    #v-pills-tab-other a:hover {
        color: #888787;
    }
    .footer-company-info h2 {
        font-weight: bold;
    }
    .footer-company-info a {
        color: #000;
    }
    .footer-company-info a:hover {
        color: #d35448;
        text-decoration: underline;
    }
    .footer-company-info {
        background-color: #faf5f3;
        padding-bottom: 25px;
        padding-top:25px;
        box-shadow: 0 5px 30px 5px #E0E0E0;
        font-size: 16px;
    }
    .footer-copyright {
        background-color: #d35448;
        padding-bottom: 25px;
        padding-top:25px;
        box-shadow: 0 5px 30px 5px #E0E0E0;
        color: #fff;
        font-size: 14px;
    }
    #footer {
        margin-top: 30px;
    }
    #cart-qty {
        color: #BE2633;
        position: absolute;
        top: -30px;
        right: 5px;
        background: #D1D1D1;
        border-radius: 50px;
        width: 23px;
        height: 23px;
        text-align: center;
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .header_logo {
            width: 100%;
        }
        .top_logo_style {
            position: relative;
            transform: none;
            left: -10px;
            top: 0;
        }
    }
    @media (max-width: 767px) {
        .header_logo {
            width: 100%;
        }
        .navbar-toggler {
            padding: 0.45rem 0.75rem;
            left: 0px;
            top: 5px;
            position: relative;
        }
        .m_padding {
            padding: 0px !important;
        }
        .top_logo_style {
            position: relative;
            transform: none;
            left: -35%;
            top: 0;
        }
        .m_hr_border {
            padding-right: 15px !important;
            padding-left: 15px !important;
        }
        .header_fixed_icon {
            right: 9px;
        }
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
                                <a href="#" class="nav_item_style">關於夥伴</a>
                                <a href="/Posts" class="nav_item_style">最新訊息</a>
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
                        <a href="#" class="nav_item_style">關於夥伴</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="/Posts" class="nav_item_style">最新訊息</a>
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