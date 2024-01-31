<div class="row">
  <!-- <div class="col-md-12">
    <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    <hr>
  </div> -->
  <!-- <div class="col-md-4">
    <div class="content-box-large">
    <?php $attributes = array('class' => 'payment', 'id' => 'payment'); ?>
    <?php echo form_open('admin/payment/insert_payment', $attributes); ?>
      <div class="form-group">
        <label for="payment_name">支付名稱</label>
        <input type="text" class="form-control" name="payment_name">
      </div>
      <div class="form-group">
        <label for="payment_info">描述</label>
        <textarea class="form-control" name="payment_info" rows="2"></textarea>
      </div>
      <div class="form-group">
        <label for="payment_status">狀態</label>
        <select class="form-control" name="payment_status" id="payment_status">
          <option value="1">啟用</option>
          <option value="0">停用</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">新增支付方式</button>
      </div>
    <?php echo form_close(); ?>
    </div>
  </div> -->
  <?php if (!empty($features_pay)) : ?>
    <div class="col-md-12">
      <h1>金鑰管理</h1>
      <div class="content-box-large">
        <table class="table">
          <thead>
            <tr>
              <th>金流名稱</th>
              <th>MerchantID</th>
              <th>HashKey</th>
              <th>HashIV</th>
              <th>狀態</th>
              <th>操作</th>
            </tr>
          </thead>
          <?php foreach ($features_pay as $self) : ?>
            <tr>
              <td><?php echo $self['pay_name'] ?></td>
              <td><?= $self['MerchantID'] ?></td>
              <td><?= $self['HashKey'] ?></td>
              <td><?= $self['HashIV'] ?></td>
              <td><? if ($self['payment_status'] == 1) { ?>
                  <a href="/admin/payment/update_KEY_status/<?= $self['pay_id'] ?>" class="btn btn-success btn-sm" onClick="return confirm('確定要停用嗎?')"></i>
                    <span>啟用中</span></a>
                <? } else { ?>
                  <a href="/admin/payment/update_KEY_status/<?= $self['pay_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要啟用嗎?')"></i>
                    <span>已停用</span></a>
                <? } ?>
              </td>
              <td>
                <a href="/admin/payment/edit_KEY/<?= $self['pay_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-md-12">
    <h1>付款方式管理</h1>
    <div class="content-box-large">
      <table class="table">
        <thead>
          <tr>
            <th>支付名稱</th>
            <th>描述</th>
            <th>狀態</th>
            <th>排序</th>
            <th>操作</th>
          </tr>
        </thead>
        <?php if (!empty($payment)) : foreach ($payment as $data) : ?>
            <tr>
              <td><?php echo $data['payment_name'] ?></td>
              <td style="white-space: pre-wrap;"><?php echo $data['payment_info'] ?></td>
              <td><? if ($data['payment_status'] == 1) { ?>
                  <a href="/admin/payment/update_payment_status/<?php echo $data['id'] ?>" class="btn btn-success btn-sm" onClick="return confirm('確定要停用嗎?')"></i>
                    <span>啟用中</span></a>
                <? } else { ?>
                  <a href="/admin/payment/update_payment_status/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要啟用嗎?')"></i>
                    <span>停用</span></a>
                <? } ?>
              </td>
              <td><?= $data['sort'] ?></td>
              <td>
                <a href="/admin/payment/edit_payment/<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <!-- <a href="/admin/payment/delete_payment/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa fa-trash-o"></i></a> -->
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="4">
              <center>對不起, 沒有資料 !</center>
            </td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
  </div>
</div>