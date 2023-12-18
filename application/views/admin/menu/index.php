<div class="row">
    <div class="col-md-3">
        <div class="content-box-large">
            <?php $attributes = array('class' => 'menu', 'id' => 'menu');?>
            <?php echo form_open('admin/menu/insert', $attributes); ?>
            <div class="form-group">
                <label for="menu_name">選單名稱</label>
                <input type="text" class="form-control" name="menu_name" required>
            </div>
            <div class="form-group">
                <label for="menu_type">類型</label>
                <select class="form-control" name="menu_type">
                    <option value="Sub" selected>次要選單</option>
                    <option value="Main">主要選單</option>
                </select>
            </div>
            <div class="form-group">
                <label for="menu_sort">排序</label>
                <input type="number" class="form-control" name="menu_sort" min="0" value="50">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">新增</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="col-md-9">
        <div class="content-box-large">
            <table class="table">
                <thead>
                    <tr>
                        <th>選單名稱</th>
                        <th>類型</th>
                        <th>層級</th>
                        <th>內文</th>
                        <th>排序</th>
                        <th>狀態</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <?if (!empty($menu)) {
                    foreach ($menu as $data){?>
                        <tr>
                            <td><?=$data['name']?></td>
                            <td><?=$data['type']?></td>
                            <td></td>
                            <td></td>
                            <td><?=$data['sort']?></td>
                            <td><?=$data['status']?></td>
                            <td>
                                <a href="/admin/menu/edit/<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="/admin/menu/delete/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?}
                } else {?>
                    <tr>
                        <td colspan="4">
                            <center>對不起, 沒有資料 !</center>
                        </td>
                    </tr>
                <?}?>
            </table>
        </div>
    </div>
</div>