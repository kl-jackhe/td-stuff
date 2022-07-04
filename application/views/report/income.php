<div class="row">
  <div class="col-md-6">
    <?php if(!empty($result)){ ?>
    <?php (int)$total_sum=0;
    foreach ($result as $data):
      $total_sum+=$data['order_total'];
    endforeach ?>
    <?php echo '查詢: '.$this->input->get('start_date').' 到 '.$this->input->get('end_date').' 的營業收入: <br>'.'<h3>NT$ '.number_format($total_sum).'</h3>'; ?>
    <?php } ?>
  </div>
  <div class="col-md-6 hidden-print">
    <?php $attributes = array('class' => 'form-inline text-right', 'id' => 'search-form', 'method' => 'get'); ?>
    <?php echo form_open('report/search' , $attributes); ?>
      <div class="form-group">
        <input type="text" class="form-control text-center datepicker" name="start_date" placeholder="起始日期" size="9" value="<?php echo @$_GET['start_date'] ?>" autocomplete="off">
        <input type="text" class="form-control text-center datepicker" name="end_date" placeholder="終止日期" size="9" value="<?php echo @$_GET['end_date'] ?>" autocomplete="off">
        <!-- <input type="text" class="form-control" name="word" placeholder="請輸入關鍵字..."> -->
        <select name="type" class="form-control">
          <option value="income">營業收入</option>
          <!-- <option value="customer">客戶</option>
          <option value="manufacturer">廠商</option>
          <option value="distributor">配送單位</option>
          <option value="car">車號</option> -->
        </select>
      </div>
      <button type="submit" class="btn btn-primary">搜尋</button>
    <?php echo form_close() ?>
    <br>
  </div>
</div>
<div class="row">
  <div class="col-md-8">
    <div class="table-responsive">
      <?php if(empty($result)){echo '<h3>查無資料。</h3>';} else { ?>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr class="info">
            <th class="text-center">單號</th>
            <th>訂單金額</th>
            <th>經手人</th>
            <th>訂單日期</th>
            <!-- <th>操作</th> -->
          </tr>
        </thead>
        <?php foreach ($result as $data): ?>
          <tr>
            <td class="text-center"><?php echo $data['order_id'] ?></td>
            <td><?php echo 'NT$ '.number_format($data['order_total']) ?></td>
            <td><?php echo get_user_username($data['creator_id']) ?></td>
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
  <div class="col-md-4">
    <?php
    $query = $this->db->get('product');
    if ($query->num_rows() > 0) {
      $result = $query->result_array(); ?>
      <table class="table table-hover">
        <tr class="info">
          <th>商品名稱</th>
          <th>賣出數量</th>
        </tr>
      <?php foreach ($result as $data) {
          $product_id = $data['product_id'];
          $start_date = $this->input->get('start_date');
          $end_date = $this->input->get('end_date');

          if (!empty($start_date)) {

              if($start_date==$end_date){
                  $this->db->like('created_at',$start_date);
              } else {
                  //$start_date=str_replace("-","",$start_date);
                  //$end_date=str_replace("-","",$end_date);
                  $start_date=$start_date.' 00:00:00';
                  $end_date=$end_date.' 23:59:59';
                  $this->db->where('created_at >=', $start_date);
                  $this->db->where('created_at <=', $end_date);
              }

          }
          //$query = $this->db->query('SELECT product_id,SUM(order_item_qty) as qty FROM `order_item` WHERE product_id = '.$product_id.'');
          $this->db->select('product_id');
          $this->db->select_sum('order_item_qty');
          $this->db->where('product_id', $product_id);
          $query = $this->db->get('pos_order_item');
          if ($query->num_rows() > 0) {
            $result = $query->result_array(); ?>
            <?php foreach ($result as $data) {
              if(!empty($data['product_id'])){
              echo "<tr>";
              echo '<td>'.get_product_name($data['product_id']).'</td>';
              echo '<td>'.$data['order_item_qty'].'</td>';
              echo "</tr>";
              }
            }
          }
      } ?>
      </table>
    <?php } ?>
  </div>
</div>