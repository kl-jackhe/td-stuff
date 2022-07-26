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
    color: #68396D;
}

#product_index .product_name {
    line-height: 35px;
}

#product_index .product_price {
    line-height: 35px;
}
#zoomA {
  transition: transform ease-in-out 0s;
}
#zoomA:hover {
    transform: scale(1.1);
}
.select_product {
    background-color: #68396D;
    color: #fff !important;
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
    padding: 25px;
}
.page-header {
    padding-left: 30px;
    padding-right: 30px;
}
@media (max-width: 767px) {
    .product_box {
        padding: 0px;
    }
    .page-header {
        padding-left: 0px;
        padding-right: 0px;
    }
}
</style>
<div role="main" class="main">
    <section class="form-section">
        <div class="container">
            <div class="row product_box">
                <div class="col-md-12 text-center">
                    <div class="row justify-content-center" id="product_index">
                        <?
                        if (!empty($products)) {
                            foreach ($products as $product){
                        ?>
                        <div class="col-md-4 pb-5">
                            <a href="/product/view/<?=$product['product_id']?>">
                                <?if (!empty($product['product_image'])) {?>
                                <img id="zoomA" class="product_img_style" src="/assets/uploads/<?=$product['product_image'];?>">
                                <?}else{?>
                                <img id="zoomA" class="product_img_style" src="/assets/uploads/Product/img-600x600.png">
                                <?}?>
                                <div class="product_name">
                                    <span>
                                        <?=$product['product_name'];?></span>
                                </div>
                            </a>
                            <div class="product_price">
                                $<span style="color:#68396D">
                                    <?=$product['product_price'];?></span>
                            </div>
                            <a href="/product/view/<?=$product['product_id']?>">
                                <div class="btn select_product">
                                    <span>選購</span>
                                </div>
                            </a>
                        </div>
                        <?}
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>