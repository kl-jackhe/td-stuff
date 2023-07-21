<div class="row">
    <div class="col-md-12">
        <span class="btn" data-toggle="modal" data-target="#createAgent" style="background-color: #2894FF;color: white;cursor: pointer;border-color:#2894FF;">
            建立代言人 <i class="fa-solid fa-user-plus"></i>
        </span>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-hover" style="border-radius: 10px;margin-top: 20px;">
            <tr class="info">
                <th>ID</th>
                <th>名稱</th>
                <th>是否會員</th>
                <th>狀態</th>
                <th>操作</th>
            </tr>
            <? if (!empty($Agent)) {
                foreach ($Agent as $row) { ?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=$row['name']?></td>
                        <td><i class="fa-solid fa-circle-<?=($row['users_id'] != 0 ? 'check' : 'xmark')?>"></i></td>
                        <td>
                            <p><?=($row['status'] == true ? '啟用中' : '停用中')?></p>
                            <p>建立時間：<?=$row['created_at']?></p>
                            <p>更新時間：<?=$row['updated_at']?></p>
                        </td>
                        <td>
                            <span class="btn" data-toggle="modal" data-target="#<?php echo $row['id'] ?>" style="background-color: #2894FF;color: white;cursor: pointer;border-color:#2894FF;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </span>
                            <!-- Edit Modal -->
                            <div class="modal" id="<?php echo $row['id'] ?>" tabindex="-1" role="dialog"
                                 data-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4><?php echo $row['id'] ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <span type="button" class="btn btn-success">修改</span>
                                            <span type="button" class="btn btn-default" data-dismiss="modal">關閉</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Modal -->
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
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

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