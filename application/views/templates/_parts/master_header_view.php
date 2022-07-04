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
    <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" />
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /> -->
    <!-- <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png"> -->
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css?v=3.3.7">
    <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.min.css?v=4.7.0">
    <link rel="stylesheet" href="/node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="/node_modules/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="/node_modules/owl.carousel/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="/node_modules/owl.carousel/dist/assets/owl.theme.default.css">
    <link rel="stylesheet" href="/node_modules/magnific-popup/dist/magnific-popup.css">
    <link rel="stylesheet" href="/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.css">
    <link rel="stylesheet" href="/assets/css/theme-elements.css?v=201909062146">
    <!-- <link rel="stylesheet" href="css/theme-blog.css">

    <link rel="stylesheet" href="css/theme-shop.css"> -->
    <!-- Current Page CSS -->
    <link rel="stylesheet" href="/node_modules/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="/node_modules/rs-plugin/css/layers.css">
    <link rel="stylesheet" href="/node_modules/rs-plugin/css/navigation.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="/assets/css/custom.css?v=201912091409">
    <!-- Head Libs -->
    <script src="/node_modules/modernizr/modernizr.min.js"></script>
    <link rel="stylesheet" href="/assets/admin/jqueryui/1.12.1/jquery-ui.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"> -->
    <!-- jquery因為bootstrap的關係，所以只能匯入v2的最新版 -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <!-- <script src="/node_modules/jquery-migrate/dist/jquery-migrate.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script> -->
    <script src="/assets/admin/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127821887-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-127821887-2');
    </script>
    <!-- End Global site tag (gtag.js) - Google Analytics -->
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)

      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?

      n.callMethod.apply(n,arguments):n.queue.push(arguments)};

      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

      n.queue=[];t=b.createElement(e);t.async=!0;

      t.src=v;s=b.getElementsByTagName(e)[0];

      s.parentNode.insertBefore(t,s)}(window, document,'script',

      'https://connect.facebook.net/en_US/fbevents.js');

      fbq('init', '149439059133093');

      fbq('track', 'PageView');

    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=149439059133093&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- liff -->
    <!-- <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script> -->
    <!-- <script src="/assets/js/StreamInitLiffWithGtm.js?v=202001090144"></script> -->
    <!-- <script src="https://ad.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.min.js"></script> -->

    <!-- 2020-03-06 -->
    <!-- <script src="https://www.stream-lab.net/public/SDK/utility/streamLiff.js?v=202003091542"></script> -->
    <!-- <script src="https://intra.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.2.0.min.js?v=202003091542"></script> -->
    <!-- <script src="/assets/js/streamLiff.js"></script>
    <script src="/assets/js/StreamInitLiffWithGtm.2.0.min.js"></script> -->
    <script>
        // LIFF_init();
        // function get_liff_user_id(){
        //     if (LIFF_userID != "") {
        //         $('#liff_user_id').html(LIFF_userID);
        //     } else {
        //         setTimeout("get_liff_user_id()", 100);
        //     }
        // }
    </script>
    <!-- End liff -->
</head>

<body>
    <div class="body">
        <header id="header" class="header-narrow header-semi-transparent header-transparent-sticky-deactive custom-header-transparent-bottom-border">
            <div class="header-body">
                <div class="header-container" style="width: 100%; padding-left: 4%; padding-right: 1%;">
                    <div class="header-row">
                        <div class="header-column hidden-xs">
                            <div class="header-logo">
                                <a href="<?php echo base_url() ?>">
                                    <!--<span class="logo-word">Bytheway</span>-->
                                    <img alt="BTW" width="150" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                                </a>
                            </div>
                        </div>
                        <div class="header-column">
                            <div class="header-row">
                                <div class="header-nav">
                                    <!-- mobiletype -->
                                    <button type="button" class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
                                        <i class="fa fa-navicon"></i>
                                    </button>
                                    <div class="header-logo visible-xs">
                                        <a href="<?php echo base_url() ?>">
                                            <img src="/assets/images/m_logo@3x.png" width="60" alt="Bytheway">
                                        </a>
                                    </div>
                                    <!-- mobiletype END -->
                                    <div class="header-nav-main collapse" aria-expanded="true">
                                        <nav>
                                            <ul class="nav nav-pills" id="mainNav">
                                                <li class="worker">
                                                    <a href="/about/cross_industry_alliance">
                                                        異業合作
                                                    </a>
                                                </li>
                                                <li class="worker">
                                                    <a href="/about/shop_alliance">
                                                        店家合作
                                                    </a>
                                                </li>
                                                <?php if ($this->ion_auth->logged_in()) { ?>
                                                <li class="worker">
                                                    <a href="javascript:;" onclick="my_addess_model();">
                                                        常用地址
                                                    </a>
                                                </li>
                                                <?php } ?>
                                                <li class="message">
                                                    <a href="/posts">
                                                        最新活動
                                                    </a>
                                                </li>
                                                <li class="message" style="margin-right: 40px;">
                                                    <a href="/about/brand">
                                                        關於我們
                                                    </a>
                                                </li>
                                                <li class="dropdown">
                                                    <?php  if(!empty($this->session->userdata('user_id'))){ ?>
                                                    <div id="bbb" class="btn btn-block mb-sm" data-toggle="collapse" data-target=".dropdown-menu" aria-expanded="true">
                                                        <i class="fa fa-angle-up pull-left visible-xs"></i>
                                                        <?php echo $this->ion_auth->user()->row()->full_name; ?>
                                                    </div>
                                                    <ul class="dropdown-menu collapse">
                                                        <li>
                                                            <a href="/auth/edit_user">個人資料</a>
                                                        </li>
                                                        <li>
                                                            <a href="/coupon">優惠券管理</a>
                                                        </li>
                                                        <li>
                                                            <a href="/order">訂單管理</a>
                                                        </li>
                                                        <li>
                                                            <a href="/logout">登出</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <?php } else { ?>
                                                <?php if($this->uri->segment(1)=='' || $this->uri->segment(1)=='login' || $this->uri->segment(1)=='register') { ?>
                                                <li>
                                                    <a href="/login" class="btn" style="border: 1px solid #00BFD5; color: #00BFD5; margin-bottom: 10px;">登入</a>
                                                </li>
                                                <li style="margin-left: 0px;">
                                                    <a href="/register" class="btn register-btn" style="background: #00BFD5; color: #fefefe;">註冊</a>
                                                </li>
                                                <?php } else { ?>
                                                <li>
                                                    <a href="#" class="btn" onclick="login_model()" style="border: 1px solid #00BFD5; color: #00BFD5; margin-bottom: 10px;">登入</a>
                                                </li>
                                                <li style="margin-left: 0px;">
                                                    <a href="#" class="btn register-btn" onclick="register_model()" style="background: #00BFD5; color: #fefefe;">註冊</a>
                                                </li>
                                                <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>