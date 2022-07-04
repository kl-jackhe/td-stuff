<?php $attributes = array('method' => 'post'); ?>
<?php echo form_open('admin/store_order_time_area/create' , $attributes); ?>
      <div class="form-group">
            <?php if(!empty($store)): ?>
            <label for="store">選擇店家(可以使用ctrl複選及拖曳複選)</label>
            <?php
            // $att = 'id="store" class="form-control" onchange="javascript:location.href = this.value;"';
            $att = 'id="store" class="form-control" size="10" required';
            $options = array();
            // $options = array("0" => "---請選擇---");
            foreach ($store as $c)
            {
                  $options[$c['store_id']] = $c['store_name'];
            }
            // echo form_dropdown('store', $options, '0', $att);
            echo form_multiselect('store[]', $options, '0', $att);
            else: echo '<label>沒有店家</label><input type="text" class="form-control" id="store" name="store" value="0" readonly>';
            endif; ?>
      </div>
      <div class="form-group">
            <button class="btn btn-primary" type="submit">下一步</button>
      </div>
<?php echo form_close() ?>

<!-- <div class="form-group">
      <?php // if(!empty($store)): ?>
      <label for="store">選擇店家</label>
      <?php /* $att = 'id="store" class="form-control" onchange="javascript:location.href = this.value;"';
      $data = array("0" => "---請選擇---");
      foreach ($store as $c)
      {
            $data[base_url().'admin/store_order_time_area/create/'.$c['store_id']] = $c['store_name'];
      }
      echo form_dropdown('store', $data, '0', $att);
      else: echo '<label>沒有店家</label><input type="text" class="form-control" id="store" name="store" value="0" readonly>';
      endif; */ ?>
</div> -->