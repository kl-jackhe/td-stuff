<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <button class="btn btn-primary hidden-print" onclick="window.print();return false;">列印</button>
    </div>
  </div>
  <div class="col-md-6">
    <?php if(!empty($result)){
    $total_sum=0;
    foreach ($result as $data):
      //(int)$sub_total = $data['sales_cost'] * $data['sales_quantity'];
      (int)$total_sum+=$data['sales_price'];
    endforeach;
    echo '查詢: '.$this->input->get('start_date').' 到 '.$this->input->get('end_date').' 的銷售費用: <br>'.'<h3>$'.number_format($total_sum).'</h3>';
    } ?>
  </div>
  <div class="col-md-6 hidden-print hide">
    <?php $attributes = array('class' => 'form-inline text-right', 'id' => 'search-form', 'method' => 'get'); ?>
    <?php echo form_open('report/search' , $attributes); ?>
      <div class="form-group">
        <input type="text" class="form-control text-center datepicker" name="start_date" placeholder="起始日期" size="9" value="<?php echo @$_GET['start_date'] ?>" autocomplete="off">
        <input type="text" class="form-control text-center datepicker" name="end_date" placeholder="終止日期" size="9" value="<?php echo @$_GET['end_date'] ?>" autocomplete="off">
        <!-- <input type="text" class="form-control" name="word" placeholder="請輸入關鍵字..."> -->
        <select name="type" class="form-control">
          <option value="sales">銷售費用</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">搜尋</button>
    <?php echo form_close() ?>
    <br>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
      <?php if(empty($result)){echo '<h3>查無資料。</h3>';} else { ?>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr class="info">
            <th class="text-center">單號</th>
            <th>商品</th>
            <th class="text-right">成本</th>
            <th class="text-center">數量</th>
            <th class="text-right">小計</th>
            <th>建檔日期</th>
            <!-- <th>操作</th> -->
          </tr>
        </thead>
        <?php foreach ($result_item as $data): ?>
          <tr>
            <td class="text-center"><?php echo $data['sales_id'] ?></td>
            <td><?php echo get_product_name($data['product_id']) ?></td>
            <td align="right"><?php echo '$'.$data['sales_item_price'] ?></td>
            <td align="center"><?php echo $data['sales_item_qty'] ?></td>
            <td align="right"><?php echo '$'.number_format($data['sales_item_price']*$data['sales_item_qty']) ?></td>
            <td><?php echo $data['created_at'] ?></td>
            <!-- <td>
              <a href="payable/edit/<?php echo $data['order_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
              <a href="payable/delete/<?php echo $data['order_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i></a>
            </td> -->
          </tr>
        <?php endforeach ?>
      </table>
      <?php } ?>
    </div>
  </div>
</div>