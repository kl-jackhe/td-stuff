<? echo $this->ajax_pagination->create_links(); ?>
<div class="col-md-12 text-center">
  <div class="row" id="product_index">
    <? if (!empty($products)) :
      // $products 是从后端传递过来的产品数组
      $productsPerPage = 12; // 每页显示的产品数量
      $totalProducts = count($products);
      $totalPages = ceil($totalProducts / $productsPerPage);

      // 获取当前页码
      $currentpage = $page;
      $offset = ($currentpage - 1) * $productsPerPage;

      // 获取当前页的产品
      $currentProducts = array_slice($products, $offset, $productsPerPage);

      foreach ($currentProducts as $product) : ?>
        <div class="product_view_style_out col-6 col-md-6 col-lg-4">
          <a href="javascript:void(0)" onClick="href_product(<?= $product['product_id'] ?>)">
            <div class="product_view_style_in transitionAnimation">
              <? if (!empty($product['product_image'])) { ?>
                <img id="zoomA" class="product_img_style" src="/assets/uploads/<?= $product['product_image']; ?>">
              <? } else { ?>
                <img id="zoomA" class="product_img_style" src="/assets/uploads/Product/img-600x600.png">
              <? } ?>
              <div class="product_content">
                <span class="product_name"><?= $product['product_name']; ?></span><br><br>
              </div>
              <div class="select_product text-center">
                <span <?= ($product['sales_status'] == 0) ? '' : ($product['sales_status'] == 1 ? 'style="background: #817F82;"' : 'style="background: #A60747;"') ?>><?= ($product['sales_status'] == 0) ? '現貨' : ($product['sales_status'] == 1 ? '售完' : '預購') ?></span>
              </div>
            </div>
          </a>
        </div>
      <? endforeach ?>
      <!-- 显示分页链接 -->
      <div class="col-12">
        <ul class="pagination">
          <?php
          $range = 2; // 定义前后显示的页码范围

          // 显示 "<<" 和 上一页 按钮
          if ($currentpage > 1) {
            echo '<li class="page-item"><a href="javascript:void(0)" onclick="pageShift(1)" class="page-link">&laquo;</a></li>';
            echo '<li class="page-item"><a href="javascript:void(0)" onclick="pageShift(' . ($currentpage - 1) . ')" class="page-link">&lsaquo;</a></li>';
          } else {
            echo '<li class="page-item disabled"><a href="javascript:void(0)" onclick="pageShift(1)" class="page-link">&laquo;</a></li>';
            echo '<li class="page-item disabled"><a href="javascript:void(0)" onclick="pageShift(' . ($currentpage - 1) . ')" class="page-link">&lsaquo;</a></li>';
          }

          // 计算开始和结束页码
          $start = max(1, $currentpage - $range);
          $end = min($totalPages, $currentpage + $range);

          // 当前页码靠近开始或结束时，调整结束页码，确保显示固定数量的页码
          if ($currentpage <= $range) {
            $end = min($start + 2 * $range, $totalPages);
          } elseif ($currentpage >= $totalPages - $range) {
            $start = max($end - 2 * $range, 1);
          }

          for ($i = $start; $i <= $end; $i++) {
            echo '<li class="page-item"><a href="javascript:void(0)" onclick="pageShift(' . $i . ')"' . ($i == $currentpage ? 'class="page-link active"' : 'class="page-link"') . '>' . $i . '</a></li>';
          }

          // 显示 ">>" 和 下一页 按钮
          if ($currentpage < $totalPages) {
            echo '<li class="page-item"><a href="javascript:void(0)" onclick="pageShift(' . ($currentpage + 1) . ')" class="page-link">&rsaquo;</a></li>';
            echo '<li class="page-item"><a href="javascript:void(0)" onclick="pageShift(' . $totalPages . ')" class="page-link">&raquo;</a></li>';
          } else {
            echo '<li class="page-item disabled"><a href="javascript:void(0)" onclick="pageShift(' . ($currentpage + 1) . ')" class="page-link">&rsaquo;</a></li>';
            echo '<li class="page-item disabled"><a href="javascript:void(0)" onclick="pageShift(' . $totalPages . ')" class="page-link">&raquo;</a></li>';
          }
          ?>
        </ul>
        <div class="pagination_bottom">
          <span>目前頁數： <?= $currentpage ?> / <?= $totalPages ?>　資料總數：<?= $totalProducts ?></span>
        </div>
      </div>
    <? else : ?>
      <div class="col-12 text-center" style="height: 500px;">
        <p>搜尋不到對應的商品！</p>
      </div>
    <? endif; ?>
  </div>
</div>