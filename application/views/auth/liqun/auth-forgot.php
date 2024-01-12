<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberForm">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">FORGOT<span class="memberTitleLogin">&nbsp;PASSWORD</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <?php if ($this->session->flashdata('forgotMessage')) { ?>
                    <div class="alert alert-info text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('forgotMessage'); ?>
                    </div>
                <?php } ?>
                <?php echo form_open('auth/forgot_password'); ?>
                <div class="form-group text-center">
                    <label>請輸入您當初註冊時所使用的手機號碼或E-mail，以接收密碼。</label>
                    <input type="text" class="form-control" id="identity" name="identity" placeholder="請輸入手機號碼或E-mail" required>
                </div>
                <div class="form-group text-center paddingFixTop">
                    <button type="submit" id="forgotSendBtn"><i class="fas fa-check" aria-hidden="true"></i>&nbsp;送出認證信</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>