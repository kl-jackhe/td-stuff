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
    <?if ($this->is_td_stuff) {?>
        background-color: #68396D;
        color: #fff !important;
    <?}?>
    <?if ($this->is_liqun_food) {?>
        background-color: #f6d523;
        color: #000 !important;
    <?}?>
    <?if ($this->is_partnertoys) {?>
        background-color: rgba(239,132,104,1.0);
        color: #fff !important;
    <?}?>
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
                <div class="col-md-8 text-center product_description" style="margin-bottom: 35px;">
                    <?if ($this->is_td_stuff) {?>
                        <img src="/assets/uploads/Banner/page_banner_free_shipping_1000-1.jpg">
                    <?}?>
                </div>
                <div class="col-md-8 text-center product_description">
                    <p class="m-0" style="font-size: 28px;">
                        <?=$product['product_name']?>
                    </p>
                    <?=(!empty($product['product_description'])? $product['product_description'] : '<h3>暫無商品描述</h3>' )?>
                </div>
                <div class="col-md-8 text-center product_description">
                    <p class="m-0" style="font-size: 28px;">
                        <?=$product['product_note']?>
                    </p>
                </div>
                <div class="col-md-8 text-center product_description" style="margin-bottom: 35px;">
                    <?if ($this->is_td_stuff) {?>
                        <p><img src="/assets/uploads/Banner/page_banner_free_shipping_1000-1.jpg"></p>
                    <?}?>
                </div>
                <div class="col-md-12 text-center">
                    <p class="m-0" style="font-size: 28px;">方案選擇</p>
                </div>
                <div class="col-md-8 py-3">
                    <div class="row justify-content-center">
                        <?php if(!empty($product_combine)) { 
                            foreach ($product_combine as $combine) {
                                $inventory = 0;
                                foreach ($product_combine_item as $pci_row) {
                                    if ($combine['id'] == $pci_row['product_combine_id']) {
                                        $inventory = $pci_row['qty'];
                                    }
                                }?>
                            <div class="col-md-4 py-2 mb-5 text-center">
                                <img id="zoomA" class="product_view_img_style" src="/assets/uploads/<?=(!empty($combine['picture']) ? $combine['picture'] : 'Product/img-600x600.png') ; ?>">
                                <div class="pt-2" style="font-size: 16px;">
                                    <?=$combine['name']; ?>
                                </div>
                                <?if (!empty($combine['description'])) {?>
                                    <div class="py-2" style="font-size: 12px;">
                                        <?=$combine['description'];?>
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
                                    <?if(($product['sales_status'] == 0 || $product['sales_status'] == 2) && ($product['inventory'] >= $inventory || $product['excluding_inventory'] == true || $product['stock_overbought'] == true)){?>
                                        <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn add_product" data-toggle="modal" data-target="#multitude_specification_modal_<?php echo $combine['id'] ?>">
                                        <i class="fa-solid fa-cart-shopping"></i> 選擇規格
                                        </button>
                                    <?} else {?>
                                        <span class="btn add_product" style="background: #817F82;cursor: auto;">
                                            <i class="fa-solid fa-cart-shopping" disabled></i> 售完
                                        </span>
                                    <?}?>
                                    <form action="/cart/add_multitude_specification" id="multitude_specification" method="POST">
                                        <div class="modal fade" id="multitude_specification_modal_<?php echo $combine['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="multitude_specification_Label" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <p class="modal-title text-left" id="multitude_specification_Label">選擇規格
                                                            <br>
                                                            <span style="font-size: 18px;font-weight: bold;">
                                                                <?if (!empty($combine['description'])) {?>
                                                                <span><? echo $combine['description'];?>&ensp;</span>
                                                                <?}?>
                                                                請選擇 <span class="total_qty"></span> 樣
                                                            </span>
                                                        </p>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <?if (!empty($specification)) {
                                                        foreach($specification as $row) {
                                                            if ($row['status'] != 99) {?>
                                                            <div class="input-group my-3">
                                                                <div style="width: 25%;">
                                                                    <img class="product_view_img_style" src="/assets/uploads/<?php echo $row['picture']; ?>">
                                                                </div>
                                                                <div style="width: 45%;position: relative;">
                                                                    <div style="position: absolute;bottom: 10px;left: 20px;font-size: 18px;font-weight: bold;">
                                                                        <?=$row['specification'];?>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group" style="width: 30%;">
                                                                    <div class="input-group" style="position: absolute;bottom: 10px;">
                                                                    <?if ($row['status'] == 0) {
                                                                        if ($row['limit_enable'] == 'YES' && $combine['limit_enable'] == 'YES'){?>
                                                                            <p class="text-center" style="color: #C52B29;font-weight: bold;width: 100%;">選購 <span class="limit_qty"></span> 組 x 限購數量 <?=$row['limit_qty']?></p>
                                                                            <span class="input-group-btn">
                                                                                <button onclick="specification_limit_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>,<?=$row['limit_qty']?>,<?=$row['id']?>)" type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="<?php echo $row['id'].'_'.$combine['id'] ?>">
                                                                                    <i class="fa-solid fa-minus"></i>
                                                                                </button>
                                                                            </span>
                                                                            <input type="text" name="<?echo $combine['id'].'specification_qty[]'?>" id="<?php echo $row['id'].'_'.$combine['id'] ?>" class="form-control input-number input_border_style" value="0" min="0" max="100" readonly>
                                                                            <span class="input-group-btn">
                                                                                <button onclick="specification_limit_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>,<?=$row['limit_qty']?>,<?=$row['id']?>)" type="button" class="btn btn-number button_border_style_r select_qty_button" data-type="plus" data-field="<?php echo $row['id'].'_'.$combine['id'] ?>">
                                                                                    <i class="fa-solid fa-plus"></i>
                                                                                </button>
                                                                            </span>
                                                                        <?} else {?>
                                                                            <span class="input-group-btn">
                                                                                <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="<?php echo $row['id'].'_'.$combine['id'] ?>">
                                                                                    <i class="fa-solid fa-minus"></i>
                                                                                </button>
                                                                            </span>
                                                                            <input type="text" name="<?echo $combine['id'].'specification_qty[]'?>" id="<?php echo $row['id'].'_'.$combine['id'] ?>" class="form-control input-number input_border_style" value="0" min="0" max="100" readonly>
                                                                            <span class="input-group-btn">
                                                                                <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn btn-number button_border_style_r select_qty_button" data-type="plus" data-field="<?php echo $row['id'].'_'.$combine['id'] ?>">
                                                                                    <i class="fa-solid fa-plus"></i>
                                                                                </button>
                                                                            </span>
                                                                        <?}?>
                                                                    <?} else {?>
                                                                        <span class="text-center" style="color: #C52B29;font-weight: bold;width: 100%;">已售完</span>
                                                                    <?}?>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="<?echo $combine['id'].'specification_name[]'?>" value="<?php echo $row['specification'] ?>">
                                                                <input type="hidden" name="<?echo $combine['id'].'specification_id[]'?>" value="<?php echo $row['id'] ?>">
                                                            </div>
                                                        <?}
                                                        }
                                                    } else {
                                                        echo '尚無規格可以選擇！';
                                                    }?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div>選購數量 <span class="select_qty"></span> / <span class="total_qty"></span></div>
                                                    </div>
                                                    <input type="hidden" name="combine_id" value="<?php echo $combine['id'] ?>">
                                                    <div class="modal-footer">
                                                        <?if($product['sales_status'] == 0 || $product['sales_status'] == 2){?>
                                                            <span class="btn add_product" onclick="select_qty_ok_add_cart(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" style="<?=($product['sales_status'] == 2 || ($product['inventory'] < $inventory && $product['stock_overbought'] == true) ?'background: #A60747;':'')?>">
                                                                <i class="fa-solid fa-cart-shopping"></i> 
                                                                <?if ($product['inventory'] < $inventory && $product['stock_overbought'] == true){
                                                                    echo '預購';
                                                                } else {
                                                                    echo ($product['sales_status'] == 0 ? '選購' : '預購');
                                                                }?>
                                                            </span>
                                                        <?}?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- 任意選取規格 -->
                                    <?} else {
                                        if(($product['sales_status'] == 0 || $product['sales_status'] == 2) && ($product['inventory'] >= $inventory || $product['excluding_inventory'] == true || $product['stock_overbought'] == true)){?>
                                            <button onclick="add_cart(<?php echo $combine['id'] ?>)" type="button" class="btn add_product" style="<?=($product['sales_status'] == 2 || ($product['inventory'] < $inventory && $product['stock_overbought'] == true) ?'background: #A60747;':'')?>">
                                                <i class="fa-solid fa-cart-shopping"></i> 
                                                <?if ($product['inventory'] < $inventory && $product['stock_overbought'] == true){
                                                    echo '預購';
                                                } else {
                                                    echo ($product['sales_status'] == 0 ? '選購' : '預購');
                                                }?>
                                            </button>
                                        <?} else {?>
                                            <span class="btn add_product" style="background: #817F82;cursor: auto;">
                                                <i class="fa-solid fa-cart-shopping" disabled></i> 售完
                                            </span>
                                        <?}
                                    }?>
                                </div>
                            </div>
                        <?}
                        }?>
                    </div>
                </div>
                <?}?>
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
// 限購數量判斷
function specification_limit_qty(combine_id,product_combine_item,limit_qty,id) {
    var qty = document.getElementById("qty_" + combine_id).value;
    var limit_id = id+'_'+combine_id;
    var total_qty = qty * product_combine_item;
    var limit_qty_total = limit_qty * qty;
    $('.limit_qty').html(qty);
    $('.total_qty').html(total_qty);
    setTimeout(function(){
        $("#"+limit_id).attr({
           "max" : limit_qty_total,
        });
        var qty_sum = select_qty(combine_id);
        $('.select_qty').html(qty_sum);
        if (total_qty <= qty_sum) {
            $('.select_qty_button').prop('disabled', true);
        }
        if (total_qty > qty_sum) {
            $('.select_qty_button').prop('disabled', false);
        }
    }, 50);
    return total_qty;
}

// 數量判斷
function specification_qty(combine_id,product_combine_item) {
    var qty = document.getElementById("qty_" + combine_id).value;
    var total_qty = qty * product_combine_item;
    $('.limit_qty').html(qty);
    $('.total_qty').html(total_qty);
    setTimeout(function(){
        var qty_sum = select_qty(combine_id);
        $('.select_qty').html(qty_sum);
        if (total_qty <= qty_sum) {
            $('.select_qty_button').prop('disabled', true);
        }
        if (total_qty > qty_sum) {
            $('.select_qty_button').prop('disabled', false);
        }
    }, 50);
    return total_qty;
}
function select_qty(combine_id) {
    let qty_sum = $("input[name='"+ combine_id + "specification_qty[]']").map(function(){return $(this).val();}).get();
    let select_qty_sum = 0;
    for (var i = 0; i < qty_sum.length; i++) {
        select_qty_sum = select_qty_sum + qty_sum.map(Number)[i];
    }
    return select_qty_sum;
}
function select_qty_ok_add_cart(combine_id,product_combine_item) {
    var total_qty = specification_qty(combine_id,product_combine_item);
    var qty_sum = select_qty(combine_id);
    if (total_qty == qty_sum) {
        add_cart(combine_id);
        $('#multitude_specification_modal_'+combine_id).modal('toggle');
        clear(combine_id);
    }
    if (total_qty > qty_sum) {
        alert('請選取正確數量');
    }
    if (total_qty < qty_sum) {
        alert('請重新選取數量');
    }
}

// 加入購物車後清除內容
function clear(combine_id) {
    setTimeout(function(){
        $("input[name='"+ combine_id + "specification_qty[]']").val('0');
        $('#qty_'+combine_id).val('1');
    }, 50);
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
                // $(this).attr('disabled', true);
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