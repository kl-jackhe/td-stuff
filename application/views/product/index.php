<style>
#product_index {
    font-size: 18px;
    line-height: 20px;
    align-items: end;
}

#product_index a {
    text-decoration: none;
    color: black;
    transition: 500ms ease 0s;
}

#product_index a:hover {
    <?if ($this->is_td_stuff) {?>
        color: #68396D;
    <?}?>
    <?if ($this->is_liqun_food) {?>
        color: #f6d523;
    <?}?>
}

#product_index .product_name {
    padding-bottom: 10px;
}

#product_index .product_price {
    line-height: 35px;
}
#zoomA {
    transition: transform ease-in-out 0s;
}
#zoomA:hover {
    transform: scale(1.05);
}
.select_product {
    <?if ($this->is_td_stuff) {?>
        background-color: #68396D;
        color: #fff !important;
    <?}?>
    <?if ($this->is_liqun_food) {?>
        background-color: #f6d523;
        color: #000 !important;
    <?}?>
    width: 50%;
    line-height: 1.8;
    padding: 0;
}
.product_img_style {
    border-radius: 15px;
    max-width: 900px;
    max-height: 900px;
    width: 100%;
    margin-bottom: 15px;
}
.product_box {
    padding: 0px 25px 0px 25px;
}
.page-header {
    padding-left: 30px;
    padding-right: 30px;
}
.product_category {
    <?if ($this->is_td_stuff) {?>
        border: 1px solid #68396D;
    <?}?>
    <?if ($this->is_liqun_food) {?>
        border: 1px solid #f6d523;
    <?}?>
    padding: 5px 15px 5px 15px;
    border-radius: 10px;
    width: 100%;
}
.m_padding {
    padding-bottom: 0px !important;
}
@media (max-width: 767px) {
    .product_box {
        padding: 0px;
    }
    .page-header {
        padding-left: 0px;
        padding-right: 0px;
    }
    .product_category {
        margin: 10px 0px 10px 0px;
        padding: 6px 2px 6px 2px;
        font-size: 14px;
    }
    #product_index {
        padding: 0px 30px 0px 30px;
    }
}
</style>
<div role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="container">
            <div class="row product_box">
                <div class="col-12">
                    <div class="row justify-content-center text-center">
                        <!-- <div class="col-12 pb-3">
                            <span style="font-size: 18px;font-weight: bold;">商品分類</span>
                        </div> -->
                        <!-- <input type="text" id="keywords" class="form-control" placeholder="請輸入商品名稱" size="50"> -->
                        <?if (!empty($product_category)) {
                            foreach ($product_category as $row) {?>
                                <div class="col-3 col-md-2">
                                    <span class="product_category btn" id="<?echo 'product_category_id_'.$row['product_category_id']?>" onClick="searchFilter(<?echo $row['product_category_id'];?>)"><?echo $row['product_category_name'];?></span>
                                </div>
                            <?}
                        }?>
                    </div>
                    <hr class="py-2" style="border-top: 1px solid #988B7A;">
                </div>
                <div id="data" class="col-12">
                <?php require 'ajax-data.php';?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function searchFilter(product_category) {
    // var keywords = $('#keywords').val();
    // var product_category = $('#product_category').val();
    // alert(product_category);
    $.ajax({
        type: 'GET',
        url: 'product/ajaxData',
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