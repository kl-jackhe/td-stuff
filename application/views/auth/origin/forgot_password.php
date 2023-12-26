<div role="main" class="main">
    <section class="content_auto_h">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center">
                    <?php echo form_open("auth/forgot_password");?>
                    <h1>忘記手機號碼或密碼</h1>
                    <p>請填寫您的手機號碼或是電子郵件，以便讓我們寄送電子郵件查看手機號碼或重新設定密碼。</p>
                    <div id="infoMessage"><?php echo $message;?></div>
                    <div class="form-group">
                      <!-- <label>手機號碼或電子郵件</label> -->
                      <?php echo form_input($identity);?>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-info">送出認證信</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>