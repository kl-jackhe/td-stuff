<button type="button" onclick="returnSubMenu()" class="btn btn-primary" style="margin: 15px 0 20px 0;">
    <i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回
</button>
<div class="row" style="margin-bottom: 70px;">
    <div class="col-md-3">
        <div class="content-box-large">
            <?php $attributes = array('class' => 'sub-son-menu', 'id' => 'sub-son-menu'); ?>
            <?php echo form_open('admin/menu/sub_sub_son_insert', $attributes); ?>
            <div class="form-group">
                <label for="menu_name">選單名稱</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" required>
            </div>
            <div class="form-group">
                <label for="menu_type">類型</label>
                <select class="form-control" name="menu_type">
                    <option value="Sub-sub-son">次次要子選單</option>
                </select>
            </div>
            <div class="form-group">
                <label for="menu_sort">排序</label>
                <input type="number" class="form-control" id="menu_sort" name="menu_sort" min="1" value="1">
            </div>
            <div hidden class="form-group">
                <input class="form-control" name="parent_id" value="<?= $parent_id; ?>">
            </div>
            <div hidden class="form-group">
                <input class="form-control" name="grandparent_id" value="<?= $grandparent_id; ?>">
            </div>
            <div hidden class="form-group">
                <input class="form-control" name="grandparent_parent_id" value="<?= $grandparent_parent_id; ?>">
            </div>
            <div class="form-group">
                <button type="button" onclick="form_check()" class="btn btn-primary">新增</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="col-md-9">
        <div class="content-box-large">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">選單名稱</th>
                        <th class="text-center">類型</th>
                        <th class="text-center">排序</th>
                        <th class="text-center">狀態</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <?php if (!empty($menu)) : ?>
                    <?php foreach ($menu as $data) : ?>
                        <tr>
                            <td class="text-center" id="name"><?= $data['name'] ?></td>
                            <td class="text-center"><?= $data['type'] ?></td>
                            <td class="text-center" id="sort"><?= $data['sort'] ?></td>
                            <td class="text-center" id="status"><?= $data['status'] == 1 ? '✔️開啟' : '❌關閉'; ?></td>
                            <td hidden><input type="hidden" id="menuId" value="<?= $data['id'] ?>"></td>
                            <td class="text-center">
                                <a href="/admin/menu/edit/sub_sub_son_menu/<?= $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <!-- <a class="btn btn-info btn-sm" onclick="editRow(this)"><i class="fa fa-edit"></i></a> -->
                                <a href="/admin/menu/delete/sub_sub_son_menu/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">
                            <br>
                            <br>
                            <br>
                            <p class="text-center">對不起, 沒有資料 !</p>
                            <br>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<script>
    function returnSubMenu() {
        window.history.back();
    }

    function form_check() {
        var menu_name = $('#menu_name').val();
        var menu_sort = $('#menu_sort').val();
        <?php if (!empty($menu)) : ?>
            <?php foreach ($menu as $self) : ?>
                var name = <?= json_encode($self['name']) ?>;
                var sort = <?= json_encode($self['sort']) ?>;
                if (menu_name == name) {
                    alert('該項目已存在');
                    return;
                }
                if (menu_sort == sort) {
                    alert('該排序已存在');
                    return;
                }
            <?php endforeach; ?>
        <?php endif; ?>

        document.getElementById("sub-son-menu").submit();
    }

    function editRow(link) {
        var row = $(link).closest('tr');

        // 获取每个单元格的内容
        var name = row.find('#name').text();
        var sort = row.find('#sort').text();
        var status = row.find('#status').text();
        var id = row.find('#menuId').val();

        // 将内容替换为输入字段
        row.find('#name').html('<input type="text" class="form-control" id="editName" value="' + name + '">');
        row.find('#sort').html('<input type="number" class="form-control" id="editSort" value="' + sort + '">');
        row.find('#status').html('<select class="form-control" id="editStatus"><option value="1" ' + (status == '✔️開啟' ? 'selected' : '') + '>✔️開啟</option><option value="0" ' + (status == '❌關閉' ? 'selected' : '') + '>❌關閉</option></select>');
        row.find('#menuId').html('<input type="hidden" class="form-control" id="editMenuId" value="' + id + '">');

        // 添加“完成”按钮
        row.find('td:last').html('<button class="btn btn-success btn-sm" onclick="saveRow(this)">完成</button>');
    }

    function saveRow(link) {
        var row = $(link).closest('tr');

        // 获取每个输入字段的值
        var editName = row.find('#editName').val();
        var editSort = row.find('#editSort').val();
        var editStatus = row.find('#editStatus').val();
        var editMenuId = row.find('#editMenuId').val();

        if (editSort == 0) {
            alert('更新失敗排序不可為NULL');
            return;
        }
        <?php if (!empty($menu)) : ?>
            <?php foreach ($menu as $self) : ?>
                if (editSort == <?= json_encode($self['sort']) ?>) {
                    if (editMenuId != <?= json_encode($self['id']) ?>) {
                        alert('更新失敗排序不可重複');
                        return;
                    }
                }
                if (editName == <?= json_encode($self['name']) ?>) {
                    if (editMenuId != <?= json_encode($self['id']) ?>) {
                        alert('更新失敗名稱不可重複');
                        return;
                    }
                }
            <?php endforeach; ?>
        <?php endif; ?>


        // 将输入字段的值更新到数据库（这里需要使用 Ajax 请求）
        $.ajax({
            url: '/admin/menu/update/sub_sub_son_menu', // 替换成你的更新数据的后端接口
            type: 'POST',
            data: {
                id: editMenuId,
                name: editName,
                sort: editSort,
                status: editStatus
            },
            success: function(response) {
                // 处理成功的回调，可以根据需要进行其他操作
                if (response == '更新成功') {
                    location.reload();
                }
            },
        });
    }
</script>