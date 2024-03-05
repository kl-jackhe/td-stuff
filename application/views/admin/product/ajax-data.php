<?php echo $this->ajax_pagination_admin->create_links(); ?>
<table class="table table-bordered">
  <thead>
    <tr class="info">
      <th class="text-center">#</th>
      <th class="text-center">分類</th>
      <th>封面圖</th>
      <th>品號</th>
      <th>名稱</th>
      <th class="text-center">預設價格</th>
      <!-- <th class="text-center">加購價格</th> -->
      <th class="text-center">銷售狀態</th>
      <!-- <th class="text-center">計算庫存</th> -->
      <!-- <th class="text-center">當前庫存量</th> -->
      <!-- <th class="text-center">可低於庫存下單</th> -->
      <th class="text-center">上架/下架</th>
      <th class="text-center">上架時間</th>
      <th class="text-center">下架時間</th>
    </tr>
  </thead>
  <?php
  $count = 1;
  if (!empty($product)) {
    foreach ($product as $data) {
      $selectProductCategoryList = $this->product_model->getSelectProductCategory($data['product_id']) ?>
      <tr>
        <td class="text-center"><?php echo $data['product_id'] ?></td>
        <td class="text-center">
          <?php if ($this->is_partnertoys) : ?>
            <? if (!empty($data['product_category_id'])) {
              echo getProductCategoryName($data['product_category_id']);
            } ?>
          <?php else : ?>
            <? if (!empty($selectProductCategoryList)) {
              $count = 0;
              foreach ($selectProductCategoryList as $spcl_row) {
                if ($count > 0) {
                  echo '<br>';
                }
                echo get_product_category_name($spcl_row);
                $count++;
              }
            } ?>
          <?php endif; ?>
        </td>
        <?php ?>
        <?php if ($this->is_partnertoys) : ?>
          <td style="width: 75px;">
            <?php echo get_image($data['product_image']) ?>
          </td>
        <?php else : ?>
          <td class="text-center product_edit_style">
            <? if ($data['product_image'] != '') { ?>
              <a href="/assets/uploads/<?= $data['product_image'] ?>" data-fancybox data-caption="<?= $data['product_image'] ?>" style="font-size: 18px;"><i class="fa-solid fa-image"></i></a>
            <? } else { ?>
              <i class="fa-solid fa-xmark" style="color: red; font-size: 18px;"></i>
            <? } ?>
          </td>
        <?php endif; ?>
        <td><?php echo $data['product_sku'] ?></td>
        <td class="product_edit_style">
          <a href="/admin/product/edit/<?php echo $data['product_id'] ?>" target="_blank"><?php echo $data['product_name'] ?></a>
        </td>
        <td class="text-center" style="color: red;">$<?php echo $data['product_price'] ?></td>
        <!-- <td class="text-center">$<?php echo $data['product_add_on_price'] ?></td> -->
        <?php if ($this->is_partnertoys) : ?>
          <td>
            <? $options = array('0' => '商品銷售', '1' => '商品展示', '2' => '商品下架',); ?>
            <select class="form-control" name="sales_status" id="sales_status_<?= $data['product_id'] ?>" onchange="update_sales_status('<?= $data['product_id'] ?>')">
              <? foreach ($options as $key => $value) { ?>
                <option value="<?= $key ?>" <?= ($data['sales_status'] == $key ? 'selected' : '') ?>><?= $value ?></option>
              <? } ?>
            </select>
          </td>
        <?php else : ?>
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
        <?php endif; ?>
        <td class="text-center">
          <a href="/admin/product/update_product_status/<?php echo $data['product_id'] ?>" class="btn btn-<?= ($data['product_status'] == 1 ? 'success' : 'danger') ?> btn-sm" onClick="return confirm('確定要<?= ($data['product_status'] == 1 ? '下' : '上') ?>架嗎?')"></i>
            <span><?= ($data['product_status'] == 1 ? '上架中' : '已下架') ?></span></a>
        </td>
        <td class="text-center"><?php echo $data['distribute_at'] ?></td>
        <td class="text-center"><?php echo ($data['discontinued_at'] != '0000-00-00 00:00:00') ? $data['discontinued_at'] : '永久' ?></td>
      </tr>
  <?php }
  } ?>
</table>