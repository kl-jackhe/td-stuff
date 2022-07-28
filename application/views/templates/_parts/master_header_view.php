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
        max-width: 40px;
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
        margin-top: 30px;
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
        .header_fixed_icon {
            right: 9px;
        }
        .fixed_icon_style {
            max-width: 30px;
        }
    }
</style>

<body>
    <div class="body h-100">
        <header id="header" class="header-narrow header-semi-transparent header-transparent-sticky-deactive custom-header-transparent-bottom-border">
            <div class="header-body">
                <div class="header-container container m_padding">
                    <div class="header-row py-4 m_padding">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a href="<?php echo base_url() ?>" class="top_logo_style" style="max-width: 130px;">
                                <img class="img-fluid" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                            </a>
                            <div class="collapse navbar-collapse" id="navbarToggler">
                                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                    <?php $current = $this->uri->segment(1); ?>
                                    <li class="nav-item <?php echo ($current==''?'active':'') ?>">
                                        <a class="nav-link" href="<?php echo base_url() ?>">首頁</a>
                                    </li>
                                    <li class="nav-item <?php echo ($current=='about'?'active':'') ?>">
                                        <a class="nav-link" href="/about">關於龍寶</a>
                                    </li>
                                    <li class="nav-item <?php echo ($current=='product'?'active':'') ?>">
                                        <a class="nav-link" href="/product">全商品</a>
                                    </li>
                                    <div class="row nav_user_style">
                                        <?php if (!$this->ion_auth->logged_in()){ ?>
                                            <li class="nav-item">
                                                <a href="/login" class="btn nav-link nav_user_login_edit">登入</a>
                                            </li>
                                            <li class="nav-item" >
                                                <a href="/register" class="btn register-btn nav-link nav_user_register_logout">註冊</a>
                                            </li>
                                            <? } else { ?>
                                            <li class="nav-item" >
                                                <a class="btn nav-link nav_user_login_edit" href="/auth/edit_user">我的帳戶</a>
                                            </li>
                                            <li class="nav-item" >
                                                <a class="btn nav-link nav_user_register_logout" href="/logout">登出</a>
                                            </li>
                                        <? } ?>
                                    </div>
                                </ul>
                            </div>
                        </nav>
                        <div class="px-4 m_hr_border">
                            <hr style="border-top: 1px solid #988B7A;">
                        </div>
                    </div>
                </div>
            </div>
        </header>