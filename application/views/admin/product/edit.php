<style>
.add-to-links {
    display: none;
}
.featured-products-grid .item {
    padding-bottom: 30px;
    padding-top: 30px i !important;
}
.featured-products-grid .item .product-info {
    min-height: 200px;
    position: relative;
}
.featured-products-grid .item .product-info .price-box{
    position: absolute;
    bottom: 40px;
}
.featured-products-grid .item .product-info .actions{
    position: absolute;
    bottom: 0px;
}
</style>

<div class="row">
    <?php $attributes = array('class' => 'product', 'id' => 'product');?>
    <?php echo form_open('admin/product/update/' . $product['product_id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">修改</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_name">商品名稱 *</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_price">預設價格 *</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $product['product_price']; ?>" required>
                </div>
            </div>
            <div class="col-md-12">
                <table id="paramsFields" class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">單位</th>
                            <th scope="col">價格</th>
                            <th scope="col">數量</th>
                            <th scope="col">圖片</th>
                            <th scope="col">描述</th>
                            <th scope="col">規格</th>
                            <th scope="col"><a href="javascript:void(0);" class="addCF btn btn-primary">新增</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?if (!empty($product_specification)) {foreach ($product_specification as $row) {?>
                        <tr>
                            <td><input type="text" name="unit[]" value="<?=$row['unit'];?>" /></td>
                            <td><input type="number" name="price[]" value="<?=$row['price'];?>" /></td>
                            <td><input type="number" name="quantity[]" value="<?=$row['quantity'];?>" /></td>
                            <td><input type="text" name="picture[]" value="<?=$row['picture'];?>" /></td>
                            <td><input type="text" name="description[]" value="<?=$row['description'];?>" /></td>
                            <td><input type="text" name="specification[]" value="<?=$row['specification'];?>" /></td>
                            <input type="hidden" name="id[]" value="<?=$row['id'];?>" />
                            <td><a href="javascript:void(0);" class="remCF btn btn-danger">移除</a></td>
                        </tr>
                        <?}}?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <table id="plan_paramsFields" class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">名稱</th>
                            <th scope="col">單位</th>
                            <th scope="col">價格</th>
                            <th scope="col">數量</th>
                            <th scope="col"><a href="javascript:void(0);" class="PlanAddCF btn btn-primary">新增</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?if (!empty($product_combine)) {foreach ($product_combine as $row) {?>
                        <tr>
                            <td><input type="text" name="plan_name[]" value="<?=$row['name'];?>" /></td>
                            <td><input type="text" name="plan_unit[]" value="<?=$row['unit'];?>" /></td>
                            <td><input type="number" name="plan_price[]" value="<?=$row['price'];?>" /></td>
                            <td><input type="number" name="plan_quantity[]" value="<?=$row['quantity'];?>" /></td>
                            <input type="hidden" name="plan_id[]" value="<?=$row['id'];?>" />
                            <td><a href="javascript:void(0);" class="PlanRemCF btn btn-danger">移除</a></td>
                        </tr>
                        <?}}?>
                    </tbody>
                </table>
            </div>
            <!-- <div class="col-md-6">
          <div class="form-group">
            <label for="product_daily_stock">每日庫存</label>
            <input type="text" class="form-control" id="product_daily_stock" name="product_daily_stock" value="<?php echo $product['product_daily_stock']; ?>">
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="product_person_buy">限購份數</label>
            <input type="text" class="form-control" id="product_person_buy" name="product_person_buy" value="<?php echo $product['product_person_buy']; ?>">
          </div>
      </div> -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_description">描述 *</label>
                    <textarea id="product_description" name="product_description" class="form-control">
              <?php echo $product['product_description']; ?>
          </textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_image" class="control-label">封面圖片</label>
                    <div class="form-group">
                        <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=product_image<?php echo $product['product_id']; ?>&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                    </div>
                    <?php if (!empty($product['product_image'])) {?>
                    <img src="/assets/uploads/<?php echo $product['product_image']; ?>" id="product_image<?php echo $product['product_id']; ?>_preview" class="img-responsive" style="<?php if (empty($product['product_image'])) {echo 'display: none';}?>">
                    <?php } else {?>
                    <img src="" id="product_image<?php echo $product['product_id']; ?>_preview" class="img-responsive">
                    <?php }?>
                    <input type="hidden" id="product_image<?php echo $product['product_id']; ?>" name="product_image" value="<?php echo $product['product_image']; ?>" />
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div style="border: 1px solid #ccc; padding: 10px; max-height: 200px; overflow-y: auto;">
            <table class="table table-bordered table-striped table-condensed">
                <tr class="info">
                    <th width="25%">
                        欄位
                    </th>
                    <th width="25%">
                        值
                    </th>
                    <th width="25%">
                        更新者
                    </th>
                    <th width="25%">
                        更新時間
                    </th>
                </tr>
                <?php if (!empty($change_log)) {foreach ($change_log as $cl) {?>
                <tr>
                    <td>
                        <?php echo $this->lang->line($cl['change_log_key']); ?>
                    </td>
                    <td>
                        <?php echo $cl['change_log_value'] ?>
                    </td>
                    <td>
                        <?php echo get_user_full_name($cl['change_log_creator_id']) ?>
                    </td>
                    <td>
                        <?php echo $cl['change_log_created_at'] ?>
                    </td>
                </tr>
                <?php }}?>
            </table>
        </div>
    </div>
</div>
<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
$.validator.setDefaults({
    submitHandler: function() {
        document.getElementById("product").submit();
        //alert("submitted!");
    }
});
$(document).ready(function() {
    $("#product").validate({});
});
$('.fancybox').fancybox({
    'width': 1920,
    'height': 1080,
    'type': 'iframe',
    'autoScale': false
});

function responsive_filemanager_callback(field_id) {
    if (field_id) {
        //console.log(field_id);
        var url = jQuery('#' + field_id).val();
        document.getElementById(field_id + '_preview').src = '<?php echo base_url(); ?>assets/uploads/' + url;
        $('#' + field_id + '_preview').show();
    }
}
</script>
<script>
$(document).ready(function() {
    $(".addCF").click(function() {
        $("#paramsFields").append('<tr><td><input type="text" name="unit[]" value="" /></td><td><input type="number" name="price[]" value="" /></td><td><input type="number" name="quantity[]" value="" /></td><td><input type="text" name="picture[]" value="" /></td><td><input type="text" name="description[]" value="" /></td><td><input type="text" name="specification[]" value="" /></td><input type="hidden" name="id[]" value="0" /><td><a href="javascript:void(0);" class="remCF btn btn-danger">移除</a></td></tr>');
    });
    $("#paramsFields").on('click', '.remCF', function() {
        $(this).parent().parent().remove();
    });
});
</script>
<script>
$(document).ready(function() {
    $(".PlanAddCF").click(function() {
        $("#plan_paramsFields").append('<tr><td><input type="text" name="plan_name[]" value="" /></td><td><input type="text" name="plan_unit[]" value="" /></td><td><input type="number" name="plan_price[]" value="" /></td><td><input type="number" name="plan_quantity[]" value="" /></td><input type="hidden" name="plan_id[]" value="0" /><td><a href="javascript:void(0);" class="PlanRemCF btn btn-danger">移除</a></td></tr>');
    });
    $("#plan_paramsFields").on('click', '.PlanRemCF', function() {
        $(this).parent().parent().remove();
    });
});
</script>