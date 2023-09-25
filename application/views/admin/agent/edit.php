<style>
.modal-backdrop {
    z-index: -1;
}
.modal.in .modal-dialog {
    margin: 10% auto;
}
.pay_ok_color {
    background-color: #C4E1FF !important;
}
.order_cancel_color {
    background-color: #FFB5B5 !important;
}
.shipping_color {
    background-color: #DAB1D5 !important;
}
.complete_color {
    background-color: #CEFFCE !important;
}
.process_color {
    background-color: #FFFFCE !important;
}
.invalid_color {
    background-color: #B3D9D9 !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="content-box-large">
            <a href="/admin/agent" id="back-btn" class="btn btn-info hidden-print" style="margin-bottom: 15px;">返回上一頁</a>
            <div class="tabbable">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#basic_info" aria-controls="basic_info" role="tab" data-toggle="tab">基本資料</a>
                    </li>
                    <li role="presentation">
                        <a href="#single_sales_history" aria-controls="single_sales_history" role="tab" data-toggle="tab">參與銷售頁面</a>
                    </li>
                    <li role="presentation">
                        <a href="#sales_order_history" aria-controls="sales_order_history" role="tab" data-toggle="tab">銷售訂單紀錄</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="basic_info">
                        <?require 'basic_info.php';?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="single_sales_history">
                        <?require 'single_sales_history.php';?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="sales_order_history">
                        <?require 'sales_order_history.php';?>
                    </div>
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
<script>
$(document).ready(function() {
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
        }
        else {
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

    $('#sales_order_history_table').DataTable( {
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
              "sortAscending":  ": 升冪排列",
              "sortDescending": ": 降冪排列"
          }
        }
    });

    $('#single_sales_history_table').DataTable( {
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
              "sortAscending":  ": 升冪排列",
              "sortDescending": ": 降冪排列"
          }
        }
    });
});

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
</script>