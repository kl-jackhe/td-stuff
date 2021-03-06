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
</style>

<body>
    <div class="body h-100">
        <div class="fixed-bottom" style="left: auto;right: 25px;bottom: 60px;">
            <div id="fa-facebook-square" class="py-1">
                <a href="#">
                    <i class="fa-brands fa-facebook-square" style="font-size: 48px;"></i>
                </a>
            </div>
            <div id="fa-line" class="py-1">
                <a target="_blank" href="https://line.me/R/ti/p/@504bdron">
                    <i class="fa-brands fa-line" style="font-size: 48px;"></i>
                </a>
            </div>
            <div id="fa-bag-shopping" class="py-1">
                <a href="#" data-toggle="modal" data-target="#my_cart" onclick="get_mini_cart();">
                    <div id="cart-qty"><span style="color: #000;">0</span></div>
                    <i class="fa-solid fa-bag-shopping" style="font-size: 48px;"></i>
                </a>
            </div>
            <div id="fa-angles-up" class="py-1 text-center" style="display:none;">
                <a href="#" style="color:black;">
                    <i class="fa-solid fa-angles-up" style="font-size: 48px;"></i>
                </a>
            </div>
        </div>
        <header id="header" class="header-narrow header-semi-transparent header-transparent-sticky-deactive custom-header-transparent-bottom-border">
            <div class="header-body">
                <div class="header-container" style="width: 100%;">
                    <div class="header-row" style="padding-left:25px;padding-right:25px;">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a href="<?php echo base_url() ?>" style="position: absolute;transform: translate(-50%, -50%);left: 50%;top: 50%;">
                                <img class="img-fluid" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                            </a>
                            <div class="collapse navbar-collapse" id="navbarToggler">
                                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="<?php echo base_url() ?>">??????</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/product">??????</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/checkout">??????</a>
                                    </li>
                                    <?php if (empty($this->session->userdata('user_id'))) {?>
                                    <li class="nav-item">
                                        <a href="/login" class="btn nav-link" style="border: 1px solid #00BFD5; color: #00BFD5; margin-bottom: 10px;">??????</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/register" class="btn register-btn nav-link" style="background: #00BFD5; color: #fefefe;">??????</a>
                                    </li>
                                    <?}else{?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/auth/edit_user">????????????</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/logout">??????</a>
                                    </li>
                                    <?}?>
                                    <!-- <div class="dropdown">
                                        <?php if (!empty($this->session->userdata('user_id'))) {?>
                                        <div id="bbb" class="btn btn-secondary dropdown-toggle" data-toggle="collapse" data-target=".dropdown-menu" aria-expanded="false">
                                            <?php echo $this->ion_auth->user()->row()->full_name; ?>
                                        </div>
                                        <ul class="dropdown-menu collapse">
                                            <li>
                                                <a href="/auth/edit_user">????????????</a>
                                            </li>
                                            <li>
                                                <a href="/coupon">???????????????</a>
                                            </li>
                                            <li>
                                                <a href="/order">????????????</a>
                                            </li>
                                            <li class="worker">
                                                <a href="javascript:;" onclick="my_addess_model();">????????????</a>
                                            </li>
                                            <li>
                                                <a href="/logout">??????</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php } else {?>
                                    <?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register') {?>
                                    <li class="nav-item">
                                        <a href="/login" class="btn" style="border: 1px solid #00BFD5; color: #00BFD5; margin-bottom: 10px;">??????</a>
                                    </li>
                                    <li class="nav-item" style="margin-left: 0px;">
                                        <a href="/register" class="btn register-btn" style="background: #00BFD5; color: #fefefe;">??????</a>
                                    </li>
                                    <?php }}?> -->
                                </ul>
                                <!-- <form class="form-inline my-2 my-lg-0">
                                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </form> -->
                            </div>
                        </nav>
                        <div class="px-4">
                            <hr>
                        </div>
                        <!--  <div class="header-column">
                            <div class="header-row">
                                <div class="header-nav">
                        <button type="button" class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
                                        <i class="fa fa-navicon"></i>
                                    </button>
                        <div class="header-nav-main collapse" aria-expanded="true">
                                        <nav>
                                            <ul class="nav nav-pills" id="mainNav">
                                                <li class="worker">
                                                    <a href="/about/cross_industry_alliance">
                                                        ????????????
                                                    </a>
                                                </li>
                                                <li class="worker">
                                                    <a href="/about/shop_alliance">
                                                        ????????????
                                                    </a>
                                                </li>
                                                <?php if ($this->ion_auth->logged_in()) {?>
                                                <li class="worker">
                                                    <a href="javascript:;" onclick="my_addess_model();">
                                                        ????????????
                                                    </a>
                                                </li>
                                                <?php }?>
                                                <li class="message">
                                                    <a href="/posts">
                                                        ????????????
                                                    </a>
                                                </li>
                                                <li class="message" style="margin-right: 40px;">
                                                    <a href="/about/brand">
                                                        ????????????
                                                    </a>
                                                </li>
                                                <li class="dropdown">
                                                    <?php if (!empty($this->session->userdata('user_id'))) {?>
                                                    <div id="bbb" class="btn btn-block mb-sm" data-toggle="collapse" data-target=".dropdown-menu" aria-expanded="true">
                                                        <i class="fa fa-angle-up pull-left visible-xs"></i>
                                                        <?php echo $this->ion_auth->user()->row()->full_name; ?>
                                                    </div>
                                                    <ul class="dropdown-menu collapse">
                                                        <li>
                                                            <a href="/auth/edit_user">????????????</a>
                                                        </li>
                                                        <li>
                                                            <a href="/coupon">???????????????</a>
                                                        </li>
                                                        <li>
                                                            <a href="/order">????????????</a>
                                                        </li>
                                                        <li>
                                                            <a href="/logout">??????</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <?php } else {?>
                                                <?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register') {?>
                                                <li>
                                                    <a href="/login" class="btn" style="border: 1px solid #00BFD5; color: #00BFD5; margin-bottom: 10px;">??????</a>
                                                </li>
                                                <li style="margin-left: 0px;">
                                                    <a href="/register" class="btn register-btn" style="background: #00BFD5; color: #fefefe;">??????</a>
                                                </li>
                                                <?php } else {?>
                                                <li>
                                                    <a href="#" class="btn" onclick="login_model()" style="border: 1px solid #00BFD5; color: #00BFD5; margin-bottom: 10px;">??????</a>
                                                </li>
                                                <li style="margin-left: 0px;">
                                                    <a href="#" class="btn register-btn" onclick="register_model()" style="background: #00BFD5; color: #fefefe;">??????</a>
                                                </li>
                                                <?php }?>
                                                <?php }?>
                                            </ul>
                                        </nav>
                                    </div>
                            </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </header>