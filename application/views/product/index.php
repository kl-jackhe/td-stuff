<div role="main" class="main">
    <section class="form-section">
        <div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px;">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="row justify-content-center" id="home_product">
                        <?
                        if (!empty($products)) {
                            foreach ($products as $product){
                        ?>
                        <div class="col-md-4 pb-5">
                            <a href="/product/view/<?=$product['product_id']?>">
                                <?if (!empty($product['product_image'])) {?>
                                <img style="border-radius: 15px;max-width: 900px;max-height: 900px;width: 100%" src="/assets/uploads/<?=$product['product_image'];?>">
                                <?}else{?>
                                <img style="border-radius: 15px;max-width: 900px;max-height: 900px;width: 100%;" src="/assets/uploads/Product/img-600x600.png">
                                <?}?>
                                <div class="product_name">
                                    <span>
                                        <?=$product['product_name'];?></span>
                                </div>
                            </a>
                            <div class="product_price">
                                <span>$
                                    <?=$product['product_price'];?></span>
                            </div>
                            <a href="/product/view/<?=$product['product_id']?>">
                                <div style="border-radius: 30px;margin-left: 15%;margin-right: 15%;padding-bottom: 10px;padding-top: 10px;border: 1px solid gray;">
                                    <span><i class="fa-solid fa-cart-shopping"></i> 立即選購</span>
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