<style>
    .delete_button_style {
        color: #fff;
        background-color: #CECECE;
        padding: 0px 5px 0px 5px;
        border-radius: 50%;
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
    .border_right {
        border-right: 1px solid #D1D1D1;
    }
    .num_box {
        position: absolute;
        top: 5px;
        left: 5px;
    }
    .delete_box {
        position: absolute;
        bottom: 6px;
        left: 3px;
    }
    .delete_box img {
        width: 150%;
    }
    .subtotal_box {
        position: absolute;
        bottom: 0px;
        right: 0px;
    }
    .subtotal_box span {
        color: #BE2633;
        text-align: right;
        font-size: 22px;
    }
@media (max-width: 767px) {
    .num_box {
        position: absolute;
        top: 5px;
        left: 0px;
    }
    .delete_box {
        position: absolute;
        bottom: 5px;
        left: -4px;
    }
    .delete_box img {
        width: 15px;
    }
    .subtotal_box span {
        color: #BE2633;
        text-align: right;
        font-size: 16px;
    }
}
</style>
<?php $i = 0;if (!empty($this->cart->contents())) {
	foreach ($this->cart->contents() as $items) {
		$i++;?>
<div class="container-fluid p-2" style="border: 1px solid #D3D3D3;" id="mini-cart">
    <div class="row">
        <div class="col-4 border_right">
            <div class="row">
                <div class="col-3 py-2">
                    <div class="container h-100">
                        <div class="row h-100">
                            <div class="col num_box">
                                <span><?=$i?></span>
                            </div>
                            <div class="col delete_box">
                                <span class="mini-cart-x align-text-bottom" style="cursor: pointer;" valign="bottom" id="<?php echo $items["rowid"] ?>">
                                    <img src="/assets/images/web icon_delete.png" alt="">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 py-2 px-0">
                    <?//$image = get_product_combine($items['id'], 'picture');?>
                    <?//php $image = ?>
                    <?//php if ($image != '') {?>
                    <!-- <img style="width: 100%;" src="/assets/uploads/<?php echo $image; ?>" alt="<?//php echo $items['name']; ?>"> -->
                    <?//php }?>
                    <?if ($items['image'] != '') {?>
                        <img style="width: 100%;" src="/assets/uploads/<?=$items['image']?>" alt="<?$items['name']; ?>">
                    <?}?>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="row">
                <div class="col-12 p-2">
                    <span style="font-weight: bold; font-size: 16px;">
                        <?php echo $items['name']; ?>
                    </span>
                    <?$this->db->where('product_combine_id', $items['id']);
                    $query = $this->db->get('product_combine_item');
                    if ($query->num_rows() > 0) {
                        echo '<ul class="pl-3 m-0" style="color: gray;">';
                        foreach ($query->result_array() as $item) {
                            // echo '<li style="list-style-type: circle;">' . get_product_name($item['product_id']) . ' ' . $item['product_unit'] . ' ' . $item['product_specification'] . '</li>';
                            ?>
                                <li style="list-style-type: circle;">
                                <? echo $item['qty'] . ' ' . $item['product_unit'];
                                if (!empty($item['product_specification'])) {
                                    echo ' - '.$item['product_specification'];
                                }
                                if (!empty($items['specification']['specification_id'])) {
                                    $y=0;
                                    $x=0;
                                    $total_qty = $item['qty']*$items['qty'];
                                    echo ' - 共：' . $total_qty . ' ' . $item['product_unit'];
                                    foreach($items['specification']['specification_qty'] as $row){
                                        // if ($items['qty'] > 1) {
                                        //     $specification_qty[$y] = $row*$items['qty'];
                                        // } else {
                                        //     $specification_qty[$y] = $row;
                                        // }
                                        $specification_qty[$y] = $row;
                                        $y++;
                                    }
                                    foreach($items['specification']['specification_name'] as $specification_name){
                                        echo '<br>' . '✓ ' . $specification_name . ' x ' . $specification_qty[$x];
                                        $x++;
                                    }
                                }?>
                                </li>
                                <?}
                        echo '</ul>';
                    }?>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="row h-100">
                <div class="col-12 py-2 pl-0">
                    <div class="container px-0">
                        <div class="row">
                            <div class="col">
                                <div class="input-group">
                                    <?if (!empty($items['specification']['specification_id'])){?>
                                    <span class="input-group-btn" style="display:none;">
                                        <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[<?php echo $items["rowid"] ?>]" id="<?php echo $items["rowid"] ?>">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </span>
                                    <input style="border-radius: 5px" type="text" name="quant[<?php echo $items["rowid"] ?>]" class="form-control input-number input_border_style" value="<?php echo $items['qty']; ?>" min="1" max="100" readonly>
                                    <span class="input-group-btn" style="display:none;">
                                        <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-field="quant[<?php echo $items["rowid"] ?>]" id="<?php echo $items["rowid"] ?>" disabled>
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </span>
                                    <?}else{?>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[<?php echo $items["rowid"] ?>]" id="<?php echo $items["rowid"] ?>">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quant[<?php echo $items["rowid"] ?>]" class="form-control input-number input_border_style" value="<?php echo $items['qty']; ?>" min="1" max="100" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-field="quant[<?php echo $items["rowid"] ?>]" id="<?php echo $items["rowid"] ?>">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </span>
                                    <?}?>
                                </div>
                            </div>
                            <div class="col text-right subtotal_box">
                                <span>
                                    $
                                    <?php echo $items['price']; ?>
                                    <!-- $<?php echo $items['subtotal']; ?> -->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }}?>
<div class="col-12 text-right p-0">
    <hr>
    <span style="font-size: 24px;">總計：<span style="color: #BE2633;">$
            <?php echo $this->cart->total() ?></span></span>
    <hr>
</div>
<div class="row">
    <div class="col-6">
        <spna class="btn btn-block mt-md" style="color: #4E4E4E;background-color: #BCBCBC;" data-dismiss="modal">繼續選購</span>
    </div>
    <div class="col-6">
        <span class="btn btn-block mt-md" style="color: #fff;background-color: #420252;" onclick="view_form_check()">前往 結帳</span>
    </div>
</div>
<script>
$(document).ready(function() {
    $(document).on('click', '.mini-cart-x', function() {
        var rowid = this.id;
        $.ajax({
            url: "/cart/remove",
            method: "POST",
            data: { rowid: rowid },
            success: function(data) {
                get_mini_cart();
            }
        });
    });
});
</script>
<!-- NumberBtn -->
<script>
$('#mini-cart .btn-number').click(function(e) {
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
        var rowid = this.id;
        $.ajax({
            url: "/cart/update_qty",
            method: "POST",
            data: { rowid: rowid, qty: input.val() },
            success: function(data) {
                get_mini_cart();
            }
        });
    } else {
        input.val(0);
    }
});
$('#mini-cart .input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('#mini-cart .input-number').change(function() {
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
$("#mini-cart .input-number").keydown(function(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>
<!-- NumberBtn -->