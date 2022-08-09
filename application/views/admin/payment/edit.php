<div class="row">
  <div class="col-md-12">
    <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    <hr>
  </div>
  <div class="col-md-6">
    <div class="content-box-large">
      <?php $attributes = array('class' => 'payment', 'id' => 'payment');?>
      <?php echo form_open('admin/payment/update_payment/' . $payment['id'], $attributes); ?>
          <div class="form-group">
            <label for="payment_name">支付名稱</label>
            <input type="text" class="form-control" name="payment_name" value="<?php echo $payment['payment_name']; ?>">
          </div>
          <div class="form-group">
            <label for="payment_info">描述</label>
            <textarea class="form-control" name="payment_info" rows="2"><?php echo $payment['payment_info']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="payment_status">狀態</label>
            <select class="form-control" name="payment_status" id="payment_status">
              <?if ($payment['payment_status'] == 1) {?>
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