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
            <input type="text" class="form-control" name="delivery_name" value="<?php echo $delivery['delivery_name']; ?>">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">修改</button>
          </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>