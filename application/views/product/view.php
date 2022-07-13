<style>
.product_description img {
    width: 100%;
    max-width: 700px;
}
</style>
<div role="main" class="main">
    <section class="form-section">
        <div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px;">
            <div class="row justify-content-center">
                <?
                        if (!empty($product)) {
                        ?>
                <div class="col-md-12 text-center">
                    <h1>描述</h1>
                </div>
                <div class="col-md-8 text-center product_description">
                    <div>
                        <?=$product['product_description']?>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <h1>商品選購</h1>
                </div>
                <div class="col-md-8 text-center">
                    <?foreach  ( $specification as  $row ){?>
                    <div class="col-md-6">
                        <img class="img-fluid" src="/assets/uploads/<?=$product['product_image'];?>">
                        <div>
                            <?=$product['product_name'];?>
                        </div>
                        <div>規格：
                            <?=$row['quantity'];?>
                            <?=$row['unit'];?>
                        </div>
                        <div>金額：
                            <?=$row['price'];?>元</div>
                        <div class="text-center">
                            <span style="border: 1px solid red;background-color: red;border-radius: 15px;padding: 5px 10px 5px 10px;"><i class="fa-solid fa-cart-shopping"></i> 加入購物車</span>
                        </div>
                    </div>
                    <?}?>
                </div>
                <?}?>
            </div>
        </div>
    </section>
</div>