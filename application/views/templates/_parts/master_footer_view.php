<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<footer id="footer">
    <div class="footer-copyright" style="background-color: #000;padding-bottom: 15px; padding-top:15px;">
        <div class="container-fluid">
            <div class="row justify-content-center text-center">
                <div class="col-md-6">
                    <span style="color: #fff;">Copyright © 2022 龍寶嚴選. All rights reserved.</span>
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
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-5 col-sm-6">
                            <span class="btn btn-info btn-block mt-md" onclick="view_form_check()">前往結帳</span>
                        </div>
                        <div class="col-7 col-sm-6">
                            <spna class="btn btn-dark btn-block mt-md" data-dismiss="modal">繼續選購商品 <i class="fa-solid fa-arrow-right-long"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- <script src="/node_modules/jquery/dist/jquery.min.js"></script> -->
<!-- <script src="/node_modules/jquery.appear/jquery.appear.min.js')}}script> -->
<!-- <script src="/node_modules/jquery.easing/jquery.easing.min.js"></script>
  <script src="/node_modules/jquery.cookie/jquery.cookie.js"></script>
  <script src="/node_modules/common/common.min.js"></script>
  <script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script> -->
<!-- <script src="/node_modules/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js')}}script> -->
<!-- <script src="/node_modules/jquery.gmap/jquery.gmap.min.js')}}script> -->
<!-- <script src="/node_modules/jquery-lazyload/jquery.lazyload.js"></script> -->
<!-- <script src="/node_modules/isotope/jquery.isotope.min.js"></script> -->
<!-- <script src="/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="/node_modules/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
  <script src="/node_modules/vide/vide.min.js"></script> -->
<!-- Theme Base, Components and Settings -->
<!-- <script src="/assets/js/theme.js"></script> -->
<!-- Theme Initialization Files -->
<!-- <script src="/assets/js/theme.init.js"></script> -->
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<!-- purchase-steps -->
<script src="/assets/jquery.steps-1.1.0/jquery.steps.min.js"></script>
<script>
$("#wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    enableFinishButton: false,
    titleTemplate: '<div class="number row"><i></i><p>#index#</p></div><span class="wizard_section_title">#title#</span>',
    labels: {
        cancel: "取消",
        current: "current step:",
        pagination: "Pagination",
        finish: "完成",
        next: "下一步",
        previous: "上一步",
        loading: "載入中..."
    }
    // autoFocus: true
});
</script>
<!-- purchase-steps -->
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
    var main_h = $(".main").height();
    var h_sum = h - header_h - footer_h;
    var h_checkout = h_sum * 0.6;
    if (h > main_h) {
        $(".main").css('height', h_sum);
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
            $('#fa-angles-up').show();
        } else {
            $('#fa-angles-up').hide();
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