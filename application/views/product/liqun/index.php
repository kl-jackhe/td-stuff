<div role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="container">
            <div class="row product_box my-5">
                <div class="col-12">
                    <div class="row text-center">
                        <!-- <div class="col-12 pb-3">
                            <span style="font-size: 18px;font-weight: bold;">商品分類</span>
                        </div> -->
                        <!-- <input type="text" id="keywords" class="form-control" placeholder="請輸入商品名稱" size="50"> -->
                        <div class="product-categories">
                            <?php if (!empty($product_category)) { ?>
                                <?php foreach ($product_category as $row) { ?>
                                    <span class="product_category btn col-2" id="<?php echo 'product_category_id_' . $row['product_category_id'] ?>" onClick="searchFilter(<?php echo $row['product_category_id']; ?>)"><?php echo $row['product_category_name']; ?></span>
                                <?php } ?>
                                <!-- <span class="product_category btn col-2" onClick="searchFilter('')">全品項</span> -->
                            <?php } ?>
                        </div>
                    </div>
                    <hr class="py-2" style="border-top: 1px solid #988B7A;">
                </div>
                <div id="data" class="col-12">
                    <?php require 'ajax-data.php'; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    // $(document).ready(function() {
    //     // 取得完整的查詢字串（包括問號）
    //     var queryString = window.location.search;
    //     // 解析查詢字串，並建立一個包含參數和值的物件
    //     var params = new URLSearchParams(queryString);
    //     // 取得 id 參數的值
    //     var idValue = params.get('cid');
    //     searchFilter(idValue);
    // });

    function searchFilter(product_category) {
        $.ajax({
            type: 'GET',
            url: '/product/ajaxData',
            // data: 'keywords=' + keywords + '&product_category=' + product_category,
            data: 'product_category=' + product_category,
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(html) {
                $('#data').html(html);
                $('#loading').fadeOut("fast");
            }
        });
    }
</script>