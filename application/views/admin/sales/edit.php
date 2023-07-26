<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <span class="btn btn-success" style="margin-bottom: 10px;" onclick="updateEditAllData()">一鍵更新 <i class="fa-solid fa-upload"></i></span>
    </div>
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="tabbable">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#general" aria-controls="general" role="tab" data-toggle="tab">基本資料</a>
                    </li>
                    <!-- <li role="presentation">
                        <a href="#product" aria-controls="product" role="tab" data-toggle="tab">商品資訊</a>
                    </li> -->
                    <?if (!empty($SingleSalesDetail)) {
                        $status = array('Closure','OutSale','ForSale','OnSale');
                        $btn_class = array('btn-danger','btn-warning','btn-info','btn-success');
                        for ($i=0;$i<count($status);$i++) {
                            if ($status[$i] != $SingleSalesDetail['status']) {?>
                                <li style="float: right;margin-left: 10px;font-weight: bold;" 
                                class="btn <?=$btn_class[$i]?>" 
                                onclick="updateSingleSalesStatus('<?=$SingleSalesDetail['id']?>','<?=$status[$i]?>')">
                                    <?=$this->lang->line($status[$i])?>
                                </li>
                            <?}
                        }
                    }?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                        <div class="row">
                            <?if (!empty($SingleSalesDetail)) {?>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">ID</span>
                                    <input type="text" class="form-control" id="sales_id" value="<?=$SingleSalesDetail['id']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">商品名稱</span>
                                    <input type="text" class="form-control" id="product_id" value="<?=get_product_name($SingleSalesDetail['product_id'])?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">狀態</span>
                                    <input type="text" class="form-control" id="status" value="<?=$this->lang->line($SingleSalesDetail['status'])?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">展示日期</span>
                                    <input type="text" class="form-control datepicker" id="pre_date" value="<?=($SingleSalesDetail['pre_date'] != '0000-00-00 00:00:00' ? substr($SingleSalesDetail['pre_date'], 0, 10) : '')?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">開始日期</span>
                                    <input type="text" class="form-control datepicker" id="start_date" value="<?=($SingleSalesDetail['start_date'] != '0000-00-00 00:00:00' ? substr($SingleSalesDetail['start_date'], 0, 10) : '')?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">結束日期</span>
                                    <input type="text" class="form-control datepicker" id="end_date" value="<?=($SingleSalesDetail['end_date'] != '0000-00-00 00:00:00' ? substr($SingleSalesDetail['end_date'], 0, 10) : '')?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <?}?>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom: 10px;">
                                <span class="btn btn-primary" data-toggle="modal" data-target="#createAgent">
                                    建立代言人數量 <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn btn-info" data-toggle="modal" data-target="#selectAgentImport" style="margin-left: 10px;">
                                    匯入現有代言人 <i class="fa-solid fa-file-import"></i>
                                </span>
                            </div>
                            <div class="col-md-12" style="overflow-x: auto;">
                                <table class="table table-bordered table-striped table-hover" style="border-radius: 10px;margin-top: 20px;" id="data-table">
                                    <thead>
                                        <tr class="info">
                                            <th>排序</th>
                                            <th>網站名稱</th>
                                            <th>銷售網址</th>
                                            <th>用戶ID</th>
                                            <th>用戶名稱</th>
                                            <th>狀態</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <? if (!empty($SingleSalesAgentDetail)) {
                                        $count = 0;
                                        foreach ($SingleSalesAgentDetail as $row) {
                                            $count++;?>
                                            <input type="hidden" name="single_sales_agent_id[]" value="<?=$row['single_sales_agent_id']?>">
                                            <input type="hidden" id="agent_id_<?=$row['single_sales_agent_id']?>" value="<?=$row['agent_id']?>">
                                            <tr>
                                                <td><?=$count?></td>
                                                <td>
                                                    <input type="text" id="single_sales_agent_name_<?=$row['single_sales_agent_id']?>" value="<?=$row['single_sales_agent_name']?>" class="form-control">
                                                </td>
                                                <td>
                                                    <?if (!empty($SingleSalesDetail)) {?>
                                                        <p><?=$SingleSalesDetail['url'] . '?aid=' . $row['agent_id']?></p>
                                                        <a href="<?=$SingleSalesDetail['url'] . '?aid=' . $row['agent_id']?>" class="copy-link" onclick="copyLink(event)">點擊這裡複製連結 <i class="fa-regular fa-copy"></i></a>
                                                    <?}?>
                                                </td>
                                                <td><?=$row['agent_id']?></td>
                                                <td>
                                                    <input type="text" id="agent_name_<?=$row['single_sales_agent_id']?>" value="<?=$row['agent_name']?>" class="form-control">
                                                </td>
                                                <td>
                                                    <p>狀態：<?=($row['status'] == true ? '啟用中' : '停用中')?></p>
                                                    <p>建立時間：<?=$row['created_at']?></p>
                                                    <p>更新時間：<?=$row['updated_at']?></p>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="product">
                        <? require 'product/product_edit.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Create Modal -->
<div class="modal" id="createAgent" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4>建立代言人數量</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" class="form-control" id="agent_quantity" value="1" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span type="button" class="btn btn-success" onclick="createAgentQuantity()">建立</span>
                <span type="button" class="btn btn-default" data-dismiss="modal">關閉</span>
            </div>
        </div>
    </div>
</div>
<!-- Create Modal -->
<!-- Select Agent Import Modal -->
<div class="modal" id="selectAgentImport" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4>選擇代言人匯入</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">匯入代言人</span>
                            <select id="agent_id_list" multiple class="form-control chosen">
                                <?if (!empty($AgentList)) {
                                    foreach ($AgentList as $row) { ?>
                                        <option value="<?=$row['id'] ?>"><?=$row['name'] . ' - ' . $row['id'] ?></option>
                                    <?}
                                }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span type="button" class="btn btn-success" onclick="selectAgentImport()">匯入</span>
                <span type="button" class="btn btn-default" data-dismiss="modal">關閉</span>
            </div>
        </div>
    </div>
</div>
<!-- Select Agent Import Modal -->
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('#data-table').DataTable({
            searching: false,
            paging: false,
            info: false,
            "dom": '<"top"iflp<"clear">>',
            "language": {
              "processing":   "處理中...",
              "loadingRecords": "載入中...",
              "lengthMenu":   "顯示 _MENU_ 項結果",
              "zeroRecords":  "沒有符合的結果",
              "emptyTable":   "沒有資料",
              "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
              "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
              "infoFiltered": "(從 _MAX_ 項結果中過濾)",
              "infoPostFix":  "",
              "search":       "搜尋:",
              "paginate": {
                  "first":    "第一頁",
                  "previous": "上一頁",
                  "next":     "下一頁",
                  "last":     "最後一頁"
              },
              "aria": {
                  "sortAscending":  ": <?php echo $this->lang->line('sort_asc'); ?>",
                  "sortDescending": ": <?php echo $this->lang->line('sort_desc'); ?>"
              }
            }
        });
    });

    function createAgentQuantity() {
        $.ajax({
            type: "POST",
            url: '/admin/agent/createAgentQuantity',
            data: {
                agent_qty: $('#agent_quantity').val(),
                sales_id: $('#sales_id').val(),
            },
            success: function(data) {
                alert('建立成功！');
                location.reload();
            },
            error: function(data) {
                console.log('Create Error');
            }
        });
    }

    function selectAgentImport() {
        $.ajax({
            type: "POST",
            url: '/admin/agent/selectAgentImport',
            data: {
                agent_id_list: $('#agent_id_list').val(),
                sales_id: $('#sales_id').val(),
            },
            success: function(data) {
                alert('匯入成功！');
                location.reload();
            },
            error: function(data) {
                console.log('Create Error');
            }
        });
    }

    function updateEditAllData() {
        var single_sales_agent_id = $('input[name="single_sales_agent_id[]"]');
        var single_sales_agent_list = [];
        for (i=0;i< single_sales_agent_id.length;i++) {
            // console.log($('#single_sales_agent_name_' + single_sales_agent_id[i].value).val());
            // console.log($('#agent_id_' + single_sales_agent_id[i].value).val());
            // console.log($('#agent_name_' + single_sales_agent_id[i].value).val());
            single_sales_agent_list[i] = {
                single_sales_agent_id:single_sales_agent_id[i].value,
                single_sales_agent_name:$('#single_sales_agent_name_' + single_sales_agent_id[i].value).val(),
                agent_id:$('#agent_id_' + single_sales_agent_id[i].value).val(),
                agent_name:$('#agent_name_' + single_sales_agent_id[i].value).val()
            };
        }
        // console.log(single_sales_agent_list);
        // console.log($('#sales_id').val());
        // console.log($('#pre_date').val());
        // console.log($('#start_date').val());
        // console.log($('#end_date').val());
        if ($('#start_date').val() != '' && $('#end_date').val() != '') {
            if ($('#start_date').val() > $('#end_date').val()) {
               alert('開始日期大於結束日期！請修改正確日期。');
               return;
            }
        }
        $.ajax({
            type: "POST",
            url: '/admin/sales/updateEditAllData',
            data: {
                single_sales_agent_list: single_sales_agent_list,
                sales_id: $('#sales_id').val(),
                pre_date: $('#pre_date').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val()
            },
            success: function(data) {
                alert('更新成功！');
                location.reload();
            },
            error: function(data) {
                console.log('Create Error');
            }
        });
    }

    function copyLink(event) {
      // 防止點擊 <a> 連結後導致瀏覽器跳轉
      event.preventDefault();

      // 獲取點擊的 <a> 標籤的 href 屬性值
      var hrefToCopy = event.target.href;

      // 使用 Clipboard API 複製內容
      navigator.clipboard.writeText(hrefToCopy)
        .then(function() {
          // 成功複製後可以加上提示或其他操作
          alert("已成功複製連結: " + hrefToCopy);
        })
        .catch(function(error) {
          // 複製失敗時處理錯誤
          console.error("複製連結失敗: ", error);
        });
    }

    function updateSingleSalesStatus(id,status) {
        if (confirm('確定要變更狀態嗎？')) {
            $.ajax({
                type: "POST",
                url: '/admin/sales/updateSingleSalesStatus',
                data: {
                    id: id,
                    status: status,
                },
                success: function(data) {
                    alert('更新成功！');
                    location.reload();
                },
                error: function(data) {
                    console.log('Create Error');
                }
            });
        }
    }
</script>