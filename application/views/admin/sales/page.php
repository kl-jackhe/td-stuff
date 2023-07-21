<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-hover" style="border-radius: 10px;margin-top: 20px;">
            <tr class="info">
                <th>ID</th>
                <th>商品名稱</th>
                <th>網址</th>
                <th>日期</th>
                <th>狀態</th>
                <th>操作</th>
            </tr>
            <? if (!empty($SingleSales)) {
                foreach ($SingleSales as $row) { ?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=get_product_name($row['product_id'])?></td>
                        <td><?=$row['url']?></td>
                        <td>
                            <p>展示：<?=$row['pre_date']?></p>
                            <p>開始：<?=$row['start_date']?></p>
                            <p>結束：<?=$row['end_date']?></p>
                        </td>
                        <td>
                            <p><?=$row['status']?></p>
                            <p>建立時間：<?=$row['created_at']?></p>
                            <p>更新時間：<?=$row['updated_at']?></p>
                        </td>
                        <td>
                            <a class="btn btn-info" href="sales/editSingleSales/<?=$row['id']?>" target="_blank">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                    <?
                }
            } else { ?>
                <tr>
                    <td colspan="15">
                        <center><?php echo $this->lang->line('no_data') ?></center>
                    </td>
                </tr>
            <? } ?>
        </table>
    </div>
</div>
