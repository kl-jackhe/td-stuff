<style>
    .modal-backdrop {
        z-index: -1;
    }

    .modal.in .modal-dialog {
        margin: 10% auto;
    }

    .tabbable .nav-tabs > li.active > a, .tabbable .nav-tabs > li.active > a:hover, .tabbable .nav-tabs > li.active > a:focus {
        z-index: 0;
    }

    .tooltip-inner {
        text-align: left;
    }

    .table-curved tr:last-child td:first-child {
        border-radius: 0 0 0 6px;
    }

    .table-curved tr:last-child td:last-child {
        border-radius: 0 0 6px 0;
    }
    .wrapper {
  position: relative;
  width: 400px;
  height: 200px;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.signature-pad {
  position: absolute;
  left: 0;
  top: 0;
  width:400px;
  height:200px;
  background-color: white;
}
</style>
<!-- <div class="row">
    <div class="col-md-12">
        <canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
        <br>

        <button id="saveJPGButton">jpge</button>
        <button id="clear-signature">Clear</button>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="tabbable">
                <input type="hidden" id="status" value="Test">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#Test" aria-controls="Test" role="tab" data-toggle="tab" onclick="searchTagStatus('Test')">測試中</a>
                    </li>
                    <li role="presentation">
                        <a href="#ForSale" aria-controls="ForSale" role="tab" data-toggle="tab" onclick="searchTagStatus('ForSale')">展示中</a>
                    </li>
                    <li role="presentation">
                        <a href="#OnSale" aria-controls="OnSale" role="tab" data-toggle="tab" onclick="searchTagStatus('OnSale')">銷售中</a>
                    </li>
                    <li role="presentation">
                        <a href="#History" aria-controls="History" role="tab" data-toggle="tab" onclick="searchTagStatus('History')">歷史</a>
                    </li>
                    <li role="presentation">
                        <a href="#Finish" aria-controls="Finish" role="tab" data-toggle="tab" onclick="searchTagStatus('Finish')">結案</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="row" style="justify-content: right;display: flex;">
                        <div class="col-md-2 col-sm-12">
                            <select id="agent" class="form-control chosen_other" onchange="searchFilterSales()">
                                <option value="">代言人</option>
                                <?if (!empty($agent)) {
                                  foreach ($agent as $row) {?>
                                    <option value="<?=$row['id']?>" <?=(isset($_COOKIE['order_agent']) && $_COOKIE['order_agent'] == $row['id'] ? 'selected' : '' )?>><?=$row['name']?></option>
                                  <?}
                                }?>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <select id="product" class="form-control chosen_other" onchange="searchFilterSales()">
                                <option value="">商品</option>
                                <?if (!empty($product)) {
                                    foreach ($product as $row) {?>
                                        <option value="<?=$row['product_id']?>" <?=(isset($_COOKIE['order_product']) && $_COOKIE['order_product'] == $row['product_id'] ? 'selected' : '' )?>><?=$row['product_name']?></option>
                                    <?}
                                }?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- <div role="tabpanel" class="tab-pane active" id="Test"></div>
                    <div role="tabpanel" class="tab-pane" id="ForSale"></div>
                    <div role="tabpanel" class="tab-pane" id="OnSale"></div>
                    <div role="tabpanel" class="tab-pane" id="History"></div>
                    <div role="tabpanel" class="tab-pane" id="Finish"></div> -->
                    <?php require 'ajax-data.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="report">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="undoneOrderListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="undoneOrderList">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".chosen_other").chosen({
          no_results_text: "沒有找到。",
          search_contains: true,
          width: "100%",
        });

        if (location.hash) {
            $('a[href=\'' + location.hash + '\']').tab('show');
        }
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[href="' + activeTab + '"]').tab('show');
        }
        $('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
            e.preventDefault()
            var tab_name = this.getAttribute('href')
            if (history.pushState) {
                history.pushState(null, null, tab_name)
            } else {
                location.hash = tab_name
            }
            localStorage.setItem('activeTab', tab_name)
            $(this).tab('show');
            return false;
        });
        $(window).on('popstate', function () {
            var anchor = location.hash ||
                $('a[data-toggle=\'tab\']').first().attr('href');
            $('a[href=\'' + anchor + '\']').tab('show');
        });
        status = activeTab.replace('#', '');

        searchTagStatus(status);
    });

    function searchTagStatus(status) {
        if (status == 'Test') {
            $('#status').val(status);
        }
        if (status == 'ForSale') {
            $('#status').val(status);
        }
        if (status == 'OnSale') {
            $('#status').val(status);
        }
        if (status == 'History') {
            $('#status').val(status);
        }
        if (status == 'Finish') {
            $('#status').val(status);
        }
        searchFilterSales();
    }

    function calculationReport(id) {
        if (confirm('確定要結束此次銷售並且計算所有費用嗎？')) {
            $('#loading').show();
            $.ajax({
                type: "POST",
                url: '/admin/sales/calculationReport',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function(data) {
                    console.log(data);
                    if (data['ExecutionResults'] == 'no') {
                        if (!$.isEmptyObject(data['UndoneOrderList'])) {
                            viewUndoneOrderList(data['UndoneOrderList'],data['OrderQty']);
                        } else {
                            alert('執行失敗！');
                        }
                    }
                    if (data['ExecutionResults'] == 'yes') {
                        if (confirm('執行成功！')) {
                            viewCalculationReport(id);
                            searchFilterSales();
                        }
                    }
                    if (data['ExecutionResults'] == 'no_default_profit_percentage') {
                        alert('預設利潤％數沒設定！');
                    }
                },
                error: function(data) {
                    console.log(data);
                    alert('異常錯誤！');
                }
            });
            $('#loading').hide();
        }
    }

    function viewCalculationReport(id) {
        $('#report').html('');
        $.ajax({
            type: "POST",
            url: '/admin/sales/viewCalculationReport',
            data: {
                id: id,
            },
            success: function(data) {
                $('#report').html(data);
                $('#reportModal').modal('show');
            },
            error: function(data) {
                console.log('Error');
            }
        });
    }

    function viewUndoneOrderList(data,orderQty) {
        var undoneOrderListStr = '';
        undoneOrderListStr += '<h3 class="text-center">訂單筆數：' + orderQty + '</h3>';
        undoneOrderListStr += '<h3 class="text-center">未完成訂單比數：' + data.length + '</h3>';
        undoneOrderListStr += '<table class="table table-bordered table-striped"><tbody>';
        undoneOrderListStr += '<tr style="font-size:18px;"><th>訂單編號</th><th>訂單狀態</th></tr>';
        for (var i=0;i<data.length;i++) {
            undoneOrderListStr += '<tr style="font-size:16px;">'
            undoneOrderListStr += '<td><a href="/admin/order/view/' + data[i]['order_id'] + '" target="_blank">' + data[i]['order_number'] + '</a></td>';
            if (data[i]['order_step'] == 'confirm') {
                undoneOrderListStr += '<td>訂單確認</td>';
            }
            if (data[i]['order_step'] == 'pay_ok') {
                undoneOrderListStr += '<td style="background-color: #C4E1FF">已收款</td>';
            }
            if (data[i]['order_step'] == 'process') {
                undoneOrderListStr += '<td style="background-color: #FFFFCE">待出貨</td>';
            }
            if (data[i]['order_step'] == 'shipping') {
                undoneOrderListStr += '<td style="background-color: #DAB1D5">已出貨</td>';
            }
            if (data[i]['order_step'] == 'invalid') {
                undoneOrderListStr += '<td style="background-color: #B3D9D9">訂單不成立</td>';
            }
            undoneOrderListStr += '</tr>'
        }
        undoneOrderListStr += '</tbody></table>';
        $('#undoneOrderList').html('');
        $('#undoneOrderList').html(undoneOrderListStr);
        $('#undoneOrderListModal').modal('show');
    }

    function closedCase(id,status) {
        if (confirm('確定要結案？')) {
            $.ajax({
                type: "POST",
                url: '/admin/sales/updateSingleSalesStatus',
                data: {
                    id: id,
                    status: status,
                },
                success: function(data) {
                    alert('結案成功！');
                    searchFilterSales();
                },
                error: function(data) {
                    alert('異常錯誤！');
                }
            });
        }
    }
</script>
<!-- 簽名JS -->
<script src="/assets/admin/js/signature/signature_pad.js"></script>
<!-- 簽名JS -->

<!-- <script>
jQuery(document).ready(function($){
    const canvas = document.getElementById("signature");
    const signaturePad = new SignaturePad(canvas);
    $('#clear-signature').on('click', function(){
        signaturePad.clear();
    });
    saveJPGButton.addEventListener("click", function (event) {
      if (signaturePad.isEmpty()) {
        alert("Please provide a signature first.");
      } else {
        var dataURL = signaturePad.toDataURL("image/jpeg");
        var imgName = <?=$product_image = 'p_img_' . $id . '_' . date('YmdHis') . '.' . $ext;?>
        // download(dataURL, imgName+".jpg");
        //alert(dataURL);
        $.ajax({
          type: 'POST',
          url: "/admin/sales/uploadSignature",
          data: {
            data:dataURL,
          },
          success: function(data, textStatus, jqXHR){
            if(data!='0')
            {
                alert("上傳成功！");
            }
            else
                alert('錯誤！這個檔案不是圖片。');
          }
        });
      }
    });
});
</script> -->