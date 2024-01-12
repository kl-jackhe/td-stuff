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
                <img class="fixed_icon_style" src="/assets/images/web icon_line service.png">
            </a>
        </div>
    <? } ?>
    <? if (strpos(base_url(), 'home') !== false) { ?>
        <div id="scrollToBottomBtn" class="my-3 icon_pointer">
            <a href="#">
                <img class="fixed_icon_style" src="/assets/images/liqun/web icon_buynow.png">
            </a>
        </div>
    <? } ?>
    <div id="fa-bag-shopping" class="my-3 icon_pointer">
        <a href="#" data-toggle="modal" style="position: relative;" data-target="#my_cart" onclick="get_mini_cart();">
            <div id="cart-qty"><span>0</span></div>
            <i class="fa-solid fa-cart-shopping fixed_icon_style"></i>
        </a>
    </div>
    <div id="fa-angles-up" class="my-3 icon_pointer">
        <a href="#">
            <img class="fixed_icon_style" src="/assets/images/web icon_top-2.png">
        </a>
    </div>
</div>

<? if ($agentID == '') { ?>
    <footer id="footer">
        <div class="footer-company-info">
            <div class="container-fluid">
                <div class="row justify-content-center" style="padding-left: 15px;padding-right: 15px;">
                    <!-- 最新消息 -->
                    <div class="col-12 col-md-2">
                        <h2>最新消息</h2>
                        <hr>
                        <?php if (!empty($footer_category)) : ?>
                            <?php foreach ($footer_category as $self) : ?>
                                <?php if ($self['parent_id'] == 3 && $self['status'] == 1) : ?>
                                    <p><a href="/posts/index?id=<?= $self['sort'] ?>"><?= $self['name'] ?></a></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <!-- 夥伴商城 -->
                    <div class="col-12 col-md-2">
                        <h2>夥伴商城</h2>
                        <hr>
                        <?php if (!empty($footer_category)) : ?>
                            <?php foreach ($footer_category as $self) : ?>
                                <?php if ($self['parent_id'] == 1 && $self['status'] == 1) : ?>
                                    <p><a href="/product/index?id=<?= $self['sort'] ?>"><?= $self['name'] ?></a></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-md-2">
                        <h2>其他連結</h2>
                        <hr>
                        <p><a href="/about">關於夥伴</a></p>
                        <p><a href="/product">產品介紹</a></p>
                        <p><a href="#">合作介紹</a></p>
                        <p><a href="#">經銷通路</a></p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h2>聯絡我們</h2>
                        <hr>
                        <p><i class="fa-solid fa-phone"></i>&ensp;<a href="tel:<?php echo get_setting_general('phone1'); ?>"><?php echo get_setting_general('phone1'); ?></a></p>
                        <p><i class="fa-solid fa-envelope"></i>&ensp;<a href="mailto:<?php echo get_setting_general('email'); ?>"><?php echo get_setting_general('email'); ?></a></p>
                        <p><i class="fa-solid fa-map-location-dot"></i>&ensp;<?php echo get_setting_general('address'); ?></p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3640.4789445134197!2d120.67437757593652!3d24.15493037312489!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34693d7ace462a2b%3A0xc2473adc0c9d6183!2zNDA05Y-w5Lit5biC5YyX5Y2A5Lit5riF6Lev5LiA5q61ODnomZ85IDEw!5e0!3m2!1szh-TW!2stw!4v1701331194617!5m2!1szh-TW!2stw" width="100%" height="auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <div class="col-md-12">
                        Copyright © 2023 <?php echo get_setting_general('name'); ?>. All rights reserved.
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
</div>
<script src="/assets/bootstrap-4.2.1-dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script defer src="/assets/fontawesome-free-6.1.1-web/js/all.js"></script>
<?php if ($this->is_partnertoys) : ?>
    <script src="/assets/js/partnertoysPage.js"></script>
    <script src="/assets/magnific-popup/jquery.magnific-popup.min.js"></script>
<?php endif; ?>
<script>
    $(document).ready(function() {
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
        $(".content_auto_h").css('padding-top', header_h * 2.5);
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
        $(function() {
            $('#scrollToBottomBtn').click(function() {
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 1000);
            });
        });
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