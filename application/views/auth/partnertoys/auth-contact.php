<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div class="memberContactUs">
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
                        您可以使用電話與我們聯絡，亦可將您的寶貴意見、合作提案，以e-mail、私訊粉專等方式通知我們，並提供您的需求內容，我們將會迅速處理，謝謝您。
                    </div>
                    <? if (!empty(get_setting_general('phone1'))) { ?>
                        <div class="col-4">
                            <div id="fa-phone-square" class="my-3 icon_pointer link_href">
                                <a id="phone_href" href="tel:<?= get_setting_general('phone1') ?>" target="_blank">
                                    <div class="iconBoxwrap"><i class="fa fa-phone-square fixed_icon_style" aria-hidden="true"></i></div>
                                    <span>Number</span>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                    <? if (!empty(get_setting_general('email'))) { ?>
                        <div class="col-4">
                            <div id="fa-email-square" class="my-3 icon_pointer link_href">
                                <a id="email_href" href="mailto:<?= get_setting_general('email') ?>" target="_blank">
                                    <div class="iconBoxwrap"><i class="fas fa-envelope fixed_icon_style"></i></div>
                                    <span>Email</span>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                    <? if (!empty(get_setting_general('message_link'))) { ?>
                        <div class="col-4">
                            <div id="fa-message-square" class="my-3 icon_pointer link_href">
                                <a id="message_href" href="//<?= get_setting_general('message_link') ?>" target="_blank">
                                    <div class="iconBoxwrap"><i class="fa-brands fa-facebook-messenger fixed_icon_style"></i></div>
                                    <span>Message</span>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>