<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberForm">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">MEMBER<span class="memberTitleLogin">&nbsp;INFORMATION</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <?php if ($this->session->flashdata('editMessage')) { ?>
                    <div class="alert alert-info text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('editMessage'); ?>
                    </div>
                <?php } ?>
                <?php echo form_open('auth/edit_user'); ?>
                <div class="form-content">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">使用者帳號</span>
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $user->username; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">姓名</span>
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $user->full_name; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">電子郵件</span>
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></i></span>
                                </div>
                                <input type="text" class="form-control" name="email" id="email" onchange="check_email()" value="<?php echo $user->email; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">聯絡電話</span>
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $user->phone; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">地址</span>
                                    <span class="input-group-text"><i class="fas fa-street-view"></i></span>
                                </div>
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo $user->address; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">生日</span>
                                    <span class="input-group-text"><i class="fa-solid fa-cake-candles"></i></span>
                                </div>
                                <input type="date" class="form-control" name="birthday" id="birthday" value="<?php echo $user->birthday; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group paddingFixTop text-center">
                    <button type="submit" id="editBtn"><i class="fas fa-check" aria-hidden="true"></i>&nbsp;儲存</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
