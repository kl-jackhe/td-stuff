<script src="/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
<script src="/node_modules/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script>
<!-- <script src="/node_modules/chosen-js/chosen.jquery.min.js"></script> -->
<script src="/assets/chosen_v1.8.7/chosen.jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<!-- <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> -->
<script src="/assets/admin/js/dataTables.bootstrap.min.js"></script>
<script src="/assets/admin/js/flaty.js"></script>
<script src="/node_modules/jquery.cookie/jquery.cookie.js"></script>
<script src="/node_modules/moment/min/moment.min.js"></script>
<script src="/node_modules/moment/locale/zh-tw.js"></script>
<script src="/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-TW.min.js"></script>
<script src="/node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="/assets/admin/js/bootstrap-formhelpers.js"></script>
<script src="/node_modules/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>

<script>
$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("submit_form").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
    $("#submit_form").validate({});
    $("input[type='text']:first", document.forms[0]).focus();
    // $("input[type='text']").on("click", function () {
    // 	$(this).select();
    // });
    $("form input").keypress(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
    $('#submit_form input.form-control').keydown(function(e) {
        /*Enter*/
        if (e.keyCode == 13) {
            // focus next input elements
            $(':input:visible:enabled:eq(' + ($(':input:visible:enabled').index(this) + 1) + ')').focus();
            e.preventDefault();
        }
    });
    $(".form-inline.form-group.text-right #keywords").keypress(function(event) {
        if (event.keyCode == 13) {
            searchFilter();
        }
    });
    $(".form-inline.form-group.text-right #keywords2").keypress(function(event) {
        if (event.keyCode == 13) {
            searchFilter();
        }
    });
    $(".form-inline.form-group.text-right #keywords3").keypress(function(event) {
        if (event.keyCode == 13) {
            searchFilter();
        }
    });
    $("#submit_form input.form-control").on("keypress", function(event) {
        // console.log("submit_form keypress");
        var keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
            console.log("Stop Form Submit!");
            event.preventDefault();
            return false;
        }
    });
    $('#submit_form #quick-add').keydown(function(e) {
        /*Enter*/
        if (e.keyCode == 13) {
            quick_add_cart();
        }
    });
    $("#cart_details input").attr('autocomplete', 'off');
    $("#cart_details_of_cost input").attr('autocomplete', 'off');

    if (document.getElementById('general-message')) {
        // alert('exist');
        setTimeout("$('#general-message').fadeOut();", 1500);
    }
    if (document.getElementById('error-message')) {
        // alert('exist');
        setTimeout("$('#error-message').fadeOut();", 1500);
    }

    var check_form_change = 0;
    $("#submit_form input").on("input", function() {
        check_form_change++;
        console.log($(this).val());
    });

    $("#submit_form select").on("input", function() {
        check_form_change++;
        console.log($(this).val());
    });

    $("#submit_form textarea").on("input", function() {
        check_form_change++;
        console.log($(this).val());
    });

    $('#submit_form').on('submit', function() {
        check_form_change = 0;
    });

    $(window).on("beforeunload", function() {
        $('#loading').show();
        if (check_form_change > 0) {
            return check_form_change > 0 ? "您輸入的內容尚未儲存，確定離開此頁面嗎?" : null;
        }
    })
});
$('.fancybox').fancybox({
    'width': 1920,
    'height': 1080,
    'type': 'iframe',
    'autoScale': false
});

$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    clearBtn: true,
    todayBtn: true,
    todayHighlight: true,
    language: 'zh-TW'
});

$('.datepicker-ym').datepicker({
    format: "yyyy-mm",
    autoclose: true,
    clearBtn: true,
    viewMode: "months",
    minViewMode: "months",
    todayBtn: true,
    todayHighlight: true,
    language: 'zh-TW'
});

$('.datepicker-y').datepicker({
    format: "yyyy",
    autoclose: true,
    viewMode: "years",
    minViewMode: "years",
    clearBtn: true,
    todayHighlight: true,
    language: 'zh-TW'
});

$('.datepicker-m').datepicker({
    format: "mm",
    autoclose: true,
    viewMode: "months",
    minViewMode: "months",
    clearBtn: true,
    todayHighlight: true,
    language: 'zh-TW'
});

$('.datepicker_mu').datepicker({
    format: "yyyy-mm-dd",
    //autoclose: true,
    clearBtn: true,
    todayBtn: true,
    todayHighlight: true,
    weekStart: 0,
    multidate: true,
    language: 'zh-TW'
});

$('.datetimepicker-ymd').datetimepicker({
    locale: 'zh-TW',
    format: 'YYYY-MM-DD'
});

$('.datetimepicker').datetimepicker({
    locale: 'zh-TW',
    format: 'YYYY-MM-DD HH:mm:ss'
});

$('.timepicker').datetimepicker({
    locale: 'zh-TW',
    format: 'HH:mm:ss'
});

$('.modal-btn').on('click', function(e) {
    e.preventDefault();
    //$('#use-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
    $('#use-Modal .modal-body').html('');
    $('#use-Modal').modal('show').find('.modal-body').load(this.href);
});

function responsive_filemanager_callback(field_id) {
    if (field_id) {
        //console.log(field_id);
        var url = jQuery('#' + field_id).val();
        if (document.getElementById(field_id + '_preview')) {
            document.getElementById(field_id + '_preview').src = '/assets/uploads/' + url;
            $('#' + field_id + '_preview').show();
        }
        if (document.getElementById(field_id + '_name')) {
            document.getElementById(field_id + '_name').value = url;
        }
        if (document.getElementById(field_id + '_link')) {
            document.getElementById(field_id + '_link').href = '/assets/uploads/' + url;
        }
        if (document.getElementById(field_id + '_link')) {
            document.getElementById(field_id + '_link').innerHTML = url;
        }
    }
}

function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var keywords = $('#keywords').val();
    var other_keywords = $('#other_keywords').val();
    var sortBy = $('#sortBy').val();
    var category = $('#category').val();
    var category1 = $('#category1').val();
    var category2 = $('#category2').val();
    var status = $('#status').val();
    var county = $('#county').val();
    var district = $('#district').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var sales = $('#sales').val();
    var agent = $('#agent').val();
    var product = $('#product').val();
    $.ajax({
        type: 'GET',
        url: '/admin/<?php echo $this->uri->segment(2); ?>/ajaxData/' + page_num,
        data: 'page=' + page_num + '&keywords=' + keywords + '&other_keywords=' + other_keywords + '&sortBy=' + sortBy + '&category=' + category + '&category1=' + category1 + '&category2=' + category2 + '&status=' + status + '&county=' + county + '&district=' + district + '&start_date=' + start_date + '&end_date=' + end_date + '&sales=' + sales + '&agent=' + agent + '&product=' + product,
        beforeSend: function() {
            $('#loading').show();
        },
        success: function(html) {
            $('#datatable').html(html);
            $('#loading').fadeOut("fast");
        }
    });
}

function searchFilterSales(page_num) {
    page_num = page_num ? page_num : 0;
    var keywords = $('#keywords').val();
    var agent = $('#agent').val();
    var product = $('#product').val();
    var sortBy = $('#sortBy').val();
    var status = $('#status').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    $.ajax({
        type: 'GET',
        url: '/admin/<?php echo $this->uri->segment(2); ?>/pageAjaxData/' + page_num,
        data: 'page=' + page_num + '&keywords=' + keywords + '&agent=' + agent + '&product=' + product + '&sortBy=' + sortBy + '&status=' + status + '&start_date=' + start_date + '&end_date=' + end_date,
        beforeSend: function() {
            $('#loading').show();
        },
        success: function(html) {
            $('#datatable').html(html);
            $('#loading').fadeOut("fast");
        }
    });
}

(function update_time() {
    var now = moment().format('YYYY年MM月DD日 dddd HH點mm分ss秒');
    $('#NowTime').text(now);
    setTimeout(update_time, 1000);
})();

function start_chosen() {
    if (jQuery().chosen) {
        $(".chosen").chosen({
            no_results_text: "沒有找到。",
            search_contains: true,
            width: "100%",
        });
    }
}
</script>

<script src="/assets/admin/tinymce4.4.3/tinymce.min.js" type="text/javascript"></script>
<script>
	tinymce.init( {
    language: 'zh_TW',
    selector: 'textarea#product_description',
    plugins: [
          "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save",
          "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern code image imagetools imagetools responsivefilemanager"
      ],
    toolbar: 'insert undo redo | fontselect fontsizeselect | responsivefilemanager | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code removeformat',
    image_advtab: true,
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt 60pt 72pt 84pt 96pt",
    content_css: ['/assets/admin/bootstrap/dist/css/bootstrap.min.css'],
    font_formats: '微軟正黑體=微軟正黑體,Microsoft JhengHei;新細明體=PMingLiU,新細明體;標楷體=標楷體,DFKai-SB,BiauKai;黑體=黑體,SimHei,Heiti TC,Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=v erdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;',
    external_filemanager_path:"/assets/admin/filemanager/",
    filemanager_title:"媒體庫" ,
    external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"}
	});
</script>


<script>
    tinymce.init( {
    language: 'zh_TW',
    selector: 'textarea#product_note',
    plugins: [
          "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save",
          "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern code image imagetools imagetools responsivefilemanager"
      ],
    toolbar: 'insert undo redo | fontselect fontsizeselect | responsivefilemanager | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code removeformat',
    image_advtab: true,
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt 60pt 72pt 84pt 96pt",
    content_css: ['/assets/admin/bootstrap/dist/css/bootstrap.min.css'],
    font_formats: '微軟正黑體=微軟正黑體,Microsoft JhengHei;新細明體=PMingLiU,新細明體;標楷體=標楷體,DFKai-SB,BiauKai;黑體=黑體,SimHei,Heiti TC,Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=v erdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;',
    external_filemanager_path:"/assets/admin/filemanager/",
    filemanager_title:"媒體庫" ,
    external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"}
    });
</script>