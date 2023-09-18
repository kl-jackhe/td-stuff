<?
print_r('<pre>');
print_r($data);
print_r('</pre>');

?>

<style>
#order_content div {
  float: left;
}

.print {
  page-break-after: always;
}

#order_content td{
  padding: 3px!important;
  border: 1px solid #000;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #000 !important;
}

@page {
  /*size: A4;*/
  margin: 0cm;
  padding: 0cm;
  margin-top: 0px;
  padding-top: 0cm;
}

@page:first {
  /*size: A4;*/
  margin: 0cm;
  padding: 0cm;
  margin-top: -48px;
  padding-top: 0cm;
}

@media print {
  body {
      line-height: 1;
  }
  table {
      border-spacing:0;
      border-collapse:collapse;
  }
  .print {
    page-break-after: always;
    padding: 0px;
    margin: 0px;
    margin-left: 0.5cm;
    margin-top: 0.5cm;
  }
}
</style>
<div class="form-group form-inline hidden-print">
  <button class="btn btn-primary hidden-print" id="print-btn" onclick="window.print();return false;"><i class="fa fa-print"></i> <?php echo $this->lang->line('print') ?></button>
</div>

<?php
if(isset($array_sales_id) && !empty($array_sales_id)){
  $array_sales_id = $array_sales_id;
} else {
  $array_sales_id = array();
  array_push($array_sales_id, $sales['sales_id']);
}

foreach ($array_sales_id as $sales_id) {

  $page=1;
  $num=0;
  $is_next_page=1;
  $final_page=0;
  // 取得筆數
  $this->db->where('sales_id', $sales_id);
  $count_item = $this->db->count_all_results('sales_order_item');
  $total_page = ceil($count_item/40);
  $sales = $this->sales_model->get_sales_order_with_customer($sales_id, 'sales_order');
  ?>

  <?php while($is_next_page == '1') { ?>

  <?php require('header.php'); ?>

  <div class="main">

    <!-- 計算num-40筆資料的文字長度 -->
    <?php
    $this->db->select("*");
    $this->db->where('sales_id', $sales_id);
    $this->db->limit(40, $num);
    $this->db->order_by('sales_item_sort', 'asc');
    $query = $this->db->get('sales_order_item');
    if ($query->num_rows() > 0) {
      if (($count_item-$num)>40) {$is_next_page='1'; $page++;} else { $is_next_page='0'; $final_page='1';}
    }

    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $data ) { ?>
        <div>
          <div style="width: 1cm; text-align: center;"><?php echo $num+1; ?></div>
          <!-- <div style="width: 2cm;"><?php echo $data['product_sku'] ?>&nbsp;</div> -->
          <div style="width: 9cm; height: 20px; overflow: hidden; white-space: nowrap;">
            <?php echo $data['product_name'].' '.$data['sales_item_specification'] ?>&nbsp;
          </div>
          <div style="width: 1cm; text-align: right;"><?php echo floatval($data['sales_item_qty']) ?></div>
          <div style="width: 1cm; padding-left: 0.1cm"><?php echo $data['product_unit'] ?></div>
          <div style="width: 2cm; text-align: right;">
            <?php
            echo '<span class="price" style="'.($sales['sales_print_price']=='1'?'':'display: none').'">';
            echo get_0_show_empty($data['sales_item_price']);
            echo '</span>&nbsp;';
            ?>
          </div>
          <div style="width: 2cm; text-align: right;">
            <?php
            echo '<span class="price" style="'.($sales['sales_print_price']=='1'?'':'display: none').'">';
            echo get_0_show_empty(get_subtotal($data['sales_item_price'],$data['sales_item_qty'],$data['sales_item_discount'],get_setting_general('sales_order_decimal_point')));
            echo '</span>&nbsp;';
            ?>
          </div>
          <div style="width: 4cm; padding-left: 0.3cm; overflow: hidden; white-space: nowrap;"><?php echo $data['sales_item_remark'] ?>&nbsp;</div>
        </div>
        <?php $num++;
      }
    } ?>

  </div>

  <?php require('footer.php'); ?>

  <?php } ?>

<?php } ?>