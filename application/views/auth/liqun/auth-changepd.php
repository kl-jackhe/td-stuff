<!-- Auth function -->
<div role="main" class="main">
  <div class="container">
    <div class="justify-content-center">
      <div class="memberForm">
        <div class="col-12 text-center">
          <span class="memberTitleMember">CHANGE<span class="memberTitleLogin">&nbsp;PASSWORD</span></span>
        </div>
        <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
        <?php if ($this->session->flashdata('changePasswordMessage')) { ?>
          <div class="alert alert-info text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('changePasswordMessage'); ?>
          </div>
        <?php } ?>
        <?php echo form_open("auth/change_password"); ?>
        <div class="form-content">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-bg-12 col-md-6 col-lg-6 required" for="old">舊密碼</label>
                <input type="password" class="form-control" id="old" name="old" placeholder="請輸入舊密碼" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-bg-12 col-md-6 col-lg-6 required" for="new">新密碼</label>
                <input type="password" class="form-control" id="new" name="new" placeholder="請輸入6~20個字元內的新密碼" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-bg-12 col-md-6 col-lg-6 required" for="new_confirm">新密碼</label>
                <input type="password" class="form-control" id="new_confirm" name="new_confirm" placeholder="請再次輸入密碼" required>
              </div>
            </div>
          </div>
          <div class="form-group col-12 text-center paddingFixTop">
            <button type="submit" id="changeBtn">
              <i class="fas fa-check" aria-hidden="true"></i>&nbsp;確認更改
            </button>
          </div>
        </div>
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>