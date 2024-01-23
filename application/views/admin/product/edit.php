<style>
    label {
        font-weight: bold;
        font-size: 16px;
    }

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

    .featured-products-grid .item .product-info .price-box {
        position: absolute;
        bottom: 40px;
    }

    .featured-products-grid .item .product-info .actions {
        position: absolute;
        bottom: 0px;
    }
</style>
<div class="row">
    <?php $attributes = array('class' => 'submit_form', 'id' => 'submit_form'); ?>
    <?php echo form_open('admin/product/update/' . $product['product_id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info btn-sm hidden-print" style="margin-right: 10px;">返回上一頁</a>
            <a href="/admin/product/delete/<?php echo $product['product_id'] ?>" class="btn btn-danger btn-sm" style="float: right;" onClick="return confirm('您確定要刪除嗎?')">刪除商品</a>
            <a href="/admin/product/update_product_status/<?php echo $product['product_id'] ?>" class="btn btn-<?= ($product['product_status'] == 1 ? 'success' : 'danger') ?> btn-sm" style="float: right;margin-right: 15px;" onClick="return confirm('確定要<?= ($product['product_status'] == 1 ? '下' : '上') ?>架嗎?')"></i>
                <span><?= ($product['product_status'] == 1 ? '上架中' : '已下架') ?></span></a>
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
                    <li role="presentation">
                        <a href="#product_description" aria-controls="product_description" role="tab" data-toggle="tab">商品描述</a>
                    </li>
                    <li role="presentation">
                        <a href="#product_note" aria-controls="product_note" role="tab" data-toggle="tab">注意事項</a>
                    </li>
                    <!-- <li role="presentation">
                        <a href="#plan" aria-controls="plan" role="tab" data-toggle="tab">方案</a>
                    </li> -->
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                                <? if ($this->is_td_stuff || $this->is_liqun_food) { ?>
                                    <span class="btn btn-success btn-sm" onclick="createSingleSales(<?= $product['product_id'] ?>)">建立銷售頁面</span>
                                <? } ?>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_sku">品號</label>
                                            <input type="text" class="form-control" id="product_sku" name="product_sku" value="<?php echo $product['product_sku']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_name">商品名稱</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                                        </div>
                                    </div>
                                    <?php if ($this->is_partnertoys) : ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <? if (!empty($product_category)) { ?>
                                                    <label for="product_category">分類</label>
                                                    <select class="form-control" id="product_category" name="product_category">
                                                        <? foreach ($product_category as $pc_row) { ?>
                                                            <option value="<?= $pc_row['product_category_id'] ?>" <?= ($product['product_category_id'] == $pc_row['product_category_id']) ? 'selected' : ''; ?>><?= $pc_row['product_category_name'] ?></option>
                                                        <? } ?>
                                                    </select>
                                                <? } else {
                                                    echo '<label for="product_category">沒有分類</label><input type="text" class="form-control" id="product_category" name="product_category" value="" readonly>';
                                                } ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <? if (!empty($product_category)) { ?>
                                                    <label for="product_category">分類</label>
                                                    <select class="form-control chosen" id="product_category[]" name="product_category[]" multiple>
                                                        <? foreach ($product_category as $pc_row) { ?>
                                                            <option value="<?= $pc_row['product_category_id'] ?>" <?= (!empty($select_product_category) && in_array($pc_row['product_category_id'], $select_product_category) ? 'selected' : '') ?>><?= $pc_row['product_category_name'] ?></option>
                                                        <? } ?>
                                                    </select>
                                                <? } else {
                                                    echo '<label for="product_category">沒有分類</label><input type="text" class="form-control" id="product_category" name="product_category" value="" readonly>';
                                                } ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_price">預設價格</label>
                                            <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $product['product_price']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="display: none;">
                                        <div class="form-group">
                                            <label for="product_add_on_price">加購價格</label>
                                            <input type="text" class="form-control" id="product_add_on_price" name="product_add_on_price" value="<?php echo $product['product_add_on_price']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="distribute_at">上架日期</label>
                                            <input type="text" class="form-control datetimepicker" id="distribute_at" name="distribute_at" value="<?php echo $product['distribute_at']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="discontinued_at">下架日期</label>
                                            <input type="text" class="form-control datetimepicker" id="discontinued_at" name="discontinued_at" value="<?php echo $product['discontinued_at']; ?>">
                                        </div>
                                    </div>
                                    <?php if (!empty($product_tag)) : ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="product_tag">標籤</label>
                                                <select class="form-control chosen" id="product_tag[]" name="product_tag[]" multiple>
                                                    <?php foreach ($product_tag as $self) : ?>
                                                        <?php if ($self['status'] == 1) : ?>
                                                            <option value="<?= $self['id'] ?>" <?= (!empty($selected_product_tag) && in_array($self['id'], $selected_product_tag) ? 'selected' : '') ?>><?= $self['name'] ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($this->is_partnertoys && $product['product_category_id'] == 1) : ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="booking_date">預購年月</label>

                                                <input type="text" class="form-control datetimepicker-ym" id="booking_date" name="booking_date" value="<?= $product['booking_date'] ?>" required>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <? if (!empty($delivery)) { ?>
                                        <div class="col-md-12">
                                            <label for="delivery">指定配送方式</label>
                                            <select name="delivery[]" id="delivery" class="form-control chosen" multiple>
                                                <? foreach ($delivery as $d_row) {
                                                    $is_use = '';
                                                    if (!empty($use_delivery_list)) {
                                                        foreach ($use_delivery_list as $udl_row) {
                                                            if ($udl_row['delivery_id'] == $d_row['id']) {
                                                                $is_use = 'selected';
                                                                break;
                                                            }
                                                        }
                                                    } ?>
                                                    <option value="<?= $d_row['id'] ?>" <?= ($is_use != '' ? $is_use : '') ?>><?= $d_row['delivery_name'] ?></option>
                                                <? } ?>
                                            </select>
                                            <p style="color: red;font-size: 12px;">※無設定則任何配送方式都可使用！<br>※有設定則會依照設定值為主要配送方式！<br>※配送方式優先順序『全域 < 分類 < 商品 < 方案』</p>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="excluding_inventory">是否計算庫存</label>
                                            <select class="form-control" id="excluding_inventory" name="excluding_inventory">
                                                <option value="0" <?= ($product['excluding_inventory'] == false ? 'selected' : '') ?>>是</option>
                                                <option value="1" <?= ($product['excluding_inventory'] == true ? 'selected' : '') ?>>否</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="stock_overbought">低於庫存時轉預購</label>
                                            <select class="form-control" id="stock_overbought" name="stock_overbought">
                                                <option value="0" <?= ($product['stock_overbought'] == false ? 'selected' : '') ?>>否</option>
                                                <option value="1" <?= ($product['stock_overbought'] == true ? 'selected' : '') ?>>是</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inventory">當前庫存量</label>
                                            <input type="text" class="form-control" id="inventory" name="inventory" value="<?= intval($product['inventory']) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="product_image" class="control-label">封面圖片</label>
                                    <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=product_image<?php echo $product['product_id']; ?>&relative_url=1" class="btn btn-primary btn-sm fancybox" type="button" style="float: right;">選擇圖片</a>
                                    <?php if (!empty($product['product_image'])) { ?>
                                        <img src="/assets/uploads/<?php echo $product['product_image']; ?>" id="product_image<?php echo $product['product_id']; ?>_preview" class="img-responsive" style="<?php if (empty($product['product_image'])) {
                                                                                                                                                                                                                echo 'display: none';
                                                                                                                                                                                                            } ?>">
                                    <?php } else { ?>
                                        <img src="" id="product_image<?php echo $product['product_id']; ?>_preview" class="img-responsive">
                                    <?php } ?>
                                    <input type="hidden" id="product_image<?php echo $product['product_id']; ?>" name="product_image" value="<?php echo $product['product_image']; ?>" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>單位</label>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="add_unit();">新增</a>
                                    <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                                </div>
                                <table class="table table-bordered" id="paramsFields">
                                    <tr class="info">
                                        <th class="text-center">單位</th>
                                        <th class="text-center">重量/kg <span style="color:red;font-size:12px;">(設定0時則不套用)</span></th>
                                        <th class="text-center">材積/cm <span style="color:red;font-size:12px;">(設定0時則不套用)</span></th>
                                        <th class="text-center"></th>
                                    </tr>
                                    <tbody id="product-unit-list">
                                        <? if (!empty($product_unit)) {
                                            foreach ($product_unit as $row) { ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="id[]" value="<?php echo $row['id']; ?>">
                                                        <input type="text" class="form-control unit" name="unit[]" value="<?php echo $row['unit']; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="weight[]" value="<?= $row['weight'] ?>">
                                                    </td>
                                                    <td>
                                                        <div class="input-group" style="margin-bottom: 10px;">
                                                            <span class="input-group-addon">長度</span>
                                                            <input type="number" class="form-control" name="volume_length[]" min="0" value="<?= intval($row['volume_length']) ?>">
                                                        </div>
                                                        <div class="input-group" style="margin-bottom: 10px;">
                                                            <span class="input-group-addon">寬度</span>
                                                            <input type="number" class="form-control" name="volume_width[]" min="0" value="<?= intval($row['volume_width']) ?>">
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">高度</span>
                                                            <input type="number" class="form-control" name="volume_height[]" min="0" value="<?= intval($row['volume_height']) ?>">
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><i class="fa-solid fa-trash x"></i></td>
                                                </tr>
                                        <? }
                                        } ?>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>規格</label>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="add_specification();">新增</a>
                                    <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                                </div>
                                <table class="table table-bordered" id="paramsFields">
                                    <tr class="info">
                                        <th class="text-center">規格</th>
                                        <?php if (!empty($product_specification)) { ?>
                                            <th class="text-center">圖片</th>
                                            <th class="text-center">狀態</th>
                                            <th class="text-center">限購數量</th>
                                        <?php } ?>
                                        <th class="text-center"></th>
                                    </tr>
                                    <tbody id="product-specification-list">
                                        <?php if (!empty($product_specification)) {
                                            foreach ($product_specification as $row) { ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="id[]" value="<?php echo $row['id']; ?>">
                                                        <input type="text" class="form-control specification" name="specification[]" value="<?php echo $row['specification']; ?>">
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=picture<?php echo $row['id']; ?>&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                                                        </div>
                                                        <?php if (!empty($row['picture'])) { ?>
                                                            <img src="/assets/uploads/<?php echo $row['picture']; ?>" id="picture<?php echo $row['id']; ?>_preview" class="img-responsive" style="<?php if (empty($row['picture'])) {
                                                                                                                                                                                                        echo 'display: none';
                                                                                                                                                                                                    } ?>;max-width: 100px;width: 100%;">
                                                        <?php } else { ?>
                                                            <img src="" id="picture<?php echo $row['id']; ?>_preview" class="img-responsive">
                                                        <?php } ?>
                                                        <input type="hidden" id="picture<?php echo $row['id']; ?>" name="picture[]" value="<?php echo $row['picture']; ?>" />
                                                    </td>
                                                    <td>
                                                        <? $status_array = array(
                                                            '0' => '販售中',
                                                            '1' => '已售完',
                                                            '2' => '預購',
                                                            '99' => '停用',
                                                        );
                                                        if (!empty($row['status'])) { ?>
                                                            <select name=status[] class="form-control">
                                                                <? foreach ($status_array as $key => $value) { ?>
                                                                    <option value="<?= $key ?>" <?= ($row['status'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                                                                <? } ?>
                                                            </select>
                                                        <? } else { ?>
                                                            <select name=status[] class="form-control">
                                                                <? foreach ($status_array as $key => $value) { ?>
                                                                    <option value="<?= $key ?>" <?= ('0' == $key ? 'selected' : '') ?>><?= $value ?></option>
                                                                <? } ?>
                                                            </select>
                                                        <? } ?>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="limit_enable[]">
                                                            <? if (!empty($row['limit_enable'])) { ?>
                                                                <option value="YES" selected>啟用</option>
                                                                <option value="">停用</option>
                                                            <? } else { ?>
                                                                <option value="YES">啟用</option>
                                                                <option value="" selected>停用</option>
                                                            <? } ?>
                                                        </select>
                                                        <? if ($row['limit_qty'] > 0) { ?>
                                                            <input type="number" name="limit_qty[]" class="form-control" placeholder="請輸入限購數量" value="<?= $row['limit_qty'] ?>">
                                                        <? } else { ?>
                                                            <input type="number" name="limit_qty[]" class="form-control" placeholder="請輸入限購數量">
                                                        <? } ?>
                                                    </td>
                                                    <td class="text-center"><i class="fa-solid fa-trash x"></i></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>方案</label>
                                    <a href="/admin/product/create_plan/<?php echo $product['product_id'] ?>" class="btn btn-warning modal-btn btn-sm">新增 <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                </div>
                                <table class="table table-bordered" id="plan_paramsFields">
                                    <tr class="info">
                                        <th style="width: 20%;">名稱</th>
                                        <th style="width: 10%;">貨號</th>
                                        <th style="width: 10%;">原價</th>
                                        <th style="width: 10%;">方案價</th>
                                        <th style="width: 10%;">限購數量</th>
                                        <th style="width: 20%;">描述</th>
                                        <th style="width: 10%;">圖片</th>
                                        <th style="width: 10%;">操作</th>
                                    </tr>
                                    <?php if (!empty($product_combine)) {
                                        foreach ($product_combine as $row) { ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['cargo_id']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['current_price']; ?></td>
                                                <td>
                                                    <select class="form-control" name="limit_enable[]" disabled>
                                                        <? if (!empty($row['limit_enable'])) { ?>
                                                            <option value="YES" selected>啟用</option>
                                                            <option value="">停用</option>
                                                        <? } else { ?>
                                                            <option value="YES">啟用</option>
                                                            <option value="" selected>停用</option>
                                                        <? } ?>
                                                    </select>
                                                    <? if ($row['limit_qty'] > 0) { ?>
                                                        <input type="number" name="limit_qty[]" class="form-control" placeholder="請輸入限購數量" value="<?= $row['limit_qty'] ?>" disabled>
                                                    <? } else { ?>
                                                        <input type="number" name="limit_qty[]" class="form-control" placeholder="請輸入限購數量" disabled>
                                                    <? } ?>
                                                </td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td>
                                                    <?php if (!empty($row['picture'])) { ?>
                                                        <img src="/assets/uploads/<?php echo $row['picture']; ?>" class="img-responsive">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="/admin/product/edit_plan/<?php echo $row['id'] ?>" class="btn btn-primary modal-btn">編輯</a>
                                                    <a href="/admin/product/delete_plan/<?php echo $row['id'] ?>" class="btn btn-danger" onClick="return confirm('您確定要刪除嗎?')">刪除</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="product_description">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_description">商品描述</label>
                                    <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                                    <textarea class="form-control" id="product_description" name="product_description" cols="30" rows="30"><?php echo $product['product_description']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="product_note">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_note">注意事項</label>
                                    <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                                    <textarea class="form-control" id="product_note" name="product_note" cols="30" rows="30"><?php echo $product['product_note']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<!-- <div class="row">
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
</div> -->
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
        $(window).on('popstate', function() {
            var anchor = location.hash ||
                $('a[data-toggle=\'tab\']').first().attr('href');
            $('a[href=\'' + anchor + '\']').tab('show');
        });

        $(document).on('click', '.x', function() {
            $(this).parent().parent().remove();
        });
    });

    function checkbox($id) {
        var id = "limit_enable_" + $id;
        if (document.getElementById(id).checked) {
            alert('OK');
            $('#' + id).val('YES');
        } else {
            $('#' + id).val('NO');
        }
    }

    function add_unit() {
        $("#product-unit-list").append('<tr><td><input type="text" name="unit[]" class="form-control unit"/></td><td><input type="number" class="form-control" name="weight[]" min="0" value="0"></td><td><div class="input-group" style="margin-bottom: 10px;"><span class="input-group-addon">長度</span><input type="number" class="form-control" name="volume_length[]" min="0" value="0"></div><div class="input-group" style="margin-bottom: 10px;"><span class="input-group-addon">寬度</span><input type="number" class="form-control" name="volume_width[]" min="0" value="0"></div><div class="input-group"><span class="input-group-addon">高度</span><input type="number" class="form-control" name="volume_height[]" min="0" value="0"></div></td><td class="text-center"><i class="fa-solid fa-trash x"></i></td></tr>');
    }

    function add_specification() {
        $("#product-specification-list").append('<tr><td><input type="text" name="specification[]" class="form-control specification"/></td><td class="text-center"><i class="fa-solid fa-trash x"></i></td></tr>');
    }

    function createSingleSales(product_id) {
        if (confirm('確定要建立銷售頁面')) {
            $.ajax({
                type: "POST",
                url: '/admin/sales/createSingleSales',
                data: {
                    product_id: product_id,
                },
                success: function(data) {
                    window.location.href = data;
                },
                error: function(data) {
                    console.log('Create Error');
                }
            })
        }
    }
</script>