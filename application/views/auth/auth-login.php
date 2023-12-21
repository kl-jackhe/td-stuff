<!-- Auth function -->
<div role="main" class="main pt-xlg-main">
    <div class="container">
        <div class="box mt-md">
            <div class="justify-content-center">
                <div id="memberLoginForm" class="row">
                    <div class="col-12 text-center">
                        <span class="memberTitleMember">MEMBER<span class="memberTitleLogin">&nbsp;LOGIN</span></span>
                    </div>
                    <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                    <?php if (!empty($this->session->flashdata('loginMessage'))) { ?>
                        <div class="alert alert-info col-12">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('loginMessage'); ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($this->session->flashdata('identity'))) {
                        $loginIdentity = $this->session->flashdata('identity');
                    } ?>
                    <?php $attributes = array('id' => 'login'); ?>
                    <?php echo form_member_login_open('auth/login', $attributes); ?>

                    <div class="col-12 form-group">
                        <label class="required" for="identity">行動電話|E-MAIL</label>
                        <input type="text" class="form-control" id="identity" name="identity" placeholder="請輸入手機號碼或E-MAIL" value="<?php echo (!empty($loginIdentity) ? $loginIdentity : ''); ?>" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="required" for="password">密碼</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼" required>
                    </div>
                    <div class="row" id="formBtnStyle">
                        <div class="col-6 form-group text-center">
                            <button type="reset" id="eraseBtn">
                                <i class="fas fa-times" aria-hidden="true"></i>&nbsp;清除
                            </button>
                            <!-- <input type="button" value="清除" id="eraseBtn"> -->
                        </div>
                        <div class="col-6 form-group text-center">
                            <button type="submit" id="loginBtn">
                                <i class="fas fa-check" aria-hidden="true"></i>&nbsp;登入
                            </button>
                            <!-- <input type="submit" value="登入" id="loginBtn"> -->
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <a href="/forgot_password" class="pull-right" id="forgotBtn">
                            <i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;忘記登入資訊
                        </a>
                    </div>
                    <?php echo form_close(); ?>
                    <div id="separator" class="col-sm-12 col-md-6 col-lg-6">
                        <div class="text-center">
                            <span id="memberTitle">還不是「夥伴玩具有限公司」會員嗎？</span>
                        </div>
                        <div class="text-center">
                            <span id="memberTxt">加入會員即可在官網自由選購或詢價商品，您可輕鬆掌握每筆訂單的最新處理狀態。</span>
                        </div>
                        <div class="text-center" id="addMember">
                            <a href="/register" id="addMemberBtn">
                                <i class="fas fa-user-plus"></i>&nbsp;立即加入會員
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>