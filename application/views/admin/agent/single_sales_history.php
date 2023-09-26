<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped" id="single_sales_history_table">
            <thead>
                <tr class="info">
                    <th>ID</th>
                    <th>商品名稱</th>
                    <th>開始時間</th>
                    <th>結束時間</th>
                    <th>銷售總天數</th>
                    <th>銷售總數量</th>
                    <th>銷售總額</th>
                    <th>總點擊數</th>
                    <th>狀態</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?if (!empty($sales_page)) {
                    foreach ($sales_page as $sales) {
                        $datetime1 = new DateTime($sales['start_date']);
                        $datetime2 = new DateTime($sales['end_date']);
                        $interval = $datetime1->diff($datetime2);
                        $daysDiff = $interval->days;?>
                        <tr <?=($sales['status'] == 'Closure' ? 'style="background-color: #FFB5B5;"' : '')?>>
                            <td>
                                <a href="editSingleSales/<?=$sales['single_sales_id']?>" target="_blank">
                                    <?=$sales['single_sales_id']?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            </td>
                            <td>
                                <a href="/admin/product/edit/<?=$sales['product_id']?>" target="_blank">
                                    <?=get_product_name($sales['product_id'])?>&ensp;<i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            </td>
                            <td><?=$sales['start_date']?></td>
                            <td><?=$sales['end_date']?></td>
                            <td><?=$daysDiff?></td>
                            <td><?=$this->order_model->getOrderProductQTY($sales['single_sales_id'],$sales['agent_id'])?></td>
                            <td><?='$' . format_number($this->order_model->getOrderTotalAmount($sales['single_sales_id'],$sales['agent_id']))?></td>
                            <td><?=$sales['pre_hits'] + $sales['start_hits']?></td>
                            <td><?=$this->lang->line($sales['status'])?></td>
                            <td>
                                <span class="btn btn-success btn-sm <?=($sales['status'] == 'Closure'? '' : 'hide')?>" data-toggle="modal" data-target="#reportModal" onclick="viewCalculationReport('<?=$sales['single_sales_id']?>')">查看報表</span>
                            </td>
                        </tr>
                    <?}
                } else {?>
                    <tr>
                        <td colspan="15">
                            <center>對不起, 沒有資料 !</center>
                        </td>
                    </tr>
                <?}?>
            </tbody>
        </table>
    </div>
</div>