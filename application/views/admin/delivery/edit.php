<style>
  label.require::before {
    content: '* ';
    color: red;
  }

  label.free::before {
    content: '* ';
    color: blue;
  }

  .editDeliveryContent {
    left: 25%;
  }

  .editDeliveryContent h3 {
    font-weight: bold;
  }

  @media (max-width:991px) {
    .editDeliveryContent {
      left: auto;
    }
  }
</style>
<div class="row">
  <div class="col-md-6 editDeliveryContent">
    <div class="content-box-large row">
      <?php $attributes = array('class' => 'delivery', 'id' => 'delivery'); ?>
      <?php echo form_open('admin/delivery/update_delivery/' . $delivery['id'], $attributes); ?>
      <div class="col-md-12 returnBack">
        <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回</a>
        &emsp;<button type="submit" class="btn btn-primary">修改</button>
        <hr>
      </div>
      <div class="form-group col-md-12">
        <h3>基本設定</h3>
        <hr>
      </div>
      <div class="form-group col-md-12">
        <label class="require" for="delivery_name">配送名稱</label>
        <input type="text" class="form-control" name="delivery_name" value="<?php echo $delivery['delivery_name']; ?>" require>
      </div>
      <div class="form-group col-md-12">
        <label class="free" for="delivery_info">描述</label>
        <textarea class="form-control" name="delivery_info" rows="3"><?php echo $delivery['delivery_info']; ?></textarea>
      </div>
      <div class="form-group col-md-12">
        <label class="free" for="delivery_status">狀態</label>
        <select class="form-control" name="delivery_status" id="delivery_status">
          <? if ($delivery['delivery_status'] == 1) { ?>
            <option value="1" selected>啟用</option>
            <option value="0">停用</option>
          <? } else { ?>
            <option value="0" selected>停用</option>
            <option value="1">啟用</option>
          <? } ?>
        </select>
      </div>
      <div class="form-group col-md-12">
        <h3>運費設定</h3>
        <hr>
      </div>
      <div class="form-group col-md-6">
        <label class="free" for="free_shipping_enable">免運開關</label>
        <select class="form-control" name="free_shipping_enable" id="free_shipping_enable">
          <? if ($delivery['free_shipping_enable'] == 1) { ?>
            <option value="1" selected>啟用</option>
            <option value="0">停用</option>
          <? } else { ?>
            <option value="0" selected>停用</option>
            <option value="1">啟用</option>
          <? } ?>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label class="free" for="free_shipping_limit">免運門檻</label>
        <input type="number" class="form-control" name="free_shipping_limit" value="<?php echo $delivery['free_shipping_limit']; ?>">
      </div>
      <div class="form-group col-md-12">
        <label class="require" for="shipping_cost">運費</label>
        <input type="number" class="form-control" name="shipping_cost" value="<?php echo $delivery['shipping_cost']; ?>" require>
      </div>
      <div class="form-group col-md-12">
        <h3>限制重量</h3>
        <hr>
      </div>
      <div class="form-group col-md-6">
        <label class="free" for="limit_weight">重量</label>
        <input type="number" class="form-control" name="limit_weight" value="<?php echo $delivery['limit_weight']; ?>">
      </div>
      <div class="form-group col-md-6">
        <label class="free" for="limit_weight_unit">單位</label>
        <input type="text" class="form-control" name="limit_weight_unit" value="<?php echo $delivery['limit_weight_unit']; ?>">
      </div>
      <div class="form-group col-md-12">
        <h3>限制體積/單位cm</h3>
        <hr>
      </div>
      <div class="form-group col-md-4">
        <label class="free" for="limit_volume_length">長度</label>
        <input type="number" class="form-control" name="limit_volume_length" value="<?php echo $delivery['limit_volume_length']; ?>">
      </div>
      <div class="form-group col-md-4">
        <label class="free" for="limit_volume_length">寬度</label>
        <input type="number" class="form-control" name="limit_volume_width" value="<?php echo $delivery['limit_volume_width']; ?>">
      </div>
      <div class="form-group col-md-4">
        <label class="free" for="limit_volume_length">高度</label>
        <input type="number" class="form-control" name="limit_volume_height" value="<?php echo $delivery['limit_volume_height']; ?>">
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>