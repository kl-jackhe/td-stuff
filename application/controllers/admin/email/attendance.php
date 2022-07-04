<?php

$header = '<img src="'.base_url().'assets/images/logo.png" height="100px">
        <h3>'.get_user_username($this->input->post('top_employee_id')).' 您好：</h3>
        <h3>員工簽到通知，以下是通知訊息：</h3>';

$message = '
<table style="width:100%;background:#fafaf8;padding:15px;">
    <tr>
        <td>
            <h3>【通知訊息】</h3>
            <hr>
        </td>
    </tr>
    <tr>
        <td>
            簽到員工 : '.get_user_username($this->input->post('employee_id')).'
        </td>
    </tr>
    <tr>
        <td>
            類型 : '.get_attendance_type($this->input->post('attendance_type')).'
        </td>
    </tr>
    <tr>
        <td>
            內容 : '.$this->input->post('attendance_description').'
        </td>
    </tr>
    <tr>
        <td>
            使用時數 : '.$this->input->post('attendance_time').'
        </td>
    </tr>
</table>';

$message .= '<table style="width:100%" border="0">';
$message .= '<tr>
                <td text-align="center">
                    <a href="'.base_url().'attendance/edit/'.$attendance_id.'" target="_blank" class="order-check-btn">查看</a>
                </td>
            </tr>';
$message .= '</table>';

$footer = '
<div style="width:750px;height:70px;;background:#f0f6fa;">
    <div style="display:block;padding:15px;font-size:12px;">
        <span>此郵件是系統自動傳送，請勿直接回覆此郵件。</span>
        <p>
            <a href="'.base_url().'" target="_blank">網站首頁</a>
        </p>
    </div>
<div>';

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
                	'.$footer.'
                </div>
            </body>
        </html>';