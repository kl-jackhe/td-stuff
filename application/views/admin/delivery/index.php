<div class="row">
  <!-- <div class="col-md-12">
    <a href="<?= base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    <hr>
  </div> -->
  <!-- <div class="col-md-4">
    <div class="content-box-large">
    <?php $attributes = array('class' => 'delivery', 'id' => 'delivery'); ?>
    <?= form_open('admin/delivery/insert_delivery', $attributes); ?>
      <div class="form-group">
        <label for="delivery_name">配送名稱</label>
        <input type="text" class="form-control" name="delivery_name">
      </div>
      <div class="form-group">
        <label for="shipping_cost">運費</label>
        <input type="number" class="form-control" name="shipping_cost">
      </div>
      <div class="form-group">
        <label for="delivery_info">描述</label>
        <textarea class="form-control" name="delivery_info" rows="2"></textarea>
      </div>
      <div class="form-group">
        <label for="delivery_status">狀態</label>
        <select class="form-control" name="delivery_status" id="delivery_status">
          <option value="1">啟用</option>
          <option value="0">停用</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">新增配送方式</button>
      </div>
    <?= form_close(); ?>
    </div>
  </div> -->
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr class="info">
            <th>配送名稱</th>
            <!-- <th>依照方式</th> -->
            <th class="text-center">免運開關</th>
            <th class="text-center">免運門檻</th>
            <th class="text-center">運費</th>
            <th>限制</th>
            <th>描述</th>
            <th style="width: 5%" class="text-center">排序</th>
            <th class="text-center">狀態</th>
            <th class="text-center">操作</th>
          </tr>
        </thead>
        <? if (!empty($delivery)) : ?>
          <? foreach ($delivery as $data) : ?>
            <tr>
              <!-- name -->
              <td><?= $data['delivery_name'] ?></td>
              <!-- shipping free enable -->
              <td class="text-center">
                <? if ($data['free_shipping_enable']) { ?>
                  <a href="/admin/delivery/editShippingStatus/<?= $data['id'] ?>" class="btn btn-success btn-sm" onClick="return confirm('確定要停用嗎?')">
                    <span>啟用中</span>
                  </a>
                <? } else { ?>
                  <a href="/admin/delivery/editShippingStatus/<?= $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要啟用嗎?')"></i>
                    <span>停用</span></a>
                <? } ?>
              </td>
              <!-- shipping free limit -->
              <td class="text-center">
                $<?= $data['free_shipping_limit'] ?>
              </td>
              <!-- shipping fee -->
              <td class="text-center">$<?= $data['shipping_cost'] ?></td>
              <!-- limit -->
              <td>
                <?
                $count = 0;
                if ($data['limit_weight'] != '' && $data['limit_weight_unit'] != '') {
                  echo '重量限制：' . $data['limit_weight'] . ' ' . $data['limit_weight_unit'];
                  $count++;
                }
                if ($data['limit_volume_length'] != '' || $data['limit_volume_width'] != '' || $data['limit_volume_height'] != '') {
                  if ($count > 0) {
                    echo '<br>';
                  }
                  echo '材積限制：' . '長 ' . $data['limit_volume_length'] . 'cm, 寬 ' . $data['limit_volume_width'] . 'cm, 高 ' . $data['limit_volume_height'] . 'cm';
                } ?>
              </td>
              <!-- description -->
              <td><?= $data['delivery_info'] ?></td>
              <!-- sort -->
              <td class="text-center">
                <input type="number" class="form-control" id="realTimeSort_<?= $data['id'] ?>" onchange="updateSortPosition(<?= $data['id'] ?>)" value="<?= $data['delivery_sort'] ?>">
              </td>
              <!-- status -->
              <td class="text-center"><? if ($data['delivery_status'] == 1) { ?>
                  <a href="/admin/delivery/update_delivery_status/<?= $data['id'] ?>" class="btn btn-success btn-sm" onClick="return confirm('確定要停用嗎?')"></i>
                    <span>啟用中</span></a>
                <? } else { ?>
                  <a href="/admin/delivery/update_delivery_status/<?= $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要啟用嗎?')"></i>
                    <span>停用</span></a>
                <? } ?>
              </td>
              <!-- operation -->
              <td class="text-center">
                <a href="/admin/delivery/edit_delivery/<?= $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <!-- <a href="/admin/delivery/delete_delivery/<?= $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa fa-trash-o"></i></a> -->
              </td>
            </tr>
          <? endforeach ?>
        <? else : ?>
          <tr>
            <td colspan="4">
              <center>對不起, 沒有資料 !</center>
            </td>
          </tr>
        <? endif; ?>
      </table>
    </div>
  </div>
</div>

<script>
  function updateSortPosition(id) {
    $.ajax({
      url: '/admin/delivery/updateSortPosition/' + id,
      type: 'post',
      data: {
        sort: $('#realTimeSort_' + id).val(),
      },
      success: function(response) {
        console.response;
      }
    });
  }
</script>