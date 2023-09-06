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
</style>
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
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Test"></div>
                    <div role="tabpanel" class="tab-pane" id="ForSale"></div>
                    <div role="tabpanel" class="tab-pane" id="OnSale"></div>
                    <div role="tabpanel" class="tab-pane" id="History"></div>
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
<script>
    $(document).ready(function () {
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
        searchFilterSales();
    }

    function calculationReport(id) {
        if (confirm('確定要結束此次銷售並且計算所有費用嗎？')) {
            $('#loading').show();
            $.ajax({
                type: "POST",
                url: '/admin/sales/calculationReport',
                data: {
                    id: id,
                },
                success: function(data) {
                    if (data == 'yes') {
                        if (confirm('執行成功！')) {
                            viewCalculationReport(id);
                            searchFilterSales();
                        }
                    } else if (data == 'no_default_profit_percentage') {
                        alert('預設利潤％數沒設定！');
                    } else {
                        alert('執行失敗！');
                    }
                },
                error: function(data) {
                    alert('執行失敗！');
                    console.log('Error');
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
</script>