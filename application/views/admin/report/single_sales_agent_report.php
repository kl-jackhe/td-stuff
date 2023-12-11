<div class="row">
	<?if (!empty($SingleSalesDetail)) {?>
		<div class="col-md-12">
			<h3>銷售商品：<?=get_product_name($SingleSalesDetail['product_id'])?></h3>
		</div>
	<?}?>
	<div class="col-md-12"><hr></div>
	<div class="col-md-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr class="info">
					<th>ID</th>
					<th>代言人</th>
					<th>銷售總額</th>
					<th>利潤百分比</th>
					<th>收益</th>
					<th>訂單總數</th>
					<th>成交率</th>
					<th class="text-center">簽收單</th>
					<th>狀態</th>
				</tr>
			</thead>
			<tbody>
				<?if (!empty($SingleSalesAgentList) && !empty($SingleSalesDetail)) {
					foreach ($SingleSalesAgentList as $ssal_row) {?>
						<tr>
							<td><?=$ssal_row['agent_id']?></td>
							<td><?=$ssal_row['agent_name']?></td>
							<td><?=number_format($ssal_row['turnover_amount'])?></td>
							<td><?=($ssal_row['profit_percentage'] > 0 ? $SingleSalesDetail['default_profit_percentage'] : $ssal_row['profit_percentage'] )?></td>
							<td><?=number_format($ssal_row['income'])?></td>
							<td><?=$ssal_row['order_qty']?></td>
							<td><?=$ssal_row['turnover_rate']?></td>
							<td class="text-center" style="font-size: 24px; color: red;"><a href="/admin/sales/viewCalculationReportPDF?ssid=<?=$SingleSalesDetail['id']?>&aid=<?=$ssal_row['agent_id']?>" target="_blank" style="cursor: pointer;"><i class="fa-solid fa-file-pdf"></i></a></td>
							<td></td>
						</tr>
					<?}
				} else {?>
					<tr>
	                    <td colspan="15">
	                        <center>尚無資料！</center>
	                    </td>
	                </tr>
				<?}?>
			</tbody>
		</table>
	</div>
</div>
<script>
	function downloadCalculationReportPDF(single_sales_id,agent_id) {
        $.ajax({
        	type: "POST",
            url: '/admin/sales/downloadCalculationReportPDF',
            dataType: 'json',
            data: {
                single_sales_id: single_sales_id,
                agent_id: agent_id,
            },
            success: function (data) {
                if (data['ExecutionResults'] == 'yes') {
                    generatePDF(data['SingleSalesAgent']);
                } else {
                	alert('執行失敗！');
                }
            },
            error: function(data) {
                console.log(data);
                alert('異常錯誤！');
            }
        });
    }
</script>