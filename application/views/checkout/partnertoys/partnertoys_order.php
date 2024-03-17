<section>
    <div class="form-group">
        <div class="formTi">訂單確認</div>
    </div>
    <div class="container-fluid">
        <div class="row p-3 justify-content-center">
            <div class="col-12">
                <span class="confirm_info" style="font-size: 18px;"></span>
            </div>
            <div class="col-12 py-3" id="NotesOnBankRemittance">
                <p>＊銀行匯款＊<br>注意事項：完成付款後，記得聯繫客服，確認付款完成！</p>
                <? if (get_setting_general('official_line_1') != '') { ?>
                    Line客服連結：
                    <a href="<?= get_setting_general('official_line_1') ?>" target="_blank" style="text-decoration-line: underline;">
                        <?= get_setting_general('official_line_1') ?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="checkoutConfirm">
        <input type="checkbox" id="confirmShoppingNote"><span>已同意<span class="shoppingNote transitionAnimation" @click="toggleTermsPopup">購物須知條款</span></span>
    </div>
    <div id="termsPopupWrapper">
        <div id="termsOfMembership" class="mfp-hide">
            <div id="languageSelector"> <!-- 語言選擇器放在這裡 -->
                <select id="languageSelect">
                    <option value="zh_tw">繁體中文</option>
                    <option value="zh_cn">简体中文</option>
                    <option value="ja_jp">日本語</option>
                    <option value="en_us">English</option>
                    <!-- 其他語言選項 -->
                </select>
            </div>
            <div class="col-12 text-center">
                <span class="memberTitleMember">SHOPPING<span class="memberTitleLogin">&nbsp;NOTES</span></span>
            </div>
            <div class="memberTitleChinese col-12 text-center"><?= !empty($instructions['page_title']) ? $instructions['page_title'] : ''; ?></div>
            <div class="membershipLine"></div>
            <div class="membershipContent">
                <?php echo !empty($instructions['page_info']) ? $instructions['page_info'] : ''; ?>
            </div>
        </div>
    </div>
</section>