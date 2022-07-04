
<div class="form-group">
      <?php if(!empty($store)): ?>
      <label for="store">選擇店家</label>
      <?php $att = 'id="store" class="form-control" onchange="javascript:location.href = this.value;"';
      $data = array("0" => "---請選擇---");
      foreach ($store as $c)
      {
            $data[base_url().'admin/store_order_time/create/'.$c['store_id']] = $c['store_name'];
      }
      echo form_dropdown('store', $data, '0', $att);
      else: echo '<label>沒有店家</label><input type="text" class="form-control" id="store" name="store" value="0" readonly>';
      endif; ?>
</div>