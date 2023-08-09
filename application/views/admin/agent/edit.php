<style>
.modal-backdrop {
    z-index: -1;
}
.modal.in .modal-dialog {
    margin: 10% auto;
}
.tabbable .nav-tabs>li.active>a, .tabbable .nav-tabs>li.active>a:hover, .tabbable .nav-tabs>li.active>a:focus {
    z-index: 0;
}
.fa-toggle-on {
  color: green;
}
.fa-toggle-off {
  color: gray;
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
            <a href="#history_order" aria-controls="history_order" role="tab" data-toggle="tab">歷史訂單</a>
          </li>
        </ul>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="basic_info">
            <?require 'basic_info.php';?>
          </div>
          <div role="tabpanel" class="tab-pane" id="history_order">
            <?require 'history_order.php';?>
          </div>
        </div>
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
});
</script>