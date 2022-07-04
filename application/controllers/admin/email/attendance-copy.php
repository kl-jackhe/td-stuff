<?php

$header = '<img src="'.base_url().'assets/images/logo.jpg" height="100px">
        <h3>'.$this->input->post('name').' 您好：</h3>
        <h3>您在 ZF Shop 的訂單已完成訂購，以下是您的訂單明細：</h3>';

$message = '<table style="width:100%;background:#fafaf8;padding:15px;">
<tr style="border-bottom:2px solid #e41c10;">
    <td><h3>【訂購明細】</h3><hr></td>
</tr>
<tr>
    <td>
        付款方式 : '.$shipping_name.'
    </td>
</tr>
<tr>
    <td>
        訂單狀況 : 處理中
    </td>
</tr>
<tr>
    <td>
        訂購日期 : '.date("Y-m-d H:i:s").'
    </td>
</tr>
</table>
';

$content = '<table cellpadding="6" cellspacing="1" style="width:100%" border="0">';

$content .= '<tr>';
        $content .= '<th style="text-align:left;">商品名稱</th>';
        $content .= '<th style="text-align:right;">價格</th>';
        $content .= '<th style="text-align:center;">數量</th>';
        $content .= '<th style="text-align:right">小計</th>';
$content .= '</tr>';

$i = 1;
foreach ($this->cart->contents() as $items):
    $content .= '<tr>';
        $content .= '<td>'.$items['name'];
            if ($this->cart->has_options($items['rowid']) == TRUE):
                $content .= '<p>';

                    foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value):

                            $content .= '<strong>'.$option_name.':</strong>'.$option_value.'<br />';

                    endforeach;
                $content .= '</p>';
            endif;
        $content .= '</td>';
        $content .= '<td style="text-align:right">$ '.$this->cart->format_number($items['price']).'</td>';
        $content .= '<td style="text-align:center">'.$items['qty'].'</td>';
        $content .= '<td style="text-align:right">$ '.$this->cart->format_number($items['subtotal']).'</td>';
    $content .= '</tr>';
$i++;
endforeach;

$content .= '<tr><td colspan="4"><hr></td></tr>';
$content .= '<tr>';
        $content .= '<td colspan="2"> </td>';
        $content .= '<td style="text-align:right"><strong>訂單總計</strong></td>';
        $content .= '<td style="text-align:right">$ '.$this->cart->format_number($this->cart->total()).'</td>';
$content .= '</tr>';
$content .= '<tr><td colspan="4" text-align="center"><a href="'.base_url().'auth/login" target="_blank" class="order-check-btn">訂單查詢</a></td></tr>';

$content .= '</table>';

$information = '<table style="width:100%;background:#fafaf8;padding:15px;">
<tr style="border-bottom:2px solid #e41c10;">
    <td><h3>【收件資訊】</h3><hr></td>
</tr>
<tr>
    <td>
        收件姓名 : '.$this->input->post('name').'
    </td>
</tr>
<tr>
    <td>
        聯絡電話 : '.$this->input->post('phone').'
    </td>
</tr>
<tr>
    <td>
        收件地址 : '.$this->input->post('address').'
    </td>
</tr>
<tr>
    <td>
        <div style="width:100%;background:#fff;padding:15px 0px 15px 10px;border:1px dashed #979797;">
            備註 : '.$this->input->post('remark').'
        </div>
    </td>
</tr>
</table>
';

$footer = '<div style="width:750px;height:70px;;background:#f0f6fa;"><span style="display:block;padding:15px;font-size:12px;">此郵件是系統自動傳送，請勿直接回覆此郵件<p><a href="'.base_url().'">網站首頁</a></p></span><div>';

$body = '<html>
            <head>
                <style>
                	#main-div{
                		font-family: Microsoft JhengHei;
                		color : #222;
                	}
                	.right{
                		text-align: right;
                	}
                	.order-check-btn{
                		display:block;
                		margin:10px auto;
                		width:180px;
                		height:40px;
                		line-height:40px;
                		background:#e7462b;
                		border-bottom:3px solid #cf3020;
                		border-radius:5px;
                		font-size:16px;
    					text-align:center;
    					text-decoration:none;
    					color:#fff;
                	}
                </style>
            </head>
            <body>
                <div id="main-div" style="max-width:750px;font-size:14px;border:1px solid #979797; padding:20px;">
    				'.$header.'
                	'.$message.'
                	'.$content.'
                	'.$information.'
                	'.$footer.'
                </div>
            </body>
        </html>';