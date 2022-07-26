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
    <title>
        <?php echo $page_title; ?> |
        <?php echo get_setting_general('name') ?>
    </title>
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" /> -->
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Theme CSS -->
    <!-- <link rel="stylesheet" href="/assets/css/theme.css">
    <link rel="stylesheet" href="/assets/css/theme-elements.css?v=201909062146"> -->
    <!-- Current Page CSS -->
    <!-- <link rel="stylesheet" href="/node_modules/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="/node_modules/rs-plugin/css/layers.css">
    <link rel="stylesheet" href="/node_modules/rs-plugin/css/navigation.css"> -->
    <!-- Theme Custom CSS -->
    <!-- <link rel="stylesheet" href="/assets/css/custom.css?v=201912091409"> -->
    <!-- Head Libs -->
    <!-- <script src="/node_modules/modernizr/modernizr.min.js"></script>
    <link rel="stylesheet" href="/assets/admin/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/assets/admin/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link href="/assets/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/solid.css" rel="stylesheet">
    <script defer src="/assets/fontawesome-free-6.1.1-web/js/all.js"></script>
    <!-- Fontawesome -->
    <!-- purchase-steps -->
    <link href="/assets/jquery.steps-1.1.0/jquery.steps.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/main.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/normalize.css" rel="stylesheet">
    <!-- purchase-steps -->
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<style>
    #fa-facebook-square a {
        color: blue;
    }
    #fa-facebook-square a:hover {
        color: #0080FF;
    }
    #fa-line a {
        color: green;
    }
    #fa-line a:hover {
        color: #00BB00;
    }
    #fa-bag-shopping a {
        color: #FF5809;
    }
    #fa-bag-shopping a:hover {
        color: #FF8F59;
    }
    #cart-qty {
        position: absolute;
        right: -5px;
        background: #FFD2D2;
        border-radius: 50px;
        width: 25px;
        height: 25px;
        text-align: center;
    }
    .top_logo_style {
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
        border: 1px solid #534431;
        color: #808080 !important;
        padding: 2px 12px 2px 12px !important;
    }
    .nav_user_register_logout {
        background: #534431;
        color: #fff !important;
        padding: 2px 12px 2px 12px !important;
    }
    .fixed_icon_style {
        left: auto;right: 25px;bottom: 60px;
    }
    .fixed_icon_style i {
        font-size: 48px;
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .top_logo_style {
            position: relative;
            transform: none;
            left: -10px;
            top: 0;
        }
        .nav_user_style {
            position: relative;
            right: 0;
            width: 12%;
            left: 10px;
        }
    }
    @media (max-width: 767px) {
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
        .nav_user_style {
            position: relative;
            right: -10px;
            width: 30%;
        }
        .m_hr_border {
            padding-right: 15px !important;
            padding-left: 15px !important;
        }
    }
</style>

<body>
    <div class="body h-100">
        <div class="fixed-bottom fixed_icon_style">
            <div id="fa-facebook-square" class="py-1">
                <a href="#">
                    <i class="fa-brands fa-facebook-square"></i>
                </a>
            </div>
            <div id="fa-line" class="py-1">
                <a target="_blank" href="https://line.me/R/ti/p/@504bdron">
                    <i class="fa-brands fa-line"></i>
                </a>
            </div>
            <div id="fa-bag-shopping" class="py-1">
                <a href="#" data-toggle="modal" data-target="#my_cart" onclick="get_mini_cart();">
                    <div id="cart-qty"><span style="color: #000;">0</span></div>
                    <i class="fa-solid fa-bag-shopping"></i>
                </a>
            </div>
            <div id="fa-angles-up" class="py-1 text-center" style="display:none;">
                <a href="#" style="color:black;">
                    <i class="fa-solid fa-angles-up"></i>
                </a>
            </div>
        </div>
        <header id="header" class="header-narrow header-semi-transparent header-transparent-sticky-deactive custom-header-transparent-bottom-border">
            <div class="header-body">
                <div class="header-container container m_padding">
                    <div class="header-row py-4 m_padding">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a href="<?php echo base_url() ?>" class="top_logo_style">
                                <img class="img-fluid" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                            </a>
                            <div class="collapse navbar-collapse" id="navbarToggler">
                                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="<?php echo base_url() ?>">首頁</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">關於龍寶</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">商品分類</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/product">全商品</a>
                                    </li>
                                    <div class="row nav_user_style">
                                        <?php if (empty($this->session->userdata('user_id'))) {?>
                                        <li class="nav-item">
                                            <a href="/login" class="btn nav-link nav_user_login_edit">登入</a>
                                        </li>
                                        <li class="nav-item" >
                                            <a href="/register" class="btn register-btn nav-link nav_user_register_logout">註冊</a>
                                        </li>
                                        <?}else{?>
                                        <li class="nav-item" >
                                            <a class="btn nav-link nav_user_login_edit" href="/auth/edit_user">我的帳戶</a>
                                        </li>
                                        <li class="nav-item" >
                                            <a class="btn nav-link nav_user_register_logout" href="/logout">登出</a>
                                        </li>
                                        <?}?>
                                    </div>
                                </ul>
                            </div>
                        </nav>
                        <div class="px-4 m_hr_border">
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </header>