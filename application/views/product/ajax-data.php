<?echo $this->ajax_pagination->create_links(); ?>
<div class="col-md-12 text-center">
  <div class="row justify-content-center" id="product_index">
    <?if (!empty($products)):
      foreach ($products as $product): ?>
      <div class="col-md-4 pb-5">
          <a href="/product/view/<?=$product['product_id']?>">
              <?if (!empty($product['product_image'])) {?>
                  <img id="zoomA" class="product_img_style" src="/assets/uploads/<?=$product['product_image'];?>">
              <?}else{?>
                  <img id="zoomA" class="product_img_style" src="/assets/uploads/Product/img-600x600.png">
              <?}?>
              <div class="product_name">
                  <span><?=$product['product_name'];?></span>
              </div>
          </a>
          <a href="/product/view/<?=$product['product_id']?>">
              <div class="btn select_product">
                  <span>選購</span>
              </div>
          </a>
      </div>
      <?endforeach?>
    <?else: ?>
      <div class="col-12 text-center" style="height: 500px;"><p>搜尋不到對應的商品！</p></div>
    <?endif;?>
  </div>
</div>