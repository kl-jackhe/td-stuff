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
</section>