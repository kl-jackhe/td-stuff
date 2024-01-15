<style>
.product_tag_edit_style {
    cursor: pointer;
    text-decoration: underline;
    color: #66B3FF;
}
.product_tag_edit_style:hover {
    color: #003060;
}
.chosen-container .chosen-choices li.search-choice {
    font-size: 16px !important;
}
.chosen-container .chosen-results li {
    font-size: 16px !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <span class="btn btn-primary" data-toggle="modal" data-target="#createProductTag"><?=$this->lang->line('create_product_tag')?></span>
        <div class="form-inline text-right">
            <select id="status" class="form-control" onchange="searchFilter()">
                <option value="1" selected><?php echo $this->lang->line('on_the_shelf_now'); ?></option>
                <option value="0"><?php echo $this->lang->line('off_the_shelf_now'); ?></option>
            </select>
            <span onclick="searchFilter()">
                <div class="btn btn-default" onclick="sort_icon_change()">
                    <i class="fa fa-sort-numeric-asc sortBy"></i>
                    <input type="hidden" value="asc" id="sortBy">
                </div>
            </span>
        </div>
    </div>
</div>
<div class="table-responsive" id="datatable">
    <?php // require 'ajax-data.php';?>
</div>
<div class="modal" id="createProductTag" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4><?=$this->lang->line('create_product_tag')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?if (!empty($language_list)) {
                            foreach ($language_list as $value) {?>
                                <input type="hidden" name="lang_list[]" value="<?=$value?>">
                                <div class="input-group" style="padding-bottom: 15px;">
                                    <span class="input-group-addon"><?=$this->lang->line($value) . ' ' . $this->lang->line('name')?></span>
                                    <input type="text" id="product_tag_name_<?=$value?>" class="form-control">
                                    <input type="hidden" id="product_tag_lang_<?=$value?>" value="<?=$value?>">
                                </div>
                            <?}
                        }?>
                        <div class="input-group">
                            <span class="input-group-addon"><?=$this->lang->line('sort')?></span>
                            <input type="number" id="product_tag_sort" class="form-control" value="50">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="createProductTag()"><?=$this->lang->line('save');?></button>
                <button class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('close_btn')?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="updateProductTag" data-keyboard="true" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4><?=$this->lang->line('update_product_tag')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?if (!empty($language_list)) {
                            foreach ($language_list as $value) {?>
                                <input type="hidden" name="updateProductTagLangList[]" value="<?=$value?>">
                                <div class="input-group" style="padding-bottom: 15px;">
                                    <span class="input-group-addon"><?=$this->lang->line($value) . ' ' . $this->lang->line('name')?></span>
                                    <input type="text" id="updateProductTagName<?=$value?>" class="form-control" value="">
                                    <input type="hidden" id="updateProductTagLang<?=$value?>" value="<?=$value?>">
                                </div>
                                <input type="hidden" id="updateProductTagLangID<?=$value?>" value="0">
                            <?}
                        }?>
                        <input type="hidden" id="updateProductTagID" value="0">
                        <div class="input-group">
                            <span class="input-group-addon"><?=$this->lang->line('sort')?></span>
                            <input type="number" id="updateProductTagSort" class="form-control" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="updateProductTag()"><?=$this->lang->line('update');?></button>
                <button class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('close_btn')?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="updateProductTagContent" data-keyboard="true" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4><?=$this->lang->line('edit') . $this->lang->line('product') . $this->lang->line('list');?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <p>新增商品分類所有商品</p>
                        <select class="form-control chosen" multiple id="product_category_list">
                            <? foreach ($product_category as $pc_row) {?>
                            <option value="<?=$pc_row['product_category_id']?>"><?php echo get_lang('product_category_name', $pc_row['product_category_id'], $this->language) ?></option>
                            <?}?>
                        </select> -->
                        <select class="form-control" multiple id="updateProductList"></select>
                        <input type="hidden" id="updateProductTagContentID" value="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="updateProductTagContent()"><?=$this->lang->line('update');?></button>
                <button class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('close_btn')?></button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    searchFilter();
});
function createProductTag() {
    var lang_list = $("input[name='lang_list[]']").map(function() {
        return $(this).val();
    }).get();
    var lang_name_array = {};
    var name_array = {};
    for (i=0;i<lang_list.length;i++) {
        if ($('#product_tag_name_' + lang_list[i]).val() != '') {
            lang_name_array[i] = {
                lang: $('#product_tag_lang_' + lang_list[i]).val(),
                name: $('#product_tag_name_' + lang_list[i]).val()
            }
            name_array[i] = $('#product_tag_name_' + lang_list[i]).val();
        }
        if (i==0) {
            if ($('#product_tag_name_' + lang_list[i]).val() == '') {
                alert('<?=$this->lang->line('Please_enter_a_valid_name')?>');
                return;
            }
        }
    }
    $.ajax({
        url: '/product_tag/createProductTag',
        type: 'POST',
        data: {
            lang_name_array: lang_name_array,
            name_array: name_array,
            sort: $('#product_tag_sort').val()
        },
        success: function(data) {
            if (data == 'yes') {

                for (i=0;i<lang_list.length;i++) {
                    if ($('#product_tag_name_' + lang_list[i]).val() != '') {
                        lang_name_array[i] = {
                            name: $('#product_tag_name_' + lang_list[i]).val('')
                        }
                    }
                }
                $('#createProductTag').modal('hide');
                searchFilter();
            } else {
                alert('<?=$this->lang->line('duplicate_name')?>');
            }
        }
    });
}
function updateProductTagModal(id,sort) {
    var lang_list = $("input[name='updateProductTagLangList[]']").map(function() {
        return $(this).val();
    }).get();
    for (i=0;i<lang_list.length;i++) {
        $('#updateProductTagLangID'+ lang_list[i]).val(0);
        $('#updateProductTagName' + lang_list[i]).val('');
    }
    $('#updateProductTagID').val(0);
    $('#updateProductTagSort').val('');
    $.ajax({
        url: '/product_tag/getProductTagLangDetail/' + id,
        type: 'POST',
        dataType: 'JSON',
        data: {},
        success: function(data) {
            for (i=0;i<data.length;i++) {
                $('#updateProductTagLangID' + data[i]['lang']).val(data[i]['id']);
                $('#updateProductTagName' + data[i]['lang']).val(data[i]['name']);
            }
            $('#updateProductTagID').val(id);
            $('#updateProductTagSort').val(sort);
            $('#updateProductTag').modal('show');
        }
    });
}
function updateProductTag() {
    var lang_list = $("input[name='updateProductTagLangList[]']").map(function() {
        return $(this).val();
    }).get();
    var lang_name_array = {};
    for (i=0;i<lang_list.length;i++) {
        if ($('#updateProductTagName' + lang_list[i]).val() != '') {
            lang_name_array[i] = {
                lang_id: $('#updateProductTagLangID' + lang_list[i]).val(),
                lang: $('#updateProductTagLang' + lang_list[i]).val(),
                name: $('#updateProductTagName' + lang_list[i]).val()
            }
        }
        if (i==0) {
            if ($('#updateProductTagName' + lang_list[i]).val() == '') {
                alert('<?=$this->lang->line('Please_enter_a_valid_name')?>');
                return;
            }
        }
    }
    $.ajax({
        url: '/product_tag/updateProductTag',
        type: 'POST',
        data: {
            id: $('#updateProductTagID').val(),
            lang_name_array: lang_name_array,
            sort: $('#updateProductTagSort').val()
        },
        success: function(data) {
            if (data == '') {
                $('#updateProductTag').modal('hide');
                searchFilter();
            } else {
                alert(data);
            }
        }
    });
}
function updateProductTagContentModal(id) {
    $.ajax({
        url: '/product_tag/getProductList/' + id,
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function () {
            $('#loading').show();
        },
        success: function(data) {
            $("#updateProductList").html('');
            $.each(data, function(index, item) {
                var option = $('<option>', {
                    value: item.product_id,
                    text: item.product_name
                });
                if (item.selected === '1') {
                    option.attr('selected', 'selected');
                }
                $('#updateProductList').append(option);
            });
            $('#updateProductList').chosen({
                no_results_text: "沒有找到。",
                search_contains: true,
                width:"100%"
            });
            $("#updateProductList").trigger("chosen:updated");
            $('#updateProductTagContentID').val(id);
            $('#loading').hide();
            $('#updateProductTagContent').modal('show');
        }
    });
}
function updateProductTagContent() {
    $.ajax({
        url: '/product_tag/updateProductTagContent',
        type: 'POST',
        data: {
            id: $('#updateProductTagContentID').val(),
            product_list: $('#updateProductList').val()
        },
        success: function(data) {
            $('#updateProductTagContent').modal('hide');
            searchFilter();
        }
    });
}
function updateProductTagStatus(id,status) {
    if (confirm('<?php echo $this->lang->line('confirm') . $this->lang->line('update') . '？ '?>')) {
        $.ajax({
            url: '/product_tag/updateProductTagStatus',
            type: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function(data) {
                alert('<?=$this->lang->line('update_success')?>');
                searchFilter();
            }
        });
    }
}
function sort_icon_change() {
    var sortBy = $('#sortBy').val();
    if (sortBy == 'asc') {
        $('#sortBy').val('desc');
        $('.sortBy').removeClass('fa-sort-numeric-asc').addClass('fa-sort-numeric-desc');
    } else {
        $('#sortBy').val('asc');
        $('.sortBy').removeClass('fa-sort-numeric-desc').addClass('fa-sort-numeric-asc');
    }
}
function removeSingleProductTag(id) {
    if (confirm('<?php echo $this->lang->line('remove_confirm') . '？ '?>')) {
        $.ajax({
            url: '/product_tag/removeSingleProductTag',
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                searchFilter();
            }
        });
    }
}
</script>