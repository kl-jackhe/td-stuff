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
    <meta property="og:title" content=" | <?php echo get_setting_general('name') ?>" />
    <meta property="og:url" content="<?php echo base_url() ?>" />
    <meta property="og:site_name" content="<?php echo get_setting_general('name') ?>" />
    <meta property="og:image" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:card" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:title" content=" | <?php echo get_setting_general('name') ?>" />
    <title>
         |
        <?php echo get_setting_general('name') ?>
    </title>
    <link href="/assets/bootstrap-4.2.1-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="/assets/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/solid.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="/assets/fullPage.js-master/dist/jquery.fullpage.min.css" /> -->
</head>
<style>
    a:hover {
        text-decoration:none;
    }
    .header_relative_top {
        background-color: #fff;
        position: relative;
        z-index: 999;
    }
    .header_fixed_top {
        background-color: #fff;
        position: fixed;
        box-shadow: 0 5px 10px 5px #bdbdbd;
        width: 100%;
        top: 0;
        z-index: 1030;
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
        color: #e84C69 !important;
    }
    .nav_item_mb_style {
        padding-top: 15px;
        padding-bottom: 15px;
    }
    #content a ,#footer a {
        color: #fff;
    }
    #content a:hover {
        color: #414141;
    }
    #footer a:hover {
        color: #e84c69;
    }
    .fixed_icon_style {
        max-width: 40px;
        cursor: pointer;
    }
    .fixed_icon {
        left: auto;
        right: 25px;
        bottom: 60px;
    }
    .footer_nav_itme {
        text-align: center;
        font-weight: bold;
    }
    .footer_link {
        text-align: right;
    }
    .footer_copyright {
        text-align: left;
    }
    @media (min-width: 991.99px) and (max-width: 1024px) {
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
    }
    @media (max-width: 767px) {
        #fa-message {
            display: none;
        }
        .footer_nav_itme {
            text-align: left;
        }
        .footer_nav_itme hr {
            border-bottom: 1px solid #fff;
        }
        .footer_link {
            text-align: center;
        }
        .footer_copyright {
            text-align: center;
            font-size: 12px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    }
</style>
<body>
    <div class="container-fluid">
        <header id="header">
            <div class="row py-4 header_style justify-content-center header">
                <div class="col-5 col-md-3 col-lg-2" style="align-self: center;">
                    <a href="<?php echo base_url() ?>">
                        <img class="img-fluid" src="/assets/images/559mall_official/599mall%20logo.png">
                    </a>
                </div>
                <div class="col-md-8 col-lg-9 d-none d-md-none d-lg-block d-xl-block" style="align-self: center;">
                    <div class="row justify-content-end">
                        <div class="col-12 text-right ">
                            <a href="#" class="nav_item_style">網購商店示範</a>
                            <a href="#" class="nav_item_style">商店精選</a>
                            <a href="#" class="nav_item_style">技術支援</a>
                            <a href="#" class="nav_item_style" style="border: 2px solid #615d56;border-radius: 30px;padding: 1px 15px 1px 15px; background-color: transparent;">登入</a>
                            <a href="#" class="nav_item_style" style="border: 2px solid #615d56;border-radius: 30px;padding: 1px 15px 1px 15px;background-color: #615d56;color: #fff;">註冊我的店</a>
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
        </header>
        <div class="row" style="position: relative;z-index: 99;">
            <div class="collapse navbar-collapse" id="navbarToggler" style="position: fixed;top: 12%;z-index: 9999;background-color: rgb(245, 242, 236);height: 100%;min-height: 2000px;padding: 6% 20px 15px 20px;">
                <ul class="navbar-nav">
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">網購商店示範</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">商店精選</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">技術支援</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <hr style="color:#fff;">
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style" style="color: #000;text-decoration:none;border: 2px solid #615d56;border-radius: 30px; background-color: transparent;padding: 1px 15px 1px 15px;">登入</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style" style="color: #fff;text-decoration:none;border: 2px solid #615d56;border-radius: 30px;background-color: #615d56;padding: 1px 15px 1px 15px;">註冊我的店</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="#" class="nav_item_style">聯絡我們</a>
                    </li>
                </ul>
            </div>
        </div>
        <content id="content">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row text-center justify-content-center pb-5">
                        <div class="col-12 col-md-12 p-0">
                            <img src="/assets/images/559mall_official/index_top%20pic_1920_10181536.jpg" class="img-fluid banner d-none d-md-none d-lg-none d-xl-block">
                            <img src="/assets/images/559mall_official/index_top%20pic_1536.jpg" class="img-fluid d-none d-md-block d-lg-none d-xl-none">
                            <img src="/assets/images/559mall_official/index_top%20pic_800.jpg" class="img-fluid d-block d-md-none d-lg-none d-xl-none">
                            <!-- jquery 自動帶入圖片 -->
                            <!-- <img src="" class="img-fluid banner"> -->
                        </div>
                    </div>
                    <div class="row text-center justify-content-center py-5">
                        <div class="col-12 col-md-10">
                            <img src="/assets/images/559mall_official/page_2-text.png" class="img-fluid">
                            <div style="background-image: url('/assets/images/559mall_official/page_2-button_bg.png'); background-position: center;background-repeat: no-repeat;background-size:contain;padding: 15px;font-size: 24px;">
                                <span>｜ <a href="#">網站商店示範</a> ｜ <a href="#">註冊</a> ｜</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center justify-content-center py-5">
                        <div class="col-12 col-md-5">
                            <img src="/assets/images/559mall_official/page_3-pic.jpg" class="img-fluid">
                        </div>
                        <div class="col-12 col-md-5">
                            <img src="/assets/images/559mall_official/page_3-text.jpg" class="img-fluid">
                        </div>
                    </div>
                    <div class="row text-center justify-content-center py-5">
                        <div class="col-12 col-md-5">
                            <img src="/assets/images/559mall_official/page_4-text.jpg" class="img-fluid">
                        </div>
                        <div class="col-12 col-md-5">
                            <img src="/assets/images/559mall_official/page_4-pic.jpg" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </content>
        <div class="fixed-bottom fixed_icon">
            <div id="fa-message" class="my-3 icon_pointer">
                <a href="#" target="_blank" style="outline: none;">
                    <img class="fixed_icon_style" src="/assets/images/559mall_official/icon/web%20icon_message.png">
                </a>
            </div>
            <div id="fa-angles-up" class="my-3 icon_pointer">
                <a href="#" style="color:black;outline: none;" style="display: none;">
                    <img class="fixed_icon_style" src="/assets/images/559mall_official/icon/web%20icon_top.png">
                </a>
            </div>
        </div>
        <footer id="footer">
            <div class="row justify-content-center py-5" style="background-color: #e3e1df;">
                <div class="col-12 col-md-6" style="color: #878787;">
                    <p>註冊專屬網路商店，每月 NT$ 1,990。不限任何裝置使用，無論是手機、平板、電腦。</p>
                    <p>展示的封面與文章僅用於說明目的，559mall可使用的模組依實際註冊模式主。</p>
                    <p class="m-0">如需使用微商或其它功能，請聯絡我們</p>
                </div>
            </div>
            <div class="row justify-content-center pt-4 pb-3" style="background-color: #625d57;color: #fff;">
                <div class="col-12 col-md-8 footer_nav_itme">
                    <div class="row justify-content-center">
                        <div class="col-10 col-md-2 my-2"><a href="#">關於559mall</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="#">聯絡我們</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="#">購物商店示範</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="#">問與答</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="#">技術支援</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pb-4" style="background-color: #625d57;color: #fff;">
                <div class="col-12 col-md-6 text-right footer_link">
                    <span>
                        ｜&emsp;<a href="#">免責聲明</a>&emsp;｜&emsp;<a href="#">服務條款</a>&emsp;｜&emsp;<a href="#">知識產權</a>&emsp;｜
                    </span>
                </div>
                <div class="col-12 col-md-6 footer_copyright">
                    <span>
                        Copyright © 2023 <?php echo get_setting_general('name'); ?>. All rights reserved.
                    </span>
                </div>
            </div>
        </footer>
    </div>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/assets/bootstrap-4.2.1-dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script defer src="/assets/fontawesome-free-6.1.1-web/js/all.js"></script>
    <!-- <script defer src="/assets/fullPage.js-master/dist/jquery.fullpage.min.js"></script>
    <script defer src="/assets/fullPage.js-master/vendors/jquery.easings.min.js"></script> -->
    <script>
    $(document).ready(function() {
        // var content_width = $('#content').width();
        // if (content_width > 1024) {
        //     $(".banner").attr("src", "/assets/images/559mall_official/index_top%20pic_1920.jpg");
        // }
        // if (content_width <= 1024 && content_width > 800) {
        //     $(".banner").attr("src", "/assets/images/559mall_official/index_top%20pic_1536.jpg");
        // }
        // if (content_width <= 800) {
        //     $(".banner").attr("src", "/assets/images/559mall_official/index_top%20pic_800.jpg");
        // }

        var $navbarToggler = $("#navbarToggler");
        var $menuToggle = $(".navbar-toggler");
        var isOpen = false;
        $menuToggle.click(function() {
            if (isOpen) {
                $navbarToggler.animate({
                    left: "-100%"
                }, 500, function() {
                    isOpen = false;
                });
            } else {
                $navbarToggler.animate({
                    left: 0
                }, 500, function() {
                    isOpen = true;
                });
            }
        });

        //headerFixed
        $(window).scroll(function() {
            if ($(window).scrollTop() > $("#header").offset().top) {
                $('.header').addClass('header_fixed_top');
                $('.header').removeClass('header_relative_top');
            } else {
                $('.header').removeClass('header_fixed_top');
                $('.header').addClass('header_relative_top');
            }
        });
        //scrollTop
        $(function() {
            var $win = $(window);
            $win.scroll(function() {
                if ($win.scrollTop() > 100) {
                    // $('#fa-angles-up').slideDown();
                    $('#fa-angles-up').show();
                } else {
                    // $('#fa-angles-up').slideUp();
                    $('#fa-angles-up').hide();
                }
            });
            $('#fa-angles-up').click(function() {
                $('html, body').animate({ scrollTop: 0 }, 500);
            });
        });
        //裝置辨認
        var ua = navigator.userAgent;
        var android = ua.indexOf('Android') > -1 || ua.indexOf('Adr') > -1; // android
        var iOS = !!ua.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); // ios
        if(android==true){
            $('#facebook_href').attr('href','fb://page/114764431237605')
        // document.getElementById('resoult').innerHTML = '您的裝置是 Android';
        }else if(iOS==true){
            $('#facebook_href').attr('href','fb://page/?id=114764431237605')
        // document.getElementById('resoult').innerHTML = '您的裝置是 iOS';
        }else{
        // document.getElementById('resoult').innerHTML = '您目前非行動裝置';
        }
    });
    </script>
</body>

</html>