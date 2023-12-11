<?php echo $this->ajax_pagination_admin->create_links(); ?>
<table class="table table-bordered">
  <thead>
    <tr class="info">
      <th class="text-center">#</th>
      <th class="text-center">分類</th>
      <th>商品封面</th>
      <th>品號</th>
      <th>名稱</th>
      <th class="text-center">預設價格</th>
      <!-- <th class="text-center">加購價格</th> -->
      <th class="text-center">銷售狀態</th>
      <th class="text-center">計算庫存</th>
      <th class="text-center">當前庫存量</th>
      <th class="text-center">可低於庫存下單</th>
      <th class="text-center">上架/下架</th>
      <th class="text-center">上架時間</th>
      <th class="text-center">下架時間</th>
      <th class="text-center">操作</th>
    </tr>
  </thead>
  <?php
  $count = 1;
  if (!empty($product)) {
    foreach ($product as $data) { ?>
      <tr>
        <td class="text-center"><?php echo $count ?></td>
        <td class="text-center"><?php echo get_product_category_name($data['product_category_id']) ?></td>
        <td style="width: 75px;"><?php echo get_image($data['product_image']) ?></td>
        <td><?php echo $data['product_sku'] ?></td>
        <td><?php echo $data['product_name'] ?></td>
        <td class="text-center">$<?php echo $data['product_price'] ?></td>
        <!-- <td class="text-center">$<?php echo $data['product_add_on_price'] ?></td> -->
        <td>
          <? $options = array('0' => '販售中', '1' => '已售完', '2' => '預購',); ?>
          <select class="form-control" name="sales_status" id="sales_status_<?= $data['product_id'] ?>" onchange="update_sales_status('<?= $data['product_id'] ?>')">
            <? foreach ($options as $key => $value) { ?>
              <option value="<?= $key ?>" <?= ($data['sales_status'] == $key ? 'selected' : '') ?>><?= $value ?></option>
            <? } ?>
          </select>
        </td>
        <td class="text-center">
          <span style="font-size: 18px;color:<?= ($data['excluding_inventory'] == true ? 'red' : 'green') ?>">
            <i class="fa-regular fa-circle-<?= ($data['excluding_inventory'] == true ? 'xmark' : 'check') ?>"></i>
          </span>
        </td>
        <td class="text-center" style="font-weight: bold;color: <?= ($data['inventory'] > 0 ? 'green' : 'red') ?>;"><?php echo number_format($data['inventory']) ?></td>
        <td class="text-center">
          <span style="font-size: 18px;color:<?= ($data['stock_overbought'] == false ? 'red' : 'green') ?>">
            <i class="fa-regular fa-circle-<?= ($data['stock_overbought'] == false ? 'xmark' : 'check') ?>"></i>
          </span>
        </td>
        <td class="text-center">
          <a href="/admin/product/update_product_status/<?php echo $data['product_id'] ?>" class="btn btn-<?= ($data['product_status'] == 1 ? 'success' : 'danger') ?> btn-sm" onClick="return confirm('確定要<?= ($data['product_status'] == 1 ? '下' : '上') ?>架嗎?')"></i>
            <span><?= ($data['product_status'] == 1 ? '上架中' : '已下架') ?></span></a>
        </td>
        <td class="text-center"><?php echo $data['distribute_at'] ?></td>
        <td class="text-center"><?php echo $data['discontinued_at'] ?></td>
        <td class="text-center">
          <a href="/admin/product/edit/<?php echo $data['product_id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-edit" aria-hidden="true"></i></a>
          <a href="/admin/product/delete/<?php echo $data['product_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>
      </tr>
      <?php $count++; ?>
  <?php }
  } ?>
</table>