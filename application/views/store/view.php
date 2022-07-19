<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script> -->
<div class="main">
    <!-- <div class="container">
        <section class="page-header no-padding sm-slide-fix">
            <div class="row">
                <?php
if (!empty(get_store_banner($store_order_time['store_id']))) {
	$banner = '/assets/uploads/' . get_store_banner($store_order_time['store_id']);
} else {
	$banner = '';
}
?>
                <img src="<?php echo $banner ?>" class="img-responsive" style="min-height: 170px; max-height: 500px; margin: 0 auto;">
                <div class="container">
                    <div class="col-md-3 pull-right" style="margin-top: -150px; background: white; padding: 20px 15px; box-shadow: 2px 2px 10px 0px grey; border-radius: 8px;">
                        <h4 class="fs-16 color-221814 bold">
                            <?php echo get_store_name($store_order_time['store_id']) ?>
                            <input type="hidden" id="store_order_time" value="<?php echo $store_order_time['store_order_time_id'] ?>">
                        </h4>
                        <span class="fs-12 color-221814">
                            截止時間：
                            <?php echo $store_order_time['store_close_time'] ?>
                        </span>
                        <div class="text-center">
                            <?php if (!empty($store_order_time['store_id'])) {?>
                            <a href="<?php echo get_store_link($store_order_time['store_id']) ?>" target="_blank" class="text-center fs-12" style="text-decoration: underline; color: #00A0E8">查看店家詳情</a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div> -->
    <div class="container">
        <?php $attributes = array('class' => 'view', 'id' => 'view_form');?>
        <?php echo form_open('store/checkout', $attributes); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="detail-content">
                    <h3 class="fs-16 color-221814 bold">取餐日期
                        <?php echo $this->session->userdata('delivery_date') ?>
                    </h3>
                    <!--ORDER-->
                    <?php if (!empty($store_order_time_item)) {
	foreach ($store_order_time_item as $data) {?>
                    <?php
$cart_qty = 0;
		foreach ($this->cart->contents() as $items) {
			if ($items["id"] == $data['product_id']) {
				$cart_qty = $items["qty"];
			}
		}
		?>
                    <div class="row order">
                        <div class="col-md-6" style="padding-left: 0px;">
                            <?php if (!empty($data['product_image'])) {?>
                                <!-- <img data-src="/assets/uploads/<?php // echo $data['product_image'] ?>" class="img-responsive lazy"> -->
                                <img src="/assets/uploads/<?php echo $data['product_image'] ?>" class="img-responsive">
                            <?php }?>
                        </div>
                        <div class="col-md-6" style="padding: 15px;">
                            <h3 class="fs-12 color-221814">
                                <?php echo $data['product_name'] ?>
                            </h3>
                            <h4 class="fs-12 color-717071">
                                <?php echo $data['product_description'] ?>
                            </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="input-group">
                                            <span class="input-group-btn" onclick="add_cart(<?php echo $data['store_order_time_id'] ?>,<?php echo $data['product_id'] ?>)">
                                                <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="quant[<?php echo $data['product_id'] ?>]">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <?php $get_product_remaining_qty = get_product_remaining_qty($data['store_order_time_id'], $data['product_id'], $cart_qty);?>
                                            <?php
if ($data['product_person_buy'] != 0) {
			if ($get_product_remaining_qty > $data['product_person_buy']) {
				$max = $data['product_person_buy'];
			} else {
				$max = $get_product_remaining_qty;
			}
		} else {
			$max = 999;
		}
		?>
                                            <input type="text" name="quant[<?php echo $data['product_id'] ?>]" id="qty_<?php echo $data['product_id'] ?>" class="form-control input-number" min="0" max="<?php echo $max; ?>" value="<?php echo get_cart_product_qty($data['product_id']) ?>" style="background: #fff;" readonly>
                                            <span class="input-group-btn" onclick="add_cart(<?php echo $data['store_order_time_id'] ?>,<?php echo $data['product_id'] ?>)">
                                                <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[<?php echo $data['product_id'] ?>]">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>

                                        <input type="hidden" id="product_<?php echo $data['product_id'] ?>" value="<?php echo $data['product_id'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" id="product<?php echo $data['product_id'] ?>_remaining_default" value="<?php echo $get_product_remaining_qty ?>">
                                        <p class="fs-10" style="color: red;">
                                            <span style="color: red;" id="product<?php echo $data['product_id'] ?>_remaining">
                                                <?php echo ($get_product_remaining_qty == 0 ? '' : '*餐點剩餘' . $get_product_remaining_qty . '份') ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-5 text-right">
                                    <h4 class="color-221814" style="margin-top: 6px;">NT$
                                        <?php echo $data['product_price'] ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }}?>
                </div>
            </div>
            <div class="col-md-4">
                <div style="box-shadow: 3px 3px 10px 0px grey; border-left: none;">
                    <div class="checkout-list" style="margin-top: 55px; padding: 30px 30px; border: none; box-shadow: none;">
                        <?php // $attributes = array('method' => 'get'); ?>
                        <?php // echo form_open('store/checkout', $attributes); ?>
                        <table class="table table-bordered">
                            <tbody id="cart_details">
                            </tbody>
                            <tr>
                                <td>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php if (!empty($user_coupon)): ?>
                                            <h4 class="fs-13 bold color-221814">使用優惠券</h4>
                                            <?php $att = 'id="coupon" class="form-control" onchange="select_coupon()"';
$data = array('' => '選擇優惠券');
foreach ($user_coupon as $c) {
	// 排除過期的
	if (strtotime($c['coupon_off_date']) >= strtotime(date('Y-m-d H:i:s'))) {
		if ($c['coupon_use_limit'] == 'once' && $c['coupon_is_uesd'] == 'y') {
			//
		} else {
			$data[$c['coupon_code']] = $c['coupon_name'];
		}
	}
}
echo form_dropdown('coupon', $data, $this->session->userdata('coupon_id'), $att);
else:echo '<input type="hidden" name="coupon">';
endif;?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php if (empty($this->session->userdata('custom_address'))) {
	?>
                                                <?php if (!empty($delivery_place)): ?>
                                                <?php $count = 1;?>
                                                <h4 class="fs-13 bold color-221814">取餐地點</h4>
                                                <?php $att = 'id="delivery_place" class="form-control" onchange="set_delivery_place()"';
	$data = array('' => '請選擇取餐地點');
	foreach ($delivery_place as $c) {
		if ($count < 4) {
			$data[$c['delivery_place_id']] = $c['delivery_place_name'];
		}
		$count++;
	}
	echo form_dropdown('delivery_place', $data, $this->session->userdata('delivery_place'), $att);
	else:echo '<h4 class="fs-13 bold color-221814">沒有取餐地點</h4><input type="text" class="form-control" id="delivery_place" name="delivery_place" value="0" readonly>';
	endif;?>
                                            <?php } else {
	echo '<h4 class="fs-13 bold color-221814">取餐地點</h4>';
	echo $this->session->userdata('custom_address');
}?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- <h4 class="fs-13 bold color-221814">使用優惠券</h4> -->
                                            <?php if (!empty($store_order_time['delivery_time'])): ?>
                                            <?php // foreach (explode(',',$product['product_option1']) as $value) { ?>
                                            <h4 class="fs-13 bold color-221814">取餐時間</h4>
                                            <?php $att = 'id="delivery_time" class="form-control" onchange="select_delivery_time()"';
$data = array('' => '選擇取餐時間');
// foreach ($store_order_time['store_close_time'] as $c)
foreach (explode(',', $store_order_time['delivery_time']) as $c) {
	$data[$c] = $c;
}
echo form_dropdown('delivery_time', $data, $this->session->userdata('delivery_time'), $att);
else: // echo '<h4 class="fs-13 bold color-221814">沒有優惠券</h4><input type="hidden" class="form-control" id="delivery_time" name="delivery_time" value="0" readonly>';
endif;?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <ul id="load_cart_price" style="border: none;">
                        </ul>
                        <ul style="border: none;">
                            <li>
                                <div class="col-md-10 col-md-offset-1">
                                    <!-- <a href="/store/checkout" class="btn btn-info btn-block mt-md">結帳</a> -->
                                    <span class="btn btn-info btn-block mt-md" onclick="view_form_check()">結帳</span>
                                    <!-- <button type="submit" class="btn btn-info btn-block mt-md">結帳</button> -->
                                </div>
                            </li>
                        </ul>
                        <?php // echo form_close() ?>
                    </div>
                </div>
                <div class="pull-right" style="padding-top: 60px; padding-bottom: 20px;">
                    <span class="btn" style="border: 1px solid #3bccde; color: #3bccde;" onclick="history.back()">回上一頁</span>
                </div>
            </div>
        </div>
        <?php echo form_close() ?>
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
                    $('#qty_'+id).val(0);
                    $('#cart_details').load("<?php echo base_url(); ?>store/load_cart");
                    $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
                }
            });
        });
    });

    function view_form_check() {
        if($('#delivery_time').val()==''){
            alert('請選擇取餐時間。');
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>auth/check_is_login",
                method: "GET",
                data: { },
                success: function(data) {
                    if(data=='1'){

                        $.ajax({
                            url: "<?php echo base_url(); ?>cart/check_cart_is_empty",
                            method: "GET",
                            data: { },
                            success: function(data) {
                                if(data>0){
                                    $.ajax({
                                        url: "<?php echo base_url(); ?>store/cart_price_check",
                                        method: "GET",
                                        data: { },
                                        success: function(data) {
                                            if(data=='yes'){
                                                $('#view_form').submit();
                                            } else {
                                                alert('購物車金額需滿'+data+'元，才能結帳。');
                                            }
                                        }
                                    });
                                    // $('#view_form').submit();
                                } else {
                                    alert('購物車是空的，請添加商品。');
                                }
                            }
                        });

                    } else if(data=='0'){
                        login_model();
                    }
                }
            });
        }
    }

    function add_cart(store_order_time_id, id) {
        var store_order_time = document.getElementById("store_order_time").value;
        var id = document.getElementById("product_" + id).value;
        var qty = document.getElementById("qty_" + id).value;
        var store_order_time_id = store_order_time_id;
        // var remaining = document.getElementById("product"+id+"_remaining").html();
        var remaining_default = $("#product" + id + "_remaining_default").val();
        var remaining = $("#product" + id + "_remaining").text();
        // if (parseInt(qty) <= parseInt(stock)) {
        $.ajax({
            url: "<?php echo base_url(); ?>cart/add",
            method: "POST",
            data: { id: id, qty: qty, store_order_time_id: store_order_time_id, store_order_time: store_order_time },
            success: function(data) {
                $('#cart_details').load("<?php echo base_url(); ?>store/load_cart");
                $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
                $('#coupon').val('');
                // $('#qty_' + id).val('');
                if($('#qty_'+id).attr('max')!='999'){
                    $('#product' + id + '_remaining').text('*餐點剩餘'+(remaining_default - data)+'份');
                }
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
                if(data['reason']!=''){
                    alert(data['reason']);
                }
                $('#load_cart_price').load("<?php echo base_url(); ?>store/load_cart_price");
            },
            error: function(data) {
                alert('Error: '+data);
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
            success: function(data) {
                //
            }
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

    // $(".input-number").keydown(function(e) {
    //     // Allow: backspace, delete, tab, escape, enter and .
    //     if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
    //         // Allow: Ctrl+A
    //         (e.keyCode == 65 && e.ctrlKey === true) ||
    //         // Allow: home, end, left, right
    //         (e.keyCode >= 35 && e.keyCode <= 39)) {
    //         // let it happen, don't do anything
    //         return;
    //     }
    //     // Ensure that it is a number and stop the keypress
    //     if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
    //         e.preventDefault();
    //     }
    // });

    // $(function() {
    //     $('.lazy').lazy();
    // });
    </script>