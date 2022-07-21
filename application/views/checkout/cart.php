<?php $subtotal = 0;
$count = 0;
foreach ($this->cart->contents() as $items) {
	$count++;
}?>
<div role="main" class="main">
    <section class="form-section">
        <div class="container-fluid">
            <?php $attributes = array('class' => 'view', 'id' => 'view_form');?>
            <?php echo form_open('checkout', $attributes); ?>
            <div class="row" style="padding-left: 25px;padding-right: 25px;">
                <div class="col-12 col-md-9 px-4">
                    <h4>您共選擇 (
                        <?=$count?> 項目 )</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-nowrap">商品</th>
                                    <th scope="col" class="text-nowrap">價格</th>
                                    <th scope="col" class="text-nowrap">數量</th>
                                    <th scope="col" class="text-nowrap">小計</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                <?php foreach ($this->cart->contents() as $items): ?>
                                <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                                <tr>
                                    <td>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </td>
                                    <td>
                                        <?php echo $items['name']; ?>
                                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                        <p>
                                            <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                            <strong>
                                                <?php echo $option_name; ?>:</strong>
                                            <?php echo $option_value; ?><br />
                                            <?php endforeach;?>
                                        </p>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?php echo $this->cart->format_number($items['price']); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                                    </td>
                                    <td>$
                                        <?php echo $this->cart->format_number($items['subtotal']); ?>
                                    </td>
                                </tr>
                                <?php $i++;?>
                                <?php $subtotal = $subtotal + $this->cart->format_number($items['subtotal']);?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-end">
                        <button class="btn-danger btn font-weight-bold">清除全部</button>
                        <button class="btn-success btn mx-4 font-weight-bold">更新購物車</button>
                    </div>
                </div>
                <div class="col-12 col-md-3 px-4">
                    <h4>購物車總計</h4>
                    <div class="row">
                        <hr style="border-top: 1px solid gray;width: 100%;">
                        <div class="col-6">
                            <label class="col-form-label">小計</label>
                        </div>
                        <div class="col-6 text-right text-danger">
                            $
                            <?=$subtotal?>
                        </div>
                        <hr style="border-top: 1px solid gray;width: 100%;">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="col-form-label">運送方式</label>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="" id="">
                                <option value="">超商取貨</option>
                                <option value="">宅配</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="border-top: 1px solid gray;width: 100%;">
                        <div class="col-6">
                            <label class="col-form-label">總計</label>
                        </div>
                        <div class="col-6 text-right text-danger">
                            $
                            <?=$subtotal?>
                        </div>
                        <hr style="border-top: 1px solid gray;width: 100%;">
                    </div>
                    <span class="btn btn-info btn-block mt-md" onclick="view_form_check()">前往結帳</span>
                    <!-- <div class="col-12 btn-primary btn font-weight-bold">前往結帳</div> -->
                    <a href="/product" class="col-12 btn-dark btn my-4 font-weight-bold">繼續選購商品 <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </section>
</div>
<script>
function getLiffUserID() {
    if (LIFF_userID != "") {
        alert(LIFF_userID);
    } else {
        console.log("等候LIFF加載...");
        setTimeout("getLiffUserID()", 300);
    }
};

function view_form_check() {
    $.ajax({
        url: "<?php echo base_url(); ?>cart/check_cart_is_empty",
        method: "GET",
        data: {},
        success: function(data) {
            if (data > 0) {
                // $.ajax({
                //     url: "<?php echo base_url(); ?>store/cart_price_check",
                //     method: "GET",
                //     data: { },
                //     success: function(data) {
                //         if(data=='yes'){
                //             $('#view_form').submit();
                //         } else {
                //             alert('購物車金額需滿'+data+'元，才能結帳。');
                //         }
                //     }
                // });
                $('#view_form').submit();
            } else {
                alert('購物車是空的，請添加商品。');
            }
        }
    });
}
</script>