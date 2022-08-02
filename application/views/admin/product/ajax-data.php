<?php echo $this->ajax_pagination_admin->create_links(); ?>
<table class="table table-bordered">
  <thead>
    <tr class="info">
      <th>#</th>
      <th>分類</th>
      <th>商品封面</th>
      <th>名稱</th>
      <th class="text-center">預設價格</th>
      <!-- <th>描述</th> -->
      <th>操作</th>
    </tr>
  </thead>
  <?php
$count = 1;
if (!empty($product)) {foreach ($product as $data) {?>
    <tr>
      <td><?php echo $count ?></td>
      <td><?php echo get_product_category_name($data['product_category_id']) ?></td>
      <td style="width: 75px;"><?php echo get_image($data['product_image']) ?></td>
      <td><?php echo $data['product_name'] ?></td>
      <td class="text-center">$<?php echo $data['product_price'] ?></td>
      <!-- <td><?php echo $data['product_description'] ?></td> -->
      <td>
        <a href="/admin/product/edit/<?php echo $data['product_id'] ?>" class="btn btn-primary" target="_blank" >編輯</a>
        <!-- <a href="/admin/product/delete/<?php echo $data['product_id'] ?>" class="btn btn-danger" onClick="return confirm('您確定要刪除嗎?')">刪除</a> -->
      </td>
    </tr>
    <?php $count++;?>
  <?php }}?>
</table>