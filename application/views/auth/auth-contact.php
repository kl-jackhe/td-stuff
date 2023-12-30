<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberForm">
                <div class="row">
                    <div class="col-12 text-center">
                        <span class="memberTitleMember">CONTACT<span class="memberTitleLogin">&nbsp;US</span></span>
                    </div>
                    <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                    <?php if ($this->session->flashdata('contactMessage')) { ?>
                        <div class="alert alert-info text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('contactMessage'); ?>
                        </div>
                    <?php } ?>
                    <div class="notice">
                        您可以使用電話與我們聯絡，亦可將您的寶貴意見、合作提案，以傳真、e-mail 方式通知我們，或利用以下表單來傳達您的訊息，希望您能留下大名及聯絡電話，我們將會迅速處理，謝謝您。
                    </div>
                    <? if ($agentID == '' && get_setting_general('phone1') != '') { ?>
                        <div id="fa-phone-square" class="my-3 icon_pointer col-3 link_href">
                            <a id="phone_href" href="tel:<?= get_setting_general('phone1') ?>" target="_blank">
                                <i class="fa fa-phone-square fixed_icon_style" aria-hidden="true"></i><br>Number
                            </a>
                        </div>
                    <? } ?>
                    <? if ($agentID == '' && get_setting_general('email') != '') { ?>
                        <div id="fa-email-square" class="my-3 icon_pointer col-3 link_href">
                            <a id="email_href" href="mailto:<?= get_setting_general('email') ?>" target="_blank">
                                <i class="fa fa-envelope fixed_icon_style" aria-hidden="true"></i><br>Email
                            </a>
                        </div>
                    <? } ?>
                    <? if ($agentID == '' && get_setting_general('official_facebook_1') != '') { ?>
                        <div id="fa-facebook-square" class="my-3 icon_pointer col-3 link_href">
                            <a id="facebook_href" href="<?= get_setting_general('official_facebook_1') ?>" target="_blank">
                                <i class="fa-brands fa-facebook fixed_icon_style" aria-hidden="true"></i><br>Facebook
                            </a>
                        </div>
                    <? } ?>
                    <? if ($agentID == '' && get_setting_general('official_instagram_1') != '') { ?>
                        <div id="fa-instagram-square" class="my-3 icon_pointer col-3 link_href">
                            <a id="instagram_href" href="<?= get_setting_general('official_instagram_1') ?>" target="_blank">
                                <i class="fa-brands fa-instagram fixed_icon_style" aria-hidden="true"></i><br>Instagram
                            </a>
                        </div>
                    <? } ?>
                    <? if (get_setting_general('official_line_1') != '') { ?>
                        <div id="fa-line" class="my-3 icon_pointer col-3 link_href">
                            <a href="<?= get_setting_general('official_line_1') ?>" target="_blank">
                                <img class="fixed_icon_style" src="/assets/images/web icon_line service.png">
                            </a>
                        </div>
                    <? } ?>
                </div>
                <?php
                // echo '<pre>';
                // print_r($this->session->userdata());
                // echo '</pre>';
                ?>
                <?php $attributes = array('id' => 'cantact_us'); ?>
                <?php echo form_open('auth/cantact_us', $attributes); ?>
                <div class="row">
                    <div class="col-bg-12 col-md-6 col-lg-6 form-group">
                        <label>留言項目</label>
                        <select class="form-control" id="freetime" name="freetime">
                            <option value="聯絡我們" selected>聯絡我們</option>
                        </select>
                    </div>
                    <div class="col-bg-12 col-md-6 col-lg-6 form-group">
                        <label>方便聯絡時間</label>
                        <select class="form-control" id="freetime" name="freetime">
                            <option value="請選擇方便聯絡時間" selected>請選擇方便聯絡時間</option>
                            <option value="上午">上午</option>
                            <option value="中午">中午</option>
                            <option value="下午">下午</option>
                            <option value="皆可">皆可</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label for="company">公司名稱</label>
                        <input type="text" class="form-control" id="company" name="company" placeholder="請輸入您的公司名稱">
                    </div>
                    <div class="col-bg-12 col-md-6 col-lg-6 form-group">
                        <label class="required" for="number">聯絡電話</label>
                        <input type="text" class="form-control" id="number" name="number" placeholder="請輸入您的連絡電話" value="<?= !empty($this->session->userdata('identity')) ? $this->session->userdata('identity') : '' ?>" required>
                    </div>
                    <div class="col-bg-12 col-md-6 col-lg-6 form-group">
                        <label class="required" for="name">姓名</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入您的姓名" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="required" for="email">E-MAIL</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="請輸入您的E-MAIL" value="<?= !empty($this->session->userdata('email')) ? $this->session->userdata('email') : '' ?>" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="required" for="content">訊息內容</label>
                        <textarea class="form-control" id="content" name="content" placeholder="請輸入您的訊息內容" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="captcha" name="captcha" value="<?= $this->session->flashdata('captcha') ?>">
                    </div>
                    <div class="col-12 form-group" style="position:relative;">
                        <label class="required" for="checkcode">驗證碼</label>
                        <input type="text" class="form-control" id="checkcode" name="checkcode" placeholder="請輸入驗證碼" autocomplete="off" required>
                        <a @click="randomCheckcodeContact"><img id="randomCheckcodeContact" src="<?php echo $imageBase64; ?>" alt="Captcha Image"></a>
                    </div>
                    <div class="col-12 form-group">
                        <span id="error_text" style="color: red; font-weight: bold;"></span>
                    </div>
                    <div class="col-6 form-group text-center paddingFixTop">
                        <button type="reset" id="contactEraseBtn"><i class="fas fa-times" aria-hidden="true"></i>&nbsp;清除</button>
                    </div>
                    <div class="col-6 form-group text-center paddingFixTop">
                        <button type="button" id="contactSendBtn" onclick="contact_check()"><i class="fas fa-check" aria-hidden="true"></i>&nbsp;送出</button>
                    </div>
                </div>

                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>