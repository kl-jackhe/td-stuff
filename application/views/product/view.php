<style>
    .product_description img {
    width: 100%;
    max-width: 900px;
    height: 100%;
}
.qty {
    width: 40px;
    height: 35px;
    text-align: center;
    border: 0;
    border-top: 1px solid #aaa;
    border-bottom: 1px solid #aaa;
}
input.qtyplus {
    width: 25px;
    height: 35px;
    border: 1px solid #aaa;
    background: #f8f8f8;
}
input.qtyminus {
    width: 25px;
    height: 35px;
    border: 1px solid #aaa;
    background: #f8f8f8;
}
.button_border_style_l {
        border: 1px solid #B5ACA5;
        padding: 0px 5px 0px 5px;
        border-radius: 5px 0px 0px 5px;
        color: #524535;
        background: #fff;
}
.button_border_style_r {
    border: 1px solid #B5ACA5;
    padding: 0px 5px 0px 5px;
    border-radius: 0px 5px 5px 0px;
    color: #C52B29;
    background: #fff;
}
.input_border_style {
    background-color: #fff !important;
    border-top: 1px solid #B5ACA5;
    border-bottom: 1px solid #B5ACA5;
    padding: 0px;
    height: 26px;
    text-align: center;
}
.add_product {
    background-color: #68396D;
    color: #fff !important;
    width: 100%;
    line-height: 1.8;
    padding: 0;
}
#zoomA {
  transition: transform ease-in-out 0s;
}
#zoomA:hover {
    transform: scale(1.05);
}
.product_view_img_style {
    border-radius: 15px;
    max-width: 300px;
    max-height: 300px;
    width: 100%;
}
</style>
<div role="main" class="main product-view">
    <section class="form-section content_auto_h">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <?php if (!empty($product)) { ?>
                <div class="col-md-8 text-center product_description">
                    <p class="m-0" style="font-size: 28px;">
                        <?=$product['product_name']?>
                    </p>
                    <?php if (!empty($product['product_description'])) {
                        echo $product['product_description'];
                    } else {
                        echo '<h3>暫無商品描述</h3>';
                    } ?>
                </div>
                <div class="col-md-12 text-center">
                    <p class="m-0" style="font-size: 28px;">方案選擇</p>
                </div>
                <div class="col-md-8 py-3">
                    <div class="row justify-content-center">
                        <?php if(!empty($product_combine)) { foreach ($product_combine as $combine) { ?>
                        <div class="col-md-4 py-2 mb-5 text-center">
                            <?php if(!empty($combine['picture'])) { ?>
                            <img id="zoomA" class="product_view_img_style" src="/assets/uploads/<?php echo $combine['picture']; ?>">
                            <?}else{?>
                            <img id="zoomA" class="product_view_img_style" src="/assets/uploads/Product/img-600x600.png">
                            <?}?>
                            <div class="pt-2">
                                <span style="font-size: 16px;">
                                    <?php echo $combine['name']; ?>
                                </span>
                            </div>
                            <?if (!empty($combine['description'])) {?>
                            <div class="py-2">
                                <span style="font-size: 12px;">
                                    <? echo $combine['description'];?>
                                </span>
                            </div>
                            <?}?>
                            <div>
                                <?php if ($combine['price'] != $combine['current_price'] && $combine['price'] != 0) {?>
                                <span style="color: gray;font-size: 14px;font-style: oblique;text-decoration: line-through;">原價
                                    <span style="color: gray;font-size: 14px;font-style: oblique;"> $
                                        <?=$combine['price'];?>
                                    </span>
                                </span>
                                <br>
                                <?}?>
                                <span style="color:#BE2633; font-size: 16px; font-weight: bold;font-style: oblique;">方案價
                                    <span style="color:#BE2633; font-size: 16px; font-weight: bold;font-style: oblique;">$
                                        <?=$combine['current_price'];?>
                                    </span>
                                </span>
                            </div>
                            <div class="text-center" style="padding-left: 25%;padding-right: 25%;">
                                <!-- <input type="text" id="qty_<?php echo $combine['product_id'] ?>" class="form-control input-number" min="1" max="999" value="1" style="background: #fff;" readonly> -->
                                <div class="input-group my-3">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[<?php echo $combine['id'] ?>]">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quant[<?php echo $combine['id'] ?>]" id="qty_<?php echo $combine['id'] ?>" class="form-control input-number input_border_style" value="1" min="1" max="100" disabled>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-field="quant[<?php echo $combine['id'] ?>]">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                                <?if ($combine['type'] == 1) {?>
                                <!-- 任意選取規格 -->
                                <div>
                                    <?$product_combine_item_qty = $this->product_model->get_product_combine_item($combine['id']);?>
                                </div>
                                <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn add_product" data-toggle="modal" data-target="#multitude_specification<?php echo $combine['id'] ?>">
                                    <i class="fa-solid fa-cart-shopping"></i> 選擇規格
                                </button>
                                <form action="/cart/add_multitude_specification" id="multitude_specification" method="POST">
                                    <div class="modal fade" id="multitude_specification<?php echo $combine['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="multitude_specification<?php echo $combine['id'] ?>Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="multitude_specification<?php echo $combine['id'] ?>Label">選擇規格</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?if (!empty($specification)) {
                                                    foreach($specification as $row){?>
                                                    <div class="input-group my-3">
                                                        <span style="width: 30%;">
                                                            <?=$row['specification'];?>
                                                        </span>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="<?php echo $row['id'].'_'.$combine['id'] ?>">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="<?echo $combine['id'].'specification_qty[]'?>" id="<?php echo $row['id'].'_'.$combine['id'] ?>" class="form-control input-number input_border_style" value="0" min="0" max="100" readonly>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-field="<?php echo $row['id'].'_'.$combine['id'] ?>">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </span>
                                                        <input type="hidden" name="<?echo $combine['id'].'specification_name[]'?>" value="<?php echo $row['specification'] ?>">
                                                        <input type="hidden" name="<?echo $combine['id'].'specification_id[]'?>" value="<?php echo $row['id'] ?>">
                                                    </div>
                                                    <?}
                                                } else {
                                                    echo '尚無規格可以選擇！';
                                                }?>
                                                </div>
                                                <div class="modal-footer">
                                                    <div>選購數量 <span class="select_qty"></span> / <span class="total_qty"></span></div>
                                                </div>
                                                <input type="hidden" name="combine_id" value="<?php echo $combine['id'] ?>">
                                                <div class="modal-footer">
                                                    <span class="btn add_product" onclick="add_cart(<?php echo $combine['id'] ?>)">
                                                        <i class="fa-solid fa-cart-shopping"></i> 選購
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- 任意選取規格 -->
                                <?} else {?>
                                <button onclick="add_cart(<?php echo $combine['id'] ?>)" type="button" class="btn add_product">
                                    <i class="fa-solid fa-cart-shopping"></i> 選購
                                </button>
                                <?}?>
                            </div>
                        </div>
                        <? }} ?>
                    </div>
                </div>
                <? } ?>
            </div>
        </div>
    </section>
</div>
<script>
function add_cart(combine_id) {
    var qty = document.getElementById("qty_" + combine_id).value;
    var form = $('#multitude_specification');
    var url = form.attr('action');
    var specification_name = $("input[name='"+ combine_id +"specification_name[]']").map(function(){return $(this).val();}).get();
    var specification_id = $("input[name='"+ combine_id + "specification_id[]']").map(function(){return $(this).val();}).get();
    var specification_qty = $("input[name='"+ combine_id + "specification_qty[]']").map(function(){return $(this).val();}).get();
    // alert(specification_name);
    // alert(specification_id);
    // alert(specification_qty);
    // alert(combine_id);
    $.ajax({
        url: "/cart/add_combine",
        method: "POST",
        data: {
            combine_id: combine_id, 
            qty: qty,
            specification_name: specification_name,
            specification_id: specification_id,
            specification_qty: specification_qty,
        },
        success: function(data) {
            alert('加入成功');
            get_cart_qty();
        }
    });
}

function specification_qty(combine_id,product_combine_item) {
    var qty = document.getElementById("qty_" + combine_id).value;
    var total_qty= qty*product_combine_item;
    $('.total_qty').html(total_qty);
    $.ajax({
        method: "POST",
        data: { combine_id: combine_id, qty: qty },
        success: function(data) {
            // $('.select_qty').html(select_qty);
        }
    });
}

// plugin bootstrap minus and plus
// http://jsfiddle.net/laelitenetwork/puJ6G/
$('.product-view .btn-number').click(function(e) {
    e.preventDefault();
    fieldName = $(this).attr('data-field');
    type = $(this).attr('data-type');
    var input = $("input[name='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {

            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if (type == 'plus') {

            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.product-view .input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('.product-view .input-number').change(function() {

    minValue = parseInt($(this).attr('min'));
    maxValue = parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if (valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
});


//input_id
$('.product-view .btn-number').click(function(e) {
    e.preventDefault();
    fieldName = $(this).attr('data-field');
    type = $(this).attr('data-type');
    var input = $("input[id='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {

            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if (type == 'plus') {

            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.product-view .input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('.product-view .input-number').change(function() {

    minValue = parseInt($(this).attr('min'));
    maxValue = parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if (valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
});
</script>


