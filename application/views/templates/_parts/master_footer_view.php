<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
  <footer id="footer">
    <div class="footer-copyright" style="background-color: #000;padding-bottom: 15px; padding-top:15px;">
      <div class="container-fluid">
        <div class="row justify-content-center text-center">
          <div class="col-md-6">
            <span style="color: #fff;">Copyright © 2022  龍寶嚴選. All rights reserved.</span>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <?php if (!$this->ion_auth->logged_in() && $this->uri->segment(1) != 'login' && $this->uri->segment(1) != 'register') {
	include 'login-register-modal.php';
}?>

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

  <?php if ($this->uri->segment(1) != 'my_address') {?>
  <div id="my-address-Modal" class="modal fade">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" id="my-address-table">
        <div class="modal-body" style="padding: 15px;">
          <h4 style="padding-top: 10px;">常用地址</h4>
          <table class="table">
              <?php if (!empty($address)) {foreach ($address as $data) {?>
              <tr>
                  <td>
                      <div class="form-check" onclick="set_default('<?php echo $data['id'] ?>')" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 5px; border-radius: 10px;">
                          <input type="radio" class="form-check-input" name="address" id="address_<?php echo $data['id'] ?>" value="<?php echo $data['county'] . $data['district'] . $data['address'] ?>" <?php echo ($data['used'] ? 'checked' : '') ?>>
                          <label for="address_<?php echo $data['id'] ?>" class="form-check-label fs-13 color-59757 font-normal">
                              <?php echo $data['county'] . $data['district'] . $data['address'] ?>
                          </label>
                      </div>
                  </td>
                  <td>
                      <a href="/my_address/delete/<?php echo $data['id'] ?>" onClick="return confirm('您確定要刪除嗎?')">
                          <i class="fa fa-trash-o align-middle" style="font-size: 24px; color: black;"></i>
                      </a>
                  </td>
              </tr>
              <?php }}?>
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
  <?php }?>

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
  <!-- <script src="/assets/js/theme.init.js"></script>
  <script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <!-- purchase-steps -->
  <script src="/assets/jquery.steps-1.1.0/jquery.steps.min.js"></script>
  <script>
    $("#wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true
    });
  </script>
  <!-- purchase-steps -->
  <script>
    <?php if ($this->input->get('ajax_register') == 'yes') {?>
        $('#ajax-register-Modal').modal('show');
    <?php }?>
  </script>

  <script>
  $(function(){
    var h = $(window).height();
    var header_h = $("#header").height();
    var footer_h = $("#footer").height();
    var main_h = $(".main").height();
    if (h > main_h) {
      var h_sum = h - header_h - footer_h;
      $(".main").css('height',h_sum);
    }
  });
  </script>
</body>
</html>