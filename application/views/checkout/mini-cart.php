<style>
    .delete_button_style {
        color: #fff;
        background-color: #CECECE;
        padding: 0px 4px 0px 4px;
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
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
<?php $i = 0;if (!empty($this->cart->contents())) {foreach ($this->cart->contents() as $items) {$i++;?>
<div class="container-fluid p-2" style="border: 1px solid #D3D3D3;" id="mini-cart">
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-3 py-2">
                    <div class="container h-100">
                        <div class="row h-100">
                            <div class="col" style="position: absolute;top: 5px;left: 5px;">
                                <span><?=$i?></span>
                            </div>
                            <div class="col" style="position: absolute;bottom: 5px;left: 0px;">
                                <span class="mini-cart-x delete_button_style align-text-bottom" valign="bottom" id="<?php echo $items["rowid"] ?>"><i class="fa-solid fa-xmark"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 py-2 pl-0">
                    <?php if ($items['image'] != '') {?>
                    <img style="width: 100%;" src="/assets/uploads/<?php echo $items['image']; ?>" alt="<?php echo $items['name']; ?>">
                    <?php }?>
                    <div class="container h-100 border_right">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="row">
                <div class="col-12 py-2">
                    <span style="font-weight: bold; font-size: 16px;">
                        <?php echo $items['name']; ?></span>
                    <!-- <ul class="pl-3 m-0" style="color:gray;">
                        <li style="list-style-type: circle;">黑色保溫杯</li>
                        <li style="list-style-type: circle;">黃色保溫杯</li>
                    </ul> -->
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
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[2]" id="<?php echo $items["rowid"] ?>">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quant[2]" class="form-control input-number input_border_style" value="<?php echo $items['qty']; ?>" min="1" max="100" disabled>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-field="quant[2]" id="<?php echo $items["rowid"] ?>">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col text-right" style="position: absolute; bottom: 0px; right: 0px;">
                                <span style="color: #BE2633;text-align: right; font-size: 22px;">
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