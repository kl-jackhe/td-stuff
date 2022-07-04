<div role="main" class="main pt-xlg-main">
    <section>
        <div class="container">
            <div class="box mt-md">
                <div class="row">
                  <div class="col-md-6 col-md-offset-3" style="box-shadow: 6px 6px 20px grey; padding: 30px 60px;">
                    <?php echo form_open("login"); ?>
                      <?php if($this->session->flashdata('message')) { ?>
                        <div class="alert alert-danger" role="alert">
                          <?php echo $this->session->flashdata('message');?>
                        </div>
                      <?php } ?>
                      <div class="form-group">
                        <label><h4>電子信箱</h4></label>
                        <input type="text" class="form-control" id="identity" name="identity" placeholder="請輸入 E-mail" required>
                      </div>
                      <div class="form-group">
                        <label><h4>密碼</h4></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="6-15個字元" required>
                      </div>
                      <div class="form-group">
                        <p>
                          <a href="/forgot_password" class="pull-right">忘記密碼?</a>
                        </p>
                      </div>
                      <div class="form-group clearfix">
                        <input type="submit" value="登入" class="btn btn-info btn-lg btn-block mt-xl mr-lg">
                      </div>
                      <div class="form-group clearfix">
                        <a href="/register" class="btn btn-info btn-lg btn-block mt-xl mr-lg">免費註冊</a>
                      </div>
                    <?php echo form_close(); ?>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>