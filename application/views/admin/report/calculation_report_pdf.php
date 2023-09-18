<style>
#order_content div {
    float: left;
}

.print {
    page-break-after: always;
}

#order_content td {
    padding: 3px !important;
    border: 1px solid #000;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #000 !important;
}

@page {
    /*size: A4;*/
    margin: 2cm;
    padding: 2cm;
    margin-top: 0px;
    padding-top: 0cm;
}

@page: first {
    /*size: A4;*/
    margin: 2cm;
    padding: 2cm;
    margin-top: -48px;
    padding-top: 0cm;
}

@media print {
    body {
        line-height: 1;
    }

    table {
        border-spacing: 0;
        border-collapse: collapse;
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
    <button class="btn btn-primary hidden-print" id="print-btn" onclick="window.print();return false;"><i class="fa fa-print"></i>
        <?php echo $this->lang->line('print') ?></button>
</div>
<div class="main">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="5">製表日期：<?=$data['date_now']?></th>
            </tr>
            <tr>
                <th colspan="5">銷售詳細表</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>名字</td>
                <td><?=$data['name']?></td>
            </tr>
            <tr>
                <td>開始日期</td>
                <td><?=$data['start_date']?></td>
            </tr>
            <tr>
                <td>結束日期</td>
                <td><?=$data['end_date']?></td>
            </tr>
            <tr>
                <td>總點擊數</td>
                <td><?=$data['start_hits'] + $data['pre_hits']?></td>
            </tr>
            <tr>
                <td>總訂單數</td>
                <td><?=$data['order_qty']?></td>
            </tr>
            <tr>
                <td>完成數</td>
                <td><?=$data['finish_qty']?></td>
            </tr>
            <tr>
                <td>取消數</td>
                <td><?=$data['cancel_qty']?></td>
            </tr>
            <tr>
                <td>成交率</td>
                <td><?=$data['turnover_rate']?></td>
            </tr>
            <tr>
                <td>總銷售額</td>
                <td><?=$data['turnover_amount']?></td>
            </tr>
            <tr>
                <td>利潤％</td>
                <td><?=$data['profit_percentage']?></td>
            </tr>
            <tr>
                <td>收益</td>
                <td><?=$data['income']?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>簽名</td>
                <td style="height: 100px;"></td>
            </tr>
        </tfoot>
    </table>
</div>