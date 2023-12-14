<style>
.carousel-fade .carousel-item {
 opacity: 0;
 transition-duration: 2s;
 transition-property: opacity;
}
.carousel-fade  .carousel-item.active,
.carousel-fade  .carousel-item-next.carousel-item-left,
.carousel-fade  .carousel-item-prev.carousel-item-right {
    opacity: 1;
}
.carousel-fade .active.carousel-item-left,
.carousel-fade  .active.carousel-item-right {
    opacity: 0;
}
.carousel-fade  .carousel-item-next,
.carousel-fade .carousel-item-prev,
.carousel-fade .carousel-item.active,
.carousel-fade .active.carousel-item-left,
.carousel-fade  .active.carousel-item-prev {
    transform: translateX(0);
    transform: translate3d(0, 0, 0);
}
<?for ($i=1;$i<=6;$i++) {?>
    .image-link-<?=$i?>:hover img {
        content: url('/assets/images/liqun/index_icon_pots-<?=$i?>a.png');
    }
<?}?>










#home_product {
    font-size: 16px;
    line-height: 20px;
}
#home_product a {
    text-decoration: none;
    color: black;
    transition: 500ms ease 0s;
}
#home_product a:hover {
    color: rgba(239,132,104,1.0);
}
#zoomA {
    transition: transform ease-in-out 0s;
}
#zoomA:hover {
    transform: scale(1.05);
}
.product_img_style {
    border-radius: 15px;
    max-width: 900px;
    max-height: 900px;
    width: 100%;
    margin-bottom: 15px;
}
@media (min-width: 768px) and (max-width: 991.98px) {
    .ipad_w {
        max-width: 50%;
        flex: 0 0 50%;
    }
}
@media (max-width: 767px) {
    .product_box_list {
        padding: 0px 30px 0px 30px;
    }
}
</style>
<div role="main" class="main">
    <section class="content_auto_h">
        <?if (!empty($banner)) {?>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 px-0" style="max-height: 500px;">
                <div id="home-carousel" class="carousel slide carousel-fade" data-touch="false" data-interval="false">
                    <ol class="carousel-indicators" style="bottom: -20px;">
                        <?for ($i=0;$i<count($banner);$i++) {?>
                            <li data-target="#home-carousel" data-slide-to="<?=$i?>" <?=($i==0?'class="active"':'')?>></li>
                        <?}?>
                    </ol>
                    <div class="carousel-inner">
                        <?php $count=0;
                        foreach ($banner as $data) {?>
                            <div class="carousel-item <?=($count==0?'active':'') ?>">
                                <a href="<?=$data['banner_link'] ?>" target="<?=($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                                    <img class="d-block" style="width: 100%;max-height: 500px;" src="/assets/uploads/<?=$data['banner_image'] ?>">
                                </a>
                            </div>
                            <?php $count++;
                        }?>
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
                </div>
            </div>
        </div>
        <?}?>
        <div class="container">
            <div class="row justify-content-center py-5">
                <?for ($i=1;$i<=6;$i++) {?>
                    <div class="col-6 col-md-2 my-3">
                        <a href="#" class="image-link-<?=$i?>">
                            <img src="/assets/images/liqun/index_icon_pots-<?=$i?>.png" class="img-fluid">
                        </a>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9 col-md-3 text-center pb-4">
                    <img src="/assets/images/liqun/index_icon_title-1.png" class="img-fluid">
                </div>
                <div class="col-md-12 text-center">
                    <div class="row justify-content-center product_box_list" id="home_product">
                        <?if (!empty($products)) {
                            $count = 0;
                            foreach ($products as $product){
                                if ($count < 4) {?>
                                <div class="col-md-3 pb-4 ipad_w">
                                    <a href="/product/view/<?=$product['product_id']?>">
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
                </div>
            </div>
        </div>
        <div style="background-color: #f5f0e7;margin-top: 15px;margin-bottom: 15px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-9 col-md-3 text-center py-4">
                        <img src="/assets/images/liqun/index_icon_title-2.png" class="img-fluid">
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="row justify-content-center product_box_list" id="home_product">
                            <?if (!empty($products)) {
                                $count = 0;
                                foreach ($products as $product){
                                    if ($count < 6) {?>
                                    <div class="col-md-2 pb-4 ipad_w">
                                        <a href="/product/view/<?=$product['product_id']?>">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-9 col-md-3 text-center py-4">
                    <img src="/assets/images/liqun/index_icon_title-3.png" class="img-fluid">
                </div>
                <div class="col-md-12 text-center">
                    <?if (!empty($product_category)) {
                        foreach ($product_category as $pc_row) {?>
                            <span style="border-radius: 15px; border: 1px solid #b9b9b9;background-color: #f4f2f2;color: #1d1e1e;min-width: 120px;padding: 5px 12px;font-size: 14px;display: inline-block; cursor: pointer;margin-bottom: 25px;margin-left: 10px;margin-right: 10px;"><?=$pc_row['product_category_name']?></span>
                        <?}
                    }?>
                </div>
            </div>
        </div>
    </section>
</div>