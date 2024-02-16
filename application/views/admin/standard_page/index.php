<div class="row">
    <div class="col-md-12">
        <div class="tabbable" style="margin-top: 0px;">
            <?php if ($this->is_partnertoys) : ?>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#TermsOfService_tw" aria-controls="TermsOfService_tw" role="tab" data-toggle="tab" onclick="openStandardPage('TermsOfService_tw','zh_tw')"><?= $this->lang->line('TermsOfService_tw') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#TermsOfService_cn" aria-controls="TermsOfService_cn" role="tab" data-toggle="tab" onclick="openStandardPage('TermsOfService_cn','zh_cn')"><?= $this->lang->line('TermsOfService_cn') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#TermsOfService_jp" aria-controls="TermsOfService_jp" role="tab" data-toggle="tab" onclick="openStandardPage('TermsOfService_jp','ja_jp')"><?= $this->lang->line('TermsOfService_jp') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#TermsOfService_en" aria-controls="TermsOfService_en" role="tab" data-toggle="tab" onclick="openStandardPage('TermsOfService_en','en_us')"><?= $this->lang->line('TermsOfService_en') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#LogisticsAndPayment_tw" aria-controls="LogisticsAndPayment_tw" role="tab" data-toggle="tab" onclick="openStandardPage('LogisticsAndPayment_tw','zh_tw')"><?= $this->lang->line('LogisticsAndPayment_tw') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#LogisticsAndPayment_cn" aria-controls="LogisticsAndPayment_cn" role="tab" data-toggle="tab" onclick="openStandardPage('LogisticsAndPayment_cn','zh_cn')"><?= $this->lang->line('LogisticsAndPayment_cn') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#LogisticsAndPayment_jp" aria-controls="LogisticsAndPayment_jp" role="tab" data-toggle="tab" onclick="openStandardPage('LogisticsAndPayment_jp','ja_jp')"><?= $this->lang->line('LogisticsAndPayment_jp') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#LogisticsAndPayment_en" aria-controls="LogisticsAndPayment_en" role="tab" data-toggle="tab" onclick="openStandardPage('LogisticsAndPayment_en','en_us')"><?= $this->lang->line('LogisticsAndPayment_en') ?></a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="TermsOfService_tw"></div>
                    <div role="tabpanel" class="tab-pane" id="TermsOfService_cn"></div>
                    <div role="tabpanel" class="tab-pane" id="TermsOfService_jp"></div>
                    <div role="tabpanel" class="tab-pane" id="TermsOfService_en"></div>
                    <div role="tabpanel" class="tab-pane" id="LogisticsAndPayment_tw"></div>
                    <div role="tabpanel" class="tab-pane" id="LogisticsAndPayment_cn"></div>
                    <div role="tabpanel" class="tab-pane" id="LogisticsAndPayment_jp"></div>
                    <div role="tabpanel" class="tab-pane" id="LogisticsAndPayment_en"></div>
                </div>
            <?php else : ?>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#FraudPreventionInformation" aria-controls="FraudPreventionInformation" role="tab" data-toggle="tab" onclick="openStandardPage('FraudPreventionInformation','zh_tw')"><?= $this->lang->line('FraudPreventionInformation') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#TermsOfService" aria-controls="TermsOfService" role="tab" data-toggle="tab" onclick="openStandardPage('TermsOfService','zh_tw')"><?= $this->lang->line('TermsOfService') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#PrivacyPolicy" aria-controls="PrivacyPolicy" role="tab" data-toggle="tab" onclick="openStandardPage('PrivacyPolicy','zh_tw')"><?= $this->lang->line('PrivacyPolicy') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#Disclaimer" aria-controls="Disclaimer" role="tab" data-toggle="tab" onclick="openStandardPage('Disclaimer','zh_tw')"><?= $this->lang->line('Disclaimer') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#IntellectualProperty" aria-controls="IntellectualProperty" role="tab" data-toggle="tab" onclick="openStandardPage('IntellectualProperty','zh_tw')"><?= $this->lang->line('IntellectualProperty') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#LogisticsAndPayment" aria-controls="LogisticsAndPayment" role="tab" data-toggle="tab" onclick="openStandardPage('LogisticsAndPayment','zh_tw')"><?= $this->lang->line('LogisticsAndPayment') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#ReturnPolicy" aria-controls="ReturnPolicy" role="tab" data-toggle="tab" onclick="openStandardPage('ReturnPolicy','zh_tw')"><?= $this->lang->line('ReturnPolicy') ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#FrequentlyQA" aria-controls="FrequentlyQA" role="tab" data-toggle="tab" onclick="openStandardPage('FrequentlyQA','zh_tw')"><?= $this->lang->line('FrequentlyQA') ?></a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="FraudPreventionInformation"></div>
                    <div role="tabpanel" class="tab-pane" id="TermsOfService"></div>
                    <div role="tabpanel" class="tab-pane" id="PrivacyPolicy"></div>
                    <div role="tabpanel" class="tab-pane" id="Disclaimer"></div>
                    <div role="tabpanel" class="tab-pane" id="IntellectualProperty"></div>
                    <div role="tabpanel" class="tab-pane" id="LogisticsAndPayment"></div>
                    <div role="tabpanel" class="tab-pane" id="ReturnPolicy"></div>
                    <div role="tabpanel" class="tab-pane" id="FrequentlyQA"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        if (location.hash) {
            $('a[href=\'' + location.hash + '\']').tab('show');
        }
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[href="' + activeTab + '"]').tab('show');
        }

        $('body').on('click', 'a[data-toggle=\'tab\']', function(e) {
            e.preventDefault()
            var tab_name = this.getAttribute('href')
            if (history.pushState) {
                history.pushState(null, null, tab_name)
            } else {
                location.hash = tab_name
            }
            localStorage.setItem('activeTab', tab_name)

            $(this).tab('show');
            return false;
        });

        <?php if ($this->is_partnertoys) : ?>
            openStandardPage('TermsOfService_tw', 'zh_tw');
            openStandardPage('TermsOfService_cn', 'zh_cn');
            openStandardPage('TermsOfService_jp', 'ja_jp');
            openStandardPage('TermsOfService_en', 'en_us');
            openStandardPage('LogisticsAndPayment_tw', 'zh_tw');
            openStandardPage('LogisticsAndPayment_cn', 'zh_cn');
            openStandardPage('LogisticsAndPayment_jp', 'ja_jp');
            openStandardPage('LogisticsAndPayment_en', 'en_us');
        <?php else : ?>
            openStandardPage('FraudPreventionInformation', 'zh_tw');
            openStandardPage('TermsOfService', 'zh_tw');
            openStandardPage('PrivacyPolicy', 'zh_tw');
            openStandardPage('Disclaimer', 'zh_tw');
            openStandardPage('IntellectualProperty', 'zh_tw');
            openStandardPage('LogisticsAndPayment', 'zh_tw');
            openStandardPage('ReturnPolicy', 'zh_tw');
            openStandardPage('FrequentlyQA', 'zh_tw');
        <?php endif; ?>
    });

    function openStandardPage(source, lang) {
        $('#' + source).html('');
        $.ajax({
            url: 'StandardPage/openStandardPage',
            type: 'POST',
            data: {
                source: source,
                lang: lang,
            },
            success: function(data) {
                $('#' + source).html(data);
                $('#' + source + ' span').attr('id', source + 'Btn').attr('onclick', 'changeStandardPage("' + source + '","' + lang + '")');
                $('#' + source + ' input').attr('id', source + 'Title');
                $('#' + source + ' textarea').attr('id', source + 'Content');
                toggleTinyMCE(source);
            }
        });
    }

    function changeStandardPage(source, lang) {
        console.log($('#' + source + 'Content').val());
        $.ajax({
            url: 'StandardPage/changeStandardPage',
            type: 'POST',
            data: {
                source: source,
                lang: lang,
                title: $('#' + source + 'Title').val(),
                content: tinymce.get(source + 'Content').getContent(),
            },
            success: function(data) {
                alert('更新成功！');
                location.reload();
            }
        });
    }

    function toggleTinyMCE(source) {
        var textareaId = source + 'Content';
        if (tinymce.get(textareaId)) {
            tinymce.get(textareaId).remove();
        }
        tinymce.init({
            language: 'zh_TW',
            selector: 'textarea#' + textareaId,
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt 60pt 72pt 84pt 96pt",
            content_css: ['/assets/admin/bootstrap/dist/css/bootstrap.min.css'],
            font_formats: '微軟正黑體=微軟正黑體,Microsoft JhengHei;新細明體=PMingLiU,新細明體;標楷體=標楷體,DFKai-SB,BiauKai;黑體=黑體,SimHei,Heiti TC,Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=v erdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;',
        });
    }
</script>