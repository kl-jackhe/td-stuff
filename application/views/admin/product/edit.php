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
    <?php $attributes = array('class' => 'submit_form', 'id' => 'submit_form');?>
    <?php echo form_open('admin/product/update/' . $product['product_id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">修改</button>
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
                                    <?if (!empty($product_category)) {?>
                                    <label for="product_category">分類</label>
                                    <?php $att = 'id="product_category" class="form-control chosen" data-rule-required="true"';
                                        $data = array();
                                        foreach ($product_category as $c) {
                                            $data[$c['product_category_id']] = $c['product_category_name'];
                                        }
                                        echo form_dropdown('product_category', $data, $product['product_category_id'], $att);
                                    } else {
                                        echo '<label>沒有分類</label><input type="text" class="form-control" id="product_category" name="product_category" value="0" readonly>';
                                    }?>
                                  </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_name">商品名稱</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="product_price">預設價格</label>
                                    <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $product['product_price']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="product_add_on_price">加購價格</label>
                                    <input type="text" class="form-control" id="product_add_on_price" name="product_add_on_price" value="<?php echo $product['product_add_on_price']; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>單位</label>
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="add_unit();">新增</a>
                                </div>
                                <table class="table table-bordered" id="paramsFields">
                                    <tr class="info">
                                        <th class="text-center" style="width: 80%;">單位</th>
                                        <th class="text-center"></th>
                                    </tr>
                                    <tbody id="product-unit-list">
                                        <?if (!empty($product_unit)) {foreach ($product_unit as $row) {?>
                                        <tr>
                                            <td>
                                                <input type="hidden" class="form-control" name="id[]" value="<?php echo $row['id']; ?>">
                                                <input type="text" class="form-control unit" name="unit[]" value="<?php echo $row['unit']; ?>">
                                            </td>
                                            <td class="text-center"><i class="fa fa-trash-o x"></i></td>
                                        </tr>
                                        <?}}?>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>規格</label>
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="add_specification();">新增</a>
                                </div>
                                <table class="table table-bordered" id="paramsFields">
                                    <tr class="info">
                                        <th class="text-center">規格</th>
                                        <th class="text-center">圖片</th>
                                        <th class="text-center">狀態</th>
                                        <th class="text-center"></th>
                                    </tr>
                                    <tbody id="product-specification-list">
                                        <?php if (!empty($product_specification)) {foreach ($product_specification as $row) {?>
                                        <tr>
                                            <td>
                                                <input type="hidden" class="form-control" name="id[]" value="<?php echo $row['id']; ?>">
                                                <input type="text" class="form-control specification" name="specification[]" value="<?php echo $row['specification']; ?>">
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=picture<?php echo $row['id']; ?>&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                                                </div>
                                                <?php if (!empty($row['picture'])) {?>
                                                    <img src="/assets/uploads/<?php echo $row['picture']; ?>" id="picture<?php echo $row['id']; ?>_preview" class="img-responsive" style="<?php if (empty($row['picture'])) {echo 'display: none';}?>;max-width: 100px;width: 100%;">
                                                <?php } else {?>
                                                    <img src="" id="picture<?php echo $row['id']; ?>_preview" class="img-responsive">
                                                <?php }?>
                                                <input type="hidden" id="picture<?php echo $row['id']; ?>" name="picture[]" value="<?php echo $row['picture']; ?>" />
                                            </td>
                                            <td>
                                                <?php if (!empty($row['status'])) {?>
                                                <select name=status[] class="form-control">
                                                    <?if ($row['status'] == 0) { ?>
                                                        <option value="0" selected>販售中</option>
                                                        <option value="1">已售完</option>
                                                        <option value="2">預購</option>
                                                    <?}?>
                                                    <?if ($row['status'] == 1) { ?>
                                                        <option value="0">販售中</option>
                                                        <option value="1" selected>已售完</option>
                                                        <option value="2">預購</option> 
                                                    <?}?>
                                                    <?if ($row['status'] == 2) { ?>
                                                        <option value="0">販售中</option>
                                                        <option value="1">已售完</option>
                                                        <option value="2" selected>預購</option>
                                                    <?}?>
                                                </select>
                                                <?php } else {?>
                                                <select name=status[] class="form-control">
                                                    <option value="0" selected>販售中</option>
                                                    <option value="1">已售完</option>
                                                    <option value="2">預購</option>
                                                </select>
                                                <?php }?>
                                            </td>
                                            <td class="text-center"><i class="fa fa-trash-o x"></i></td>
                                        </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>方案</label>
                                    <a href="/admin/product/create_plan/<?php echo $product['product_id'] ?>" class="btn btn-primary modal-btn">新增</a>
                                </div>
                                <table class="table table-bordered" id="plan_paramsFields">
                                    <tr class="info">
                                        <th style="width: 20%;">名稱</th>
                                        <th style="width: 20%;">原價</th>
                                        <th style="width: 20%;">方案價</th>
                                        <th style="width: 20%;">描述</th>
                                        <th style="width: 20%;">圖片</th>
                                        <th style="width: 20%;">操作</th>
                                    </tr>
                                    <?php if (!empty($product_combine)) {foreach ($product_combine as $row) {?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo $row['current_price']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td>
                                                <?php if (!empty($row['picture'])) {?>
                                                    <img src="/assets/uploads/<?php echo $row['picture']; ?>"  class="img-responsive">
                                                <?php }?>
                                            </td>
                                            <td>
                                                <a href="/admin/product/edit_plan/<?php echo $row['id'] ?>" class="btn btn-primary modal-btn">編輯</a>
                                                <a href="/admin/product/delete_plan/<?php echo $row['id'] ?>" class="btn btn-danger" onClick="return confirm('您確定要刪除嗎?')">刪除</a>
                                            </td>
                                        </tr>
                                    <?php }}?>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_description">商品描述</label>
                                    <textarea class="form-control" id="product_description" name="product_description" cols="30" rows="10"><?php echo $product['product_description']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="plan">
                        <div class="row">
                            <div class="col-md-12">

                            </div>
                        </div>
                    </div>
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
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(document).on('click', '.x', function(){
        $(this).parent().parent().remove();
    });
});
function add_unit()
{
  $("#product-unit-list").append('<tr><td><input type="text" name="unit[]" class="form-control unit"/></td><td class="text-center"><i class="fa fa-trash-o x"></i></td></tr>');
}
function add_specification()
{
  $("#product-specification-list").append('<tr><td><input type="text" name="specification[]" class="form-control specification"/></td><td class="text-center"><i class="fa fa-trash-o x"></i></td></tr>');
}
</script>