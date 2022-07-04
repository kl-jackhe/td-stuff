<link rel="stylesheet" href="/node_modules/print-js/dist/print.min.css">
<style>
  canvas{
    width: 100%;
  }
  @page {
    /*size: A4;
    margin-top: 2cm;*/
    /*margin: 0.5cm;*/
  }
  table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
  }
  table.table thead th{
    background: url(/assets/images/sort_both.png) no-repeat center right;
  }
  @media print {
    .rows-print-as-pages .row {
      page-break-before: always;
    }
    table{width:100%;}
    /* include this style if you want the first row to be on the same page as whatever precedes it */
    /*
    .rows-print-as-pages .row:first-child {
      page-break-before: avoid;
    }
    */
  }
</style>
<?php $dataPoints = array(); ?>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <button class="btn btn-primary hidden-print" onclick="window.print();return false;">列印</button>
      <button class="btn btn-primary hidden-print" onclick="printJS('chartContainer', 'html')">列印圖表</button>
      <button class="btn btn-primary hidden-print" onclick="printJS('product_qty_table', 'html')">列印銷售數量表</button>
    </div>
  </div>
  <div class="col-md-6">
    <?php if(!empty($result)){
    $total_sum=0;
    foreach ($result as $data):
      $total_sum+=$data['order_discount_total'];
    endforeach;
    $tax_sum = round($total_sum*get_setting_general('company_tax'));
    echo '<h3>查詢: '.$this->input->get('start_date').' 到 '.$this->input->get('end_date').' 的營業收入:</h3>';
    echo '<h4>稅前金額： $'.number_format($total_sum/1.05).'</h4>';
    echo '<h4>營業稅額： $'.number_format(($total_sum/1.05)*0.05).'</h4>';
    echo '<h4>總營業額： $'.number_format($total_sum).'</h4>';
    echo '<h4>訂單數量： '.count($result).'</h4>';
    } ?>
  </div>
  <div class="col-md-6">
    <h4>發票使用區間：</h3>
    <span><?php echo $fist_invoice['invoice_number'] ?></span><br><span><?php echo $last_invoice['invoice_number'] ?></span>
    <hr>
  </div>
  <div class="col-md-6 hidden-print hide">
    <?php $attributes = array('class' => 'form-inline text-right', 'id' => 'search-form', 'method' => 'get'); ?>
    <?php echo form_open('report/search' , $attributes); ?>
      <div class="form-group">
        <input type="text" class="form-control text-center datepicker" name="start_date" placeholder="起始日期" size="9" value="<?php echo @$_GET['start_date'] ?>" autocomplete="off">
        <input type="text" class="form-control text-center datepicker" name="end_date" placeholder="終止日期" size="9" value="<?php echo @$_GET['end_date'] ?>" autocomplete="off">
        <select name="type" class="form-control">
          <option value="income">POS收入</option>
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
      <table class="table table-striped table-condensed table-hover sortable">
        <thead>
          <tr class="info">
            <th class="text-center">單號</th>
            <th>發票號碼</th>
            <th class="text-right">訂單金額</th>
            <th>訂單日期</th>
          </tr>
        </thead>
        <?php foreach ($result as $data): ?>
          <tr>
            <td class="text-center"><?php echo $data['order_id'] ?></td>
            <td><?php echo $data['invoice_number'] ?></td>
            <td class="text-right"><?php echo '$'.number_format($data['order_total']) ?></td>
            <td><?php echo $data['created_at'] ?></td>
          </tr>
        <?php endforeach ?>
      </table>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-12">
    <div class="table-responsive">
      <h4>作廢訂單：</h4>
      <?php if(empty($void_result)){echo '<h3>查無資料。</h3>';} else { ?>
      <table class="table table-striped table-condensed table-hover sortable">
        <thead>
          <tr class="danger">
            <th class="text-center">單號</th>
            <th>發票號碼</th>
            <th class="text-right">訂單金額</th>
            <th>訂單日期</th>
          </tr>
        </thead>
        <?php foreach ($void_result as $data): ?>
          <tr>
            <td class="text-center"><?php echo $data['order_id'] ?></td>
            <td><?php echo $data['invoice_number'] ?></td>
            <td class="text-right"><?php echo '$'.number_format($data['order_total']) ?></td>
            <td><?php echo $data['created_at'] ?></td>
          </tr>
        <?php endforeach ?>
      </table>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-12" >
    <?php $query = $this->db->get('product');
    if ($query->num_rows() > 0) {
      $result = $query->result_array(); ?>
      <h4>各商品銷售數量：</h4>
      <table class="table table-striped table-hover sortable" id="product_qty_table">
        <thead>
          <tr class="info">
            <th>商品名稱</th>
            <th>商品分類</th>
            <th>賣出數量</th>
          </tr>
        </thead>
        <?php foreach ($result as $data) {
        $product_id = $data['product_id'];
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (!empty($start_date)) {

            if($start_date==$end_date){
                $this->db->like('pos_order_item.created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('pos_order_item.created_at >=', $start_date);
                $this->db->where('pos_order_item.created_at <=', $end_date);
            }
        }
        //$query = $this->db->query('SELECT product_id,SUM(order_item_qty) as qty FROM `order_item` WHERE product_id = '.$product_id.'');
        $this->db->join('pos_order', 'pos_order.order_id = pos_order_item.order_id');
        $this->db->select('product_id');
        $this->db->select_sum('order_item_qty');
        $this->db->where('pos_order.order_status', '1');
        $this->db->where('order_item_status', '1');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('pos_order_item');
        if ($query->num_rows() > 0) {
          $result = $query->result_array(); ?>
          <?php foreach ($result as $data) {
            if(!empty($data['product_id'])){
              echo "<tr>";
              echo '<td>'.get_product_name($data['product_id']).'</td>';
              echo '<td>'.get_product_category_name(get_product_category($data['product_id'])).'</td>';
              echo '<td>'.$data['order_item_qty'].'</td>';
              echo "</tr>";
              //echo json_encode($data);
              //$labels[] = get_product_name($data['product_id']);
              //$labelsdata[] = $data['order_item_qty'];
              //$labelscolor[] = generateRandomColor();
              $point = array("label" => get_product_name($data['product_id']), "y" => $data['order_item_qty']);
              array_push($dataPoints, $point);
              //$dataPoints[] = array('label' => get_product_name($data['product_id']), 'y' => $data['order_item_qty']);
              //echo json_encode($dataPoints);
            }
          }
        }
      } ?>
      </table>
    <?php } ?>
  </div>

  <div class="col-md-12 rows-print-as-pages">
    <div class="row">
      <div id="chartContainer" style="width: 100%;"></div>
    </div>
  </div>

</div>

<?php
//echo json_encode($dataPoints);
?>
<script src="/assets/admin/js/sort-table.js"></script>
<script>
window.onload = function() {
var chart = new CanvasJS.Chart("chartContainer", {
  exportEnabled: true,
  animationEnabled: true,
  title: {
    text: "各商品銷售數量"
  },
  subtitles: [{
    text: ""
  }],
  data: [{
    type: "column",
    markerType: "circle",
    yValueFormatString: "#,##0\"個\"",
    //indexLabel: "{label} ({y})",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});

chart.render();
}
</script>
<script src="/assets/admin/canvasjs/canvasjs.min.js"></script>
<script src="/node_modules/print-js/dist/print.min.js"></script>