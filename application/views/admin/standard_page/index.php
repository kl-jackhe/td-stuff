<div class="row">
    <div class="col-md-12">
        <div class="tabbable" style="margin-top: 0px;">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <? if (!empty($total_page)) : ?>
                    <? foreach ($total_page as $value => $self) : ?>
                        <li role="presentation" <?= ($value == 1) ? 'class="active"' : ''; ?>>
                            <a href="<?= '#' . $self['page_name'] ?>" aria-controls="<?= $self['page_name'] ?>" role="tab" data-toggle="tab" onclick="openStandardPage(<?= $self['page_name'] ?>,<?= $self['page_lang'] ?>)"><?= $this->lang->line($self['page_name']) ?></a>
                        </li>
                    <? endforeach; ?>
                <? endif; ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <? if (!empty($total_page)) : ?>
                    <? foreach ($total_page as $value => $self) : ?>
                        <div role="tabpanel" <?= ($value == 1) ? 'class="tab-pane active"' : 'class="tab-pane"'; ?> id="<?= $self['page_name'] ?>"></div>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
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

        <? if (!empty($total_page)) : ?>
            <? foreach ($total_page as $self) : ?>
                openStandardPage(<?= json_encode($self['page_name']) ?>, <?= json_encode($self['page_lang']) ?>);
            <? endforeach; ?>
        <? endif; ?>
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