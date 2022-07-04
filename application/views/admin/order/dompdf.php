<?php
$page=1;
$num=0;
$html='<style>
  html, body, div, span, applet, object, iframe,
  h1, h2, h3, h4, h5, h6, p, blockquote, pre,
  a, abbr, acronym, address, big, cite, code,
  del, dfn, em, img, ins, kbd, q, s, samp,
  small, strike, strong, sub, sup, tt, var,
  b, u, i, center,
  dl, dt, dd, ol, ul, li,
  fieldset, form, label, legend,
  table, caption, tbody, tfoot, thead, tr, th, td,
  article, aside, canvas, details, embed, 
  figure, figcaption, footer, header, hgroup, 
  menu, nav, output, ruby, section, summary,
  time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    font-family: "msjh";
    vertical-align: baseline;
  }
  body {
    line-height: 1;
  }
  table {
    border-spacing: 0;
    border-collapse: collapse;
  }
  .print{
    margin: 0cm;
    padding: 0cm;
    width: 210mm;
    height: 290mm;
    overflow: hidden;
    page-break-after: always;
  }
  #order_content {
    padding: 5mm;
  }
  div {
    white-space: nowrap;
  }
</style>';

$html .= '
<div class="print" style="margin-top: 1mm; margin-bottom: 0px;">
  <div id="order_content">

    <div style="margin-bottom: 0px; display: block;">
      <div style="font-weight: bold; text-align: center; font-size: 24px;">
        '. get_setting_general('name') .'
      </div>
    </div>

    <div style="clear: both; display: block;">
      <div>
        <div>客戶名稱：'. get_user_full_name($order['customer_id']) .'</div>
        <div>客戶電話：'. $order['customer_phone'] .'</div>
        <div>客戶信箱：'. $order['customer_email'] .'</div>
        <div>店家名稱：'. get_store_name($order['store_id']) .'</div>
        <div>訂單編號：'. $order['order_number'] .'</div>
        <div>訂單日期：'. substr($order['created_at'], 0, 10) .'</div>
        <div>取餐日期：'. $order['order_date'] .'</div>
        <div>取餐時段：'. $order['order_delivery_time'] .'</div>
        <div>
            取餐地點：'. $order['order_delivery_address'] .'
        </div>
      </div>
      <hr>
      <div>
        <div style="width: 1.1cm; text-align: center; float:left">序號</div>
        <div style="width: 12.8cm; text-align: left; float:left">品名</div>
        <div style="width: 1.5cm; text-align: center; float:left">數量</div>
        <div style="width: 2.0cm; text-align: center; float:left">金額</div>
        <div style="clear: both;"></div>
      </div>
    </div>
    <hr>';

  $total=0;
  if(!empty($order_item)) { foreach ($order_item as $data ) {
    $html .= '
      <div style="font-size: 14px; clear; left;">
        <div style="width: 11mm; text-align: center; float:left">'. ($num+1) .'</div>
        <div style="width: 128mm; float:left" overflow:hidden;>'.$data['product_name'].' </div>
        <div style="width: 15mm; text-align: center; float:left">'.floatval($data['order_item_qty']).'</div>
        <div style="width: 20mm; text-align: center; float:left">'.number_format($data['order_item_qty']*$data['order_item_price']).'</div>
      </div><div style="clear: both;"></div>';
    $total+=$data['order_item_qty']*$data['order_item_price'];
    $num++;
  }}

    $html .='
      <div style="clear: both;"></div>
      <hr>
      <div>付款方式：'. get_payment($order['order_payment']) .'</div>
      <div>使用優惠券：'. get_coupon_name($order['order_coupon']) .'</div>
      <div>備註：'.$order['order_remark'].'&nbsp;</div>
      <hr>';
    $html .='
      <div class="pull-right">小計：'. number_format($total) .'</div>
      <div class="pull-right">運費：'. number_format($order['order_delivery_cost']) .'</div>
      <div class="pull-right" style="display: none;">服務費：'. number_format($total*0.1) .'</div>
      <div class="pull-right">優惠券折抵：-'. number_format($order['order_discount_price']) .'</div>
      <div class="pull-right fs-16 color-595757 bold">總計：'. number_format($order['order_discount_total']) .'</div>
      ';
    $html .='<div></div>';

// $html .='</div></div>';

// echo $html;
// 只匯入需要用到的字體，這樣pdf檔案會小很多
$dompdf = new \Dompdf\Dompdf(array('enable_font_subsetting' => true));

$dompdf->loadHtml($html);

// (選項) 設定紙張尺寸和方向
// $dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4', 'portrait');
// $dompdf->setPaper(array(0,0,684,396), 'portrait');

// 給予 HTML to PDF
$dompdf->render();
$filename = 'order_number_'.$order['order_number'];
// $filename = 'sales_order';

// 預覽
$dompdf->stream($filename,array("Attachment"=>0));
?>