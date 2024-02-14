<button type="button" onclick="returnSubMenu()" class="btn btn-primary" style="margin: 15px 0 20px 0;">
    <i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回
</button>
<div class="row" style="margin-bottom: 70px;">
    <div class="col-md-3">
        <div class="content-box-large">
            <?php $attributes = array('class' => 'sub-son-menu', 'id' => 'sub-son-menu'); ?>
            <?php echo form_open('admin/menu/sub_son_insert', $attributes); ?>
            <div class="form-group">
                <label for="menu_name">選單名稱</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" required>
            </div>
            <div class="form-group">
                <label for="menu_type">類型</label>
                <select class="form-control" name="menu_type">
                    <option value="Sub-son">次要子選單</option>
                </select>
            </div>
            <div class="form-group">
                <label for="menu_sort">序列編號</label>
                <input type="number" class="form-control" id="menu_sort" name="menu_sort" min="1" value="1">
            </div>
            <div class="form-group">
                <label for="menu_position_sort">排序</label>
                <input type="number" class="form-control" id="menu_position_sort" name="menu_position_sort" min="1" value="1">
            </div>
            <div hidden class="form-group">
                <input class="form-control" name="parent_id" value="<?= $parent_id; ?>">
            </div>
            <div hidden class="form-group">
                <input class="form-control" name="grandparent_id" value="<?= $grandparent_id; ?>">
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
                        <th class="text-center">序列編號</th>
                        <th class="text-center">排序</th>
                        <th class="text-center">狀態</th>
                        <th class="text-center">次次子項目操作</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <?php if (!empty($menu)) : ?>
                    <?php foreach ($menu as $data) : ?>
                        <tr>
                            <td class="text-center" id="name"><?= $data['name'] ?></td>
                            <td class="text-center"><?= $data['type'] ?></td>
                            <td class="text-center" id="sort"><?= $data['sort'] ?></td>
                            <td class="text-center" id="sort"><?= $data['position_sort'] ?></td>
                            <td class="text-center" id="status"><?= $data['status'] == 1 ? '✔️開啟' : '❌關閉'; ?></td>
                            <td class="text-center">
                                <a href="/admin/menu/sub_sub_son_index/<?= $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-list" aria-hidden="true"></i></a>
                            </td>
                            <td hidden><input type="hidden" id="menuId" value="<?= $data['id'] ?>"></td>
                            <td class="text-center">
                                <a href="/admin/menu/edit/sub_son_menu/<?= $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <!-- <a class="btn btn-info btn-sm" onclick="editRow(this)"><i class="fa fa-edit"></i></a> -->
                                <a href="/admin/menu/delete/sub_son_menu/<?= $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">
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
        window.location.href = <?= json_encode(base_url() . 'admin/menu/sub_index/' . $grandparent_id); ?>;
    }

    function form_check() {
        var menu_name = $('#menu_name').val();
        var menu_sort = $('#menu_sort').val();
        <?php if (!empty($menu)) : ?>
            <?php foreach ($menu as $self) : ?>
                var name = <?= json_encode($self['name']) ?>;
                var sort = <?= json_encode($self['sort']) ?>;
                var position_sort = <?= json_encode($self['position_sort']) ?>;
                if (menu_name == name) {
                    alert('該項目已存在');
                    return;
                }
                if (menu_sort == sort) {
                    alert('該序列編號已存在');
                    return;
                }
                if (menu_position_sort == position_sort) {
                    alert('該排序已存在');
                    return;
                }
            <?php endforeach; ?>
        <?php endif; ?>

        document.getElementById("sub-son-menu").submit();
    }
</script>