<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

    <div class="fixed-bottom header_fixed_icon">
        <div id="fa-facebook-square" class="my-2 icon_pointer">
            <a href="#">
                <img class="fixed_icon_style" src="/assets/images/web icon_fb.png" alt="">
            </a>
        </div>
        <div id="fa-line" class="my-2 icon_pointer">
            <a target="_blank" href="https://line.me/R/ti/p/@504bdron">
                <img class="fixed_icon_style" src="/assets/images/web icon_line service.png" alt="">
            </a>
        </div>
        <div id="fa-bag-shopping" class="my-2 icon_pointer">
            <a href="#" data-toggle="modal" style="position: relative;" data-target="#my_cart" onclick="get_mini_cart();">
                <div id="cart-qty"><span>0</span></div>
                <img class="fixed_icon_style" src="/assets/images/web icon_shopping car.png" alt="">
            </a>
        </div>
        <div id="fa-angles-up" class="my-2 icon_pointer" style="display: none;">
            <a href="#" style="color:black;">
                <img class="fixed_icon_style" src="/assets/images/web icon_top.png" alt="">
            </a>
        </div>
    </div>

    <footer id="footer">
        <div class="footer-copyright" style="background-color: #000;padding-bottom: 15px; padding-top:15px;">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <div class="col-md-6">
                        <span style="color: #fff;">Copyright © 2022 <?php echo get_setting_general('name'); ?>. All rights reserved.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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
<script>
$(document).ready(function() {
    get_cart_qty();
});
</script>
<!-- MyCart -->
<script>
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
</script>
<!-- MyCart -->
<!-- Window Height -->
<script>
$(function() {
    var h = $(window).height();
    var header_h = $("#header").height();
    var footer_h = $("#footer").height();
    var content_auto_h = $(".content_auto_h").height();
    // alert(content_auto_h);
    // alert(h);
    var main_h = $(".main").height();
    var h_sum = h - header_h - footer_h;
    var h_checkout = h_sum * 0.6;
    if (h_sum >= content_auto_h) {
        $(".content_auto_h").css('height', h_sum);
    } else {
        $(".content_auto_h").css('height', '100%');
    }
    $(".wizard > .content").css('min-height', h_checkout);
});
</script>
<!-- Window Height -->
<!-- scrollTop -->
<script>
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
        $('html, body').animate({ scrollTop: 0 }, 200);
    });
});
</script>
<!-- scrollTop -->
</body>

</html>