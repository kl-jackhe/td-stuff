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
                                    <span class="input-group-text">國家</span>
                                    <span class="input-group-text"><i class="fas fa-street-view"></i></span>
                                </div>
                                <select class="form-control" name="Country" id="Country">
                                    <option value="請選擇國家" selected>請選擇國家</option>
                                    <option value="臺灣" <?= ($user->Country == '臺灣') ? 'selected' : ''; ?>>臺灣</option>
                                    <option value="中國" <?= ($user->Country == '中國') ? 'selected' : ''; ?>>中國</option>
                                    <option value="香港" <?= ($user->Country == '香港') ? 'selected' : ''; ?>>香港</option>
                                    <option value="澳門" <?= ($user->Country == '澳門') ? 'selected' : ''; ?>>澳門</option>
                                    <option value="其它" <?= ($user->Country == '其它') ? 'selected' : ''; ?>>其它</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- zip of taiwan -->
                    <div id="twzipcode" class="input-group mb-3 col-12 row" style="display: none;">
                        <div class="mb-2 col-md-4 col-12 d-flex justify-content-center align-items-center" data-role="county" data-value="<?= $user->county ?>"></div>
                        <div class="mb-2 col-md-4 col-12 d-flex justify-content-center align-items-center" data-role="district" data-value="<?= $user->district ?>"></div>
                        <div class="mb-2 col-md-4 col-12 d-flex justify-content-center align-items-center" data-role="zipcode" data-value="<?= $user->zipcode ?>"></div>
                    </div>
                    <!-- zip of china -->
                    <div id="cnzipcode" class="input-group mb-3 col-12 row" style="display: none;">
                        <div class="mb-2 col-lg-3 col-md-6 col-12 d-flex justify-content-center align-items-center" data-role="province"></div>
                        <div class="mb-2 col-lg-3 col-md-6 col-12 d-flex justify-content-center align-items-center" data-role="county"></div>
                        <div class="mb-2 col-lg-3 col-md-6 col-12 d-flex justify-content-center align-items-center" data-role="district"></div>
                        <div class="mb-2 col-lg-3 col-md-6 col-12 d-flex justify-content-center align-items-center" data-role="zipcode"></div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細地址</span>
                                    <span class="input-group-text"><i class="fas fa-street-view"></i></span>
                                </div>
                                <input type="text" class="form-control" name="address" id="address" placeholder="請輸入詳細地址" value="<?php echo $user->address; ?>">
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
                                <input type="date" class="form-control" name="birthday" id="birthday" value="<?php echo ($user->birthday != '0000-00-00') ? $user->birthday : ''; ?>">
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