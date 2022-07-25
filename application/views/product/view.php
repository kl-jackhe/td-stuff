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
</style>
<div role="main" class="main product-view">
    <section class="form-section">
        <div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px;">
            <div class="row justify-content-center">
                <?php if (!empty($product)) { ?>
                <div class="col-md-8 text-center product_description">
                    <?php if (!empty($product['product_description'])) {
                        echo $product['product_description'];
                    } else {
                        echo '<h3>暫無商品描述</h3>';
                    } ?>
                </div>
                <div class="col-md-12 text-center">
                    <h1 class="m-0">方案選擇</h1>
                </div>
                <div class="col-md-8 py-5">
                    <div class="row">
                        <?php if(!empty($product_combine)) { foreach ($product_combine as $combine) { ?>
                        <div class="col-md-4 py-2">
                            <?php if(!empty($combine['picture'])) { ?>
                                <img style="max-width: 300px; max-height: 300px; width: 100%; border-radius: 15px;" src="/assets/uploads/<?php echo $combine['picture']; ?>">
                            <?php } ?>
                            <div class="pt-3">
                                <span style="font-size: 16px;">
                                    <?php echo $combine['name']; ?>
                                </span>
                            </div>
                            <div class="py-2">
                                <span style="font-size: 12px;">特好用</span>
                            </div>
                            <div>
                                <span style="color:red; font-size: 18px; font-weight: bold;">$<?php echo $combine['price'] ?></span>
                            </div>
                            <div class="text-center">
                                <!-- <input type="text" id="qty_<?php echo $combine['product_id'] ?>" class="form-control input-number" min="1" max="999" value="1" style="background: #fff;" readonly> -->
                                <div class="input-group my-3">
                                    <span class="input-group-btn">
                                        <button type="button" style="padding: 0px 5px 0px 5px;border-radius: 5px 0px 0px 5px;" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quant[2]" id="qty_<?php echo $combine['id'] ?>" style="padding: 0px;height: 26px;text-align: center;" class="form-control input-number" value="1" min="1" max="100" disabled>
                                    <span class="input-group-btn">
                                        <button type="button" style="padding: 0px 5px 0px 5px; border-radius: 0px 5px 5px 0px;" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                                <button onclick="add_cart(<?php echo $combine['id'] ?>)" type="button" class="btn btn-primary btn-number" style="border-radius: 10px;padding: 3px 10px 3px 10px;width: 100%;">
                                    <i class="fa-solid fa-cart-shopping"></i> 選購
                                </button>
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
    $.ajax({
        url: "/cart/add_combine",
        method: "POST",
        data: { combine_id: combine_id, qty: qty },
        success: function(data) {
            alert('加入成功');
            get_cart_qty();
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
</script>