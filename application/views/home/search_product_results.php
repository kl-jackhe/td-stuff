<div class="row justify-content-center product_box_list" id="home_product">
    <?if (!empty($products)) {
        $count = 0;
        foreach ($products as $product){
            if ($count < 4) {?>
                <div class="col-md-3 pb-4 ipad_w">
                    <a href="/product/view/<?=$product['product_id']?>" target="_blank">
                        <img id="zoomA" class="product_img_style" src="/assets/uploads/<?=(!empty($product['product_image'])?$product['product_image']:'Product/img-600x600.png')?>">
                        <div class="product_name">
                            <span><?=$product['product_name'];?></span>
                        </div>
                    </a>
                </div>
            <?}
            $count++;
        }
    }?>
</div>