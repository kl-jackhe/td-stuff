<style>
    label.required::before {
        content: '* ';
        color: red;
    }

    label.free::before {
        content: '* ';
        color: blue;
    }
</style>
<div class="row">
    <?php $attributes = array('class' => 'submit_form', 'id' => 'submit_form'); ?>
    <?php echo form_open('admin/product/insert', $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">建立</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="tabbable">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#general" aria-controls="general" role="tab" data-toggle="tab">基本資料</a>
                    </li>
                    <!-- <li role="presentation">
                        <a href="#plan" aria-controls="plan" role="tab" data-toggle="tab">方案</a>
                    </li> -->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php if ($this->is_partnertoys) : ?>
                                        <? if (!empty($product_category)) { ?>
                                            <label class="required" for="product_category">分類</label>
                                            <select class="form-control" id="product_category" name="product_category">
                                                <? foreach ($product_category as $pc_row) { ?>
                                                    <option value="<?= $pc_row['sort'] ?>"><?= $pc_row['name'] ?></option>
                                                <? } ?>
                                            </select>
                                        <? } else {
                                            echo '<label for="product_category">沒有分類</label><input type="text" class="form-control" id="product_category" name="product_category" value="" readonly>';
                                        } ?>

                                    <?php else : ?>
                                        <? if (!empty($product_category)) { ?>
                                            <label class="required" for="product_category">分類</label>
                                            <select class="form-control chosen" id="product_category[]" name="product_category[]" multiple>
                                                <? foreach ($product_category as $pc_row) { ?>
                                                    <option value="<?= $pc_row['product_category_id'] ?>"><?= $pc_row['product_category_name'] ?></option>
                                                <? } ?>
                                            </select>
                                        <? } else {
                                            echo '<label for="product_category">沒有分類</label><input type="text" class="form-control" id="product_category" name="product_category" value="" readonly>';
                                        } ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required" for="distribute_at">上架日期</label>
                                    <input type="text" class="form-control datetimepicker" id="distribute_at" name="distribute_at" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="free" for="discontinued_at">下架日期</label>
                                    <input type="text" class="form-control datetimepicker" id="discontinued_at" name="discontinued_at">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required" for="product_name">商品名稱</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                                    <input type="hidden" id="store_id" name="store_id" value="<?php echo $this->uri->segment(4) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required" for="product_sku">品號</label>
                                    <input type="text" class="form-control" id="product_sku" name="product_sku" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required" for="product_price">預設價格</label>
                                    <input type="text" class="form-control" id="product_price" name="product_price" required>
                                </div>
                            </div>
                            <? if ($this->is_partnertoys || $this->is_liqun_food) : ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="free" for="safe_inventory">安全庫存量</label>
                                        <input type="text" class="form-control" id="safe_inventory" name="safe_inventory" required>
                                    </div>
                                </div>
                            <? endif; ?>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_image" class="control-label">封面圖片</label>
                                    <div class="form-group">
                                        <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_image&relative_url=1" class="btn btn-primary fancybox" type="button">選擇圖片</a>
                                    </div>
                                    <img src="" id="add_product_image_preview" class="img-responsive" style="display: none;">
                                    <input type="hidden" id="add_product_image" name="product_image" />
                                </div>
                            </div>
                        </div>
                        <?php if ($this->is_partnertoys) : ?>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="product_picture" class="control-label">商品展示圖(可複選)</label>
                                        <div class="form-group">
                                            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_picture&relative_url=1" id="graphGroup" class="btn btn-primary fancybox" type="button">選擇圖片</a>
                                            <button type="button" class="btn" onclick="checkSelectedImages()">檢查圖片</button>
                                            <button type="button" class="btn" onclick="hiddenSelectedimages()">隱藏圖片</button>
                                        </div>
                                        <div id="selected_images" class="row"></div>
                                        <br>
                                        <div id="selected_name"></div>
                                        <input type="hidden" id="add_product_picture" name="product_picture" />
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="free" for="product_description">商品描述</label>
                                    <textarea class="form-control" id="product_description" name="product_description" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="free" for="product_note">注意事項</label>
                                    <textarea class="form-control" id="product_note" name="product_note" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <? if ($this->is_partnertoys) : ?>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="free" for="seo_title">seo設定</label>
                                        <div class="panel panel-default">
                                            <div class="panel-body M_panel-body_bg">
                                                <input type="text" name="seo_title" class="form-control" id="seo_title" placeholder="請輸入TITLE(標題)">
                                                <textarea name="seo_keyword" class="form-control" id="seo_keyword" rows="3" placeholder="請輸入KEYWORD(關鍵字)，每組關鍵字請用『半形逗號： , 』 隔開" style="resize:none;"></textarea>
                                                <textarea name="seo_description" class="form-control" id="seo_description" rows="5" placeholder="請輸入DESCRIPTION(網站簡述)" style="resize:none;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-12">
                                    <label class="free" for="product_combine">方案建立</label>
                                </div>
                            </div>
                            <? for ($i = 0; $i < 2; $i++) : ?>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="product_combine_name_<?= $i ?>">方案名稱</label>
                                            <input type="text" class="form-control" id="product_combine_name_<?= $i ?>" name="product_combine_name_<?= $i ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="product_combine_cargo_id_<?= $i ?>">貨號</label>
                                            <input type="text" class="form-control" id="product_combine_cargo_id_<?= $i ?>" name="product_combine_cargo_id_<?= $i ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="product_combine_price_<?= $i ?>">售價</label>
                                            <input type="text" class="form-control" id="product_combine_price_<?= $i ?>" name="product_combine_price_<?= $i ?>" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="product_combine_quantity_<?= $i ?>">庫存量</label>
                                            <input type="text" class="form-control" id="product_combine_quantity_<?= $i ?>" name="product_combine_quantity_<?= $i ?>" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="limit_enable_<?= $i ?>">限購狀態</label>
                                        <select class="form-control" name="limit_enable_<?= $i ?>">
                                            <option value="YES">啟用</option>
                                            <option value="" selected>停用</option>
                                        </select>
                                        <input type="number" min="1" name="limit_qty_<?= $i ?>" class="form-control" placeholder="請輸入限購數量">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="product_combine_image_<?= $i ?>" class="control-label">商品圖片</label>
                                            <div class="form-group">
                                                <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_combine_image_<?= $i ?>&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                                            </div>
                                            <input type="hidden" id="add_product_combine_image_<?= $i ?>" name="product_combine_image_<?= $i ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <img src="" id="add_product_combine_image_<?= $i ?>_preview" class="img-responsive" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            <? endfor; ?>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>

<!-- 檢查圖片上傳 -->
<script>
    // 更新选定的图片
    function checkSelectedImages() {
        // 解析隐藏域的值
        var images = $('#add_product_picture').val()

        // 清空现有图片和文件名
        $('#selected_images').empty();
        $('#selected_name').empty();
        $('#selected_images').append('<span class="col-md-12">已選圖片：</span><br><br>');
        $('#selected_name').append('<span>已選圖片（路徑檔名）：</span>');

        // 检查 images 是否为空或者不是有效的 JSON 字符串
        if (images) {
            if (isValidJSON(images)) {
                var imagesArray = JSON.parse(images);

                // 如果 imagesArray 是数组，则添加新图片
                if (Array.isArray(imagesArray) && imagesArray.length > 0) {
                    $.each(imagesArray, function(index, image) {
                        $('#selected_images').append('<img src="/assets/uploads/' + image + '" class="img-responsive col-md-1" />');
                        $('#selected_name').append('<span>' + image + '</span>&emsp;');
                    });
                }
            } else {
                $('#selected_images').append('<img src="/assets/uploads/' + images + '" class="img-responsive col-md-1" />');
                $('#selected_name').append('<span>' + images + '</span>&emsp;');
            }
        } else {
            // 清空现有
            $('#selected_images').empty();
            $('#selected_name').empty();
        }
    }

    function hiddenSelectedimages() {
        // 清空现有
        $('#selected_images').empty();
        $('#selected_name').empty();
    }

    // 检查字符串是否是有效的 JSON 格式
    function isValidJSON(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }
</script>