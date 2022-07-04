<?php echo $this->ajax_pagination->create_links(); ?>
<table class="table table-striped table-bordered table-hover" id="data-table">
  <thead>
    <tr class="info">
      <th class="text-center"><input type="checkbox"></th>
      <th>姓名</th>
      <th>E-mail</th>
      <th>生日月份</th>
      <th>認證</th>
      <th>操作</th>
    </tr>
  </thead>
  <?php if(!empty($auth)): foreach($auth as $data): ?>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td><?php echo $data['full_name'] ?></td>
      <td><?php echo $data['email'] ?></td>
      <td><?php echo substr($data['birthday'],5,2) ?> 月</td>
      <td><?php echo get_yes_no($data['active']) ?></td>
      <td>
        <a href="/admin/user/edit_user/<?php echo $data['user_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> 編輯</a>
        <a href="/admin/user/delete_user/<?php echo $data['user_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash-o"></i> 刪除</a>
      </td>
    </tr>
  <?php endforeach ?>
  <?php else: ?>
    <tr>
      <td colspan="15"><center>對不起, 沒有資料 !</center></td>
    </tr>
  <?php endif; ?>
</table>