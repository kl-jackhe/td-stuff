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
                                            <label for="product_category">分類</label>
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
                                            <label for="product_category">分類</label>
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
                                    <label for="distribute_at">上架日期</label>
                                    <input type="text" class="form-control datetimepicker" id="distribute_at" name="distribute_at" required>
                                </div>
                            </div>
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="discontinued_at">下架日期</label>
                                    <input type="datetime-local" class="form-control" id="discontinued_at" name="discontinued_at" required>
                                </div>
                            </div> -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_name">商品名稱</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                                    <input type="hidden" id="store_id" name="store_id" value="<?php echo $this->uri->segment(4) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_sku">品號</label>
                                    <input type="text" class="form-control" id="product_sku" name="product_sku" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_price">預設價格</label>
                                    <input type="text" class="form-control" id="product_price" name="product_price" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_image" class="control-label">封面圖片</label>
                                    <div class="form-group">
                                        <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                                    </div>
                                    <img src="" id="add_product_image_preview" class="img-responsive" style="display: none;">
                                    <input type="hidden" id="add_product_image" name="product_image" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_description">商品描述</label>
                                    <textarea class="form-control" id="product_description" name="product_description" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_note">注意事項</label>
                                    <textarea class="form-control" id="product_note" name="product_note" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>