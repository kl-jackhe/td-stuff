<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="fixed-bottom header_fixed_icon">
    <? if ($agentID == '' && get_setting_general('official_facebook_1') != '') { ?>
        <div id="fa-facebook-square" class="my-3 icon_pointer">
            <a id="facebook_href" href="<?= get_setting_general('official_facebook_1') ?>" target="_blank">
                <i class="fa-brands fa-facebook fixed_icon_style"></i>
            </a>
        </div>
    <? } ?>
    <? if ($agentID == '' && get_setting_general('official_instagram_1') != '') { ?>
        <div id="fa-instagram-square" class="my-3 icon_pointer">
            <a id="instagram_href" href="<?= get_setting_general('official_instagram_1') ?>" target="_blank">
                <i class="fa-brands fa-instagram fixed_icon_style"></i>
            </a>
        </div>
    <? } ?>
    <? if (get_setting_general('official_line_1') != '') { ?>
        <div id="fa-line" class="my-3 icon_pointer">
            <a href="<?= get_setting_general('official_line_1') ?>" target="_blank">
                <img class="fixed_icon_style" src="/assets/images/liqun/index_icon_talk.png">
            </a>
        </div>
    <? } ?>
    <!-- <? if (strpos(base_url(), 'home') !== false) { ?>
        <div id="scrollToBottomBtn" class="my-3 icon_pointer">
            <a href="#">
                <img class="fixed_icon_style" src="/assets/images/liqun/web icon_buynow.png">
            </a>
        </div>
    <? } ?> -->
    <!-- <div id="fa-bag-shopping" class="my-3 icon_pointer">
        <a href="#" data-toggle="modal" style="position: relative;" data-target="#my_cart" onclick="get_mini_cart();">
            <div id="cart-qty"><span>0</span></div>
            <i class="fa-solid fa-cart-shopping fixed_icon_style"></i>
        </a>
    </div> -->
    <div id="fa-angles-up" class="my-3 icon_pointer">
        <a href="#">
            <img class="fixed_icon_style" src="/assets/images/liqun/index_icon_arrow.png">
        </a>
    </div>
</div>

<? if ($agentID == '') { ?>
    <footer id="footer">
        <div class="footer-company-logo">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <div class="col-6 col-md-2 pl-5 pr-3">
                        <img src="/assets/images/liqun/index_logo_footer-AKai.png" class="img-fluid">
                    </div>
                    <div class="col-6 col-md-2 pr-5 pl-3">
                        <img src="/assets/images/liqun/index_logo_footer-LGFD.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-company-info">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <div class="col-12 col-md-12">
                        <span>
                            <a href="/about">關於我們</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                            <span class="d-none d-md-inline-block d-lg-inline-block d-xl-inline-block"> ｜ </span>
                            <a href="/policy?target=FrequentlyQA">常見Ｑ＆Ａ</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                            <span class="d-none d-md-inline-block d-lg-inline-block d-xl-inline-block"> ｜ </span>
                            <a href="/policy?target=FraudPreventionInformation">防詐騙宣導資訊</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                            <span class="d-none d-md-inline-block d-lg-inline-block d-xl-inline-block"> ｜ </span>
                            <a href="/policy?target=Disclaimer">免責聲明</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                            <span class="d-none d-md-inline-block d-lg-inline-block d-xl-inline-block"> ｜ </span>
                            <a href="/policy?target=TermsOfService">服務條款</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                            <span class="d-none d-md-inline-block d-lg-inline-block d-xl-inline-block"> ｜ </span>
                            <a href="/policy?target=IntellectualProperty">知識產權</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                            <span class="d-none d-md-inline-block d-lg-inline-block d-xl-inline-block"> ｜ </span>
                            <a href="/policy?target=ReturnPolicy">退貨政策</a>
                            <div class="d-block d-md-none d-lg-none d-xl-none w-100">
                                <hr>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <div class="col-11 col-md-12">
                        Copyright © 2023 li-group food 阿凱的冰箱. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
<? } ?>

<!-- MyCart Modal -->
<div class="modal fade" id="my_cart" tabindex="-1" role="dialog" aria-labelledby="my_cart_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title m-0" id="my_cart_title">購物車</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script defer src="/assets/fontawesome-free-6.1.1-web/js/all.js"></script>
<script>
    $(document).ready(function() {
        var isFridgeBoxOpen = true;
        $(document).click(function(event) {
            var target = $(event.target);
            if (!target.closest('#fridge_box').length && !target.closest('#fridge_item').length) {
                $('#fridge_item').not(target.closest('#fridge_box').find('#fridge_item')).slideUp();
                isFridgeBoxOpen = false;
            }
        });

        $('#fridge_box').click(function(event) {
            if (isFridgeBoxOpen == false) {
                $('#fridge_item').slideDown();
                isFridgeBoxOpen = true;
            } else {
                $('#fridge_item').slideUp();
                isFridgeBoxOpen = false;
            }
        });

        $('#home-carousel').carousel({
            interval: 5000
        });

        get_cart_qty();
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
        //Window Height
        var header_h = $(".header_fixed_top").height();
        $(".content_auto_h").css('padding-top', header_h * 1.8);
        //scrollTop
        $(function() {
            var $win = $(window);
            $win.scroll(function() {
                if ($win.scrollTop() > 100) {
                    $('#fa-angles-up').slideDown();
                } else {
                    $('#fa-angles-up').slideUp();
                }
            });
            $('#fa-angles-up').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 200);
            });
        });
        //scrollDown
        // $(function() {
        //     $('#scrollToBottomBtn').click(function() {
        //         $('html, body').animate({
        //             scrollTop: $(document).height()
        //         }, 1000);
        //     });
        // });
        //裝置辨認
        var ua = navigator.userAgent;
        var android = ua.indexOf('Android') > -1 || ua.indexOf('Adr') > -1; // android
        var iOS = !!ua.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); // ios
        if (android == true) {
            $('#facebook_href').attr('href', 'fb://page/114764431237605')
            // document.getElementById('resoult').innerHTML = '您的裝置是 Android';
        } else if (iOS == true) {
            $('#facebook_href').attr('href', 'fb://page/?id=114764431237605')
            // document.getElementById('resoult').innerHTML = '您的裝置是 iOS';
        } else {
            // document.getElementById('resoult').innerHTML = '您目前非行動裝置';
        }
    });
    //MyCart
    function get_cart_qty() {
        $.ajax({
            url: "/cart/check_cart_is_empty",
            method: "GET",
            data: {},
            success: function(data) {
                $('#cart-qty span').html(data);
            }
        });
    }

    function get_mini_cart() {
        $('#my_cart .modal-body').load("/cart/mini_cart");
    }

    function view_form_check() {
        $.ajax({
            url: "/cart/check_cart_is_empty",
            method: "GET",
            data: {},
            success: function(data) {
                if (data > 0) {
                    // $('#view_form').submit();
                    $(location).attr('href', '/checkout');
                } else {
                    alert('購物車是空的，請添加商品。');
                }
            }
        });
    }
    //MyCart
</script>
</body>

</html>