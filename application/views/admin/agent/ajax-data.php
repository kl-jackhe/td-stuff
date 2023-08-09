<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover" id="datatable" style="border-top-width: 0px;border-left-width: 0px;border-right-width: 0px;border-bottom-width: 0px;">
            <thead class="pc_control">
                <tr class="info">
                    <th>ID</th>
                    <th>名稱</th>
                    <th>會員連動</th>
                    <th>狀態</th>
                </tr>
            </thead>
            <? if (!empty($Agent)) {
                foreach ($Agent as $row) { ?>
                    <tr>
                        <td>
                            <a href="agent/editAgent/<?=$row['id']?>" target="_blank">
                                <?=$row['id']?>&emsp;<i class="fa-solid fa-up-right-from-square"></i>
                            </a>
                        </td>
                        <td><?=$row['name']?></td>
                        <td>
                            <i class="fa-solid fa-circle-<?=($row['users_id'] != 0 ? 'check' : 'xmark')?>" style="font-size: 24px;color: <?=($row['users_id'] != 0 ? 'green' : 'red')?>;"></i>
                        </td>
                        <td>
                            <div class="input-group" style="width: 30%;">
                                <!-- <span class="input-group-addon"><?=($row['status'] == true ? '啟用中' : '停用中')?></span>
                                <span class="input-group-addon" style="font-size: 18px;cursor: pointer;" onclick="updateAgentStatus('<?=$row['id']?>','<?=$row['status']?>')"><i style="margin-top: 0;<?=($row['status'] == true ? 'color:green;' : 'color:red;')?>" class="fa-solid fa-toggle-<?=($row['status'] == true ? 'on' : 'off')?> agent_status_id_<?=$row['id']?>"></i></span> -->
                                <span  style="font-size: 24px;cursor: pointer;" onclick="updateAgentStatus('<?=$row['id']?>','<?=$row['status']?>')"><i style="margin-top: 0;<?=($row['status'] == true ? 'color:green;' : 'color:red;')?>" class="fa-solid fa-toggle-<?=($row['status'] == true ? 'on' : 'off')?> agent_status_id_<?=$row['id']?>"></i></span>
                            </div>
                        </td>
                    </tr>
                <?}
            } else {?>
            <tr>
                <td colspan="15">
                    <center>對不起, 沒有資料 !</center>
                </td>
            </tr>
            <?}?>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    function updateAgentStatus(agent_id,status) {
        console.log(agent_id);
        console.log(status);
        $.ajax({
            type: "POST",
            url: '/admin/agent/updateAgentStatus',
            data: {
                id: agent_id,
                status: status,
            },
            success: function(data) {
                alert('修改成功');
                location.reload();
            },
            error: function(data) {
                console.log('Create Error');
            }
        });
    }
</script>