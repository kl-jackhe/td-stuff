<div role="main" class="main product-view">
    <section class="form-section content_auto_h">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <?php if (!empty($product)) { ?>
                    <div class="col-md-8 text-center product_description" style="margin-bottom: 35px;">
                        <? if ($this->is_td_stuff) { ?>
                            <img src="/assets/uploads/Banner/page_banner_free_shipping_1000-1.jpg">
                        <? } ?>
                    </div>
                    <div class="col-md-8 text-center product_description">
                        <p class="m-0">
                            <span class="productViewTitle"><?= $product['product_name'] ?></span>
                            <span id="jumpToCombine" class="transitionAnimation jumpToCombine productViewTitle"><i class="fa fa-caret-square-down" aria-hidden="true"></i>&nbsp;跳至方案選擇</span>
                        </p>
                    </div>
                    <div class="col-md-8 text-center product_description">
                        <div id="dynamicCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
                            <div class="carousel-inner">
                                <!-- Carousel items will be dynamically added here -->
                                <?= (!empty($product['product_description']) ? $product['product_description'] : '<h3>暫無商品描述</h3>') ?>
                            </div>
                            <a class="carousel-control-prev" href="#dynamicCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#dynamicCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            <ol class="carousel-indicators" style="bottom: 50px;">
                                <!-- Dynamic carousel-indicators -->
                            </ol>
                        </div>
                        <? if ($this->is_liqun_food) : ?>
                            <div class="reminderGraph">
                                <img src="../../../assets/fixed-graph/page_reminder-shopping.jpg" alt="page_cooking-1" />
                                <img src="../../../assets/fixed-graph/page_reminder.jpg" alt="page_cooking-1" />
                            </div>
                        <? else : ?>
                            <p class="m-0" style="font-size: 28px;">
                                <?= $product['product_note'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="col-md-8 text-center product_description" style="margin-bottom: 35px;">
                        <? if ($this->is_td_stuff) { ?>
                            <p><img src="/assets/uploads/Banner/page_banner_free_shipping_1000-1.jpg"></p>
                        <? } ?>
                    </div>
                    <div class="col-md-12 text-center" id="selectCombine">
                        <p class="m-0" style="font-size: 28px;">方案選擇</p>
                    </div>
                    <input type="hidden" name="weight" id="weight" value="<?php echo $product_unit['weight'] ?>">
                    <div class="col-md-8 py-3">
                        <div class="row justify-content-center">
                            <?php if (!empty($product_combine)) {
                                foreach ($product_combine as $combine) {
                                    $inventory = 0;
                                    if (!empty($product_combine_item)) {
                                        foreach ($product_combine_item as $pci_row) {
                                            if ($combine['id'] == $pci_row['product_combine_id']) {
                                                $inventory = $pci_row['qty'];
                                            }
                                        }
                                    } ?>
                                    <div class="col-md-4 py-2 mb-5 text-center">
                                        <img id="zoomA" class="product_view_img_style" src="/assets/uploads/<?= (!empty($combine['picture']) ? $combine['picture'] : 'Product/img-600x600.png'); ?>">
                                        <div class="pt-2" style="font-size: 16px;">
                                            <?= $combine['name']; ?>
                                        </div>
                                        <? if (!empty($combine['description'])) { ?>
                                            <div class="py-2" style="font-size: 12px;">
                                                <?= $combine['description']; ?>
                                            </div>
                                        <? } ?>
                                        <div>
                                            <?php if ($combine['price'] != $combine['current_price'] && $combine['price'] != 0) { ?>
                                                <span style="color: gray;font-size: 14px;font-style: oblique;text-decoration: line-through;">原價
                                                    <span style="color: gray;font-size: 14px;font-style: oblique;">&nbsp;$
                                                        <?= $combine['price']; ?>
                                                    </span>
                                                </span>
                                                <br>
                                            <? } ?>
                                            <span style="color:#BE2633; font-size: 16px; font-weight: bold;font-style: oblique;">方案價
                                                <span style="color:#BE2633; font-size: 16px; font-weight: bold;font-style: oblique;">&nbsp;$
                                                    <?= $combine['current_price']; ?>
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
                                            <? if ($combine['type'] == 1) { ?>
                                                <!-- 任意選取規格 -->
                                                <div>
                                                    <? $product_combine_item_qty = $this->product_model->get_product_combine_item($combine['id']); ?>
                                                </div>
                                                <? if (($product['sales_status'] == 0 || $product['sales_status'] == 2) && ($product['inventory'] >= $inventory || $product['excluding_inventory'] == true || $product['stock_overbought'] == true)) { ?>
                                                    <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn add_product" data-toggle="modal" data-target="#multitude_specification_modal_<?php echo $combine['id'] ?>">
                                                        <i class="fa-solid fa-cart-shopping"></i> 選擇規格
                                                    </button>
                                                <? } else { ?>
                                                    <span class="btn add_product" style="background: #817F82;cursor: auto;">
                                                        <i class="fa-solid fa-cart-shopping" disabled></i> 售完
                                                    </span>
                                                <? } ?>
                                                <form action="/cart/add_multitude_specification" id="multitude_specification" method="POST">
                                                    <div class="modal fade" id="multitude_specification_modal_<?php echo $combine['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="multitude_specification_Label" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <p class="modal-title text-left" id="multitude_specification_Label">選擇規格
                                                                        <br>
                                                                        <span style="font-size: 18px;font-weight: bold;">
                                                                            <? if (!empty($combine['description'])) { ?>
                                                                                <span><? echo $combine['description']; ?>&ensp;</span>
                                                                            <? } ?>
                                                                            請選擇 <span class="total_qty"></span> 樣
                                                                        </span>
                                                                    </p>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <? if (!empty($specification)) {
                                                                        foreach ($specification as $row) {
                                                                            if ($row['status'] != 99) { ?>
                                                                                <div class="input-group my-3">
                                                                                    <div style="width: 25%;">
                                                                                        <img class="product_view_img_style" src="/assets/uploads/<?php echo $row['picture']; ?>">
                                                                                    </div>
                                                                                    <div style="width: 45%;position: relative;">
                                                                                        <div style="position: absolute;bottom: 10px;left: 20px;font-size: 18px;font-weight: bold;">
                                                                                            <?= $row['specification']; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="input-group" style="width: 30%;">
                                                                                        <div class="input-group" style="position: absolute;bottom: 10px;">
                                                                                            <? if ($row['status'] == 0) {
                                                                                                if ($row['limit_enable'] == 'YES' && $combine['limit_enable'] == 'YES') { ?>
                                                                                                    <p class="text-center" style="color: #C52B29;font-weight: bold;width: 100%;">選購 <span class="limit_qty"></span> 組 x 限購數量 <?= $row['limit_qty'] ?></p>
                                                                                                    <span class="input-group-btn">
                                                                                                        <button onclick="specification_limit_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>,<?= $row['limit_qty'] ?>,<?= $row['id'] ?>)" type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="<?php echo $row['id'] . '_' . $combine['id'] ?>">
                                                                                                            <i class="fa-solid fa-minus"></i>
                                                                                                        </button>
                                                                                                    </span>
                                                                                                    <input type="text" name="<? echo $combine['id'] . 'specification_qty[]' ?>" id="<?php echo $row['id'] . '_' . $combine['id'] ?>" class="form-control input-number input_border_style" value="0" min="0" max="100" readonly>
                                                                                                    <span class="input-group-btn">
                                                                                                        <button onclick="specification_limit_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>,<?= $row['limit_qty'] ?>,<?= $row['id'] ?>)" type="button" class="btn btn-number button_border_style_r select_qty_button" data-type="plus" data-field="<?php echo $row['id'] . '_' . $combine['id'] ?>">
                                                                                                            <i class="fa-solid fa-plus"></i>
                                                                                                        </button>
                                                                                                    </span>
                                                                                                <? } else { ?>
                                                                                                    <span class="input-group-btn">
                                                                                                        <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn btn-number button_border_style_l" data-type="minus" data-field="<?php echo $row['id'] . '_' . $combine['id'] ?>">
                                                                                                            <i class="fa-solid fa-minus"></i>
                                                                                                        </button>
                                                                                                    </span>
                                                                                                    <input type="text" name="<? echo $combine['id'] . 'specification_qty[]' ?>" id="<?php echo $row['id'] . '_' . $combine['id'] ?>" class="form-control input-number input_border_style" value="0" min="0" max="100" readonly>
                                                                                                    <span class="input-group-btn">
                                                                                                        <button onclick="specification_qty(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" type="button" class="btn btn-number button_border_style_r select_qty_button" data-type="plus" data-field="<?php echo $row['id'] . '_' . $combine['id'] ?>">
                                                                                                            <i class="fa-solid fa-plus"></i>
                                                                                                        </button>
                                                                                                    </span>
                                                                                                <? } ?>
                                                                                            <? } else { ?>
                                                                                                <span class="text-center" style="color: #C52B29;font-weight: bold;width: 100%;">已售完</span>
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="<? echo $combine['id'] . 'specification_name[]' ?>" value="<?php echo $row['specification'] ?>">
                                                                                    <input type="hidden" name="<? echo $combine['id'] . 'specification_id[]' ?>" value="<?php echo $row['id'] ?>">
                                                                                </div>
                                                                    <? }
                                                                        }
                                                                    } else {
                                                                        echo '尚無規格可以選擇！';
                                                                    } ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div>選購數量 <span class="select_qty"></span> / <span class="total_qty"></span></div>
                                                                </div>
                                                                <input type="hidden" name="combine_id" value="<?php echo $combine['id'] ?>">
                                                                <div class="modal-footer">
                                                                    <? if ($product['sales_status'] == 0 || $product['sales_status'] == 2) { ?>
                                                                        <span class="btn add_product" onclick="select_qty_ok_add_cart(<?php echo $combine['id'] ?>,<?php echo $product_combine_item_qty['qty'] ?>)" style="<?= ($product['sales_status'] == 2 || ($product['inventory'] < $inventory && $product['stock_overbought'] == true) ? 'background: #A60747;' : '') ?>">
                                                                            <i class="fa-solid fa-cart-shopping"></i>
                                                                            <? if ($product['inventory'] < $inventory && $product['stock_overbought'] == true) {
                                                                                echo '預購';
                                                                            } else {
                                                                                echo ($product['sales_status'] == 0 ? '選購' : '預購');
                                                                            } ?>
                                                                        </span>
                                                                    <? } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- 任意選取規格 -->
                                                <? } else {
                                                if (($product['sales_status'] == 0 || $product['sales_status'] == 2) && ($product['inventory'] >= $inventory || $product['excluding_inventory'] == true || $product['stock_overbought'] == true)) { ?>
                                                    <button onclick="add_cart(<?php echo $combine['id'] ?>, '<?= $combine['limit_enable'] ?>', <?php echo $combine['limit_qty'] ?>)" type="button" class="btn add_product" style="<?= ($product['sales_status'] == 2 || ($product['inventory'] < $inventory && $product['stock_overbought'] == true) ? 'background: #A60747;' : '') ?>">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                        <? if ($product['inventory'] < $inventory && $product['stock_overbought'] == true) {
                                                            echo '預購';
                                                        } else {
                                                            echo ($product['sales_status'] == 0 ? '選購' : '預購');
                                                        } ?>
                                                    </button>
                                                <? } else { ?>
                                                    <span class="btn add_product" style="background: #817F82;cursor: auto;">
                                                        <i class="fa-solid fa-cart-shopping" disabled></i> 售完
                                                    </span>
                                            <? }
                                            } ?>
                                        </div>
                                    </div>
                            <? }
                            } ?>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </section>
</div>
<!-- Jump to the combine select -->
<script>
    $(document).ready(function() {
        // 给 span 元素添加点击事件
        $("#jumpToCombine").on("click", function() {
            // 使用 jQuery 动画效果滚动到目标
            $("html, body").animate({
                scrollTop: $("#selectCombine").offset().top
            }, 1000); // 1000 是滚动的时间，以毫秒为单位
        });
    });
</script>

<!-- Initial carousel -->
<script>
    $(document).ready(function() {
        $('.carousel-control-prev, .carousel-control-next, .carousel-indicators').css('display', 'none');
    })
</script>

<!-- Carousel -->
<script>
    // $(document).ready(function() {
    //     var productDescription = '';
    //     try {
    //         // 假设 $product['product_description'] 包含 HTML 内容
    //         productDescription = '<?= $product["product_description"] ?>';
    //     } catch (error) {
    //         console.error('Error fetching product description:', error);
    //         // 在這裡可以執行一些替代操作，或者忽略錯誤繼續執行
    //     }

    //     var matches = [];
    //     // 使用 jQuery 解析 HTML 内容并提取所有图片路径
    //     $(productDescription).find('img').each(function() {
    //         matches.push($(this).attr('src'));
    //     });

    //     // 如果没有在 <p> 中找到图像，尝试直接查找图像标记
    //     if (matches.length === 0) {
    //         $(productDescription).filter('img').each(function() {
    //             matches.push($(this).attr('src'));
    //         });
    //     } else {
    //         $('p img').each(function() {
    //             this.style.setProperty('display', 'none', 'important');
    //         });
    //         $('.carousel-control-prev, .carousel-control-next, .carousel-indicators').css('display', '');
    //     }



    //     $('p img').each(function() {
    //         this.style.setProperty('display', 'none', 'important');
    //     });

    //     // 创建 Carousel
    //     var carouselInner = $("#dynamicCarousel .carousel-inner");
    //     var carouselIndicators = $("#dynamicCarousel .carousel-indicators");


    //     $.each(matches, function(index, imagePath) {
    //         var item = $("<div>").addClass("carousel-item");
    //         if (index === 0) {
    //             item.addClass("active");
    //         }

    //         var img = $("<img>").attr("src", imagePath);

    //         item.append(img);
    //         carouselInner.append(item);

    //         // 创建相应的 carousel indicator
    //         var indicator = $("<li>")
    //             .attr({
    //                 'data-target': "#dynamicCarousel",
    //                 'data-slide-to': index
    //             })
    //             .addClass(index === 0 ? 'active' : '');

    //         carouselIndicators.append(indicator);
    //     });
    // });
</script>

<script>
    function add_cart(combine_id, limit_enable = 'NO', limit_qty = 0) {
        var weight = $('#weight').val();
        console.log('weight = ' + weight);
        var qty = document.getElementById("qty_" + combine_id).value;
        if (limit_enable == 'YES' && parseInt(qty) > parseInt(limit_qty)) {
            alert('商品數量不得超過' + limit_qty + '個');
            return;
        }
        var form = $('#multitude_specification');
        var url = form.attr('action');
        var specification_name = $("input[name='" + combine_id + "specification_name[]']").map(function() {
            return $(this).val();
        }).get();
        var specification_id = $("input[name='" + combine_id + "specification_id[]']").map(function() {
            return $(this).val();
        }).get();
        var specification_qty = $("input[name='" + combine_id + "specification_qty[]']").map(function() {
            return $(this).val();
        }).get();
        $.ajax({
            url: "/cart/add_combine",
            method: "POST",
            data: {
                combine_id: combine_id,
                qty: qty,
                weight: weight,
                specification_id: specification_id,
                specification_qty: specification_qty,
            },
            success: function(data) {
                if (data == 'contradiction') {
                    alert('預購商品不得與其他類型商品一並選購，敬請見諒。');
                } else if (data == 'exceed') {
                    alert('超過限制數量故無法下單，敬請見諒');
                } else if (data == 'weight_exceed') {
                    alert('超過限制重量故無法下單，敬請見諒');
                } else if (data == 'updateSuccessful') {
                    alert('成功更新購物車');
                } else if (data == 'successful') {
                    alert('成功加入購物車');
                } else {
                    console.log(data);
                }
                get_cart_qty();
            }
        });
    }
    // 限購數量判斷
    function specification_limit_qty(combine_id, product_combine_item, limit_qty, id) {
        var qty = document.getElementById("qty_" + combine_id).value;
        var limit_id = id + '_' + combine_id;
        var total_qty = qty * product_combine_item;
        var limit_qty_total = limit_qty * qty;
        $('.limit_qty').html(qty);
        $('.total_qty').html(total_qty);
        setTimeout(function() {
            $("#" + limit_id).attr({
                "max": limit_qty_total,
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
    function specification_qty(combine_id, product_combine_item) {
        var qty = document.getElementById("qty_" + combine_id).value;
        var total_qty = qty * product_combine_item;
        $('.limit_qty').html(qty);
        $('.total_qty').html(total_qty);
        setTimeout(function() {
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
        let qty_sum = $("input[name='" + combine_id + "specification_qty[]']").map(function() {
            return $(this).val();
        }).get();
        let select_qty_sum = 0;
        for (var i = 0; i < qty_sum.length; i++) {
            select_qty_sum = select_qty_sum + qty_sum.map(Number)[i];
        }
        return select_qty_sum;
    }

    function select_qty_ok_add_cart(combine_id, product_combine_item) {
        var total_qty = specification_qty(combine_id, product_combine_item);
        var qty_sum = select_qty(combine_id);
        if (total_qty == qty_sum) {
            add_cart(combine_id);
            $('#multitude_specification_modal_' + combine_id).modal('toggle');
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
        setTimeout(function() {
            $("input[name='" + combine_id + "specification_qty[]']").val('0');
            $('#qty_' + combine_id).val('1');
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