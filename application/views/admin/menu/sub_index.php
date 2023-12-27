<button type="button" onclick="returnMainMenu()" class="btn btn-primary" style="margin-bottom: 20px;">
    <i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回
</button>
<div class="row">
    <div class="col-md-3">
        <div class="content-box-large">
            <?php $attributes = array('class' => 'sub-menu', 'id' => 'sub-menu'); ?>
            <?php echo form_open('admin/menu/sub_insert', $attributes); ?>
            <div class="form-group">
                <label for="menu_name">選單名稱</label>
                <input type="text" class="form-control" name="menu_name" required>
            </div>
            <div class="form-group">
                <label for="menu_type">類型</label>
                <select class="form-control" name="menu_type">
                    <option value="Sub">次要選單</option>
                </select>
            </div>
            <div class="form-group">
                <label for="menu_sort">排序</label>
                <input type="number" class="form-control" name="menu_sort" min="1" value="1">
            </div>
            <div hidden class="form-group">
                <input class="form-control" name="parent_id" value="<?= $parent_id; ?>">
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
                <? if (!empty($menu)) {
                    foreach ($menu as $data) { ?>
                        <tr>
                            <td class="text-center"><?= $data['name'] ?></td>
                            <td class="text-center"><?= $data['type'] ?></td>
                            <td class="text-center"><?= $data['sort'] ?></td>
                            <td class="text-center"><?= $data['status'] == 1 ? '開啟中' : '關閉中'; ?></td>
                            <td class="text-center">
                                <a href="/admin/menu/edit/<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="/admin/menu/sub_delete/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <? }
                } else { ?>
                    <tr>
                        <td colspan="4">
                            <center>對不起, 沒有資料 !</center>
                        </td>
                    </tr>
                <? } ?>
            </table>
        </div>
    </div>
</div>

<script>
    function returnMainMenu() {
        window.location.href = <?= json_encode(base_url()) ?> + 'admin/menu';
    }

    function form_check() {
        var menu_name = $('#menu_name').val();
        var menu_sort = $('#menu_sort').val();
        <?php if (isset($menu)) : ?>
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

        document.getElementById("sub-menu").submit();
    }
</script>