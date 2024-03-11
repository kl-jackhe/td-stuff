<div class="cartList row justify-content-center">
    <!-- 一般商品 ----------------------------------------------------------------------------------------------------------------------------------------->
    <section>
        <h3 class="mt-0">您共選擇【<?= count($this->cart->contents()) ?> 個項目】</h3>
        <table class="table table-hover m_table_none">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-nowrap" style="width: 20%;">圖片</th>
                    <th scope="col" class="text-nowrap">商品</th>
                </tr>
            </thead>
            <tbody>
                <? $i = 1;
                foreach ($this->cart->contents() as $items) :
                    $add_disabled = '';
                    if (!empty($this->product_model->getProductCombine($items["id"]))) {
                        $self = $this->product_model->getProductCombine($items["id"]);
                        $is_lottery = $this->mysql_model->_select('lottery', 'product_id', $self['product_id'], 'row');
                        if (!empty($is_lottery)) {
                            $add_disabled = 'disabled';
                        }
                    }
                ?>
                    <tr class="cartListBorder">
                        <td><?= $i++ ?></td>
                        <td>
                            <? $image = get_product_combine($items['id'], 'picture'); ?>
                            <? if ($image != '') : ?>
                                <img class="checkoutImg" src="/assets/uploads/<?php echo $image; ?>" alt="<?php echo $items['name']; ?>">
                            <? endif; ?>
                        </td>
                        <td>
                            <p><?php echo $items['name']; ?></p>
                            <p>金額：$ <?php echo $items['price']; ?></p>
                            <p>
                                數量：
                                <span class="input-group-btn inlineBlock">
                                    <button type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="quant[<?php echo $items["rowid"] ?>]" data-reword-id="<?php echo $items["rowid"] ?>">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                </span>
                                <input type="text" name="quant[<?php echo $items["rowid"] ?>]" class="input_border_style inlineBlock qtyInputBox" value="<?php echo $items['qty']; ?>" data-reword-id="<?php echo $items["rowid"] ?>" min='1' max='100' <?= $add_disabled ?>>
                                <span class="input-group-btn inlineBlock">
                                    <button type="button" class="btn btn-number button_border_style_r" data-type="plus" data-weight="<?= !empty($items['options']['weight']) ? $items['options']['weight'] : 0; ?>" data-field="quant[<?php echo $items["rowid"] ?>]" data-reword-id="<?php echo $items["rowid"] ?>" <?= $add_disabled ?>>
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </span>
                            </p>
                            <p>小計：<span style="color: #dd0606">$ <?php echo $items['subtotal']; ?></span></p>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <span class="cartCashPosition">購物車小計：
            <span>&nbsp;$<?php echo  $this->cart->total() ?></span>
        </span>
    </section>
</div>