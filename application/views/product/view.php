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
<div role="main" class="main">
    <section class="form-section">
        <div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px;">
            <div class="row justify-content-center">
                <?if (!empty($product)) {?>
                <!-- <div class="col-md-12 text-center">
                    <h1>商品描述</h1>
                </div> -->
                <div class="col-md-8 text-center product_description">
                    <?if (!empty($product['product_description'])) {
                        echo $product['product_description'];
                    }else {?>
                    <h3>暫無商品描述</h3>
                    <?}?>
                </div>
                <div class="col-md-12 text-center">
                    <h1 class="m-0">商品選購</h1>
                </div>
                <div class="col-md-8 py-5">
                    <form id="form1" name="form1" method="post" action="">
                        <div class="row">
                            <?foreach  ( $specification as  $row ){?>
                            <div class="col-md-4 py-2">
                                <img style="max-width: 300px;max-height: 300px;width: 100%;border-radius: 15px;" src="/assets/uploads/<?=$product['product_image'];?>">
                                <div class="pt-3">
                                    <span style="font-size:16px;">
                                        <?=$product['product_name'];?></span>
                                </div>
                                <div class="py-2">
                                    <span style="font-size: 12px;">特好用</span>
                                </div>
                                <div>
                                    <span style="color:red;font-size: 18px;font-weight: bold;">$<?=$row['price'];?></span>
                                </div>
                                <div class="text-center">
                                    <div>
                                        <?php
$cart_qty = 0;
foreach ($this->cart->contents() as $items) {
	if ($items["id"] == $product['product_id']) {
		$cart_qty = $items["qty"];
	}
}
?>
                                    </div>
                                    <div>
                                        <?php $get_product_remaining_qty = get_product_remaining_qty($product['product_id'], $cart_qty);
if ($product['product_person_buy'] != 0) {
	if ($get_product_remaining_qty > $product['product_person_buy']) {
		$max = $product['product_person_buy'];
	} else {
		$max = $get_product_remaining_qty;
	}
} else {
	$max = 999;
}
?>
                                    </div>
                                    <!-- <input type="text" id="qty_<?php echo $product['product_id'] ?>" class="form-control input-number" min="1" max="999" value="1" style="background: #fff;" readonly> -->
                                    <div class="input-group my-3">
                                        <span class="input-group-btn">
                                            <button type="button" style="padding: 0px 5px 0px 5px;border-radius: 5px 0px 0px 5px;" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quant[2]" style="padding: 0px;height: 26px;text-align: center;" class="form-control input-number" value="1" min="1" max="100" disabled>
                                        <span class="input-group-btn">
                                            <button type="button" style="padding: 0px 5px 0px 5px; border-radius: 0px 5px 5px 0px;" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <button onclick="add_cart(<?php echo $product['product_id'] ?>)" type="button" class="btn btn-primary btn-number" style="border-radius: 10px;padding: 3px 10px 3px 10px;width: 100%;">
                                        <i class="fa-solid fa-cart-shopping"></i> 選購
                                    </button>
                                    <input type="hidden" id="product_<?php echo $product['product_id'] ?>" value="<?php echo $product['product_id'] ?>">
                                </div>
                            </div>
                            <?}?>
                        </div>
                    </form>
                </div>
                <?}?>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
    $('#cart_details').load("<?php echo base_url(); ?>store/load_cart");
    $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
    $(document).on('click', '.remove_item', function() {
        var id = $(this).data("id");
        var rowid = $(this).data("rowid");
        $.ajax({
            url: "<?php echo base_url(); ?>cart/remove",
            method: "POST",
            data: { rowid: rowid },
            success: function(data) {
                // window.location.reload();
                $('#coupon').val('');
                $('#qty_' + id).val(0);
                $('#cart_details').load("<?php echo base_url(); ?>store/load_cart");
                $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
            }
        });
    });
});

function view_form_check() {
    if ($('#delivery_time').val() == '') {
        alert('請選擇取餐時間。');
    } else {
        $.ajax({
            url: "<?php echo base_url(); ?>auth/check_is_login",
            method: "GET",
            data: {},
            success: function(data) {
                if (data == '1') {

                    $.ajax({
                        url: "<?php echo base_url(); ?>cart/check_cart_is_empty",
                        method: "GET",
                        data: {},
                        success: function(data) {
                            if (data > 0) {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>store/cart_price_check",
                                    method: "GET",
                                    data: {},
                                    success: function(data) {
                                        if (data == 'yes') {
                                            $('#view_form').submit();
                                        } else {
                                            alert('購物車金額需滿' + data + '元，才能結帳。');
                                        }
                                    }
                                });
                                // $('#view_form').submit();
                            } else {
                                alert('購物車是空的，請添加商品。');
                            }
                        }
                    });

                } else if (data == '0') {
                    login_model();
                }
            }
        });
    }
}

function add_cart(id) {
    var id = document.getElementById("product_" + id).value;
    var qty = document.getElementById("qty_" + id).value;
    // var remaining = document.getElementById("product"+id+"_remaining").html();
    // var remaining_default = $("#product" + id + "_remaining_default").val();
    // var remaining = $("#product" + id + "_remaining").text();
    // if (parseInt(qty) <= parseInt(stock)) {
    alert(id);
    alert(qty);
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add",
        method: "POST",
        data: { id: id, qty: qty },
        success: function(data) {
            // $('#cart_details').load("<?php echo base_url(); ?>store/load_cart");
            // $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
            // $('#coupon').val('');
            // $('#qty_' + id).val('');
            // if ($('#qty_' + id).attr('max') != '999') {
            //     $('#product' + id + '_remaining').text('*餐點剩餘' + (remaining_default - data) + '份');
            // }
            alert('加入成功');

        }
    });
    //document.getElementById("stock-"+id).value -= qty;
    // } else {
    //     alert("庫存不足！");
    // }
}

function select_coupon() {
    var coupon_code = document.getElementById("coupon").value;
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add_coupon",
        method: "POST",
        dataType: "json",
        data: { coupon_code: coupon_code },
        success: function(data) {
            if (data['result'] == '1') {
                // alert('已套用此優惠券。');
            } else if (data['result'] == '0') {
                $('#coupon').val('');
                // alert('此優惠券已過期。');
            } else if (data['result'] == '2') {
                // alert('2');
            } else if (data['result'] == '3') {
                $('#coupon').val('');
                // alert('不符合使用條件。');
            }
            if (data['reason'] != '') {
                alert(data['reason']);
            }
            $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
        },
        error: function(data) {
            alert('Error: ' + data);
            $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
        }
    });
}

function set_delivery_place() {
    var delivery_place = $('#delivery_place').val();
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add_delivery_place",
        method: "POST",
        data: { delivery_place: delivery_place },
        success: function(data) {
            // $('#delivery_place_notice').fadeIn();
        }
    });
}

function select_delivery_time() {
    var delivery_time = document.getElementById("delivery_time").value;
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add_delivery_time",
        method: "POST",
        data: { delivery_time: delivery_time },
        success: function(data) {}
    });
}

// plugin bootstrap minus and plus
// http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e) {
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
$('.input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

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