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
    <meta property="og:title" content="<?php echo $page_title ?> | <?php echo get_setting_general('name') ?>" />
    <meta property="og:url" content="<?php echo base_url() ?>" />
    <meta property="og:site_name" content="<?php echo get_setting_general('name') ?>" />
    <meta property="og:image" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:card" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:title" content="<?php echo $page_title ?> | <?php echo get_setting_general('name') ?>" />
    <title>
        <?php echo $page_title ?> |
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
        box-shadow: 0 5px 30px 5px #E0E0E0;
        width: 100%;
        top: 0;
        z-index: 1030;
    }
    .header_logo {
        width: 80%;
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
        .header_logo {
            width: 100%;
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .header_logo {
            width: 100%;
        }
    }
    @media (max-width: 767px) {
        .header_logo {
            width: 100%;
        }
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
                        <img class="header_logo" src="/assets/images/559mall_official/599mall%20logo.png">
                    </a>
                </div>
                <div class="col-md-8 col-lg-9 d-none d-md-none d-lg-block d-xl-block" style="align-self: center;">
                    <div class="row justify-content-end">
                        <div class="col-12 text-right ">
                            <a href="/SampleStore" class="nav_item_style">網購商店示範</a>
                            <a href="/FeaturedStore" class="nav_item_style">商店精選</a>
                            <a href="/TechnicalSupport" class="nav_item_style">技術支援</a>
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
                        <a href="/SampleStore" class="nav_item_style">網購商店示範</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="/FeaturedStore" class="nav_item_style">商店精選</a>
                    </li>
                    <li class="nav_item_mb_style">
                        <a href="/TechnicalSupport" class="nav_item_style">技術支援</a>
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
                        <a href="<?=get_setting_general('official_line_1')?>" target="_blank" class="nav_item_style">聯絡我們</a>
                    </li>
                </ul>
            </div>
        </div>
        <content id="content">
            <div class="row justify-content-center">
                <div class="col-12" style="background-color:#f2efe8; padding-top: 80px;padding-bottom: 30px;">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8">
                            <h1>知識產權</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8" style="margin-top: 60px;margin-bottom: 80px;">
                    <p>
                        本商城的所有軟件和內容（其定義為，或包括任何文字、音訊或音樂、影片、圖像、相片和圖片）是本商城的知識產權作品，並受知識產權、版權法和國際公約條款的保護。本網站只供作個人及非商業用途。只有得到本商城及 / 或其第三方授權人明確授權，方可使用內容作任何非個人及 / 或非商業用途。在未獲本商城同意或授權前，不可發佈、複製、售賣或特許任何本網站的內容。任何未經授權的行為可能會導致民事後果或刑事處罰。
                    </p>
                    <p>
                        本商城保留在沒有通知的情況下撤消或修改任何服務的權利。若本網站因任何理由在任何時間或任何期間無法使用，我們概不負責。產品描述本商城將盡力確保本網站的內容和產品描述為準確和完整。不過，我們不保證內容和產品描述均為準確、完整、最新和無誤。如果您覺得本商城提供的產品與描述不符，請參閱我們的退貨及退款程序。
                    </p>
                    <p>
                        <span style="font-weight: bold;">第一條 價格</span><br>
                        本網站所標示的價格為新臺幣。除非出現明顯錯誤，否則您的訂單獲接納時即代表您同意支付 本網站所顯示的價格。我們盡力確保本網站所顯示的所有價格準確，但不能保證所有價格無誤，並保留更正任何錯誤的權利。如果我們發現您已訂購的任何產品價格有誤，我們會盡快通知您，屆時您可選擇重新確認或取消訂單。如果未能聯絡閣下，我們將把訂單作取消訂單般處理。
                    </p>
                    <p>
                        <span style="font-weight: bold;">第二條 接受訂單</span><br>
                        當您輸入個人資料、付款資料並提交訂單，我們將向您發出電郵以確認收到訂單。該電郵僅確認收到訂單，並不代表接受訂單。我們向您發出電郵確認貨品已經寄出時，即表示您的訂單已獲接受，而您與本商城的合約亦已完成。只有在寄出商品時發出的確認電郵中列出的商品包括於合約中。本商城保留權利因任何原因自行決定不接受訂貨。原因包括但不限於以下其一：
                        <br><br>
                        a) 所訂購的商品缺貨，或因為未能達到我們的品質標準或因為其中一項或全部訂購商品適用於送貨限制而被撤回。
                        <br>
                        b) 我們發現價格或產品描述有誤。
                        <br>
                        c) 我們未能獲得付款授權。
                        <br>
                        d) 您不符合服務條款載列的購買資格，如果您的訂單有任何問題，我們的客戶服務團隊會盡快聯絡您。
                    </p>
                    <p>
                        <span style="font-weight: bold;">第三條 送貨和取貨</span><br>
                        當您在網站下訂單時，您會收到一個預期送貨時間的提示。本商城團隊會盡力於預計時間內完成送貨，但不能保證一定能於預計時間內把貨品送到您手上。本商城為每個訂單於運送過程中投保，直至商品送到或被提取。提取商品時，您需要簽署收取商品確認。簽署後，您開始為商品承擔責任。如果取貨人不是原來購買者，或者交付的是禮物，即表示您接受上述人士的簽署確認為送貨證據並表示本商城已完成您的訂單，同時接受相關的責任轉移。本商城保留在沒有事先通知下自行決定更新送貨政策的權利。
                    </p>
                    <p>
                        <span style="font-weight: bold;">第四條 退貨</span><br>
                        本商城希望為您提供最佳的網上購物體驗，因此設有免費、不問原因的退貨政策。如果因為任何原因未能對商品百分百滿意，您可以退還商品並獲得全額退款。
                        <br><br>
                        a) 客戶可以在訂購後7天內退還商品。
                        <br>
                        b) 退還的商品必須維持原狀：即未經穿著 / 使用，放於沒受損壞原裝品牌包裝盒及包裝袋，而且所有價錢牌均完好無缺。如果希望退還商品，請填妥送貨時收到的退貨表格，連同附有原本包裝的商品寄回我們的地址。如果您沒有保留購買表格，請致電我們的客戶服務團隊，我們會以電郵方式補發給您。請注意，退貨時不設退還運費。
                    </p>
                    <p>
                        <span style="font-weight: bold;">第五條 您的權利</span><br>
                        本服務條款無意影響您根據臺灣法律所享有的權利。
                    </p>
                    <p>
                        <span style="font-weight: bold;">第六條 責任</span><br>
                        商品售賣於本網站的設計師、公司或第三方及其關聯人士向任何媒體所表達的觀點純屬其個人意見。本商城對任何此等觀點概不負責，而此等觀點不一定反映本公司的觀點。本商城不保證使用本網站和服務均為無誤，也不保證本網站或支援本網站的伺服器沒有病毒或其他有害成分。我們建議所有本網站的用戶確保自己已安裝最新軟件，包括防毒軟件。某些事情可能在本公司的合理監管之外發生，例如惡劣天氣。在此等情況下，本商城會盡力維持服務，但對於任何未能滿足本服務條款的責任概不負責。
                    </p>
                </div>
            </div>
        </content>
        <div class="fixed-bottom fixed_icon">
            <div id="fa-message" class="my-3 icon_pointer">
                <a href="<?=get_setting_general('official_line_1')?>" target="_blank" style="outline: none;">
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
            <div class="row justify-content-center py-5 text-center" style="background-color: #e3e1df;">
                <div class="col-12 col-md-6" style="color: #878787;">
                    <p>註冊專屬網路商店，每月 NT$ 1,990。不限任何裝置使用，無論是手機、平板、電腦。</p>
                    <p>展示的封面與文章僅用於說明目的，559mall可使用的模組依實際註冊模式主。</p>
                    <p class="m-0">如需使用微商或其它功能，請聯絡我們</p>
                </div>
            </div>
            <div class="row justify-content-center pt-4 pb-3" style="background-color: #625d57;color: #fff;">
                <div class="col-12 col-md-8 footer_nav_itme">
                    <div class="row justify-content-center">
                        <div class="col-10 col-md-2 my-2"><a href="/About">關於559mall</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="<?=get_setting_general('official_line_1')?>" target="_blank">聯絡我們</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="/SampleStore">購物商店示範</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="#">問與答</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                        <div class="col-10 col-md-2 my-2"><a href="/TechnicalSupport">技術支援</a></div>
                        <div class="d-block d-md-none d-lg-none d-xl-none w-100"><hr></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pb-4" style="background-color: #625d57;color: #fff;">
                <div class="col-12 col-md-6 text-right footer_link">
                    <span>
                        ｜&emsp;<a href="/Disclaimer">免責聲明</a>&emsp;｜&emsp;<a href="/TermsOfService">服務條款</a>&emsp;｜&emsp;<a href="/IntellectualProperty">知識產權</a>&emsp;｜
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