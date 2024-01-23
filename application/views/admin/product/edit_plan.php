<div class="row">
    <? $attributes = array('class' => 'plan_update_submit_form', 'id' => 'plan_update_submit_form'); ?>
    <? echo form_open('admin/product/update_plan/' . $product_combine['id'], $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <span id="quick-update-btn" class="btn btn-primary">更新</span>
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
                                    <label for="product_combine_name">方案名稱</label>
                                    <input type="text" class="form-control" id="product_combine_name" name="product_combine_name" value="<? echo $product_combine['name'] ?>" required>
                                    <input type="hidden" name="product_id" value="<? echo $product['product_id'] ?>">
                                </div>
                            </div>
                            <?php if ($this->is_liqun_food) : ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="product_combine_cargo_id">貨號</label>
                                        <input type="text" class="form-control" id="product_combine_cargo_id" name="product_combine_cargo_id" value="<? echo $product_combine['cargo_id'] ?>" required>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="product_combine_price">原價</label>
                                    <input type="text" class="form-control" id="product_combine_price" name="product_combine_price" value="<? echo $product_combine['price'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="product_combine_current_price">方案價</label>
                                    <input type="text" class="form-control" id="product_combine_current_price" name="product_combine_current_price" value="<? echo $product_combine['current_price'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="product_combine_current_price">限購狀態</label>
                                <select class="form-control" name="limit_enable">
                                    <? if (!empty($product_combine['limit_enable'])) { ?>
                                        <option value="YES" selected>啟用</option>
                                        <option value="">停用</option>
                                    <? } else { ?>
                                        <option value="YES">啟用</option>
                                        <option value="" selected>停用</option>
                                    <? } ?>
                                </select>
                                <? if (!empty($product_combine['limit_qty'])) { ?>
                                    <input type="number" min="1" name="limit_qty" class="form-control" placeholder="請輸入限購數量" value="<?= $product_combine['limit_qty'] ?>">
                                <? } else { ?>
                                    <input type="number" min="1" name="limit_qty" class="form-control" placeholder="請輸入限購數量">
                                <? } ?>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="any_specification">開啟任意規格</label>
                                    <? if ($product_combine['type'] == 1) { ?>
                                        <input id="any_specification" name="any_specification" type="checkbox" value="1" checked>
                                    <? } else { ?>
                                        <input id="any_specification" name="any_specification" type="checkbox">
                                    <? } ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="product_combine_image" class="control-label">封面圖片</label>
                                    <div class="form-group">
                                        <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_combine_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                                    </div>
                                    <? if (!empty($product_combine['picture'])) { ?>
                                        <img src="/assets/uploads/<? echo $product_combine['picture']; ?>" id="add_product_combine_image<? echo $product_combine['product_id']; ?>_preview" class="img-responsive" style="<? if (empty($product_combine['picture'])) {
                                                                                                                                                                                                                                echo 'display: none';
                                                                                                                                                                                                                            } ?>">
                                    <? } else { ?>
                                        <img src="" id="add_product_combine_image<? echo $product_combine['product_id']; ?>_preview" class="img-responsive">
                                    <? } ?>
                                    <input type="hidden" id="add_product_combine_image" name="product_combine_image" value="<? echo $product_combine['picture'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_combine_description">方案描述</label>
                                    <textarea class="form-control" id="product_combine_description" name="product_combine_description" cols="30" rows="3"><? echo $product_combine['description'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label onclick="add_plan_item()"><i class="fa fa-plus"></i> 商品</label>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="info">
                                                <th width="30%" class="text-center">數量</th>
                                                <th width="30%" class="text-center">單位</th>
                                                <th width="30%" class="text-center">規格</th>
                                                <th width="5%" class="text-center">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody id="plan-item-list">
                                            <? if (!empty($product_combine_item)) {
                                                foreach ($product_combine_item as $item) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="plan_qty[]" class="form-control" value="<? echo $item['qty'] ?>">
                                                        </td>
                                                        <td>
                                                            <? $att = 'class="form-control"';
                                                            $options = array();
                                                            // $options = array("" => "單位");
                                                            if (!empty($product_unit)) {
                                                                foreach ($product_unit as $pu) {
                                                                    $options[$pu['unit']] = $pu['unit'];
                                                                }
                                                            }
                                                            echo form_dropdown('plan_unit[]', $options, $item['product_unit'], $att); ?>
                                                        </td>
                                                        <td>
                                                            <? $att = 'class="form-control"';
                                                            $options = array();
                                                            // $options = array("" => "規格");
                                                            if (!empty($product_specification)) {
                                                                $options[''] = '請選擇...';
                                                                foreach ($product_specification as $ps) {
                                                                    $options[$ps['specification']] = $ps['specification'];
                                                                }
                                                            }
                                                            echo form_dropdown('plan_specification[]', $options, $item['product_specification'], $att); ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <i class="fa-solid fa-trash x"></i>
                                                        </td>
                                                    </tr>
                                            <? }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? echo form_close() ?>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.x', function() {
            $(this).parent().parent().remove();
        });
        $('#any_specification').click(function() {
            if ($("#any_specification").is(":checked") == true) {
                $('#any_specification').val('1');
            } else {
                $('#any_specification').val('0');
            }
        });
    });

    function add_plan_item() {
        var unit = '';
        var unit_list = $('#product-unit-list .unit');
        unit += '<select class="form-control" name="plan_unit[]">';
        for (var i = 0; i < unit_list.length; i++) {
            unit += '<option value=' + unit_list[i].value + '>' + unit_list[i].value + '</option>';
        }
        unit += '</select>';

        var specification = '';
        var specification_list = $('#product-specification-list .specification');
        specification += '<select class="form-control" name="plan_specification[]">';
        specification += '<option value="">請選擇...</option>';
        for (var i = 0; i < specification_list.length; i++) {
            specification += '<option value=' + specification_list[i].value + '>' + specification_list[i].value + '</option>';
        }
        specification += '</select>';

        $("#plan-item-list").append('<tr><td><input type="text" name="plan_qty[]" class="form-control"/></td><td>' + unit + '</td><td>' + specification + '</td><td class="text-center"><i class="fa-solid fa-trash x"></i></td></tr>');
    }
    $('.fancybox').fancybox({
        'width': 1920,
        'height': 1080,
        'type': 'iframe',
        'autoScale': false
    });
    $('#quick-update-btn').click(function(e) {
        var update_cargo_id = $('#product_combine_cargo_id').val();
        // console.log(update_cargo_id);
        <?php if (!empty($cargo_id)) : ?>
            <?php foreach ($cargo_id as $self) : ?>
                if (update_cargo_id == <?= json_encode($self['cargo_id']); ?> && <?= json_encode($product_combine['id'] != $self['id']) ?>) {
                    alert('此貨號已存在請重新輸入');
                    return;
                }
            <?php endforeach; ?>
        <?php endif; ?>
        e.preventDefault();
        var form = $('#plan_update_submit_form');
        var url = form.attr('action');
        // console.log( $('#submit_form').serialize() );
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            // contentType: false,
            // cache: false,
            // processData: false,
            success: function(data) {
                // $('#use-Modal').modal('hide');
                location.reload(true);
                // console.log(data);
            },
            error: function(data) {
                console.log('無法送出');
            }
        })
    });
</script>