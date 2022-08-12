<div class="row">
  <div class="col-md-12">
    <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    <hr>
  </div>
  <div class="col-md-6">
    <div class="content-box-large">
      <?php $attributes = array('class' => 'delivery', 'id' => 'delivery');?>
      <?php echo form_open('admin/delivery/update_delivery/' . $delivery['id'], $attributes); ?>
          <div class="form-group">
            <label for="delivery_name">配送名稱</label>
            <input type="text" class="form-control" name="delivery_name" value="<?php echo $delivery['delivery_name']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="shipping_cost">運費</label>
            <input type="number" class="form-control" name="shipping_cost" value="<?php echo $delivery['shipping_cost']; ?>">
          </div>
          <div class="form-group">
            <label for="delivery_info">描述</label>
            <textarea class="form-control" name="delivery_info" rows="2"><?php echo $delivery['delivery_info']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="delivery_status">狀態</label>
            <select class="form-control" name="delivery_status" id="delivery_status">
              <?if ($delivery['delivery_status'] == 1) {?>
                <option value="1" selected>啟用</option>
                <option value="0">停用</option>
              <?} else {?>
                <option value="0" selected>停用</option>
                <option value="1">啟用</option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">修改</button>
          </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>