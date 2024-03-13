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
                        <div class="col-6">
                            <div id="fa-phone-square" class="my-3 icon_pointer link_href">
                                <a id="phone_href" href="tel:<?= get_setting_general('phone1') ?>" target="_blank">
                                    <i class="fa fa-phone-square fixed_icon_style" aria-hidden="true"></i><br>Number
                                </a>
                            </div>
                        </div>
                    <? } ?>
                    <? if ($agentID == '' && get_setting_general('email') != '') { ?>
                        <div class="col-6">
                            <div id="fa-email-square" class="my-3 icon_pointer link_href">
                                <a id="email_href" href="mailto:<?= get_setting_general('email') ?>" target="_blank">
                                    <i class="fa fa-envelope fixed_icon_style" aria-hidden="true"></i><br>Email
                                </a>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>