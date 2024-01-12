<style>
    <? for ($i = 1; $i <= 6; $i++) { ?>.image-link-<?= $i ?>:hover img {
        content: url('/assets/images/liqun/index_icon_pots-<?= $i ?>a.png');
    }
    <?
    }
    ?>
</style>
<div role="main" class="main">
    <section class="content_auto_h">
        <div class="container">
            <div class="row justify-content-center py-3">
                <div class="col-10 col-md-4">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                        </div>
                        <div class="col-md-8" style="position: relative;">
                            <div class="fridge_style">
                                <div class="py-2" id="fridge_box">
                                    <i class="fa-solid fa-bars"></i>&ensp;冰箱裡有什麼？
                                </div>
                                <div class="row justify-content-center" id="fridge_item">
                                    <div class="col-md-12 py-3"><a href="#">新春年菜&ensp;強強滾</a></div>
                                    <div class="col-md-12 py-3"><a href="#">餐廳美食&ensp;帶回家</a></div>
                                    <div class="col-md-12 py-3"><a href="#">嚴格挑選&ensp;頂級牛</a></div>
                                    <div class="col-md-12 py-3"><a href="#">露營必備&ensp;不可少</a></div>
                                    <div class="col-md-12 py-3"><a href="#">即食加熱&ensp;超便利</a></div>
                                    <div class="col-md-12 py-3"><a href="#">烤肉必備&ensp;香噴噴</a></div>
                                    <div class="col-md-12 py-3"><a href="#">低卡蔬食&ensp;輕食區</a></div>
                                    <div class="col-md-12 py-3"><a href="#">常溫可食&ensp;免煩惱</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10 col-md-8" style="position: relative;top: 20px;">
                    <div class="row justify-content-end">
                        <div class="col-md-8">
                            <div id="search_box">
                                <div class="tb">
                                    <div class="td">
                                        <input type="text" id="SearchContent" placeholder="嫩肩菲力" required>
                                    </div>
                                    <div class="td text-right">
                                        <span id="searchAllProduct" onClick="searchAllProduct()">
                                            <a>搜尋 <i class="fa-solid fa-magnifying-glass"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 py-3">
                            <div class="tag_item">
                                熱門 >> <a href="#">千層生乳吐司</a> ｜ <a href="#">紅龍雞塊</a> ｜ <a href="#">卜蜂炒飯</a> ｜ <a href="#">紅燒牛肉湯</a> ｜ <a href="#">挪威頂級鯖魚</a> ｜ <a href="#">醬醃蛤蠣</a> ｜ <a href="#">起司千層派</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="background-color: #e7e6e6;padding-bottom: 10px;padding-top: 10px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 px-0">
                        <? if (!empty($banner)) { ?>
                            <div id="home-carousel" class="carousel slide carousel-fade" data-touch="false" data-interval="false">
                                <ol class="carousel-indicators" style="bottom: -20px;">
                                    <? for ($i = 0; $i < count($banner); $i++) { ?>
                                        <li data-target="#home-carousel" data-slide-to="<?= $i ?>" <?= ($i == 0 ? 'class="active"' : '') ?>></li>
                                    <? } ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php $count = 0;
                                    foreach ($banner as $data) { ?>
                                        <div class="carousel-item <?= ($count == 0 ? 'active' : '') ?>">
                                            <a href="<?= $data['banner_link'] ?>" target="<?= ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                                                <img class="d-block" style="width: 100%;max-height: 500px;" src="/assets/uploads/<?= $data['banner_image'] ?>">
                                            </a>
                                        </div>
                                    <?php $count++;
                                    } ?>
                                </div>
                                <!-- <a class="carousel-control-prev" href="#home-carousel" role="button" data-slide="prev" style="font-size: 24px;">
                                <i class="fa-solid fa-circle-chevron-left" aria-hidden="true"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#home-carousel" role="button" data-slide="next" style="font-size: 24px;">
                                <i class="fa-solid fa-circle-chevron-right" aria-hidden="true"></i>
                                <span class="sr-only">Next</span>
                            </a> -->
                            </div>
                        <? } ?>
                        <div id="searchProductResults"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center py-5">
                <!-- <? for ($i = 1; $i <= 6; $i++) { ?>
                    <div class="col-5 col-md-2 my-3">
                        <a href="#" class="image-link-<?= $i ?>">
                            <img src="/assets/images/liqun/index_icon_pots-<?= $i ?>.png" class="img-fluid">
                        </a>
                    </div>
                <? } ?> -->
                <? if (!empty($main_product_category)) {
                    $count = 0;
                    foreach ($main_product_category as $mpc_row) {
                        $count++; ?>
                        <div class="col-5 col-md-2 my-3">
                            <a href="/product?cid=<?= $mpc_row['product_category_id'] ?>" style="text-decoration: none;" class="image-link-<?= $count ?>">
                                <img src="<?= $mpc_row['product_category_image'] ?>" class="img-fluid">
                            </a>
                        </div>
                <? }
                } ?>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9 col-md-3 text-center pb-4 mb-4">
                    <img src="/assets/images/liqun/index_icon_title-1.png" class="img-fluid">
                </div>
                <div class="col-md-12 text-center">
                    <div class="row justify-content-center product_box_list" id="home_product">
                        <? if (!empty($limited_time_products)) {
                            $count = 0;
                            foreach ($limited_time_products as $product) {
                                if ($count < 4) { ?>
                                    <div class="col-md-3 pb-4 ipad_w">
                                        <a href="/product/view/<?= $product['product_id'] ?>">
                                            <img id="zoomA" class="product_img_style" src="/assets/uploads/<?= (!empty($product['picture']) ? $product['picture'] : 'Product/img-600x600.png') ?>">
                                            <div class="product_name">
                                                <span><?= $product['product_name']; ?></span>
                                            </div>
                                            <input type="hidden" name="countdown_count[]" value="<?= $count ?>">
                                            <input type="hidden" name="countdown_limited_time[]" value="<?= $product['discontinued_at'] ?>">
                                            <div id="countdown_<?= $count ?>" style="background-color: #7f0d20;display: inline-block;padding: 3px 15px 3px 15px;border-radius: 15px;color: #fff;font-weight: bold; margin-top: 10px; margin-bottom: 10px;"></div>
                                            <br>
                                            <span style="color:#bf0029; font-size: 16px; font-weight: bold;font-style: oblique;">
                                                <span style="color:#bf0029; font-size: 16px; font-weight: bold;font-style: oblique;">$
                                                    <?= $product['current_price']; ?>
                                                </span>
                                            </span>
                                            <?php if ($product['price'] != $product['current_price'] && $product['price'] != 0) { ?>
                                                <span style="color: gray;font-size: 12px;font-style: oblique;text-decoration: line-through;">原價
                                                    <span style="color: gray;font-size: 12px;font-style: oblique;"> $
                                                        <?= $product['price']; ?>
                                                    </span>
                                                </span>
                                            <? } ?>
                                        </a>
                                    </div>
                        <? }
                                $count++;
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div style="background-color: #f5f0e7;margin-top: 54px;margin-bottom: 54px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-9 col-md-3 text-center py-4 mb-4">
                        <img src="/assets/images/liqun/index_icon_title-2.png" class="img-fluid">
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="row justify-content-center product_box_list" id="home_product">
                            <? if (!empty($product_combine)) {
                                $count = 0;
                                foreach ($product_combine as $product) {
                                    if ($count < 6) { ?>
                                        <div class="col-md-2 pb-4 ipad_w">
                                            <a href="/product/view/<?= $product['product_id'] ?>">
                                                <img id="zoomA" class="product_img_style" src="/assets/uploads/<?= (!empty($product['picture']) ? $product['picture'] : 'Product/img-600x600.png') ?>">
                                                <div class="product_name">
                                                    <span><?= $product['product_name']; ?></span>
                                                </div>
                                                <div class="product_combine_name my-2">
                                                    <span><?= $product['product_combine_name']; ?></span>
                                                </div>
                                                <span style="color:#bf0029; font-size: 16px; font-weight: bold;font-style: oblique;">
                                                    <span style="color:#bf0029; font-size: 16px; font-weight: bold;font-style: oblique;">$
                                                        <?= $product['current_price']; ?>
                                                    </span>
                                                </span>
                                                <?php if ($product['price'] != $product['current_price'] && $product['price'] != 0) { ?>
                                                    <span style="color: gray;font-size: 12px;font-style: oblique;text-decoration: line-through;">原價
                                                        <span style="color: gray;font-size: 12px;font-style: oblique;"> $
                                                            <?= $product['price']; ?>
                                                        </span>
                                                    </span>
                                                <? } ?>
                                            </a>
                                        </div>
                            <? }
                                    $count++;
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-9 col-md-3 text-center py-4 mb-4">
                    <img src="/assets/images/liqun/index_icon_title-3.png" class="img-fluid">
                </div>
                <div class="col-12 text-justify liqunHomeCategoryOuter">
                    <?php if (!empty($product_category)) {
                        $count = 0;
                        foreach ($product_category as $pc_row) { ?>
                            <a href="/product?cid=<?= $pc_row['product_category_id'] ?>" style="text-decoration: none;">
                                <span class="text-center liqunHomeCategory"><?= $pc_row['product_category_name'] ?></span>
                            </a>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        var countdown_count = $('input[name="countdown_count[]"]').map(function() {
            return $(this).val();
        }).get();
        var countdown_limited_time = $('input[name="countdown_limited_time[]"]').map(function() {
            return $(this).val();
        }).get();
        countdown_count.forEach((count, index) => {
            const endTime = new Date(countdown_limited_time[index]).getTime();
            const updateCountdown = () => {
                const now = new Date().getTime();
                const distance = endTime - now;
                const countdownElement = $('#countdown_' + count);

                if (distance <= 0) {
                    countdownElement.html('已結束！');
                } else {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownElement.html(`限量倒數 ${days} 天 ${hours} : ${minutes} : ${seconds}`);
                }
            };
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });

        $('#SearchContent').on('keyup', function(event) {
            // 檢查按下的鍵是否是 Enter 鍵 (keyCode 13 代表 Enter)
            if (event.keyCode === 13) {
                // 模擬點擊按鈕事件
                $('#searchAllProduct').click();
            }
        });
    });

    function searchAllProduct() {
        $.ajax({
            type: "POST",
            url: '/home/searchAllProduct',
            // dataType: 'json',
            data: {
                keywords: $('#SearchContent').val(),
            },
            success: function(data) {
                console.log(data);
                if (data != 'noProductData') {
                    $('#home-carousel').hide();
                    $('#searchProductResults').show();
                    $('#searchProductResults').html(data);
                } else {
                    $('#home-carousel').show();
                    $('#searchProductResults').hide();
                    $('#searchProductResults').html('');
                }
            },
            error: function(data) {
                console.log(data);
                alert('異常錯誤！');
            }
        });
    }
</script>