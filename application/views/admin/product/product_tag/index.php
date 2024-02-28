<div class="row">
    <div class="col-md-4">
        <div class="content-box-large">
            <?php $attributes = array('class' => 'product_tag', 'id' => 'product_tag'); ?>
            <?php echo form_open('admin/product/insert_tag', $attributes); ?>
            <div class="form-group">
                <label for="product_tag_name">標籤名稱</label>
                <input type="text" class="form-control" id="product_tag_name" name="product_tag_name">
            </div>
            <div class="form-group">
                <label for="product_tag_sort">標籤排序</label>
                <input type="number" class="form-control" id="product_tag_sort" name="product_tag_sort" value="1">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="form_check()">新增標籤</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr class="info">
                        <th class="text-center">標籤名稱</th>
                        <th class="text-center">排序</th>
                        <th class="text-center">狀態</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($product_tag)) : ?>
                        <?php foreach ($product_tag as $self) : ?>
                            <tr>
                                <td class="text-center"><?= $self['name'] ?></td>
                                <td class="text-center"><?= (int)$self['sort'] ?></td>
                                <td class="text-center"><?= ($self['status'] == 1) ? "✔️啟用中" : "❌關閉中" ?></td>
                                <td class="text-center">
                                    <a href="/admin/product/edit_tag/<?= $self['id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <?php if ($self['code'] == '') : ?>
                                        <a href="/admin/product/delete_tag/<?= $self['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function form_check() {
        var product_tag_name = $('#product_tag_name').val();
        var product_tag_sort = $('#product_tag_sort').val();
        <?php if (!empty($product_tag)) : ?>
            <?php foreach ($product_tag as $self) : ?>
                var name = <?= json_encode($self['name']) ?>;
                var sort = <?= json_encode($self['sort']) ?>;
                if (product_tag_name == name) {
                    alert('該項目已存在');
                    return;
                }
                if (parseInt(product_tag_sort) == parseInt(sort)) {
                    alert('該排序已存在');
                    return;
                }
            <?php endforeach; ?>
        <?php endif; ?>

        document.getElementById("product_tag").submit();
    }
</script>