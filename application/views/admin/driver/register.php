<div role="main" class="main pt-xlg-main">
    <section>
        <div class="container">
            <div class="box mt-md">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style="box-shadow: 6px 6px 20px grey; padding: 30px 60px;">
                      <?php echo form_open("register");?>
                      <div class="form-content">
                        <div class="form-group">
                          <label><h4>電子信箱</h4></label>
                          <input type="text" class="form-control" id="email" name="email" placeholder="請輸入E-Mail" required>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="password"><h4>密碼</h4></label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="6-15 個字元" required>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label><h4>確認密碼</h4></label>
                              <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="請再輸入一次密碼" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                              <label><h4>行動電話</h4></label>
                              <div class="input-group">
                                <input type="text" class="form-control form-control" id="phone" name="phone" placeholder="09xxxxxxxx" required>
                                <span class="input-group-addon" onclick="" style="background: #3bccde; color: white;">驗證</span>
                                <span class="input-group-addon" style="display: none;"></span>
                              </div>

                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label><h4>驗證碼</h4></label>
                              <input type="text" class="form-control" id="sms_code" name="sms_code" placeholder="請輸入驗證碼" required>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="agree"> 我同意<a href="privacy_policy">網站服務條款</a>及<a href="/rule">隱私政策</a>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-action clearfix">
                        <input type="submit" value="免費註冊" class="btn btn-info btn-lg btn-block mt-xl mr-lg">
                      </div>
                      <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>