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
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#history" aria-controls="history" role="tab" data-toggle="tab">銷售紀錄</a>
                    </li>
                    <li role="presentation">
                        <a href="#page" aria-controls="page" role="tab" data-toggle="tab">銷售頁面</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="history">
                        <? require 'history.php'; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="page">
                        <? require 'page.php'; ?>
                    </div>
                </div>
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
    });
</script>