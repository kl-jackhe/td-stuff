<?php echo $this->ajax_pagination_admin->create_links(); ?>
<table class="table table-bordered">
  <thead>
    <tr class="info">
      <th class="text-center">#</th>
      <th class="text-center">分類</th>
      <th>商品封面</th>
      <th>名稱</th>
      <th class="text-center">預設價格</th>
      <th class="text-center">加購價格</th>
      <th class="text-center">上架/下架</th>
      <th class="text-center">操作</th>
    </tr>
  </thead>
  <?php
$count = 1;
if (!empty($product)) {foreach ($product as $data) {?>
    <tr>
      <td class="text-center"><?php echo $count ?></td>
      <td class="text-center"><?php echo get_product_category_name($data['product_category_id']) ?></td>
      <td style="width: 75px;"><?php echo get_image($data['product_image']) ?></td>
      <td><?php echo $data['product_name'] ?></td>
      <td class="text-center">$<?php echo $data['product_price'] ?></td>
      <td class="text-center">$<?php echo $data['product_add_on_price'] ?></td>
      <!-- <td><?php echo $data['product_description'] ?></td> -->
      <td class="text-center"><?if ($data['product_status'] == 1) {?>
        <a href="/admin/product/update_product_status/<?php echo $data['product_id'] ?>" class="btn btn-success btn-sm" onClick="return confirm('確定要下架嗎?')"></i>
        <span>上架中</span></a>
      <?} else {?>
        <a href="/admin/product/update_product_status/<?php echo $data['product_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要上架嗎?')"></i>
        <span>已下架</span></a>
      <?}?>
      </td>
      <td class="text-center">
        <a href="/admin/product/edit/<?php echo $data['product_id'] ?>" class="btn btn-primary" target="_blank" >編輯</a>
      </td>
    </tr>
    <?php $count++;?>
  <?php }}?>
</table>