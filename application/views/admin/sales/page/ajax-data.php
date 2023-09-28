<?php echo $this->ajax_pagination_admin->create_links(); ?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-hover" id="datatable" style="border-top-width: 0px;border-left-width: 0px;border-right-width: 0px;border-bottom-width: 0px;">
          <? if (!empty($SingleSales)) {?>
            <tr class="info">
                <th>ID</th>
                <th>商品名稱</th>
                <?if ($SingleStatus == 'History' || $SingleStatus == 'Finish') {?><th>開始時間</th><?}?>
                <?if ($SingleStatus == 'OnSale' || $SingleStatus == 'ForSale') {?><th>倒數時間</th><?}?>
                <th>結束時間</th>
                <th>銷售人員</th>
                <?if ($SingleStatus == 'History' || $SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {?><th>銷售總天數</th><?}?>
                <?if ($SingleStatus == 'History' || $SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {?><th>銷售總數量</th><?}?>
                <?if ($SingleStatus == 'History' || $SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {?><th>銷售總額</th><?}?>
                <?if ($SingleStatus == 'OnSale' || $SingleStatus == 'ForSale') {?><th>點擊數</th><?}?>
                <?if ($SingleStatus == 'History' || $SingleStatus == 'Finish') {?><th>總點擊數</th><?}?>
                <?if ($SingleStatus == 'Test') {?><th>日期</th><?}?>
                <?if ($SingleStatus == 'History') {?><th>狀態</th><?}?>
                <?if ($SingleStatus == 'History' || $SingleStatus == 'Finish') {?><th>操作</th><?}?>
            </tr>
                <?foreach ($SingleSales as $row) {
                  if (!empty($SingleSalesAgent)) {
                    $count = 0;
                    $pre_hits = 0;
                    $start_hits = 0;
                    $sales_staff = array();
                    $sales_staff_list_str = '';
                    $sales_staff_hits_list_str = '';
                    foreach ($SingleSalesAgent as $ssa_row) {
                      if ($ssa_row['single_sales_id'] == $row['id']) {
                        $count++;
                        $sales_staff[] = array(
                          'agent_id' => $ssa_row['agent_id'],
                        );
                        $pre_hits += $ssa_row['pre_hits'];
                        $start_hits += $ssa_row['start_hits'];
                        $sales_staff_list_str .= $count . '. ' . $this->agent_model->getAgentName($ssa_row['agent_id']) . '&emsp;' . format_number($ssa_row['profit_percentage']) . '%' . '<br>';
                        $sales_staff_hits_list_str .= $count . '. ' . $this->agent_model->getAgentName($ssa_row['agent_id']) . '<br>當前點擊數：' . $ssa_row['start_hits'] . '<br>';
                      }
                    }
                  }
                  ?>
                    <tr <?=($row['status'] == 'Closure' ? 'style="background-color: #FFB5B5;"' : '')?>>
                        <td>
                          <a href="editSingleSales/<?=$row['id']?>" target="_blank">
                            <?=$row['id']?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
                          </a>
                        </td>
                        <td>
                          <a href="/admin/product/edit/<?=$row['product_id']?>" target="_blank">
                            <?=get_product_name($row['product_id'])?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
                          </a>
                        </td>
                        <?if ($SingleStatus == 'History' || $SingleStatus == 'Finish') {?>
                          <td><?=$row['start_date']?></td>
                        <?}?>
                        <?if ($SingleStatus == 'OnSale' || $SingleStatus == 'ForSale') {
                          $toDay = date('Y-m-d');
                          if ($SingleStatus == 'OnSale') {
                            $datetime1 = new DateTime($toDay);
                            $datetime2 = new DateTime($row['end_date']);
                          }
                          if ($SingleStatus == 'ForSale') {
                            $datetime1 = new DateTime($toDay);
                            $datetime2 = new DateTime($row['start_date']);
                          }
                          $interval = $datetime1->diff($datetime2);
                          $daysDiff = $interval->days;
                          ?>
                          <td><?=$daysDiff?></td>
                        <?}?>
                        <td>
                          <?=$row['end_date']?>
                        </td>
                        <td>
                          <div style="padding-bottom: 5px;border-bottom: 1px solid gray;">
                            <span data-html="true" data-toggle="tooltip" data-placement="right" data-original-title="<?=$sales_staff_list_str?>">
                              <?=$count?> 人 <i class="fa-regular fa-circle-question"></i>
                            </span>
                          </div>
                          <?if ($SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {
                            for ($i=0; $i < count($sales_staff); $i++) {
                              if ($this->order_model->getOrderTotalAmount($row['id'],$sales_staff[$i]['agent_id']) > 0) {?>
                                <div style="padding-top: 10px;">
                                  <span style="border: 1px solid gray;padding: 3px 6px 3px 6px;border-radius: 5px;" data-html="true" data-toggle="tooltip" data-placement="right" data-original-title="銷售數量：<?=$this->order_model->getOrderProductQTY($row['id'],$sales_staff[$i]['agent_id'])?><br>銷售金額：<?='$' . format_number($this->order_model->getOrderTotalAmount($row['id'],$sales_staff[$i]['agent_id']))?>">
                                    <?=$this->agent_model->getAgentName($sales_staff[$i]['agent_id'])?> <i class="fa-solid fa-circle-info"></i>
                                  </span>
                                </div>
                              <?}
                            }
                          }?>
                        </td>
                        <?if ($SingleStatus == 'History' || $SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {
                          $datetime1 = new DateTime($row['start_date']);
                          $datetime2 = new DateTime($row['end_date']);
                          $interval = $datetime1->diff($datetime2);
                          $daysDiff = $interval->days;?>
                          <td><?=$daysDiff?></td>
                        <?}?>
                        <?if ($SingleStatus == 'History' || $SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {?>
                          <td><?=$this->order_model->getOrderProductQTY($row['id'])?></td>
                        <?}?>
                        <?if ($SingleStatus == 'History' || $SingleStatus == 'OnSale' || $SingleStatus == 'Finish') {?>
                          <td><?='$' . format_number($this->order_model->getOrderTotalAmount($row['id']))?></td>
                        <?}?>
                        <?if ($SingleStatus == 'ForSale') {?>
                          <td><?=$pre_hits?></td>
                        <?}?>
                        <?if ($SingleStatus == 'OnSale') {?>
                          <td>
                              <div style="padding-bottom: 5px;border-bottom: 1px solid gray;">
                                <span data-html="true" data-toggle="tooltip" data-placement="left" data-original-title="<?=$sales_staff_hits_list_str?>">
                                  <?=$start_hits?> <i class="fa-regular fa-circle-question"></i>
                                </span>
                              </div>
                          </td>
                        <?}?>
                        <?if ($SingleStatus == 'History' || $SingleStatus == 'Finish') {?>
                          <td><?=$pre_hits + $start_hits?></td>
                        <?}?>
                        <?if ($SingleStatus == 'Test') {?>
                          <td>
                            <p>展示：<?=$row['pre_date']?></p>
                            <p>開始：<?=$row['start_date']?></p>
                            <p>結束：<?=$row['end_date']?></p>
                          </td>
                        <?}?>
                        <?if ($SingleStatus == 'History') {?>
                          <td><?=$this->lang->line($row['status'])?></td>
                        <?}?>
                        <?if ($SingleStatus == 'History' || $SingleStatus == 'Finish') {?>
                          <td>
                            <span class="btn btn-danger btn-sm <?=($row['status'] == 'OutSale'? '' : 'hide')?>" onclick="calculationReport('<?=$row['id']?>')">結束並計算</span>
                            <span class="btn btn-success btn-sm <?=($row['status'] == 'Closure' || $SingleStatus == 'Finish'? '' : 'hide')?>" data-toggle="modal" data-target="#reportModal" onclick="viewCalculationReport('<?=$row['id']?>')">查看報表</span>
                            <span class="btn btn-warning btn-sm <?=($row['status'] == 'Closure'? '' : 'hide')?>" onclick="closedCase('<?=$row['id']?>','Finish')">結案</span>
                          </td>
                        <?}?>
                    </tr>
                    <?
                }
            } else { ?>
                <tr>
                    <td colspan="15">
                        <center>尚無資料！</center>
                    </td>
                </tr>
            <? } ?>
        </table>
    </div>
</div>
<script>
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>