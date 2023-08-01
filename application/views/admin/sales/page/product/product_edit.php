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
                                        <?php if (!empty($product_specification)) {?>
                                        <th class="text-center">圖片</th>
                                        <th class="text-center">狀態</th>
                                        <th class="text-center">限購數量</th>
                                        <?php }?>
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
                                            <td>
                                                <select class="form-control" name="limit_enable[]">
                                                    <?if (!empty($row['limit_enable'])) {?>
                                                        <option value="YES" selected>啟用</option>
                                                        <option value="">停用</option>
                                                    <?} else {?>
                                                        <option value="YES">啟用</option>
                                                        <option value="" selected>停用</option>
                                                    <?}?>
                                                </select>
                                                <?if ($row['limit_qty'] > 0) {?>
                                                    <input type="number" name="limit_qty[]" class="form-control" placeholder="請輸入限購數量" value="<?=$row['limit_qty']?>">
                                                <?} else {?>
                                                    <input type="number" name="limit_qty[]" class="form-control" placeholder="請輸入限購數量">
                                                <?}?>
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
            <a href="/admin/sales/create_plan/<?php echo $product['product_id'] ?>" class="btn btn-primary modal-btn">新增</a>
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
                        <a href="/admin/sales/edit_plan/<?php echo $row['id'] ?>" class="btn btn-primary modal-btn">編輯</a>
                        <a href="/admin/sales/delete_plan/<?php echo $row['id'] ?>" class="btn btn-danger" onClick="return confirm('您確定要刪除嗎?')">刪除</a>
                    </td>
                </tr>
            <?php }}?>
        </table>
    </div>
</div>
<script>
function add_unit()
{
  $("#product-unit-list").append('<tr><td><input type="text" name="unit[]" class="form-control unit"/></td><td class="text-center"><i class="fa fa-trash-o x"></i></td></tr>');
}
function add_specification()
{
  $("#product-specification-list").append('<tr><td><input type="text" name="specification[]" class="form-control specification"/></td><td class="text-center"><i class="fa fa-trash-o x"></i></td></tr>');
}
</script>