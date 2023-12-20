<!-- Auth function -->
<div role="main" class="main pt-xlg-main">
    <div class="container">
        <div class="box mt-md">
            <div class="justify-content-center">
                <div class="memberForm">
                    <div class="col-12 text-center">
                        <span class="memberTitleMember">MEMBER<span class="memberTitleLogin">&nbsp;JOIN</span></span>
                    </div>
                    <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                    <?php if (!empty($this->session->flashdata('form_values'))) {
                        $form_values = $this->session->flashdata('form_values');
                        // 使用 isset() 確認索引存在
                        $registerIdentity = isset($form_values['identity']) ? $form_values['identity'] : '';
                        $registerName = isset($form_values['name']) ? $form_values['name'] : '';
                        $registerEmail = isset($form_values['email']) ? $form_values['email'] : '';
                    } ?>
                    <?php $attributes = array('id' => 'register'); ?>
                    <?php echo form_open('register', $attributes); ?>
                    <?php if (!empty($this->session->flashdata('registerMessage'))) { ?>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('registerMessage'); ?>
                        </div>
                    <?php } ?>
                    <div class="form-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="identity">行動電話 <small style="color: #C52B29;">以行動電話作為登入帳號</small></label>
                                    <input type="text" class="form-control" id="identity" name="identity" placeholder="09xxxxxxxx" value="<?php echo !empty($registerIdentity) ? $registerIdentity : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="name">姓名</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="請輸入姓名" value="<?php echo !empty($registerName) ? $registerName : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="email">電子信箱 <small id="email_text" style="color: #C52B29;"></small></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="請輸入E-Mail" onchange="check_email()" value="<?php echo !empty($registerEmail) ? $registerEmail : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="required" for="password">密碼</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="6-15 個字元" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="required" for="password_confirm">確認密碼</label>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="請再輸入一次密碼" required>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row d-none">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="agree" name="agree"> 我同意<a href="/about/rule" class="use-modal-btn">網站服務條款</a>及<a href="/about/privacy_policy" class="use-modal-btn">隱私政策</a>
                                        </label>
                                    </div>
                                    <label id="agree-error" class="error" for="agree"></label>
                                </div>
                            </div> -->
                    </div>
                    <span id="error_text" style="color: red; font-weight: bold;"></span>
                    <input type="hidden" id="email_ok" value="0">
                    <input type="hidden" id="identity_ok" value="0">
                    <!-- <input type="hidden" name="now_url" value="<?php // echo base_url() . $_SERVER['REQUEST_URI'] 
                                                                    ?>"> -->
                    <div class="form-action clearfix text-center">
                        <span id="joinBtn" onclick="form_check()"><i class="fas fa-check" aria-hidden="true"></i>&nbsp;加入會員</span>
                        <!-- <input type="submit" value="免費註冊" class="btn btn-info btn-lg btn-block mt-xl mr-lg"> -->
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>