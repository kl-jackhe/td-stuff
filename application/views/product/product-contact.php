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