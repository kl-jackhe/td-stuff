<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

  <footer id="footer">
    <!-- 電腦板footer -->
    <div class="footer-sidebar visible-md visible-lg">
      <div class="container-fluid">
        <div class="col-md-3">
          <h3 class="fs-16 color-white">
            <img src="/assets/images/bytheway_footer.png" class="img-responsive" style="float: left; width: 65%; margin-left: -5px;"> 團隊
          </h3>
          <p><a href="/about/brand" class="fs-13 color-221814">品牌介紹</a></p>
          <p><a href="/about/history" class="fs-13 color-221814">創業故事</a></p>
          <!-- <p><a href="/about/team" class="fs-13 color-221814">車隊介紹</a></p> -->
        </div>
        <div class="col-md-3">
          <h3 class="fs-16 color-white">法律規章</h3>
          <p><a href="/about/privacy_policy" class="use-modal-btn fs-13 color-221814">隱私權保護政策</a></p>
          <p><a href="/about/rule" class="use-modal-btn fs-13 color-221814">使用條款與條件</a></p>
        </div>
        <div class="col-md-3">
          <h3 class="fs-16 color-white">合作機會</h3>
          <p><a href="/about/cross_industry_alliance" class="fs-13 color-221814">異業合作</a></p>
          <p><a href="/about/shop_alliance" class="fs-13 color-221814">店家合作</a></p>
        </div>
        <div class="col-md-3">
          <div class="row">
            <div class="col-md-3 col-xs-3 form-group">
              <a href="https://www.facebook.com/bythewaytaiwan/" target="_new">
                <img src="/assets/images/white_fb.png" class="img-responsive" style="padding-top: 20px;">
              </a>
            </div>
          </div>
          <div class="row">
            <!-- <div style="padding-bottom: 3px;"><button class="btn" onclick="getLiffUserID()">get UserID</button></div> -->
            <!-- <div style="padding-bottom: 3px;"><button class="btn" onclick="sendMessages()">send messages</button></div> -->
            <!-- <div style="padding-bottom: 3px;"><button class="btn" onclick="sendMessagesAndClose()">send messages and close LIFF</button></div> -->
            <!-- <div style="padding-bottom: 3px;"><button class="btn" onclick="sendMessagesERR()">send messages ERR</button></div> -->
            <!-- <div style="padding-bottom: 3px;"><button class="btn" onclick='shareToLine()'>share</button></div> -->
            <!-- <div style="padding-bottom: 3px;"><button class="btn" onclick="LIFF_close()">close</button></div> -->
          </div>
        </div>
      </div>
    </div>
    <!-- End 電腦板footer -->
    <!-- 手機板footer -->
    <div class="footer-sidebar visible-xs visible-sm" style="padding-top: 0px;">
      <div class="container-fluid">
        <div class="col-xs-4 col-sm-4" style="padding: 0px 5px;">
          <h3 class="fs-16 color-white">法律規章</h3>
          <p><a href="/about/privacy_policy" class="use-modal-btn fs-13 color-221814">隱私權保護政策</a></p>
          <p><a href="/about/rule" class="use-modal-btn fs-13 color-221814">使用條款與條件</a></p>
          <!-- <p><span onclick='shareToLine()'>share</span></p> -->
        </div>
        <div class="col-xs-3 col-sm-3" style="padding: 0px 5px;">
          <h3 class="fs-16 color-white">合作機會</h3>
          <p><a href="/about/cross_industry_alliance" class="fs-13 color-221814">異業合作</a></p>
          <p><a href="/about/shop_alliance" class="fs-13 color-221814">店家合作</a></p>
        </div>
        <div class="col-xs-5 col-sm-5" style="padding: 0px 5px; position: relative;">
          <h3 class="fs-16 color-white">
            <img src="/assets/images/bytheway_footer.png" class="img-responsive" style="float: left;width: 75%;margin-left: -5px;"> 團隊
          </h3>
          <p><a href="/about/brand" class="fs-13 color-221814">品牌介紹</a></p>
          <p><a href="/about/history" class="fs-13 color-221814">創業故事</a></p>
          <!-- <p><a href="/about/team" class="fs-13 color-221814">車隊介紹</a></p> -->
          <a href="https://www.facebook.com/bythewaytaiwan/" target="_new" style="position: absolute; right: 0px; bottom: 0px;">
            <img src="/assets/images/white_fb.png" class="img-responsive" style="width: 50px; padding-top: 20px;">
          </a>
        </div>
        <!-- <div class="col-xs-3 col-sm-3">
          <div class="row">
            <div class="col-xs-3 col-sm-3 form-group">
              <a href="https://www.facebook.com/bythewaytaiwan/" target="_new">
                <img src="/assets/images/white_fb.png" class="img-responsive" style="padding-top: 20px;">
              </a>
            </div>
          </div>
        </div> -->
      </div>
    </div>
    <!-- End 手機板footer -->
    <div class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <p>Bytheway順便一提© Copyright 2018. All Rights Reserved.</p>
          </div>
          <div class="col-md-6">
            <nav id="sub-menu">
              <ul>
                <li><a href="/about/how_to_buy">FAQ問答</a></li>
                <li><a href="/about/contact">聯絡我們</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="server-area" id="server-area">
      <a href="https://www.facebook.com/bythewaytaiwan" target="_blank">
        <img src="/assets/images/home/server-message.png" class="img-responsive" id="server-message" style="display: none;">
      </a>
      <a href="tel:02-27419628">
        <img src="/assets/images/home/server-call.png" class="img-responsive" id="server-call" style="display: none;">
      </a>
      <a href="mailto:service1@bythewaytaiwan.com">
        <img src="/assets/images/home/server-email.png" class="img-responsive" id="server-email" style="display: none;">
      </a>
      <img src="/assets/images/home/server-up.png" class="img-responsive" onclick="close_server()" style="cursor: pointer;">
    </div>
  </footer>

  <?php if(!$this->ion_auth->logged_in() && $this->uri->segment(1)!='login' && $this->uri->segment(1)!='register') {
    include('login-register-modal.php');
  } ?>

  <div id="ajax-register-Modal" class="modal">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content" style="background: #717171; color: white;">
              <div class="modal-body" style="padding: 15px;">
                  <div class="row">
                      <div class="col-md-12" style="padding-top: 50px; padding-bottom: 50px;">
                          <img src="/assets/images/checkout/ajax-register.png" class="img-responsive">
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div id="use-Modal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" style="padding: 15px;">
          <p>讀取中...</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
            <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>

  <?php if($this->uri->segment(1)!='my_address'){ ?>
  <div id="my-address-Modal" class="modal fade">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" id="my-address-table">
        <!-- <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
        </div> -->
        <div class="modal-body" style="padding: 15px;">
          <h4 style="padding-top: 10px;">常用地址</h4>
          <table class="table">
              <?php if(!empty($address)) { foreach($address as $data) { ?>
              <tr>
                  <td>
                      <div class="form-check" onclick="set_default('<?php echo $data['id'] ?>')" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 5px; border-radius: 10px;">
                          <input type="radio" class="form-check-input" name="address" id="address_<?php echo $data['id'] ?>" value="<?php echo $data['county'].$data['district'].$data['address'] ?>" <?php echo ($data['used']?'checked':'') ?>>
                          <label for="address_<?php echo $data['id'] ?>" class="form-check-label fs-13 color-59757 font-normal">
                              <?php echo $data['county'].$data['district'].$data['address'] ?>
                          </label>
                      </div>
                  </td>
                  <td>
                      <a href="/my_address/delete/<?php echo $data['id'] ?>" onClick="return confirm('您確定要刪除嗎?')">
                          <i class="fa fa-trash-o align-middle" style="font-size: 24px; color: black;"></i>
                      </a>
                  </td>
              </tr>
              <?php }} ?>
          </table>
          <div class="row">
              <div class="col-md-6 col-md-offset-3">
                  <div class="form-group">
                      <button class="btn btn-warning btn-block" style="background: #FFB718; border-color: #FFB718; border-radius: 10px;" onclick="add_address()">添加地址</button>
                  </div>
              </div>
          </div>
          <form action="/my_address/insert" method="post" id="address_form" style="display: none;">
              <div class="form-group">
                  <div class="form-group">
                      <label class="col-sm-3 control-label">地址</label>
                      <div class="col-md-9">
                          <div id="my-address-twzipcode"></div>
                      </div>
                  </div>
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-md-9">
                      <div class="form-group">
                          <input type="text" class="form-control" name="address" id="address" value="">
                      </div>
                      <button type="submit" class="btn btn-primary" style="background: #FFB718; border-color: #FFB718; border-radius: 10px;">添加</button>
                  </div>
              </div>
          </form>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
        </div> -->
      </div>
    </div>
  </div>
  <?php } ?>

</div>

  <!-- Vendor -->
  <!-- <script src="/node_modules/jquery/dist/jquery.min.js"></script> -->
  <!-- <script src="/node_modules/jquery.appear/jquery.appear.min.js')}}script> -->
  <script src="/node_modules/jquery.easing/jquery.easing.min.js"></script>
  <script src="/node_modules/jquery.cookie/jquery.cookie.js"></script>
  <script src="/node_modules/common/common.min.js"></script>
  <script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
  <!-- <script src="/node_modules/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js')}}script> -->
  <!-- <script src="/node_modules/jquery.gmap/jquery.gmap.min.js')}}script> -->
  <script src="/node_modules/jquery-lazyload/jquery.lazyload.js"></script>
  <!-- <script src="/node_modules/isotope/jquery.isotope.min.js"></script> -->
  <script src="/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="/node_modules/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
  <script src="/node_modules/vide/vide.min.js"></script>

  <!-- Theme Base, Components and Settings -->
  <script src="/assets/js/theme.js"></script>

  <!-- Current Page Vendor and Views -->
  <script src="/node_modules/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
  <script src="/node_modules/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
  <script src="/node_modules/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
  <script src="/assets/js/views/view.home.js"></script>

  <!-- Theme Custom -->
  <script src="/assets/js/custom.min.js?v=202002102245"></script>

  <!-- Theme Initialization Files -->
  <script src="/assets/js/theme.init.js"></script>
  <script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>

  <script>
    <?php if($this->input->get('ajax_register')=='yes'){ ?>
        $('#ajax-register-Modal').modal('show');
    <?php } ?>
  </script>

</body>
</html>