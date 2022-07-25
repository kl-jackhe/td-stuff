<table class="table table-striped table-hover" id="mini-cart">
    <?php if(!empty($this->cart->contents())) { foreach ($this->cart->contents() as $items){ ?>
    <tr>
        <td>
            <span class="mini-cart-x" id="<?php echo $items["rowid"] ?>" style="color: #FF5151"><i class="fa-solid fa-trash-can"></i></span>
        </td>
        <td>
            <div class="row">
                <div class="col-3">
                    <?php if($items['image']!='') { ?>
                        <img style="width: 100%;" src="/assets/uploads/<?php echo $items['image']; ?>" alt="<?php echo $items['name']; ?>">
                    <?php } ?>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-12">
                            <span style="font-weight: bold; font-size: 18px;"><?php echo $items['name']; ?></span>
                            <!-- <ul class="pl-3 m-0" style="color:gray;">
                                <li style="list-style-type: circle;">黑色保溫杯</li>
                                <li style="list-style-type: circle;">黃色保溫杯</li>
                            </ul> -->
                        </div>
                        <div class="col-12">
                            <span style="color: red;text-align: right; font-size: 22px;">
                                $<?php echo $items['price']; ?>
                                <!-- $<?php echo $items['subtotal']; ?> -->
                            </span>
                        </div>
                        <div class="col-6 col-sm-5">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" style="padding: 0px 5px 0px 5px;border-radius: 5px 0px 0px 5px;" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]" id="<?php echo $items["rowid"] ?>">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                </span>
                                <input type="text" name="quant[2]" style="padding: 0px;height: 26px;text-align: center;" class="form-control input-number" value="<?php echo $items['qty']; ?>" min="1" max="100" disabled>
                                <span class="input-group-btn">
                                    <button type="button" style="padding: 0px 5px 0px 5px; border-radius: 0px 5px 5px 0px;" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]" id="<?php echo $items["rowid"] ?>">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php }} ?>
</table>
<div class="col-12 text-right">
    <hr>
    <span style="font-size: 24px;">總計：<span style="color:red;">$<?php echo $this->cart->total() ?></span></span>
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