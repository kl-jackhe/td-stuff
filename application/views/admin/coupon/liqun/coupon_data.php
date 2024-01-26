<?php echo $this->ajax_pagination_admin->create_links(); ?>
<?php $attributes = array('class' => 'coupon', 'id' => 'coupon'); ?>
<?php echo form_open('admin/coupon/multiple_action', $attributes); ?>
<div class="form-group">
    <div class="form-inline">
        <label><input type="checkbox" id="checkAll"> 全選</label>
        <select name="action" id="action" class="form-control">
            <option value="0">--動作--</option>
            <option value="delete">刪除</option>
        </select>
        <button type="subit" class="btn btn-primary">操作</button>
    </div>
</div>

<table class="table table-striped table-bordered table-hover" id="data-table">
    <thead>
        <tr class="info">
            <th class="text-center">#</th>
            <th class="text-center">優惠券名稱</th>
            <th class="text-center">上架日期</th>
            <th class="text-center">下架日期</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    <?php if (!empty($coupon)) : ?>
        <?php foreach ($coupon as $data) : ?>
            <tr>
                <td class="text-center"><input type="checkbox" name="coupon_id[]" value="<?php echo $data['id'] ?>"></td>
                <td class="text-center"><?php echo $data['name'] ?></td>
                <td class="text-center"><?php echo $data['distribute_at'] ?></td>
                <td class="text-center"><?php echo $data['discontinued_at'] ?></td>
                <td class="text-center">
                    <?php // if($data['coupon_id']!=1){ 
                    ?>
                    <a href="/admin/coupon/edit/<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> 編輯</a>
                    <a href="/admin/coupon/delete/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i> 刪除</a>
                    <?php // } 
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php echo form_close() ?>

<script>
    $(document).ready(function() {
        $("#checkAll").click(function() {
            $('#data-table input:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>