<div class="row">
    <?php $attributes = array('class' => 'submit_form', 'id' => 'submit_form');?>
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product_name">商品名稱</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                                    <input type="hidden" id="store_id" name="store_id" value="<?php echo $this->uri->segment(4) ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product_price">預設價格</label>
                                    <input type="text" class="form-control" id="product_price" name="product_price" required>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>

<script>
$(document).ready(function() {
    $(".addCF").click(function() {
        $("#paramsFields").append('<tr><td><input type="text" class="code" name="unit[]" value="" /></td><td><input type="number" class="code" name="price[]" value="" /></td><td><input type="number" class="code" name="quantity[]" value="" /></td><td><input type="text" class="code" name="picture[]" value="" /></td><td><input type="text" class="code" name="description[]" value="" /></td><td><input type="text" class="code" name="specification[]" value="" /></td><td><a href="javascript:void(0);" class="remCF btn btn-danger">移除</a></td></tr>');
    });
    $("#paramsFields").on('click', '.remCF', function() {
        $(this).parent().parent().remove();
    });
});
</script>