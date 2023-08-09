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

    #agent_name.invalid {
        border: 2px solid #ff0000;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="tabbable">
                <span class="btn" data-toggle="modal" data-target="#createAgent" style="background-color: #2894FF;color: white;cursor: pointer;border-color:#2894FF;margin-bottom: 15px;">
                    建立代言人 <i class="fa-solid fa-user-plus"></i>
                </span>
                <input type="hidden" id="status" value="Enabled">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#Enabled" aria-controls="Enabled" role="tab" data-toggle="tab" onclick="searchTagStatus('Enabled')">啟用中</a>
                    </li>
                    <li role="presentation">
                        <a href="#Disabled" aria-controls="Disabled" role="tab" data-toggle="tab"  onclick="searchTagStatus('Disabled')">停用中</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Enabled">
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Disabled">
                    </div>
                    <?php require 'ajax-data.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Create Modal -->
<div class="modal" id="createAgent" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                    <h4>建立代言人</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group" style="padding-bottom: 15px;">
                            <span class="input-group-addon">代言人名稱</span>
                            <input type="text" class="form-control" id="agent_name" value="" required>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">會員連結資料  <i class="fa-solid fa-circle-question" data-html="true" data-toggle="tooltip" data-original-title="◎ 代言人如果是會員，可以選擇會員資料進行連動紀錄。<br>◎ 代言人如果沒有會員資料，則可以不用選擇！"></i></span>
                            <select id="users_id" class="form-control chosen">
                                <option value="" selected>選擇會員</option>
                                <? if (!empty($Users)) {
                                    foreach ($Users as $row) { ?>
                                        <option value="<?=$row['id'] ?>"><?=$row['full_name'] . ' - ' . $row['username'] ?></option>
                                        <?
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span type="button" class="btn btn-success" onclick="createAgent()">建立</span>
                <span type="button" class="btn btn-default" data-dismiss="modal" onclick="clearModelContent()">關閉</span>
            </div>
        </div>
    </div>
</div>
<!-- Create Modal -->
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
        console.log(status);
        searchTagStatus(status);
    });

    function searchTagStatus(status) {
        if (status == 'Disabled') {
            $('#status').val(status);
        }
        if (status == 'Enabled') {
            $('#status').val(status);
        }
        searchFilter();
    }

    function createAgent() {
        if ($('#agent_name').val() === '') {
            $('#agent_name').addClass('invalid');
            return;
        }
        $.ajax({
            type: "POST",
            url: '/admin/agent/createAgent',
            data: {
                name: $('#agent_name').val(),
                users_id: $('#users_id').val(),
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

    function clearModelContent() {
        $('#agent_name').removeClass('invalid');
        $('#agent_name').val('');
        $('#users_id').val('');
    }
</script>